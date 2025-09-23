@extends('backend.layouts.master')
@section('title')
    Sortie
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
            Liste des sorties
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <span class="text-primary">Sortie #{{ $sortie->code }}</span>
                        <small class="text-muted ms-2">
                            du {{ \Carbon\Carbon::parse($sortie['date_sortie'])->format('d-m-Y à H:i') }}
                        </small>
                    </h5>
                    <a href="{{ route('sortie.create') }}" class="btn btn-primary">
                        <i class="ri-add-line"></i> Nouvelle sortie
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
                                    <th>Stock sorti</th>
                                    <th>Stock restant</th>
                                    <th>Stock alerte</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sortie->produits as $key => $item)
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
                                        <td>
                                            {{ $item['pivot']['stock_disponible'] }}

                                        </td>
                                        <td>
                                            <span class="text-danger fw-bold">{{ $item['pivot']['stock_sortie'] }}</span>

                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $item['stock'] }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning text-dark">{{ $item['stock_alerte'] }}</span>
                                            @if (!empty($item['uniteSortie']['libelle']))
                                                <span class="text-muted">{{ $item['uniteSortie']['libelle'] }}</span>
                                            @endif
                                        </td>
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
   
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

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
    </script>
@endsection
