@extends('backend.layouts.master')
@section('title')
    Détail des Achats
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
            Détail des Achats
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        Détail des Achats 
                        @if($dateDebut || $dateFin)
                            du 
                            @if($dateDebut)
                                {{ \Carbon\Carbon::parse($dateDebut)->format('d/m/Y') }}
                            @endif
                            @if($dateFin)
                                au {{ \Carbon\Carbon::parse($dateFin)->format('d/m/Y') }}
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
                                    <th>Produit</th>
                                    {{-- <th>Quantité achetée</th> --}}
                                    <th>Prix total</th>
                                    <th>Stock restant</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produitsGroupes as $key => $produit)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td class="fw-bold"> <a href="#">{{ $produit['nom'] }}</a> </td>
                                    {{-- <td>{{ $produit['quantite_achat'] }}</td> --}}
                                    <td>{{ $produit['prix_total_format'] }}</td>
                                    <td>{{ $produit['stock_restant'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            {{-- <tfoot>
                                <tr>
                                    <th colspan="5">Résumé</th>
                                </tr>
                                <tr>
                                    <td colspan="2">Nombre total de produits achetés :</td>
                                    <td colspan="3">{{ $produitsGroupes->count() }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Montant total des achats :</td>
                                    <td colspan="3">{{ number_format($produitsGroupes->sum('prix_total'), 0, ',', ' ') }} FCFA</td>
                                </tr>
                            </tfoot> --}}
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
