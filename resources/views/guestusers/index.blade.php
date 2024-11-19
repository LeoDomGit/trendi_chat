@extends('layouts.app')

@section('content')
<div class="page-wrapper">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.guest_users')}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.guest_users')}}</li>
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

                            <div id="users-table_filter" class="ml-auto">
                                <div class="form-group mb-0">

                                    <form action="" method="get">
                                        <input name="search" class="search form-control" type="text"
                                            value="{{ Request::get('search') }}" placeholder="Search your keyword">

                                        <select name="limit" class="form-control">
                                                <option value="">{{trans('lang.select_limit')}}</option>
                                                <option value="10" {{ (Request::get('limit') ==  10) ? 'selected' : '' }}> 10 </option>
                                                <option value="20" {{ (Request::get('limit') ==  20) ? 'selected' : '' }}> 20 </option>
                                                <option value="30" {{ (Request::get('limit') ==  30) ? 'selected' : '' }}> 30 </option>
                                                <option value="50" {{ (Request::get('limit') ==  50 || Request::get('limit') ==  '') ? 'selected' : '' }}> 50 </option>
                                                <option value="100" {{ (Request::get('limit') ==  100) ? 'selected' : '' }}> 100 </option>
                                        </select>    
                                        <button class="btn btn-warning btn-flat" type="submit">Search</button>
                                        <a class="btn btn-warning btn-flat" href="{{url('guestusers')}}">Clear</a>
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
                                        <th class="delete-all"><input type="checkbox" id="is_active"><label
                                                class=" control-label" for="is_active"><a id="deleteAll"
                                                    class="do_not_delete" href="javascript:void(0)"><i
                                                        class="fa fa-trash"></i>&nbsp;&nbsp;</a></label></th>
                                        <th>{{trans('lang.device_id')}}</th>
                                        <th>{{trans('lang.writer_limit')}}</th>
                                        <th>{{trans('lang.chat_limit')}}</th>
                                        <th>{{trans('lang.image_limit')}}</th>
                                        <th>{{trans('lang.registered')}}</th>
                                        <th>{{trans('lang.actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody id="append_list12">
                                    @forelse($guestusers as $guestuser)
                                    <tr>
                                        <td class="delete-all"><input type="checkbox" id="is_open_{{$guestuser->id}}"
                                                class="is_open" dataid="{{$guestuser->id}}"><label
                                                class="col-3 control-label" for="is_open_{{$guestuser->id}}"></label>
                                        </td>
                                        <td>{{$guestuser->device_id}}</td>
                                        <td>{{ $guestuser->writer_limit}}</td>
                                        <td>{{ $guestuser->chat_limit}}</td>
                                        <td>{{ $guestuser->image_limit}}</td>
                                        <td>{{ $guestuser->created_at->format('d/m/Y g:i:s A') }}</td>
                                        <td class="action-btn">
                                            <a id="'+val.id+'" class="do_not_delete"
                                                name="user-delete"
                                                href="{{route('guestusers.delete', ['id' => $guestuser->id])}}"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td align="center" colspan=9>{{trans('lang.no_results')}} </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <nav aria-label="Page navigation example" class="custom-pagination">
                                {{ $guestusers->appends(request()->query())->links() }}
                                {{ $guestusers->links('pagination.pagination') }}
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

@section('scripts')

<script type="text/javascript">

    $("#is_active").click(function () {
        $("#example24 .is_open").prop('checked', $(this).prop('checked'));

    });

    $("#deleteAll").click(function () {
        if ($('#example24 .is_open:checked').length) {

            if (confirm("{{trans('lang.confirm_message')}}")) {
                var arrayUsers = [];
                $('#example24 .is_open:checked').each(function () {
                    var dataId = $(this).attr('dataId');
                    arrayUsers.push(dataId);

                });

                arrayUsers = JSON.stringify(arrayUsers);
                var url = "{{url('guestusers/delete', 'id')}}";
                url = url.replace('id', arrayUsers);

                $(this).attr('href', url);
            }
        } else {
            alert("{{trans('lang.alert_message')}}");
        }
    });


    $(document).on("click", "input[name='publish']", function (e) {
        var ischeck = $(this).is(':checked');
        var id = this.id;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'guestusers/status',
            method: "POST",
            data: {
                'ischeck': ischeck,
                'id': id
            },
            success: function (data) {

            },
        });

    });
</script>

@endsection