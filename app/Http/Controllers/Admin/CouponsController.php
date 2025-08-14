<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Coupon;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CouponsController extends Controller
{
    public function import(Request $request)
    {
        // Handle skip request (after duplicate modal)
        if ($request->query('skip')) {
            $pending = session('pending_import');
            if (!$pending) {
                return response()->json(['error' => 'No pending import found.'], 400);
            }
            // Insert non-duplicate coupons
            foreach ($pending['coupons'] as $coupon) {
                if (!in_array($coupon['username'], $pending['duplicates'])) {
                    Coupon::create($coupon);
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

        $coupons = [];
        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) !== count($header)) {
                // Optionally log or collect skipped rows for user feedback
                continue; // skip malformed row
            }
            $data = array_combine($header, $row);
            // Debug output for $data
            $coupons[] = [
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
        foreach ($coupons as $coupon) {
            $exists = Coupon::where('username', $coupon['username'])
                ->orWhere('email', $coupon['email'])
                ->orWhere('phone_number', $coupon['phone_number'])
                ->exists();
            if ($exists) {
                $duplicates[] = $coupon['username'];
            }
        }

        if ($duplicates) {
            // Store pending import in session for skip
            session(['pending_import' => [
                'coupons' => $coupons,
                'duplicates' => $duplicates
            ]]);
            // Return duplicate info for modal
            $dupeDetails = array_filter($coupons, function($m) use ($duplicates) {
                return in_array($m['username'], $duplicates);
            });
            return response()->json(['duplicates' => array_values($dupeDetails)]);
        } else {
            // No duplicates, insert all
            foreach ($coupons as $coupon) {
                Coupon::create($coupon);
            }
            return response()->json(['success' => true]);
        }
    }
    public function export()
    {
        $coupons = Coupon::all(['id', 'username', 'phone_number', 'email', 'last_login']);
        $filename = 'members_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
        ];

        $callback = function() use ($coupons) {
            $handle = fopen('php://output', 'w');
            // CSV header
            fputcsv($handle, ['id', 'username', 'phone_number', 'email', 'last_login']);
            // CSV rows
            foreach ($coupons as $coupon) {
                fputcsv($handle, [
                    $coupon->id,
                    $coupon->username,
                    $coupon->phone_number,
                    $coupon->email,
                    $coupon->last_login,
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function index()
    {
        abort_if(Gate::denies('member_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $coupons = Coupon::paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        abort_if(Gate::denies('member_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('member_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'username' => 'bail|required|max:255|min:4',
            'email' => 'bail|required|email|unique:coupons|max:255',
            'phone_number' => 'bail|required',
        ]);
        Coupon::create($request->all());
        return redirect()->route('coupons.index')->withStatus(__('Coupon is added successfully.'));
    }

    public function edit(Coupon $coupon)
    {
        abort_if(Gate::denies('member_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        abort_if(Gate::denies('member_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'username' => 'bail|required|max:255|min:4',
            'email' => 'bail|required|email|max:255|unique:coupons,email,' . $coupon->id,
            'phone_number' => 'bail|required',
        ]);
        $coupon->update($request->all());
        return redirect()->route('coupons.index')->withStatus(__('Coupon is updated successfully.'));
    }

    public function destroy(Coupon $coupon)
    {
        abort_if(Gate::denies('member_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $coupon->delete();
        return back()->withStatus(__('Coupon is deleted successfully.'));
    }

    // DataTables server-side search
    public function search(Request $request)
    {
        $search = $request->input('search.value');
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $couponsQuery = Coupon::query();
        if ($search) {
            $couponsQuery->where(function($q) use ($search) {
                $q->where('username', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone_number', 'like', "%$search%");
            });
        }

        $total = $couponsQuery->count();
        $coupons = $couponsQuery->orderBy('created_at', 'desc')
            ->skip($start)
            ->take($length)
            ->get();

        $data = [];
        foreach ($coupons as $i => $coupon) {
            $data[] = [
                'no' => $start + $i + 1,
                'coupon_no' => $coupon->coupon_no,
                'shop' => $coupon->shop,
                'type' => $coupon->type,
                'value' => $coupon->value,
                'status' => $coupon->status,
                'created_at' => $coupon->created_at->format('Y-m-d H:i:s'),
                'used_at' => $coupon->used_at ? $coupon->used_at : '-',
                'action' => view('admin.coupons.partials.actions', compact('coupon'))->render(),
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