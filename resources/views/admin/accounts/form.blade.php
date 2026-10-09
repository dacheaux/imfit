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
                {!! html()->modelForm($account, $account->exists ? 'put' : 'post', ($account->exists ? route('admin.accounts.update', $account->id) : route('admin.accounts.store')))->open() !!}

                <div class="form-group">
                    {!! html()->label(trans('admin_message.account.balance'), 'balance') !!}
                    {!! html()->number('balance')->attributes(['class' => 'form-control']) !!}
                </div>

                {!! html()->submit($account->exists ? trans('admin_message.plans.save_workout') : trans('admin_message.plans.create_plan'))->attributes(['class' => 'btn btn-primary btn-flat']) !!}
                <a href="{!! url('admin/accountplans') !!}" title="{{ trans('admin_message.cancel') }}" class="btn btn-danger btn-flat">{{ trans('admin_message.cancel') }}</a>
               {!! html()->closeModelForm() !!}
            </div>
        </div>
    </div>
@endsection

