<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Member;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MembersController extends Controller
{
    public function import(Request $request)
    {
        // Handle skip request (after duplicate modal)
        if ($request->query('skip')) {
            $pending = session('pending_import');
            if (!$pending) {
                return response()->json(['error' => 'No pending import found.'], 400);
            }
            // Insert non-duplicate members
            foreach ($pending['members'] as $member) {
                if (!in_array($member['username'], $pending['duplicates'])) {
                    Member::create($member);
                }
            }
            session()->forget('pending_import');
            return response()->json(['success' => true]);
        }

        // Initial upload
        if (!$request->hasFile('csv')) {
            return response()->json(['error' => 'No file uploaded.'], 400);
        }
        $file = $request->file('csv');
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle);
        $header = fgetcsv($handle);

        $members = [];
        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) !== count($header)) {
                // Optionally log or collect skipped rows for user feedback
                continue; // skip malformed row
            }
            $data = array_combine($header, $row);
            // Debug output for $data
            $members[] = [
                'username' => $data['username'] ?? '',
                'email' => $data['email'] ?? '',
                'phone_number' => $data['phone_number'] ?? '',
                'created_at' => $data['created_at'] ?? now(),
                'last_login' => $data['last_login'] ?? null,
            ];
        }
        fclose($handle);

        // Check for duplicates by username/email/phone_number
        $duplicates = [];
        foreach ($members as $member) {
            $exists = Member::where('username', $member['username'])
                ->orWhere('email', $member['email'])
                ->orWhere('phone_number', $member['phone_number'])
                ->exists();
            if ($exists) {
                $duplicates[] = $member['username'];
            }
        }

        if ($duplicates) {
            // Store pending import in session for skip
            session(['pending_import' => [
                'members' => $members,
                'duplicates' => $duplicates
            ]]);
            // Return duplicate info for modal
            $dupeDetails = array_filter($members, function($m) use ($duplicates) {
                return in_array($m['username'], $duplicates);
            });
            return response()->json(['duplicates' => array_values($dupeDetails)]);
        } else {
            // No duplicates, insert all
            foreach ($members as $member) {
                Member::create($member);
            }
            return response()->json(['success' => true]);
        }
    }
    public function export()
    {
        $members = Member::all(['id', 'username', 'phone_number', 'email', 'last_login']);
        $filename = 'members_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
        ];

        $callback = function() use ($members) {
            $handle = fopen('php://output', 'w');
            // CSV header
            fputcsv($handle, ['id', 'username', 'phone_number', 'email', 'last_login']);
            // CSV rows
            foreach ($members as $member) {
                fputcsv($handle, [
                    $member->id,
                    $member->username,
                    $member->phone_number,
                    $member->email,
                    $member->last_login,
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function index()
    {
        abort_if(Gate::denies('member_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $members = Member::paginate(10);
        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        abort_if(Gate::denies('member_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('member_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'username' => 'bail|required|max:255|min:4',
            'email' => 'bail|required|email|unique:members|max:255',
            'phone_number' => 'bail|required',
        ]);
        Member::create($request->all());
        return redirect()->route('members.index')->withStatus(__('Member is added successfully.'));
    }

    public function edit(Member $member)
    {
        abort_if(Gate::denies('member_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        abort_if(Gate::denies('member_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'username' => 'bail|required|max:255|min:4',
            'email' => 'bail|required|email|max:255|unique:members,email,' . $member->id,
            'phone_number' => 'bail|required',
        ]);
        $member->update($request->all());
        return redirect()->route('members.index')->withStatus(__('Member is updated successfully.'));
    }

    public function destroy(Member $member)
    {
        abort_if(Gate::denies('member_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $member->delete();
        return back()->withStatus(__('Member is deleted successfully.'));
    }

    // DataTables server-side search
    public function search(Request $request)
    {
        $search = $request->input('search.value');
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $membersQuery = Member::query();
        if ($search) {
            $membersQuery->where(function($q) use ($search) {
                $q->where('username', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone_number', 'like', "%$search%");
            });
        }

        $total = $membersQuery->count();
        $members = $membersQuery->with('stamps')
            ->orderBy('created_at', 'desc')
            ->skip($start)
            ->take($length)
            ->get();

        $data = [];
        foreach ($members as $i => $member) {
            $stampInfo = $member->stamps;
            $data[] = [
                'no' => $start + $i + 1,
                'username' => $member->username,
                'phone_number' => $member->phone_number,
                'email' => '<a href="mailto:' . e($member->email) . '">' . e($member->email) . '</a>',
                'created_at' => $member->created_at->format('Y-m-d H:i:s'),
                'last_login' => $member->last_login ? $member->last_login : '-',
                'stamps' => $stampInfo,
                'action' => view('admin.members.partials.actions', compact('member'))->render(),
            ];
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data,
        ]);
    }
}