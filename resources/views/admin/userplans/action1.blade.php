<form action="{!! route('admin.userplans.destroy', $userplans->id) !!}" method="POST"
      onsubmit="return confirm('{!! trans('admin_message.userplans.confirm')!!}'+' {!! $userplans->id !!}?')">
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
    <input class="btn btn-sm btn-flat btn-danger"
           type="submit"
           value="{{ trans('admin_message.userplans.delete') }}">
</form>
