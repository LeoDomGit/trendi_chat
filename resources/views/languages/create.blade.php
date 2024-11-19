@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        
        <div class="row page-titles">
    
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{trans('lang.language_create')}}</h3>
            </div>

            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a href="{!! route('languages') !!}">{{trans('lang.languages')}}</a></li>
                    <li class="breadcrumb-item active">{{trans('lang.language_create')}}</li>
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
                            <form action="{{route('languages.store')}}" method="post" enctype="multipart/form-data" id="create_category">
                                @csrf

                                <div class="row restaurant_payout_create">
                                    <div class="restaurant_payout_create-inner">
                                        <fieldset>
                                            <legend>{{trans('lang.language_create')}}</legend>

                                            <div class="form-group row width-50">
                                                <label class="col-3 control-label">{{trans('lang.language_name')}}</label>
                                                <div class="col-7">
                                                    <input type="text" class="form-control name" name="name" value="{{Request::old('name')}}">
                                                </div>
                                            </div>

                                            <div class="form-group row width-50">
                                                <label class="col-3 control-label">{{trans('lang.language_code')}}</label>
                                                <div class="col-7">
                                                    <input type="text" class="form-control code" name="code" value="{{Request::old('code')}}">
                                                </div>
                                            </div>

                                            <div class="form-group row width-100">
                                                <label class="col-3 control-label">{{trans('lang.language_image')}}</label>
                                                <input type="file"  class="col-7" name="photo" onchange="readURL(this);">
                                                <div class="placeholder_img_thumb user_image"></div>
                                                <div id="image_preview" style="display: none; padding-left: 15px;">
                                                <img class="rounded" style="width:50px" id="uploding_image" src="#" alt="image">
                                                </div>
                                            </div>

                                            <div class="form-group row width-50">
                                                <div class="form-check">
                                                    <input type="checkbox" class="" name="status" id="status">
                                                    <label class="col-3 control-label" for="status">{{trans('lang.status')}}</label>
                                                </div>
                                            </div>

                                            <div class="form-group row width-50">
                                                <div class="form-check">
                                                    <input type="checkbox" class="" name="is_rtl" id="is_rtl">
                                                    <label class="col-3 control-label" for="is_rtl">{{trans('lang.language_isrtl')}}</label>
                                                </div>    
                                            </div>

                                        </fieldset>


                                        <div class="form-group col-12 text-center btm-btn">
                                            <button type="submit" class="btn btn-primary save_driver_btn"><i
                                                        class="fa fa-save"></i> {{ trans('lang.save')}}</button>
                                            <a href="{!! route('languages') !!}" class="btn btn-default"><i
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
            @section('scripts')
                <script>
                     function readURL(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                $('#image_preview').show();
                                $('#uploding_image').attr('src', e.target.result);
                             }   
                            reader.readAsDataURL(input.files[0]);
                        }
                     }
                </script>
               

@endsection
