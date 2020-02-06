@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Users
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-home"></i>Home</a></li>
            <li class="active">Users list</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row form-group">
                    <div class="col-sm-12 pull-right">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-success"><i class="fa fa-edit"></i>
                            Create Users</a>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">List Users</h3>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <thead class="bg-primary">
                        <tr>
                        <tr>
                            <th>STT</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Extra Permission</th>
                            <th>Action</th>
                        </tr>
                        </tr>
                        </thead>
                        <tbody>
                        @if($users->count() > 0)
                            @foreach($users as $key => $user)
                                <tr>
                                    <td>{{ @($key + 1) }}</td>
                                    <td>{{ @$user->name }}</td>
                                    <td>{{ @$user->email }}</td>
                                    <td>{{ implode(",", @$user->roles->pluck('name')->toArray()) }}</td>
                                    <td>{{ implode(",", @$user->permissions->pluck('name')->toArray()) }}</td>
                                    <td>
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                           class="btn btn-xs btn-primary"><i
                                                    class="fa fa-pencil"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="5" class="text-center">No result</td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        var request = false;
        $(document).on('click', 'a.delete_role', function (e) {
            if (!confirm('Are you sure?')) {
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
