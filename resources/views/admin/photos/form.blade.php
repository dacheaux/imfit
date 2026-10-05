@extends('admin.layout')

@section('title')
    {{ trans('admin_message.sidebar.photo') }}
@endsection

@section('heading')
    {{ trans('admin_message.sidebar.photo') }}
@endsection

@section('style')
<link rel="stylesheet" href="{!! asset('assets-admin/css/fileinput.min.css') !!}" type="text/css" charset="utf-8" />
@endsection

@section('content')

    <div class="box box-primary">
        <div class="box-header">
            <h3>{{$photo->exists ? trans('admin_message.photos.edit') .' '.$photo->title : trans('admin_message.photos.create')}}</h3>
        </div>
        <div class="box-body">
               {!! Form::model($photo, [
                'files' => true,
                'id' => 'photo-form',
                'method' => $photo->exists ? 'put' : 'post',
                'route'  => $photo->exists ?
                 ['admin.photos.update', $photo->id]:
                 ['admin.photos.store']
            ]) !!}

            {!! Form::hidden('photoId', $photo->photo_id,['id' =>'photoId']) !!}

            <div class="form-group">
                {!! Form::label('title', trans('admin_message.photos.title')) !!}
                {!! Form::text('title', null,['class' => 'form-control']) !!}
            </div>

           <div class="form-group">
                {!! Form::label('description', trans('admin_message.photos.description')) !!}
                {!! Form::text('description', null,['class' => 'form-control']) !!}
            </div>

              <div class="form-group">
                {!! Form::label('path', trans('admin_message.photos.image')) !!}
                {!! Form::file('path', ['class' => 'file', 'data-preview-file-type' => 'text', 'accept' => 'image/*']) !!}
                <div id="path-messagge"></div>
              </div>
            <hr>

            {!! Form::submit($photo->exists ? trans('admin_message.photos.save') : trans('admin_message.photos.create'), ['class' => 'btn btn-primary btn-flat']) !!}
            <a href="{!! url('admin/photos') !!}" title="{{ trans('admin_message.cancel') }}" class="btn btn-danger btn-flat">{{ trans('admin_message.cancel') }}</a>

            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/additional-methods.min.js"></script>
    <script src="{!! asset('assets-admin/js/fileinput.min.js') !!}"></script>
    <script src="{!! asset('assets-admin/js/fileinput_locale_sr.js') !!}"></script>

    <script>


        // initialize fileinputs
        $("#path").fileinput({
            language: "sr",
            showUpload: false,
            showCaption: false,
            allowedFileExtensions: ["jpg", "jpeg", "png", "gif"],
            previewFileType: "image",
            maxFileSize: 2000,
            browseLabel: 'Izaberi',
            @if($photo->exists && $photo->thumbnail_path != '')
            initialPreview: [
                '<img src="{!! asset($photo->thumbnail_path) !!}" class="file-preview-image">'
            ],
                @if($photo->path != 'gallery/photos/no-image.png')
                    initialPreviewConfig: [
                        {
                            url: "/admin/image-photos",
                            extra: {
                                pos: 0,
                                _token: "{{ csrf_token() }}",
                                _method: "DELETE",
                                photo_id: "{{$photo->id}}"
                            }
                        }
                    ]
                @endif
            @endif
        });

         var $photoVal = $('#photo-form').validate({
                validClass: "pass",
                rules: {
                    title: {
                        minlength: 2,
                        maxlength:100,
                        required: true
                    },
                    description: {
                        minlength: 2,
                        maxlength:260,
                        required: true
                    },

                },
                messages:{
                    title: {
                        required: "Unesite naslov.",
                        minlength: jQuery.validator.format("Unesite bar {0} karaktera."),
                        maxlength: jQuery.validator.format("Maksimalan broj karaktera je {0}.")
                    },
                    description: {
                        required: "Unesite opis.",
                        minlength: jQuery.validator.format("Unesite bar {0} karaktera."),
                        maxlength: jQuery.validator.format("Maksimalan broj karaktera je {0}.")
                    },
                },

                highlight: function (element) {
                    $(element).removeClass('success').addClass('error');
                    $(element).closest('.form-group').removeClass('success').addClass('has-error');
                },
                success: function (element) {
                    element.text('OK!').closest('.form-group').removeClass('has-error').addClass('has-success');
                },
                errorPlacement: function(error, element) {
                    if (element.attr('id') == 'path') {
                      error.appendTo("#path-messagge");
                    } else {
                      error.insertAfter(element);
                    }
                  },
                submitHandler: function(form) {

                    form.submit();

                }
            });
    </script>

@stop