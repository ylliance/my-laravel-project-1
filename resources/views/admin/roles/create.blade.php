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
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header ">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('New Users') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('roles.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                        </div>
                    </div>
                </div>

               
                <div class="card-body">

                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="validationDefault01">{{__('Title:')}}</label>
                                    <input type="text" class="form-control" 
                                           name="title">
                                        @error('title')
                                        <div class="invalid-div">{{ $message }}</div>
                                        @enderror
                                </div>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="validationDefault03">{{__('Permissions:')}}</label>
                                    <select class="js-example-basic form-control" size="20" name="permissions[]"
                                        multiple="multiple">
                                        @foreach ($permissions as $per)

                                        <option value="{{$per['id']}}">{{$per['title']}}</option>
                                        @endforeach

                                    </select>
                                    @error('permissions')
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