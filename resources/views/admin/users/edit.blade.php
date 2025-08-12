@extends('layouts.app')

@section('content')
@include('layouts.headers.header',
array(
'class'=>'info',
'title'=>"Users",'description'=>'',
'icon'=>'fas fa-home',
'breadcrumb'=>array([
'text'=>'Users',
'text'=>'Edit User'
])))
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header ">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Edit User') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('users.index') }}"
                                class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <form action="{{ route("users.update", [$user->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="validationDefault01">{{__('Name:')}}</label>
                                    <input type="text" name="name" value="{{ old('name',$user->name) }}"
                                        class="form-control  @error('name') invalid-input @enderror"
                                        placeholder="{{__('Please Enter Name')}}" autofocus required>

                                    @error('name')
                                    <div class="invalid-div">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="validationDefault01">{{__('Email:')}}</label>
                                    <input type="email" name="email" value="{{ old('email',$user->email) }}"
                                        class="form-control  @error('email') invalid-input @enderror"
                                        placeholder="{{__('Please Enter Email')}}" readonly>

                                    @error('email')
                                    <div class="invalid-div">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="validationDefault01">{{__('IP Address:')}}</label>
                                    <input type="text" name="ip_address" value="{{ old('ip_address',$user->ip_address) }}"
                                        class="form-control  @error('ip_address') invalid-input @enderror"
                                        placeholder="{{__('Please Enter IP Address')}}">

                                    @error('ip_address')
                                    <div class="invalid-div">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="validationDefault01">{{__('Roles:')}}</label>
                                    <select class="js-example-basic form-control" name="roles[]" multiple="multiple">


                                        @foreach($roles as $roles)
                                        <option value="{{ $roles->id }}"
                                            {{ (in_array($roles->id, old('roles', [])) || isset($user) && $user->roles->contains($roles->id)) ? 'selected' : '' }}>
                                            {{ $roles->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('roles')
                                    <div class="invalid-div">{{ $message }}</div>
                                    @enderror
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
