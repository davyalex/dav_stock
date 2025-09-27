@extends('backend.layouts.master')
@section('title')
    Rapport des ventes par produit
@endsection
@section('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <style>
        @media print {
            body * { visibility: hidden; }
            .divPrint, .divPrint * { visibility: visible; }
            .divPrint { position: absolute; left: 0; top: 0; width: 100%; }
            .btn, .dataTables_filter, .dataTables_length, .dataTables_info, .dataTables_paginate { display: none !important; }
            .rapport-header { text-align: center !important; margin-bottom: 20px; }
        }
        .rapport-header {
            background: #f8f9fa;
            border-bottom: 2px solid #e9ecef;
            padding: 20px 0;
            text-align: center;
        }
        .rapport-table th {
            background: #e9ecef;
            font-weight: bold;
        }
        .rapport-table tfoot th {
            background: #f8f9fa;
            color: #198754;
        }
        .resume-global {
            background: #f6fff6;
            border: 1px solid #d1e7dd;
            padding: 20px;
            margin-top: 30px;
            border-radius: 8px;
        }
    </style>
@endsection
@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <h5>Filtres</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('rapport.produit') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Produit</label>
                        <select name="produit_id" class="form-select">
                            <option value="">Tous</option>
                            @foreach($produits as $prod)
                                <option value="{{ $prod->id }}" {{ request('produit_id') == $prod->id ? 'selected' : '' }}>
                                    {{ $prod->nom }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Caisse</label>
                        <select name="caisse_id" class="form-select">
                            <option value="">Toutes</option>
                            @foreach($caisses as $caisse)
                                <option value="{{ $caisse->id }}" {{ request('caisse_id') == $caisse->id ? 'selected' : '' }}>
                                    {{ $caisse->libelle }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Classement</label>
                        <select name="classement" class="form-select">
                            <option value="">--</option>
                            <option value="plus_vendu" {{ request('classement') == 'plus_vendu' ? 'selected' : '' }}>Les plus vendus</option>
                            <option value="moins_vendu" {{ request('classement') == 'moins_vendu' ? 'selected' : '' }}>Les moins vendus</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Date début</label>
                        <input type="date" name="date_debut" class="form-control" value="{{ request('date_debut') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Date fin</label>
                        <input type="date" name="date_fin" class="form-control" value="{{ request('date_fin') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Période</label>
                        <select name="periode" class="form-select">
                            <option value="">--</option>
                            <option value="jour" {{ request('periode') == 'jour' ? 'selected' : '' }}>Jour</option>
                            <option value="semaine" {{ request('periode') == 'semaine' ? 'selected' : '' }}>Semaine</option>
                            <option value="mois" {{ request('periode') == 'mois' ? 'selected' : '' }}>Mois</option>
                            <option value="annee" {{ request('periode') == 'annee' ? 'selected' : '' }}>Année</option>
                        </select>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    
                    <div class="col-md-12 text-center ">
                        <button type="submit" class="btn btn-primary w-50"><i class="ri-filter-3-line"></i> Filtrer</button>
                        <a href="{{ route('rapport.produit') }}" class="btn btn-secondary"><i class="ri-refresh-line"></i> Réinitialiser</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card divPrint">
        <div class="rapport-header">
            <h2>Rapport des Ventes par Produit</h2>
            <p class="mb-0">
                <small>
                    @if(request('date_debut') && request('date_fin'))
                        Du <b>{{ request('date_debut') }}</b> au <b>{{ request('date_fin') }}</b>
                    @elseif(request('periode'))
                        @if(request('periode') == 'jour') Aujourd'hui
                        @elseif(request('periode') == 'semaine') Cette semaine
                        @elseif(request('periode') == 'mois') Ce mois
                        @elseif(request('periode') == 'annee') Cette année
                        @endif
                    @else
                        Toutes les périodes
                    @endif
                </small>
            </p>
            @if (request()->hasAny(['produit_id', 'caisse_id']))
                <p class="mb-0">
                    <small>
                        @if(request('produit_id'))
                            Produit : <b>{{ optional(\App\Models\Produit::find(request('produit_id')))->nom ?? 'Non trouvé' }}</b>
                        @endif
                        @if(request('caisse_id'))
                            | Caisse : <b>{{ optional(\App\Models\Caisse::find(request('caisse_id')))->libelle ?? 'Non trouvée' }}</b>
                        @endif
                    </small>
                </p>
            @endif
            @if(request('classement'))
                <p class="mb-0">
                    <small>
                        Classement :
                        @if(request('classement') == 'plus_vendu') Les plus vendus
                        @elseif(request('classement') == 'moins_vendu') Les moins vendus
                        @endif
                    </small>
                </p>
            @endif
        </div>
        <div class="card-body">
            @if($ventesProduit->count())
                <table class="table table-bordered table-sm rapport-table">
                    <thead>
                        <tr>
                            <th>Date vente</th>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Prix unitaire</th>
                            <th>Total</th>
                            <th>Caisse</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ventesProduit as $vente)
                            <tr>
                                <td>{{ $vente->vente->date_vente }}</td>
                                <td>{{ $vente->produit->nom }}</td>
                                <td>{{ $vente->quantite }}</td>
                                <td>{{ number_format($vente->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                                <td>{{ number_format($vente->quantite * $vente->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                                <td>{{ $vente->vente->caisse->libelle ?? '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total vendu</th>
                            <th colspan="2">{{ number_format($totalVendu, 0, ',', ' ') }} FCFA</th>
                        </tr>
                    </tfoot>
                </table>
            @else
                <div class="alert alert-warning">Aucune vente pour ce produit.</div>
            @endif

            <div class="resume-global text-center">
                <h4 class="mb-3 text-success" style="text-align: center">Résumé global</h4>
                <p style="text-align: center">
                    <b>Montant total toutes ventes :</b>
                    <span class="fw-bold fs-4 text-primary">
                        {{ number_format($totalVendu, 0, ',', ' ') }} FCFA
                    </span>
                </p>
            </div>
        </div>
    </div>

    <button id="btnImprimer" class="w-100 btn btn-primary mt-3"><i class="ri ri-printer-fill"></i> Imprimer le Rapport</button>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            function imprimerRapport() {
                var contenuImprimer = `
                <html>
                    <head>
                        <title>Rapport de Vente</title>
                        <style>
                            body { font-family: Arial, sans-serif; }
                            table { width: 100%; border-collapse: collapse; }
                            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                            th { background-color: #e9ecef; }
                            .resume-global { background: #f6fff6; border: 1px solid #d1e7dd; padding: 20px; margin-top: 30px; border-radius: 8px; }
                            h2, h4, h5 { color: #198754; }
                            .rapport-header { text-align: center !important; margin-bottom: 20px; }
                        </style>
                    </head>
                    <body>
                        ${$('.divPrint').html()}
                    </body>
                </html>
                `;
                var printWindow = window.open('', '', 'height=900,width=1200');
                printWindow.document.write(contenuImprimer);
                printWindow.document.close();
                printWindow.focus();
                printWindow.print();
                printWindow.close();
            }

            $('#btnImprimer').on('click', imprimerRapport);
        });
    </script>
@endsection
