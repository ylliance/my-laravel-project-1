<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Coupon;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class UsedCouponController extends Controller
{
    //
    public function index()
    {
        abort_if(Gate::denies('redeem_coupon_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $coupons = Coupon::where('status', 'used')->paginate(10);
        return view('admin.used_coupon.index', compact('coupons'));
    }
    public function search(Request $request)
    {
        abort_if(Gate::denies('redeem_coupon_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $search = $request->input('search.value');
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $couponsQuery = Coupon::query();
        $couponsQuery->where('status', 'used');
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
                'member' => $coupon->member->username,
                'shop' => $coupon->shop,
                'type' => $coupon->type,
                'value' => $coupon->value,
                'used_at' => $coupon->used_at ? $coupon->used_at : '-',
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
