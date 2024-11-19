@extends('layouts.app')

@section('content')


<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.category_edit')}}</h3>
        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href="{!! route('categories') !!}">{{trans('lang.category')}}</a>
                </li>
                <li class="breadcrumb-item active">{{trans('lang.category_edit')}}</li>
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

                <form method="post" action="{{ route('categories.update',$category->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row restaurant_payout_create">
                        <div class="restaurant_payout_create-inner">

                            <fieldset>

                                <legend>{{trans('lang.category_edit')}}</legend>

                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.category_name')}}</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control" name="name" value="{{$category->name}}">
                                        <div class="form-text text-muted">
                                            {{ trans("lang.category_name_help") }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.ordering')}}</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control name" name="ordering"
                                                value="{{$category->ordering}}">
                                        <div class="form-text text-muted">{{trans('lang.ordering_help')}}</div>
                                    </div>
                                </div>
                                
                                <div class="form-group row width-100">
                                    <label class="col-2 control-label">{{trans('lang.category_image')}}</label>
                                    <input type="file" class="col-6 photo" name="photo" onchange="readURL(this);">
                                    @if (file_exists(public_path('images/category'.'/'.$category->photo)) &&
                                    !empty($category->photo))
                                    <img class="rounded" id="uploding_image" style="width:50px"
                                        src="{{asset('images/category').'/'.$category->photo}}" alt="image">
                                    @else
                                    <img class="rounded" id="uploding_image" style="width:50px"
                                        src="{{asset('images/logo.png')}}" alt="image">
                                    @endif

                                </div>
                                <div class="form-check  width-50">
                                    @if ($category->status === "yes")
                                    <input type="checkbox" class="user_active" name="status" id="user_active"
                                        checked="checked">
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
                        <button type="submit" class="btn btn-primary  save_user_btn"><i class="fa fa-save"></i>
                            {{ trans('lang.save')}}</button>
                        <a href="{!! route('categories') !!}" class="btn btn-default"><i
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
function readURL(input) {
    console.log(input.files);
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#uploding_image').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection