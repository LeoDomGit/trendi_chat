@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.limit_settings')}}</h3>
        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.limit_settings')}}</li>
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

                        <div class="limit-alert">
                            <p>{{trans('lang.limit_alert')}}</p>
                        </div>
                            
                        <form action="{{route('settings.update.limit',['id'=>$settings->id])}}" method="post"  enctype="multipart/form-data" id="limitform">
						
                        @csrf

                            <div class="row restaurant_payout_create">
                                <div class="restaurant_payout_create-inner">
                                    <fieldset>
                                        <legend>{{trans('lang.limit_settings')}}</legend>

                                        <div class="form-group row width-50">
                                            <label class="col-3 control-label">{{trans('lang.writer_limit')}}</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control" name="writer_limit" value="{{ $settings->writer_limit }}">
                                            </div>
                                        </div>

                                        <div class="form-group row width-50">
                                            <label class="col-3 control-label">{{trans('lang.chat_limit')}}</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control" name="chat_limit" value="{{ $settings->chat_limit }}">
                                            </div>
                                        </div>

                                        <div class="form-group row width-50">
                                            <label class="col-3 control-label">{{trans('lang.image_limit')}}</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control" name="image_limit" value="{{ $settings->image_limit }}">
                                            </div>
                                        </div>
                                        <div class="form-group row width-50">
                                            <label class="col-3 control-label">{{trans('lang.refferal_limit')}}</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control" name="reffered_limit" value="{{ $settings->reffered_limit }}">
                                            </div>
                                        </div>

                                    </fieldset>
                                
                                </div>
                            </div>

                            <div class="form-group col-12 text-center btm-btn">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans('lang.save')}}</button>
                            </div>

						</form>
	
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection

    @section('scripts')

    <script type="text/javascript">

        $("#limitform").on("submit",function (e) {
            if (confirm("{{trans('lang.limit_alert')}}")) {
                return true;
            }else{
                return false;
            }
        });

    </script>  

    @endsection
