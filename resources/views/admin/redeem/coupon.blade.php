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

@push('page-script')
<script>
    let isModalOpen = false;
    const GET_MEMBER_COUPON_URL =  "{{route('coupon.getCoupon')}}";

    function getMemberCoupon(userInfo) {
        if (isModalOpen)
            return;

        let result = null;
        $.ajax({
            url: GET_MEMBER_COUPON_URL,
            headers: { 'X-CSRF-TOKEN': '{{csrf_token()}}' },
            type: 'post',
            data: userInfo,
            async: false,
            success: function (res) { result = res; },
            error: function (xhr) { 
            }
        })

        if (result == null) {            
            Toast_info.fire({
                title: 'Success',
                text: 'Bill is created successfully.',
                icon: 'success'
            });
        } else {
            showUserStampDialog(userInfo, result.stamps);
        }
    }

    const onQRCodeResultCallback = function(data) {
        if (data == null || data.trim() == "")
            return;
        
        try {
            const userInfo = JSON.parse(data);
            getMemberCoupon(userInfo);
        } catch (error) {

        }
    };

</script>
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
<script src="{{ asset('argon') }}/js/custom/qr-scan.js"></script>
@endpush
@endsection