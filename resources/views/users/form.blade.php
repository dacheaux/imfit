@extends($area.'.layout')

@section('title')
    {{ trans('admin_message.sidebar.users') }}
@endsection

@section('heading')
    {{ trans('admin_message.sidebar.users') }}
@endsection

@section('content')

    <div class="col-md-8">
        <div class="box box-primary">

            <div class="box-header">
                <h3>{{$user->exists ? trans('admin_message.users.hedit') .' '.$user->name : trans('admin_message.users.create_user')}}</h3>
            </div>

            <div class="box-body">
                {!! html()->modelForm($user, $user->exists ? 'put' : 'post', ($user->exists ? route($area.'.users.update', $user->id) : route($area.'.users.store')))->acceptsFiles()->attributes(['id' => 'user-form'])->open() !!}
                <div class="col-md-6">
                    @if($logedUser->id != $user->id)
                        {!! html()->label(trans('admin_message.users.roles').'*', 'type') !!}
                         <div class="form-group ">
                             @if(!$roles->isEmpty())
                                <select name="roles" id="roles" class="form-control" required>
                                    @foreach ($roles as $role)
                                        @if($role->id != 1)
                                            <option value="{{ $role->id }}" {{  $role->exists &&  $role->id == $user->hasRole($role->name) ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    @endif

                    <div class="form-group">
                      {!! html()->label(trans('admin_message.users.type').'*', 'type') !!}
                       <select name="type" id="type" class="form-control">
                            <option value="0" {{   $user->exists && 0 == $user->type  ? 'selected' : '' }}>Mesečni</option>
                            <option value="1" {{   $user->exists && 1 == $user->type  ? 'selected' : '' }}>Nedeljni</option>
                        </select>
                    </div>

                    <div class="form-group">
                        {!! html()->label(trans('admin_message.users.email').'*', 'email') !!}
                        {!! html()->text('email')->attributes(['class' => 'form-control'])->attributeIf($user->exists, 'readonly') !!}
                    </div>

                    <div class="form-group">
                        {!! html()->label(trans('admin_message.users.name').'*', 'name') !!}
                        {!! html()->text('name')->attributes(['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! html()->label(trans('admin_message.users.lastname').'*', 'lastname') !!}
                        {!! html()->text('lastname')->attributes(['class' => 'form-control']) !!}
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        {!! html()->label(trans('admin_message.users.phone'), 'phone') !!}
                        {!! html()->text('phone')->attributes(['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! html()->label(trans('admin_message.users.birth'), 'birth') !!}
                        {!! html()->date('birth', $user->exists ?  \Carbon\Carbon::parse($user->birth):  \Carbon\Carbon::now())->attributes(['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! html()->label(trans('admin_message.users.note'), 'note') !!}
                        {!! html()->textarea('note')->attributes(['class' => 'form-control', 'rows' => 2]) !!}
                    </div>

                    <div class="form-group">
                        {!! html()->label(trans('admin_message.users.avatar'), 'avatar') !!}
                        {!! html()->file('avatar')->attributes(['class' => 'file', 'data-preview-file-type' => 'text', 'accept' => 'image/*']) !!}
                    </div>

                </div>

                <div class="pull-right">
                   {!! html()->submit($user->exists ? trans('admin_message.users.save') : trans('admin_message.users.create'))->attributes(['class' => 'btn btn-primary btn-flat']) !!}
                    <a href="{!! url($area.'/users') !!}" title="{{ trans('admin_message.cancel') }}" class="btn btn-danger btn-flat">{{ trans('admin_message.cancel') }}</a>
                    {!! html()->closeModelForm() !!}
                </div>
                <div class="clearfix"></div>

                <br>

            </div>
            <div class="clearfix"></div>
        </div>
    </div>


    @if( $user->exists )
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-body">
                    <h3>Korisnikov QR</h3>
                    @if($user->qrcode)
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(300)->generate($user->qrcode->token)) !!} ">
                    @else
                    <p>Korisnik nema QR kod.</p>
                    {{ html()->form('POST', route($area.'.users.qrcode.store', $user->id))->open() }}
                        <button type="submit" class="btn btn-primary btn-flat">Kreiraj QR kod</button>
                    {!! html()->form()->close() !!}
                    @endif
            </div>
        </div>
    </div>
    @endif


    @if( $user->exists && $user->id != auth()->user()->id )
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-body">

                        <h3>{{ trans('admin_message.users.sendpassword')  }}</h3>

                        {{ html()->form('POST', url('password/email'))->open() }}
                            <div class="form-group hidden">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" >
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block"  onclick="this.disabled=true;this.form.submit();" >{{ trans('admin_message.sendpassword')  }}</button>
                            </div>
                        {!! html()->form()->close() !!}
                </div>

            </div>
        </div>
    @endif


@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/additional-methods.min.js"></script>
    <script src="{!! asset('assets-admin/js/fileinput.min.js') !!}"></script>
    <script src="{!! asset('assets-admin/js/fileinput_locale_sr.js') !!}"></script>

    <script>
                // initialize fileinputs
        $("#avatar").fileinput({
            language: "sr",
            showUpload: false,
            showCaption: false,
            allowedFileExtensions: ["jpg", "jpeg", "png", "gif"],
            previewFileType: "image",
            maxFileSize: 2000,
            browseLabel: 'Izaberi',
            @if($user->exists && $user->avatar != '')
            initialPreview: [
                '<img src="{!! asset($user->avatar) !!}" class="file-preview-image">'
            ],
            @endif
        });


    </script>

@endsection
