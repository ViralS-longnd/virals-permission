@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            {{ __('virals-permission::permission.role') }}
            <small>{{ __('virals-permission::messages.list') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-home"></i>{{ __('virals-permission::messages.home') }}</a></li>
            <li class="active">{{ __('virals-permission::permission.role_list') }}</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row form-group">
                    <div class="col-sm-12 pull-right">
                        <a href="{{ route('admin.roles.create') }}" class="btn btn-success"><i class="fa fa-edit"></i>
                            {{ __('virals-permission::permission.role_create') }}</a>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ __('virals-permission::permission.role_list') }}</h3>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <thead class="bg-primary">
                        <tr>
                        <tr>
                            <th>{{ __('virals-permission::messages.index') }}</th>
                            <th>{{ __('virals-permission::permission.role_name') }}</th>
                            <th>{{ __('virals-permission::permission.permission') }}</th>
                            <th>{{ __('virals-permission::messages.action') }}</th>
                        </tr>
                        </tr>
                        </thead>
                        <tbody>
                        @if($roles->count() > 0)
                            @foreach($roles as $key => $role)
                                <tr>
                                    <td>{{ @($key + 1) }}</td>
                                    <td>{{ @$role->name }}</td>
                                    <td>{{ subContent(implode(",", @$role->permissions->pluck('name')->toArray())) }}</td>
                                    <td>
                                        <a href="{{ route('admin.roles.edit', $role->id) }}"
                                           class="btn btn-xs btn-primary"><i
                                                    class="fa fa-pencil"></i></a>
                                        <a class="btn btn-xs btn-danger delete_role"
                                           data-url="{{ route('admin.roles.destroy', $role->id) }}"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="5" class="text-center">{{ __('virals-permission::messages.no_result') }}</td></tr>
                        @endif
                        </tbody>
                    </table>
                    <div class="row mbm">
                        <div class="col-sm-6">
                            <span class="record-total">{{ __('virals-permission::messages.show') }} {{ $roles->count() }} / {{ $roles->total() }} {{ __('virals-permission::messages.result') }}</span>
                        </div>
                        <div class="col-sm-6">
                            <div class="pagination-panel pull-right">
                                {{ $roles->appends(request()->input())->links() }}
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
        $(document).on('click', 'a.delete_role', function (e) {
            if (!confirm('{{ __('virals-permission::messages.delete_message') }}')) {
                e.preventDefault();
            } else {
                $.ajax({
                    url: $(this).attr('data-url'),
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "_method": "DELETE"
                    },
                    success: function (response) {
                        location.reload()
                    }
                })
            }

        });
    </script>
@endsection
