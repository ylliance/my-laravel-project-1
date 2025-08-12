<?php

namespace App\Http\Controllers\Admin;

use App\Coupon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RedeemCouponController extends Controller
{
    public function index()
    {
        return view("admin.redeem.coupon");
    }

    public function getCoupon(Request $request)
    {
        $request->validate([
            'coupon_no' => 'bail|required|string',
            'member_id' => 'bail|required|integer',
        ]);

        $coupon = Coupon::where('coupon_no', $request->coupon_no)->where('member_id', $request->member_id)->first();

        if (empty($coupon)) {
            return response()->json([
                'success' => false,
                'msg' => 'no coupon'
            ]);
        }

        return response()->json([
            'success' => true,
            'coupon' => $coupon
        ]);
    }

    public function setCouponUsed(Request $request)
    {
        $request->validate([
            'coupon_id' => 'bail|required|integer',
        ]);

        $coupon = Coupon::find($request->coupon_id);
        if (empty($coupon)) {
            return response()->json([
                'success' => false,
                'msg' => 'no coupon'
            ]);
        }

        if ($coupon->status != 'valid') {
            return response()->json([
                'success' => false,
                'msg' => 'coupon is expired or used'
            ]);
        }
        $coupon->status = 'used';
        $coupon->used_at = Carbon::now()->format('Y-m-d H:i:s');
        $coupon->save();

        return response()->json([
            'success' => true,
            'msg' => ''
        ]);
    }
}
