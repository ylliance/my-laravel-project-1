<?php

namespace App\Http\Controllers\Admin;

use App\Coupon;
use App\Http\Controllers\Controller;
use App\Member;
use App\RedeemCouponHistory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Auth;

class RedeemCouponController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('redeem_coupon_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view("admin.redeem.coupon");
    }

    public function getCoupon(Request $request)
    {
        abort_if(Gate::denies('redeem_coupon_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'coupon_no' => 'bail|required|string',
            'member_id' => 'bail|required|integer',
        ]);

        $member = Member::find($request->member_id);

        if (empty($member)) {
            return response()->json([
                'success' => false,
                'msg' => 'no member'
            ]);
        }

        $coupon = Coupon::where('coupon_no', $request->coupon_no)->where('member_id', $request->member_id)->first();

        if (empty($coupon)) {
            return response()->json([
                'success' => false,
                'msg' => 'no coupon'
            ]);
        }

        return response()->json([
            'success' => true,
            'coupon' => $coupon,
            'member' => $member
        ]);
    }

    public function setCouponUsed(Request $request)
    {
        abort_if(Gate::denies('redeem_coupon_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
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
                'msg' => 'expired or used'
            ]);
        }
        $coupon->status = 'used';
        $coupon->used_at = Carbon::now()->format('Y-m-d H:i:s');
        $coupon->save();

        $user = Auth::user();
        RedeemCouponHistory::create([
            'user_id' => $user->id,
            'member_id' => $coupon->member_id,
            'coupon_no' => $coupon->coupon_no,
            'comment' => 'Redeem Coupon comment test'
        ]);

        return response()->json([
            'success' => true,
            'msg' => ''
        ]);
    }
}
