<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MemberStamps;
use App\RedeemStampHistory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Member;
use Auth;

class RedeemStampController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('redeem_treasure_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view("admin.redeem.stamp");
    }

    public function getUserStamp(Request $request)
    {
        abort_if(Gate::denies('redeem_treasure_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'uuid' => 'bail|required|string',
        ]);

        $member = Member::where('uuid', $request->uuid)->first();

        if (empty($member)) {
            return response()->json([
                'success' => false,
                'stamps' => [],
                'msg' => 'no member'
            ]);
        }

        return response()->json([
            'success' => true,
            'member' => $member, 
            'stamps' => $member->stamps
        ]);
    }

    public function setStampUsed(Request $request)
    {
        abort_if(Gate::denies('redeem_treasure_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'member_id' => 'bail|required|integer',
        ]);

        $member = Member::find($request->member_id);
        if (empty($member)) {
            return response()->json([
                'success' => false,
                'msg' => 'no member'
            ]);
        }

        $usedStampCount = MemberStamps::where('is_used', true)->count();
        
        if ($usedStampCount > 0) {
            return response()->json([
                'success' => false,
                'msg' => 'already redeem'
            ]);
        }

        $notUsedStampCount = MemberStamps::where('member_id', $request->member_id)->count();
        
        if ($notUsedStampCount < 6) {
            return response()->json([
                'success' => false,
                'msg' => 'need 6 stamps'
            ]);
        }

        MemberStamps::where('member_id', $request->member_id)->update(['is_used' => true]);

        $user = Auth::user();

        RedeemStampHistory::create([
            'user_id' => $user->id,
            'member_id' => $request->member_id,
            'comment' => 'Redeem Stamp comment test'
        ]);

        return response()->json([
            'success' => true,
            'stamps' => $member->stamps
        ]);
    }
}
