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
    <style>
        .w-128 {
            width: 128px;
        }
        .h-128 {
            height: 128px;
        }
        .border-b-1 {
            border-bottom: 1px solid #e9ecef;
        }
        .stamp-info {
            display: flex;
            align-content: center;
        }
        .camera-dropdown {
            min-width: 200px;
        }
        .camera-dropdown .dropdown-item {
            padding: 0.5rem 1rem;
            border-bottom: 1px solid #f8f9fa;
        }
        .camera-dropdown .dropdown-item:last-child {
            border-bottom: none;
        }
        .camera-dropdown .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        .camera-refresh-btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            margin-left: 0.5rem;
        }
        .dropdown-menu.show {
            display: block !important;
        }
        .btn-group {
            position: relative;
        }
        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            float: left;
            min-width: 10rem;
            padding: 0.5rem 0;
            margin: 0.125rem 0 0;
            font-size: 1rem;
            color: #212529;
            text-align: left;
            list-style: none;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 0.25rem;
        }
        .dropdown-item {
            display: block;
            width: 100%;
            padding: 0.25rem 1.5rem;
            clear: both;
            font-weight: 400;
            color: #212529;
            text-align: inherit;
            white-space: nowrap;
            background-color: transparent;
            border: 0;
        }
        .dropdown-item:hover,
        .dropdown-item:focus {
            color: #16181b;
            text-decoration: none;
            background-color: #f8f9fa;
        }
        
        /* Camera preview styling */
        .camera-preview .wrap {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            overflow: hidden;
            background: #f8f9fa;
            width: 400px;
            height: 400px;
            position: relative;
        }
        
        .camera-preview video {
            width: 400px;
            height: 400px;
            object-fit: cover;
        }
        
        .camera-preview canvas#overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 400px;
            height: 400px;
        }
        
        /* Scan results styling */
        .scan-result-container {
            min-height: 400px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            background: #f8f9fa;
        }
        
        .scan-result-item {
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;
            background: white;
            margin: 0.5rem;
            border-radius: 6px;
        }
        
        .scan-result-item:last-child {
            border-bottom: none;
        }
        
        .member-info {
            background: #e3f2fd;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
        }
        
        .coupon-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .coupon-item {
            background: white;
            padding: 1rem;
            border-radius: 6px;
            border: 1px solid #e9ecef;
            text-align: left;
        }
        
        .coupon-qr {
            margin-bottom: 0.5rem;
            text-align: center;
        }
        
        .coupon-qr img {
            margin: 0 auto;
            display: block;
        }
        
        .coupon-details {
            text-align: left;
        }
        
        .redeem-actions {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e9ecef;
        }
        
        /* Layout container for fixed left and flexible right */
        .layout-container {
            display: flex;
            gap: 2rem;
            align-items: flex-start;
        }
        
        /* Camera controls and preview transitions */
        .camera-controls,
        .camera-preview {
            transition: opacity 0.3s ease-in-out;
        }
        
        .camera-controls.hidden,
        .camera-preview.hidden {
            opacity: 0;
            pointer-events: none;
        }
        
        .left-side {
            width: 400px;
            flex-shrink: 0;
        }
        
        .right-side {
            flex: 1;
            min-width: 0; /* Allows flex item to shrink below content size */
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .layout-container {
                flex-direction: column;
                gap: 1rem;
            }
            
            .left-side {
                width: 100%;
            }
            
            .right-side {
                width: 100%;
            }
        }
    </style>
@endpush
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header ">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h3 class="mb-0">{{ __('Redeem Coupon') }}</h3>
                        </div>
                    </div>
                </div>               
                <div class="card-body">
                    <!-- Camera Preview and Settings/Results in same line -->
                    <div class="layout-container">
                        <!-- Left Side - Camera Preview and Settings (Fixed 400px) -->
                        <div class="left-side">
                            <!-- Camera Settings Section -->
                            <div class="camera-controls" id="cameraControls">
                                <h5 class="mb-3">{{ __('Camera Settings') }}</h5>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" id="cameraDropdown">
                                        <i class="fas fa-camera"></i> {{__('Select Camera')}}
                                    </button>
                                    <ul class="dropdown-menu camera-dropdown" id="cameraList">
                                        <li><a class="dropdown-item" href="#" data-camera="default">{{__('Default Camera')}}</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="#" id="refreshCameras">
                                            <i class="fas fa-sync-alt"></i> {{__('Refresh Cameras')}}
                                        </a></li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="camera-preview" id="cameraPreview" style="display: none;">
                                <h5 class="mb-3">{{ __('Camera Preview') }}</h5>
                                <div class="wrap">
                                    <video id="cam" playsinline muted></video>
                                    <canvas id="overlay"></canvas>
                                    <!-- offscreen capture canvas -->
                                    <canvas id="capture" style="display:none"></canvas>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Side - Scan Results (Remaining space) -->
                        <div class="right-side">
                            <!-- Scan Results Section -->
                            <div class="scan-results">
                                <h5 class="mb-3">{{ __('Scan Results') }}</h5>
                                <div id="scanResultContainer" class="scan-result-container">
                                    <div class="text-center text-muted py-5">
                                        <i class="fas fa-qrcode fa-3x mb-3"></i>
                                        <p>{{ __('No QR code scanned yet') }}</p>
                                        <small>{{ __('Point your camera at a QR code to scan') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
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
            console.log(error);
        }
        // getMemberCoupon({
        //     'coupon_no': 'S546124$*%2343423534',
        //     'member_id': 1
        // });
    };

    function showCouponDialog(result) {       
        const {member, coupon} = result;
        isModalOpen = true; 
        
        // Show camera settings after successful QR scan
        stop();
        showCameraSettings();

        // Create the result HTML
        let resultHTML = `
            <div class="scan-result-item">
                <div class="member-info">
                    <h6 class="mb-2"><i class="fas fa-ticket-alt mr-2"></i>Coupon Information</h6>
                    <div class="row">
                        <div class="col-sm-6">
                            <strong>Username:</strong> ${member.username}<br>
                            <strong>Phone:</strong> ${member.phone_number}
                        </div>
                        <div class="col-sm-6">
                            <strong>Email:</strong> ${member.email}<br>
                            <strong>Coupon No:</strong> ${coupon.coupon_no}
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <strong>Shop:</strong> ${coupon.shop}
                        </div>
                        <div class="col-sm-6">
                            <strong>Status:</strong> `;
        
        if(coupon.status == 'valid') {
            resultHTML += `<span class="badge badge-success">Valid</span>`;
        } else if(coupon.status == 'used') {
            resultHTML += `<span class="badge badge-danger">Used</span>`;
        } else {
            resultHTML += `<span class="badge badge-dark">Expired</span>`;
        }
        
        resultHTML += `
                        </div>
                    </div>
                    <input type="hidden" id="couponId" value="${coupon.id}"/>
                </div>
                
                <div class="redeem-actions">
                    <button type="button" class="btn btn-primary" id='redeemButton'>
                        <i class="fas fa-gift mr-2"></i>Redeem Coupon
                    </button>
                    <button type="button" class="btn btn-secondary" id='clearButton'>
                        <i class="fas fa-times mr-2"></i>Clear
                    </button>
                </div>
            </div>
        `;
        
        // Update the scan result container
        $('#scanResultContainer').html(resultHTML);
    }

    // Event handlers for redeem and clear buttons (using event delegation)
    $(document).on('click', '#redeemButton', function(e) {
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
            // Clear the results after successful redemption
            clearScanResults();
        }
    });

    $(document).on('click', '#clearButton', function (e) {
        clearScanResults();
    });

    function clearScanResults() {
        isModalOpen = false;
        $('#scanResultContainer').html(`
            <div class="text-center text-muted py-5">
                <i class="fas fa-qrcode fa-3x mb-3"></i>
                <p>{{ __('No QR code scanned yet') }}</p>
                <small>{{ __('Point your camera at a QR code to scan') }}</small>
            </div>
        `);
        
        // Show camera settings after clearing results
        showCameraSettings();
    }
    
    // Function to show camera settings and hide camera preview
    function showCameraSettings() {
        $('#cameraControls').show().removeClass('hidden');
        $('#cameraPreview').hide().addClass('hidden');
    }
    
    // Function to show camera preview and hide camera settings
    function showCameraPreview() {
        $('#cameraControls').hide().addClass('hidden');
        $('#cameraPreview').show().removeClass('hidden');
    }

</script>
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>
<script src="{{ asset('argon') }}/js/custom/qr-scan.js"></script>
@endpush
@endsection