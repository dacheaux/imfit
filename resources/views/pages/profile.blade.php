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

                    {!! html()->modelForm($user, 'PUT', route('profil.update', $user->id))->acceptsFiles()->attributes(['id' => 'user-form'])->open() !!}

                    <div class="row justify-content-md-center">
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! html()->label(trans('admin_message.users.avatar'), 'avatar') !!}:
                                <img src="{{ $user->avatar }}" class="avatar img-circle img-thumbnail" alt="avatar">
                            </div>
                            <hr>
                            <div class="form-group">
                                {!! html()->label(trans('admin_message.users.note'), 'note') !!}:
                                <p>{{ $user->note }}</p>
                            </div>
                        </div>
                        <div class="col-sm-6">

                            <div class="form-group">
                                {!! html()->label(trans('admin_message.users.email').'*', 'email') !!}
                                <div class="ff_contact_input">
                                {!! html()->text('email', old('email'))->attributes(['class' => 'form-control'])->attributeIf($user->exists, 'readonly') !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! html()->label(trans('admin_message.users.name').'*', 'name') !!}
                                {!! html()->text('name', old('name'))->attributes(['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! html()->label(trans('admin_message.users.lastname').'*', 'lastname') !!}
                                {!! html()->text('lastname', old('lastname'))->attributes(['class' => 'form-control']) !!}
                            </div>

                                <div class="form-group">
                                    {!! html()->label(trans('admin_message.users.phone'), 'phone') !!}:
                                    {!! html()->text('phone', old('phone'))->attributes(['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! html()->label(trans('admin_message.users.birth'), 'birth') !!}:
                                    {!! html()->date('birth', $user->exists ?  \Carbon\Carbon::parse($user->birth):  \Carbon\Carbon::now())->attributes(['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! html()->label(trans('admin_message.users.password'), 'password') !!}
                                    {!! html()->password('password')->attributes(['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! html()->label(trans('admin_message.users.password_confirmation'), 'password_confirmation') !!}
                                    {!! html()->password('password_confirmation')->attributes(['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! html()->label(trans('admin_message.users.avatar'), 'avatar') !!}:
                                    {!! html()->file('avatar')->attributes(['class' => 'file', 'data-preview-file-type' => 'text', 'accept' => 'image/*']) !!}
                                </div>



                                <div class="form-group">
                                    <div class="col-xs-12">
                                        {!! html()->submit($user->exists ? trans('admin_message.users.save') : trans('admin_message.users.create'))->attributes(['class' => 'ff_button pull-right']) !!}
                                    </div>
                                </div>

                                <div class="pt-2">
                                    @include('partials.errors')
                                </div>

                            </div>

                    </div><!--/col-9-->

                </div><!--/row-->

                {!! html()->closeModelForm() !!}

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <!-- Sweetalert -->
    <script src="{{asset('assets-admin/js/sweetalert-dev.js')}}"></script>
    @include('admin.partials._flash')
@endsection