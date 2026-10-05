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
                {!! Form::model($globalConf, [
                    'id' => 'global-form',
                    'method' => $globalConf->exists ? 'put' : 'post',
                    'route'  => $globalConf->exists ?
                     ['admin.globalconf.update', $globalConf->id]:
                     ['admin.globalconf.store']
                ]) !!}

                <div class="col-md-12">

                    <div class="form-group">
                        {!! Form::label('time_book', trans('admin_message.global.time_book')) !!}
                        {!! Form::number('time_book', null,['class' => 'form-control']) !!}
                    </div>


                    <div class="form-group">
                        {!! Form::label('time_delay', trans('admin_message.global.time_delay')) !!}
                        {!! Form::number('time_delay', null,['class' => 'form-control']) !!}
                    </div>


                    <div class="form-group">
                        {!! Form::label('time_pause', trans('admin_message.global.time_pause')) !!}
                        {!! Form::number('time_pause', null,['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                       {!! Form::submit($globalConf->exists ? trans('admin_message.global.save') : trans('admin_message.global.create'), ['class' => 'btn btn-primary btn-flat']) !!}
                    </div>

                </div>

                {!! Form::close() !!}

            </div>
            <div class="clearfix"></div>
        </div>
    </div>

@endsection
@section('scripts')


@endsection