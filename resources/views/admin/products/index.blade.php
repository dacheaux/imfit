@extends('admin.layout')

@section('title', 'Proizvodi')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.dataTables.min.css">
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
        .select2-container--default .select2-results__option[aria-disabled=true] {
            color: #999;
            background-color: #eee;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: #000;
        }
    </style>
@endsection
@section('content')

    <div class="box box-primary">

            <div class="box-header">
                <div class="col-md-12">
                    <div class="form-group">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-4"><i class="iconsminds-add"></i> Dodaj novi proizvod</a>
                    </div>
                </div>

                {{ Form::open() }}

                <div class="form-group">
                    <div class="col-md-4">
                        <label for="category_id">Filtriranje po kategoriji:</label>
                        <select name="category_id" id="category_id" class="form-control" style="width: 100%;">
                            <option value="Sve">Sve</option>
                            @foreach($categories as $cat)
                                @if(count($cat->categories) > 0 )
                                <option value="{{ $cat->id }}" class="opt-disabled" disabled="disabled" >{{ $cat->category_name}}</option>
                                @foreach($cat->categories as $sub_category )
                                    <option value="{{ $sub_category->id }}">-{{ $sub_category->category_name}}</option>
                                @endforeach
                                @else
                                <option value="{{ $cat->id }}" class="opt-disabled" >{{ $cat->category_name}}</option>
                                @endif
                            @endforeach
                        </select>
                        {!! Form::hidden('category_id', 1, ['id' => 'categoryId']) !!}
                    </div>
                </div>

                {{ Form::close() }}

            </div>

            <div class="box-body">
            <p>*Ne sortirati pod sve</p>
                <table class="table table-striped table-bordered dt-responsive" id="products-table"  cellspacing="0" width="100%" role="grid">
                    <thead>
                        <tr>
                            <th>Sort</th>
                            <th>Slika</th>
                            <th>Naziv</th>
                            <th>Cena</th>
                            <th>Količina</th>
                            <th>Kategorija</th>
                            <th>Kreiran</th>
                            <th>Vidljivost</th>
                            <th>Izmeni</th>
                            <th>Obriši</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>

            </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js"></script>
    <script>
        $(function() {


            $('#category_id').select2();

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


            $('#category_id').change(function(e) {
                setSelectValue('#categoryId', this.value);
                setSelectValue('#category_id', this.value);
                table.draw();
                e.preventDefault();
            });

            var table = $('#products-table').DataTable({
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
                rowReorder: {
                    dataSrc: 'order',
                    update: false,
                },
                autoWidth: false,
                ajax: {
                    url:'{!! route('admin.products.data' ) !!}',
                    data: function (d) {
                        d.category_id = $('#category_id').val();
                    }
                },
                {{--ajax: '{!! route('admin.products.data') !!}',--}}
                columns: [
                    {data: 'order', name: 'order', className: 'reorder', orderable: false, searchable: false },
                    {data: 'image', name: 'image'},
                    {data: 'product_name', name: 'product_name'},
                    {data: 'product_price', name: 'product_price'},
                    {data: 'product_quantity', name: 'product_quantity'},
                    {data: 'category', name: 'category', orderable: false, searchable: false},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                    {data: 'action0', name: 'action', orderable: false, searchable: false},
                    {data: 'action1', name: 'action1', orderable: false, searchable: false},
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


            // Ajax
            $('.table').on(  'change', ':checkbox',function() {

                $(this).hide().parent().append('<i class="fa fa-refresh fa-spin"></i>');

                var token = $('input[name="_token"]').val();
                var inactive = $(this).attr('name');

                if(inactive == 'inactive'){
                    $(this).parents('tr').toggleClass('danger').toggleClass('default');
                }
                $.ajax({
                    url: '/admin/updatevisible/' + this.value,
                    type: 'PUT',
                    data: inactive + "=" + this.checked + "&_token=" + token
                })
                    .done(function() {
                        $('.table > .fa-spin').remove();
                        $('.table > input[type="checkbox"]:hidden').show();
                        table.ajax.reload();
                    })
                    .fail(function() {
                        $('.table > .fa-spin').remove();
                        var chk = $('.table > input[type="checkbox"]:hidden');
                        if(inactive == 'inactive') {
                            chk.parents('tr').toggleClass('danger').toggleClass('default');
                        }
                        chk.show().prop('checked', chk.is(':checked') ? null:'checked');
                        alert('Nije updejtovano.');
                    });
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
                    url: '{!! route('admin.products.order' ) !!}',
                    type: 'POST',
                    data: jsonString,
                    dataType: 'json',
                    success: function (json) {
                        $('#products-table').DataTable().ajax.reload(); // now refresh datatable
                    }
                });
            });

        });
    </script>
@endsection
