<form action="{!! route('admin.posts.destroy', $posts->id) !!}" method="POST"
      onsubmit="return confirm('{!! trans('admin_message.posts.confirm')!!}'+' {!! $posts->post_title !!}?')">
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
    <input class="btn btn-sm btn-flat btn-danger"
           type="submit"
           value="{{ trans('admin_message.posts.delete') }}">
</form>
