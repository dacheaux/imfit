@extends('layouts.main')

@section('styles')
  <!-- Sweetalert -->
  <link rel="stylesheet" href="{{ asset('assets-admin/css/sweetalert.css') }}">
@endsection

@section('content')
<!-- breadcrumb section start -->
@include('partials.breadcrumb', ['pageTitle' => 'kontakt'])
<!-- contact section start -->
<div class="ff_contact_wrapper top_padder80 bottom_padder30">
    <div class="container">
        <div class="row">
            <div class="ff_heading" style="margin: 0 auto; padding-bottom: 30px;">
                <h1>Za sve dodatne informacije,<br> možete nas  <span>kontaktirati</span></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="ff_contact_box">
                    <span class="fa fa-phone"></span>
                    <h4>Pozovite nas</h4>
                    <p><a href="tel:+381604242389">060/424-2389</a></p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="ff_contact_box">
                    <span class="fa fa-envelope"></span>
                    <h4>Email</h4>
                    <p><a href="mailto:ivanmilovanovic1987@gmail.com">ivanmilovanovic1987@gmail.com</a></p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="ff_contact_box">
                    <span class="fa fa-map-marker"></span>
                    <h4>Lokacija</h4>
                    <p>Oslobođenja br. 3, 15000, Šabac</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- gmap section start -->
{{--<div id="gmap" class="gmap"></div>--}}
<div style="width: 100%">
   <iframe width="100%" height="450" src="https://maps.google.com/maps?width=100%&amp;height=600&amp;hl=en&amp;coord=44.7521077,19.6881794&amp;q=%C5%A0abac%20Oslobodjenja%3&t=&z=13&ie=UTF8&amp;t=&amp;z=17&amp;iwloc=B&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div><br />
<!-- contact form section start -->
<div class="ff_contact_form_wrapper top_padder80 bottom_padder80">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="ff_heading">
                    <h1><span>Kontakt</span> forma</h1> <br>
                </div>
            </div>
        </div>
            <div class="row justify-content-md-center">
                {!! Form::model( $contact = new \App\Contact, ['url'=>'kontakt', 'id'=>'contact-form'] ) !!}

                        <div class="col-md-12">
                            <div class="col-lg-10 col-md-12">
                                <div class="ff_contact_input">
                                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ime*']) !!}
                                </div>
                            </div>
                            <div class="col-lg-10 col-md-12">
                                <div class="ff_contact_input">
                                    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email*', 'data-valid' => 'email', 'data-error'=>'Email should be valid.']) !!}
                                </div>
                            </div>
                        </div>
                         <div class="col-md-12">
                            <div class="col-lg-10 col-md-12">
                                <div class="ff_contact_input">
                                    {!! Form::text('theme', null, ['class' => 'form-control', 'placeholder' => 'Naslov*']) !!}
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="ff_contact_input">
                                       {!! Form::textarea('question', null, ['class' => 'form-control', 'placeholder' => 'Poruka*', 'rows' => 8]) !!}
                                        <div class="response"></div>
                                        <button type="submit" class="ff_button" >Pošalji</button>
                                </div>
                            </div>
                        </div>

                        <div class="pt-2">
                           @include('partials.errors')
                        </div>


                {!! Form::close() !!}
            </div>
    </div>
</div>

@endsection

@section('scripts')
{{--<script src="assets/js/gmap.min.js"></script>--}}
{{--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDNdePPJKYq0ptBV_AFi_4RnmUtMa1ZLFg&amp;libraries=places"></script>--}}
 <script>
    $(function () {
        $('#gmap')
            .gmap3({
            address: "Ulica Oslobođenja br. 3",
            zoom: 15,
            mapTypeId : google.maps.MapTypeId.ROADMAP
        })
        .marker(function (map) {
        return {
            position: map.getCenter(),
            icon: 'assets/images/map_icon.png'
        };
        })
    });
</script>
<!-- Sweetalert -->
<script src="{{asset('assets-admin/js/sweetalert-dev.js')}}"></script>
    @include('admin.partials._flash')
@endsection
