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

    <style>
        @media print {
            .ticket-container {
                width: 58mm;
                /* Adapte en fonction de ton imprimante */
                font-size: 12px;
                /* Ajuste selon le besoin */
                font-family: 'Courier New', monospace;
            }
        }

        @media print {
            @page {
                margin: 0;
            }

            body {
                margin: 0;
            }
        }
    </style>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class=" p-3  mb-3">
                    <h6 class="text-muted">Détails de la vente</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>N° vente :</strong> #{{ $vente->code }}</p>
                            <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($vente['date_vente'])->format('d-m-Y') }}
                            </p>
                            @if ($vente->type_vente == 'commande')
                                <p><strong>Type de vente :</strong> <a
                                        href="{{ route('commande.show', $vente->commande->id) }}"> {{ $vente->type_vente }};
                                        #{{ $vente->commande->code }} </a></p>
                            @else
                                <p><strong>Type de vente :</strong> {{ $vente->type_vente }}</p>
                            @endif
                        </div>
                        <div class="col-md-4">
                            @if ($vente->valeur_remise > 0)
                                <p><strong>Remise :</strong> {{ $vente->valeur_remise }}
                                    {{ $vente->type_remise == 'amount' ? 'FCFA' : '%' }}</p>
                            @endif
                            <p><strong>Montant vente :</strong> {{ $vente->montant_total }}</p>
                            <p><strong>Caissier(e) :</strong> {{ $vente->user->first_name }} {{ $vente->user->last_name }}</p>
                            <p><strong>Caisse :</strong> {{ $vente->caisse->libelle }}</p>
                        </div>
                        {{-- @if ($vente->type_vente != 'commande') --}}
                        <div class="col-md-4">
                            @if ($vente->mode_paiement)
                                <p><strong>Réglement :</strong> {{ $vente->mode_paiement }}</p>
                            @endif
                            @if ($vente->montant_recu)
                                <p><strong>Montant reçu :</strong> {{ $vente->montant_recu }}</p>
                            @endif
                            @if ($vente->montant_rendu)
                                <p><strong>Montant rendu :</strong> {{ $vente->montant_rendu }}</p>
                            @endif
                        </div>
                        {{-- @endif --}}
                    </div>
                </div>
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Produits de la vente </h5>

                    <div class="d-flex justify-content-end">
                        <button id="btnImprimerTicket" class="btn btn-info me-2 flot-end"> <i
                                class="ri-printer-line align-bottom me-1"></i> Imprimer le reçu</button>

                        @can('creer-vente')
                            <a href="{{ route('vente.create') }}" type="button" class="btn btn-primary">Nouvelle vente</a>
                        @endcan

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
                                    <tr id="row_{{ $item['id'] }}">
                                        <td>{{ ++$key }}</td>
                                        <td>
                                            <img class="rounded avatar-sm"
                                                src="{{ $item->getFirstMediaUrl('ProduitImage') }}" width="50px"
                                                alt="{{ $item['nom'] }}">
                                        </td>
                                        <td>{{ $item['nom'] }}</td>
                                        <!-- Recuperer le libelle de la variante en fonction de son id -->


                                        <td><b> {{ $item['pivot']['quantite'] }}</b>
                                            @if ($item['pivot']['variante_id'])
                                                {{ \App\Models\Variante::find($item['pivot']['variante_id'])->libelle }}
                                            @endif
                                        </td>
                                        <td>{{ number_format($item['pivot']['prix_unitaire'], 0, ',', ' ') }} FCFA</td>
                                        <td>{{ number_format($item['pivot']['quantite'] * $item['pivot']['prix_unitaire'], 0, ',', ' ') }}
                                            FCFA</td>
                                    </tr>
                                @endforeach


                                @foreach ($vente->plats as $key => $item)
                                    <tr id="row_{{ $item['id'] }}">
                                        <td>
                                            <span class="badge bg-primary">Vente depuis Menu du jour</span>
                                        </td>
                                        <td>
                                            <img class="rounded avatar-sm"
                                                src="{{ $item->hasMedia('ProduitImage') ? $item->getFirstMediaUrl('ProduitImage') : asset('assets/img/logo/logo_Chez-jeanne.jpg') }}"
                                                width="50px" alt="{{ $item['nom'] }}">
                                        </td>
                                        <td>
                                            <p class="text-capitalize fw-bold ">{{ $item['nom'] }} * <span
                                                    class="text-danger">{{ $item['pivot']['quantite'] }}</span></p>
                                            @if (json_decode($item['pivot']['garniture']))
                                                <div>
                                                    <small class="ms-3 fw-bold">Garniture:</small>
                                                    @foreach (json_decode($item['pivot']['garniture']) as $garniture)
                                                        <div class="garniture ms-3">
                                                            {{ $garniture->nom }} (Qté: {{ $garniture->quantity }})
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif


                                            @if (json_decode($item['pivot']['complement']))
                                                <div class="mt-2">
                                                    <small class="ms-3 fw-bold">Complément:</small>
                                                    @foreach (json_decode($item['pivot']['complement']) as $complement)
                                                        <div class="complement ms-3">
                                                            {{ $complement->nom }} (Qté: {{ $complement->quantity }})
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $item['pivot']['quantite'] }}</td>
                                        <td>{{ number_format($item['pivot']['prix_unitaire'], 0, ',', ' ') }} FCFA</td>
                                        <td>{{ number_format($item['pivot']['quantite'] * $item['pivot']['prix_unitaire'], 0, ',', ' ') }}
                                            FCFA</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>

            <!-- ========== Start facture generé ========== -->
            <div class="ticket-container"
                style="font-family: 'Courier New', monospace; font-size: 14px; width: 300px; margin: 0 auto;">
                <div class="ticket-header" style="text-align: center; margin-bottom: 10px;">
                    <h3 style="margin: 0;">CHEZ JEANNE</h3>
                    <h5 style="margin: 0;">RESTAURANT LOUNGE</h5>
                    <h5 style="margin: 5px 0;">AFRICAIN ET EUROPEEN</h5>
                    <p style="border-top: 1px dashed black; margin: 5px 0;"></p>

                    <table class="header" style="font-size: 16px">
                        <tr style="text-align: left;">
                            <td>Table <strong>N°: {{ $vente->numero_table ?? '' }}</strong> </td>
                            <td>Couvert(s) <strong> : {{ $vente->nombre_couverts ?? '' }}</strong> </td>
                        </tr>

                        <tr style="text-align: left;">
                            <td>Caissier: <strong> {{ $vente->user->first_name }}</strong>
                            </td>
                            <td>Caisse: <strong> {{ $vente->caisse->libelle ?? 'Non définie' }}</strong> </td>
                        </tr>

                        <tr style="text-align: left;">
                            <td>Ticket <strong>N°: {{ $vente->code }}</strong> </td>

                            <td>émis: <strong> {{ $vente->created_at->format('d/m/Y à H:i') }}</strong> </td>
                        </tr>

                    </table>

                </div>



                <div class="ticket-products">
                    <table
                        style="width: 100%; font-size: 18px; border-collapse: collapse; margin-bottom: 10px; font-weight:600;">
                        <thead style="border-bottom: 1px dashed black;">
                            <tr>
                                <th style="text-align: left;">DESIGNATION</th>
                                <th style="text-align: right;">P.U.</th>
                                <th style="text-align: right;">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vente->produits as $produit)
                                <tr>
                                    <td>{{ $produit->nom }} x <b>{{ $produit->pivot->quantite }}</b>
                                        @if ($produit->categorie->famille == 'bar' && isset($produit['pivot']['variante_id']))
                                            @php
                                                $variante = \App\Models\Variante::find(
                                                    $produit['pivot']['variante_id'],
                                                );
                                            @endphp
                                            {{ $variante ? $variante->libelle : '' }}
                                        @endif

                                    </td>
                                    <td style="text-align: right;">
                                        {{ number_format($produit->pivot->prix_unitaire, 0, ',', ' ') }}</td>
                                    <td style="text-align: right;">
                                        {{ number_format($produit->pivot->quantite * $produit->pivot->prix_unitaire, 0, ',', ' ') }}
                                    </td>
                                </tr>
                            @endforeach

                            @foreach ($vente->plats as $plat)
                                <tr>
                                    <td>
                                        {{ $plat->nom }} x{{ $plat->pivot->quantite }}
                                        @if (json_decode($plat['pivot']['garniture']))
                                            <small><br>- Garniture:
                                                @foreach (json_decode($plat['pivot']['garniture']) as $garniture)
                                                    {{ $garniture->nom }} (Qté: {{ $garniture->quantity }})
                                                @endforeach
                                            </small>
                                        @endif
                                        @if (json_decode($plat['pivot']['complement']))
                                            <small><br>- Complément:
                                                @foreach (json_decode($plat['pivot']['complement']) as $complement)
                                                    {{ $complement->nom }} (Qté: {{ $complement->quantity }})
                                                @endforeach
                                            </small>
                                        @endif
                                    </td>
                                    <td style="text-align: right;">
                                        {{ number_format($plat->pivot->prix_unitaire, 0, ',', ' ') }}</td>
                                    <td style="text-align: right;">
                                        {{ number_format($plat->pivot->quantite * $plat->pivot->prix_unitaire, 0, ',', ' ') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>



                    <p style="border-top: 1px dashed black; margin: 5px 0;"></p>
                </div>

                <table style="width: 100%; font-size: 18px; margin-bottom: 10px; font-weight:bold;">
                    @if ($vente->valeur_remise > 0)
                        <tr>
                            <td><strong>TOTAL FACTURE:</strong></td>
                            <td style="text-align: right;">
                                <strong>{{ number_format($vente->montant_avant_remise, 0, ',', ' ') }} FCFA</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>Remise appliquée:</td>
                            <td style="text-align: right;">
                                {{ $vente->valeur_remise }} {{ $vente->type_remise == 'amount' ? 'FCFA' : '%' }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>TOTAL A PAYER:</strong></td>
                            <td style="text-align: right;"><strong>{{ number_format($vente->montant_total, 0, ',', ' ') }}
                                    FCFA</strong></td>
                        </tr>
                    @else
                        <tr>
                            <td><strong>TOTAL A PAYER:</strong></td>
                            <td style="text-align: right;"><strong>{{ number_format($vente->montant_total, 0, ',', ' ') }}
                                    FCFA</strong></td>
                        </tr>
                    @endif
                </table>

                <hr style="border-top: 1px dashed black; margin: 5px 0;">

                <table style="width: 100%; font-size: 18px; font-weight:bold;">
                    <tr>
                        <td><strong>Règlement le :</strong></td>
                        <td style="text-align: right;">{{ $vente->created_at->format('d/m/Y à H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Reçu :</strong></td>
                        <td style="text-align: right;">
                            {{ $vente->montant_recu ? number_format($vente->montant_recu, 0, ',', ' ') : '0' }} FCFA
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Rendu:</strong></td>
                        <td style="text-align: right;">
                            {{ $vente->montant_rendu ? number_format($vente->montant_rendu, 0, ',', ' ') : '0' }} FCFA
                        </td>
                    </tr>
                </table>


                <hr style="border-top: 1px dashed black; margin: 5px 0;">


                <div class="ticket-footer" style="text-align: center; font-size: 12px; font-weight: bold;">
                    <span>MERCI DE VOTRE VISITE</span><br>
                    <span>AU REVOIR ET À BIENTÔT</span><br>
                    <span>RESERVATIONS: 07-49-88-95-18</span><br>
                    <span>www.chezjeanne.ci</span>
                </div>
            </div>


            <script>
                document.getElementById('btnImprimerTicket').addEventListener('click', function() {
                    var ticketContent = document.querySelector('.ticket-container').innerHTML;
                    var win = window.open('', '', 'height=700,width=700');
                    win.document.write('<html><head><title>Ticket de vente</title></head><body>');
                    win.document.write(ticketContent);
                    win.document.write('</body></html>');
                    win.document.close();
                    win.print();
                });
            </script>
            <!-- ========== End facture generé ========== -->



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
