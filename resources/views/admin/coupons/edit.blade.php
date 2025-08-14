@extends('layouts.app')

@section('content')
@include('layouts.headers.header',
array(
'class'=>'info',
'title'=>"Coupons",'description'=>'',
'icon'=>'fas fa-home',
'breadcrumb'=>array([
'text'=>'Coupon',
'text'=>'New Coupon',
])))
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header ">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Edit Coupon Detail') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('coupons.index') }}"
                                class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('coupons.update', $coupon->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="validationDefault01">{{__('Coupon Number:')}}</label>
                                    <input type="text" name="coupon_no" value="{{ old('coupon_no', $coupon->coupon_no) }}"
                                        class="form-control  @error('coupon_no') invalid-input @enderror"
                                        placeholder="{{__('Please Enter Coupon Number')}}" autofocus required>

                                    @error('coupon_no')
                                    <div class="invalid-div">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="validationDefault01">{{__('Shop:')}}</label>
                                    <input type="text" name="shop" value="{{ old('shop', $coupon->shop) }}"
                                        class="form-control  @error('shop') invalid-input @enderror"
                                        placeholder="{{__('Please Enter Shop')}}" autofocus required>

                                    @error('shop')
                                    <div class="invalid-div">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="validationDefault01">{{__('Type:')}}</label>
                                    <input type="text" name="type" value="{{ old('type', $coupon->type) }}"
                                        class="form-control  @error('type') invalid-input @enderror"
                                        placeholder="{{__('Please Select Type')}}" autofocus required>

                                    @error('type')
                                    <div class="invalid-div">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="validationDefault01">{{__('Value:')}}</label>
                                    <input type="text" name="value" value="{{ old('value', $coupon->value) }}"
                                        class="form-control  @error('value') invalid-input @enderror"
                                        placeholder="{{__('Please Enter Value')}}" autofocus required>

                                    @error('value')
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
