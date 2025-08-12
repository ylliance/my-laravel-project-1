@extends('layouts.app')

@section('content')
@include('layouts.headers.header',
array(
'class'=>'info',
'title'=>"Roles",'description'=>'',
'icon'=>'fas fa-home',
'breadcrumb'=>array([
'text'=>'User',
'text'=>'New User',
])))
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header ">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('New User Detail') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('users.index') }}"
                                class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                        </div>
                    </div>
                </div>


                <div class="card-body">

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="validationDefault01">{{__('Name:')}}</label>
                                    <input type="text" name="name" value="{{ old('name') }}"
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
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control  @error('email') invalid-input @enderror" placeholder="{{__('Please Enter Email')}}" required>
                                    
                                    @error('email')
                                    <div class="invalid-div">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="validationDefault01">{{__('Password:')}}</label>
                                  <input type="password" name="password" value="{{ old('password') }}"
                                        class="form-control  @error('password') invalid-input @enderror" placeholder="{{__('Please Enter Password')}}"
                                        min="6" required>
                                    
                                    @error('password')
                                    <div class="invalid-div">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="validationDefault01">{{__('IP Address:')}}</label>
                                  <input type="text" name="ip_address" value="{{ old('ip_address') }}"
                                        class="form-control  @error('ip_address') invalid-input @enderror" placeholder="{{__('Please Enter IP Address')}}"
                                        required>
                                    
                                    @error('ip_address')
                                    <div class="invalid-div">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="validationDefault01">{{__('Roles:')}}</label>
                                    <select class="js-example-basic form-control" name="roles[]" multiple="multiple">
                                            @foreach ($roles as $role)
                                        
                                            <option value="{{$role['id']}}">{{$role['title']}}</option>
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