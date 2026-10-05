<form action="{!! route('admin.workouts.destroy', $workouts->id) !!}" method="POST"
      onsubmit="return confirm('{!! trans('admin_message.workouts.confirm')!!}'+' {!! $workouts->name !!}?')">
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
    <input class="btn btn-sm btn-flat btn-danger"
           type="submit"
           value="{{ trans('admin_message.workouts.delete') }}">
</form>
