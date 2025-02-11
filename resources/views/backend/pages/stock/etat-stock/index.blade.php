@extends('backend.layouts.master')
@section('title')
    État des stocks
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
            État des stocks
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Liste des produits en stock
                        @if(request()->has('statut')) - <b>{{ request('statut') }}</b> @endif
                        @if(request()->has('filter')) - <b>{{ request('filter') }}</b> @endif
                    </h5>

                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class=" ri ri-filter-2-fill"></i> Filtrer par categorie
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="/admin/etat-stock?filter=Restaurant">Restaurant</a></li>
                            <li><a class="dropdown-item" href="/admin/etat-stock?filter=Bar">Bar</a></li>
                            <li><a class="dropdown-item" href="/admin/etat-stock">Toutes les categories</a></li>
                        </ul>
                    </div>
                </div>

                
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Nom</th>
                                    <th>Catégorie</th>
                                    <th>Stock actuel</th>
                                    <th>Stock alerte</th>
                                    <th>État du stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produits as $key => $produit)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                         
                                                <img class="rounded avatar-sm"
                                                src="{{ $produit->hasMedia('ProduitImage') ? $produit->getFirstMediaUrl('ProduitImage') : asset('assets/img/logo/logo_Chez-jeanne.jpg') }}"
                                                width="50px" alt="{{ $produit['nom'] }}">
                                        </td>
                                        <td>{{ $produit->nom }}
                                            <p> {{ $produit['valeur_unite'] ?? '' }}
                                                {{ $produit['unite']['libelle'] ?? '' }}  {{ $produit->unite ? '('. $produit['unite']['abreviation'] .')' : '' }}   </p>
                                        </td>
                                        <td>{{ $produit->categorie->name }}</td>
                                        <td>{{ $produit->stock }}     {{ $produit['uniteSortie']['libelle'] ?? '' }}  {{ $produit->unite ? '('. $produit['uniteSortie']['abreviation'] .')' : '' }} </td>
                                        <td>{{ $produit->stock_alerte }} {{ $produit['uniteSortie']['libelle'] ?? '' }}  {{ $produit->unite ? '('. $produit['uniteSortie']['abreviation'] .')' : '' }} </td>
                                        <td>
                                            @if ($produit->stock <= $produit->stock_alerte)
                                                <span class="badge bg-danger">Alerte</span>
                                            @else
                                                <span class="badge bg-success">Normal</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
    <script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
