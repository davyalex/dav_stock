@extends('backend.layouts.master')
@section('title')
    Vente
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
            Gestion des ventes
        @endslot
        @slot('title')
            Détails de la vente
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="p-3 mb-3">
                    <h6 class="text-muted">Détails de la vente</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>N° vente :</strong> #{{ $vente->code }}</p>
                            <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($vente->date_vente)->format('d-m-Y') }}</p>
                            <p><strong>Caissier(e) :</strong> {{ $vente->user->first_name }} {{ $vente->user->last_name }}
                            </p>
                            <p><strong>Caisse :</strong> {{ $vente->caisse->libelle }}</p>
                        </div>
                        <div class="col-md-4">
                            @if ($vente->valeur_remise > 0)
                                <p><strong>Remise :</strong> {{ $vente->valeur_remise }}
                                    {{ $vente->type_remise == 'amount' ? 'FCFA' : '%' }}</p>

                                <p><strong>Montant avant remise :</strong>
                                    {{ number_format($vente->montant_avant_remise, 0, ',', ' ') }} FCFA</p>
                            @endif
                            <p><strong>Montant vente :</strong> {{ number_format($vente->montant_total, 0, ',', ' ') }} FCFA
                            </p>

                        </div>
                        <div class="col-md-4">
                            @if ($vente->modePaiement)
                                <p><strong>Mode de paiement :</strong> {{ $vente->modePaiement->libelle }}</p>
                            @endif
                            @if ($vente->montant_recu)
                                <p><strong>Montant reçu :</strong> {{ number_format($vente->montant_recu, 0, ',', ' ') }}
                                    FCFA</p>
                            @endif
                            @if ($vente->montant_rendu)
                                <p><strong>Montant rendu :</strong> {{ number_format($vente->montant_rendu, 0, ',', ' ') }}
                                    FCFA</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Produits associés à la vente</h5>
                    <div>
                        <button id="btnImprimerTicket" class="btn btn-info me-2">
                            <i class="ri-printer-line align-bottom me-1"></i> Reçu de caisse
                        </button>
                        @if (auth()->user()->hasRole(['caisse', 'supercaisse']))
                            <a href="{{ route('vente.create') }}" class="btn btn-primary">
                            <i class="ri-add-circle-line align-bottom me-1"></i> Nouvelle vente
                        </a>
                        @endif
                        
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Nom du produit</th>
                                    <th>Quantité</th>
                                    <th>Prix unitaire</th>
                                    <th>Montant total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vente->produits as $key => $item)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>
                                            <img class="rounded avatar-sm"
                                                src="{{ $item->getFirstMediaUrl('ProduitImage') }}" width="50px"
                                                alt="{{ $item->nom }}">
                                        </td>
                                        <td>{{ $item->nom }}</td>
                                        <td>{{ $item->pivot->quantite }}</td>
                                        <td>{{ number_format($item->pivot->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                                        <td>{{ number_format($item->pivot->quantite * $item->pivot->prix_unitaire, 0, ',', ' ') }}
                                            FCFA</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="ticket-container"
        style="font-family: 'Courier New', monospace; font-size: 14px; width: 300px; margin: 0 auto;">
        <div class="ticket-header" style="text-align: center; margin-bottom: 10px;">
            <h3 style="margin: 0;">Bienvenue</h3>
            <h5 style="margin: 0;">PATISSERIE</h5>
            <p style="border-top: 1px dashed black; margin: 5px 0;"></p>
            <table style="width:100%; font-size: 14px;">
                <tr>
                    <td>Caissier:</td>
                    <td><strong>{{ $vente->user->first_name }} {{ $vente->user->last_name }}</strong></td>
                </tr>
                <tr>
                    <td>Caisse:</td>
                    <td><strong>{{ $vente->caisse->libelle }}</strong></td>
                </tr>
                <tr>
                    <td>Ticket N°:</td>
                    <td><strong>{{ $vente->code }}</strong></td>
                </tr>
                <tr>
                    <td>Date:</td>
                    <td><strong>{{ \Carbon\Carbon::parse($vente->date_vente)->format('d/m/Y H:i') }}</strong></td>
                </tr>
            </table>
        </div>
        <div class="ticket-products">
            <table style="width: 100%; font-size: 14px; border-collapse: collapse; margin-bottom: 10px;">
                <thead style="border-bottom: 1px dashed black;">
                    <tr>
                        <th style="text-align: left;">Produit</th>
                        <th style="text-align: right;">Qté</th>
                        <th style="text-align: right;">P.U.</th>
                        <th style="text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vente->produits as $produit)
                        <tr>
                            <td>{{ $produit->nom }}</td>
                            <td style="text-align: right;">{{ $produit->pivot->quantite }}</td>
                            <td style="text-align: right;">{{ number_format($produit->pivot->prix_unitaire, 0, ',', ' ') }}
                            </td>
                            <td style="text-align: right;">{{ number_format($produit->pivot->quantite * $produit->pivot->prix_unitaire, 0, ',', ' ') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p style="border-top: 1px dashed black; margin: 5px 0;"></p>
        </div>
        <table style="width: 100%; font-size: 14px; margin-bottom: 10px;">
            @if ($vente->valeur_remise > 0)
                <tr>
                    <td>Montant avant remise:</td>
                    <td style="text-align: right;">
                        {{ number_format($vente->montant_avant_remise, 0, ',', ' ') }} FCFA
                    </td>
                </tr>
                <tr>
                    <td>Remise:</td>
                    <td style="text-align: right;">
                        {{ $vente->valeur_remise }} {{ $vente->type_remise == 'amount' ? 'FCFA' : '%' }}
                    </td>
                </tr>
            @endif
            <tr>
                <td><strong>Total à payer:</strong></td>
                <td style="text-align: right;"><strong>{{ number_format($vente->montant_total, 0, ',', ' ') }}
                        FCFA</strong></td>
            </tr>
        </table>
        <table style="width: 100%; font-size: 14px;">
            <tr>
                <td>Mode paiement:</td>
                <td style="text-align: right;">{{ $vente->modePaiement ? $vente->modePaiement->libelle : '' }}</td>
            </tr>
            <tr>
                <td>Montant reçu:</td>
                <td style="text-align: right;">{{ number_format($vente->montant_recu, 0, ',', ' ') }} FCFA</td>
            </tr>
            <tr>
                <td>Monnaie rendue:</td>
                <td style="text-align: right;">{{ number_format($vente->montant_rendu, 0, ',', ' ') }} FCFA</td>
            </tr>
        </table>
        <hr style="border-top: 1px dashed black; margin: 5px 0;">
        <div class="ticket-footer" style="text-align: center; font-size: 12px; font-weight: bold;">
            <span>MERCI DE VOTRE VISITE</span><br>
            <span>AU REVOIR ET À BIENTÔT</span><br>
            <span>RESERVATIONS: 0000000000</span>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#buttons-datatables').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    'print', 'excel', 'pdf'
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/fr_fr.json"
                }
            });
        });

        document.getElementById('btnImprimerTicket').addEventListener('click', function() {
            // Crée une modale d'aperçu
            let modal = document.createElement('div');
            modal.id = 'previewTicketModal';
            modal.style.position = 'fixed';
            modal.style.top = '0';
            modal.style.left = '0';
            modal.style.width = '100vw';
            modal.style.height = '100vh';
            modal.style.background = 'rgba(0,0,0,0.5)';
            modal.style.zIndex = '9999';
            modal.style.display = 'flex';
            modal.style.alignItems = 'center';
            modal.style.justifyContent = 'center';

            let ticketContent = document.querySelector('.ticket-container').outerHTML;

            modal.innerHTML = `
        <div style="background:#fff; padding:20px; border-radius:8px; min-width:320px; max-width:350px;">
            <h5 style="text-align:center;">Aperçu du ticket</h5>
            <div id="ticketPreviewArea">${ticketContent}</div>
            <div class="d-flex justify-content-between mt-3">
                <button id="closePreviewTicket" class="btn btn-secondary">Fermer</button>
                <button id="printPreviewTicket" class="btn btn-primary">Imprimer</button>
            </div>
        </div>
    `;
            document.body.appendChild(modal);

            document.getElementById('closePreviewTicket').onclick = function() {
                document.body.removeChild(modal);
            };

            document.getElementById('printPreviewTicket').onclick = function() {
                var ticketHtml = document.getElementById('ticketPreviewArea').innerHTML;
                var win = window.open('', '', 'width=300,height=600');
                win.document.write(`
            <html>
            <head>
                <title>Ticket de vente</title>
                <style>
                    body { margin: 0; padding: 0; }
                    .ticket-container {
                        width: 58mm;
                        font-size: 13px;
                        font-family: 'Courier New', monospace;
                        margin: 0 auto;
                    }
                    table { width: 100%; border-collapse: collapse; }
                    th, td { padding: 2px 0; }
                    hr { border: none; border-top: 1px dashed #000; margin: 4px 0; }
                </style>
            </head>
            <body onload="window.print();window.close();">
                ${ticketHtml}
            </body>
            </html>
        `);
                win.document.close();
                document.body.removeChild(modal);
            };
        });
    </script>
@endsection
