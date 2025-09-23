@extends('backend.layouts.master')
@section('title')
    Parametre
@endsection
@section('content')
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid black; text-align: left; }
        th { background-color: #f4f4f4; }
        a { text-decoration: none; color: blue; }
    </style>

    <div class="row">
        <div class="col-xxl-12  mt-5">
            <div class="card mt-xxl-n5">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                <i class="fas fa-home"></i> Informations du site
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#privacy" role="tab">
                                <i class="far fa-envelope"></i> Application
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#backup" role="tab">
                                <i class="far fa-envelope"></i> Backups
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                      @include('backend.pages.setting.partials.site-info')
                        <!--end tab-pane information-->


                       @include('backend.pages.setting.partials.application')
                        <!--end tab-pane application and security-->

                     @include('backend.pages.setting.partials.backups')
                        <!--end tab-pane backups-->

                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
@endsection
@section('script')
    <script src="{{ URL::asset('build/js/pages/profile-setting.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

    <script>
        $(document).ready(function() {

            //cache clear
            $('.btn-clear').click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "get",
                    url: "{{ route('setting.cache-clear') }}",
                    // data: "data",
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 200) {
                            let timerInterval;
                            Swal.fire({
                                title: "Traitement en cour!",
                                html: "Se termine dans <b></b> milliseconds.",
                                timer: 6000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading();
                                    const timer = Swal.getPopup().querySelector(
                                        "b");
                                    timerInterval = setInterval(() => {
                                        timer.textContent =
                                            `${Swal.getTimerLeft()}`;
                                    }, 100);
                                },
                                willClose: () => {
                                    clearInterval(timerInterval);
                                }
                            }).then((result) => {
                                /* Read more about handling dismissals below */
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    console.log("I was closed by the timer");
                                }
                            });
                        }
                    }
                });
            });

            // maintenance mode down
            $('.btn-mode-down').click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "get",
                    url: "{{ route('setting.maintenance-down') }}",
                    // data: "data",
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 200) {
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Mode maintenance activé",
                                showConfirmButton: false,
                                timer: 1500
                            });

                            $('btn-mode-up').html('désactivé');
                            location.reload(true);
                        }
                    }
                });
            });

            // maintenance mode up
            $('.btn-mode-up').click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "get",
                    url: "{{ route('setting.maintenance-up') }}",
                    // data: "data",
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 200) {
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Mode maintenance desactivé",
                                showConfirmButton: false,
                                timer: 1500
                            });

                            location.reload(true);
                        }
                    }
                });
            });


        });
    </script>
@endsection
