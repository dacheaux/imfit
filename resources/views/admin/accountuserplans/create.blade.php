@extends('admin.layout')

@section('title')
    {{ trans('admin_message.sidebar.accountuserplans') }}
@endsection

@section('heading')
    {{ trans('admin_message.sidebar.accountuserplans') }}
@endsection

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-selection__rendered {
            line-height: 31px !important;
            border-radius: 0;
        }
        .select2-container .select2-selection--single {
            height: 35px !important;
            border-radius: 0;
        }
        .select2-selection__arrow {
            height: 34px !important;
            border-radius: 0;
        }
    </style>
@endsection


@section('content')

    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3>{{ trans('admin_message.accountuserplans.create_userplan') }}</h3>
            </div>
            <div class="box-body">

                {!! Form::model($accountuserplans, [
                    'method' => $accountuserplans->exists ? 'put' : 'post',
                    'route'  => $accountuserplans->exists ?
                     ['admin.accountuserplans.update', $accountuserplans->id]:
                     ['admin.accountuserplans.store']
                ]) !!}

                <div class="form-group">
                    <label for="account_plan_id">{{ trans('admin_message.accountuserplans.plan_name') }}:</label>
                    <select name="account_plan_id" id="account_plan_id" class="form-control"
                            required>
                        <option>--</option>
                        @foreach($accountplans as $plan)
                            <option value="{{ $plan->id }}">{{ $plan->plan_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="user_id">{{ trans('admin_message.accountuserplans.user') }}:</label>
                    <select name="user_id" id="user_id" class="form-control"
                            required>
                        <option>--</option>
                        @foreach($vezbaci as $v)
                            <option value="{{ $v->id }}">{{ $v->id }} - {{ $v->name }} {{ $v->lastname }}</option>
                        @endforeach
                    </select>
                </div>

                {!! Form::submit($accountuserplans->exists ? trans('admin_message.accountuserplans.save') : trans('admin_message.accountuserplans.create'), ['class' => 'btn btn-primary btn-flat']) !!}
                    <a href="{!! url('admin/accountuserplans') !!}" title="{{ trans('admin_message.cancel') }}" class="btn btn-danger btn-flat">{{ trans('admin_message.cancel') }}</a>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(function() {

            $('#user_id').select2();


        });
    </script>

@endsection
