@extends('admin.layout2')
@section('title')
    {{ trans('admin_message.sidebar.terms') }}
@endsection

@section('heading')
    {{ trans('admin_message.sidebar.terms') }}
@endsection
@section('style')
    <link rel="stylesheet"
          href="{!! asset('assets-admin/admin2/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') !!}"/>
@endsection
@section('content')

    <div class="col-md-4">
        <div class="box box-primary">

            @if($terms->exists && $terms->start_datetime < \Carbon\Carbon::now() )
                <h2 class="alert-info text-center">Završen termin.</h2>
            @endif

            <div class="box-header">
                {{--<h3>{{$terms->exists ? trans('admin_message.term.edit') .' ' : trans('admin_message.term.create')}}</h3>--}}
            </div>

            <div class="box-body">
                {!! html()->modelForm($terms, $terms->exists ? 'put' : 'post', ($terms->exists ? route('admin.terms.update', $terms->id) : route('admin.terms.store')))->attributes(['id' => 'term-form'])->open() !!}
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="workout_id">{{ trans('admin_message.term.workout') }}:</label>
                        <select name="workout_id" id="workout_id" class="form-control"
                                required>
                            @foreach($workouts as $workout)
                                <option value="{{ $workout->id }}" {{ $workout->id == $terms->workout_id ? 'selected' : '' }}>{{ $workout->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="trener_id">{{ trans('admin_message.term.coach') }}:</label>
                        <select name="trener_id" id="trener_id" class="form-control"
                                required>
                            @foreach($coaches as $coach)
                                <option value="{{ $coach->id }}" {{ $coach->id == $terms->trener_id ? 'selected' : '' }}>{{ $coach->name }} {{ $coach->lastname }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        {!! html()->label(trans('admin_message.term.start_datetime'), 'start_datetime') !!}
                        <div class='input-group date' id='start_datetime'>
                            <input type='text' class="form-control" name="start_datetime"  {!!  isset($userTerm->userTerms) ? 'disabled': ''!!}
                            value="" />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>

                    @if(  $terms->exists )
                    <div class="form-group">
                        {!! html()->label(trans('admin_message.term.end_datetime'), 'end_datetime') !!}
                        <div class='input-group date' id='end_datetime'>
                            <input type='text' class="form-control" name="end_datetime"  {!!  $terms->exists ? 'disabled': ''!!}
                            value="" />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                        <div class='input-group '>
                            {!! html()->label(trans('admin_message.term.slot'), 'slots') !!}
                            {!! html()->number('slots', $terms->exists ? $terms->slots : '')->attributes(['class' => 'form-control', 'min' => 0]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class='input-group '>
                            {!! html()->label(trans('admin_message.term.note'), 'note') !!}
                            {!! html()->textarea('note', $terms->exists ? $terms->note : '')->attributes(['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group pull-right">
                        {!! html()->submit($terms->exists ? trans('admin_message.users.save') : trans('admin_message.term.create'))->attributes(['class' => 'btn btn-primary btn-flat']) !!}
                        <a href="{!! url('admin/terms') !!}" title="{{ trans('admin_message.cancel') }}"
                           class="btn btn-danger btn-flat">{{ trans('admin_message.cancel') }}</a>
                    </div>

                    {!! html()->closeModelForm() !!}

                    @if(  $terms->exists  && $terms->start_datetime > \Carbon\Carbon::now() &&  !count($userTerm->userTerms))
                        <div class="clearfix"></div>
                        <hr >
                        <form action="{!! route('admin.terms.destroy', $terms) !!}" method="POST"
                              onsubmit="return confirm('{!! trans('admin_message.term.confirm')!!} ?')">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <input class="btn  btn-flat btn-danger"
                                   type="submit"
                                   value="{{ trans('admin_message.term.delete') }}">
                        </form>
                    @endif
                </div>

            </div>

        </div>


    </div>


    @if( isset($userTerm->userTerms) && count($userTerm->userTerms) )
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="col-md-12">
                    <h3>Zakazani vežbači</h3>
                </div>

                @foreach( $userTerm->userTerms as $user )
                <div class="col-md-4">
                    @if(isset($user->user))
                    <div class="box-body box-profile {{ $user->user_delayed == 0 ? '' : 'bg-danger' }}">
                        <img class="profile-user-img img-responsive img-circle" src="{{ asset( $user->user->avatar) }}" alt="User profile avatar">

                        <h3 class="profile-username text-center">{{ $user->user->name}} {{ $user->user->lastname}} </h3>


                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item  {{ $user->user_delayed == 0 ? '' : 'list-group-item-danger ' }}">
                                <b>{{ trans('admin_message.term.workout_number') }}</b> <a class="pull-right">ID: {{ $user->user->id}}</a>
                            </li>
                            {{--<li class="list-group-item {{ $user->delayed == 0 ? '' : 'list-group-item-danger ' }}">--}}
                                {{--<b>{{ trans('admin_message.membership.expired_time') }} </b> <a class="pull-right">{{$userTerm->userTerms[$loop->index]->user->toArray()['membership']['expired_time']}}</a>--}}
                            {{--</li>--}}
                            <li class="list-group-item {{ $user->user_delayed == 0 ? '' : 'list-group-item-danger ' }}">
                                <b>{{ trans('admin_message.term.delayed') }}</b> <p class="pull-right">{{ $user->user_delayed == 0 ? 'Ne' : 'Da' }}</p>
                            </li>
                        </ul>

                        @if( $user->user_delayed == 0)

                            @if($terms->start_datetime > \Carbon\Carbon::now() )
                            <form action="{{ url('/admin/terms/delayeduser/'.$user->id) }}" method="POST"
                                  onsubmit="return confirm('{!! trans('admin_message.term.confirm')!!}')">
                                <input type="hidden" name="_method" value="POST">
                                <input type="hidden" name="user_id" value="{{ $user->user->id }}">
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                <input class="btn btn-primary btn-block"
                                       type="submit"
                                       value="{{ trans('admin_message.term.delayedUser')}}">
                            </form>
                             <p>Ako odložiš vežbača, vraćamo mu termin.(Ne vraćamo samo u slučaju da je prošlo vreme za otkazivanje.)</p>
                            @endif
                        @endif
                    </div>
                    @endif
                    <!-- /.box-body -->

                </div>
                @endforeach

                <div class="clearfix"></div>
            </div>
        </div>
    @endif

        @endsection

        @section('scripts')
            <script type="text/javascript"
                    src="{!! asset('assets-admin/admin2/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') !!}"></script>
            <script>
                $(function () {

                @if(!$terms->exists )

                    var date = new Date();
                    date.setDate(date.getDate());
                    $('#start_datetime').datetimepicker({
                        locale: 'sr',
                        minDate: date
                    });

                    $('#end_datetime').datetimepicker({
                        locale: 'sr',
                        minDate: date
                    });
                @else

                    $('#start_datetime').datetimepicker({
                        locale: 'sr',
                        defaultDate: '{!! $terms->start_datetime  !!}'
                    });

                    $('#end_datetime').datetimepicker({
                        locale: 'sr',
                        defaultDate: '{!! $terms->end_datetime  !!}'
                    });

                @endif

                });
            </script>
@endsection
