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
                {!! html()->modelForm($tags, $tags->exists ? 'put' : 'post', ($tags->exists ? route('admin.tags.update', $tags->id) : route('admin.tags.store')))->acceptsFiles()->open() !!}
                <div class="form-group">
                    {!! html()->label(trans('admin_message.tags.name'), 'name') !!}
                    {!! html()->text('name')->attributes(['class' => 'form-control']) !!}
                </div>

                {!! html()->submit($tags->exists ? trans('admin_message.tags.save_workout') : trans('admin_message.tags.create_workout'))->attributes(['class' => 'btn btn-primary btn-flat']) !!}
                <a href="{!! url('admin/tags') !!}" title="{{ trans('admin_message.cancel') }}" class="btn btn-danger btn-flat">{{ trans('admin_message.cancel') }}</a>
               {!! html()->closeModelForm() !!}
            </div>
        </div>
    </div>
@endsection

