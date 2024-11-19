@extends('layouts.app')

@section('content')

<div class="page-wrapper">
	
	<div class="row page-titles">
		
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor">{{trans('lang.landing_page')}}</h3>
		</div>

		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a>
				</li>
				<li class="breadcrumb-item active">
					{{trans('lang.landing_page')}}
				</li>
			</ol>
		</div>
	</div>

	<div class="row">
		
		<div class="col-md-12">
		
			<form action="{{ route('landingpage.save')}}" method="POST">
			@csrf	
				<div class="card-body" >
					
					@if(session()->has('message'))
					<div class="alert alert-success">
						{{ session()->get('message') }}
					</div>
					@endif

					<div class="row restaurant_payout_create">
						<div class="vendor_payout_create-inner">
							<fieldset >
								<legend>
									{{trans('lang.landing_page_html')}}
								</legend>
								<div class="form-group width-100">
									<textarea class="form-control col-7" name="html_template" id="html_template">{{@$template->html_template}}</textarea>
								</div>
							</fieldset>
						</div>
					</div>
				</div>
			
				<div class="form-group col-12 text-center btm-btn">
					<button type="submit" class="btn btn-primary  create_user_btn" ><i class="fa fa-save"></i> {{ trans('lang.save')}}</button>
				</div>
			
			</form>
		</div>
	</div>
</div>

@endsection

@section('scripts')

<script>

$(document).ready(function(){

	$('#html_template').summernote({
		height: 400,
		width: 1024,
		toolbar: [
			['style', ['bold', 'italic', 'underline', 'clear']],
			['font', ['strikethrough', 'superscript', 'subscript']],
			['fontsize', ['fontsize']],
			['color', ['color']],
			['forecolor', ['forecolor']],
			['backcolor', ['backcolor']],
			['para', ['ul', 'ol', 'paragraph']],
			['height', ['height']],
			['view', ['fullscreen', 'codeview', 'help']],
		]
	});
});
</script>

@endsection