<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Coupon;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

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
                if (!in_array($coupon['coupon_no'], $pending['duplicates'])) {
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
                'coupon_no' => $data['coupon_no'] ?? '',
                'shop' => $data['shop'] ?? '',
                'type' => $data['type'] ?? '',
                'value' => $data['value'] ?? '',
                'status' => $data['status'] ?? '',
                'used_at' => $data['used_at'] ?? null,
            ];
        }
        fclose($handle);

        // Check for duplicates by username/email/phone_number
        $duplicates = [];
        foreach ($coupons as $coupon) {
            $exists = Coupon::where('coupon_no', $coupon['coupon_no'])
                ->exists();
            if ($exists) {
                $duplicates[] = $coupon['coupon_no'];
            }
        }

        if ($duplicates) {
            // Store pending import in session for skip
            session([
                'pending_import' => [
                    'coupons' => $coupons,
                    'duplicates' => $duplicates
                ]
            ]);
            // Return duplicate info for modal
            $dupeDetails = array_filter($coupons, function ($m) use ($duplicates) {
                return in_array($m['coupon_no'], $duplicates);
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
        $coupons = Coupon::all(['coupon_no', 'shop', 'type', 'value', 'status', 'used_at']);
        $filename = 'coupons_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
        ];

        $callback = function () use ($coupons) {
            $handle = fopen('php://output', 'w');
            // CSV header
            fputcsv($handle, ['coupon_no', 'shop', 'type', 'value', 'status', 'used_at']);
            // CSV rows
            foreach ($coupons as $coupon) {
                fputcsv($handle, [
                    $coupon->coupon_no,
                    $coupon->shop,
                    $coupon->type,
                    $coupon->value,
                    $coupon->status,
                    $coupon->used_at,
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function index()
    {
        abort_if(Gate::denies('coupon_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $coupons = Coupon::paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        abort_if(Gate::denies('coupon_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('coupon_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'coupon_no' => 'bail|required|max:255|min:4',
            'shop' => 'bail|required',
            'type' => 'bail|required',
            'value' => 'bail|required',
        ]);
        Coupon::create($request->all());
        return redirect()->route('coupons.index')->withStatus(__('Coupon is added successfully.'));
    }

    public function edit(Coupon $coupon)
    {
        abort_if(Gate::denies('coupon_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        abort_if(Gate::denies('coupon_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'coupon_no' => 'bail|required|max:255|min:4',
            'shop' => 'bail|required',
            'type' => 'bail|required',
            'value' => 'bail|required',
        ]);
        $coupon->update($request->all());
        return redirect()->route('coupons.index')->withStatus(__('Coupon is updated successfully.'));
    }

    public function destroy(Coupon $coupon)
    {
        abort_if(Gate::denies('coupon_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
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
            $couponsQuery->where(function ($q) use ($search) {
                $q->where('coupon_no', 'like', "%$search%")
                    ->orWhere('shop', 'like', "%$search%");
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