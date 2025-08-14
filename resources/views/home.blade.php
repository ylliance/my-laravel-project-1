@extends('layouts.app')

@section('content')
@include('layouts.headers.header',
array(
'class'=>'info',
'title'=>"Members",'description'=>'',
'icon'=>'fas fa-home',
'breadcrumb'=>array([
'text'=>'Member List'
])))
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">{{ __('Home') }}</h3>
                </div>

                <div class="card-body">
                    <p>Welcome to the website! This application provides tools to manage roles, users, members and coupons.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
