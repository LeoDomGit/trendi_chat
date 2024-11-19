@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.general_settings')}}</h3>
        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.general_settings')}}</li>
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

                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                            
                        <form action="{{route('settings.update.general',['id'=>$settings->id])}}" method="post"  enctype="multipart/form-data">
						
                        @csrf

                            <div class="row restaurant_payout_create">
                                <div class="restaurant_payout_create-inner">
                                    <fieldset>
                                        <legend>{{trans('lang.api_settings')}}</legend>

                                        <div class="form-group row width-100">
                                            <label class="col-3 control-label">{{trans('lang.apikey_android_revenuecat')}}</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control" name="apikey_android_revenuecat" value="{{ $settings->apikey_android_revenuecat }}">
                                            </div>
                                        </div>

                                        <div class="form-group row width-100">
                                            <label class="col-3 control-label">{{trans('lang.apikey_ios_revenuecat')}}</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control" name="apikey_ios_revenuecat" value="{{ $settings->apikey_ios_revenuecat }}">
                                            </div>
                                        </div>

                                        <div class="form-group row width-100">
                                            <label class="col-3 control-label">{{trans('lang.openai_api_key')}}</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control" name="openai_api_key" value="{{ $settings->openai_api_key }}">
                                            </div>
                                        </div>

                                        <div class="form-group width-100 choose-theme">
                                            <label class="col-12 control-label">{{trans('lang.app_homepage_theme')}}</label>
                                            <div class="col-12">
                                                <div class="select-theme-radio">
                                                    <label class="form-check-label" for="app_homepage_theme_1">
                                                        <input type="radio" class="btn-check" name="app_homepage_theme" id="app_homepage_theme_1" value="theme_1" {{ $settings->app_homepage_theme == "theme_1" ? "checked" : "" }}>
                                                        <img src="{{url('images/app_homepage_theme_1.png')}}" height="150">
                                                    </label>
                                                    <label class="form-check-label" for="app_homepage_theme_2">
                                                        <input type="radio" class="btn-check" name="app_homepage_theme" id="app_homepage_theme_2" value="theme_2" {{ $settings->app_homepage_theme == "theme_2" ? "checked" : "" }}>
                                                        <img src="{{url('images/app_homepage_theme_2.png')}}" height="150">    
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row width-50">
                                            <label class="col-3 control-label">{{trans('lang.model_type')}}</label>
                                            <div class="col-7">
                                                <select name="model_type" class="form-control">
                                                    <option value="gpt-4o-mini" {{ $settings->model_type ==  "gpt-4o-mini" ? 'selected' : '' }}>{{trans('lang.gpt_4o_mini')}}</option>
                                                    <option value="gpt-4o-mini-2024-07-18" {{ $settings->model_type ==  "gpt-4o-mini-2024-07-18" ? 'selected' : '' }}>{{trans('lang.gpt_4o_mini_release')}}</option>
                                            </select>
                                            </div>
                                        </div>
                                        
                                    </fieldset>

                                    <fieldset>
                                        <legend>{{trans('lang.ads_settings')}}</legend>

                                        <div class="form-check  width-50">
                                            @if ($settings->add_is_enabled === "yes")
                                                <input type="checkbox" class="" name="add_is_enabled" id="add_is_enabled" checked="checked">
                                            @else
                                                <input type="checkbox" class="" name="add_is_enabled" id="add_is_enabled">
                                            @endif
                                            <label class="col-3 control-label" for="add_is_enabled">{{trans('lang.add_is_enabled')}}</label>
                                        </div>

                                        <div class="form-group row width-50">
                                            <label class="col-3 control-label">{{trans('lang.android_app_id')}}</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control" name="android_app_id" value="{{ $settings->android_app_id }}">
                                            </div>
                                        </div>

                                        <div class="form-group row width-50">
                                            <label class="col-3 control-label">{{trans('lang.ios_app_id')}}</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control" name="ios_app_id" value="{{ $settings->ios_app_id }}">
                                            </div>
                                        </div>

                                        <div class="form-group row width-50">
                                            <label class="col-3 control-label">{{trans('lang.android_banner_id')}}</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control" name="android_banner_id" value="{{ $settings->android_banner_id }}">
                                            </div>
                                        </div>

                                        <div class="form-group row width-50">
                                            <label class="col-3 control-label">{{trans('lang.ios_banner_id')}}</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control" name="ios_banner_id" value="{{ $settings->ios_banner_id }}">
                                            </div>
                                        </div>

                                        <div class="form-group row width-50">
                                            <label class="col-3 control-label">{{trans('lang.android_interstitial_id')}}</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control" name="android_interstitial_id" value="{{ $settings->android_interstitial_id }}">
                                            </div>
                                        </div>

                                        <div class="form-group row width-50">
                                            <label class="col-3 control-label">{{trans('lang.ios_interstitial_id')}}</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control" name="ios_interstitial_id" value="{{ $settings->ios_interstitial_id }}">
                                            </div>
                                        </div>

                                        <div class="form-group row width-50">
                                            <label class="col-3 control-label">{{trans('lang.android_reward_ads_id')}}</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control" name="android_reward_ads_id" value="{{ $settings->android_reward_ads_id }}">
                                            </div>
                                        </div>

                                        <div class="form-group row width-50">
                                            <label class="col-3 control-label">{{trans('lang.ios_reward_ads_id')}}</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control" name="ios_reward_ads_id" value="{{ $settings->ios_reward_ads_id }}">
                                            </div>
                                        </div>

                                    </fieldset>

                                    <fieldset>
                                        <legend>{{trans('lang.rewards_settings')}}</legend>

                                        <div class="form-group row width-50">
                                            <label class="col-3 control-label">{{trans('lang.writer_limit')}}</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control" name="ads_writer_limit" value="{{ $settings->ads_writer_limit }}">
                                            </div>
                                        </div>

                                        <div class="form-group row width-50">
                                            <label class="col-3 control-label">{{trans('lang.chat_limit')}}</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control" name="ads_chat_limit" value="{{ $settings->ads_chat_limit }}">
                                            </div>
                                        </div>

                                        <div class="form-group row width-50">
                                            <label class="col-3 control-label">{{trans('lang.image_limit')}}</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control" name="ads_image_limit" value="{{ $settings->ads_image_limit }}">
                                            </div>
                                        </div>

                                    </fieldset>

                                    <fieldset>
                                        
                                        <legend>{{trans('lang.support_settings')}}</legend>
                                        
                                        <div class="form-group row width-50">
                                            <label class="col-3 control-label">{{trans('lang.support_email')}}</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control" name="support_email" value="{{ $settings->support_email }}">
                                            </div>
                                        </div>

                                        <div class="form-group row width-50">
                                            <label class="col-3 control-label">{{trans('lang.app_version')}}</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control" name="app_version" value="{{ $settings->app_version }}">
                                            </div>
                                        </div>

                                        <div class="form-group row width-100">
                                            <label class="col-3 control-label">{{trans('lang.privacy_policy')}}</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control" name="privacy_policy" value="{{ $settings->privacy_policy }}">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row width-100">
                                            <label class="col-3 control-label">{{trans('lang.terms_and_conditions')}}</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control" name="terms_and_conditions" value="{{ $settings->terms_and_conditions }}">
                                            </div>
                                        </div>

                                        <div class="form-group row width-100">
                                            <label class="col-3 control-label">{{trans('lang.faq')}}</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control" name="faq" value="{{ $settings->faq }}">
                                            </div>
                                        </div>

                                    </fieldset>    
                                </div>
                            </div>

                            <div class="form-group col-12 text-center btm-btn">
                                <button type="submit" class="btn btn-primary  create_user_btn"><i class="fa fa-save"></i> {{ trans('lang.save')}}</button>
                            </div>

						</form>
	
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="themeModal" tabindex="-1" role="dialog" aria-labelledby="themeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 50%;">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group">
                        <img id="themeImage" src="" width="630">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection

    @section('scripts')

    <script>

        var theme_1_url = '{!! url("images/app_homepage_theme_1.png"); !!}';
        var theme_2_url = '{!! url("images/app_homepage_theme_2.png"); !!}';

        $(".form-group input[name='app_homepage_theme']").click(function () {
            if ($(this).is(':checked')) {
                var modal = $('#themeModal');
                if ($(this).val() == "theme_1") {
                    modal.find('#themeImage').attr('src',theme_1_url);
                } else {
                    modal.find('#themeImage').attr('src',theme_2_url);
                }
                $('#themeModal').modal('show');
            }
        }); 

        $('#themeModal').on('hide.bs.modal', function (event) {
            var modal = $(this);
            modal.find('#themeImage').attr('src','');
        });

    </script>

    @endsection
