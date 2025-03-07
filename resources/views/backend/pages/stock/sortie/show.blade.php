@extends('backend.layouts.master')
@section('title')
   Sortie
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
            Gestion de stock
        @endslot
        @slot('title')
            Liste des sorties
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Liste des produits de la sortie en stock
                        <strong>#{{ $sortie->code }} du {{ \Carbon\Carbon::parse($sortie['date_sortie'])->format('d-m-Y à H:i') }} </strong>
                    </h5>
                    <a href="{{ route('sortie.create') }}" type="button" class="btn btn-primary ">Faire
                        une sortie de stock</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Nom</th>
                                    <th>Stock existant</th>
                                    <th>Quantité utilisé</th>
                                    <th>Stock Restant</th>
                                    <th>Stock alerte</th>
                                    <th class="d-none">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sortie->produits as $key => $item)
                                    <tr id="row_{{ $item['id'] }}">
                                        <td> {{ ++$key }} </td>
                                        <td>
                                            <img class="rounded avatar-sm"
                                                src="{{ $item->hasMedia('ProduitImage') ? $item->getFirstMediaUrl('ProduitImage') : asset('assets/img/logo/logo_Chez-jeanne.jpg') }}"
                                                width="50px" alt="">
                                        </td>
                                        <td>{{ $item['nom'] }} {{ $item['valeur_unite'] ?? ''}} {{ $item['unite']['libelle'] ?? '' }}  </td>
                                        <td>{{ $item['pivot']['quantite_existant'] }} {{ $item['uniteSortie']['libelle'] ?? '' }}</td>
                                        <td>{{ $item['pivot']['quantite_utilise'] }} {{ $item['uniteSortie']['libelle'] ?? '' }}</td>
                                        <td>{{ $item['stock'] }} {{ $item['uniteSortie']['libelle'] ?? '' }}</td>
                                        <td>{{ $item['stock_alerte'] }} {{ $item['uniteSortie']['libelle'] ?? '' }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->

    {{-- @include('backend.pages.produit.create') --}}
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

    <script>
        $(document).ready(function() {
            var route = "depense"
            delete_row(route);
        })
    </script>
@endsection
