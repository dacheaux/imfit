@extends('admin.layout')

@section('title')
    {{ trans('admin_message.sidebar.tags') }}
@endsection

@section('heading')
    {{ trans('admin_message.sidebar.tags') }}
@endsection

@section('style')

@endsection

@section('content')

    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3>{{$tags->exists ? trans('admin_message.tags.edit_workout') .' '.$tags->name : trans('admin_message.tags.create_workout')}}</h3>
            </div>
            <div class="box-body">
                {!! Form::model($tags, [
                    'files' => true,
                    'method' => $tags->exists ? 'put' : 'post',
                    'route'  => $tags->exists ?
                     ['admin.tags.update', $tags->id]:
                     ['admin.tags.store']
                ]) !!}
                <div class="form-group">
                    {!! Form::label('name', trans('admin_message.tags.name')) !!}
                    {!! Form::text('name', null,['class' => 'form-control']) !!}
                </div>

                {!! Form::submit($tags->exists ? trans('admin_message.tags.save_workout') : trans('admin_message.tags.create_workout'), ['class' => 'btn btn-primary btn-flat']) !!}
                <a href="{!! url('admin/tags') !!}" title="{{ trans('admin_message.cancel') }}" class="btn btn-danger btn-flat">{{ trans('admin_message.cancel') }}</a>
               {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

