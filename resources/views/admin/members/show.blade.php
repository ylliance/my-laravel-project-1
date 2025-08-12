@extends('layouts.app')

@section('content')
@include('layouts.headers.header',
array(
'class'=>'info',
'title'=>"Member",'description'=>'',
'icon'=>'fas fa-home',
'breadcrumb'=>array([
'text'=>'Member',
'text'=>'Member Detail',
])))
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header ">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Member Detail') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('members.index') }}"
                                class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>{{__('Name')}}</th>
                                <td>{{ $member->name }}</td>
                                <th>{{__('Gender')}}</th>
                                <td>
                                    @if ($member->gender == 1)
                                        {{__('Male')}}
                                    @elseif($member->gender == 2)
                                        {{__('Female')}}
                                    @else
                                        {{__('No define')}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>{{__('Boss ID')}}</th>
                                <td>{{ $member->boss_id }}</td>
                                <th>{{__('Register Date')}}</th>
                                <td>{{ $member->created_at }}</td>
                            </tr>
                          
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <tr>
                                <th>{{__('Balance')}}</th>
                                <td>{{ $member->balanceFloat }} PT</td>
                                <td></td>
                                <td></td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card shadow mt-3">
                <div class="card-header ">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Member Transaction History') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <div class="export-buttons">
                                <label class="text-sm text-right">Export Data: </label>
                                <div class="btn-group ml-3">
                                    @can('export_transaction_deposit')
                                        @can('export_transaction_withdraw')
                                        <button class="btn btn-outline-success btn-sm" data-member-id="{{$member->id}}" data-member-name="{{$member->name}}" onclick="exportCSV(this, 'all')">All</button>
                                        @endcan
                                    @endcan
                
                                    @can('export_transaction_deposit')
                                        <button class="btn btn-outline-success btn-sm" data-member-id="{{$member->id}}" data-member-name="{{$member->name}}" onclick="exportCSV(this, 'deposit')">Deposit</button>
                                    @endcan
                
                                    @can('export_transaction_withdraw')
                                        <button class="btn btn-outline-success btn-sm" data-member-id="{{$member->id}}" data-member-name="{{$member->name}}" onclick="exportCSV(this, 'withdraw')">Withdraw</button>
                                    @endcan
                                </div>
                            </div>

                            <div class="export-loader" style="display: none">
                                <h3><span class="fa fa-spinner fa-spin"></span> Downloading ... </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{__('#')}}</th>
                                <th>{{__('Transaction ID')}}</th>
                                <th>{{__('Type')}}</th>
                                <th>{{__('Amount (PT)')}}</th>
                                <td>{{__('Deposit Info')}}</td>
                                <th>{{__('Remark')}}</th>
                                <th>{{__('Staff')}}</th>
                                <th>{{__('DateTime')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($member->transactions()->whereNull('deleted_at')->orderBy('created_at', 'desc')->get() as $transaction)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ "C".str_pad($transaction->id, 11, '0', STR_PAD_LEFT)}}</td>
                                    <td>
                                        @if ($transaction->type == 'deposit')
                                            <span class="badge badge-success">Deposit</span>
                                        @else
                                            <span class="badge badge-warning">Withdraw</span>
                                        @endif
                                    </td>
                                    <td>PT {{$transaction->amount / 100}}</td>
                                    <td>
                                        @if ($transaction->type == 'deposit')
                                            @isset($transaction->meta['exchange_rate'])
                                                <a class="btn btn-outline-info btn-icon m-1 btn-sm" href='javascript:;' data-member-id="{{$member->id}}" data-transaction-id="{{$transaction->id}}" onclick="showPrintReceipt(this)">
                                                    <span class="ul-btn__icon"><i class="fa fa-print"></i></span>
                                                </a>
                                                Rate: <span class="text-success">{{ $transaction->meta['exchange_rate'] }}</span>
                                                HKD: <span class="text-info">{{ $transaction->meta['currency_symbol'] }} {{ number_format($transaction->meta['currency_amount'], 1) }}</span>
                                                @if (isset($transaction->meta['special_offer']))
                                                    Special Offer: <span class="text-success">{{ $transaction->meta['special_offer'] }}</span>
                                                @endif
                                            @endisset
                                        @endif
                                    </td>
                                    <td>
                                        {{ $transaction->meta['remark']}}
                                        @if ($transaction->type == 'deposit')
                                            @isset($transaction->meta['cs_remark'])
                                                <span class="text-gray">&nbsp;{{$transaction->meta['cs_remark']}}</span>
                                            @endisset
                                        @endif
                                    </td>
                                    <td>{{ $transaction->meta['staff_name']}}</td>
                                    <td>{{$transaction->created_at}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Receipt Modal --}}
@include('admin.members.receipt')

@endsection



@push('page-script')
<script type="text/javascript" src="{{ asset('argon') }}/vendor/jquery-print/jquery.print.min.js" ></script>

<script type="text/javascript">
    const API_GET_MEMBER_TRANSACTION_URL = "{{route('member.transaction-info')}}";
    const API_GET_MEMBER_TRANSACTIONS_URL = "{{route('member.transactions-data')}}";
    
    function showPrintReceipt(ele) {
        const member_id = $(ele).attr('data-member-id');
        const transaction_id = $(ele).attr('data-transaction-id');
        $.ajax({
            url: `${API_GET_MEMBER_TRANSACTION_URL}?id=${member_id}&transaction_id=${transaction_id}`,
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
                            coupon_td_data = couponData.join(", \n");
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
    

    $(document).ready(function() {
        $('body').on('click', '.portrait_button', function() {
            $('#printable').print({
                globalStyles: true
            })
        });
    });

    function exportCSV(ele, type) {
        const member_id = $(ele).attr('data-member-id');
        const member_name = $(ele).attr('data-member-name');
        var filename = `${member_name}_${type == 'all' ? 'ALL' : type == 'deposit' ? 'Deposit': 'Withdraw'}_Transaction_History.csv`;
        $('.export-buttons').hide();
        $('.export-loader').show();
        $.ajax({
            url: `${API_GET_MEMBER_TRANSACTIONS_URL}?id=${member_id}&type=${type}`,
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

</script>
@endpush