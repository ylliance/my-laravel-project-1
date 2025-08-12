<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MemberStamps;
use Illuminate\Http\Request;
use App\Member;
use Illuminate\Support\Facades\Log;

class RedeemTreasureController extends Controller
{
    public function index()
    {
        return view("admin.redeem.treasure");
    }

    public function getUserStamp(Request $request)
    {
        $request->validate([
            'username' => 'bail|required',
            'email' => 'bail|required|email',
        ]);

        $member = Member::where('username', $request->username)->where('email', $request->email)->first();

        if (empty($member)) {
            return response()->json([
                'success' => false,
                'stamps' => [],
                'msg' => 'no member'
            ]);
        }

        return response()->json([
            'success' => true,
            'member_id' => $member->id, 
            'stamps' => $member->stamps
        ]);
    }

    public function setStampUsed(Request $request)
    {
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

        $notUsedStampCount = MemberStamps::where('member_id', $request->member_id)->count();
        
        if ($notUsedStampCount < 6) {
            return response()->json([
                'success' => false,
                'msg' => 'you need to collect 6 stamps'
            ]);
        }

        MemberStamps::update(['is_used' => true], ['member_id' => $request->member_id]);

        return response()->json([
            'success' => true,
            'stamps' => $member->stamps
        ]);
    }
}
