@extends('layouts.main')

@section('styles')
    <style>
        .ff_team_wrapper .ff_team_box .ff_team_img:after{
            border: none;
        }
    </style>
@endsection
@section('content')

<!-- breadcrumb section start -->
@include('partials.breadcrumb', ['pageTitle' => 'o nama'])
<!-- about section start -->
<div class="ff_about_wrapper">
	<div class="ff_about_img">
		<img src="{{ asset('assets/images/about.png') }}" class="img-fluid" alt="about" title="about">
	</div>
	<div class="container">
		<div class="row">
			<div class="col-xl-8 col-lg-10 offset-xl-0 offset-lg-1 col-md-12">
				<div class="ff_about_box">
					<div class="ff_about_heading">
						<h2>15 Godina iskustva u <span>Fitness-u</span></h2>
					</div>
					<div class="ff_about_content">
						<div class="ff_about_icon">
							<i class="flaticon-arm-muscles-silhouette"></i>
						</div>
						<div class="ff_about_text">
							<h3>Power Plate </h3>
							<p>Pravi funkcionalni trening je najkompletniji način treniranja jer radi na svim bitnim faktorima: snazi, kondiciji, eksplozivnosti, brzini i izdržljivosti.</p>
						</div>
					</div>
					<div class="ff_about_content">
						<div class="ff_about_icon">
							<i class="flaticon-male-gymnast-flexing-arms"></i>
						</div>
						<div class="ff_about_text">
							<h3>Funkcionalni</h3>
							<p>Sprava radi uz pomoću mehaničkih vibracija, pomerajući platformu prvenstveno gore-dole da poboljša snagu mišića, levo-desno i napred-nazad što doprinosi boljoj ravnoteži i koordinaciji.</p>
						</div>
					</div>
					<div class="ff_about_content">
						<div class="ff_about_icon">
							<i class="flaticon-kettlebells"></i>
						</div>
						<div class="ff_about_text">
							<h3>Tegovi i Cardio Program</h3>
							<p>Trening snage predstavlja značajan napor i za telo i za um. Cardio Box je visoko intenzivan trening inspirisan borilačkim veštinama.</p>
						</div>
					</div>
					<div class="ff_about_content">
						<div class="ff_about_icon">
							<i class="flaticon-male-gymnast-flexing-arms"></i>
						</div>
						<div class="ff_about_text">
							<h3>X Body</h3>
							<p>Elektro Mišićna Stimulacija je inovativna fitness tehnologija koja šalje sitne i potpuno bezbolne električne impulse direktno do mišića u toku treninga.</p>
						</div>
					</div>
                    <div class="ff_about_content">
                        <div class="ff_about_icon">
                            <i class="flaticon-arm-muscles-silhouette"></i>
                        </div>
                        <div class="ff_about_text">
                            <h3>Grupni Treninzi</h3>
                            <p>Prednost grupnog treninga i rada jesu zanimljivost vežbanja, motivacija, druženje i odlična atmosfera koja omogućava da na zabavan način dođete do željenih rezultata.</p>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- team section start -->
<div class="ff_team_wrapper bottom_padder50">
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

{{--<!-- history section start -->--}}
{{--<div class="ff_history_wrapper">--}}
{{--	<div class="container">--}}
{{--		<div class="row">--}}
{{--			<div class="col-lg-12 col-md-12">--}}
{{--				<div class="ff_heading">--}}
{{--					<h1><span>naša</span> istorija</h1>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<div class="col-lg-12 col-md-12">--}}
{{--				<div class="ff_history_box">--}}
{{--					<ul>--}}
{{--						<li>--}}
{{--							<div class="ff_history_content right_content">--}}
{{--								<div class="ff_history_year year1">--}}
{{--									<h4>1990</h4>--}}
{{--								</div>--}}
{{--								<div class="ff_history_data">--}}
{{--									<h5>We Started Our Business </h5>--}}
{{--									<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>--}}
{{--									<span class="dot"></span>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--						</li>--}}
{{--						<li>--}}
{{--							<div class="ff_history_content left_content">--}}
{{--								<div class="ff_history_year year2">--}}
{{--									<h4>1995</h4>--}}
{{--								</div>--}}
{{--								<div class="ff_history_data">--}}
{{--									<h5>Started Growing Our Business to New Cities</h5>--}}
{{--									<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>--}}
{{--									<span class="dot"></span>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--						</li>--}}
{{--						<li>--}}
{{--							<div class="ff_history_content right_content">--}}
{{--								<div class="ff_history_year year3">--}}
{{--									<h4>2007</h4>--}}
{{--								</div>--}}
{{--								<div class="ff_history_data">--}}
{{--									<h5>We Becomes  Leading Gym In the world</h5>--}}
{{--									<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>--}}
{{--									<span class="dot"></span>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--						</li>--}}
{{--						<li>--}}
{{--							<div class="ff_history_content left_content">--}}
{{--								<div class="ff_history_year year4">--}}
{{--									<h4>2016</h4>--}}
{{--								</div>--}}
{{--								<div class="ff_history_year year5">--}}
{{--									<h4>2017</h4>--}}
{{--								</div>--}}
{{--								<div class="ff_history_data">--}}
{{--									<h5>We Awarded as Best Gym in the world</h5>--}}
{{--									<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>--}}
{{--									<span class="dot"></span>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--						</li>--}}
{{--					</ul>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--		</div>--}}
{{--	</div>--}}
{{--</div>--}}

@endsection
