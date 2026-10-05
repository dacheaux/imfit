<div class="modal fade" id="modal-default{{$product->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 style="color: #0a0a0a;"><i class="fa fa-qrcode"></i></h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Zatvori">
                    <span aria-hidden="true" class="pull-right">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center ">
                        <div class="col-md-5">
                            <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_name }}" title="{{ $product->product_name }}" class="img-fluid">
                        </div>
                        <div class="col-md-7">
                            <h4>{!! $product->product_name !!}</h4>
                            <p>{!! $product->product_description !!}</p>
                            <h6>Količina: 1</h6>
                            <h3 class="product-price"><span>Ukupno: </span> <br>{{ number_format($product->product_price, 0) }}  <span>RSD</span> </h3>
                        </div>
                    </div>
                    <br>
                    <div class="text-center">
                        <a href="javascript:void(0)" style="color: #fff;" class="ff_button product-button2"
                           data-order_amount="{{ $product->product_price }}"
                           data-user_id="{{ auth()->id() }}"
                           data-product_id="{{ $product->id }}">PLAĆANJE</a>
                    </div>
                </div>
                <div>
                    <h5 class="text-center msgs{{ $product->id }}" style="color:#0b93d5;"></h5>
                    <br>
                </div>
{{--                <p class="text-center">Vaš Qr Code</p>--}}
{{--                <div class="col-sm-12 text-center">--}}
{{--                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate($token)) !!} " class="avatar img-thumbnail">--}}
{{--                </div>--}}

            </div>
            <div class="modal-body">
                <p>*Klikom na dugme "PLAĆANJE", proces kupovine će se <strong>ODMAH</strong> izvršiti a
                    vrata od frižidera će se otvoriti. Ukoliko je plaćanje izvšreno uspešno,
                    vaš račun će biti umanjen u iznosu cene proizovda koji ste izabrali. <br>
                    *Ukoliko vam se vrata od fržidera ne otvore, a iznos na Vašem računu bude umanjen,
                    potražite pomoć od osoblja da Vam otvore vrata.
                </p>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
