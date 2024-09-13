@extends('site.layouts.app')

@section('title', 'Connexion')
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

@section('content')
<div class="login-register-area pt-95 pb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a class="active" data-bs-toggle="tab" href="#lg1">
                            <h4> Connexion </h4>
                        </a>
                        <a href="{{route('user.register')}}">
                            <h4> Inscription </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form action="{{route('user.login.post')}}" method="post">
                                        @csrf
                                        <input type="number" name="phone" placeholder="numero de telephone" required>
                                        {{-- <input type="password" name="user-password" placeholder="Password"> --}}
                                        <div class="button-box">
                                            {{-- <div class="login-toggle-btn">
                                                <a href="#">Forgot Password?</a>
                                            </div> --}}
                                            <button type="submit"><span>Valider</span></button>
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
@endsection


