@extends('admin.layout2')

@section('title')
    {{ trans('admin_message.sidebar.termpatterns') }}
@endsection

@section('heading')
    {{ trans('admin_message.sidebar.termpatterns') }}
@endsection

@section('style')
    <link rel="stylesheet" href="{!! asset('assets-admin/admin2/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') !!}"/>
@endsection

@section('content')

    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">

            </div>

            <div class="box-body">
                {!! html()->modelForm($termpattern, $termpattern->exists ? 'put' : 'post', ($termpattern->exists ? route('admin.termpatterns.update', $termpattern->id) : route('admin.termpatterns.store')))->attributes(['id' => 'termpatterns-form'])->open() !!}

                <div class="col-md-12">
                    <div class="form-group">
                        <div class='input-group '>
                            {!! html()->label(trans('admin_message.termpatterns.name'), 'name') !!}
                            {!! html()->text('name', $termpattern->exists ? $termpattern->name : '')->attributes(['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="workout_id">{{ trans('admin_message.termpatterns.workout') }}:</label>
                        <select name="workout_id" id="workout_id" class="form-control"
                                required>
                            @foreach($workouts as $workout)
                                <option value="{{ $workout->id }}" {{ $workout->id == $termpattern->workout_id ? 'selected' : '' }}>{{ $workout->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="trener_id">{{ trans('admin_message.termpatterns.coach') }}:</label>
                        <select name="trener_id" id="trener_id" class="form-control"
                                required>
                            @foreach($coaches as $coach)
                                <option value="{{ $coach->id }}" {{ $coach->id == $termpattern->trener_id ? 'selected' : '' }}>{{ $coach->name }} {{ $coach->lastname }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <div class='input-group date' id="hours">
                            <table  class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th width="70%">Vreme početka:</th>
                                        <th width="40%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($termpattern->exists )
                                    <tr>
                                        <td><button type="button" name="add" id="add" class="btn btn-success">Dodaj</button></td>
                                    </tr>

                                    @if(count(unserialize($termpattern->hours)) > 0)
                                        @foreach(unserialize($termpattern->hours) as $termp)
                                            <tr>
                                                <td><input type="text" name="hours[]" value="{{ $termp->format('H:i')}}" class="form-control hours"/></td>
                                                <td><button type="button" name="remove"  class="btn btn-danger remove">Obriši</button></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class='input-group '>
                            {!! html()->label(trans('admin_message.termpatterns.slot'), 'slots') !!}
                            {!! html()->number('slots', $termpattern->exists ? $termpattern->slots : '')->attributes(['class' => 'form-control', 'min' => 0]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class='input-group '>
                            {!! html()->label(trans('admin_message.termpatterns.note'), 'note') !!}
                            {!! html()->textarea('note', $termpattern->exists ? $termpattern->note : '')->attributes(['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group pull-right">
                        {!! html()->submit($termpattern->exists ? trans('admin_message.users.save') : trans('admin_message.termpatterns.create'))->attributes(['class' => 'btn btn-primary btn-flat', 'id' => 'save']) !!}
                        <a href="{!! url('admin/termpatterns') !!}" title="{{ trans('admin_message.cancel') }}"
                           class="btn btn-danger btn-flat">{{ trans('admin_message.cancel') }}</a>
                    </div>

                    {!! html()->closeModelForm() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript"
            src="{!! asset('assets-admin/admin2/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') !!}"></script>
    <script>
        $(function () {

            var date = new Date();
            date.setDate(date.getDate());

            $('body').on('focus',".hours", function(){
                $(this).datetimepicker({
                    locale: 'sr',
                    format: 'HH:mm',
                });
            });

            $('.hours').datetimepicker({
                locale: 'sr',
                format: 'HH:mm',
            });

        });
    </script>
    <script>
        $(document).ready(function(){

            @if(!$termpattern->exists )
                var count = 1;

                dynamic_field(count);

                function dynamic_field(number)
                {
                    html = '<tr>';
                    html += '<td><input type="text" name="hours[]" class="form-control hours" /></td>';
                    if(number > 1)
                    {
                        html += '<td><button type="button" name="remove"  class="btn btn-danger remove">Obriši</button></td></tr>';
                        $('tbody').append(html);
                    }
                    else
                    {
                        html += '<td><button type="button" name="add" id="add" class="btn btn-success">Dodaj</button></td></tr>';
                        $('tbody').html(html);
                    }
                }
            @else

                var count = {{ count(unserialize($termpattern->hours))  }};


                function dynamic_field(number)
                {

                    var html = '<tr>';
                    if(number  > 1  )
                    {
                        html += '<td><input type="text" name="hours[]" class="form-control hours" /></td>';
                        html += '<td><button type="button" name="remove"  class="btn btn-danger remove">Obriši</button></td></tr>';
                        $('tbody').append(html);
                    }
                    else
                    {
                        html += '<td><input type="text" name="hours[]" class="form-control hours" /></td>';
                        html += '<td><button type="button" name="remove"  class="btn btn-danger remove">Obriši</button></td></tr>';
                        $('tbody').append(html);
                    }
                }

            @endif

            $(document).on('click', '#add', function(){
                count++;
                dynamic_field(count);
            });

            $(document).on('click', '.remove', function(){
                count--;
                $(this).closest("tr").remove();
            });

            {{--$('#termpatterns-form').on('submit', function(event){--}}
                {{--event.preventDefault();--}}
                {{--$.ajax({--}}
                    {{--url:'{{ route("admin.termpatterns.store") }}',--}}
                    {{--method:'post',--}}
                    {{--data:$(this).serialize(),--}}
                    {{--dataType:'json',--}}
                    {{--beforeSend:function(){--}}
                        {{--$('#save').attr('disabled','disabled');--}}
                    {{--},--}}
                    {{--success:function(data)--}}
                    {{--{--}}
                        {{--if(data.error)--}}
                        {{--{--}}
                            {{--var error_html = '';--}}
                            {{--for(var count = 0; count < data.error.length; count++)--}}
                            {{--{--}}
                                {{--error_html += '<p>'+data.error[count]+'</p>';--}}
                            {{--}--}}
                            {{--$('#result').html('<div class="alert alert-danger">'+error_html+'</div>');--}}
                        {{--}--}}
                        {{--else--}}
                        {{--{--}}
                            {{--dynamic_field(1);--}}
                            {{--$('#result').html('<div class="alert alert-success">'+data.success+'</div>');--}}
                        {{--}--}}
                        {{--$('#save').attr('disabled', false);--}}
                    {{--}--}}
                {{--})--}}
            {{--});--}}

        });
    </script>


@endsection
