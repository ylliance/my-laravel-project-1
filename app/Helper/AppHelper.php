<?php

namespace App\Helper;

use Illuminate\Http\Request;
use App\IpList;
use App\AdminSetting;
use App\Coupon;
use App\NoShowCoupon;

class AppHelper {

    public static function checkIP(Request $request)
    {
        $allowedIPItems = IpList::all();
        $allowedIPs = array();

        foreach ($allowedIPItems as $key => $value) {
            $allowedIPs[] = $value->address;
        }

        $ip = $request->ip();
        if(in_array($ip, $allowedIPs)) {
            return true;
        } else {
            return false;
        }
    }

    public static function checkCoupon($coupon_no) 
    {
        $setting_data = AdminSetting::get()->first();
        $coupon_rate = $setting_data->coupon_rate;
        
        $coupon_count = Coupon::where([['coupon_no', '=', $coupon_no], ['is_reverted', '=', 0]])->count();
        $coupon_used = $coupon_count > 0 ? true : false;

        $coupon_character = strtoupper(substr($coupon_no, 0, 1));
        $coupon_character2 = strtoupper(substr($coupon_no, 1, 1));
        $coupon_value = 0;
        $coupon_point = 0;
        $coupon_valid = false;

        switch ($coupon_character) {
            //--------------------------
            // HK Coupon
            case 'R':
                $coupon_value = 300;
                $coupon_valid = true;
                break;
            case 'S':
                $coupon_value = 500;
                $coupon_valid = true;
                break;
            case 'G':
                $coupon_value = 1000;
                $coupon_valid = true;
                break;
            //--------------------------
            // SZ
            case 'C':
                if ($coupon_character2 == 'S') {
                    $coupon_value = 500;
                    $coupon_valid = true;
                }
                break;
            default:
                $coupon_value = 0;
                break;
        }

        $coupon_point = $coupon_value * $coupon_rate;

        return array(
            'coupon_valid' => $coupon_valid,
            'coupon_used' => $coupon_used,
            'coupon_value' => $coupon_value,
            'coupon_point' => $coupon_point,
            'coupon_no' => $coupon_no,
            'coupon_rate' => $coupon_rate,
        );
    }

    public static function checkNoShowCoupon($coupon_number)
    {
        $coupon = NoShowCoupon::where('coupon_number', '=', $coupon_number)->first();

        if($coupon) {
            return array(
                'success' => false,
                'exists' => true,
                'msg' => 'Coupon is no-showed',
                'data' => $coupon,
            );
        } else {
            return array(
                'success' => true,
                'exists' => false,
                'msg' => 'Coupon was not used',
                'data' => null,
            );
        }
    }
}