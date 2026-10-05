@extends('layouts.main')
@section('styles')
    <!-- Sweetalert -->
    <link rel="stylesheet" href="{{ asset('assets-admin/css/sweetalert.css') }}">
@endsection
@section('content')
    <!-- breadcrumb section start -->
    @include('partials.breadcrumb', ['pageTitle' => 'profil'])
    <!-- gallery section start -->
    <div class="ff_gallery_wrapper top_padder80 bottom_padder50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="ff_heading">
                        <h1><span>Vaš</span> Profil</h1>
                    </div>
                </div>

                <div class="container bootstrap snippet">

                    {!! Form::model($user, [
                                  'files'=>true,
                                  'id' => 'user-form',
                                  'method' =>'put' ,
                                   'route' => [ 'profil.update', $user->id ]
                              ]) !!}

                    <div class="row justify-content-md-center">
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Form::label('avatar', trans('admin_message.users.avatar')) !!}:
                                <img src="{{ $user->avatar }}" class="avatar img-circle img-thumbnail" alt="avatar">
                            </div>
                            <hr>
                            <div class="form-group">
                                {!! Form::label('note',trans('admin_message.users.note')) !!}:
                                <p>{{ $user->note }}</p>
                            </div>
                        </div>
                        <div class="col-sm-6">

                            <div class="form-group">
                                {!! Form::label('email',trans('admin_message.users.email').'*') !!}
                                <div class="ff_contact_input">
                                {!! Form::text('email', old('email'),['class' => 'form-control', $user->exists ? 'readonly' : '']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('name', trans('admin_message.users.name').'*') !!}
                                {!! Form::text('name', old('name'),['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('lastname', trans('admin_message.users.lastname').'*') !!}
                                {!! Form::text('lastname', old('lastname'),['class' => 'form-control']) !!}
                            </div>

                                <div class="form-group">
                                    {!! Form::label('phone', trans('admin_message.users.phone')) !!}:
                                    {!! Form::text('phone', old('phone'),['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('birth', trans('admin_message.users.birth')) !!}:
                                    {!! Form::date('birth', $user->exists ?  \Carbon\Carbon::parse($user->birth):  \Carbon\Carbon::now(),['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('password',trans('admin_message.users.password')) !!}
                                    {!! Form::password('password',['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('password_confirmation', trans('admin_message.users.password_confirmation')) !!}
                                    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('avatar', trans('admin_message.users.avatar')) !!}:
                                    {!! Form::file('avatar', ['class' => 'file', 'data-preview-file-type' => 'text', 'accept' => 'image/*']) !!}
                                </div>



                                <div class="form-group">
                                    <div class="col-xs-12">
                                        {!! Form::submit($user->exists ? trans('admin_message.users.save') : trans('admin_message.users.create'), ['class' => 'ff_button pull-right']) !!}
                                    </div>
                                </div>

                                <div class="pt-2">
                                    @include('partials.errors')
                                </div>

                            </div>

                    </div><!--/col-9-->

                </div><!--/row-->

                {!! Form::close() !!}

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <!-- Sweetalert -->
    <script src="{{asset('assets-admin/js/sweetalert-dev.js')}}"></script>
    @include('admin.partials._flash')
@endsection