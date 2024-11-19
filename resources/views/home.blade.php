@extends('layouts.app')

@section('content')

    <div id="main-wrapper" class="page-wrapper">

        <!-- start container-->

        <div class="container-fluid">
 
            <!-- start row -->
            <div class="card mb-3 mt-4 business-analytics">
                <div class="card-body">
                    <div class="row trip-info total top">

                        <!-- column -->
                        <div class="col-lg-12">
                            <h3 class="card-title">{{trans('lang.dashboard_overall_upadte')}}</h3>
                        </div>

                        <!-- column -->
                        <div class="col-lg-4">

                            <div class="card">
                            <a href="{{ route('appusers') }}" >
                                <div class="card-body d-flex icon-blue">

                                    <div class="card-left">

                                        <h3 class="m-b-0 text-dark font-medium mb-2 users_count"
                                            id="users_count">{{ $total_users }}</h3>

                                        <h5 class="text-dark m-b-0 small">{{trans('lang.dashboard_total_users')}}</h5>

                                    </div>

                                    <div class="card-right ml-auto">

                                        <i class="mdi mdi-account-multiple"></i>

                                    </div>

                                </div>
                                </a>
                            </div>

                        </div>

                        <!-- column -->
                        <div class="col-lg-4">

                            <div class="card">
                            <a href="{{ route('appusers') }}" >
                                <div class="card-body d-flex icon-red">

                                    <div class="card-left">

                                        <h3 class="m-b-0 text-dark font-medium mb-2 driver_count"
                                            id="subscription_count">{{ $total_subscription }}</h3>

                                        <h5 class="text-dark m-b-0 small">{{trans('lang.dashboard_total_subscription')}}</h5>

                                    </div>

                                    <div class="card-right ml-auto">

                                        <i class="mdi mdi-cash-usd"></i>

                                    </div>

                                </div>
                            </a>
                            </div>

                        </div>

                        <!-- column -->
                        <div class="col-lg-4">

                            <div class="card">
                            <a href="{{ route('appusers') }}" >
                                <div class="card-body d-flex icon-blue">

                                    <div class="card-left">

                                        <h3 class="m-b-0 text-dark font-medium mb-2 driver_count"
                                            id="guest_count">{{ $total_guest_users }}</h3>

                                        <h5 class="text-dark m-b-0 small">{{trans('lang.dashboard_total_guest_users')}}</h5>

                                    </div>

                                    <div class="card-right ml-auto">

                                        <i class="mdi mdi-account-multiple"></i>

                                    </div>

                                </div>
                            </a>
                            </div>

                        </div>

                    </div>
                    
                </div>
            </div>
            <!-- end row -->

            <!-- start row -->
            <div class="card mb-3 mt-4 business-analytics">
            	
                <div class="card-body">
                	
                	<div class="row trip-info today top">

	                    <!-- column -->
	                    <div class="col-lg-12">
	                        <h3 class="card-title">{{trans('lang.dashboard_today_upadte')}}</h3>
	                    </div>

	                    <!-- column -->
	                    <div class="col-lg-4">
	
	                        <div class="card">
	                        <a href="{{ route('appusers') }}" >
	                            <div class="card-body d-flex icon-blue">
	
	                                <div class="card-left">
	
	                                    <h3 class="m-b-0 text-dark font-medium mb-2">{{ $today_users }}</h3>
	
	                                    <h5 class="text-dark m-b-0 small">{{trans('lang.dashboard_today_users')}}</h5>
	
	                                </div>
	
	                                <div class="card-right ml-auto">
	
	                                    <i class="mdi mdi-account-multiple-plus"></i>
	
	                                </div>
	
	                            </div>
	                        </a>
	                        </div>
	
	                    </div>
	
	                    <!-- column -->
	                    <div class="col-lg-4">
	
	                        <div class="card">
	                        <a href="{{ route('appusers') }}" >
	                            <div class="card-body d-flex icon-red">
	
	                                <div class="card-left">
	
	                                    <h3 class="m-b-0 text-dark font-medium mb-2">{{ $today_subscription }}</h3>
	
	                                    <h5 class="text-dark m-b-0 small">{{trans('lang.dashboard_today_subscription')}}</h5>
	
	                                </div>
	
	                                <div class="card-right ml-auto">
	
	                                    <i class="mdi mdi-cash-usd"></i>
	
	                                </div>
	
	                            </div>
	                        </a>
	                        </div>
	
	                    </div>

                        <div class="col-lg-4">
	
	                        <div class="card">
	                        <a href="{{ route('appusers') }}" >
	                            <div class="card-body d-flex icon-blue">
	
	                                <div class="card-left">
	
	                                    <h3 class="m-b-0 text-dark font-medium mb-2">{{ $today_guest_users }}</h3>
	
	                                    <h5 class="text-dark m-b-0 small">{{trans('lang.dashboard_today_guest_users')}}</h5>
	
	                                </div>
	
	                                <div class="card-right ml-auto">
	
	                                    <i class="mdi mdi-account-multiple-plus"></i>
	
	                                </div>
	
	                            </div>
	                        </a>
	                        </div>
	
	                    </div>

                	</div>
                    
              </div>
		</div>
        <!-- end row -->

		<!-- start row -->   
        <div class="row daes-sec-sec mt-3 mb-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header no-border d-flex justify-content-between">
                        <h3 class="card-title">{{trans('lang.dashboard_recent_users')}}</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                            <tr>
                                <th>{{trans('lang.user_id')}}</th>
                                <th>{{trans('lang.name')}}</th>
                                <th>{{trans('lang.email')}}</th>
                                <th>{{trans('lang.photo')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_users as $recent_user)
                                <tr>
                                    <td><a href="{{route('appusers.edit', ['id' => $recent_user->id])}}">{{$recent_user->id}}</a></td>
                                    <td><a href="{{route('appusers.edit', ['id' => $recent_user->id])}}">{{$recent_user->name}}</a></td>
                                    <td>{{ $recent_user->email}}</td>
                                    @if (file_exists(public_path('images/users'.'/'.$recent_user->photo)) && !empty($recent_user->photo))
                                        <td>
                                            <img class="rounded" style="width:50px" src="{{asset('images/users').'/'.$recent_user->photo}}" alt="image">
                                        </td>
                                    @else
                                        <td>
                                            <img class="rounded" style="width:50px" src="{{asset('images/default_user.png')}}" alt="image">
                                        </td>
                                    @endif    
                                </tr>   
                                @empty
                                <tr>
                                    <td align="center" colspan=9>{{trans('lang.no_results')}} </td>
                                </tr>
                                @endforelse     
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

        <!--charts Start-->
		<div class="row daes-sec-sec">
			
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header no-border">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">{{trans('lang.dashboard_user_overview')}}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="position-relative mb-4">
                            <canvas id="overview_chart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header no-border">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">{{trans('lang.dashboard_service_overview')}}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="position-relative mb-4">
                            <canvas id="service_chart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--charts End-->

     </div>
    <!-- end container -->

</div>
<!-- end page-wrapper -->

@endsection

@section('scripts')

    <script src="{{asset('js/chart.js')}}"></script>

    <script type="text/javascript">

        setOverviewChart();
        setServiceChart();

        function setOverviewChart() {

            const data = {
                labels: [
                    "{{trans('lang.dashboard_total_users')}}",
                    "{{trans('lang.dashboard_total_subscription')}}",
                ],
                datasets: [{
                    data: [jQuery("#users_count").text(),jQuery("#subscription_count").text()],
                    backgroundColor: [
                        '#218be1',
                        '#B1DB6F',
                    ],
                    hoverOffset: 4
                }]
            };

            return new Chart('overview_chart', {
                type: 'doughnut',
                data: data,
                options: {
                    maintainAspectRatio: false,
                }
            })
        }

        function setServiceChart() {

            const data = {
                labels: [
                    "{{trans('lang.dashboard_total_categories')}}",
                    "{{trans('lang.dashboard_total_suggestions')}}",
                ],
                datasets: [{
                    data: [{{$total_categories}},{{$total_suggestions}}],
                    backgroundColor: [
                        '#218be1',
                        '#B1DB6F',
                    ],
                    hoverOffset: 4
                }]
            };

            return new Chart('service_chart', {
                type: 'doughnut',
                data: data,
                options: {
                    maintainAspectRatio: false,
                }
            })
        }
        

    </script>

@endsection
