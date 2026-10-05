
@if($userplans->pause_flag == 0)
    @if( $userplans->expired_time > \Carbon\Carbon::now())
    <form action="{!! route('admin.userplans.setpauseon', $userplans->id) !!}" method="POST"
          onsubmit="return confirm('{!! trans('admin_message.userplans.confirm2')!!}'+' {!! $userplans->id !!}?')">
        <input type="hidden" name="_method" value="POST">
        <input type="hidden" name="user_id" value="{{ $userplans->user_id }}">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <input class="btn btn-sm btn-flat btn-info uppercase"
               type="submit"
               value="{{ trans('admin_message.userplans.setpause') }}">
    </form>
    @else
        @if($userplans->active)
            <span class="tag label label-danger">Plan istekao</span>
        @endif
    @endif
@else
    @if($userplans->pause_from->toDateTimeString() !== '2000-01-01 00:00:00')

        <form action="{!! route('admin.userplans.setpauseoff', $userplans->id) !!}" method="POST"
              onsubmit="return confirm('{!! trans('admin_message.userplans.confirm3')!!}'+' {!! $userplans->id !!}?')">
            <input type="hidden" name="_method" value="POST">
            <input type="hidden" name="user_id" value="{{ $userplans->user_id }}">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <input class="btn btn-sm btn-flat btn-warning uppercase"
                   type="submit"
                   value="{{ trans('admin_message.userplans.setpauseoff') }}">
        </form>
    @else
        <span class="tag label label-danger">Plan istekao</span>
    @endif
@endif

