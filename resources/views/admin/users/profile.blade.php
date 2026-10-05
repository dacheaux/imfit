@extends('admin.layout')

@section('title')
    {{ trans('admin_message.profile') }}
@endsection

@section('heading')
    {{ trans('admin_message.profile') }}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-4">
            <!-- Widget: user widget style 1 -->
            <div class="box box-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active">
                    <h3 class="widget-user-username">{{$logedUser->name}}</h3>
                    <h5 class="widget-user-desc">Admin</h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="{{ asset($logedUser->avatar) }}" alt="User Avatar">
                </div>
                <div class="box-footer">
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-sm-6 border-right">
                            <div class="description-block">
                                <h5 class="description-header">{{ $logedUser->posts()->count() }}</h5>
                                <span class="description-text">OBJAVIO POSTOVA</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <div class="col-sm-6">
                            <div class="description-block">
                                <h5 class="description-header">{{$logedUser->created_at}}</h5>
                                <span class="description-text">KREIRAN</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
            <!-- /.widget-user -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">

            {{--<div class="box box-primary">--}}

                {{--<div class="box-header">--}}
                {{--</div>--}}

                {{--<div class="box-body">--}}


                {{--</div>--}}
            {{--</div>--}}
        </div>
    </div>
@endsection