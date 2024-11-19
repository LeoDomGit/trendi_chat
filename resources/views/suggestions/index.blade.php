@extends('layouts.app')

@section('content')

<div class="page-wrapper">

    <div class="row page-titles">

        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.suggestions')}}</h3>
        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.suggestions')}}</li>
            </ol>
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
                                    <a class="nav-link" href="{!! route('suggestions.create') !!}"><i
                                            class="fa fa-plus mr-2"></i>{{trans('lang.suggestion_create')}}</a>
                                </div>
                                <div id="users-table_filter" class="ml-auto">
                                    <div class="form-group mb-0">

                                        <form action="" method="get">
                                            <input name="search" class="search form-control" type="text"
                                                value="{{ Request::get('search') }}" placeholder="Search your keyword">
                                            @if(!empty($category))
                                                <select name="category" class="form-control">
                                                    <option value="">{{trans('lang.select_category')}}</option>
                                                    @foreach($category as $category)
                                                    <option value="{{ $category->id}}"
                                                        {{ (Request::get('category') ==  $category->id) ? 'selected' : '' }}>
                                                        {{$category->name }}</option>
                                                    @endforeach
                                            </select>
                                            @endif
                                            <button class="btn btn-warning btn-flat" type="submit">Search</button>
                                            <a class="btn btn-warning btn-flat" href="{{url('suggestions')}}">Clear</a>
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
                                                            class="fa fa-trash"></i>&nbsp;</a></label></th>
                                            <th>{{trans('lang.suggestion')}}</th>
                                            <th>{{trans('lang.category')}}</th>
                                            <th>{{trans('lang.status')}}</th>
                                            <th>{{trans('lang.actions')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="append_list12">
                                        @forelse($suggestions as $suggestion)
                                        <tr>
                                            <td class="delete-all"><input type="checkbox"
                                                    id="is_open_{{$suggestion->id}}" class="is_open"
                                                    dataid="{{$suggestion->id}}"><label class="col-3 control-label"
                                                    for="is_open_{{$suggestion->id}}"></label></td>


                                            <td>
                                                <a
                                                    href="{{route('suggestions.edit', ['id' => $suggestion->id])}}">{{ $suggestion->name}}</a>
                                            </td>
                                            <td>
                                                {{$suggestion->catName }}
                                            </td>
                                            <td>
                                                @if ($suggestion->status=="yes") <label class="switch"><input
                                                        type="checkbox" checked id="{{$suggestion->id}}"
                                                        name="publish"><span class="slider round"></span></label>
                                                @else <label class="switch"><input type="checkbox"
                                                        id="{{$suggestion->id}}" name="publish"><span
                                                        class="slider round"></span></label><span>
                                                    @endif </td>

                                            <td class="action-btn"><a
                                                    href="{{route('suggestions.edit', ['id' => $suggestion->id])}}"><i
                                                        class="fa fa-edit"></i></a><a id="'+val.id+'"
                                                    class="do_not_delete1" name="user-delete"
                                                    href="{{route('suggestions.delete', ['id' => $suggestion->id])}}"><i
                                                        class="fa fa-trash"></i></a>
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
                                    {{ $suggestions->appends(request()->query())->links() }}
                                    {{ $suggestions->links('pagination.pagination') }}
                                </nav>
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

$("#deleteAll").click(function() {

    if ($('#example24 .is_open:checked').length) {
        if (confirm("{{trans('lang.confirm_message')}}")) {
            var arrayUsers = [];
            $('#example24 .is_open:checked').each(function() {
                var dataId = $(this).attr('dataId');
                arrayUsers.push(dataId);

            });
            arrayUsers = JSON.stringify(arrayUsers);
            var url = "{{url('suggestions/delete', 'id')}}";
            url = url.replace('id', arrayUsers);
            $(this).attr('href', url);
        }
    } else {
        alert("{{trans('lang.alert_message')}}");
    }
});

$(document).on("click", "input[name='publish']", function(e) {
    var ischeck = $(this).is(':checked');
    var id = this.id;
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: 'suggestions/status',
        method: "POST",
        data: {
            'ischeck': ischeck,
            'id': id
        },
        success: function(data) {

        },
    });

});
</script>

@endsection