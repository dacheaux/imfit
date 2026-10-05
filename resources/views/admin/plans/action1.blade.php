<form action="{!! route('admin.plans.destroy', $plans->id) !!}" method="POST"
      onsubmit="return confirm('{!! trans('admin_message.plans.confirm')!!}'+' {!! $plans->name !!}?')">
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
    <input class="btn btn-sm btn-flat btn-danger"
           type="submit"
           value="{{ trans('admin_message.plans.delete') }}">
</form>
