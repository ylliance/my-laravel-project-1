@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
@include('layouts.headers.member')

<div class="container mt--8 pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card bg-secondary shadow border-0">
                <div class="card-body px-lg-5 py-lg-5">
                    <div class="text-center  mb-4">
                        <h2>
                            {{ __('Enter Your Info Here:') }}
                        </h2>
                    </div>
                    <form role="form" method="POST" action="{{ route('front.login') }}">
                        @csrf

                        <div class="form-group basic {{ $errors->has('boss_id') ? ' has-danger' : '' }}">
                            <div class="input-wrapper">
                                <label class="label" for="boss_id">Boss ID</label>
                                <input type="text" class="form-control {{ $errors->has('boss_id') ? ' is-invalid' : '' }}" 
                                    id="boss_id" placeholder="{{ __('boss_id') }}" name="boss_id" value="{{ old('boss_id') }}" required autofocus>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                                @if ($errors->has('boss_id'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('boss_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group basic {{ $errors->has('password') ? ' has-danger' : '' }}">
                            <div class="input-wrapper">
                                <label class="label" for="password">Password</label>
                                <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" autocomplete="off"
                                    placeholder="Your password" name="password">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                                @if ($errors->has('password'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-links mt-2">
                            <div><a href="app-forgot-password.html" class="text-muted">Forgot Password?</a></div>
                        </div>

                        <div class="form-button-group  transparent">
                            <button type="submit" class="btn btn-primary2 btn-block btn-lg">Log in</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-6">
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-light">
                        <small>{{ __('Forgot password?') }}</small>
                    </a>
                    @endif
                </div>
        
            </div>
        </div>
    </div>
</div>
@endsection