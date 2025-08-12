@extends('layouts.app')

@section('content')
@include('layouts.headers.header',
array(
'class'=>'info',
'title'=>"Member",'description'=>'',
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
                            <h3 class="mb-0">{{ __('New Member Detail') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('members.index') }}"
                                class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <form action="{{ route('members.store') }}" method="POST" id="create-member">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="name">{{__('Name:')}}</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}"
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
                                            <input name="gender" class="custom-control-input" id="gender_male" type="radio" value="1" checked>
                                            <label class="custom-control-label" for="gender_male">Male</label>
                                        </div>
                                        <div class="custom-control custom-radio ml-4">
                                            <input name="gender" class="custom-control-input" id="gender_female" type="radio" value="2">
                                            <label class="custom-control-label" for="gender_female">Female</label>
                                        </div>
                                        <div class="custom-control custom-radio ml-4">
                                            <input name="gender" class="custom-control-input" id="gender_both" type="radio" value="0">
                                            <label class="custom-control-label" for="gender_both">No define</label>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="boss_id">{{__('Boss ID:')}}</label>
                                    <input type="text" id="boss_id" name="boss_id" value="{{ old('boss_id') }}"
                                        class="form-control  @error('boss_id') invalid-input @enderror"
                                        placeholder="{{__('Please Enter Boss ID')}}" required>

                                    @error('boss_id')
                                    <div class="invalid-div">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="password">{{__('Password:')}}</label>
                                    <input type="text" id="password" name="password" value="{{ old('password') }}"
                                        class="form-control  @error('password') invalid-input @enderror"
                                        placeholder="{{__('Please Enter password')}}" required>

                                    @error('password')
                                    <div class="invalid-div">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <button class="btn btn-primary" type="submit" id="smbtBtn">{{__('Submit')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('page-script')

<style>
    .icon{
        margin-right:5px;
        display: none;
    }
    .loading{
        color:#eee;
    }
    .loading .icon{
        display: inline-block;
        color:#eee;
        animation: spin 2s linear infinite;
    }
    @keyframes spin {
        
        0%{
            transform: rotate(0deg);
        }sbm
        100%{
            transform: rotate(360deg);
        }
    }
</style>

<script type="text/javascript" src="{{ asset('argon') }}/vendor/jquery-print/jquery.print.min.js" ></script>
<script>
var form = document.getElementById("create-member");

$('#smbtBtn').on('click', function() {
    form.submit();
    $(this).prop('disabled', true);
    $(this).addClass('loading');
    this.innerHTML = "Loading...";
});

</script>
@endpush