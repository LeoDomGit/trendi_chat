@extends('layouts.app')

@section('content')


    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{trans('lang.subscription_edit')}}</h3>
            </div>

            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a
                                href="{!! route('subscriptions') !!}">{{trans('lang.subscriptions')}}</a>
                    </li>
                    <li class="breadcrumb-item active">{{trans('lang.subscription_edit')}}</li>
                </ol>
            </div>
        </div>


        <div class="container-fluid">


            <div class="card pb-4">

                <div class="card-body">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="post" action="{{ route('subscriptions.update',$subscription->id) }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row restaurant_payout_create">
                        
                            <div class="restaurant_payout_create-inner">

                                <fieldset>
                                    
                                    <legend>{{trans('lang.subscription_edit')}}</legend>
                                    
                                    <div class="form-group row width-50">
                                        <label class="col-3 control-label">{{trans('lang.subscription_name')}}</label>
                                        <div class="col-7">
                                            <input type="text" class="form-control" name="name" value="{{$subscription->name}}">
                                        </div>
                                    </div>

                                    <div class="form-group row width-50">
                                        <label class="col-3 control-label">{{trans('lang.subscription_description')}}</label>
                                        <div class="col-7">
                                            <input type="text" class="form-control" name="description" value="{{$subscription->description}}">
                                        </div>
                                    </div>

                                    <div class="form-group row width-100">
                                        <label class="col-3 control-label">{{trans('lang.subscription_android_subscription_key')}}</label>
                                        <div class="col-7">
                                            <input type="text" class="form-control" name="android_subscription_key" value="{{$subscription->android_subscription_key}}">
                                        </div>
                                    </div>

                                    <div class="form-group row width-100">
                                        <label class="col-3 control-label">{{trans('lang.subscription_ios_subscription_key')}}</label>
                                        <div class="col-7">
                                            <input type="text" class="form-control" name="ios_subscription_key" value="{{$subscription->ios_subscription_key}}">
                                        </div>
                                    </div>

                                    <div class="form-group row width-50">
                                        <label class="col-3 control-label">{{trans('lang.subscription_price')}}</label>
                                        <div class="col-7">
                                            <input type="text" class="form-control" name="price" value="{{$subscription->price}}">
                                        </div>
                                    </div>

                                    <div class="form-group row width-50">
                                        <label class="col-3 control-label">{{trans('lang.subscription_discount')}}</label>
                                        <div class="col-7">
                                            <input type="text" class="form-control" name="discount" value="{{$subscription->discount}}">
                                        </div>
                                    </div>
                                    
                                    <div class="form-check  width-50">
                                      @if ($subscription->status === "yes")
                                        <input type="checkbox" class="" name="status" id="status" checked="checked">
                                      @else
                                        <input type="checkbox" class="" name="status" id="status">
                                      @endif
                                        <label class="col-3 control-label" for="status">{{trans('lang.status')}}</label>
                                    </div>

                                </fieldset>

                            </div>
                        </div>

                        <div class="form-group col-12 text-center btm-btn">
                            <button type="submit" class="btn btn-primary  save_user_btn"><i class="fa fa-save"></i> {{ trans('lang.save')}}</button>
                            <a href="{!! route('subscriptions') !!}" class="btn btn-default"><i class="fa fa-undo"></i>{{ trans('lang.cancel')}}</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')

@endsection
