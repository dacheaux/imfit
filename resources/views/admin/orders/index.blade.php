@extends('admin.layout')

@section('title', 'Porudžbine')

@section('style')
    <script>
        var APP_URL = {!! json_encode(url('/')) !!};
    </script>
@endsection

@section('content')


        <div class="box box-primary">
            <div class="box-header">
                <h3>Porudžbine</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered dt-responsive "  id="orders-table" cellspacing="0" width="100%" role="grid">
                    <thead>
                        <tr>
                            <th>Br.</th>
                            <th>Detalji</th>
                            <th>Ime</th>
                            <th>Prezime</th>
                            <th>Iznos</th>
                            <th>Datum i vreme</th>
                            <th>Status</th>
                            <th>Brisanje</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

@endsection

@section('scripts')
    <script>
        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#orders-table').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                lengthChange: false,
                ordering: true,
                info: true,
                responsive: true,
                autoWidth: false,
                ajax: '{!! route('admin.ordersData') !!}',
                columns: [
                    {data: 'id', name: 'id'},
                    {
                        data: 'views',
                        render: function (data, type, row, meta) {
                            return row.views
                        }
                    },
                    {data: 'user.name', name: 'user.name'},
                    {data: 'user.lastname', name: 'user.lastname'},
                     {
                        data: function (data, type, row) {
                            var amount = parseInt(data.order_amount);
                            return amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')   + ' RSD';
                        }, name: 'order_amount'
                    },
                    {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
                    {data: 'status', name: 'status', orderable: false, searchable: false},
                    {data: 'action1', name: 'action', orderable: false, searchable: false},

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
            $('#orders-table tbody').on('click', '[class^="delete"]', function () {
                var ok = confirm("Da li ste sigurni?");
                var id = this.id;
                if (ok) {
                    $.ajax({
                            method: 'DELETE',
                            url: APP_URL + '/admin/orders/' + id,
                            dataType: 'json',
                            success: function (d) {
                                table.ajax.reload();
                            }

                        }
                    );
                }

            });

            // Ajax
            $('body').on('change', '.orderStatus', function (e) {
                console.log($(this).find(":selected").data('status'));

                var token = $('meta[name="csrf-token"]').val();
                var status = $(this).find(":selected").data('status');

                $.ajax({
                    url: APP_URL + '/admin/ordersStatus/' + $(this).data('id'),
                    data: "status=" + status + "&_token=" + token ,
                    type: 'PUT',
                    success: function (result) {
                        if (result) {
                            table.ajax.reload();
                        } else {
                            alert('error');
                        }
                    }
                });

                e.preventDefault();
            });

        });
    </script>
@endsection
