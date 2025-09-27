@extends('backend.layouts.master')
@section('title')
    Rapport des ventes par catégorie parent
@endsection
@section('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .divPrint,
            .divPrint * {
                visibility: visible;
            }

            .divPrint {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .btn,
            .dataTables_filter,
            .dataTables_length,
            .dataTables_info,
            .dataTables_paginate {
                display: none !important;
            }
        }

        .rapport-header {
            background: #f8f9fa;
            border-bottom: 2px solid #e9ecef;
            padding: 20px 0;
            text-align: center;
        }

        .rapport-header p {
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
    @component('backend.components.breadcrumb')
        @slot('li_1')
            Rapports
        @endslot
        @slot('title')
            Ventes par catégorie
        @endslot
    @endcomponent

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Filtres</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('rapport.vente') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Catégorie</label>
                    <select name="categorie_id" class="form-select">
                        <option value="">Toutes</option>
                        @php
                            function renderCategorieOptions($categories, $level = 0)
                            {
                                foreach ($categories as $cat) {
                                    $indent = str_repeat('— ', $level);
                                    echo '<option value="' .
                                        $cat->id .
                                        '" ' .
                                        (request('categorie_id') == $cat->id ? 'selected' : '') .
                                        '>' .
                                        $indent .
                                        $cat->name .
                                        '</option>';
                                    if ($cat->children && $cat->children->count()) {
                                        renderCategorieOptions($cat->children, $level + 1);
                                    }
                                }
                            }
                        @endphp
                        @php renderCategorieOptions($categories) @endphp
                    </select>
                    @if (request('categorie_id'))
                        <div class="mt-1 text-muted small">
                            <strong>Catégorie sélectionnée :</strong>
                            {{ optional(\App\Models\Categorie::find(request('categorie_id')))->name ?? 'Non trouvée' }}
                        </div>
                    @endif
                </div>
                <div class="col-md-2">
                    <label class="form-label">Caisse</label>
                    <select name="caisse_id" class="form-select">
                        <option value="">Toutes</option>
                        @foreach ($caisses as $caisse)
                            <option value="{{ $caisse->id }}" {{ request('caisse_id') == $caisse->id ? 'selected' : '' }}>
                                {{ $caisse->libelle }}
                            </option>
                        @endforeach
                    </select>
                    @if (request('caisse_id'))
                        <div class="mt-1 text-muted small">
                            <strong>Caisse sélectionnée :</strong>
                            {{ optional(\App\Models\Caisse::find(request('caisse_id')))->libelle ?? 'Non trouvée' }}
                        </div>
                    @endif
                </div>
                <div class="col-md-2">
                    <label class="form-label">Date début</label>
                    <input type="date" name="date_debut" class="form-control" value="{{ request('date_debut') }}">
                    @if (request('date_debut'))
                        <div class="mt-1 text-muted small">
                            <strong>Date début :</strong> {{ request('date_debut') }}
                        </div>
                    @endif
                </div>
                <div class="col-md-2">
                    <label class="form-label">Date fin</label>
                    <input type="date" name="date_fin" class="form-control" value="{{ request('date_fin') }}">
                    @if (request('date_fin'))
                        <div class="mt-1 text-muted small">
                            <strong>Date fin :</strong> {{ request('date_fin') }}
                        </div>
                    @endif
                </div>
                <div class="col-md-2">
                    <label class="form-label">Période</label>
                    <select name="periode" class="form-select">
                        <option value="">--</option>
                        <option value="jour" {{ request('periode') == 'jour' ? 'selected' : '' }}>Aujourd'hui</option>
                        <option value="semaine" {{ request('periode') == 'semaine' ? 'selected' : '' }}>Cette semaine
                        </option>
                        <option value="mois" {{ request('periode') == 'mois' ? 'selected' : '' }}>Ce mois</option>
                        <option value="annee" {{ request('periode') == 'annee' ? 'selected' : '' }}>Cette année</option>
                    </select>
                    @if (request('periode'))
                        <div class="mt-1 text-muted small">
                            <strong>Période :</strong>
                            @if (request('periode') == 'jour')
                                Aujourd'hui
                            @elseif(request('periode') == 'semaine')
                                Cette semaine
                            @elseif(request('periode') == 'mois')
                                Ce mois
                            @elseif(request('periode') == 'annee')
                                Cette année
                            @endif
                        </div>
                    @endif
                </div>
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary w-50"><i class="ri-filter-3-line"></i> Filtrer</button>
                    <a href="{{ route('rapport.vente') }}" class="btn btn-secondary"><i class="ri-refresh-line"></i> Réinitialiser</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card divPrint">
        <div class="rapport-header">
            <h2 style="text-align: center">Rapport des Ventes par Catégorie</h2>
            <p class="mb-0" style="text-align: center">
                <small>
                    @if (request('date_debut') && request('date_fin'))
                        Du <b>{{ request('date_debut') }}</b> au <b>{{ request('date_fin') }}</b>
                    @elseif(request('periode'))
                        @if (request('periode') == 'jour')
                            Aujourd'hui
                        @elseif(request('periode') == 'semaine')
                            Cette semaine
                        @elseif(request('periode') == 'mois')
                            Ce mois
                        @elseif(request('periode') == 'annee')
                            Cette année
                        @endif
                    @else
                        Toutes les périodes
                    @endif
                </small>
            </p>
            @if (request()->hasAny(['categorie_id', 'caisse_id']))
                <p class="mb-0" style="text-align: center">
                    <small>
                        @if (request('categorie_id'))
                            Catégorie :
                            <b>{{ optional(\App\Models\Categorie::find(request('categorie_id')))->name ?? 'Non trouvée' }}</b>
                        @endif
                        @if (request('caisse_id'))
                            | Caisse :
                            <b>{{ optional(\App\Models\Caisse::find(request('caisse_id')))->libelle ?? 'Non trouvée' }}</b>
                        @endif
                    </small>
                </p>
            @endif
        </div>
        <div class="card-body">
            @forelse($categoriesParent as $parent => $infos)
                <h5 class="mt-4 text-primary">{{ $parent }}</h5>
                <div class="table-responsive mb-3">
                    <table class="table table-bordered table-sm rapport-table">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Quantité</th>
                                <th>Prix unitaire</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($infos['produits'] as $prod)
                                <tr>
                                    <td>{{ $prod['nom'] }}</td>
                                    <td>{{ $prod['quantite'] }}</td>
                                    <td>{{ number_format($prod['prix_unitaire'], 0, ',', ' ') }} FCFA</td>
                                    <td>{{ number_format($prod['total'], 0, ',', ' ') }} FCFA</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total ventes catégorie</th>
                                <th>{{ number_format($infos['total_ventes'], 0, ',', ' ') }} FCFA</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @empty
                <div class="alert alert-warning">Aucune vente enregistrée.</div>
            @endforelse

            <div class="resume-global text-center">
                {{-- <h4 class="mb-3 text-success">Résumé global</h4> --}}
                <p>
                <h4 style="text-align: center">Montant total toutes ventes :
                    <span class="fw-bold fs-4 text-primary">
                        {{ number_format($montantTotalVente, 0, ',', ' ') }} FCFA
                    </span>
                </h4>

                </p>
            </div>
        </div>
    </div>

    <button id="btnImprimer" class="w-100 btn btn-primary mt-3"><i class="ri ri-printer-fill"></i> Imprimer le
        Rapport</button>
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
