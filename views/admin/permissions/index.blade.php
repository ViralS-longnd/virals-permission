@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Permission
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-home"></i>Home</a></li>
            <li class="active">Permission list</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">List route permissions</h3>
                    </div>
                </div>
                <form id="form-search-advance" action="{{ route('admin.permission.index') }}" method="get">
                    @php
                        $action = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];
                    @endphp
                    <div id="search-advance" class="search-advance">
                        <div class="row form-group space-5">
                            <div class="col-sm-4">
                                <select name="method" class="form-control">
                                    <option value="" selected>Method</option>
                                    @foreach($action as $value)
                                        <option value="{{ $value }}" @if(@$method == $value) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-danger"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <thead class="bg-primary">
                        <tr>
                            <th>Stt</th>
                            <th>Uri</th>
                            <th>Method</th>
                            <th>Permission Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($permissions) > 0)
                            @foreach($permissions as $key => $route)
                                <tr @if(!$route['status']) class="bg-red" @endif data-id="{{ $route['id'] }}">
                                    <td>{{ @($key + 1) + ($permissions->currentPage() - 1) * $permissions->perPage() }}</td>
                                    <td class="uri">{{ $route['uri'] }}</td>
                                    <td class="method">{{ $route['method'] }}</td>
                                    <td class="name">{{ @$route['name'] }}</td>
                                    <td>
                                        <button class="btn btn-xs btn-primary edit_permission"><i class="fa fa-pencil"></i></button>
                                        @if($route['id'] != "")
                                        <button class="btn btn-xs btn-danger delete_permission" data-url="{{ route('admin.permission.destroy', $route['id']) }}"><i class="fa fa-trash"></i></button>
                                            @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="6" class="text-center">No result</td></tr>
                        @endif
                        </tbody>
                    </table>
                    <div class="row mbm">
                        <div class="col-sm-6">
                            <span class="record-total">Show {{ $permissions->count() }} / {{ $permissions->total() }} results</span>
                        </div>
                        <div class="col-sm-6">
                            <div class="pagination-panel pull-right">
                                {{ $permissions->appends(request()->input())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        var request = false;
        $(document).on('click', 'button.edit_permission', function (e) {
            if(!request) {
                request = true;
                e.preventDefault();
                var tr = $(this).parents('tr');
                var td = $(this).parent();
                var text = tr.find('td.name').text();
                td.html(' <button class="btn btn-xs btn-success sync_permission" title="Sync database"><i class="fa fa-refresh"></i></button>' +
                    ' <button class="btn btn-xs btn-warning cancel_permission" data-text="'+ text +'" title="Cancel"><i class="fa fa-times"></i></button>');
                tr.find('td.name').html('<input name="name" value="'+ text +'" class="form-control">')
                request = false;
            }
        });

        $(document).on('click', 'button.cancel_permission', function (e) {
            if(!request) {
                request = true;
                e.preventDefault();
                var tr = $(this).parents('tr');
                var id = tr.data('id');
                var td = $(this).parent();
                var text = $(this).data('text');
                var html = '<button class="btn btn-xs btn-primary edit_permission"><i class="fa fa-pencil"></i></button>';
                if (id != "") {
                    var url = '{{ request()->getSchemeAndHttpHost() }}' + '/admin/permission/'+id;
                    html += '<button class="btn btn-xs btn-danger delete_permission" data-url="'+ url +'"><i class="fa fa-trash"></i></button>'
                }
                td.html(html);
                tr.find('td.name').html(text);
                request = false;
            }
        });

        $(document).on('click', 'button.sync_permission', function (e) {
            if(!request) {
                request = true;
                e.preventDefault();
                var tr = $(this).parents('tr');
                var id = tr.data('id');
                var td = $(this).parent();
                var text =  tr.find('td.name').find('input').val();
                if (text == '') {
                    var html = '<button class="btn btn-xs btn-primary edit_permission"><i class="fa fa-pencil"></i></button>';
                    if (id != "") {
                        var url = '{{ request()->getSchemeAndHttpHost() }}' + '/admin/permission/'+id;
                        html += '<button class="btn btn-xs btn-danger delete_permission" data-url="'+ url +'"><i class="fa fa-trash"></i></button>'
                    }
                    td.html(html);
                    tr.find('td.name').html(text);
                    request = false;
                    return;
                }
                var uri = tr.find('td.uri').text();
                var method = tr.find('td.method').text();
                $.ajax({
                    url: '{{ route('admin.permission.store') }}',
                    method: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "name": text,
                        "uri": uri,
                        "method": method
                    },
                    success: function (response) {
                        request = false;
                        tr.find('td.name').html(text);
                        var url = '{{ request()->getSchemeAndHttpHost() }}' + '/admin/permission/'+response.id;
                        td.html('<button class="btn btn-xs btn-primary edit_permission"><i class="fa fa-pencil"></i></button>'+
                            '<button class="btn btn-xs btn-danger delete_permission" data-url="'+ url +'"><i class="fa fa-trash"></i></button>');
                    }
                });
            }
        });

        $(document).on('click', 'button.delete_permission', function (e) {
            if (!confirm('Are you sure?')) {
                e.preventDefault();
            } else {
                $.ajax({
                    url: $(this).attr('data-url'),
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        location.reload()
                    }
                })
            }

        });
    </script>
@endsection
