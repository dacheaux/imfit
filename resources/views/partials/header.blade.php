<!-- header section start -->
<div class="ff_header">
	<div class="ff_header_wrapper">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<div class="ff_logo">
						<a href="{{ url('/') }}">
							<img src="{{ asset('assets/images/logo.png') }}" class="img-fluid" alt="I'm Fit" title="I'm Fit">
						</a>
					</div>
					<div class="ff_header_box">
						<ul>
							<li><a href="https://www.facebook.com/imfit.sabac/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
							<li><a href="https://www.instagram.com/imfit.sabac/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="ff_menu_wrapper">
		<div class="ff_menu_overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<div class="ff_menu_box">
						<div class="ff_menu">
							<div class="ff_logo hidden-lg-up" style="padding:0 20px 20px 20px;">
								<a href="{{ url('/') }}">
									<img src="{{ asset('assets/images/logo.png') }}" class="img-fluid" alt="I'm Fit" title="I'm Fit">
								</a>
							</div>
							<ul>
								<li class="{{ Request::is('/') ? 'active' : '' }}"><a href="{{ url('/') }}">Početna</a></li>
								<li class="{{ Request::is('o-nama') ? 'active' : '' }}"><a href="{{ url('/o-nama') }}">O nama</a></li>
								<li class="{{ Request::is('galerija') ? 'active' : '' }}"><a href="{{ url('/galerija') }}">Galerija</a></li>
								<li class="{{ Request::is('treninzi') ||  Request::is('treninzi*')  ? 'active' : '' }}"><a href="{{ url('/treninzi') }}">Treninzi</a></li>
								<li class="{{ Request::is('kontakt') ? 'active' : '' }}"><a href="{{ url('/kontakt') }}">Kontakt</a></li>
							 	@guest
								<li><a href="{{ route('login') }}">Prijava</a></li>
								@else
								@role('vežbač')
								<li class="{{ Request::is('zakazi-trening') ? 'active' : '' }}"><a href="{{ url('/zakazi-trening') }}"><span class="fa fa-calendar"></span> Zakaži trening</a></li>
								@endrole
								<li class="dropdown">
									<a  href="{{url('/profil')}}" role="button"><strong>{{ Auth::user()->name }} </strong> <span class="fa fa-chevron-down hidden-md-down"></span></a>

									<ul class="sub-menu">
                                        @role('vežbač')
                                        <li><a href="{{url('/racun')}}">Račun: {{ number_format(Auth::user()->account->balance, 2) }}</a></li>
                                        @endrole
                                        <li>
                                            <a href="{{url('/qrcode')}}">QR-Code</a>
                                        </li>
										@role('vežbač')
                                            <li>
                                                <a href="{{url('/shop')}}">Shop</a>
                                            </li>
											<li>
												<a href="{{url('/termini')}}">Termini</a>
											</li>
											<li>
												<a href="{{url('/clanarina')}}">Članarina</a>
											</li>
											<li>
												<a href="{{url('/profil')}}">Profil</a>
											</li>
										@endrole
										@role('admin')
										<li>
											<a href="{{url('/admin')}}">Admin panel</a>
										</li>
										@endrole
										@role('trener')
										<li>
											<a href="{{url('/aptreneri')}}">Admin treneri</a>
										</li>
										<li>
											<a href="{{url('/profil')}}">Profil</a>
										</li>
										@endrole
										<li>
											<a href="{{ route('logout') }}"
											   onclick="event.preventDefault();
															 document.getElementById('logout-form').submit();">
												{{ __('Logout') }}
											</a>

											<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
												@csrf
											</form>
										</li>
									</ul>
								</li>

								@endguest
							</ul>
							<button class="ff_close_btn"><i class="fa fa-times"></i></button>
						</div>
						<button class="ff_toggle_btn"><i class="fa fa-bars"></i></button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
