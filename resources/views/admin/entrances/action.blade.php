<form action="{!! route('admin.entrances.destroy', $data['id']) !!}" method="POST"
      onsubmit="return confirm('{!! trans('admin_message.entrances.confirm')!!}'+' {!! $data['id'] !!}?')">
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
    <input class="btn btn-sm btn-flat btn-danger"
           type="submit"
           value="{{ trans('admin_message.entrances.delete') }}">
</form>
