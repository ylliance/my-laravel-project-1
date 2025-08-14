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
    </style>
@endpush
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header ">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Redeem Stamp') }}</h3>
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

<div class="modal fade dialogbox" id="stampsModal" data-bs-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Member STAMPS</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" id="memberId"/>
                <dl class="row mb-2">
                    <dt class="col-sm-4">Username: </dt>
                    <dd class="col-sm-8"><span id="mUsername"></span></dd>

                    <dt class="col-sm-4">Phone: </dt>
                    <dd class="col-sm-8"><span id="mPhone"></span></dd>

                    <dt class="col-sm-4">Email: </dt>
                    <dd class="col-sm-8"><span id="mEmail"></span></dd>

                    <dt class="col-sm-4">Stamp Count:</dt>
                    <dd class="col-sm-8"><span id="mStampCount"></span></dd>
                </dl>
                <div class='dropdown-divider pt-2'></div>
                <div id="mStamps" class="row pt-2">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id='redeemButton'>Redeem</button>
                <a href="#" class="btn btn-text-secondary" data-bs-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>

@push('page-script')
<script>
    let isModalOpen = false;
    const GET_MEMBER_STAMPS_URL =  "{{route('treasure.getMemberStamps')}}";
    const SET_STAMP_USED_URL =  "{{route('treasure.setStampUsed')}}";

    function getMemberStamps(userInfo) {
        if (isModalOpen)
            return;

        let result = null;
        $.ajax({
            url: GET_MEMBER_STAMPS_URL,
            headers: { 'X-CSRF-TOKEN': '{{csrf_token()}}' },
            type: 'post',
            data: userInfo,
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
            Toast_info_long.fire({
                title: 'Warning',
                text: 'Invalide Member QR Code. Please contact to super admin.',
                icon: 'warning'
            });
        }
        else {
            showUserStampDialog(result);
        }
    }

    const onQRCodeResultCallback = function(data) {
        if (data == null || data.trim() == "")
            return;
        
        try {
            const userInfo = JSON.parse(data);
            getMemberStamps(userInfo);
        } catch (error) {

        }

        getMemberStamps({
            uuid: 'eb0baac3-086b-3095-a292-822d4b4f91f4',          
        })
    };

    function showUserStampDialog(result) {       
        const {member, stamps} = result;
        isModalOpen = true; 

        $('#mUsername').text(member.username);
        $('#mPhone').text(member.phone_number);
        $('#mEmail').text(member.email);
        $('#mStampCount').text(stamps.length);
        $('#memberId').val(member.id);

        $stampDiv = $("#mStamps");
        $stampDiv.html('');
        
        stamps.forEach((stampInfo, index) => {
            let id = 'stamp-' + (index + 1);
            $stampDiv.append(`
                <div class="col-sm-6 border-b-1 py-3 stamp-info" id='${id}'>
                    <div id="mQRCode" class="w-128 h-128" />
                    <div class="ml-3">
                        <div>
                            <i class='fas fa-shopping-bag mr-2'/>
                            <span id="name"></span>
                        </div>
                        <div>
                            <i class='fas fa-address-card mr-2'/>
                            <span id="address"></span>
                        </div>
                        <div>
                            <i class='fas fa-mail-bulk mr-2'/>
                            <span id="email"></span>
                        </div>
                        <div>
                            <i class='fas fa-phone mr-2'/>
                            <span id="phone"></span>
                        </div>
                    </dl>
                </div>`
            );

            console.log(stampInfo.qr_code);
            const qr = new QRCode(document.querySelector(`#${id} #mQRCode`), {
                text: stampInfo.qr_code,
                width: 128,
                height: 128,
                colorDark: "#000",
                colorLight: "#fff",
                correctLevel: QRCode.CorrectLevel.M
            });

            $(`#${id} #name`).text(stampInfo.shop);
            $(`#${id} #address`).text(stampInfo.address);
            $(`#${id} #email`).text(stampInfo.email);
            $(`#${id} #phone`).text(stampInfo.phone_number);
        });
        $('#stampsModal').modal('show');
    }

    $('#stampsModal').on('hidden.bs.modal', function (e) {
        isModalOpen = false;
    });

    $('#redeemButton').on('click', function(e) {
        let member_id = $('#memberId').val();
        let result = null;
        $.ajax({
            url: SET_STAMP_USED_URL,
            headers: { 'X-CSRF-TOKEN': '{{csrf_token()}}' },
            type: 'post',
            data: {member_id},
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
            if (result.msg == 'no member')  {
                Toast_info_long.fire({
                    title: 'Warning',
                    text: 'Invalide Member QR Code. Please contact to super admin.',
                    icon: 'warning'
                });
            } else if (result.msg == 'need 6 stamps') {
                Toast_info_long.fire({
                    title: 'Warning',
                    text: 'Member needs to collect 6 stamps',
                    icon: 'warning'
                });
            } else if (result.msg == 'already redeem') {
                Toast_info_long.fire({
                    title: 'Warning',
                    text: 'He/She is a already redeemed',
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

</script>
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>
<script src="{{ asset('argon') }}/js/custom/qr-scan.js"></script>
@endpush
@endsection