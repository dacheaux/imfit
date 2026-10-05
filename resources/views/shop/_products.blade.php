@if(count($products) > 0)

    @foreach($products as $product)

        <div class="col-md-3 col-sm-6 col-xs-6">
            <div class="content">
                @if($product->product_image != null)
                    <div class="product-image">
                        <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_name }}" title="{{ $product->product_name }}" class="img-fluid">
                    </div>
                @endif
                <div class="product_info">
                    <div class="d-flex flex-column align-items-center">
                        <h3>{!! $product->product_name !!}</h3>
                        <h5 class="product-price">{{ number_format($product->product_price, 0) }}  <span>RSD</span> </h5>
                        <a href="#" class="ff_button product-button" data-toggle="modal" data-target="#modal-default{{$product->id}}"><i class="fa fa-shopping-cart"></i> KUPI</a>
                    </div>

                </div>
            </div>
        </div>


        @include('shop._modals')

    @endforeach

@else

    <div class="col-lg-12 col-md-12">
        <div class="ff_heading">
            <h3>Nema traženih rezultata.</h3>
        </div>
    </div>

@endif

<br>

<div class="col-lg-12 d-flex justify-content-center">

    {{ $products->links() }}

</div>
