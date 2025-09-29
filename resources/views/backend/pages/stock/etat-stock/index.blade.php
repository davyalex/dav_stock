@extends('backend.layouts.master')
@section('title')
    État des stocks
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
            État des stocks
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-body ">
                    <div class="table-responsive">
                        <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    {{-- <th>Image</th> --}}
                                    <th>Nom</th>
                                    {{-- <th>Catégorie</th> --}}
                                    <th>Stock actuel</th>
                                    <th>Stock alerte</th>
                                    <th>État du stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produits as $key => $produit)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        {{-- <td>

                                            <img class="rounded avatar-sm"
                                                src="{{ $produit->hasMedia('ProduitImage') ? $produit->getFirstMediaUrl('ProduitImage') : asset('assets/img/logo/logo.jpg') }}"
                                                width="50px" alt="{{ $produit['nom'] }}">
                                        </td> --}}
                                        <td>{{ $produit->nom }}

                                        </td>
                                        {{-- <td>{{ $produit->categorie->name }}</td> --}}
                                        <td>
                                            {{ $produit->stock }}

                                        </td>

                                        <td>
                                            {{ $produit->stock_alerte }}
                                        </td>

                                        <td>
                                            @if ($produit->stock <= $produit->stock_alerte)
                                                <span class="badge bg-danger">Alerte</span>
                                            @else
                                                <span class="badge bg-success">Normal</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- <button id="btnImprimer" class="w-100 btn btn-primary mt-3"><i class="ri ri-printer-fill"></i> Imprimer le
                    Rapport</button> --}}
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
    <script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>


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
