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
                <h3>{{$accountplans->exists ? trans('admin_message.plans.edit_workout') .' '.$accountplans->name : trans('admin_message.plans.create_plan')}}</h3>
            </div>
            <div class="box-body">
                {!! Form::model($accountplans, [
                    'method' => $accountplans->exists ? 'put' : 'post',
                    'route'  => $accountplans->exists ?
                     ['admin.accountplans.update', $accountplans->id]:
                     ['admin.accountplans.store']
                ]) !!}

                <div class="form-group">
                    {!! Form::label('plan_name', trans('admin_message.plans.name')) !!}
                    {!! Form::text('plan_name', null,['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('deposit_amount', trans('admin_message.plans.price')) !!}
                    {!! Form::text('deposit_amount', null,['class' => 'form-control']) !!}
                </div>


                {!! Form::submit($accountplans->exists ? trans('admin_message.plans.save_workout') : trans('admin_message.plans.create_plan'), ['class' => 'btn btn-primary btn-flat']) !!}
                <a href="{!! url('admin/accountplans') !!}" title="{{ trans('admin_message.cancel') }}" class="btn btn-danger btn-flat">{{ trans('admin_message.cancel') }}</a>
               {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

