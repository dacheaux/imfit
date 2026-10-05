@extends('layouts.main')

@section('content')

<!-- breadcrumb section start -->
@include('partials.breadcrumb', ['pageTitle' => 'Resetuj password'])


<div class="ff_contact_form_wrapper top_padder80 bottom_padder80">
    <div class="container">
      <div class="row justify-content-md-center">
        <div class="col-lg-6 ">
            <form method="POST" action="{{ url('password/reset') }}" aria-label="{{ __('Reset Password') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="col-lg-12 col-md-12">
                    <div class="ff_heading">
                        <h1><span>Resetuj</span> password</h1>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="ff_contact_input">
                        <input id="email" type="email" class="form-control require{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="ff_contact_input">
                        <input id="password" type="password" placeholder="Password"  class="form-control require{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                    </div>
                </div>
                  <div class="col-lg-12">
                    <div class="ff_contact_input">
                        <input id="password_confirmation" type="password"  placeholder="Potvrda passworda"  class="form-control require{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" required>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="ff_contact_input">
                        <button type="submit" class="ff_button submitForm" >Resetuj</button>
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