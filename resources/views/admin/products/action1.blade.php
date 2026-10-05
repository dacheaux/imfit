<div style="display: inline-block" >
<form action="{!! route('admin.products.destroy', $products->id) !!}" method="POST"
      onsubmit="return confirm('Brisanje proizvoda: '+' {!! $products->product_name !!}?')">
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
    <button type="submit" class="btn btn-sm btn-flat btn-danger"><i class="simple-icon-trash"></i> Brisanje</button>
</form>
</div>
