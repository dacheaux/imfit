@extends('admin.layout')

@section('title')
    {{ trans('admin_message.sidebar.membership') }}
@endsection

@section('heading')
    {{ trans('admin_message.sidebar.membership') }}
@endsection

@section('style')

@endsection

@section('content')

    <div class="box box-primary">
               <div class="box-header">
            <a href="{{ route('admin.memberships.create') }}" class="btn btn-primary btn-flat">
                <i class="fa fa-user-plus"></i> &nbsp;&nbsp;
                {{ trans('admin_message.membership.create') }}
            </a>
        </div>
        <div class="box-body">
            <p>Crvena - da je istekla članarina <br> Plava - da je na pauzi 7 dana</p>
            <table class="table table-striped table-bordered dt-responsive"  cellspacing="0" width="100%"  id="membership-table" role="grid">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('admin_message.membership.user') }}</th>
                    <th>{{ trans('admin_message.membership.terms_number') }}</th>
                    <th>{{ trans('admin_message.membership.created') }}</th>
                    <th>{{ trans('admin_message.membership.expired_time') }}</th>
                    <th>{{ trans('admin_message.membership.pause_time') }}</th>
                    <th>{{ trans('admin_message.membership.edit') }}</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function() {

            var table = $('#membership-table').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                lengthChange: false,
                ordering: true,
                info: true,
                responsive: true,
                autoWidth: false,
                ajax: '{!! route('admin.memberships.data') !!}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: function ( data, type, row ) {
                                     return 'FA - ' +data.user.id + ' / ' + data.user.name + ' ' + data.user.lastname;
                                 }, name: 'user'},
                    {data: 'terms_number', name: 'terms_number'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'expired_time', name: 'expired_time'},
                    {data: 'pause_time', name: 'pause_time'},
                    {data: 'action0', name: 'action0', orderable: false, searchable: false},
                ],
                "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    console.log(aData);
                  if ( new Date(aData.expired_time) < new Date('{!! \Carbon\Carbon::now() !!}') )
                  {
                    $('td', nRow).css('background-color', '#f2dede' );
                  }
                  if( new Date(aData.pause_time) >= new Date('{!! \Carbon\Carbon::now()->subDays(7) !!}') || aData.pause_flag == 1){
                      $('td', nRow).css('background-color', '#c0dbea' );
                  }
                },
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
            $('body').on(  'change', ':checkbox',function() {

                $(this).hide().parent().append('<i class="fa fa-refresh fa-spin"></i>');

                var token = $('input[name="_token"]').val();
                var active = $(this).attr('name');

                if(active == 'active'){
                    $(this).parents('tr').toggleClass('danger').toggleClass('default');
                }

                $.ajax({
                    url: '/admin/updatemember/' + this.value,
                    type: 'PUT',
                    dataType: 'json',
                    data: { active : this.checked }
                })
                    .done(function() {
                        $('.fa-spin').remove();
                        $('input[type="checkbox"]:hidden').show();
                        table.ajax.reload();
                    })
                    .fail(function() {
                        $('.fa-spin').remove();
                        var chk = $('input[type="checkbox"]:hidden');
                        if(active == 'active') {
                            chk.parents('tr').toggleClass('danger').toggleClass('default');
                        }
                        chk.show().prop('checked', chk.is(':checked') ? null:'checked');
                        alert('Nije updejtovano.');
                    });
            });

        });
    </script>
@endsection