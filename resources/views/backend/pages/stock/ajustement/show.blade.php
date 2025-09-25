@extends('backend.layouts.master')
@section('title')
    Ajustement de stock
@endsection
@section('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" />
@endsection
@section('content')
    @component('backend.components.breadcrumb')
        @slot('li_1')
            Gestion de stock
        @endslot
        @slot('title')
            Détail de l'ajustement
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <span class="text-primary">Ajustement #{{ $ajustement->code }}</span>
                        <small class="text-muted ms-2">
                            du {{ \Carbon\Carbon::parse($ajustement['date_ajustement'])->format('d-m-Y à H:i') }}
                        </small>
                    </h5>
                    <a href="{{ route('ajustement.create') }}" class="btn btn-primary">
                        <i class="ri-add-line"></i> Nouvel ajustement
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="buttons-datatables" class="table table-bordered table-hover align-middle"
                            style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Nom</th>
                                    <th>Stock disponible</th>
                                    <th>Type ajustement</th>
                                    <th>Quantité ajustée</th>
                                    <th>Stock après ajustement</th>
                                    <th>Stock alerte</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ajustement->produits as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <img class="rounded avatar-sm"
                                                src="{{ $item->hasMedia('ProduitImage') ? $item->getFirstMediaUrl('ProduitImage') : asset('assets/img/logo/logo.jpg') }}"
                                                width="50" alt="Image produit">
                                        </td>
                                        <td>
                                            <span class="fw-semibold">{{ $item->nom }}</span>
                                        </td>
                                        <td>{{ $item->pivot->stock_disponible }}</td>
                                        <td>
                                            @if($item->pivot->type_ajustement == 'ajouter')
                                                <span class="badge bg-success">Ajout</span>
                                            @elseif($item->pivot->type_ajustement == 'reduire')
                                                <span class="badge bg-danger">Réduction</span>
                                            @else
                                                <span class="badge bg-secondary">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->pivot->type_ajustement == 'ajouter')
                                                +{{ $item->pivot->stock_ajuste }}
                                            @elseif($item->pivot->type_ajustement == 'reduire')
                                                -{{ $item->pivot->stock_ajuste }}
                                            @else
                                                0
                                            @endif
                                        </td>
                                        <td>{{ $item->stock }}</td>
                                        <td>{{ $item->stock_alerte }}</td>
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
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#buttons-datatables').DataTable();
        });
    </script>
@endsection
