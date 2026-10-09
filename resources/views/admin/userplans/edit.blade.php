@extends('admin.layout2')

@section('title')
    {{ trans('admin_message.sidebar.userplans') }}
@endsection

@section('heading')
    {{ trans('admin_message.sidebar.userplans') }}
@endsection

@section('style')
    <link rel="stylesheet"
          href="{!! asset('assets-admin/admin2/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') !!}"/>
@endsection

@section('content')

    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3>{{$userplans->exists ? trans('admin_message.plans.edit_workout') .' '.$userplans->id : trans('admin_message.plans.create_plan')}}</h3>
            </div>
            <div class="box-body">

                @if($userplans->active == 1 && $userplans->exists && $userplans->expired_time < \Carbon\Carbon::now() )
                    <h2 class="alert-info text-center">Plan istekao</h2>
                @endif

                {!! html()->modelForm($userplans, $userplans->exists ? 'put' : 'post', ($userplans->exists ? route('admin.userplans.update', $userplans->id) : route('admin.userplans.store')))->open() !!}

                <div class="form-group">
                    {!! html()->label(trans('admin_message.userplans.user_id'), 'name') !!}
                    {!! html()->text('name', $userplans->exists ? $userplans->user->name . ' ' . $userplans->user->lastname : null)->attributes(['class' => 'form-control', 'readonly']) !!}
                </div>

                <div class="form-group">
                    {!! html()->label(trans('admin_message.userplans.plan_id'), 'name') !!}
                    {!! html()->text('name', $userplans->exists ? $userplans->plan->name : null)->attributes(['class' => 'form-control', 'readonly']) !!}
                </div>

                <div class="form-group">
                    {!! html()->label(trans('admin_message.userplans.terms_number'), 'terms_number') !!}
                    {!! html()->number('terms_number')->attributes(['class' => 'form-control', 'min' => 0]) !!}
                </div>

                <div class="form-group">
                    {!! html()->label(trans('admin_message.userplans.expired_time'), 'expired_time') !!}
                    <div class='input-group date' id='expired_time'>
                        <input type='text' class="form-control" name="expired_time" value="" />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>

                    {!! html()->submit($userplans->exists ? trans('admin_message.userplans.save_workout') : trans('admin_message.userplans.create_plan'))->attributes(['class' => 'btn btn-primary btn-flat']) !!}
                    <a href="{!! url('admin/userplans') !!}" title="{{ trans('admin_message.cancel') }}" class="btn btn-danger btn-flat">{{ trans('admin_message.cancel') }}</a>
                {!! html()->closeModelForm() !!}

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript"
            src="{!! asset('assets-admin/admin2/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') !!}"></script>
    <script>
        $(function () {

            @if(!$userplans->exists )

            var date = new Date();
            date.setDate(date.getDate());

            $('#expired_time').datetimepicker({
                locale: 'sr',
                minDate: date
            });

            @else

            $('#expired_time').datetimepicker({
                locale: 'sr',
                defaultDate: '{!! $userplans->expired_time  !!}'
            });

            @endif

        });
    </script>
@endsection