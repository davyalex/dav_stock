@extends('backend.layouts.master')
@section('title')
    Détails de la commande
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
            Gestion des commandes
        @endslot
        @slot('title')
            Détails de la commande
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class=" p-3  mb-3">
                    <h6 class="text-muted">Détails de la commande</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>N° commande :</strong> #{{ $commande->code }}</p>
                            <p><strong>Date :</strong> {{ $commande->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Client :</strong> {{ $commande->client->first_name }}
                                {{ $commande->client->last_name }}</p>
                            <p><strong>Téléphone :</strong> {{ $commande->client->phone }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Mode de livraison :</strong> {{ $commande->mode_livraison }}</p>
                            <p><strong>Adresse de livraison :</strong> {{ $commande->adresse_livraison }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Produits de la commande</h5>
                   
                   
                 @if (auth()->user()->hasRole('caisse'))
                 <div class="d-flex justify-content-end mt-3">
                    {{-- <a href="{{ route('commande.index') }}" type="button" class="btn btn-primary">Retour aux commandes</a> --}}

                    <button type="button" class="btn btn-info me-2 btnImprimerTicket" onclick="imprimerFacture()">
                        <i class="ri-printer-line align-bottom me-1"></i> Imprimer la facture
                    </button>
                    <select class="form-select w-auto" data-commande="{{ $commande->id }}"
                        onchange="changerStatut(this)" {{ $commande->statut == 'livrée' ? 'disabled' : '' }}>
                        <option value="">Changer le statut</option>
                        @if ($commande->statut == 'annulée' || ($commande->statut != 'confirmée' && $commande->statut != 'livrée'))
                            <option value="en attente" {{ $commande->statut == 'en attente' ? 'selected' : '' }}>En
                                attente</option>
                            <option value="confirmée" {{ $commande->statut == 'confirmée' ? 'selected' : '' }}>
                                Confirmée</option>
                            <option value="livrée" {{ $commande->statut == 'livrée' ? 'selected' : '' }}>Livrée
                            </option>
                            <option value="annulée" {{ $commande->statut == 'annulée' ? 'selected' : '' }}>Annulée
                            </option>
                        @elseif($commande->statut == 'confirmée' || $commande->statut == 'livrée')
                            <option value="livrée" {{ $commande->statut == 'livrée' ? 'selected' : '' }}>Livrée
                            </option>
                            <option value="annulée" {{ $commande->statut == 'annulée' ? 'selected' : '' }}>Annulée
                            </option>
                        @endif
                    </select>

                </div>
                 @endif

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
                                @foreach ($commande->produits as $key => $item)
                                    <tr id="row_{{ $item['id'] }}">
                                        <td>{{ ++$key }}</td>
                                        <td>
                                            <img class="rounded-circle" src="{{ $item->getFirstMediaUrl('ProduitImage') }}"
                                                width="50px" alt="">
                                        </td>
                                        <td>{{ $item['nom'] }}</td>
                                        <td>{{ $item['pivot']['quantite'] }}</td>
                                        <td>{{ number_format($item['pivot']['prix_unitaire'], 0, ',', ' ') }} FCFA</td>
                                        <td>{{ number_format($item['pivot']['quantite'] * $item['pivot']['prix_unitaire'], 0, ',', ' ') }}
                                            FCFA</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end"><strong>Total de la commande:</strong></td>
                                    <td><strong>{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>


             <!-- ========== Start facture generé ========== -->

             
             <div class="ticket-container col-8 m-auto" style="font-family: 'Courier New', monospace; font-size: 12px; width: 350px;">
                <div class="ticket-header" style="text-align: center;">
                    <h3>CHEZ JEANNE</h3>
                    <h4>RESTAURANT LOUNGE</h4>
                    <h5>AFRICAIN ET EUROPEEN</h5>
                    <p>-------------------------------</p>
                    <div style="display: flex; justify-content: space-between; padding: 0 10px;">
                        <span><strong>Commande:</strong> #{{ $commande->code }}</span>
                        <span><strong>Date:</strong> {{ $commande->created_at->format('d/m/Y à H:i') }}</span>
                    </div>
                </div>
                <div class="ticket-info" style="padding: 0 10px;">

                   
                    <div style="display: flex; justify-content: space-between;">
                        <span><strong>Caisse:</strong> {{ Auth::user()->caisse->libelle ?? 'Non définie' }}</span>
                        <span><strong>Caissier:</strong> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                    </div>
                </div>
                <p style="text-align: center;">-------------------------------</p>
                <div class="ticket-products">
                    <table style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Designation</th>
                                <th>Qté</th>
                                <th>P.U.</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($commande->produits as $produit)
                                <tr>
                                    <td>{{ $produit->nom }}</td>
                                    <td>{{ $produit->pivot->quantite }}</td>
                                    <td>{{ number_format($produit->pivot->prix_unitaire, 0, ',', ' ') }}</td>
                                    <td>{{ number_format($produit->pivot->quantite * $produit->pivot->prix_unitaire, 0, ',', ' ') }}
                                    </td>
                                </tr>
                            
                            @endforeach
                            <tfoot>
                                <tr>
                                    <th colspan="3" style="text-align: right;">Total:</th>
                                    <th>{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</th>
                                </tr>
                            </tfoot>
                        </tbody>
                    </table>
                </div>
               

                <p style="text-align: center;">-------------------------------</p>

                {{-- <div class="reglement col-md-8 m-auto" style="text-align: justify;">
                    <span><strong>Réglement:</strong> {{ $commande->created_at->format('d/m/Y à H:i:s') }}</span><br>
                    <span><strong class="text-capitalize">{{ $commande->mode_paiement }}:</strong>
                        {{ number_format($commande->montant_recu, 0, ',', ' ') }} FCFA</span><br>
                    <span><strong>Rendu:</strong> {{ number_format($commande->montant_rendu, 0, ',', ' ') }} FCFA</span>
                </div> --}}

                <div class="col-md-12 m-auto">
                    <span><strong>Nom du client:</strong> {{ $commande->client->first_name }} {{ $commande->client->last_name }}</span><br>
                    <span><strong>Contact du client:</strong> {{ $commande->client->phone }}</span><br>
                    <span><strong>mode de livraison:</strong> {{ $commande->mode_livraison }}</span><br>
                    <span><strong>Adresse de livraison:</strong> {{ $commande->adresse_livraison ?? 'Au restaurant' }}</span>

                </div>

                <p style="text-align: center;">-------------------------------</p>

                <div class="ticket-footer" style="text-align: center;">
                    <p>MERCI DE VOTRE VISITE</p>
                    <p>AU REVOIR ET A BIENTÔT</p>
                    <p>RESERVATIONS: 07-49-88-95-18</p>
                    <p>A BIENTÔT</p>
                </div>
            </div>


            <script>

                function imprimerFacture(){
                    var ticketContent = document.querySelector('.ticket-container').innerHTML;
                    var win = window.open('', '', 'height=700,width=700');
                    win.document.write('<html><head><title>Facture de commande</title></head><body>');
                    win.document.write(ticketContent);
                    win.document.write('</body></html>');
                    win.document.close();
                    win.print();
                }
                
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


    <script>
        function changerStatut(selectElement) {
            // Récupérer la valeur du statut sélectionné et l'ID de la commande
            var statut = $(selectElement).val();
            var commandeId = $(selectElement).data('commande');

            $.ajax({
                url: "{{ route('commande.statut') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    statut: statut,
                    commandeId: commandeId // Assurez-vous que ce paramètre est utilisé dans la route
                },
                success: function(response) {
                    if (response.success) {
                        // Mettre à jour l'interface utilisateur si nécessaire
                        Swal.fire({
                            title: 'Succès!',
                            text: 'Le statut a été mis à jour avec succès',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        location.reload(); // Recharger la page pour afficher les changements
                    } else {
                        alert('Une erreur est survenue lors de la mise à jour du statut');
                    }
                },
                error: function() {
                    alert('Une erreur est survenue lors de la communication avec le serveur');
                }
            });
        }
    </script>
@endsection
