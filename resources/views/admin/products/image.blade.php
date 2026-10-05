@if($product->product_image !== null)
<img src="{{ asset($product->product_image) }}" alt="{{ $product->product_name  }}" class="img-fluid" width="100">
@else
<img src="{{ asset('/uploads/products/no-image.jpg') }}" alt="{{ $product->product_name  }}" class="img-fluid" width="100">
@endif
