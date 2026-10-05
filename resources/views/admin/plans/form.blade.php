@extends('admin.layout')

@section('title')
    {{ trans('admin_message.sidebar.plans') }}
@endsection

@section('heading')
    {{ trans('admin_message.sidebar.plans') }}
@endsection

@section('style')

@endsection

@section('content')

    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3>{{$plans->exists ? trans('admin_message.plans.edit_workout') .' '.$plans->name : trans('admin_message.plans.create_plan')}}</h3>
            </div>
            <div class="box-body">
                {!! Form::model($plans, [
                    'files' => true,
                    'method' => $plans->exists ? 'put' : 'post',
                    'route'  => $plans->exists ?
                     ['admin.plans.update', $plans->id]:
                     ['admin.plans.store']
                ]) !!}

                <div class="form-group">
                    <label for="workout_id">{{ trans('admin_message.plans.workout_id') }}:</label>
                    <select name="workout_id" id="workout_id" class="form-control"
                            required>
                        @foreach($workouts as $workout)
                            <option value="{{ $workout->id }}" {{ $workout->id == $plans->workout_id ? 'selected' : '' }}>{{ $workout->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    {!! Form::label('name', trans('admin_message.plans.name')) !!}
                    {!! Form::text('name', null,['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('workouts_number', trans('admin_message.plans.wokrouts_number')) !!}
                    {!! Form::number('workouts_number', null,['class' => 'form-control', 'min' => 1]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('plan_duration', trans('admin_message.plans.plan_duration')) !!}
                    {!! Form::number('plan_duration', null,['class' => 'form-control', 'min' => 0]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('price', trans('admin_message.plans.price')) !!}
                    {!! Form::text('price', null,['class' => 'form-control']) !!}
                </div>


                {!! Form::submit($plans->exists ? trans('admin_message.plans.save_workout') : trans('admin_message.plans.create_plan'), ['class' => 'btn btn-primary btn-flat']) !!}
                <a href="{!! url('admin/plans') !!}" title="{{ trans('admin_message.cancel') }}" class="btn btn-danger btn-flat">{{ trans('admin_message.cancel') }}</a>
               {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

