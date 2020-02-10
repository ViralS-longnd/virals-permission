@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            {{ __('virals-permission::permission.role') }}
            <small>{{ __('virals-permission::permission.role_create') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-home"></i>{{ __('virals-permission::messages.home') }}</a></li>
            <li class="active">{{ __('virals-permission::permission.role_create') }}</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ __('virals-permission::permission.role_create') }}</h3>
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
                {!! Form::open(['url' =>[route('admin.roles.store') ] , 'method'=> 'POST','files' => true]) !!}
                <div class="form-group">
                    {!! Form::label('name', __('virals-permission::permission.role_name')) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' =>  __('virals-permission::permission.role_name')]) !!}
                </div>
                {!! Form::label('name',  __('virals-permission::permission.permission')) !!}
                <div class="form-group">
                    @foreach($permissions as $permission)
                        <div class="col-xs-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        </div>

                    @endforeach
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-default">{{ __('virals-permission::messages.submit') }}</button>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-default pull-right">{{ __('virals-permission::messages.cancel') }}</a>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection
