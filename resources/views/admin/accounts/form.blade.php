@extends('admin.layout')


@section('title')
    {{ trans('admin_message.sidebar.accounts') }}
@endsection

@section('heading')
    {{ trans('admin_message.sidebar.accounts') }}
@endsection

@section('style')

@endsection

@section('content')

    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3>{{$account->exists ? trans('admin_message.account.edit')  : trans('admin_message.account.create')}}</h3>
            </div>
            <div class="box-body">
                {!! Form::model($account, [
                    'method' => $account->exists ? 'put' : 'post',
                    'route'  => $account->exists ?
                     ['admin.accounts.update', $account->id]:
                     ['admin.accounts.store']
                ]) !!}

                <div class="form-group">
                    {!! Form::label('balance', trans('admin_message.account.balance')) !!}
                    {!! Form::number('balance', null,['class' => 'form-control']) !!}
                </div>

                {!! Form::submit($account->exists ? trans('admin_message.plans.save_workout') : trans('admin_message.plans.create_plan'), ['class' => 'btn btn-primary btn-flat']) !!}
                <a href="{!! url('admin/accountplans') !!}" title="{{ trans('admin_message.cancel') }}" class="btn btn-danger btn-flat">{{ trans('admin_message.cancel') }}</a>
               {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

