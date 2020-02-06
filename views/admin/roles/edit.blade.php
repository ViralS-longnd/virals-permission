@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Roles
            <small>Edit roles</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-home"></i>Home</a></li>
            <li class="active">Create Roles</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Edit Role</h3>
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
                {!! Form::open(['url' =>[route('admin.roles.update', $role->id) ] , 'method'=> 'POST','files' => true]) !!}
                @method('PUT')
                <input type="hidden" name="id" value="{{ $role->id }}">
                <div class="form-group">
                    {!! Form::label('name', 'Role name') !!}
                    {!! Form::text('name', old('name') ?? $role->name , ['class' => 'form-control', 'placeholder' => 'Role name']) !!}
                </div>
                {!! Form::label('name', 'Permissions') !!}
                <div class="form-group">
                    @foreach($permissions as $permission)
                        <div class="col-xs-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" @if(in_array($permission->id, @$role->permissions->pluck('id')->toArray())) checked @endif>
                                    {{ $permission->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-default">Submit</button>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-default pull-right">Cancel</a>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection
