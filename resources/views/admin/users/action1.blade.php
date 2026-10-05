@if($logedUser->id != $users->id)
<form action="{!! route('admin.users.destroy', $users->id) !!}" method="POST"
      onsubmit="return confirm('{!! trans('admin_message.users.confirm')!!}'+' {!! $users->name !!}?')">
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
    <input class="btn btn-sm btn-flat btn-danger"
           type="submit"
           value="{{ trans('admin_message.users.delete') }}">
</form>
@endif