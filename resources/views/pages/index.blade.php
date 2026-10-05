@extends('layouts.main')

@section('styles')
    <style>
        .ff_team_wrapper .ff_team_box .ff_team_img:after{
            border: none;
        }
    </style>
@endsection
@section('content')

    @include('partials.banner')


<!-- service section start -->
<div class="ff_service_wrapper">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="ff_heading">
					<h1><span>fitness centar</span> treninzi</h1>
				</div>
			</div>
			<div class="col-lg-12 col-md-12">
				<div class="ff_service_content">
					<div class="ff_service_img">
						<img src="{{ asset('assets/images/service.png') }}" alt="service" title="service" class="img-fluid">
					</div>
					<div class="ff_service_text">
						<ul>
							<li>
								<div class="ff_service_data">
									<h2>Funkcionalni <i class="flaticon-male-gymnast-flexing-arms"></i></h2>
									<p>Pravi funkcionalni trening je najkompletniji način treniranja jer radi na svim bitnim faktorima: snazi, kondiciji, eksplozivnosti, brzini i izdržljivosti.</p>
								</div>
							</li>
							<li>
								<div class="ff_service_data">
									<h2>Power Plate <i class="flaticon-arm-muscles-silhouette"></i></h2>
									<p>Sprava radi uz pomoću mehaničkih vibracija, pomerajući platformu prvenstveno gore-dole da poboljša snagu mišića, levo-desno i napred-nazad što doprinosi boljoj ravnoteži i koordinaciji.</p>
								</div>
							</li>
							<li class="hidden-md-down">
								<div class="ff_service_data">
									<h2></h2>
									<p></p>
								</div>
							</li>
							<li>
								<div class="ff_service_data">
									<h2><i class="flaticon-male-gymnast-flexing-arms"></i> X Body (EMS)</h2>
									<p>Elektro Mišićna Stimulacija je inovativna fitness tehnologija koja šalje sitne i potpuno bezbolne električne impulse direktno do mišića u toku treninga</p>
								</div>
							</li>
							<li>
								<div class="ff_service_data">
									<h2><i class="flaticon-kettlebells"></i> Tegovi <span class="text-lowercase">i</span> Cardio Box</h2>
									<p>Trening snage predstavlja značajan napor i za telo i za um. Cardio Box je visoko intenzivan trening inspirisan borilačkim veštinama.</p>
								</div>
							</li>
							<li>
								<div class="ff_service_data">
									<h2><i class="flaticon-arm-muscles-silhouette"></i> Grupni treninzi</h2>
									<p>Prednost grupnog treninga i rada jesu zanimljivost vežbanja, motivacija, druženje i odlična atmosfera koja omogućava da na zabavan način dođete do željenih rezultata. </p>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- counter section start -->
<div class="ff_counter_wrapper">
	<div class="container">
		<div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="ff_counter_box">
                    <div class="ff_counter_overlay">
                        <i class="flaticon-badge"></i>
                    </div>
                    <h2><i class="flaticon-badge"></i><span class="" data-from="0" data-to="10" data-speed="3000">10+</span></h2>
                    <p>Godina iskustva</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="ff_counter_box">
                    <div class="ff_counter_overlay">
                        <i class="flaticon-arm-muscles-silhouette"></i>
                    </div>
                    <h2><i class="flaticon-arm-muscles-silhouette"></i><span class="" data-from="0" data-to="300" data-speed="3000">12550</span></h2>
                    <p>Trenizni snage</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="ff_counter_box">
                    <div class="ff_counter_overlay">
                        <i class="flaticon-male-gymnast-flexing-arms"></i>
                    </div>
                    <h2><i class="flaticon-male-gymnast-flexing-arms"></i><span class="" data-from="0" data-to="7505" data-speed="3000">7505</span></h2>
                    <p>Personalni treneri</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="ff_counter_box">
                    <div class="ff_counter_overlay">
                        <i class="flaticon-kettlebells"></i>
                    </div>
                    <h2><i class="flaticon-kettlebells"></i><span class="" data-from="0" data-to="150" data-speed="3000">150</span></h2>
                    <p>Tegovi</p>
                </div>
            </div>
		</div>
	</div>
</div>
<!-- team section start -->
<div class="ff_team_wrapper top_padder80 bottom_padder50">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="ff_heading">
					<h1><span>naši</span> treneri</h1>
				</div>
			</div>
			<div class="col-lg-2 col-md-6 col-sm-6">
				<div class="ff_team_box">
					<div class="ff_team_img text-center">
						<img src="assets/images/team/1.jpg" alt="team" title="team" class="img-fluid">
					</div>
{{--					<div class="ff_team_text">--}}
{{--						<h3>Jesicca James</h3>--}}
{{--						<p>Cardio Trainer</p>--}}
{{--						<ul>--}}
{{--							<li><a href="#"><i class="fa fa-facebook"></i></a></li>--}}
{{--							<li><a href="#"><i class="fa fa-twitter"></i></a></li>--}}
{{--							<li><a href="#"><i class="fa fa-linkedin"></i></a></li>--}}
{{--							<li><a href="#"><i class="fa fa-instagram"></i></a></li>--}}
{{--							<li><a href="#"><i class="fa fa-google-plus"></i></a></li>--}}
{{--						</ul>--}}
{{--					</div>--}}
				</div>
			</div>
			<div class="col-lg-2 col-md-6 col-sm-6">
				<div class="ff_team_box">
					<div class="ff_team_img text-center">
						<img src="assets/images/team/2.jpg" alt="team" title="team" class="img-fluid">
					</div>
{{--					<div class="ff_team_text">--}}
{{--						<h3>Jesicca James</h3>--}}
{{--						<p>Cardio Trainer</p>--}}
{{--						<ul>--}}
{{--							<li><a href="#"><i class="fa fa-facebook"></i></a></li>--}}
{{--							<li><a href="#"><i class="fa fa-twitter"></i></a></li>--}}
{{--							<li><a href="#"><i class="fa fa-linkedin"></i></a></li>--}}
{{--							<li><a href="#"><i class="fa fa-instagram"></i></a></li>--}}
{{--							<li><a href="#"><i class="fa fa-google-plus"></i></a></li>--}}
{{--						</ul>--}}
{{--					</div>--}}
				</div>
			</div>
			<div class="col-lg-2 col-md-6 col-sm-6">
				<div class="ff_team_box">
					<div class="ff_team_img text-center">
						<img src="assets/images/team/3.jpg" alt="team" title="team" class="img-fluid">
					</div>
{{--					<div class="ff_team_text">--}}
{{--						<h3>Jesicca James</h3>--}}
{{--						<p>Cardio Trainer</p>--}}
{{--						<ul>--}}
{{--							<li><a href="#"><i class="fa fa-facebook"></i></a></li>--}}
{{--							<li><a href="#"><i class="fa fa-twitter"></i></a></li>--}}
{{--							<li><a href="#"><i class="fa fa-linkedin"></i></a></li>--}}
{{--							<li><a href="#"><i class="fa fa-instagram"></i></a></li>--}}
{{--							<li><a href="#"><i class="fa fa-google-plus"></i></a></li>--}}
{{--						</ul>--}}
{{--					</div>--}}
				</div>
			</div>

			<div class="col-lg-3 col-lg-offset-3 col-md-6 col-sm-6">
				<div class="ff_team_box">
					<div class="ff_team_img text-center">
						<img src="assets/images/team/4.jpg" alt="team" title="team" class="img-fluid">
					</div>
{{--					<div class="ff_team_text">--}}
{{--						<h3>Jesicca James</h3>--}}
{{--						<p>Cardio Trainer</p>--}}
{{--						<ul>--}}
{{--							<li><a href="#"><i class="fa fa-facebook"></i></a></li>--}}
{{--							<li><a href="#"><i class="fa fa-twitter"></i></a></li>--}}
{{--							<li><a href="#"><i class="fa fa-linkedin"></i></a></li>--}}
{{--							<li><a href="#"><i class="fa fa-instagram"></i></a></li>--}}
{{--							<li><a href="#"><i class="fa fa-google-plus"></i></a></li>--}}
{{--						</ul>--}}
{{--					</div>--}}
				</div>
			</div>
			<div class="col-lg-2 col-md-6 col-sm-6">
				<div class="ff_team_box">
					<div class="ff_team_img text-center">
						<img src="assets/images/team/5.jpg" alt="team" title="team" class="img-fluid">
					</div>
{{--					<div class="ff_team_text">--}}
{{--						<h3>Jesicca James</h3>--}}
{{--						<p>Cardio Trainer</p>--}}
{{--						<ul>--}}
{{--							<li><a href="#"><i class="fa fa-facebook"></i></a></li>--}}
{{--							<li><a href="#"><i class="fa fa-twitter"></i></a></li>--}}
{{--							<li><a href="#"><i class="fa fa-linkedin"></i></a></li>--}}
{{--							<li><a href="#"><i class="fa fa-instagram"></i></a></li>--}}
{{--							<li><a href="#"><i class="fa fa-google-plus"></i></a></li>--}}
{{--						</ul>--}}
{{--					</div>--}}
				</div>
			</div>
		</div>
	</div>
</div>
<!-- offer section start -->
<div class="ff_offer_wrapper">
	<div class="container">
		<div class="row">
			<div class="col-lg-7 col-md-12 push-lg-5">
				<div class="ff_offer_text">
					<h5>PRVI XBODY STUDIO SA ELEKTRO-MIŠIĆNOM STIMULACIJOM</h5>
					<div class="offer_duration">
						<h3>SAVRŠENO OBLIKOVANO TELO <br>ZA 2x20 MIN. TRENINGA NEDELJNO</h3>
					</div>
					<h2>X body</h2>
					<p>EMS ili Elektro-Mišićna Stimulacija je inovativna fitness tehnologija koja šalje sitne i potpuno bezbolne električne impulse direktno do mišića u toku treninga, čime pojačava njihove prirodne kontrakcije i čini svaki trening višestruko efikasnijim.</p>
					<a href="{{ url('/treninzi/xbody-trening') }}" class="ff_button">Saznaj više</a>
				</div>
			</div>
			<div class="col-lg-5 col-md-12 pull-lg-7">
				<div class="ff_offer_img">
					<img src="{{ asset('assets/images/xbody-machine-woman-workout.png') }}" alt="offer" title="offer" class="img-fluid">
				</div>
			</div>
		</div>
	</div>
</div>
<!-- blog section start -->
<div class="ff_blog_wrapper top_padder80 bottom_padder30">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="ff_heading">
					<h1><span>personalni treninzi </span> u našoj ponudi</h1>
				</div>
			</div>
			@if(count($posts) > 0)

				@foreach($posts as $post)

					<div class="col-lg-4 col-md-6">
						<div class="ff_blog_box">
							@if($post->post_thumb != null)
								<div class="ff_blog_img">
									<img src="{{ asset($post->post_thumb) }}" alt="{{ $post->post_title }}" title="{{ $post->post_title }}" class="img-fluid">
								</div>
							@endif
							<div class="ff_blog_text">
								<h2><a href="{{ url('treninzi/'.$post->slug) }}" title="{{ $post->post_title }}">{{ $post->post_title }}</a></h2>
								<ul>
									<li><a href="{{ url('treninzi/'.$post->slug) }}"><i class="fa fa-comment" aria-hidden="true"></i>{{ $post->commentCount() }}</a></li>
									<li><a href="#"><i class="fa fa-share-alt" aria-hidden="true"></i>Podeli</a>
										@include('partials._socials2', ['url' => \Request::url().'/'.$post->slug])
									</li>
								</ul>
								<p>{{ $post->post_desc }}</p>
								<a href="{{ url('treninzi/'.$post->slug) }}" class="ff_button">Saznaj više</a>
							</div>
						</div>
					</div>

				@endforeach

			@endif
		</div>
	</div>
</div>
@endsection
