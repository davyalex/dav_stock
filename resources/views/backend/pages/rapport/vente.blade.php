@extends('backend.layouts.master')
@section('title')
    Rapport des ventes par catégorie
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
            Rapports
        @endslot
        @slot('title')
            Rapport des ventes par catégorie
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Filtres</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('rapport.vente') }}" method="GET">
                        @csrf
                        <div class="row">

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="caisse_id" class="form-label">Caisse</label>
                                    <select class="form-select" id="caisse_id" name="caisse_id">
                                        <option value="">Toutes les caisses</option>
                                        @foreach ($caisses as $caisse)
                                            <option value="{{ $caisse->id }}" {{ request('caisse_id') == $caisse->id ? 'selected' : '' }}>
                                                {{ $caisse->libelle }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="date_debut" class="form-label">Famille</label>
                                <select class="form-select" id="categorie" name="categorie_famille">
                                    <option value="">Toutes les catégories</option>
                                    @foreach ($famille as $item)
                                        <option value="{{$item->famille}}" {{request('categorie_famille') == $item->famille ? 'selected' : ''}}>
                                            @if($item->famille == 'bar')
                                                Boissons
                                            @elseif($item->famille == 'menu') 
                                                Cuisine interne
                                            @else
                                                {{$item->famille}}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="date_debut" class="form-label">Date de début</label>
                                    <input type="date" class="form-control" id="date_debut" name="date_debut"
                                        value="{{ request('date_debut') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="date_fin" class="form-label">Date de fin</label>
                                    <input type="date" class="form-control" id="date_fin" name="date_fin"
                                        value="{{ request('date_fin') }}">
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Filtrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        Rapport des ventes 
                        @if(request('caisse_id'))
                            <strong> {{ $caisses->find(request('caisse_id'))->libelle }}</strong>
                        @endif
                        @if(request('categorie_famille'))
                            @if(request('categorie_famille') == 'bar')
                                pour les Boissons
                            @elseif(request('categorie_famille') == 'menu')
                                pour la Cuisine interne
                            @else
                                pour {{ request('categorie_famille') }}
                            @endif
                        @endif
                        @if(request('date_debut') || request('date_fin'))
                            du 
                            @if(request('date_debut'))
                                {{ \Carbon\Carbon::parse(request('date_debut'))->format('d/m/Y') }}
                            @endif
                            @if(request('date_fin'))
                                au {{ \Carbon\Carbon::parse(request('date_fin'))->format('d/m/Y') }}
                            @endif
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($produitsVendus->groupBy('famille') as $famille => $produits)
                        <h3>
                            @if($famille == 'bar')
                            Boissons
                        @elseif($famille == 'menu') 
                            Cuisine interne
                        @else
                            {{$famille}}
                        @endif</h3>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nom du produit</th>
                                        <th>Catégorie</th>
                                        <th>Quantité vendue</th>
                                        <th>Montant total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($produits as $produit)
                                        <tr>
                                            <td>{{ $produit['nom'] }}</td>
                                            <td>{{ $produit['categorie'] }}</td>
                                            <td>{{ $produit['quantite_vendue'] }}</td>
                                            <td>{{ number_format($produit['montant_total'], 0, ',', ' ') }} FCFA</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2">Total pour {{ $famille }}</th>
                                        <th>{{ $produits->sum('quantite_vendue') }}</th>
                                        <th>{{ number_format($produits->sum('montant_total'), 0, ',', ' ') }} FCFA</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @endforeach
                    
                    <div class="mt-4">
                        <h3>Résumé global</h3>
                        <p>Nombre total de produits vendus : {{ $produitsVendus->sum('quantite_vendue') }}</p>
                        <p>Montant total des ventes : {{ number_format($produitsVendus->sum('montant_total'), 0, ',', ' ') }} FCFA</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->
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
