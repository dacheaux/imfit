
<!-- footer section start -->
<div class="ff_footer_wrapper top_padder80 bottom_padder30">
	<div class="container">
		<div class="row ">
            <div class="col-lg-6 col-md-12">
                <div class="widget widget_contact">
                    <h2 class="widget-title">kontakt info</h2>
                    <div class="ff_footer_contact">
                        <div class="ff_contact_icon">
                            <i class="fa fa-home" aria-hidden="true"></i>
                        </div>
                        <div class="ff_contact_text">
                            <p>Adresa: Oslobođenja br. 3, 15000 Šabac</p>
                        </div>
                    </div>
                    <div class="ff_footer_contact">
                        <div class="ff_contact_icon">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                        </div>
                        <div class="ff_contact_text">
                            <p><a href="tel:+381604242389">060/424-2389</a></p>
                        </div>
                    </div>
                    <div class="ff_footer_contact">
                        <div class="ff_contact_icon">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </div>
                        <div class="ff_contact_text">
                            <a href="mailto:ivanmilovanovic1987@gmail.com">ivanmilovanovic1987@gmail.com</a>
                        </div>
                    </div>
                    <div class="ff_footer_contact">
                        <div class="ff_contact_icon">
                            <i class="fa fa-globe" aria-hidden="true"></i>
                        </div>
                        <div class="ff_contact_text">
                            <a href="https://www.imfit.rs/">www.imfit.rs</a>
                        </div>
                    </div>
                </div>
            </div>
			@if($photos->count() > 0)
			<div class="col-lg-3 col-md-12">
				<div class="widget widget_flicker_gallery">
					<h2 class="widget-title">Galerija</h2>
					<ul>
						@foreach($photos as $photo)
						<li>
							<a href="{{ url('/galerija') }}" title="Galerija">
								<img  width="76" src="{{ asset($photo->thumbnail_path) }}" alt="{{ $photo->title  }}"  title="{{ $photo->title  }}"  class="img-fluid">
							</a>
						</li>
						@endforeach
					</ul>
				</div>
			</div>
			@endif

            <div class="col-lg-3 col-md-12">
                <div class="widget text_widget footer_about">
                    <h2 class="widget-title">Pratite nas</h2>
                    <a href="{{ url('/') }}"><img src="{{ asset('assets/images/logo.png') }}" alt="logo" title="logo" class="img-fluid"></a>
                    <ul>
                        <li><a href="https://www.facebook.com/imfit.sabac/" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="https://www.instagram.com/imfit.sabac/" target="_blank"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
		</div>
	</div>
</div>
<div class="ff_btm_footer_wrapper">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="ff_btm_footer_box">
					<p>Copyright &copy; 2026 Sva prava zadražana. imfit.rs</p>
				</div>
			</div>
		</div>
	</div>
</div>
