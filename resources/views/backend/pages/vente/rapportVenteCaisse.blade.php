@extends('backend.layouts.master')
@section('title')
    Rapport de caisse
@endsection
@section('css')
    <!--datatable css-->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <!--datatable responsive css-->
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet"
        type="text/css" />
    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <style>
        .rapport-header {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .rapport-section-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #0d6efd;
            margin-top: 30px;
            margin-bottom: 15px;
        }
        .table thead th {
            
            background: #e9ecef;
        }
        .synthese-list .list-group-item {
            font-size: 1.1rem;
        }
    </style>
@endsection
@section('content')
    @component('backend.components.breadcrumb')
        @slot('li_1')
            Rapports
        @endslot
        @slot('title')
            Rapport de caisse
        @endslot
    @endcomponent

    <div class="card divPrint">
        <div class="rapport-header text-center mb-3">
            <h3 class="mb-2">Rapport de caisse</h3>
            <div>
                <strong>Caisse :</strong> {{ $caisse->libelle ?? 'Non définie' }}<br>
                <strong>Date de session :</strong> {{ $sessionDate ? \Carbon\Carbon::parse($sessionDate)->format('d/m/Y') : 'Non définie' }}
            </div>
        </div>
        <div class="card-body">
            <div class="rapport-section-title">Synthèse</div>
            <ul class="list-group mb-4 synthese-list">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Total ventes</span>
                    <span class="fw-bold text-success">{{ number_format($totalVentes, 0, ',', ' ') }} FCFA</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Total remises</span>
                    <span class="fw-bold text-warning">{{ number_format($totalRemise, 0, ',', ' ') }} FCFA</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Montant reçu</span>
                    <span class="fw-bold">{{ number_format($totalRecu, 0, ',', ' ') }} FCFA</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Monnaie rendue</span>
                    <span class="fw-bold">{{ number_format($totalRendu, 0, ',', ' ') }} FCFA</span>
                </li>
            </ul>

            <div class="rapport-section-title">Répartition par mode de paiement</div>
            <ul class="list-group mb-4">
                @forelse($paiements as $mode => $montant)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $mode }}</span>
                        <span class="fw-bold">{{ number_format($montant, 0, ',', ' ') }} FCFA</span>
                    </li>
                @empty
                    <li class="list-group-item text-center">Aucun paiement enregistré</li>
                @endforelse
            </ul>

            <div class="rapport-section-title">Produits vendus par catégorie</div>
            @php
                $produitsCategories = [];
                foreach ($ventes as $vente) {
                    foreach ($vente->produits as $produit) {
                        $cat = $produit->categorie->name ?? 'Autre';
                        if (!isset($produitsCategories[$cat])) {
                            $produitsCategories[$cat] = [];
                        }
                        $key = $produit->id;
                        if (!isset($produitsCategories[$cat][$key])) {
                            $produitsCategories[$cat][$key] = [
                                'nom' => $produit->nom,
                                'quantite' => 0,
                                'prix_unitaire' => $produit->pivot->prix_unitaire,
                                'montant_total' => 0
                            ];
                        }
                        $produitsCategories[$cat][$key]['quantite'] += $produit->pivot->quantite;
                        $produitsCategories[$cat][$key]['montant_total'] += $produit->pivot->quantite * $produit->pivot->prix_unitaire;
                    }
                }
            @endphp
            @forelse($produitsCategories as $categorie => $produits)
                <h5 class="mt-3 text-primary">{{ $categorie }}</h5>
                <div class="table-responsive mb-3">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Quantité vendue</th>
                                <th>Prix unitaire</th>
                                <th>Montant total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produits as $prod)
                                <tr>
                                    <td>{{ $prod['nom'] }}</td>
                                    <td>{{ $prod['quantite'] }}</td>
                                    <td>{{ number_format($prod['prix_unitaire'], 0, ',', ' ') }} FCFA</td>
                                    <td>{{ number_format($prod['montant_total'], 0, ',', ' ') }} FCFA</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total catégorie :</th>
                                <th>
                                    {{ number_format(collect($produits)->sum('montant_total'), 0, ',', ' ') }} FCFA
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @empty
                <div class="alert alert-warning">Aucun produit vendu pour cette session.</div>
            @endforelse

            <div class="rapport-section-title">Produits vendus (regroupés par produit)</div>
            @php
                $produitsGroupes = [];
                foreach ($ventes as $vente) {
                    foreach ($vente->produits as $produit) {
                        $key = $produit->id;
                        if (!isset($produitsGroupes[$key])) {
                            $produitsGroupes[$key] = [
                                'nom' => $produit->nom,
                                'categorie' => $produit->categorie->name ?? 'Autre',
                                'quantite' => 0,
                                'prix_unitaire' => $produit->pivot->prix_unitaire,
                                'montant_total' => 0
                            ];
                        }
                        $produitsGroupes[$key]['quantite'] += $produit->pivot->quantite;
                        $produitsGroupes[$key]['montant_total'] += $produit->pivot->quantite * $produit->pivot->prix_unitaire;
                    }
                }
            @endphp
            <div class="table-responsive mb-3">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Catégorie</th>
                            <th>Quantité totale vendue</th>
                            <th>Prix unitaire</th>
                            <th>Montant total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produitsGroupes as $prod)
                            <tr>
                                <td>{{ $prod['nom'] }}</td>
                                <td>{{ $prod['categorie'] }}</td>
                                <td>{{ $prod['quantite'] }}</td>
                                <td>{{ number_format($prod['prix_unitaire'], 0, ',', ' ') }} FCFA</td>
                                <td>{{ number_format($prod['montant_total'], 0, ',', ' ') }} FCFA</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total général :</th>
                            <th>
                                {{ number_format(collect($produitsGroupes)->sum('montant_total'), 0, ',', ' ') }} FCFA
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <button id="btnImprimer" class="btn btn-primary w-100 mt-3"><i class="ri ri-printer-fill"></i> Imprimer le Rapport</button>
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
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            $('#btnImprimer').on('click', function() {
                var printContent = $('.divPrint').html();
                var win = window.open('', '', 'width=900,height=700');
                win.document.write(`
                    <html>
                    <head>
                        <title>Rapport de caisse</title>
                        <style>
                            body { font-family: Arial, sans-serif; }
                            table { width: 100%; border-collapse: collapse; }
                            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                            th { background-color: #f2f2f2; }
                            .card-header, .card-title { text-align: center; }
                            .rapport-header { background: #f8f9fa; border-radius: 8px; padding: 20px; margin-bottom: 20px; }
                            .rapport-section-title { font-size: 1.2rem; font-weight: bold; color: #0d6efd; margin-top: 30px; margin-bottom: 15px; }
                            .table thead th { background: #e9ecef; }
                            .synthese-list .list-group-item { font-size: 1.1rem; }
                        </style>
                    </head>
                    <body>
                        ${printContent}
                    </body>
                    </html>
                `);
                win.document.close();
                win.print();
            });
        });
    </script>
@endsection
