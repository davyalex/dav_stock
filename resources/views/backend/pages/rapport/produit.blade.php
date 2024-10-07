@extends('backend.layouts.master')
@section('title')
    Rapport des produits
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
            Rapport des produits
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Filtres</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('rapport.produit') }}" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="categorie" class="form-label">Catégorie</label>
                                    <select class="form-select" id="categorie" name="categorie">
                                        <option value="">Toutes les catégories</option>
                                        {{-- @foreach ($data_categorie as $categorie)
                                            @include('backend.pages.produit.partials.subCategorieOption', [
                                                'category' => $categorie,
                                            ])
                                        @endforeach --}}
                                        @foreach ($categorie_famille as $item)
                                            <option value="{{$item->famille}}" {{request('categorie') == $item->famille ? 'selected' : ''}}>
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
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="date_debut" class="form-label">Date de début</label>
                                    <input type="date" class="form-control" id="date_debut" name="date_debut"
                                        value="{{ request('date_debut') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
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
                        Rapport des produits 
                        @if(request('categorie'))
                            {{ request('categorie') == 'bar' ? 'boissons' : 'cuisine interne' }}
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
                    <div class="table-responsive">
                        <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Designation</th>
                                    {{-- <th>Famille</th> --}}
                                    <th>Catégorie</th>
                                    <th>Prix de vente</th>
                                    <th>Quantité vendue</th>
                                    <th>Montant total des ventes</th>
                                    <th>Stock disponible</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produits as $key => $produit)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $produit->code }}</td>
                                        <td>{{ $produit->nom }}</td>
                                        {{-- <td>{{ $produit->categorie->famille }}</td> --}}
                                        <td>{{ $produit->categorie->name }}</td>
                                        <td>
                                            {{-- {{ number_format($produit->prix_unitaire, 0, ',', ' ') }} FCFA --}}
                                            {{$produit->ventes[0]->pivot->prix_unitaire ?? 0}}
                                        </td>
                                        <td>{{ $produit->quantite_vendue }}</td>
                                        <td>{{ number_format($produit->montant_total_ventes, 0, ',', ' ') }} FCFA</td>
                                        <td>{{ $produit->stock ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                        <tfoot>
                           
                            <tr>
                                <th colspan="7">Résumé</th>
                            </tr>
                            <tr>
                                <td colspan="3">Nombre de produits :</td>
                                <td colspan="4">{{ $produits->count() }}</td>
                            </tr>
                            <tr>
                                <td colspan="3">Montant total des ventes :</td>
                                <td colspan="4">{{ number_format($produits->sum('montant_total_ventes'), 0, ',', ' ') }} FCFA</td>
                            </tr>
                            <tr>
                                <td colspan="3">Quantité totale vendue :</td>
                                <td colspan="4">{{ $produits->sum('quantite_vendue') }}</td>
                            </tr>
                        </tfoot>
                        </table>
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
