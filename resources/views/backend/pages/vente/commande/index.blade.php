
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
          Liste des commandes
        @endslot
        @slot('title')
        Gestion des commandes
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Liste des commandes @if(request()->has('filter')) - <b>{{ request('filter') }}</b> @endif</h5>

                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class=" ri ri-filter-2-fill"></i> Filtrer par statut
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="/admin/commande">Tous</a></li>
                            @foreach(['en attente' => 'En attente', 'confirmée' => 'Confirmée', 'livrée' => 'Livrée', 'annulée' => 'Annulée'] as $key => $value)
                                <li><a class="dropdown-item" href="/admin/commande?filter={{$key}}" >{{ $value }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
              

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>N° de commande</th>
                                    <th>Date</th>
                                    <th>Montant</th>
                                    <th>Client</th>
                                    <th>Statut</th>
                                   @if (Auth::user()->hasRole('caisse'))
                                   <th>Actions</th>
                                   @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($commandes as $key => $item)
                                    <tr id="row_{{ $item['id'] }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a class="fw-bold" href="{{route('commande.show', $item->id)}}">#{{ $item['code'] }}</a></td>
                                        <td>{{ $item['date_commande'] }}</td>
                                        <td>{{ number_format($item['montant_total'], 0, ',', ' ') }} FCFA</td>
                                        <td>{{ $item['client']['first_name'] }} {{ $item['client']['last_name'] }}</td>
                                        <td>
                                            @if($item['statut'] == 'en attente')
                                                <span class="badge bg-warning">En attente</span>
                                            @elseif($item['statut'] == 'confirmée')
                                                <span class="badge bg-success">Confirmée</span>
                                            @elseif($item['statut'] == 'livrée')
                                                <span class="badge bg-info">Livrée</span>
                                            @elseif($item['statut'] == 'annulée')
                                                <span class="badge bg-danger">Annulée</span>
                                            @endif
                                        </td>
                                       @if (Auth::user()->hasRole('caisse'))
                                       <td>
                                        <a href="{{route('commande.show', $item->id)}}" class="btn btn-sm btn-info">Détails</a>
                                        {{-- <a href="#" class="btn btn-sm btn-primary">Imprimer</a> --}}
                                    </td>
                                       @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Aucune commande trouvée</td>
                                    </tr>
                                @endforelse
                            </tbody>
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
