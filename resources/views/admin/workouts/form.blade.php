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
                {!! Form::model($workouts, [
                    'files' => true,
                    'method' => $workouts->exists ? 'put' : 'post',
                    'route'  => $workouts->exists ?
                     ['admin.workouts.update', $workouts->id]:
                     ['admin.workouts.store']
                ]) !!}
                <div class="form-group">
                    {!! Form::label('name', trans('admin_message.workouts.name')) !!}
                    {!! Form::text('name', null,['class' => 'form-control']) !!}
                </div>
                 <div class="form-group">
                    {!! Form::label('workout_time', trans('admin_message.workouts.workout_time')) !!} <i class="fa fa-clock-o"></i>
                    {!! Form::text('workout_time', null,['class' => 'form-control']) !!}
                </div>


                {!! Form::submit($workouts->exists ? trans('admin_message.workouts.save_workout') : trans('admin_message.workouts.create_workout'), ['class' => 'btn btn-primary btn-flat']) !!}
                <a href="{!! url('admin/workouts') !!}" title="{{ trans('admin_message.cancel') }}" class="btn btn-danger btn-flat">{{ trans('admin_message.cancel') }}</a>
               {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

