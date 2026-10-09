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
                {!! html()->modelForm($plans, $plans->exists ? 'put' : 'post', ($plans->exists ? route('admin.plans.update', $plans->id) : route('admin.plans.store')))->acceptsFiles()->open() !!}

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
                    {!! html()->label(trans('admin_message.plans.name'), 'name') !!}
                    {!! html()->text('name')->attributes(['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! html()->label(trans('admin_message.plans.wokrouts_number'), 'workouts_number') !!}
                    {!! html()->number('workouts_number')->attributes(['class' => 'form-control', 'min' => 1]) !!}
                </div>

                <div class="form-group">
                    {!! html()->label(trans('admin_message.plans.plan_duration'), 'plan_duration') !!}
                    {!! html()->number('plan_duration')->attributes(['class' => 'form-control', 'min' => 0]) !!}
                </div>

                <div class="form-group">
                    {!! html()->label(trans('admin_message.plans.price'), 'price') !!}
                    {!! html()->text('price')->attributes(['class' => 'form-control']) !!}
                </div>


                {!! html()->submit($plans->exists ? trans('admin_message.plans.save_workout') : trans('admin_message.plans.create_plan'))->attributes(['class' => 'btn btn-primary btn-flat']) !!}
                <a href="{!! url('admin/plans') !!}" title="{{ trans('admin_message.cancel') }}" class="btn btn-danger btn-flat">{{ trans('admin_message.cancel') }}</a>
               {!! html()->closeModelForm() !!}
            </div>
        </div>
    </div>
@endsection

