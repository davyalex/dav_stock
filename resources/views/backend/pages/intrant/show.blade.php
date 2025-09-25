@extends('backend.layouts.master')
@section('title')
    Intrant
@endsection
@section('css')
    <!--datatable css-->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <!--datatable responsive css-->
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet"
        type="text/css" />
    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('backend.components.breadcrumb')
        @slot('li_1')
            Détail intrant
        @endslot
        @slot('title')
            Intrant
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-body border border-primary border-dashed">
                            <div class="mb-4 d-flex flex-wrap justify-content-around">
                                <p>Code : <span class="fw-bold">{{ $data_intrant['code'] }}</span></p>
                                <p>Nom : <span class="fw-bold">{{ $data_intrant['nom'] }}</span></p>
                                <p>Stock actuel : <span class="fw-bold">{{ $data_intrant['stock'] }}</span></p>
                                <p>Stock alerte : <span class="fw-bold text-danger">{{ $data_intrant['stock_alerte'] }}</span></p>
                                <p>Prix : <span class="fw-bold">{{ number_format($data_intrant['prix'], 0, ',', ' ') }} FCFA</span></p>
                                <p>Statut : <span class="fw-bold">{{ $data_intrant['statut'] }}</span></p>
                                <p>Date création : <span class="fw-bold">{{ $data_intrant['created_at'] }}</span></p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-semibold">Description :</label>
                                <div>{{ $data_intrant['description'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center col-lg-2">
                    <div class="text-center">
                        <div class="position-relative d-inline-block">
                            <div class="avatar-lg">
                                <div class="avatar-title bg-light rounded" id="intrant-img">
                                    <img src="{{ $data_intrant->hasMedia('IntrantImage') ? $data_intrant->getFirstMediaUrl('IntrantImage') : asset('assets/img/logo/logo.jpg') }}"
                                        class="avatar-md h-auto" alt="Image intrant" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>

    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
