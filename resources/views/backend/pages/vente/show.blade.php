@extends('backend.layouts.master')
@section('title')
    @lang('translation.datatables')
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
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Produits de la vente
                        <strong>#{{ $vente->code }} du {{ $vente->created_at }} </strong>
                    </h5>
                    <button id="btnImprimerTicket" class="btn btn-secondary me-2">Imprimer le ticket</button>
                    <a href="{{ route('vente.create') }}" type="button" class="btn btn-primary">Nouvelle vente</a>
                </div>
                <div class="ticket-container" style="font-family: 'Courier New', monospace; font-size: 12px; width: 350px;">
                    <div class="ticket-header" style="text-align: center;">
                        <h3>CHEZ JEANNE</h3>
                        <h4>RESTAURANT LOUNGE</h4>
                        <h5>AFRICAIN ET EUROPEEN</h5>
                        <p>-------------------------------</p>
                        <div style="display: flex; justify-content: space-between; padding: 0 10px;">
                            <span><strong>Vente:</strong> #{{ $vente->code }}</span>
                            <span><strong>Date:</strong> {{ $vente->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                    <div class="ticket-info" style="padding: 0 10px;">
                        <div style="display: flex; justify-content: space-between;">
                            <span><strong>Caisse:</strong> {{ $vente->caisse->libelle ?? 'Non définie' }}</span>
                            <span><strong>Caissier:</strong> {{ $vente->user->first_name }} {{ $vente->user->last_name }}</span>
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
                                @foreach ($vente->produits as $produit)
                                    <tr>
                                        <td>{{ $produit->nom }}</td>
                                        <td>{{ $produit->pivot->quantite }}</td>
                                        <td>{{ number_format($produit->pivot->prix_unitaire, 0, ',', ' ') }}</td>
                                        <td>{{ number_format($produit->pivot->quantite * $produit->pivot->prix_unitaire, 0, ',', ' ') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <p style="text-align: center;">-------------------------------</p>
                    <div class="ticket-total" style="text-align: right;">
                        <p><strong>Total:</strong> {{ number_format($vente->montant_total, 0, ',', ' ') }} FCFA</p>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>

    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
