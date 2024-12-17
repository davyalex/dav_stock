@extends('site.layouts.app')

@section('title', 'Contactez-nous')

@section('content')
    <div class="contact-area pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="contact-info-wrapper text-center mb-30">
                        <div class="contact-info-icon">
                            <i class="ion-ios-location-outline"></i>
                        </div>
                        <div class="contact-info-content">
                            {{-- <h4>Our Location</h4> --}}
                            {{-- <p>012 345 678 / 123 456 789</p> --}}
                            <p><a href="{{ $setting->google_maps ?? '' }}" target="_blank"
                                    rel="noopener noreferrer">{{ $setting->localisation ?? '' }}</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="contact-info-wrapper text-center mb-30">
                        <div class="contact-info-icon">
                            <i class="ion-ios-telephone-outline"></i>
                        </div>
                        <div class="contact-info-content">
                            {{-- <h4>Contact us Anytime</h4> --}}
                            <p> <a href="tel:{{ $setting->phone1 ?? '' }}">Mobile: {{ $setting->phone1 ?? '' }}</a> </p>
                            {{-- <p>Fax: 123 456 789</p> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="contact-info-wrapper text-center mb-30">
                        <div class="contact-info-icon">
                            <i class="ion-ios-email-outline"></i>
                        </div>
                        <div class="contact-info-content">
                            {{-- <h4>Write Some Words</h4> --}}
                            <p><a href="mailto:{{ $setting->email1 ?? '' }}">{{ $setting->email1 ?? '' }}</a></p>
                        </div>
                    </div>
                </div>
            </div>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="contact-message-wrapper">
                        <h4 class="contact-title">Ecrivez nous</h4>
                        <div class="contact-message">
                            <form  action="{{route('email-nous-contactez')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="contact-form-style mb-20">
                                            <input name="nom" placeholder="Votre nom" type="text" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="contact-form-style mb-20">
                                            <input name="email" placeholder="Votre adresse Email" type="email" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="contact-form-style mb-20">
                                            <input name="objet" placeholder="Objet" type="text" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="contact-form-style">
                                            <textarea name="message" placeholder="Message" required></textarea>
                                            <button class="submit btn-style" type="submit">ENVOYEZ</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <p class="form-messege"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contact-map">
                {{-- <iframe class="map-size"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.693667617067!2d144.946279515845!3d-37.82064364221098!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d4cee0cec83%3A0xd019c5f69915a4a0!2sCollins%20St%2C%20West%20Melbourne%20VIC%203003%2C%20Australia!5e0!3m2!1sen!2sbd!4v1607512676761!5m2!1sen!2sbd">
                </iframe> --}}

                <iframe class="map-size"
                    src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3972.8204465595004!2d-3.9780556!3d5.2906944!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNcKwMTcnMjYuNSJOIDPCsDU4JzQxLjAiVw!5e0!3m2!1sfr!2sci!4v1733138090727!5m2!1sfr!2sci"
                    width="100%" height="450" style="border:0;" allowfullscreen="true" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
@endsection
