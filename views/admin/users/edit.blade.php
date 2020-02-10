@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            {{ __('virals-permission::permission.user') }}
            <small>{{ __('virals-permission::permission.user_edit') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-home"></i>{{ __('virals-permission::messages.home') }}</a></li>
            <li class="active">{{ __('virals-permission::permission.user_edit') }}</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ __('virals-permission::permission.user_edit') }}</h3>
                    </div>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {!! Form::open(['url' =>[route('admin.users.update', $user->id) ] , 'method'=> 'POST','files' => true]) !!}
                @method('PUT')
                <input type="hidden" name="id" value="{{ $user->id }}">
                <div class="form-group">
                    {!! Form::label('name', __('virals-permission::permission.user_name')) !!}
                    {!! Form::text('name', old('name') ?? $user->name , ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('email', __('virals-permission::permission.user_email')) !!}
                    {!! Form::text('email', old('email') ?? $user->email , ['class' => 'form-control' , 'readonly']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('name', __('virals-permission::permission.user_roles')) !!}
                    @foreach($roles as $role)
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="check_role" name="roles[]" value="{{ $role->id }}" @if(in_array($role->id, @$user->roles->pluck('id')->toArray())) checked @endif>
                                {{ $role->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                {!! Form::label('name', __('virals-permission::permission.user_permissions')) !!}
                <div class="form-group">
                    @foreach($permissions as $permission)
                    <div class="col-xs-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="check_permission" name="permissions[]" value="{{ $permission->id }}" @if(in_array($permission->id, @$user->permissions->pluck('id')->toArray())) checked @endif
                                @if(in_array($permission->id, $collapseUser)) checked disabled @endif >
                                {{ $permission->name }}
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-default">{{ __('virals-permission::messages.submit') }}</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-default pull-right">{{ __('virals-permission::messages.cancel') }}</a>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        var request = false;
        $(document).on('change', 'input.check_role', function (e) {
            if(!request) {
                request = true;
                e.preventDefault();
                var roleId = $('input.check_role:checked').serialize();
                var status = $(this).is(":checked");
                var url = '{{ request()->getSchemeAndHttpHost() }}' + '/admin/roles/'+roleId;
                $.ajax({
                    url: '{{ route('admin.users.roles.permissions') }}',
                    type: 'GET',
                    data: roleId,
                    success: function (response) {
                        $("input.check_permission").prop("checked",false);
                        $("input.check_permission:disabled").prop("disabled",false);
                        $.each(response, function( index, value ) {
                            $("input.check_permission[value="+value+"]").prop("checked",true);
                            $("input.check_permission[value="+value+"]").attr("disabled",true);
                        });
                        request = false;
                    }
                })
            }
        })
    </script>
@endsection
