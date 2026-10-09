@extends('admin.layout')

@section('title')
    {{ trans('admin_message.sidebar.global') }}
@endsection

@section('heading')
    {{ trans('admin_message.sidebar.global') }}
@endsection

@section('content')

    <div class="col-md-4">
        <div class="box box-primary">

            <div class="box-header">
                <h3>{{ trans('admin_message.global.title')}}</h3>
            </div>

            <div class="box-body">
                {!! html()->modelForm($globalConf, $globalConf->exists ? 'put' : 'post', ($globalConf->exists ? route('admin.globalconf.update', $globalConf->id) : route('admin.globalconf.store')))->attributes(['id' => 'global-form'])->open() !!}

                <div class="col-md-12">

                    <div class="form-group">
                        {!! html()->label(trans('admin_message.global.time_book'), 'time_book') !!}
                        {!! html()->number('time_book')->attributes(['class' => 'form-control']) !!}
                    </div>


                    <div class="form-group">
                        {!! html()->label(trans('admin_message.global.time_delay'), 'time_delay') !!}
                        {!! html()->number('time_delay')->attributes(['class' => 'form-control']) !!}
                    </div>


                    <div class="form-group">
                        {!! html()->label(trans('admin_message.global.time_pause'), 'time_pause') !!}
                        {!! html()->number('time_pause')->attributes(['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                       {!! html()->submit($globalConf->exists ? trans('admin_message.global.save') : trans('admin_message.global.create'))->attributes(['class' => 'btn btn-primary btn-flat']) !!}
                    </div>

                </div>

                {!! html()->closeModelForm() !!}

            </div>
            <div class="clearfix"></div>
        </div>
    </div>

@endsection
@section('scripts')


@endsection