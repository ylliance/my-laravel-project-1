@extends('layouts.app')

@section('content')
@include('layouts.headers.header',
array(
'class'=>'info',
'title'=>"Members",'description'=>'',
'icon'=>'fas fa-home',
'breadcrumb'=>array([
'text'=>'Member',
'text'=>'New Member',
])))
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header ">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Edit Member Detail') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('members.index') }}"
                                class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('members.update', $member->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="validationDefault01">{{__('Username:')}}</label>
                                    <input type="text" name="username" value="{{ old('username', $member->username) }}"
                                        class="form-control  @error('username') invalid-input @enderror"
                                        placeholder="{{__('Please Enter Username')}}" autofocus required>
                                    @error('username')
                                    <div class="invalid-div">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="validationDefault01">{{__('Email:')}}</label>
                                    <input type="email" name="email" value="{{ old('email', $member->email) }}"
                                        class="form-control  @error('email') invalid-input @enderror" placeholder="{{__('Please Enter Email')}}" required>
                                    @error('email')
                                    <div class="invalid-div">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="validationDefault01">{{__('Phone Number:')}}</label>
                                    <input type="text" name="phone_number" value="{{ old('phone_number', $member->phone_number) }}"
                                        class="form-control  @error('phone_number') invalid-input @enderror" placeholder="{{__('Please Enter Phone Number')}}" required>
                                    @error('phone_number')
                                    <div class="invalid-div">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">{{__('Update')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
