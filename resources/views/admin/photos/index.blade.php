@extends('admin.layout')

@section('title')
    {{ trans('admin_message.sidebar.photo') }}
@endsection

@section('heading')
    {{ trans('admin_message.sidebar.photo') }}
@endsection

@section('style')
<style>

</style>
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.dataTables.min.css">
@endsection

@section('content')

    <div class="box box-primary">
         <div class="box-header">

            {{ Form::open() }}

                <div class="form-group">
                     <div class="col-md-4">
                         <label for="pages">Izaberi stranu:</label>
                        {!! Form::select('pages', $pages,  null,['class' => 'form-control', 'id' => 'photo_id']) !!}
                        {!! Form::hidden('page_id', 1, ['id' => 'page_id']) !!}
                    </div>
                </div>

            {{ Form::close() }}
        </div>
        <div class="box-body">

             <a href="#" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-default">
                  <i class="fa fa-plus"></i> &nbsp;&nbsp;
                {{ trans('admin_message.photos.create') }}
            </a>

            <hr>

            <table class="table table-striped table-bordered dt-responsive" id="photos-table" cellspacing="0" width="100%" role="grid">
                <thead>
                    <tr>
                        <th>{{ trans('admin_message.photos.order') }}</th>
                        <th>{{ trans('admin_message.photos.thumb') }}</th>
                        <th>{{ trans('admin_message.photos.title') }}</th>
                        <th>{{ trans('admin_message.photos.description') }}</th>
                        <th>{{ trans('admin_message.photos.created') }}</th>
                        <th>{{ trans('admin_message.photos.edit') }}</th>
                        <th>{{ trans('admin_message.photos.delete') }}</th>
                        <th></th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>

    @include('admin.photos.modal')

@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/additional-methods.min.js"></script>
    <script src="{!! asset('assets-admin/js/fileinput.min.js') !!}"></script>
    <script src="{!! asset('assets-admin/js/fileinput_locale_sr.js') !!}"></script>

    <script>
        // initialize fileinputs
        var $el = $("#path");

        $el.fileinput({
            language: "sr",
            showUpload: false,
            showCaption: false,
            allowedFileExtensions: ["jpg", "jpeg", "png", "gif"],
            previewFileType: "image",
            maxFileSize: 2000,
            browseLabel: 'Izaberi',
            {{--@if($photo->exists && $photo->thumbnail_path != null)--}}
            {{--initialPreview: [--}}
                {{--'<img src="{!! asset($photo->thumbnail_path) !!}" class="file-preview-image">'--}}
            {{--],--}}
            {{--initialPreviewConfig: [--}}
                {{--{--}}
                    {{--url: "/admin/image-photos",--}}
                    {{--extra: {--}}
                        {{--pos: 0,--}}
                        {{--_token: "{{ csrf_token() }}",--}}
                        {{--_method: "DELETE",--}}
                        {{--logo_id: "{{$photo->id}}"--}}
                    {{--}--}}
                {{--}--}}
            {{--]--}}
            {{--@endif--}}
        });
    </script>
    <script>


    $(function() {

        // Processing plugin
		jQuery.fn.dataTable.Api.register( 'processing()', function ( show ) {
			return this.iterator( 'table', function ( ctx ) {
				ctx.oApi._fnProcessingDisplay( ctx, show );
			} );
		} );


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function setSelectValue(id, val) {
            $(id).val(val);
         }


        $('#photo_id').change(function(e) {
            setSelectValue('#page_id', this.value);
            setSelectValue('#photoId', this.value);
             table.draw();
             e.preventDefault();
        });


            var $photoVal = $('#photo-form-add').validate({
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
                    path: {
                        required: true,
                    }

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
                    path: {
                        required: "Unesite sliku.",
                    }
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

                    $("#photo-add").prop('disabled', true);

                    var formData = new FormData(form);

                    $.ajax({
                        url: '{!! route('admin.photos.store' ) !!}',
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        data: formData,
                        success: function (result) {
                            $('#modal-default').modal('hide');
                            $el.fileinput('refresh');
                            $photoVal.reset();
                            $('#photo-form-add').find('.form-group').removeClass('has-success').find('.error').hide();
                            $(':input','#photo-form-add')
                             .not(':button, :submit, :reset, :hidden')
                             .val('')
                             .removeAttr('checked')
                             .removeAttr('selected');
                             $("#photo-add").prop('disabled', false);
                             $('#photos-table').DataTable().ajax.reload(); // now refresh datatable
                             swal({
                                title: "Uspešno!",
                                text: "Slika je uspešno dodata.",
                                type: "success",
                                confirmButtonText: 'Zatvori',
                                html: true
                            });
                        }
                    });


                    return false;

                }
            });

             $('#modal-default').on('hidden.bs.modal', function () {

             });

        $(document).on('click', '.photo-delete a',function(e){

            var r = confirm("Da li ste sigruni?");

            if (r == true) {

                var photoid = $(this).data('photoid');

                $.ajax({
                    url: '{!! route('admin.photos.deletephoto') !!}',
                    type: 'DELETE',
                    data: {id: photoid},
                    success: function (result) {
                        $('#photos-table').DataTable().ajax.reload(); // now refresh datatable
                        swal({
                            title: "Uspešno!",
                            text: "Slika je uspešno obrisana.",
                            type: "success",
                            confirmButtonText: 'Zatvori',
                            html: true
                        });
                    }
                });
            }

            return false;

        });

        {{--$(document).on('click', '.photo-edit a',function(e){--}}


                {{--var photoid = $(this).data('photoid');--}}

                {{--$.ajax({--}}
                    {{--url: '{!! route('admin.photos.editphoto') !!}',--}}
                    {{--type: 'GET',--}}
                    {{--data: {id: photoid},--}}
                    {{--success: function (result) {--}}

                        {{--console.log(result);--}}
                         {{--$('#modal-default').modal({--}}
                            {{--show: 'true'--}}
                        {{--});--}}
                        {{--$('#idphoto').val(result.id);--}}
                        {{--$('#title').val(result.title);--}}
                        {{--$('#description').val(result.description);--}}
                        {{--$('#photoId').val(result.photo_id);--}}
                        {{--$("#photo-add").attr('id', 'edit-product');--}}


                    {{--}--}}
                {{--});--}}
        {{--});--}}


        {{--$('#photo-form-add').submit(function() {--}}

            {{--var formData = new FormData($(this)[0]);--}}

            {{--$.ajax({--}}
                {{--url: '{!! route('admin.photos.store' ) !!}',--}}
                {{--type: 'POST',--}}
                {{--processData: false,--}}
                {{--contentType: false,--}}
                {{--data: formData,--}}
                {{--success: function (result) {--}}
                    {{--$('#modal-default').modal('hide');--}}
                    {{--$el.fileinput('refresh');--}}
                    {{--$(':input','#photo-form-add')--}}
                     {{--.not(':button, :submit, :reset, :hidden')--}}
                     {{--.val('')--}}
                     {{--.removeAttr('checked')--}}
                     {{--.removeAttr('selected');--}}
                    {{--$('#photos-table').DataTable().ajax.reload(); // now refresh datatable--}}
                     {{--swal({--}}
                        {{--title: "Uspešno!",--}}
                        {{--text: "Slika je uspešno dodata.",--}}
                        {{--type: "success",--}}
                        {{--confirmButtonText: 'Zatvori',--}}
                        {{--html: true--}}
                    {{--});--}}
                {{--}--}}
            {{--});--}}

            {{--return false--}}

        {{--});--}}

        var table = $('#photos-table').DataTable({
            processing: true,
            serverSide: true,
            paging: false,
            lengthChange: false,
            ordering: true,
            info: true,
            responsive: {
                details: {
                    type: 'column',
                    target: -1
                }
            },
            columnDefs: [
                {   className: 'control',
                    orderable: false,
                    responsivePriority: 1,
                    targets: -1
                }
            ],
            autoWidth: false,
            rowReorder: {
                dataSrc: 'order',
                update: false,
            },
            ajax: {
                url:'{!! route('admin.photos.data' ) !!}',
                data: function (d) {
                    d.photo_id = $('#page_id').val();
                }
            },
            columns: [
                {data: 'order', name: 'order', className: 'reorder', orderable: false, searchable: false },
                {data: 'thumb', name: 'thumb', searchable: false},
                {data: 'title', name: 'title'},
                {data: 'description', name: 'description'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action0', name: 'action', orderable: false, searchable: false},
                {data: 'action1', name: 'action', orderable: false, searchable: false},
                {data: 'responsive', name: 'responsive', orderable: false, searchable: false},
            ],
            @if (App::getLocale() == 'sr')
            "language": {
                "sProcessing":   "Učitavanje u toku...",
                "sLengthMenu":   "Prikaži _MENU_ rezultata",
                "sZeroRecords":  "Nije pronađen nijedan rezultat",
                "sInfo":         "Prikaz _START_ do _END_ od ukupno _TOTAL_ rezultata",
                "sInfoEmpty":    "Prikaz 0 do 0 od ukupno 0 rezultata",
                "sInfoFiltered": "(filtrirano od ukupno _MAX_ rezultata)",
                "sInfoPostFix":  "",
                "sSearch":       "Pretraga:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "Početna",
                    "sPrevious": "Prethodna",
                    "sNext":     "Sledeća",
                    "sLast":     "Poslednja"
                }
            }
            @endif
        });



        table.on('row-reorder', function (e, diff, edit) {

            table.processing( true );

            var myArray = [];

            for (var i = 0, ien = diff.length; i < ien; i++) {
                var rowData = table.row(diff[i].node).data();
                myArray.push({
                    id: rowData.id,			// record id from datatable
                    position: diff[i].newPosition,		// new position
                });
            }

            var jsonString = JSON.stringify(myArray);

            $.ajax({
                url: '{!! route('admin.photos.order' ) !!}',
                type: 'POST',
                data: jsonString,
                dataType: 'json',
                success: function (json) {
                    $('#photos-table').DataTable().ajax.reload(); // now refresh datatable
                }
            });
        });


    });


    </script>
@endsection