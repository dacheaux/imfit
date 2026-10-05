@extends('layouts.main')

@section('content')

<!-- breadcrumb section start -->
@include('partials.breadcrumb', ['pageTitle' => 'Reset passworda'])

<div class="ff_contact_form_wrapper top_padder80 bottom_padder80">
    <div class="container">
      <div class="row justify-content-md-center">
        <div class="col-lg-6 ">
            <form method="POST" action="{{ url('password/email') }}" aria-label="{{ __('Reset Password') }}">

                @csrf

                <div class="col-lg-12 col-md-12">
                    <div class="ff_heading">
                        <h1><span>Reset </span> passworda</h1>
                    </div>
                </div>

                @guest

                <div class="col-lg-12">
                    <div class="ff_contact_input">
                        <input id="email" type="email"  placeholder="Email"  class="form-control require{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="ff_contact_input">
                        <button type="submit" class="ff_button submitForm" >Pošalji</button>
                    </div>
                        <br><br>

                     @if (session('status'))
                        <div class="alert alert-success text-center" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                   @else

                    <p class="text-center">Morate biti izlogovani da bi resetovali passowrd.</p> <br> <br>

                    <div class="text-center">
                        <button class="ff_button submitForm" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('Odjava') }}
                        </button>
                    </div>

                    @endguest

                    @include('partials.errors')
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
@endsection
