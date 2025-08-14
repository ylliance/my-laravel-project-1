@extends('layouts.app')

@section('content')
@include('layouts.headers.header',
array(
'class'=>'info',
'title'=>"Users",'description'=>'',
'icon'=>'fas fa-home',
'breadcrumb'=>array([
'text'=>'Users',
'text'=>'User List',
])))

@push('css')
    <link href="{{ asset('argon') }}/css/qr-scan.css" rel="stylesheet">
@endpush
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header ">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Redeem Coupon') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <button class="btn btn-primary" id="startBtn">{{__('Start Scan')}}</button>
                            <button class="btn btn-secondary" id="stopBtn">{{__('Stop Scan')}}</button>
                        </div>
                    </div>
                </div>               
                <div class="card-body">
                    <div class="wrap">
                        <video id="cam" playsinline muted></video>
                        <canvas id="overlay"></canvas>
                        <!-- offscreen capture canvas -->
                        <canvas id="capture" style="display:none"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade dialogbox" id="couponModal" data-bs-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Member Coupon</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" id="couponId"/>
                <dl class="row mb-2">
                    <dt class="col-sm-4">Username: </dt>
                    <dd class="col-sm-8"><span id="mUsername"></span></dd>

                    <dt class="col-sm-4">Phone: </dt>
                    <dd class="col-sm-8"><span id="mPhone"></span></dd>

                    <dt class="col-sm-4">Email: </dt>
                    <dd class="col-sm-8"><span id="mEmail"></span></dd>

                    <dt class="col-sm-4">Coupon No:</dt>
                    <dd class="col-sm-8"><span id="mCouponNo"></span></dd>

                    <dt class="col-sm-4">Shop:</dt>
                    <dd class="col-sm-8"><span id="mShop"></span></dd>

                    <dt class="col-sm-4">Status:</dt>
                    <dd class="col-sm-8"><span id="mStatus"></span></dd>
                </dl>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id='redeemButton'>Redeem</button>
                <button type="button" class="btn btn-secondary" id='closeButton'>Close</button>
            </div>
        </div>
    </div>
</div>

@push('page-script')
<script>
    let isModalOpen = false;
    const GET_MEMBER_COUPON_URL =  "{{route('coupon.getCoupon')}}";
    const SET_MEMBER_COUPON_USED_URL =  "{{route('coupon.setCouponUsed')}}";

    function getMemberCoupon(jsonData) {
        if (isModalOpen)
            return;

        let result = null;
        $.ajax({
            url: GET_MEMBER_COUPON_URL,
            headers: { 'X-CSRF-TOKEN': '{{csrf_token()}}' },
            type: 'post',
            data: jsonData,
            async: false,
            success: function (res) { result = res; },
            error: function (xhr) { 
            }
        })

        if (result == null) {
            Toast_info_long.fire({
                title: 'Error',
                text: 'Server Connection Error!',
                icon: 'error'
            });
        } else if (result.success == false) {
            if (result.msg == 'no coupon') {
                Toast_info_long.fire({
                    title: 'Warning',
                    text: 'It\'s not avalid coupon QR code. Please contact to super admin.',
                    icon: 'warning'
                });
            } else if (result.msg == 'no member') {
                Toast_info_long.fire({
                    title: 'Warning',
                    text: 'He/She is not a valid member',
                    icon: 'warning'
                });
            }
        }
        else{
            showCouponDialog(result);
        }
    }

    const onQRCodeResultCallback = function(data) {
        if (data == null || data.trim() == "")
            return;
        try {
            const jsonData = JSON.parse(data);
            getMemberCoupon(jsonData);
        } catch (error) {

        }
        // getMemberCoupon({
        //     'coupon_no': 'S546124$*%2343423534',
        //     'member_id': 1
        // });
    };

    function showCouponDialog(result) {       
        const {member, coupon} = result;
        isModalOpen = true; 

        $('#mUsername').text(member.username);
        $('#mPhone').text(member.phone_number);
        $('#mEmail').text(member.email);
        $('#couponId').val(coupon.id);

        $('#mCouponNo').text(coupon.coupon_no);
        $('#mShop').text(coupon.shop);
        if(coupon.status == 'valid')
            $('#mStatus').html(`<span class="badge badge-success">Valid</span>`);
        else if(coupon.status == 'used')
            $('#mStatus').html(`<span class="badge badge-danger">Used</span>`);
        else
            $('#mStatus').html(`<span class="badge badge-dark">Expired</span>`);
        
                                    
        $('#couponModal').modal('show');
    }

    $('#couponModal').on('hidden.bs.modal', function (e) {
        isModalOpen = false;
    });

    $('#redeemButton').on('click', function(e) {
        let coupon_id = $('#couponId').val();
        let result = null;
        $.ajax({
            url: SET_MEMBER_COUPON_USED_URL,
            headers: { 'X-CSRF-TOKEN': '{{csrf_token()}}' },
            type: 'post',
            data: {coupon_id},
            async: false,
            success: function (res) { result = res; },
            error: function (xhr) { 
            }
        })

        if (result == null) {
            Toast_info_long.fire({
                title: 'Error',
                text: 'Server Connection Error!',
                icon: 'error'
            });
        } else if (result.success == false) {           
            if (result.msg == 'no coupon')  {
                Toast_info_long.fire({
                    title: 'Warning',
                    text: 'Invalide Coupon. Please contact to super admin.',
                    icon: 'warning'
                });
            } else if (result.msg == 'expired or used') {
                Toast_info_long.fire({
                    title: 'Warning',
                    text: 'Coupon is expired or used.',
                    icon: 'warning'
                });
            }
        }
        else {            
            Toast_info_long.fire({
                title: 'Success',
                text: 'Do redeem successfuly',
                icon: 'success'
            });
        }
    })

    $('#closeButton').on('click', function (e) {
        $('#couponModal').modal('hide');
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
<script src="{{ asset('argon') }}/js/custom/qr-scan.js"></script>
@endpush
@endsection