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
                {!! html()->modelForm($accountplans, $accountplans->exists ? 'put' : 'post', ($accountplans->exists ? route('admin.accountplans.update', $accountplans->id) : route('admin.accountplans.store')))->open() !!}

                <div class="form-group">
                    {!! html()->label(trans('admin_message.plans.name'), 'plan_name') !!}
                    {!! html()->text('plan_name')->attributes(['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! html()->label(trans('admin_message.plans.price'), 'deposit_amount') !!}
                    {!! html()->text('deposit_amount')->attributes(['class' => 'form-control']) !!}
                </div>


                {!! html()->submit($accountplans->exists ? trans('admin_message.plans.save_workout') : trans('admin_message.plans.create_plan'))->attributes(['class' => 'btn btn-primary btn-flat']) !!}
                <a href="{!! url('admin/accountplans') !!}" title="{{ trans('admin_message.cancel') }}" class="btn btn-danger btn-flat">{{ trans('admin_message.cancel') }}</a>
               {!! html()->closeModelForm() !!}
            </div>
        </div>
    </div>
@endsection

