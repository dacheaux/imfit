@extends('admin.layout')

@section('title')
    {{ trans('admin_message.sidebar.workouts') }}
@endsection

@section('heading')
    {{ trans('admin_message.sidebar.workouts') }}
@endsection

@section('style')

@endsection

@section('content')

    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3>{{$workouts->exists ? trans('admin_message.workouts.edit_workout') .' '.$workouts->name : trans('admin_message.workouts.create_workout')}}</h3>
            </div>
            <div class="box-body">
                {!! html()->modelForm($workouts, $workouts->exists ? 'put' : 'post', ($workouts->exists ? route('admin.workouts.update', $workouts->id) : route('admin.workouts.store')))->acceptsFiles()->open() !!}
                <div class="form-group">
                    {!! html()->label(trans('admin_message.workouts.name'), 'name') !!}
                    {!! html()->text('name')->attributes(['class' => 'form-control']) !!}
                </div>
                 <div class="form-group">
                    {!! html()->label(trans('admin_message.workouts.workout_time'), 'workout_time') !!} <i class="fa fa-clock-o"></i>
                    {!! html()->text('workout_time')->attributes(['class' => 'form-control']) !!}
                </div>


                {!! html()->submit($workouts->exists ? trans('admin_message.workouts.save_workout') : trans('admin_message.workouts.create_workout'))->attributes(['class' => 'btn btn-primary btn-flat']) !!}
                <a href="{!! url('admin/workouts') !!}" title="{{ trans('admin_message.cancel') }}" class="btn btn-danger btn-flat">{{ trans('admin_message.cancel') }}</a>
               {!! html()->closeModelForm() !!}
            </div>
        </div>
    </div>
@endsection

