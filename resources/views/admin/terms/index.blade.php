@extends('admin.layout2')

@section('title')
    {{ trans('admin_message.sidebar.terms') }}
@endsection

@section('heading')
    {{ trans('admin_message.sidebar.terms') }}
@endsection

@section('style')


@endsection

@section('content')

    <div class="box box-primary">
       <div class="box-header">
            <a href="{{ route('admin.terms.create') }}" class="btn btn-primary btn-flat">
                <i class="fa fa-calendar-plus-o"></i> &nbsp;&nbsp;
                {{ trans('admin_message.term.create') }}
            </a>
           <a href="{{ route('admin.terms.getTermPatterns') }}" class="btn btn-primary btn-flat">
               <i class="fa fa-plus-circle"></i> &nbsp;&nbsp;
               {{ trans('admin_message.term.getTermPatterns') }}
           </a>
           <hr>

           <div class="col-md-3 form-group">
               <div class="form-group">
                   <label for="workout_id">{{ trans('admin_message.term.workout') }}:</label>
                   <select name="workout_id" id="workout_id" class="form-control"
                   >
                       <option value="">Svi</option>
                       @foreach($workouts as $workout)
                           <option value="{{ $workout->id }}" {{ $workout->id == old('workout_id') ? 'selected' : ''}}>{{ $workout->name }}</option>
                       @endforeach
                   </select>
               </div>
           </div>

           <div class="col-md-3 form-group">
               <label for="coach_id">Selektuj trenera:</label>
               <select name="coach_id" id="coach_id" class="form-control"
               >
                   <option value="">Svi</option>
                   @foreach($coaches as $coach)
                       <option value="{{ $coach->id }}" {{ $coach->id == old('coach_id') ? 'selected' : ''}}>{{ $coach->name }} {{ $coach->lastname }}</option>
                   @endforeach
               </select>
           </div>

           <div class="col-md-3 form-group">
               <label for="end_datetime">Selektuj period:</label>
               <select name="end_datetime" id="end_datetime" class="form-control">
                   <option value="10" selected>10 dana unazad</option>
                   <option value="30">30 dana unazad</option>
                   <option value="60">60 dana unazad</option>
                   <option value="90">90 dana unazad</option>
                   <option value="180">180 dana unazad</option>
                   <option value="360">360 dana unazad</option>
               </select>
           </div>

        </div>

        <div class="box-body no-padding">
            <div class="col-lg-10 col-sm-12">
                <!-- THE CALENDAR -->
                <div id="calendar"></div>
            </div>
        <!-- /.box-body -->
        </div>
    </div>

@endsection

@section('scripts')

    <script type="text/javascript">
      setTimeout(function () { location.reload(true); }, 900000);
    </script>

    <script>


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $(function() {
            /* initialize the calendar
          -----------------------------------------------------------------*/
            //Date for the calendar events (dummy data)
            var date = new Date()
            var d    = date.getDate(),
                m    = date.getMonth(),
                y    = date.getFullYear()


            $(document).on('change', ['#workout_id', '#coach_id','#end_datetime'], function() {
                // $('#calendar').fullCalendar('refetchEvents');
                var events = {
                    url: '{!! route('admin.terms.data') !!}',
                    data: {
                        workout_id: $('#workout_id').val(),
                        coach_id: $('#coach_id').val(),
                        end_datetime: $('#end_datetime').val(),
                    }
                }
                $('#calendar').fullCalendar('removeEventSource', events);
                $('#calendar').fullCalendar('addEventSource', events);
            });

            $('#calendar').fullCalendar({
                defaultView: 'listDay',
                views: {
                    listDay: { buttonText: 'list day' },
                    listWeek: { buttonText: 'list week' },
                    listMonth: { buttonText: 'list month' }
                },
                header    : {
                    left  : 'prev,next today',
                    center: 'title',
                    right : 'month,agendaWeek,agendaDay,listDay,listWeek,listMonth'
                },

                eventRender: function(eventObj, $el) {
                    $el.popover({
                        title: eventObj.title ,
                        content: eventObj.description,
                        trigger: 'hover',
                        placement: 'top',
                        container: 'body'
                    });
                },
                buttonText: {
                    today: 'Danas',
                    month: 'Mesec',
                    week : 'Nedelja',
                    day  : 'Dan',
                    listDay: 'Lista Dan',
                    listWeek: 'Lista Nedelja',
                    listMonth: 'Lista Mesec'
                },
                //Random default events
                events : {
                    url: '{!! route('admin.terms.data') !!}',
                    data: function () { // a function that returns an object
                        return {
                            worokout_id: $('#workout_id').val(),
                            coach_id: $('#coach_id').val(),
                            end_datetime: $('#end_datetime').val(),
                        };
                    }
                }


            });

            $('#calendar').fullCalendar({
                viewDisplay: function (view) {
                    var h;
                    if (view.name == "month") {
                        h = NaN;
                    }
                    else {
                        h = 2500;  // high enough to avoid scrollbars
                    }

                    $('#calendar').fullCalendar('option', 'contentHeight', h);
                }
            });




        });



    </script>
@endsection
