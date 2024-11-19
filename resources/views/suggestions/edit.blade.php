@extends('layouts.app')

@section('content')


    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{trans('lang.suggestion_edit')}}</h3>
            </div>

            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a
                                href="{!! route('suggestions') !!}">{{trans('lang.suggestions')}}</a>
                    </li>
                    <li class="breadcrumb-item active">{{trans('lang.suggestion_edit')}}</li>
                </ol>
            </div>
        </div>


        <div class="container-fluid">


            <div class="card pb-4">

                <div class="card-body">

                    <div class="limit-alert">
                        <p>{{trans('lang.suggestion_highlight_alert')}}</p>
                        <p>{{trans('lang.suggestion_highlight_alert_desc')}}</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="post" action="{{ route('suggestions.update',$suggestion->id) }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row restaurant_payout_create">
                            <div class="restaurant_payout_create-inner">

                                <fieldset>
                                    
                                    <legend>{{trans('lang.suggestion_edit')}}</legend>
                                    
                                    <div class="form-group row  width-100">
                                        <label class="col-3 control-label" for="user_active">{{trans('lang.category')}}</label>
                                        <div class="col-7">
                                        
                                            <select name="category_id"  class="form-control">
                                            <option>{{trans('lang.select_category')}}</option>
                                            @foreach($categories as $category)
                                            <option  value="{{ $category->id }}" {{$suggestion->category_id== $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>

                                    <div class="form-group row width-100">
                                        <label class="col-3 control-label">{{trans('lang.suggestion')}}</label>
                                        <div class="col-7">
                                            <textarea class="form-control name" id="name" name="name" rows="4" cols="50">{{$suggestion->name}}</textarea>      
                                        </div>
                                    </div>
                                    
                                    <div class="form-check  width-50">
                                      @if ($suggestion->status === "yes")
                                      <input type="checkbox" class="user_active" name="status" id="user_active" checked="checked">
                                      @else
                                      <input type="checkbox" class="user_active" name="status" id="user_active">
                                      @endif
                                        <label class="col-3 control-label"
                                               for="user_active">{{trans('lang.status')}}</label>
                                    </div>

                                </fieldset>


                            </div>
                        </div>

                        <div class="form-group col-12 text-center btm-btn">
                            <button type="submit" class="btn btn-primary  save_user_btn"><i
                                        class="fa fa-save"></i> {{ trans('lang.save')}}</button>
                            <a href="{!! route('suggestions') !!}" class="btn btn-default"><i
                                        class="fa fa-undo"></i>{{ trans('lang.cancel')}}</a>
                        </div>


                    </form>
                </div>
            </div>
        </div>


    </div>



@endsection

@section('scripts')
    <script>
    </script>

@endsection
