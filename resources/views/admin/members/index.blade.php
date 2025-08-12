@extends('layouts.app')

@section('content')
@include('layouts.headers.header',
array(
'class'=>'info',
'title'=>"Members",'description'=>'',
'icon'=>'fas fa-home',
'breadcrumb'=>array([
'text'=>'Member List'
])))
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header mb-3">
                    <div class="row align-items-center">
                        <div class="col-md-4 col">
                            <h3 class="mb-0">{{ __('Members') }}</h3>
                        </div>

                        <div class="col-xl-4 col-md-8 col-sm-5 col-12">
                            <div class="input-group">
                                <input type="text" class="daterangepicker-field form-control form-control-sm" value="{{$start_date}} To {{$end_date}}">
                                <input type="hidden" id="start_date" name="start_date" value="{{$start_date}}" />
                                <input type="hidden" id="end_date" name="end_date" value="{{$end_date}}" />
                                   <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm" id="dateFilterBtn" type="button">Go</button>
                                </div>
                              </div>
                        </div>
                        
                        <div class="col text-right">
                            <div class="row justify-content-md-center">
                                <button type="button" data-toggle="modal" data-target="#searchModal" class="btn btn-sm btn-primary col m-1">{{ __('Search Member with Actions') }}</button>

                                @can('member_create')
                                <button type="button" data-toggle="modal" data-target="#syncModal" class="btn btn-sm btn-primary col m-1">{{ __('Sync Member') }}</button>
                                
                                <!-- <a href="{{ route('members.create') }}" class="btn btn-sm btn-primary col m-1">{{ __('Add Member') }}</a> -->
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                </div>

                <div class="table-responsive">
                    <table id="myDataTable" class="table table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>{{__('Name')}}</th>
                                <th>{{__('BOSS ID')}}</th>
                                <th>{{__('Gender')}}</th>
                                <th>{{__('Top Up (PT)')}}</th>
                                <th>{{__('Withdraw (PT)')}}</th>
                                <th>{{__('Period Balance (PT)')}}</th>
                                <th>{{__('Total Balance (PT)')}}</th>
                                <th>{{__('Registerd Date')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Member Serach Modal with Actions -->
<div class="modal" tabindex="-1" role="dialog" id="searchModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Member Search</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding-top: 0px !important; padding-bottom: 0px !important;;">

                <div class="form-group d-flex">
                    <label class="form-label" for="card_id" style="flex: 80px 0 0; line-height: 38px;">Card ID</label>
                    <input type="text" id="card_id" class="form-control" />
                    <button type="button" id="member_search_btn" class="btn btn-sm btn-primary ml-2">Search <span class="fa fa-spinner fa-spin" style="display: none"><span></button>
                </div>

                <div class="form-group d-flex">
                    <label class="form-label" style="flex: 80px 0 0; line-height: 38px;">Status</label>
                    <h2 id="member_search_status"></h2>
                </div>
                <div id="member_search_status_num" style="display: none;"></div>

                <div class="form-group d-flex">
                    <label class="form-label" for="member_search_type" style="flex: 80px 0 0; line-height: 38px;">Type</label>
                    <input type="text" id="member_search_type" class="form-control" readonly />
                </div>
                <div class="form-group d-flex">
                    <label class="form-label" for="member_search_cafe_note" style="flex: 80px 0 0; line-height: 38px;">Cafe Note</label>
                    <textarea id="member_search_cafe_note" class="form-control" readonly></textarea>
                </div>
                <div class="form-group d-flex">
                    <label class="form-label" for="member_search_boss_id" style="flex: 80px 0 0; line-height: 38px;">BOSS ID</label>
                    <input type="text" id="member_search_boss_id" class="form-control" readonly />
                </div>
                <div class="form-group d-flex">
                    <label class="form-label" for="member_search_name" style="flex: 80px 0 0; line-height: 38px;">Name</label>
                    <input type="text" id="member_search_name" class="form-control" readonly />
                </div>
                <div class="form-group d-flex">
                    <label class="form-label" for="member_search_gender" style="flex: 80px 0 0; line-height: 38px;">Gender</label>
                    <input type="text" id="member_search_gender" class="form-control" readonly />
                    <input type="hidden" id="member_search_gender_value" />
                    <input type="hidden" id="member_search_password" />
                </div>
                <div id="member_search_action_wrapper" style="display: none">
                    <label style="line-height: 50px">Balance: <span id="member_search_balance" class="text-info">0</span></label>
                    <div class="form-group d-flex justify-content-around">
                        @can('member_show')
                        <a class="btn btn-outline-info btn-icon m-1 btn-lg" id="member_search_button_show" >
                            <span class="ul-btn__icon"><i class="fas fa-eye"></i></span>
                        </a>
                        @endcan
                        
                        @can('member_edit')
                        <a class="btn btn-outline-info btn-icon m-1 btn-lg" id="member_search_button_edit" >
                            <span class="ul-btn__icon"><i class="fas fa-pencil-alt"></i></span>
                        </a>
                        @endcan

                        @can('wallet_deposit')
                        <a class="btn btn-outline-info btn-icon m-1 btn-lg" id="member_search_button_deposit" href='javascript:;' data-id="" onclick="showDepositModal(this)">
                            <span class="ul-btn__icon"><i class="fa fa-money-bill"></i></span>
                        </a>
                        <a class="btn btn-outline-primary btn-icon m-1 btn-lg" id="member_search_button_deposit_coupon" href='javascript:;' data-id="" onclick="showDepositCouponModal(this)">
                            <span class="ul-btn__icon">C</span>
                        </a>
                        @endcan

                    </div>
                    <div class="form-group d-flex justify-content-around">     
                        @can('wallet_withdraw')
                        <a class="btn btn-outline-danger btn-icon m-1 btn-lg" id="member_search_button_withdraw" href='javascript:;' data-id="" onclick="showWithDrawModal(this)">
                            <span class="ul-btn__icon"><i class="fa fa-money-bill"></i></span>
                        </a>
                        @endcan

                        @can('cafe_bills_refund_create')
                        <a class="btn btn-outline-success btn-icon m-1 btn-lg" id="member_search_button_bill" href='javascript:;' data-id="" onclick="showBillModal(this)">
                            <span class="ul-btn__icon">B</span>
                        </a>
                        @endcan
                    
                        @can('upfront_bill_access')
                        <a class="btn btn-outline-success btn-icon m-1 btn-lg" id="member_search_button_upfront_bill" href='javascript:;' data-id="" onclick="showUpfrontBillModal(this)">
                            <span class="ul-btn__icon"><i class="fa fa-dollar-sign">D</i></span>
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="padding-top: 0px;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="depositModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deposit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-0">
                <div id="depositModal_Loader">
                    <h1 class="text-center text-info"><i class="fa fa-spinner fa-spin"></i></h1>
                </div>
                <form id="deposit_form" method="post" action="{{route('member.deposit')}}">
                    @csrf
                    <table id="depositModal_content" class="table">
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td id="deposit_member"></td>
                            </tr>
                            <tr>
                                <td>Boss ID</td>
                                <td id="deposit_boss_id"></td>
                            </tr>
                            <tr>
                                <td>Balance (PT)</td>
                                <td>PT <div id="deposit_balance" style="display: inline"></div></td>
                            </tr>

                            <tr>
                                <td>Card Type</td>
                                <td>
                                    <select id="deposit_card_type" class="form-control" name="card_type" tabindex="1">
                                        <option value="{{ App\Payment::CARD_TYPE_IC_CARD }}">IC Card</option>
                                        <option value="{{ App\Payment::CARD_TYPE_TOPUP }}">Top-up Card</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>Deposit ({{$setting['currency']}})</td>
                                <td>
                                    <div class="input-group mb-0">
                                        <input id="deposit_amount" name="amount" class="form-control" type="number" value="0" min="0" autofocus tabindex="1" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">{{$setting['currency_symbol']}}</span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" id="deposit_member_id" value="0" />
                                </td>
                            </tr>
                            <tr>
                                <td>Payment Type</td>
                                <td>
                                    <select id="deposit_payment_type" class="form-control" name="type" tabindex="2">
                                        <option value="{{ App\Payment::TYPE_CASH }}">{{ App\Payment::TYPE_CASH }}</option>
                                        <option value="{{ App\Payment::TYPE_OCTOPUS }}">{{ App\Payment::TYPE_OCTOPUS }}</option>
                                        <option value="{{ App\Payment::TYPE_CARD }}">{{ App\Payment::TYPE_CARD }}</option>
                                        <option value="{{ App\Payment::TYPE_ALIPAY }}">{{ App\Payment::TYPE_ALIPAY }}</option>
                                        <option value="{{ App\Payment::TYPE_WECHAT_PAY }}">{{ App\Payment::TYPE_WECHAT_PAY }}</option>
                                    </select>
                                </td>
                            </tr>

                            <tr id="payment_no_td">
                                <td>Payment NO</td>
                                <td>
                                    <input type="text" id="deposit_payment_no" class="form-control" name="payment_no" tabindex="3" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Exchange Rate = <span class="text-success">{{$setting['exchange_rate']}}</span>
                                </td>
                                <td>
                                    Deposit (PT): <span id="deposit_point_value" class="text-info">0</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Result (PT)</td>
                                <td>PT <div id="deposit_result" style="display: inline"></div></td>
                            </tr>
                            <tr>
                                <td>Special Offer</td>
                                <td>
                                    <div class="input-group mb-0">
                                        <input id="deposit_special_offer" name="special_offer" class="form-control" type="number" value="0" min="0" autofocus tabindex="4" readonly/>
                                        <div class="input-group-append">
                                            <span class="input-group-text">PT</span>
                                        </div>
                                        <div class="input-group-append" style="margin-left: 10px;">
                                            <input style="width: 20px; height: 20px; vertical-align: middle; margin: auto;" type="checkbox" onchange="getElementById('deposit_special_offer').readOnly = !this.checked" />
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Remark</td>
                                <td><textarea id="deposit_remark" class="form-control" rows="3" name="remark"></textarea></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="this.disabled = true;submitDeposit();" tabindex="2" id="depositBtn">Deposit</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="3">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="depositCouponModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deposit Coupon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-0">
                <div id="depositCouponModal_Loader">
                    <h1 class="text-center text-info"><i class="fa fa-spinner fa-spin"></i></h1>
                </div>
                <form id="depositCoupon_form" method="post" action="{{route('member.depositCoupon')}}">
                    @csrf
                    <input type="hidden" name="id" id="depositCoupon_member_id" value="0" />
                    <table id="depositCouponModal_content" class="table">
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td id="depositCoupon_member" colspan="4"></td>
                            </tr>
                            <tr>
                                <td>Boss ID</td>
                                <td id="depositCoupon_boss_id" colspan="4"></td>
                            </tr>
                            <tr>
                                <td>Balance (PT)</td>
                                <td colspan="4">PT <div id="depositCoupon_balance" style="display: inline"></div></td>
                            </tr>
                            <tr>
                                <td>Card Type</td>
                                <td colspan="4">
                                    <select id="depositCoupon_card_type" name="card_type" class="form-control form-control-sm">
                                        <option value="{{ App\Payment::CARD_TYPE_IC_CARD }}">IC Card</option>
                                        <option value="{{ App\Payment::CARD_TYPE_TOPUP }}">Top-up Card</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="5">
                                    <table id="couponTable">
                                        <thead>
                                            <tr>
                                                <td>NO</td>
                                                <td>Coupon No</td>
                                                <td></td>
                                                <td>Coupon Value</td>
                                                <td class="border-left">NO</td>
                                                <td>Coupon No</td>
                                                <td></td>
                                                <td>Coupon Value</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for ($i = 1; $i <= 20; $i+=2)
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td><input type="text" class="form-control form-control-sm depositCoupon-no-input" name="coupon_no[]" id="depositCoupon_no_{{ $i }}" /></td>
                                                    <td><button type="button" class="btn btn-sm btn-outline-primary depositCoupon-check-btn" data-no="{{ $i - 1 }}">Check</button></td>
                                                    <td><input type="text" class="form-control form-control-sm depositCoupon-value-input" id="depositCoupon_value_{{ $i }}" disabled /></td>

                                                    <td class="border-left">{{ $i+ 1 }}</td>
                                                    <td><input type="text" class="form-control form-control-sm depositCoupon-no-input" name="coupon_no[]" id="depositCoupon_no_{{ $i + 1 }}" /></td>
                                                    <td><button type="button" class="btn btn-sm btn-outline-primary depositCoupon-check-btn" data-no="{{ $i }}">Check</button></td>
                                                    <td><input type="text" class="form-control form-control-sm depositCoupon-value-input" id="depositCoupon_value_{{ $i + 1 }}" disabled /></td>
                                                </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            

                            <tr>
                                <td colspan="2">
                                    Coupon Topup Rate = <span class="text-success">{{$setting['coupon_topup_rate']}}</span>
                                </td>
                                <td colspan="3">
                                    Deposit Coupon (PT): <span id="depositCoupon_point_value" class="text-info">0</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Result (PT)</td>
                                <td colspan="4">PT <div id="depositCoupon_result" style="display: inline"></div></td>
                            </tr>
                            <tr>
                                <td>Special Offer</td>
                                <td>
                                    <div class="input-group mb-0">
                                        <input id="depositCoupon_special_offer" readonly name="special_offer" class="form-control" type="number" value="0" min="0" autofocus tabindex="4" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">PT</span>
                                        </div>
                                        <div class="input-group-append" style="margin-left: 10px;">
                                            <input style="width: 20px; height: 20px; vertical-align: middle; margin: auto;" type="checkbox" onchange="getElementById('depositCoupon_special_offer').readOnly = !this.checked" />
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Remark</td>
                                <td colspan="4"><textarea id="depositCoupon_remark" class="form-control" rows="3" name="remark"></textarea></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" 
                    onclick="this.disabled = true;submitDepositCoupon();" 
                    tabindex="2" id="depositCouponBtn">
                    Deposit Coupon
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="3">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="withdrawModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">WithDraw</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-0">
                <div id="withdrawModal_Loader">
                    <h1 class="text-center text-info"><i class="fa fa-spinner fa-spin"></i></h1>
                </div>
                <table id="withdrawModal_content" class="table">
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td id="withdraw_member"></td>
                        </tr>
                        <tr>
                            <td>Boss ID</td>
                            <td id="withdraw_boss_id"></td>
                        </tr>
                        <tr>
                            <td>Balance (PT)</td>
                            <td>PT <div id="withdraw_balance" style="display: inline"></div></td>
                        </tr>
                        <tr>
                            <td>Amount (PT)</td>
                            <td>
                                <form id="withdraw_form" method="post" action="{{route('member.withdraw')}}">
                                    @csrf
                                    <input id="withdraw_amount" name="amount" class="form-control" type="number" value="0" min="0" />
                                    <input type="hidden" name="id" id="withdraw_member_id" value="0" />
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>Result</td>
                            <td>PT <div id="withdraw_result" style="display: inline"></div></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="submitWithdraw();this.disabled = true;" id="withdrawBtn">Withdraw</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@can('cafe_bills_refund_create')
<div class="modal" tabindex="-1" role="dialog" id="billModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create a Bill</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-0">
                <div id="billModal_Loader">
                    <h1 class="text-center text-info"><i class="fa fa-spinner fa-spin"></i></h1>
                </div>
                <form id="bill_form" method="post" action="{{route('bills.create')}}">
                    @csrf
                    <table id="billModal_content" class="table">
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td id="bill_member"></td>
                            </tr>
                            <tr>
                                <td>Boss ID</td>
                                <td id="bill_boss_id"></td>
                            </tr>
                            <tr style="display: none">
                                <td>Card UID</td>
                                <td><input type="text" id="bill_card_uid" name="card_uid" class="form-control form-control-sm" readonly /> </td>
                            </tr>
                            <tr>
                                <td>Balance (PT)</td>
                                <td>PT <div id="bill_balance" style="display: inline"></div></td>
                            </tr>
                            <tr>
                                <td>Bill#</td>
                                <td><input type="text" class="form-control form-control-sm" id="bill_no_input" onchange="enableBtn('billBtn')" name="bill_no_input"/></td>
                            </tr>
                            <tr>
                                <td>PPL</td>
                                <td><input type="number" class="form-control form-control-sm" id="bill_ppl" onchange="enableBtn('billBtn')" name="ppl" value="1" step="1" min="0" max="99" /></td>
                            </tr>
                            <tr>
                                <td>Amount (PT)</td>
                                <td>
                                    <input type="number" id="bill_amount" name="amount" class="form-control form-control-sm" value="0" min="0" onchange="enableBtn('billBtn')" />
                                    <input type="hidden" name="id" id="bill_member_id" value="0" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="submitBill();this.disabled = true;" id="billBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endcan

@can('upfront_bill_access')
<div class="modal" tabindex="-1" role="dialog" id="upfront_billModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create an Upfront Bill</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-0">
                <div id="upfront_billModal_Loader">
                    <h1 class="text-center text-info"><i class="fa fa-spinner fa-spin"></i></h1>
                </div>
                <form id="upfront_bill_form" method="post" action="{{route('bills.create_upfront_bill')}}">
                    @csrf
                    <table id="upfront_billModal_content" class="table">
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td id="upfront_bill_member"></td>
                            </tr>
                            <tr>
                                <td>Boss ID</td>
                                <td id="upfront_bill_boss_id"></td>
                            </tr>
                            <tr style="display: none">
                                <td>Card UID</td>
                                <td><input type="text" id="upfront_bill_card_uid" name="card_uid" class="form-control form-control-sm" readonly /> </td>
                            </tr>
                            <tr>
                                <td>Balance (PT)</td>
                                <td>PT <div id="upfront_bill_balance" style="display: inline"></div></td>
                            </tr>
                            <tr>
                                <td>Amount (PT)</td>
                                <td>
                                    <input type="number" id="upfront_bill_amount" name="amount" class="form-control form-control-sm" value="0" min="0" onchange="enableBtn('upfront_billBtn')" />
                                    <input type="hidden" name="id" id="upfront_bill_member_id" value="0" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="submitUpfrontBill();this.disabled = true;" id="upfront_billBtn">Submit</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endcan

{{-- Receipt Modal --}}
@include('admin.members.receipt')

<div class="modal" tabindex="-1" role="dialog" id="syncModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sync Members</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="sync_period" class="d-flex">
                    <input type="text" class="actual_range form-control" id="sync_start" />
                    <span style="margin: 10px;">To</span>
                    <input type="text" class="actual_range form-control" id="sync_end" />
                    <button type="button" id="sync_search_btn" class="btn btn-sm btn-primary ml-2">Sync <span class="fa fa-spinner fa-spin" style="display: none"><span></button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('css')
<style>
    #couponTable tr td {
        padding: 0.2rem 0.4rem;
    }

    #couponTable tr td.border-left {
        border-left: 2px solid #222222 !important;
    }
</style>
@endpush

@push('page-script')
<script type="text/javascript" src="{{ asset('argon') }}/vendor/jquery-print/jquery.print.min.js" ></script>
<script>
    const NFC_API_URL = "{{$api_url}}";
    const GET_DATATABLE_DATA = "{{route('member.getDatatableData')}}";
    const MEMBER_SYNC_URL = "{{route('member.sync')}}";
    const MEMBER_RESET_PASSWORD = "{{route('member.resetpassword')}}";
    const GET_MEMBER_INFO_URL = "{{route('member.get')}}";
    const GET_MEMBER_INFO_BY_BOSS_ID_URL = "{{route('member.getbybossid')}}";
    const API_GET_MEMBER_TRANSACTION_URL = "{{route('member.transaction-info')}}";
    const BASE_URL_TO_MEMBERS = "{{URL::to('/')}}/members";
    const API_EXPORT = "{{route('member.export')}}";
    const minimum_coupons_per_deposit = Number("{{$minimum_coupons_per_deposit}}");

    const EXCHANGE_RATE = parseFloat("{{$setting['exchange_rate']}}");
    const COUPON_TOPUP_RATE = parseFloat("{{$setting['coupon_topup_rate']}}");
    const CURRENCY = "{{$setting['currency']}}";
    const CURRENCY_SYMBOL = "{{$setting['currency_symbol']}}";
    const PREV_ID = parseInt("{{session('value')}}");
    const Swal_Confirm = Swal.mixin({
        icon: 'question',
        confirmButtonText: 'Yes',
        showCancelButton: true,
    });

    const Toast_info = Swal.mixin({
        toast: true,
        position: 'top-end',
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false,
    });

    function enableBtn(id) {
        $(`#${id}`).prop('disabled', false);
    }

    function showDepositModal(ele) {
        var id = $(ele).attr('data-id');
        $('#depositModal').modal('show');
        $('#depositModal_Loader').show();
        $('#depositModal_content').hide();
        $('#deposit_payment_type option[value=cash]').prop('selected', true);
        $('#deposit_payment_type').trigger('change');
        $('#deposit_card_type option:first').prop('selected', true);
        $('#deposit_payment_no').val('');

        $.ajax({
            url: `${GET_MEMBER_INFO_URL}?id=${id}`,
            type: 'get',
            success: function(response) {
                var { data } = response;

                $('#deposit_member').text(data.name);
                $('#deposit_boss_id').text(data.boss_id);
                $('#deposit_balance').text(parseFloat(data.balance).toFixed(1));
                $('#deposit_special_offer').val(0);
                $('#deposit_amount').val(0).trigger('change');
                $('#deposit_point_value').text(0);
                $('#deposit_member_id').val(data.id);
                $('#deposit_remark').val("");
                $('#depositModal_content').show();
            },
            error: function(response) {
                console.log(response);
                Swal.fire({
                    title: 'Failed',
                    text: response.responseJSON.msg,
                    icon: 'warning'
                });
                $('#depositModal').modal('hide');
            },
            complete: function() {
                $('#depositModal_Loader').hide();
            }
        });
    }

    function showDepositCouponModal(ele) {
        var id = $(ele).attr('data-id');
        $('#depositCouponModal').modal('show');
        $('#depositCouponModal_Loader').show();
        $('#depositCouponModal_content').hide();

        depositCouponCheck = depositCouponCheck.map((item) => 0);
        $('.depositCoupon-no-input').val('');
        $('.depositCoupon-value-input').val('');
        $('#depositCoupon_point_value').text(0);

        $.ajax({
            url: `${GET_MEMBER_INFO_URL}?id=${id}`,
            type: 'get',
            success: function(response) {
                var { data } = response;

                $('#depositCoupon_member').text(data.name);
                $('#depositCoupon_boss_id').text(data.boss_id);
                $('#depositCoupon_balance').text(parseFloat(data.balance).toFixed(1));
                $('#depositCoupon_point_value').text(0);
                $('#depositCoupon_member_id').val(data.id);
                $('#depositCoupon_remark').val("");
                $('#depositCoupon_card_type option:last').prop('selected', true);
                $('#depositCouponModal_content').show();
            },
            error: function(response) {
                console.log(response);
                Swal.fire({
                    title: 'Failed',
                    text: response.responseJSON.msg,
                    icon: 'warning'
                });
                $('#depositCouponModal').modal('hide');
            },
            complete: function() {
                $('#depositCouponModal_Loader').hide();
            }
        });
    }

    function submitDeposit() {
        const amount = $('#deposit_amount').val();
        const specialOffer = $('#deposit_special_offer').val();
        const amount_pt = $('#deposit_point_value').text().trim();
        const member_name = $('#deposit_member').text().trim();
        const id = $('#deposit_member_id').val();

        // check payment_no
        const type = $('#deposit_payment_type').val();
        if(type != paymentType_cash) {
            const payment_no = $('#deposit_payment_no').val();
            if(payment_no.trim() == "") {
                Toast_info.fire({
                    title: 'Warning',
                    text: 'Please input the payment no',
                    icon: 'warning'
                });
                $('#depositBtn').prop('disabled', false);
                return;
            }
        }

        const card_type = $('#deposit_card_type').val();
        const card_type_string = card_type == 'ic_card' ? 'IC Card' : 'Top-up Card';

        if(amount > 0) {
            Swal_Confirm.fire({
                title: `${member_name}`,
                text: `Deposit HKD${CURRENCY_SYMBOL}${parseFloat(amount).toFixed(1)} (${parseFloat(amount_pt).toFixed(1)} PT) 
                        with Special Offer (${parseFloat(specialOffer).toFixed(1)} PT) to ${card_type_string}?`,
            }).then(data => {
                if(data?.isConfirmed) {
                    $('#deposit_form').submit();
                }else{
                    document.getElementById("depositBtn").disabled = false;
                }
            });
        } else {
            Toast_info.fire({
                title: 'Warning',
                text: 'Please input the number bigger than 0',
                icon: 'warning'
            });
            document.getElementById("depositBtn").disabled = false;
        }
    }

    function toFindDuplicates(arry) {
        return arry.filter((item, index) => arry.indexOf(item) !== index);
    }

    function validateCoupons() {
        var isValid = true;
        $('.depositCoupon-no-input').each(function(index, item) {
            var value = $(item).val().trim();
            if(value != "" && depositCouponCheck[index] == 0) {
                isValid = false;
            }
        });
        return isValid;
    }

    function submitDepositCoupon() {
        const specialOffer = $('#depositCoupon_special_offer').val();
        
        // check coupons
        if(!validateCoupons()) {
            Toast_info.fire({
                title: 'Warning',
                text: 'Please input usable coupons or check all coupons',
                icon: 'warning'
            });
            document.getElementById("depositCouponBtn").disabled = false;
            return;
        }

        const coupon_no_arr = [];
        $('.depositCoupon-no-input').each(function(index, item) {
            if($(item).val().trim() != "") {
                coupon_no_arr.push($(item).val().trim());
            }            
        });

        if(coupon_no_arr.length < minimum_coupons_per_deposit) {
            Toast_info.fire({
                title: 'Warning',
                text: `You need to use at least ${minimum_coupons_per_deposit} coupons to deposit`,
                icon: 'warning'
            });
            document.getElementById("depositCouponBtn").disabled = false;
            return;
        }

        // check coupon numbers duplication
        const duplicateCouponNos = toFindDuplicates(coupon_no_arr);
        if(duplicateCouponNos.length > 0) {
            Toast_info.fire({
                title: 'Warning',
                text: `Some coupons are duplicatesd. [${duplicateCouponNos.join(',')}]`,
                icon: 'warning'
            });
            document.getElementById("depositCouponBtn").disabled = false;
            return;
        }

        const amount_pt = $('#depositCoupon_point_value').text().trim();
        const member_name = $('#depositCoupon_member').text().trim();
        const id = $('#depositCoupon_member_id').val();

        const card_type = $('#depositCoupon_card_type').val();
        const card_type_str = card_type == 'ic_card' ? 'IC Card' : 'Top-up Card';

        if(amount_pt > 0) {
            Swal_Confirm.fire({
                title: `${member_name}`,
                text: `Deposit ${parseFloat(amount_pt).toFixed(1)} PT by Coupons with Special Offer ${parseFloat(specialOffer).toFixed(1)} to ${card_type_str}?`,
            }).then(data => {
                if(data?.isConfirmed) {
                    document.getElementById("depositCouponBtn").disabled = true;
                    $('#depositCoupon_form').submit();
                } else {
                    document.getElementById("depositCouponBtn").disabled = false;
                }
            });
        } else {
            document.getElementById("depositCouponBtn").disabled = false;
            Toast_info.fire({
                title: 'Warning',
                text: 'Please input the number bigger than 0',
                icon: 'warning'
            });
        }
    }

    function submitBill() {
        const amount = $("#bill_amount").val();
        const ppl = $('#bill_ppl').val();
        const member_id = $('#bill_member_id').val();
        const card_uid = $('#bill_card_uid').val();
        const bill_no = $('#bill_no_input').val();

        if(bill_no.length == 0) {
            Toast_info.fire({
                title: 'Warning',
                text: 'Please input Bill Number',
                icon: 'warning'
            });
            return;
        }

        if(amount <= 0) {
            Toast_info.fire({
                title: 'Warning',
                text: 'Please input the amount bigger than 0',
                icon: 'warning'
            });
            return;
        }

        if(ppl <= 0) {
            Toast_info.fire({
                title: 'Warning',
                text: 'Please input the ppl',
                icon: 'warning'
            });
            return;
        }

        $.ajax({
            url: $('#bill_form').attr('action'),
            type: 'post',
            data: {
                card_uid, member_id, amount, ppl, bill_no, _token: $('input[name=_token]').val()
            },
            success: function(res) {
                Toast_info.fire({
                    title: 'Success',
                    text: 'Bill is created successfully.',
                    icon: 'success'
                });
                $('#billModal').modal('hide');
                $('#searchModal').modal('hide');    
            },
            error: function(res) {
                const msg = res.responseJSON.msg;
                Toast_info.fire({
                    title: 'Failed',
                    text: msg,
                    icon: 'danger'
                });
            }
        });
    }

    function submitUpfrontBill() {
        const amount = $("#upfront_bill_amount").val();
        const member_id = $('#upfront_bill_member_id').val();
        const card_uid = $('#upfront_bill_card_uid').val();

        if(amount <= 0) {
            Toast_info.fire({
                title: 'Warning',
                text: 'Please input the amount bigger than 0',
                icon: 'warning'
            });
            return;
        }

        $.ajax({
            url: $('#upfront_bill_form').attr('action'),
            type: 'post',
            data: {
                card_uid, member_id, amount, _token: $('input[name=_token]').val()
            },
            success: function(res) {
                Toast_info.fire({
                    title: 'Success',
                    text: 'Bill is created successfully.',
                    icon: 'success'
                });
                $('#upfront_billModal').modal('hide');
                $('#searchModal').modal('hide');    
            },
            error: function(res) {
                const msg = res.responseJSON.msg;
                Toast_info.fire({
                    title: 'Failed',
                    text: msg,
                    icon: 'danger'
                });
            }
        });
    }

    function clearBillModal() {
        $('#bill_member').text('');
        $('#bill_boss_id').text('');
        $('#bill_balance').text('');
        $('#bill_amount').val(0);
        $('#bill_member_id').val(0);
        $('#bill_card_uid').val('');
        $('#bill_ppl').val(1);
    }

    function showBillModal(ele) {
        clearBillModal();
        var id = $(ele).attr('data-id');
        $('#billModal').modal('show');
        $('#billModal_Loader').show();
        $('#billModal_content').hide();

        $.ajax({
            url: `${GET_MEMBER_INFO_URL}?id=${id}`,
            type: 'get',
            success: function(response) {
                var { data } = response;

                $('#bill_member').text(data.name);
                $('#bill_boss_id').text(data.boss_id);
                $('#bill_balance').text(parseFloat(data.balance).toFixed(1));
                $('#bill_amount').val(0).trigger('change');
                $('#bill_member_id').val(data.id);
                $('#bill_card_uid').val(data.card_uid);
                $('#billModal_content').show();
            },
            error: function(response) {
                console.log(response);
            },
            complete: function() {
                $('#billModal_Loader').hide();
            }
        });
    }

    function clearUpfrontBillModal() {
        $('#upfront_bill_member').text('');
        $('#upfront_bill_boss_id').text('');
        $('#upfront_bill_balance').text('');
        $('#upfront_bill_amount').val(0);
        $('#upfront_bill_member_id').val(0);
        $('#upfront_bill_card_uid').val('');
    }

    function showUpfrontBillModal(ele) {
        clearUpfrontBillModal();
        var id = $(ele).attr('data-id');
        $('#upfront_billModal').modal('show');
        $('#upfront_billModal_Loader').show();
        $('#upfront_billModal_content').hide();

        $.ajax({
            url: `${GET_MEMBER_INFO_URL}?id=${id}`,
            type: 'get',
            success: function(response) {
                var { data } = response;

                $('#upfront_bill_member').text(data.name);
                $('#upfront_bill_boss_id').text(data.boss_id);
                $('#upfront_bill_balance').text(parseFloat(data.balance).toFixed(1));
                $('#upfront_bill_amount').val(0).trigger('change');
                $('#upfront_bill_member_id').val(data.id);
                $('#upfront_bill_card_uid').val($('#card_id').val());
                $('#upfront_billModal_content').show();
            },
            error: function(response) {
                console.log(response);
            },
            complete: function() {
                $('#upfront_billModal_Loader').hide();
            }
        });
    }

    function showWithDrawModal(ele) {
        var id = $(ele).attr('data-id');
        $('#withdrawModal').modal('show');
        $('#withdrawModal_Loader').show();
        $('#withdrawModal_content').hide();

        $.ajax({
            url: `${GET_MEMBER_INFO_URL}?id=${id}`,
            type: 'get',
            success: function(response) {
                var { data } = response;

                $('#withdraw_member').text(data.name);
                $('#withdraw_boss_id').text(data.boss_id);
                $('#withdraw_balance').text(parseFloat(data.balance).toFixed(1));
                $('#withdraw_amount').val(0).trigger('change');
                $('#withdraw_member_id').val(data.id);
                $('#withdrawModal_content').show();
            },
            error: function(response) {
                console.log(response);
                Swal.fire({
                    title: 'Failed',
                    text: response.responseJSON.msg,
                    icon: 'warning'
                });
                $('#withdrawModal').modal('hide');
            },
            complete: function() {
                $('#withdrawModal_Loader').hide();
            }
        });
    }

    async function submitWithdraw() {
        const amount = Number($('#withdraw_amount').val());
        const member_name = $('#withdraw_member').text().trim();
        const id = $('#withdraw_member_id').val();
        let balance = await checkBalance(id);
        if(amount > 0) {
            if(amount <= balance) {
                Swal_Confirm.fire({
                    title: `${member_name}`,
                    text: `Deduce PT ${amount} from this account?`,
                }).then(data => {
                    if(data?.isConfirmed) {
                        $('#withdraw_form').submit();
                    }else{
                        document.getElementById("withdrawBtn").disabled = false;
                    }
                });
            } else {
                Swal.fire({
                    title: 'Insufficient Points',
                    text: `Member's balance is PT ${balance}`,
                    icon: 'warning'
                });
                document.getElementById("withdrawBtn").disabled = false;
            }
        } else {
            Toast_info.fire({
                title: 'Warning',
                text: 'Please input the number bigger than 0',
                icon: 'warning'
            });
        }
    }

    function checkBalance(id) {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: 'get',
                url: `{{route('member.balance')}}?id=${id}`,
                success: function(response) {
                    resolve(Number(response.data.balance));
                },
                error: function(response) {
                    reject(response.responseJSON.msg);
                }
            })
        })
    }

    async function syncMembers(members) {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: 'post',
                url: MEMBER_SYNC_URL,
                data: {members, '_token': $("meta[name='csrf-token']").attr("content")},
                success: function(res) {
                    const {imported, count} = res.data;
                    const total = members.length;
                    Swal.fire(
                        'Synced',
                        `Newly created ${count} member(s) from fetched ${total} members`,
                        'success'
                    );
                    resolve({count, total, imported});
                },
                error: function(res) {
                    console.log(res);
                    reject();
                },
                complete: function() {
                    $('#sync_search_btn span').hide();
                    $('#sync_search_btn').prop('disabled', false);
                }
            });
        });
    }

    function renderMemberSearchContent(id) {
        $('#member_search_action_wrapper').show();
        $('#member_search_button_show').attr('href', `${BASE_URL_TO_MEMBERS}/${id}`);
        $('#member_search_button_edit').attr('href', `${BASE_URL_TO_MEMBERS}/${id}/edit`);

        $('#member_search_button_edit').show();
        $('#member_search_button_deposit').hide();
        $('#member_search_button_deposit_coupon').hide();
        $('#member_search_button_withdraw').hide();
        $('#member_search_button_bill').hide();
        $('#member_search_button_upfront_bill').hide();
    }
    function renderMemberSearchOperationContent(id) {
        $('#member_search_button_deposit').attr('data-id', id);
        $('#member_search_button_deposit_coupon').attr('data-id', id);
        $('#member_search_button_withdraw').attr('data-id', id);
        $('#member_search_button_bill').attr('data-id', id);
        $('#member_search_button_upfront_bill').attr('data-id', id);

        $('#member_search_button_deposit').show();
        $('#member_search_button_deposit_coupon').show();
        $('#member_search_button_withdraw').show();
        $('#member_search_button_bill').show();
        $('#member_search_button_upfront_bill').show();
    }

    function findMemberByBossID(boss_id, name) {
        $.ajax({
            type: 'post',
            url: `${GET_MEMBER_INFO_BY_BOSS_ID_URL}?boss_id=${boss_id}`,
            data: {
                boss_id: boss_id,
                name: name,
                '_token': $("meta[name='csrf-token']").attr("content")
            },
            success: function(res) {
                const data = res.data;
                renderMemberSearchContent(data.id);
                if(res.success) {
                    if ($('#member_search_status_num').text() == "1") {      //1: active, 0: inactive, 2: expired
                        renderMemberSearchOperationContent(data.id);
                    }
                }

                if(res.name_updated) {
                    Toast_info.fire({
                        text: 'Member name is updated successfully.',
                        icon: 'info'
                    });
                }
                $('#member_search_balance').text(parseFloat(data.balance).toFixed(1));
            },
            error: function(res) {
                if(res.status == 400) {
                    Swal.fire({
                        confirmButtonText: 'Yes',
                        showCancelButton: true,
                        title: 'Info',
                        text: "This member wallet is not registered. Will you create this member wallet now?",
                        icon: 'warning'
                    }).then(data => {
                        if(data?.isConfirmed) {
                            var members = [];
                            members.push({
                                'boss_id': boss_id,
                                'name': $('#member_search_name').val(),
                                'gender': $('#member_search_gender_value').val(),
                                'password': $('member_search_password').val(),
                            });
                            syncMembers(members).then((data) => {
                                var imported = data.imported;
                                var new_id = imported[0];
                                renderMemberSearchContent(new_id);
                                if ($('#member_search_status_num').text() == "1") {
                                    renderMemberSearchOperationContent(new_id);
                                }
                                $('#member_search_balance').text("0");
                            });
                        }
                    });
                } else {
                    Swal.fire('Error', 'Something went wrong', 'error');
                }
            },
            complete: function() {
                $('#member_search_btn span').hide();
                $('#member_search_btn').prop('disabled', false);
            }
        });
    }

    function clearMemberSearchModal() {    
        $('#card_id').val("");
        $('#member_search_boss_id').val("");
        $('#member_search_name').val("");
        $('#member_search_gender').val("");
        $('#member_search_gender_value').val("");
        $('#member_search_type').val("");
        $('#member_search_status').empty();
        $('#member_search_status_num').text("");
        $('#member_search_cafe_note').val("");
        $('#member_search_password').val("");
        $('#member_search_action_wrapper').hide();
        $('#member_search_balance').text("0");
    }

    function getDateFromMoment(date) {
        let month = date.month() + 1;
        month = month > 9 ? month : "0" + month;
        let day = date.date();
        day = day > 9 ? day : "0" + day;
        return "" + date.year() + "-" + month + "-" + day;
    }

    function exportCSV() {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        var filename = `members_${startDate}_To_${endDate}.csv`;
        $('.export-buttons').hide();
        $('.export-loader').show();
        $.ajax({
            url: `${API_EXPORT}?startDate=${startDate}&endDate=${endDate}`,
            type: 'get',
            success: function(res) {
                exportToCSV(res.data, filename);
            },
            complete: function() {
                $('.export-buttons').show();
                $('.export-loader').hide();
            }
        })
    }

    function exportToCSV(data, filename='export.csv') {
        let csvData = "\ufeff";

        data.forEach(function(rowArray) {
            csvData += rowArray.join(',');
            csvData += "\n";
        });

        var hiddenElement = document.createElement("a");
        hiddenElement.href = "data:text/csv;charset=utf-8," + encodeURI(csvData);
        hiddenElement.target = "_blank";
        hiddenElement.download = filename;
        hiddenElement.click();
    }

    function resetPasswordsByInitialPasswords()
    {
        const uri = "/get_all_members_with_password";
        membersWithPassword = null;

        $.ajax({
            url: `${NFC_API_URL}${uri}`,
            type: 'post',
            success: function(res) {
                membersWithPassword = res.data;

                if(membersWithPassword.length > 0) {
                    $.ajax({
                        type: 'post',
                        url: MEMBER_RESET_PASSWORD,
                        data: {'members' : membersWithPassword, '_token': $("meta[name='csrf-token']").attr("content")},
                        success: function(res) {
                            alert(`${res.data.count} passwords are reset successfully.`);
                        },
                        error: function(res) {
                            console.log(res);
                        },
                        
                    });
                }
            },
            error: function(res) {
                console.log(res);
            },
        });
    }

    function calculateTotalDepositCoupons() {
        let totalCouponValue = 0;
        const balance = parseFloat($('#depositCoupon_balance').text());

        $('.depositCoupon-value-input').each(function(index, item) {
            let value = Number($(item).val());
            if( !isNaN(value) ) {
                totalCouponValue += value;
            }
        });

        const specialOffer = parseFloat($('#depositCoupon_special_offer').val());

        $('#depositCoupon_point_value').text(parseFloat(totalCouponValue * COUPON_TOPUP_RATE).toFixed(1));
        $('#depositCoupon_result').text(parseFloat(balance + specialOffer + totalCouponValue * COUPON_TOPUP_RATE).toFixed(1));
    }

    var depositCouponCheck = [
        0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
        0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
    ]; // total 20 coupons
    const paymentType_cash = "{{ App\Payment::TYPE_CASH }}";

    $(document).ready(function() {
        var table;
        $(".daterangepicker-field").daterangepicker({
            callback: function(startDate, endDate, period){
                var start_date = getDateFromMoment(startDate);
                var end_date = getDateFromMoment(endDate);
                var title = start_date + ' to ' + end_date;
                $(this).val(title);
                $('input[name="start_date"]').val(start_date);
                $('input[name="end_date"]').val(end_date);
            },
            ranges: {
                'Today' : [moment(), moment()],
                'Last 7 days': [moment().subtract(6, 'days'), moment()],
                'Last 15 days': [moment().subtract(14, 'days'), moment()],
                'All Time': [moment("2023-01-19"), moment()],
                'Custom Range': 'custom',
            }
        });

        $('#dateFilterBtn').on('click', function() {
            table.ajax.reload();
        });

        $('#deposit_amount').on('change', function() {
            const balance = parseFloat($('#deposit_balance').text());
            const specialOffer = parseFloat($('#deposit_special_offer').val());
            const deposit = parseFloat($('#deposit_amount').val()).toFixed(1);
            $('#deposit_point_value').text(parseFloat(deposit * EXCHANGE_RATE).toFixed(1));
            $('#deposit_result').text(parseFloat(balance + specialOffer + deposit * EXCHANGE_RATE).toFixed(1));
        });

        $('#deposit_special_offer').on('change', function() {
            const balance = parseFloat($('#deposit_balance').text());
            const specialOffer = parseFloat($('#deposit_special_offer').val());
            const deposit = parseFloat($('#deposit_amount').val()).toFixed(1);
            $('#deposit_point_value').text(parseFloat(deposit * EXCHANGE_RATE).toFixed(1));
            $('#deposit_result').text(parseFloat(balance + specialOffer + deposit * EXCHANGE_RATE).toFixed(1));
        });

        $('#depositCoupon_special_offer').on('change', function() {
            calculateTotalDepositCoupons();
        });

        $('#withdraw_amount').on('change', function() {
            const balance = parseFloat($('#withdraw_balance').text());
            const withdraw = parseFloat($('#withdraw_amount').val());
            $('#withdraw_result').text((balance - withdraw).toFixed(1));
        });

        // disable form submit on enter press
        $('#deposit_form').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                submitDeposit();
                return false;
            }
        });

        $('#deposit_payment_type').on('change', function(e) {
            if($(this).val() == paymentType_cash) {
                $('#payment_no_td').hide();
            } else {
                $('#payment_no_td').show();
            }
        });

        $('#withdraw_form').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                submitWithdraw();
                return false;
            }
        });

        $('#sync_search_btn').on('click', function() {
            const loader = $(this).find('span');
            loader.show();
            $(this).prop('disabled', true);

            const uri = "/get_all_members";
            const start_date = $('#sync_start').val();
            const end_date = $('#sync_end').val();

            sync_members = null;

            $.ajax({
                url: `${NFC_API_URL}${uri}`,
                type: 'post',
                data: {start_date, end_date},
                success: function(res) {
                    sync_members = res.data;

                    if(sync_members.length > 0) {
                        syncMembers(sync_members);
                    }
                },
                error: function(res) {
                    console.log(res);
                    Swal.fire(
                        'Failed',
                        'Something went wrong',
                        'error'
                    );
                    $('#sync_search_btn').prop('disabled', false);
                    loader.hide();
                },
            });

        });

        $('#sync_period').datepicker({
            inputs: $('.actual_range'),
            format: {
                toDisplay: function (date, format, language) {
                    var d = new Date(date);
                    return d.toISOString().split('T')[0];
                },
                toValue: function (date, format, language) {
                    var d = new Date(date);
                    return new Date(d);
                }
            }
        });

        $('#searchModal').on('shown.bs.modal', function() {
            clearMemberSearchModal();
        });
        
        $('#member_search_btn').on('click', function() {
            const card_id = $('#card_id').val().trim();
            $('#member_search_boss_id').val("");
            $('#member_search_name').val("");
            $('#member_search_gender').val("");
            $('#member_search_gender_value').val("");
            $('#member_search_type').val("");
            $('#member_search_status').empty();
            $('#member_search_status_num').text("");
            $('#member_search_cafe_note').val("");
            $('#member_search_password').val("");
            $('#member_search_action_wrapper').hide();
            if(card_id == "") {
                Toast_info.fire({
                    title: 'Warning',
                    text: 'Please input the card ID',
                    icon: 'warning'
                });
            } else {
                const loader = $(this).find('span');
                loader.show();
                $(this).prop('disabled', true);

                $.ajax({
                    url: `${NFC_API_URL}/boss_id?uuid=${card_id}`,
                    type: 'get',
                    success: function(res) {
                        if(res.success) {
                            $('#member_search_boss_id').val(res.data.boss_id);
                            $('#member_search_name').val(res.data.name);
                            $('#member_search_type').val(res.data.typeStr);

                            let statusCode = '';
                            if(res.data.statusCode == 0) {
                                statusCode = '<span class="badge badge-danger">Inactive</span>';
                            } else if (res.data.statusCode == 1) {
                                statusCode = '<span class="badge badge-primary">Active</span>';
                            } else {
                                statusCode = '<span class="badge badge-warning">Expired</span>';
                            }
                            $('#member_search_status').html(statusCode);
                            $('#member_search_status_num').text(res.data.statusCode);
                            $('#member_search_cafe_note').val(res.data.cafe_note);
                            $('#member_search_password').val(res.data.password);
                            let gender = res.data.gender == 1 ? 'Male' : res.data.gender == 2 ? 'Female' : 'Not defined';
                            $('#member_search_gender').val(gender);
                            $('#member_search_gender_value').val(res.data.gender);
                            findMemberByBossID(res.data.boss_id, res.data.name);
                        }
                    },
                    error: function(res) {
                        var msg = "Something went wrong";

                        if(res.status == 400) {
                            msg = "There is no member using this card";
                        }
                        console.log(res);
                        Swal.fire(
                            'Failed',
                            msg,
                            'error'
                        );
                        $('#member_search_btn').prop('disabled', false);
                        loader.hide();
                    },
                });
            }
        });

        $('body').on('click', '.portrait_button', function() {
            $('#printable').print({
                globalStyles: true
            })
        });

        // show receipt print modal when prev_id is valid
        if(PREV_ID > 0) {
            $.ajax({
                url: `${API_GET_MEMBER_TRANSACTION_URL}?id=${PREV_ID}`,
                type: 'get',
                success: function(response) {
                    if(response.success) {
                        const data = response.data;
                        var date = new Date();
                        var printDate = date.toISOString().split('T')[0];
                        if(data.transaction_type == 'deposit') {

                            if(data.coupons.length > 0) {
                                $('.price-span').hide();
                                $('.coupon-span').show();
                                $('.receipt-payment-cash').hide();

                                var couponData = data.coupons.map((coupon) => {
                                    return `${coupon.coupon_no}(${parseInt(coupon.coupon_value)})`;
                                });
                                

                                // check coupon count and modify font size
                                if(couponData.length > 14) {
                                    $('#receipt_currency_amount').css('font-size', '1rem');
                                    $('#receipt_currency_amount2').css('font-size', '1rem');
                                    $('#receipt_currency_amount3').css('font-size', '1rem');

                                    // also need to show 2 coupons in one line
                                    coupon_td_data = couponData
                                        .reduce((acc, curr, index) => {
                                        if (index % 2 === 0) {
                                            // Start a new group
                                            acc.push(curr);
                                        } else {
                                            // Add to the last group
                                            acc[acc.length - 1] += `, ${curr}`;
                                        }
                                        return acc;
                                        }, [])
                                        .join("\n");
                                } else {
                                    coupon_td_data = couponData.join(", \n");
                                }

                                
                                var obj1 = $('#receipt_currency_amount').text(coupon_td_data);
                                var obj2 = $('#receipt_currency_amount2').text(coupon_td_data);
                                var obj3 = $('#receipt_currency_amount3').text(coupon_td_data);
                                obj1.html(obj1.html().replace(/\n/g,'<br/>'));
                                obj2.html(obj2.html().replace(/\n/g,'<br/>'));
                                obj3.html(obj3.html().replace(/\n/g,'<br/>'));
                            } else {
                                $('.price-span').show();
                                $('.coupon-span').hide();
                                $('.receipt-payment-cash').show();

                                if(data.digital_payment == null) {
                                    // cash
                                    $('.receipt-payment-cash').text('現金');
                                } else {
                                    // digital payment
                                    $('.receipt-payment-cash').text(data.digital_payment.type);
                                }
                                
                                $('#receipt_currency_amount').text(data.transaction_meta.currency_amount);
                                $('#receipt_currency_amount2').text(data.transaction_meta.currency_amount);
                                $('#receipt_currency_amount3').text(data.transaction_meta.currency_amount);
                            }

                            $('#receipt_card_type').text(data.card_type);

                            var special_offer = 0;
                            var transaction_amount = Number(data.transaction_amount);
                            if(data.special_offer) {
                                special_offer = Number(data.special_offer.amount);
                                transaction_amount -= special_offer;
                            }
                            
                            $('#receipt_id').text(data.transaction_receipt_no);
                            $('#receipt_dist').text(`${data.boss_id} ${data.name}`);
                            $('#receipt_print_date').text(printDate);
                            $('#receipt_remark').text(data.transaction_remark);
                            $('#receipt_type_label').text(data.transaction_type_label);
                            $('#receipt_amount').text(`PT ${parseFloat(transaction_amount).toFixed(0)}`);
                            $('#receipt_amount_total').text(`PT ${parseFloat(data.transaction_amount).toFixed(0)}`);
                            $('#receipt_balance').text(`PT ${parseFloat(data.balance).toFixed(0)}`);
                            $('#receipt_payment_currency_amount').text(`${data.transaction_meta.currency} ${parseFloat(data.transaction_meta.currency_amount).toFixed(1)}`);
                            $('#receipt_staff').text(data.transaction_meta.staff_name);
                            $('#receipt_card_type').text(data.card_type);

                            $('#receipt_id2').text(data.transaction_receipt_no);
                            $('#receipt_dist2').text(`${data.boss_id} ${data.name}`);
                            $('#receipt_print_date2').text(printDate);
                            $('#receipt_remark2').text(data.transaction_remark);
                            $('#receipt_type_label2').text(data.transaction_type_label);
                            $('#receipt_amount2').text(`PT ${parseFloat(transaction_amount).toFixed(0)}`);
                            $('#receipt_amount_total2').text(`PT ${parseFloat(data.transaction_amount).toFixed(0)}`);
                            $('#receipt_balance2').text(`PT ${parseFloat(data.balance).toFixed(0)}`);
                            $('#receipt_payment_currency_amount2').text(`${data.transaction_meta.currency} ${parseFloat(data.transaction_meta.currency_amount).toFixed(1)}`);
                            $('#receipt_staff2').text(data.transaction_meta.staff_name);
                            $('#receipt_card_type2').text(data.card_type);                 

                            $('#receipt_id3').text(data.transaction_receipt_no);
                            $('#receipt_dist3').text(`${data.boss_id} ${data.name}`);
                            $('#receipt_print_date3').text(printDate);
                            $('#receipt_remark3').text(data.transaction_remark);
                            $('#receipt_type_label3').text(data.transaction_type_label);
                            $('#receipt_amount3').text(`PT ${parseFloat(transaction_amount).toFixed(0)}`);
                            $('#receipt_amount_total3').text(`PT ${parseFloat(data.transaction_amount).toFixed(0)}`);
                            $('#receipt_balance3').text(`PT ${parseFloat(data.balance).toFixed(0)}`);
                            $('#receipt_payment_currency_amount3').text(`${data.transaction_meta.currency} ${parseFloat(data.transaction_meta.currency_amount).toFixed(1)}`);
                            $('#receipt_staff3').text(data.transaction_meta.staff_name);
                            $('#receipt_card_type3').text(data.card_type);

                            if(data.special_offer) {
                                $('.receipt-special-offer-item').show();
                                $('#receipt_special_offer_amount').text('PT ' + special_offer);
                                $('#receipt_special_offer_amount2').text('PT ' + special_offer);
                                $('#receipt_special_offer_amount3').text('PT ' + special_offer);
                            } else {
                                $('.receipt-special-offer-item').hide();
                            }

                            $('#receiptModal').modal('show');
                        }
                    }
                }
            });
        }

        table = $('#myDataTable').DataTable({
            dom: "<'row'<'#export_wrapper.col col-sm-3 col-md-3 col'><'col-xl-4 col-sm-3 col-md-3 col ml-auto'l><'col text-right'f>>rtip",
            language: {
                paginate: {
                    previous: "<i class='fas fa-angle-left'>",
                    next: "<i class='fas fa-angle-right'>"
                },
                lengthMenu: '_MENU_'
            },
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']],
            processing: true,
            serverSide: true,
            ajax: {
                url: GET_DATATABLE_DATA,
                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                data: function (d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                },
            },
            columns: [
                { data: 'name' },
                { data: 'boss_id' },
                { data: 'gender' },
                { data: 'totalDeposit', orderable: false },
                { data: 'totalWithdraw', orderable: false },
                { data: 'periodBalanceFloat', orderable: false },
                { data: 'balanceFloat', orderable: false },
                { data: 'created_at' },
                { data: 'action', orderable: false },
            ],
            order: [[7, 'desc']],
            scrollX: true,
            scrollY: '600px',
            bLengthChange: false,
            initComplete: function(settings, json) {
                $('#export_wrapper').html(`<button class="btn btn-outline-success btn-sm export-buttons ml-2" onclick="exportCSV()">Export All</button>
                    <div class="export-loader" style="display: none">
                        <h3><span class="fa fa-spinner fa-spin"></span> Downloading ... </h3>
                    </div>`);
            }
        });

        // coupon check
        $('.depositCoupon-check-btn').on('click', function(e) {
            const no = Number($(this).attr('data-no'));
            const tr = $(this).closest('tr');
            const coupon_no_input = tr.find('input.depositCoupon-no-input');
            const coupon_no = coupon_no_input.val().trim();
            const coupon_value_input = $(`#depositCoupon_value_${no + 1}`);
            coupon_value_input.val('Analysing ...');

            $.ajax({
                url: "{{route('coupons.check')}}" + '?coupon_no=' + coupon_no,
                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                type: 'get',
                success: function(res) {
                    const data = res.data;
                    if(data.coupon_valid) {
                        if(data.coupon_used) {
                            coupon_value_input.val('This coupon is used').addClass('border-danger');
                            depositCouponCheck[no] = 0;
                        } else {
                            
                            if (data.coupon_value == 0) {
                                coupon_value_input.val(0).addClass('border-danger');
                                depositCouponCheck[no] = 0;
                            } else {
                                coupon_value_input.removeClass('border-danger');
                                coupon_value_input.val(data.coupon_value).addClass('text-success').removeClass('text-danger');
                                depositCouponCheck[no] = 1;
                            }
                        }
                    } else {
                        coupon_value_input.val('This coupon is invalid').addClass('text-danger').removeClass('text-success');
                    }
                    calculateTotalDepositCoupons();
                },
                error: function(res) {
                    console.log(res);
                    coupon_value_input.val('Something went wrong').addClass('text-danger').removeClass('text-success');
                }
            });

        });        
    });
</script>
@endpush