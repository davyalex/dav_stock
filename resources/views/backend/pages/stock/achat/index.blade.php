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
           Gestion de stock
        @endslot
        @slot('title')
            Liste des achats
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Liste des achats de la facture <strong>#{{$facture->numero_facture}}</strong>  <span class="px-5">Montant : <strong>{{$facture->montant}} FCFA</strong></span> </h5>
                    <a href="{{ route('achat.create') }}" type="button" class="btn btn-primary ">Faire
                        un achat</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Statut</th>
                                    <th>Produit</th>
                                    <th>code</th>
                                    <th>Magasin</th>
                                    <th>N°Facture</th>
                                    <th>fournisseur</th>
                                    <th>Format</th>
                                    <th>Qté format</th>
                                    <th>Qté dans format</th>
                                    <th>PU format</th>
                                    <th>Total depensé</th>
                                    <th>Qté stockée</th>
                                    <th>PU achat</th>
                                    <th>PU vente</th>
                                    <th>Unite de vente</th>
                                    <th>Crée par</th>
                                    <th>Date achat</th>
                                    <th class="d-none">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_achat as $key => $item)
                                    <tr id="row_{{ $item['id'] }}">
                                        <td> {{ ++$key }} </td>
                                        <td>{{ $item['statut'] }}</td>

                                        <td>
                                            <img class="rounded-circle"
                                                src="{{ $item->produit->getFirstMediaUrl('ProduitImage') }}" width="50px"
                                                alt="">

                                            {{ $item['produit']['nom'] }}
                                        </td>
                                        <td>{{ $item['code'] }}</td>
                                        <td>{{ $item['magasin']['libelle'] ?? 'N/A' }}</td>
                                        <td>{{ $item['numero_facture'] ?? 'N/A' }}</td>
                                        <td>{{ $item['fournisseur']['nom'] ?? 'N/A' }}</td>
                                        <td>{{ $item['format']['libelle'] ?? 'N/A' }}</td>
                                        <td> {{ $item['quantite_format'] }} </td>
                                        <td> {{ $item['quantite_in_format'] }} </td>
                                        <td> {{ $item['prix_unitaire_format'] }} </td>
                                        <td> {{ $item['prix_total_format'] }} </td>
                                        <td> {{ $item['quantite_stocke'] }} </td>
                                        <td> {{ $item['prix_achat_unitaire'] }} </td>
                                        <td> {{ $item['prix_vente_unitaire'] }} </td>
                                        <td> {{ $item['unite']['libelle'] ?? 'N/A' }} </td>
                                        <td> {{ $item['user']['first_name'] }} </td>
                                        <td> {{ $item['date_achat'] }} </td>
                                        <td class="d-none">
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill align-middle"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a href="{{ route('ajustement.create', $item['id']) }}"
                                                            class="dropdown-item"><i
                                                                class=" ri-exchange-fill align-bottom me-2 text-muted"></i>
                                                            Ajustement</a>
                                                    </li>
                                                    <li><a href="#!" class="dropdown-item"><i
                                                                class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                            View</a>
                                                    </li>
                                                    <li><a href="{{ route('achat.edit', $item['id']) }}" type="button"
                                                            class="dropdown-item edit-item-btn"><i
                                                                class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                            Edit</a></li>
                                                    <li>
                                                        <a href="#" class="dropdown-item remove-item-btn delete"
                                                            data-id={{ $item['id'] }}>
                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- @include('backend.pages.produit.edit') --}}
                                @endforeach

                                <tfoot>
                                    <tr>
                                        <th colspan="11" style="text-align:right">Montant de la facture :</th>
                                        
                                        <th colspan="6"><strong>{{$facture->montant}} FCFA</strong></th> <!-- Les autres colonnes n'ont pas de total -->
                                    </tr>
                                </tfoot>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->

    {{-- @include('backend.pages.produit.create') --}}
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
        $(document).ready(function() {
            var route = "depense"
            delete_row(route);
        })
    </script>
@endsection
