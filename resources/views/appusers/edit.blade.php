@extends('layouts.app')

@section('content')

<div class="page-wrapper">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.edit_app_users')}}</h3>
        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item"><a
                            href="{!! route('appusers') !!}">{{trans('lang.app_users')}}</a>
                </li>
                <li class="breadcrumb-item active">{{trans('lang.edit_app_users')}}</li>
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
                
                <form method="post" action="{{ route('appusers.update',$appuser->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row restaurant_payout_create">
                        
                        <div class="restaurant_payout_create-inner">

                            <fieldset>
                                
                                <legend>{{trans('lang.edit_app_users')}}</legend>
                                
                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.name')}}</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control" name="name" value="{{$appuser->name}}">
                                        
                                    </div>
                                </div>
                                
                                {{--<div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.phone')}}</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control" name="phone" value="{{$appuser->phone}}">
                                        
                                    </div>
                                </div>--}}

                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.email')}}</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control" name="email" value="{{$appuser->email}}">
                                        
                                    </div>
                                </div>
                                
                                <div class="form-group row width-100">
                                    <label class="col-2 control-label">{{trans('lang.photo')}}</label>
                                    <input type="file" class="col-6 photo" name="photo" onchange="readURL(this);">
                                    @if (file_exists(public_path('images/users'.'/'.$appuser->photo)) &&
                                    !empty($appuser->photo))
                                    <img class="rounded" id="uploding_image" style="width:50px"
                                        src="{{asset('images/users').'/'.$appuser->photo}}" alt="image">
                                    @else
                                    <img class="rounded" id="uploding_image" style="width:50px"
                                        src="{{asset('images/default_user.png')}}" alt="image">
                                    @endif

                                </div>

                                <div class="form-check  width-50">
                                    @if ($appuser->status === "yes")
                                    <input type="checkbox" class="user_active" name="status" id="user_active" checked="checked">
                                    @else
                                    <input type="checkbox" class="user_active" name="status" id="user_active">
                                    @endif
                                    <label class="col-3 control-label" for="user_active">{{trans('lang.status')}}</label>
                                </div>
                                
                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.writer_limit')}}</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control" name="writer_limit" value="{{$appuser->writer_limit}}">
                                    </div>
                                </div>

                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.chat_limit')}}</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control" name="chat_limit" value="{{$appuser->chat_limit}}">
                                        
                                    </div>
                                </div>
                                
                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.image_limit')}}</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control" name="image_limit" value="{{$appuser->image_limit}}">
                                        
                                    </div>
                                </div>

                            </fieldset>

                            <fieldset>
                                <legend>{{trans('lang.active_subscription')}}</legend>
                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">
                                        {{$appuser->subscription_name ? : trans('lang.no_active_subscription') }}
                                    </label>
                                </div>
                            </fieldset>   
                            
                             <fieldset>
                                <legend>{{trans('lang.reset_password')}}</legend>
                                <div class="form-group row width-50 password-type">
                                    <label class="col-3 control-label">{{trans('lang.new_password')}}</label>
                                    <div class="col-7">
                                        <input type="password" class="form-control" name="password" value="">
                                        <span><i class="fa fa-eye-slash eye-icon"></i></span>
                                    </div>
                                </div>
                                <div class="form-group row width-50 password-type">
                                    <label class="col-3 control-label">{{trans('lang.confirm_password')}}</label>
                                    <div class="col-7">
                                        <input type="password" class="form-control" name="confirm_password" value="">
                                        <span><i class="fa fa-eye-slash eye-icon"></i></span>
                                    </div>
                                </div>
                            </fieldset>   

                        </div>
                    </div>

                    <div class="form-group col-12 text-center btm-btn">
                        <button type="submit" class="btn btn-primary  save_user_btn"><i class="fa fa-save"></i> {{ trans('lang.save')}}</button>
                        <a href="{!! route('appusers') !!}" class="btn btn-default"><i class="fa fa-undo"></i>{{ trans('lang.cancel')}}</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

</div>

@endsection

<style>
    .password-type span{
        position: absolute;
        right: 22px;
        top: 7px;
        width: 16px;
        cursor: pointer;
    }
</style>    

@section('scripts')

<script type="text/javascript">

    function readURL(input) {
        
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#uploding_image').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(".eye-icon").click(function(){
        $(this).toggleClass('fa-eye fa-eye-slash');
        if($(this).hasClass('fa-eye')){
            $(this).parent().prev().attr('type','text');
        }else{
            $(this).parent().prev().attr('type','password');
        }
    });

</script>

@endsection
