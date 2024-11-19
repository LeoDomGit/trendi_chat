@extends('layouts.app')

@section('content')
   <div class="page-wrapper">
       <!-- ============================================================== -->
       <!-- Bread crumb and right sidebar toggle -->
       <!-- ============================================================== -->
       <div class="row page-titles">
           <div class="col-md-5 align-self-center">
               <h3 class="text-themecolor">{{trans('lang.notifications')}}</h3>
           </div>
           <div class="col-md-7 align-self-center">
               <ol class="breadcrumb">
                   <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                   <li class="breadcrumb-item active">{{trans('lang.notifications')}}</li>
               </ol>
           </div>
           <div>
           </div>
       </div>

       <div class="container-fluid">
           <div class="row">
               <div class="col-12">
                   <div class="card">

                       <div class="card-body">
                            
                           @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                            @endif
                          
                           <div class="userlist-topsearch d-flex mb-3">
                               <div class="userlist-top-left">
                                   <a class="nav-link" href="{!! route('notifications.create') !!}"><i class="fa fa-plus mr-2"></i>{{trans('lang.notifications_send')}}</a>
                               </div> 
                               <div id="users-table_filter" class="ml-auto">
                                    <div class="form-group mb-0">

                                        <form action="" method="get">
                                            <input name="search" class="search form-control" type="text"
                                                value="{{ Request::get('search') }}" placeholder="Search your keyword">
                                            
                                            <button class="btn btn-warning btn-flat" type="submit">Search</button>
                                            <a class="btn btn-warning btn-flat" href="{{url('notifications')}}">Clear</a>
                                        </form>
                                    </div>
                                </div>
                           </div>
                           <div class="table-responsive m-t-10">
                               <table id="example24"
                                      class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                      cellspacing="0" width="100%">
                                   <thead>
                                   <tr>
                                       <th>{{trans('lang.notification_title')}}</th>
                                       <th>{{trans('lang.notification_message')}}</th>
                                       <th>{{trans('lang.date_created')}}</th>
                                       <th>{{trans('lang.actions')}}</th>
                                   </tr>
                                   </thead>
                                   <tbody id="append_list12">
                                   @forelse($notifications as $notification)
                                       <tr>
                                           <td>{{ $notification->title}}</td>
                                           <td>{{$notification->body}}</td>
                                           <td>{{$notification->created_at}}</td>


                                           <td class="action-btn"><a href="{{ route('notifications.delete',$notification->id)}}" class="do_not_delete" name="user-delete"><i class="fa fa-trash"></i></a></td>
                                           </td>
                                       </tr>
                                       @empty
                                        <tr>
                                            <td align="center" colspan=5>{{trans('lang.no_results')}} </td>
                                        </tr>
                                   @endforelse
                                   </tbody>
                               </table>
                               <nav aria-label="Page navigation example" class="custom-pagination">
                                    {{ $notifications->appends(request()->query())->links() }}
                                    {{ $notifications->links('pagination.pagination') }}
                                </nav>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
   </div>
   </div>

@endsection

