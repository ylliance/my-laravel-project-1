@extends('layouts.app')

@section('content')
@include('layouts.headers.header',
array(
'class'=>'info',
'title'=>"Members",'description'=>'',
'icon'=>'fas fa-home',
'breadcrumb'=>array([
'text'=>'Members',
'text'=>'Edit Member'
])))
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header ">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Edit Member') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('members.index') }}"
                                class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route("members.update", [$member->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="name">{{__('Name:')}}</label>
                                    <input type="text" id="name" name="name" value="{{ old('name',$member->name) }}"
                                        class="form-control  @error('name') invalid-input @enderror"
                                        placeholder="{{__('Please Enter Name')}}" autofocus required>

                                    @error('name')
                                    <div class="invalid-div">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('Gender:')}}</label>
                                    <div class="d-flex mt-2">
                                        <div class="custom-control custom-radio">
                                            <input name="gender" class="custom-control-input" id="gender_male" type="radio" value="1" {{ $member->gender == 1 ? 'checked' : ''}} />
                                            <label class="custom-control-label" for="gender_male">Male</label>
                                        </div>
                                        <div class="custom-control custom-radio ml-4">
                                            <input name="gender" class="custom-control-input" id="gender_female" type="radio" value="2" {{ $member->gender == 2 ? 'checked' : ''}} />
                                            <label class="custom-control-label" for="gender_female">Female</label>
                                        </div>
                                        <div class="custom-control custom-radio ml-4">
                                            <input name="gender" class="custom-control-input" id="gender_both" type="radio" value="0" {{ $member->gender == 0 ? 'checked' : ''}}>
                                            <label class="custom-control-label" for="gender_both">No define</label>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="boss_id">{{__('Boss ID:')}}</label>
                                    <input type="text" id="boss_id" name="boss_id" value="{{ old('boss_id', $member->boss_id) }}"
                                        class="form-control  @error('boss_id') invalid-input @enderror"
                                        placeholder="{{__('Please Enter Boss ID')}}" required readonly>

                                    @error('boss_id')
                                    <div class="invalid-div">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="reset_password">{{__('Reset Password:')}}</label>
                                    <div class="input-group mb-3">
                                        <input type="text" id="reset_password" class="form-control" placeholder="{{__('New Password')}}" />
                                        <input type="hidden" id="reset_password_id" value="{{$member->id}}" />
                                        <div class="input-group-append">
                                          <button class="btn btn-outline-primary" type="button" onclick="generatePassword()"><i class="fas fa-circle-notch"></i></button>
                                          <button class="btn btn-primary" type="button" onclick="updatePassword()">Update</button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                        </div>

                        <button class="btn btn-primary" type="submit">{{__('Submit')}}</button>
                    </form>
                </div>
            </div>
           
        </div>
    </div>
</div>
@endsection

@push('page-script')
<script>

    const Swal_Confirm = Swal.mixin({
        icon: 'question',
        confirmButtonText: 'Yes',
        showCancelButton: true,
    });

    function generatePassword() {
        var minm = 100000;
        var maxm = 999999;
        var password = Math.floor(Math.random() * (maxm - minm + 1)) + minm;

        $('#reset_password').val(password);
    }

    var API_UPDATE_PASSWORD = "{{route('member.password.update')}}";
    function updatePassword() {

        Swal_Confirm.fire({
                title: `Are you sure?`,
                text: `Do you want to update the password?`,
        }).then(data => {
            if(data?.isConfirmed) {
                $.ajax({
                    url: API_UPDATE_PASSWORD,
                    type: 'post',
                    data: {
                        id: $('#reset_password_id').val(),
                        password: $('#reset_password').val(),
                        '_token': $("meta[name='csrf-token']").attr("content")
                    },
                    success: function(res) {
                        Swal.fire(
                            'Success',
                            res.msg,
                            'success'
                        );
                    },
                    error: function(res) {
                        var msg = res.responseJSON.msg || 'Oops, Something went wrong.';
                        alert(msg);
                    }
                })
            }
        });
        
    }

</script>
@endpush