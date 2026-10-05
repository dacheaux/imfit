@extends('layouts.main')

@section('content')

<!-- breadcrumb section start -->
@include('partials.breadcrumb', ['pageTitle' => 'prijava'])


<div class="ff_contact_form_wrapper top_padder80 bottom_padder80">
    <div class="container">
      <div class="row justify-content-md-center">
        <div class="col-lg-6 ">
           <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                <div class="col-lg-12 col-md-12">
                    <div class="ff_heading">
                        <h1><span>Prijavi</span> se</h1>
                    </div>
                </div>
                <div class="col-lg-12">
                    @csrf
                    <div class="ff_contact_input">
                        <input id="email" type="email"  placeholder="Email"  class="form-control require{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="ff_contact_input">
                        <input id="password" type="password" placeholder="Password"  class="form-control require{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="ff_contact_input">
                        <button type="submit" class="ff_button submitForm" >Prijava</button>
                        <br><br>
                        <a href="{{ route('password.request') }}">{{ __('Zaboravljen password?') }}</a>
                    </div>
                    <br>

                    @include('partials.errors')
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
@endsection
