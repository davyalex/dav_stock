@extends('site.layouts.app')

@section('title', 'Inscription')


@section('content')

    <style>
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>

    <div class="login-register-area pt-95 pb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            {{-- <a href="{{route('user.login')}}">
                            <h4> Connexion </h4>
                        </a> --}}
                            <a class="active" data-bs-toggle="tab" href="#lg2">
                                <h4> Inscription </h4>
                            </a>
                        </div>
                        <div class="tab-content">
                            <div id="lg2" class="tab-pane active">

                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        {{-- <h2 class="text-center mb-4">Inscription</h2> --}}
                                        <form id="formSubmit" action="{{ route('user.register.post') }}" method="post">
                                            @csrf
                                            <input type="text" name="last_name" placeholder="votre nom" required>
                                            <input type="text" name="first_name" placeholder="votre prenom" required>
                                            {{-- <input type="password" name="user-password" placeholder="Password"> --}}
                                            <input name="phone" placeholder="votre numero de telephone" type="number"
                                                required>


                                            {!! NoCaptcha::renderJs() !!}
                                            {!! NoCaptcha::display() !!}


                                            <p id="recaptchaError" style="color: red;"></p>


                                            <div class="button-box">
                                                <button class="w-100" type="submit"><span>Valider</span></button>
                                            </div>
                                            <div class="login-toggle-btn text-center">
                                                <a href="{{ route('user.login') }}">Déjà inscrit ? Cliquez ici pour vous connecter !</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('#formSubmit').addEventListener('submit', function(e) {
            if (typeof grecaptcha !== 'undefined') {
                var response = grecaptcha.getResponse();
                if (response.length === 0) {
                    e.preventDefault();
                    document.getElementById('recaptchaError').innerHTML = 'Veuillez cocher la case reCAPTCHA.';
                }
            } else {
                e.preventDefault();
                document.getElementById('recaptchaError').innerHTML =
                    'reCAPTCHA n\'est pas chargé. Veuillez actualiser la page.';
            }
        });
    </script>
@endsection
