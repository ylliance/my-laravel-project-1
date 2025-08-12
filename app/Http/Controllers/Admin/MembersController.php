<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->has('start_date')) {
            $start_date = date('Y-m').'-01';
            $end_date = date('Y-m-d');
        } else {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
        }
        abort_if(Gate::denies('member_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        // $api_url = $this->get_nfc_api_endpoint();
        // $setting_data = AdminSetting::get()->first();
        // $minimum_coupons_per_deposit = env('MINIMUM_COUPONS_PER_DEPOSIT', 5);

        // $setting = array(
        //     'currency' => $setting_data->currency, 
        //     'currency_symbol' => $setting_data->currency_symbol, 
        //     'exchange_rate' => $setting_data->exchange_rate, 
        //     'coupon_topup_rate' => $setting_data->coupon_topup_rate
        // );

        return view('admin.members.index', compact('api_url', 'setting', 'start_date', 'end_date', 'minimum_coupons_per_deposit'));
    }

    public function getMemberDatatableData(Request $request)
    {
        $reqData = $request->all();

        if(!$request->has('start_date')) {
            $start_date = date('Y-m').'-01';
            $end_date = date('Y-m-d');
        } else {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
        }


        $draw = $request->draw;
        $row = $request->start;
        $rowperpage = $request->length;
        $columnIndex1 = $request->order[0]['column']; // Column index
        $columnName1 = $request->columns[$columnIndex1]['data']; // Column name
        $columnSortOrder1 = $request->order[0]['dir']; // asc or desc

        $limit = " limit " . $row . ",". $rowperpage;

        if($rowperpage == -1) {
            $limit = "";
        }

        if (isset($request->order[1]['column'])) {
            $columnIndex2 = $request->order[1]['column']; // Column index
            $columnName2 = $request->columns[$columnIndex2]['data']; // Column name
            $columnSortOrder2 = $request->order[1]['dir']; // asc or desc
        }

        $searchValue = $request->search['value']; // Search value

        ## Search
        $searchQuery = " ";
        if($searchValue != ''){
           $searchQuery = " WHERE name like '%".$searchValue."%' or 
                boss_id like'%".$searchValue."%' ";
        }
        ## Total number of records without filtering
        $totalRecords_raw_query = "select count(*) as count from members";
        $totalRecords = (DB::select(DB::raw($totalRecords_raw_query)))[0]->count;

        ## Total number of record with filtering
        $totalRecordwithFilter_raw_query = "select count(*) as count from members " . $searchQuery;
        $totalRecordwithFilter = (DB::select(DB::raw($totalRecordwithFilter_raw_query)))[0]->count;

        ## Fetch records
        if (isset($request->order[1]['column'])) {
            $empQuery = "select m.id as id, m.name, m.gender, m.boss_id, m.created_at ".
                "from members as m ".
                $searchQuery.
                " order by ".$columnName1." ".$columnSortOrder1." ,".$columnName2." ".$columnSortOrder2.$limit;
        } else {
            $empQuery = "select m.id as id, m.name, m.gender, m.boss_id, m.created_at ".
            "from members as m ".
            $searchQuery. 
            " order by ".$columnName1." ".$columnSortOrder1 . $limit;
        }

        $empRecords = DB::select(DB::raw($empQuery));
        $data = array();
        $user = auth()->user();

        foreach ($empRecords as $key => $row) {
            $gender = $row->gender == 1 ? 'Male' : ($row->gender == 2 ? 'Female' : "No define");
            $totalDeposit = $this->calculateTotalAmountByType('deposit', $row->id, $start_date, $end_date);
            $totalWithdraw = $this->calculateTotalAmountByType('withdraw', $row->id, $start_date, $end_date);
            $periodBalance = floatval(preg_replace("/[^-0-9\.]/","",$totalDeposit)) + floatval(preg_replace("/[^-0-9\.]/","",$totalWithdraw));
            $periodBalance = number_format( $periodBalance , 1);

            $action = "";
            $detail_item = "";
            if($user->can('member_show')) {
                $detail_item = "<li class='dropdown-item'>"
                    ."<a href='".route('members.show', $row->id)."' class='d-block'><i class='fas fa-eye text-success mr-1'></i> <span class='text-body'>Show Details<span></a></li>";
            }

            $edit_item = "";
            if($user->can('member_edit')) {
                $edit_item = "<li class='dropdown-item'><a href='".route('members.edit', $row->id)."' class='d-block'><i class='fas fa-pencil-alt text-info mr-1'></i> <span class='text-body'>Edit</span></a></li>";
            }

            $delete_item = "";
            if($user->can('member_delete')) {
                $delete_item = "<li class='dropdown-item'>"
                    ."<form action='".route('members.destroy', $row->id)."' method='post' >"
                    ."<input type='hidden' name='_token' value='".csrf_token()."' />"
                    ."<input type='hidden' name='_method' value='delete' />"
                    ."<a onclick='confirm(\"Are you sure you want to delete this?\") ? this.parentElement.submit() : \"\"' class='d-block'>"
                    ."<i class='mr-1 far fa-trash-alt text-danger mr-1'></i> <span class='text-body'>Delete</span>"
                    ."</a>"
                    ."</form>"
                    ."</li>";
            }

            $deposit_item = "";
            $deposit_coupon_item = "";
            if($user->can('wallet_deposit')) {
                $deposit_item = "<li class='dropdown-item'>"
                    ."<a href='javascript:;' data-id='".$row->id."' onclick='showDepositModal(this)' class='d-block'><i class='fa fa-money-bill text-info mr-1'></i> <span class='text-body'>Topup</span></a></li>";
                $deposit_coupon_item = "<li class='dropdown-item'>"
                    ."<a href='javascript:;' data-id='".$row->id."' onclick='showDepositCouponModal(this)' class='d-block'><i class='fa fa-money-bill text-warning mr-1'></i> <span class='text-body'>Coupon</span></a></li>";
            }

            $withdraw_item = "";
            if($user->can('wallet_withdraw')) {
                $withdraw_item = "<li class='dropdown-item'>"
                    ."<a href='javascript:;' data-id='".$row->id."' onclick='showWithDrawModal(this)' class='d-block'><i class='fa fa-money-bill text-danger mr-1'></i> <span class='text-body'>Withdraw</span></a></li>";
            }

            $bill_item = "";
            if($user->can('cafe_bills_refund_create')) {
                $bill_item = "<li class='dropdown-item'>"
                    ."<a href='javascript:;' data-id='".$row->id."' onclick='showBillModal(this)' class='d-block'><i class='fa fa-dollar-sign text-danger mr-1'>B</i> <span class='text-body'>Bill</span></a></li>";
            }

            $upfront_bill_item = "";
            if($user->can('upfront_bill_access')) {
                $upfront_bill_item = "<li class='dropdown-item'>"
                    ."<a href='javascript:;' data-id='".$row->id."' onclick='showUpfrontBillModal(this)' class='d-block'><i class='fa fa-dollar-sign text-danger mr-1'>D</i> <span class='text-body'>Upfront</span></a></li>";
            }

            $action = "<div class='dropdown'>" .
                        "<button class='btn btn-outline-primary btn-sm dropdown-toggle' type='button' data-toggle='dropdown' aria-expanded='false'>Action</button>" .
                        "<div class='dropdown-menu'>".
                        $detail_item .
                        $edit_item . 
                        //$delete_item.
                        $deposit_item.
                        $deposit_coupon_item.
                        $withdraw_item.
                        $bill_item.
                        $upfront_bill_item.
                        "</div>".
                        "</div>";
            $member = Member::find($row->id);
            $data[] = array( 
                'id' => $row->id,
                'name' => $row->name,
                'gender' => $gender,
                'boss_id' => $row->boss_id,
                'periodBalanceFloat' => $periodBalance,
                'balanceFloat' => number_format($member->balanceFloat, 1),
                'totalDeposit' => $totalDeposit,
                'totalWithdraw' => $totalWithdraw,
                'created_at' => $row->created_at,
                'action' => $action,
            );
        }
        ## Response
        $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $data
        );
        return response()->json($response, 200);
    }

    public function exportData(Request $request)
    {
        if($request->has('startDate', 'endDate')) {
            $startDate = $request->startDate;
            $endDate = $request->endDate;
        } else {
            $startDate = date('Y-m-d');
            $endDate = date('Y-m-d');
        }

        $response = array('msg' => '', 'success'=>false);
        $status = 200;

        $query = "SELECT id, name, gender, boss_id, created_at FROM members ORDER BY created_at DESC";
        $empRecords = DB::select(DB::raw($query));
        try {

            $export_data = array();
            $export_data[] = array(
                'NO',
                'NAME',
                'BOSS_ID',
                'GENDER',
                'TOP UP (PT)',
                'WITHDRAW (PT)',
                'PERIOD BALANCE (PT)',
                'TOTAL BALANCE (PT)',
                'REGISTERED DATE',
            );
            foreach ($empRecords as $key => $row) {
                $gender = $row->gender == 1 ? 'Male' : ($row->gender == 2 ? 'Female' : "No define");
                $totalDeposit = $this->calculateTotalAmountByType('deposit', $row->id, $startDate, $endDate, false);
                $totalWithdraw = $this->calculateTotalAmountByType('withdraw', $row->id, $startDate, $endDate, false);
                $periodBalance = floatval(preg_replace("/[^-0-9\.]/","",$totalDeposit)) + floatval(preg_replace("/[^-0-9\.]/","",$totalWithdraw));
                $periodBalance = $periodBalance;
                $member = Member::find($row->id);

                $export_data[] = array(
                    $key + 1,
                    $row->name,
                    $row->boss_id,
                    $gender,
                    $totalDeposit,
                    $totalWithdraw,
                    $periodBalance,
                    $member->balanceFloat,
                    $row->created_at
                );
            }

            $response['data'] = $export_data;
            $response['success'] = true;
        } catch(\Exception $e) {
            $response['msg'] = $e->getMessage();
            $status = 500;
        }
        return response()->json($response, $status);
    }

    public function create()
    {
        abort_if(Gate::denies('member_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|max:64|min:2',
            'boss_id' => 'bail|required|unique:members',
            'gender' => 'bail|required',
            'password' => 'bail|required',
        ]);
        $data = $request->all();
        $member = Member::create($data);

        return redirect()->route('members.index')->withStatus(__('Member is added successfully.'));
    }

    public function edit(Member $member)
    {
        abort_if(Gate::denies('member_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'bail|required|max:64|min:2',
        ]);
        $member->update($request->all());

        return redirect()->route('members.index')->withStatus(__('Member is updated successfully.'));
    }

    public function updatePassword(Request $request)
    {
        $rules = [
            'id' => 'bail|required|exists:members',
            'password' => 'bail|required',
        ];

        $response = array('msg' => '', 'success'=>false);
        $status = 200;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $response['msg'] = $validator->messages();
            $status = 400;
        } else {
            $member = Member::find($request->input('id'));
            $data['password'] = $request->input('password');
            $member->update($data);

            $response['success'] = true;
            $response['msg'] = 'Password is changed successfully.';
        }

        return response()->json($response, $status);
        
    }

    public function show(Member $member)
    {
        abort_if(Gate::denies('member_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $setting_data = AdminSetting::get()->first();
        $setting = array('currency' => $setting_data->currency, 'currency_symbol' => $setting_data->currency_symbol, 'exchange_rate' => $setting_data->exchange_rate);
        return view('admin.members.show', compact('member', 'setting'));
    }

    public function destroy(Member $member)
    {
        abort_if(Gate::denies('member_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $member->delete();

        return back()->withStatus(__('Member is deleted successfully.'));
    }

    public function getMemberById(Request $request)
    {
        $rules = [
            'id' => 'bail|required|exists:members,id',
        ];

        $response = array('msg' => '', 'success'=>false);
        $status = 200;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $response['msg'] = $validator->messages();
            $status = 400;
        } else {
            try {
                $reqData = $request->all();
                $member = Member::find($reqData['id']);
                
                // check member status from ic-member site
                $member_info_response = $this->getBossIdStatusFromIcMember($member->boss_id);
                if(isset($member_info_response['success']) && $member_info_response['success']) {
                    $statusCode = $member_info_response['data']['statusCode'];

                    if($member_info_response['data']['statusCode'] == 0) {
                        $response['msg'] = 'Member is currently inactive.';
                        $status = 400;
                        return response()->json($response, $status);
                    }

                    if($member_info_response['data']['statusCode'] == 2) {
                        $response['msg'] = 'Member is currently expired.';
                        $status = 400;
                        return response()->json($response, $status);
                    }

                    $response['data'] = array(
                        'boss_id' => $member->boss_id,
                        'name' => $member->name,
                        'gender' => $member->gender,
                        'balance' => $member->balanceFloat,
                        'id' => $member->id,
                        'card_uid' => $member_info_response['data']['card_uid'],
                    );
                    
                    $response['success'] = true;
                } else {
                    $response['msg'] = 'There is no member record in the ic-member database.';
                    $response['success'] = false;
                    $status = 400;
                }
                
            } catch(\Exception $e) {
                $response['msg'] = $e->getMessage();
                $status = 500;
            }
        }
        return response()->json($response, $status);
    }

    public function getLastTransactionByMember(Request $request)
    {
        $rules = [
            'id' => 'bail|required|exists:members,id',
        ];

        $response = array('msg' => '', 'success'=>false);
        $status = 200;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $response['msg'] = $validator->messages();
            $status = 400;
        } else {
            try {
                $reqData = $request->all();
                $member = Member::find($reqData['id']);
                if($request->has('transaction_id')) {
                    $transaction = $member->transactions()->where('id', '=', $reqData['transaction_id'])->first();
                } else {
                    $transaction = $member->transactions()->orderBy('created_at', 'desc')->first();
                }
                
                $transaction_type_label = $transaction->type == 'deposit' ? 'IC 咭充值' : $transaction->type;
                $transaction_receipt_no = "C".str_pad($transaction->id, 11, '0', STR_PAD_LEFT);

                if(isset($transaction->meta['cs_remark'])) {
                    $transaction_cs_remark = $transaction->meta['cs_remark'];
                } else {
                    $transaction_cs_remark = '';
                }

                if(isset($transaction->meta['card_type'])) {
                    $card_type = $transaction->meta['card_type'];
                } else {
                    $card_type = App\Payment::CARD_TYPE_IC_CARD;
                }

                if(isset($transaction->meta['special_offer'])) {
                    $special_offer = SpecialOffer::where('transaction_id', $transaction->id)->first();                    
                } else {
                    $special_offer = null;
                }

                $coupons = [];
                if($transaction->type == 'deposit' && isset($transaction->meta['coupons'])) {
                    $coupon_str = $transaction->meta['coupons'];
                    $coupon_no_arr = explode(',', $coupon_str);

                    $coupons = Coupon::whereIn('coupon_no', $coupon_no_arr)->get();
                }

                $digital_payment = null;
                if($transaction->type == 'deposit' && isset($transaction->meta['payment_no'])) {
                    $payment_no = $transaction->meta['payment_no'];

                    $digital_payment = Payment::where('payment_no', $payment_no)->first();
                }

                $response['data'] = array(
                    'boss_id' => $member->boss_id,
                    'name' => $member->name,
                    'balance' => $member->balanceFloat,
                    'id' => $member->id,
                    'transaction_type' => $transaction->type,
                    'transaction_type_label' => $transaction_type_label,
                    'transaction_receipt_no' => $transaction_receipt_no,
                    'transaction_meta' => $transaction->meta,
                    'transaction_amount' => $transaction->amount / 100,
                    'transaction_created_at' => $transaction->created_at,
                    'transaction_remark' => $transaction_cs_remark,
                    'coupons' => $coupons,
                    'digital_payment' => $digital_payment,
                    'special_offer' => $special_offer,
                    'card_type' => $card_type,
                );
                
                $response['success'] = true;
            } catch(\Exception $e) {
                $response['msg'] = $e->getMessage();
                $status = 500;
            }
        }
        return response()->json($response, $status);
    }

    public function sync(Request $request)
    {
        $member_data = $request->input('members');
        $response = array('msg' => '', 'success'=>false);
        $status = 200;

        try {
            $imported = array();
            $count = 0;
            foreach ($member_data as $key => $item) {
                if(Member::where('boss_id', '=', $item['boss_id'])->count() == 0) {
                    $count++;
                    $member = Member::create($item);
                    $imported[] = $member->id;
                }
            }
            $response['data'] = array('imported' => $imported, 'count' => $count);
            $response['success'] = true;
        } catch(\Exception $e) {
            $response['msg'] = $e->getMessage();
            $status = 500;
        }
        
        return response()->json($response, $status);
    }

    public function resetPasswords(Request $request)
    {
        $member_data = $request->input('members');
        $response = array('msg' => '', 'success'=>false);
        $status = 200;

        try {
            $count = 0;
            foreach ($member_data as $key => $item) {
                $member = Member::where('boss_id', '=', $item['boss_id'])->first();
                if($member) {
                    $count++;
                    $member->update(['password' => $item['password']]);
                }
            }
            $response['data'] = array('count' => $count);
            $response['success'] = true;
        } catch(\Exception $e) {
            $response['msg'] = $e->getMessage();
            $status = 500;
        }
        
        return response()->json($response, $status);
    }

    public function deposit(Request $request)
    {
        abort_if(Gate::denies('wallet_deposit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'id' => 'bail|required|exists:members,id',
            'type' => 'bail|required',
            'amount' => 'bail|required',
        ]);

        $reqData = $request->all();
        // check payment_no
        $allCouponValid = true;
        $payment_no = $reqData['payment_no'];
        $type = $reqData['type'];

        if($type != 'cash') {
            // check if payment_no is not existing
            $payment_old = Payment::where('payment_no', $payment_no)->first();
            if($payment_old) {
                return redirect()->route('members.index')->withError(__('Pyament No is existing already in our records.'));
            }
        }
        
        $member = Member::findOrFail($reqData['id']);

        $staff = auth()->user();

        $setting_data = AdminSetting::get()->first();

        $exchange_rate = $setting_data->exchange_rate;

        $special_offer = floatval($reqData['special_offer']);
        $deposit_amount = floatval($reqData['amount']) * floatval($exchange_rate) + $special_offer;

        if($type == 'cash') {
            $meta = array(
                'staff_id' => $staff->id,
                'staff_name' => $staff->name,
                'remark' => 'CS Staff topup',
                'exchange_rate' => $exchange_rate,
                'currency' => $setting_data->currency,
                'currency_symbol' => $setting_data->currency_symbol,
                'currency_amount' => $reqData['amount'],
                'cs_remark' => $reqData['remark'],
                'card_type' => $reqData['card_type'] ?? App\Payment::CARD_TYPE_IC_CARD, // default to IC Card
            );
            if($special_offer > 0) {
                $meta['special_offer'] = $special_offer;
            }
            $member->depositFloat($deposit_amount, $meta);

            if($special_offer > 0) {
                $transaction = $member->transactions()->whereNull('deleted_at')->orderBy('created_at', 'desc')->first();
                $specialOfferData = array(
                    'transaction_no' => ('S' . str_pad($transaction->id, 11, '0', STR_PAD_LEFT)),
                    'transaction_id' => $transaction->id,
                    'member_id' => $member->id,
                    'staff_id' => $staff->id,
                    'amount' => $special_offer,
                );
                SpecialOffer::create($specialOfferData);
            }
        } else {
            $meta = array(
                'staff_id' => $staff->id,
                'staff_name' => $staff->name,
                'remark' => 'CS digital payment topup',
                'exchange_rate' => $exchange_rate,
                'currency' => $setting_data->currency,
                'currency_symbol' => $setting_data->currency_symbol,
                'currency_amount' => $reqData['amount'],
                'cs_remark' => $reqData['remark'],
                'type' => $type,
                'payment_no' => $payment_no,
                'card_type' => $reqData['card_type'] ?? App\Payment::CARD_TYPE_IC_CARD, // default to IC Card
            );
            if($special_offer > 0) {
                $meta['special_offer'] = $special_offer;
            }
            $member->depositFloat($deposit_amount, $meta);

            // get transaction id of digital payment deposit
            $transaction = $member->transactions()->whereNull('deleted_at')->orderBy('created_at', 'desc')->first();
            $transaction_id = $transaction->id;
            $transaction_no = 'C' . str_pad($transaction_id, 11, '0', STR_PAD_LEFT);
                
            $payment_data = array(
                'transaction_no' => $transaction_no,
                'transaction_id' => $transaction_id,
                'member_id' => $member->id,
                'user_id' => $staff->id,
                'type' => $type,
                'payment_no' => $payment_no,
                'payment_value' => $reqData['amount'],
                'payment_point' => $reqData['amount'] * $exchange_rate,
                'payment_rate' => $exchange_rate,
                'is_reverted' => false,
            );
            Payment::create($payment_data);

            if($special_offer > 0) {
                $specialOfferData = array(
                    'transaction_no' => ('S' . str_pad($transaction->id, 11, '0', STR_PAD_LEFT)),
                    'transaction_id' => $transaction->id,
                    'member_id' => $member->id,
                    'staff_id' => $staff->id,
                    'amount' => $special_offer,
                );
                SpecialOffer::create($specialOfferData);
            }
        }

        return redirect()->route('members.index')->withStatus(__('Processed the depositing successfully'))->withValue($member->id);
    }

    public function depositCoupon(Request $request)
    {
        abort_if(Gate::denies('wallet_deposit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'id' => 'bail|required|exists:members,id',
            'coupon_no' => 'bail|required'
        ]);

        $reqData = $request->all();
        $special_offer = floatval($reqData['special_offer']);
        // check coupons
        $allCouponValid = true;
        $coupon_no = $reqData['coupon_no'];
        $coupon_no = array_filter($coupon_no, fn($value) => !is_null($value));

        $coupon_amount = 0;
        $coupon_data_arr = [];
        foreach ($coupon_no as $key => $coupon) {
            // currently, duplication check is performed in UI side
            // in the future, we will add this check in backend side
            $coupon_data = AppHelper::checkCoupon($coupon);
            $coupon_data_arr[] = $coupon_data;
            if($coupon_data && $coupon_data['coupon_valid'] && !$coupon_data['coupon_used']) {
                $coupon_amount += $coupon_data['coupon_value'];
            } else {
                $allCouponValid = false;
            }
        }

        // coupon check should be performed in UI side first
        if(!$allCouponValid) {
            return redirect()->route('members.index')->withError(__('Coupon Invalid'));
        }
        
        $card_type = $reqData['card_type'] ?? App\Payment::CARD_TYPE_IC_CARD; // default to IC Card

        $member = Member::findOrFail($reqData['id']);

        $staff = auth()->user();

        $setting_data = AdminSetting::get()->first();

        $coupon_topup_rate = $setting_data->coupon_topup_rate;

        $deposit_amount = floatval($coupon_amount) * floatval($coupon_topup_rate) + $special_offer;

        $meta = array(
            'staff_id' => $staff->id,
            'staff_name' => $staff->name,
            'remark' => 'CS coupon topup',
            'exchange_rate' => $coupon_topup_rate,
            'currency' => 'coupon',
            'currency_symbol' => 'coupon',
            'currency_amount' => $coupon_amount,
            'cs_remark' => $reqData['remark'],
            'type' => 'coupon',
            'coupons' => implode(',', $coupon_no),
            'card_type' => $card_type, // default to IC Card
        );
        if($special_offer > 0) {
            $meta['special_offer'] = $special_offer;
        }
        $member->depositFloat($deposit_amount, $meta);

        // get transaction id of coupon deposit
        $transaction = $member->transactions()->whereNull('deleted_at')->orderBy('created_at', 'desc')->first();
        $transaction_id = $transaction->id;
        $transaction_no = 'C' . str_pad($transaction_id, 11, '0', STR_PAD_LEFT);
        foreach ($coupon_data_arr as $key => $coupon_data) {
            
            $coupon_store_data = array(
                'bill_no' => $transaction_no,
                'bill_id' => $transaction_id,
                'member_id' => $member->id,
                'coupon_no' => $coupon_data['coupon_no'],
                'coupon_value' => $coupon_data['coupon_value'],
                'coupon_point' => $coupon_data['coupon_value'] * $coupon_topup_rate,
                'coupon_real_point' => $coupon_data['coupon_value'] * $coupon_topup_rate,
                'coupon_rate' => $coupon_topup_rate,
                'is_reverted' => false,
                'staff_id' => $staff->id,
                'type' => 'coupon topup',
                'transaction_id' => $transaction_id,
            );
            Coupon::create($coupon_store_data);
        }

        if($special_offer > 0) {
            $transaction = $member->transactions()->whereNull('deleted_at')->orderBy('created_at', 'desc')->first();
            $specialOfferData = array(
                'transaction_no' => ('S' . str_pad($transaction->id, 11, '0', STR_PAD_LEFT)),
                'transaction_id' => $transaction->id,
                'member_id' => $member->id,
                'staff_id' => $staff->id,
                'amount' => $special_offer,
            );
            SpecialOffer::create($specialOfferData);
        }

        return redirect()->route('members.index')->withStatus(__('Processed the coupon depositing successfully'))->withValue($member->id);
    }

    public function withdraw(Request $request)
    {
        abort_if(Gate::denies('wallet_withdraw'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'id' => 'bail|required|exists:members,id',
            'amount' => 'bail|required'
        ]);
        $reqData = $request->all();
        $member = Member::findOrFail($reqData['id']);
        $staff = auth()->user();
        try {
            $member->withdrawFloat($reqData['amount'], array('staff_id' => $staff->id, 'staff_name' => $staff->name, 'remark' => 'CS Staff deduct'));
            return redirect()->route('members.index')->withStatus(__('Processed the withdrawing successfully'));
        } catch(\Exception $e) {
            $t = $e->getMessage();
            return redirect()->route('members.index')->withError($t);
        }
    }

    public function createBill(Request $request)
    {
        $rules = [
            'card_uid' => 'bail|required',
            'member_id' => 'bail|required|exists:members,id',
            'amount' => 'bail|required',
            'ppl' => 'bail|required',
            'bill_no' => 'bail|required',
        ];

        $response = array('msg' => '', 'success'=>false);
        $status = 200;
        $validator = Validator::make($request->all(), $rules);

        $new_bill_no = $request->bill_no;
        $bill = Bill::where('bill_no', '=', $new_bill_no)->first();
        if($bill) {
            $response['msg'] = 'Bill Number is used!';
            $status = 400;            
        } else {
            if ($validator->fails()) {
                $response['msg'] = $validator->messages();
                $status = 400;
            } else {
                try {
                    $user = auth()->user();
                    $reqData = $request->all();
                    //$reqData['bill_no'] = $this->generateBillNo();
                    $reqData['bill_no'] = $new_bill_no;
                    $reqData['status'] = 1;
                    $reqData['table_no'] = 'Fake_Table';
                    $reqData['cafe_staff'] = 'CS';
                    $reqData['cs_id'] = $user->id;
                    $reqData['end_time'] = Carbon::now();
                    $bill = Bill::create($reqData);
                    $response['data'] = $bill;
                    $response['success'] = true;
                } catch(\Exception $e) {
                    $response['msg'] = $e->getMessage();
                    $status = 500;
                }
            }
        }
        return response()->json($response, $status);
    }
    
    private function generateBillNo()
    {
        $date = date('Y-m-d');
        $datePrefix = "B".date('ymd');
        $lastBill = Bill::latest('id')->first();
        if($lastBill) {
            $referenceNo = $lastBill->bill_no;
            $parts = explode('-', $referenceNo);
            if($parts[0] == $datePrefix) {
                $increment_back = ((int)$parts[1]) + 1;
            } else {
                $increment_back = 1;
            }
        } else {
            $increment_back = 1;
        }

        return $datePrefix . '-' . str_pad(strval($increment_back), 4, '0', STR_PAD_LEFT);
    }

    public function checkMemberBalance(Request $request)
    {
        $rules = [
            'id' => 'bail|required|exists:members',
        ];

        $response = array('msg' => '', 'success'=>false);
        $status = 200;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $response['msg'] = $validator->messages();
            $status = 400;
        } else {
            try {
                $reqData = $request->all();
                $member = Member::find($request->input('id'));
                
                $response['data'] = array(
                    'balance' => $member->balanceFloat,
                );
                
                $response['success'] = true;
            } catch(\Exception $e) {
                $response['msg'] = $e->getMessage();
                $status = 500;
            }
        }
        return response()->json($response, $status);
    }

    public function getMemberBybossid(Request $request)
    {
        $rules = [
            'boss_id' => 'bail|required|exists:members,boss_id',
            'name' => 'bail|required'
        ];

        $response = array('msg' => '', 'success'=>false);
        $status = 200;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $response['msg'] = $validator->messages();
            $status = 400;
        } else {
            try {
                $reqData = $request->all();
                $member = Member::where('boss_id', '=', $reqData['boss_id'])->first();

                if($reqData['name'] != $member->name) {
                    $member->update(['name' => $reqData['name']]);
                    $response['msg'] = 'Member name is updated successfully.';
                    $response['name_updated'] = true;
                } else {
                    $response['name_updated'] = false;
                }
                
                $response['data'] = array(
                    'boss_id' => $member->boss_id,
                    'name' => $reqData['name'],
                    'gender' => $member->gender,
                    'balance' => $member->balanceFloat,
                    'id' => $member->id,
                );
                
                $response['success'] = true;

            } catch(\Exception $e) {
                $response['msg'] = $e->getMessage();
                $status = 500;
            }
        }
        return response()->json($response, $status);
    }

    public function api_insertNewMember(Request $request)
    {
        if(!AppHelper::checkIP($request)) {
            return response()->json(array('msg' => 'Not allowed ('. $request->ip() . ') to access this API'), 403);
        }

        $response = array('msg' => '', 'success' => false);
        $status = 200;
        try {
            $data = $request->all();
            // set default password is "password"
            $member = Member::create($data);
            $response['success'] = true;
        } catch(\Exception $e) {
            $response['msg'] = $e->getMessage();
            $status = 500;
        }
    
        return response()->json($response, $status);
    }

    public function api_updateMember(Request $request)
    {
        if(!AppHelper::checkIP($request)) {
            return response()->json(array('msg' => 'Not allowed ('. $request->ip() . ') to access this API'), 403);
        }

        $rules = [
            'name' => 'bail|required',
            'boss_id' => 'bail|required|exists:members:boss_id',
            'gender' => 'bail|required'
        ];

        $response = array('msg' => '', 'success'=>false);
        $status = 200;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $response['msg'] = $validator->messages();
            $status = 400;
        } else {
            try {
                $data = $request->all();
                $member = Member::where('boss_id', '=', $data['boss_id'])->first();
                $member->update($data);
                $response['success'] = true;
            } catch(\Exception $e) {
                $response['msg'] = $e->getMessage();
                $status = 500;
            }
        }
        return response()->json($response, $status);
    }

    public function api_deleteMember(Request $request)
    {
        if(!AppHelper::checkIP($request)) {
            return response()->json(array('msg' => 'Not allowed ('. $request->ip() . ') to access this API'), 403);
        }
        $rules = [
            'boss_id' => 'bail|required|exists:members:boss_id',
            'id' => 'bail|required|exists:members,id',
        ];

        $response = array('msg' => '', 'success'=>false);
        $status = 200;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $response['msg'] = $validator->messages();
            $status = 400;
        } else {
            try {
                $data = $request->all();
                $member = Member::where('boss_id', '=', $data['boss_id'])->first();
                $member->delete();
                $response['success'] = true;
            } catch(\Exception $e) {
                $response['msg'] = $e->getMessage();
                $status = 500;
            }
        }
        return response()->json($response, $status);
    }

    // kiosk Member Search APIs
    public function api_kioskSearch(Request $request)
    {
        if(!AppHelper::checkIP($request)) {
            return response()->json(array('msg' => 'Not allowed ('. $request->ip() . ') to access this API'), 403);
        }

        $response = array('msg' => '', 'success' => false);
        $status = 200;
        try {
            $data = $request->all();
            $member_info_response = $this->getMemberInfoFromIcMember($data['card_id']);
            if(isset($member_info_response['success']) && $member_info_response['success']) {
                $member_info_data = $member_info_response['data'];
                $boss_id = $member_info_data['boss_id'];

                if ( ($member_info_data['expire_at'] == null) || !isset($member_info_data['expire_at']) || ($member_info_data['expire_at'] == "")) {
                    $expireDate=date('Y-m-d', strtotime('+1 year'));
                } else {
                    $expireDate=$member_info_data['expire_at'];
                }

                
                $response['success'] = true;

                $member = Member::where('boss_id', '=', $boss_id)->first();
                $memberData = array(
                    'number' => $data['card_id'], 
                    'level' => 1, 
                    'location' => '7F',
                    'status' => $member_info_data['status'],
                    'expire_at' => $expireDate,
                    'statusCode' => $member_info_data['statusCode'],
                );
                if($member) {
                    $transactionHistory = $this->getWalletBusinessDataForKiosk($member->id);
                    $memberData['name'] = $member->name;
                    $memberData['balance'] = number_format(round($member->balanceFloat,1), 1);
                    $response['success'] = true;
                    $response['data'] = array('member' => $memberData, 'history' => $transactionHistory);
                    $response['msg'] = "Search Member Success.";
                }
            } else {
                $response['success'] = false;
                $response['msg'] = 'Member Not Found';
            }
        } catch(\Exception $e) {
            $response['msg'] = $e->getMessage();
            $status = 500;
        }
        return response()->json($response, $status);
    }

    private function getWalletBusinessDataForKiosk($id)
    {
        $empQuery = "SELECT t.type, t.amount / 100 AS amount, t.meta, t.uuid, t.created_at ".
        "FROM transactions AS t " .
        "WHERE t.payable_id = $id AND t.deleted_at IS NULL " .
        "order by t.created_at DESC limit 5 ";

        $empRecords = DB::select(DB::raw($empQuery));
        $data = array();

        foreach ($empRecords as $key => $row) {

            $meta = json_decode($row->meta);

            $sub_type = "";
            if(property_exists($meta, 'type')) {
                $sub_type = $meta->type;
            }

            if($row->type == 'deposit') {
                if($sub_type == 'refund') {
                    $sub_type = 'refund';
                } else {
                    $sub_type = 'topup';
                }
            } else {
                if($sub_type == 'bill') {
                    $sub_type = 'bill';
                } else {
                    $sub_type = 'CS Withdraw';
                }
            }

            $data[] = array( 
                'type' => $row->type,
                'amount' => number_format(round($row->amount, 1),1),
                'created_at' => $row->created_at,
                'sub_type' => $sub_type,
            );
           
        }
       
        return $data;
    }


    // eRun APIs
    public function api_searchMember(Request $request)
    {
        if(!AppHelper::checkIP($request)) {
            return response()->json(array('msg' => 'Not allowed ('. $request->ip() . ') to access this API'), 403);
        }

        $response = array('msg' => '', 'success' => false);
        $status = 200;
        try {
            $data = $request->all();
            $member_info_response = $this->getMemberInfoFromIcMember($data['card_id']);
            if(isset($member_info_response['success']) && $member_info_response['success']) {
                $member_info_data = $member_info_response['data'];
                $boss_id = $member_info_data['boss_id'];
                
                $response['success'] = true;

                $member = Member::where('boss_id', '=', $boss_id)->first();
                $memberData = array(
                    'number' => $data['card_id'], 
                    'level' => 1, 
                    'location' => '7F',
                    'status' => $member_info_data['status'],
                    'expired' => $member_info_data['expired'],
                    'statusCode' => $member_info_data['statusCode'],
                );
                if($member) {
                    $memberData['name'] = $member->name;
                    $memberData['balance'] = $member->balanceFloat;
                    $response['success'] = true;
                    $response['data'] = array('member' => $memberData);
                    $response['msg'] = "Search Member Success.";

                    // TODO:: check uuid and bill_no, if bill_no exists, then update the member in bill record
                    if(isset($data['bill_id'])) {
                        $bill = Bill::where('bill_no', '=', $data['bill_id'])->first();
                        if($bill) {
                            $bill->update(array('card_uid' => $data['card_id'], 'member_id' => $member->id));
                        }
                    }
                }
            } else {
                $response['success'] = false;
                $response['msg'] = 'Member Not Found';
            }
        } catch(\Exception $e) {
            $response['msg'] = $e->getMessage();
            $status = 500;
        }
        return response()->json($response, $status);
    }

    public function api_createBill(Request $request)
    {
        $response = array('msg' => '', 'success' => false);
        $status = 200;
        $member_data = null;
        $bill_data = null;

        $rules = [
            'bill_id' => 'bail|required|unique:bills,bill_no',
            'table' => 'bail|required',
            'ppl' => 'bail|required',
            'username' => 'bail|required',
        ];

        $response = array('msg' => '', 'success'=>false);
        $status = 200;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $response['msg'] = $validator->messages();
            $status = 400;
            return response()->json($response, $status);
        }
        try {
            $data = $request->all();
            $bill_data = array();

            $eBill = Bill::where('bill_no', '=', $data['bill_id'])->first();
            
            $bill_data['bill_no'] = $data['bill_id'];
            $bill_data['table_no'] = $data['table'];
            $bill_data['ppl'] = $data['ppl'];
            $bill_data['cafe_staff'] = $data['username'];
            $bill_data['status'] = 0;
            $bill_data['amount'] = 0;
            if(isset($data['card_id'])) {
                $member_info_response = $this->getMemberInfoFromIcMember($data['card_id']);
                $member_data = null;
                if(isset($member_info_response['success']) && $member_info_response['success']) {
                    $boss_id = $member_info_response['data']['boss_id'];
    
                    $member = Member::where('boss_id', '=', $boss_id)->first();
                    if($member) {
                        $bill_data['card_uid'] = $data['card_id'];
                        $bill_data['member_id'] = $member->id;
                        $member_data = array(
                            'number' => $data['card_id'],
                            'name'  => $member->name,
                            'level' => 1,
                            'location' => '7F',
                            'balance' => $member->balanceFloat,
                            'status' => $member_info_response['data']['status'],
                            'expired' => $member_info_response['data']['expired'],
                            'statusCode' => $member_info_response['data']['statusCode'],
                        );
                    }
                }
            }
            $bill = Bill::create($bill_data);
            $bill_info = array(
                'bill_id' => $data['bill_id'],
                'table' => $data['table'],
                'ppl' => $data['ppl'],
                'statusStr' => 'Pending',
                'status' => 0,
            );
            
            $response['data'] = array('member' => $member_data, 'bill_info' => $bill_info);
            $status = 200;
            $response['success'] = true;
            $response['msg'] = 'Create order success';

        } catch(\Exception $e) {
            $response['msg'] = $e->getMessage();
            $status = 500;
        }
    
        return response()->json($response, $status);
    }



    private function get_nfc_api_endpoint()
    {
        return env('NFC_MEMBER_API_URL', 'http://local.rex.nfc-membership.com/api/admin');
    }

    private function calculateTotalAmountByType($type, $payable_id, $start_date, $end_date, $isNumFormated = true) {
        $startDate = Carbon::createFromFormat('Y-m-d', $start_date);
        $endDate = Carbon::createFromFormat('Y-m-d', $end_date);

        $record_query = Transaction::where([
                ['payable_id', '=', $payable_id],
                ['type', '=', $type],
            ])
            ->whereDate('created_at', '<=', $endDate)
            ->whereDate('created_at', '>=', $startDate)
            ->groupBy('payable_id')
            ->select(DB::raw('SUM(amount) / 100 as total'));
        
        $query = $record_query->toSql();
        $record = $record_query->first();
        
        if($record) {
            if($isNumFormated) {
                return number_format($record->total, 1);
            } else {
                return $record->total;
            }
            
        } else {
            return 0;
        }
    }

    public function exportMemberTransactionsData(Request $request)
    {
        $rules = [
            'type' => 'bail|required',
            'id' => 'bail|required|exists:members,id',
        ];

        $response = array('msg' => '', 'success'=>false);
        $status = 200;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $response['msg'] = $validator->messages();
            $status = 400;
        } else {
            try {

                if(isset($transaction->meta['cs_remark'])) {
                    $transaction_cs_remark = $transaction->meta['cs_remark'];
                } else {
                    $transaction_cs_remark = '';
                }
                  
                switch($request->type) {
                    case 'deposit':
                        $method = ['deposit'];
                        break;
                    case 'withdraw':
                        $method = ['withdraw'];
                        break;
                    case 'all':
                        $method = ['deposit', 'withdraw'];
                        break;
                    default:
                        $method = ['1'];
                }
                
                $transactions = DB::table('transactions')
                                ->join('members', 'transactions.payable_id', '=', 'members.id')
                                ->select('members.id', 'transactions.id', DB::raw("concat('C', LPAD(transactions.id, 11, '0')) as recept_id"), 'transactions.type', 'transactions.amount', 'transactions.meta', 'transactions.uuid', 'transactions.created_at', 'members.boss_id', 'members.name')
                                ->where('members.id', '=', $request->id)
                                ->whereIn('transactions.type', $method)
                                ->whereNull('transactions.deleted_at')
                                ->orderBy('transactions.created_at', 'desc')
                                ->get(); 

                $count = count($transactions);
        
                $export_data = array();
                $export_data[] = array(
                    'NO',
                    'TRANSACTION ID',
                    'NAME',
                    'BOSS ID',
                    'TYPE',
                    'AMOUNT (PT)',
                    'TOP-UP (HKD)',
                    'STAFF',
                    'REMARK',
                    'CS REMARK',
                    'CREATED AT',
                );
        
                foreach ($transactions as $key => $transaction) {
                    $meta = json_decode($transaction->meta);
                    
                    $topup = "";
                    if($transaction->type == 'deposit' && property_exists($meta, 'currency_amount')) {
                        $topup = $meta->currency_amount;
                    }
        
                    $staff = "";
                    if(property_exists($meta, 'staff_name')) {
                        $staff = $meta->staff_name;
                    }
        
                    $remark = "";
                    if(property_exists($meta, 'remark')) {
                        $remark = $meta->remark;
                    }
        
                    $cs_remark = "";
                    if(property_exists($meta, 'cs_remark')) {
                        $cs_remark = $meta->cs_remark;
                    }
        
                    $export_data[] = array(
                        $key + 1,
                        $transaction->recept_id,
                        $transaction->name,
                        $transaction->boss_id,
                        $transaction->type,
                        $transaction->amount / 100,
                        $topup,
                        $staff,
                        $remark,
                        $cs_remark,
                        $transaction->created_at,
                    );
                }
                $response['data'] = $export_data;
                $response['count'] = $count;
                $response['success'] = true;
            } catch(\Exception $e) {
                $response['msg'] = $e->getMessage();
                $status = 500;
            }
        }
        return response()->json($response, $status);
    }

    private function getMemberInfoFromIcMember($card_id)
    {
        $api_endpoint = $this->get_nfc_api_endpoint() . "/boss_id?uuid=".$card_id;
        $response = Http::get($api_endpoint);
        $jsonData = $response->json();
        return $jsonData;
    }

    private function getCardIdStatusFromIcMember($card_id)
    {
        $api_endpoint = $this->get_nfc_api_endpoint() . "/statusByCardId?uuid=".$card_id;
        $response = Http::get($api_endpoint);
        $jsonData = $response->json();
        return $jsonData;
    }

    private function getBossIdStatusFromIcMember($boss_id)
    {
        $api_endpoint = $this->get_nfc_api_endpoint() . "/statusByBossId?boss_id=".$boss_id;
        $response = Http::get($api_endpoint);
        $jsonData = $response->json();
        return $jsonData;
    }

}
