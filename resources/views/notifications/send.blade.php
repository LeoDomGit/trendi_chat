@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        
        <div class="row page-titles">
    
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{trans('lang.notifications_send')}}</h3>
            </div>

            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a href="{!! route('categories') !!}">{{trans('lang.notifications')}}</a></li>
                    <li class="breadcrumb-item active">{{trans('lang.notifications_send')}}</li>
                </ol>
            </div>
            
        </div>


        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
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
                           <form action="{{route('notifications.send')}}" method="post">
                                @csrf 

                                <div class="row restaurant_payout_create">
                                    <div class="restaurant_payout_create-inner">
                                        <fieldset>
                                            <legend>{{trans('lang.notifications_send')}}</legend>

                                            <div class="form-group row width-100">
                                                <label class="col-3 control-label">{{trans('lang.notification_title')}}</label>
                                                <div class="col-7">

                                                    <input type="text" class="form-control title" id="title" name="title">
                                                </div>
                                            </div>

                                            <div class="form-group row width-100">
                                                <label class="col-3 control-label">{{trans('lang.notification_message')}}</label>
                                                <div class="col-7">
                                                    <textarea name="message" class="form-control message" id="message" cols="30" rows="10">{{Request::old('message')}}</textarea>
                                                    
                                                </div>
                                            </div>

                                        
                                            <div class="form-check  width-100">
                                                <input type="checkbox" class="" name="send_to[]" id="login_user" value="login">
                                                <label class="col-3 control-label" for="login_user">{{trans('lang.login_user')}}</label>

                                                <input type="checkbox" class="" name="send_to[]" id="guest_user" value="without_login">
                                                <label class="col-3 control-label" for="guest_user">{{trans('lang.without_login')}}</label>
                                            </div>



                                        </fieldset>


                                        <div class="form-group col-12 text-center btm-btn">
                                            <button type="submit" class="btn btn-primary save_driver_btn"><i
                                                        class="fa fa-send"></i> {{ trans('lang.send')}}</button>
                                            <a href="{!! route('notifications') !!}" class="btn btn-default"><i
                                                        class="fa fa-undo"></i>{{ trans('lang.cancel')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @endsection
    