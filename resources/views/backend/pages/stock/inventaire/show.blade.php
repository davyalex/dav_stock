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
            Détails de l'inventaire
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Produits de l'inventaire
                        <strong>#{{ $inventaire->code }} du {{ $inventaire->created_at->format('d-m-Y à H:i') }} </strong>
                    </h5>
                    <a href="{{ route('inventaire.create') }}" type="button" class="btn btn-primary">Nouvel inventaire</a>
                </div>
                <div class="card-body divPrint">
                    <div class="table-responsive">
                        <table id="example" class="display table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Nom</th>
                                    <th>Stock théorique</th>
                                    <th>Stock physique</th>
                                    <th>Écart</th>
                                    <th>Etat du stock</th>
                                    <th>Observation</th>
                                    <th>Stock alerte</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inventaire->produits as $key => $item)
                                    <tr id="row_{{ $item['id'] }}">
                                        <td>{{ ++$key }}</td>
                                        <td>
                                            <img class="rounded avatar-sm"
                                                src="{{ $item->hasMedia('ProduitImage') ? $item->getFirstMediaUrl('ProduitImage') : asset('assets/img/logo/logo_Chez-jeanne.jpg') }}"
                                                width="50px" alt="">
                                        </td>
                                        <td>{{ $item['nom'] }} {{ $item['valeur_unite'] ?? '' }}
                                            {{ $item['unite']['libelle'] ?? '' }} </td>
                                        <td>{{ $item['pivot']['stock_theorique'] }}
                                            {{ $item['uniteSortie']['libelle'] ?? '' }}</td>
                                        <td>{{ $item['pivot']['stock_physique'] }}
                                            {{ $item['uniteSortie']['libelle'] ?? '' }}</td>
                                        <td>{{ $item['pivot']['ecart'] }}</td>
                                        <td>{{ $item['pivot']['etat'] }}</td>
                                        <td>{{ $item['pivot']['observation'] }}</td>
                                        <td>{{ $item['stock_alerte'] }} {{ $item['uniteSortie']['libelle'] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <button id="btnImprimer" class="w-100"><i class="ri ri-printer-fill"></i></button>

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


    <script>
        // $(document).ready(function() {
        //     // Fonction pour imprimer le rapport
        //     function imprimerRapport() {
        //         // $('.divPrint table').removeAttr('id');
        //         // Créer une nouvelle fenêtre pour l'impression
        //         var fenetreImpression = window.open('', '_blank');

        //         // Contenu à imprimer
        //         var contenuImprimer = `
    //             <html>
    //                 <head>
    //                     <title style="text-align: center;">Compte exploitation</title>
    //                     <style>
    //                         body { font-family: Arial, sans-serif; }
    //                         table { width: 100%; border-collapse: collapse; }
    //                         th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    //                         th { background-color: #f2f2f2; }
    //                     </style>
    //                 </head>
    //                 <body>
    //                     <h2 style="text-align: center;">Fiche Inventaire  </h2>
    //                     <p style="text-align: center;">Code : {{ $inventaire->code }}</p>
    //                     <p style="text-align: center;">Réalisé le : {{ $inventaire->created_at->format('d-m-Y à H:i') }}</p>
    //                     ${$('.divPrint').html()}
    //                     <footer style="position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 12px; margin-top: 20px;">
    //                         <p>Imprimé le : ${new Date().toLocaleString()} par {{ Auth::user()->first_name }}</p>
    //                     </footer>
    //                 </body>
    //             </html>
    //         `;

        //         // Écrire le contenu dans la nouvelle fenêtre
        //         fenetreImpression.document.write(contenuImprimer);

        //         // Fermer le document
        //         fenetreImpression.document.close();

        //         // Imprimer la fenêtre
        //         fenetreImpression.print();
        //     }

        //     // Ajouter un bouton d'impression
        //     $('#btnImprimer')
        //         .text('Imprimer le Rapport')
        //         .addClass('btn btn-primary mt-3')
        //         .on('click', imprimerRapport);
        //     // .appendTo('.divPrint');
        //     // Supprimer l'ID de la table avant l'impression

        // });

        $(document).ready(function() {
            // Fonction pour imprimer le rapport
            function imprimerRapport() {
                // Sauvegarder l'ID de la table
                var table = $('#example');
                var originalId = table.attr('id');

                // Désactiver DataTable temporairement (pagination, recherche, etc.)
                if ($.fn.DataTable.isDataTable('#example')) {
                    // Détruire DataTables pour enlever la pagination, la barre de recherche, etc.
                    table.DataTable().destroy();
                }

                // Supprimer l'ID avant l'impression pour éviter des conflits
                table.removeAttr('id');

                // Créer une nouvelle fenêtre pour l'impression
                var fenetreImpression = window.open('', '_blank');

                // Contenu à imprimer
                var contenuImprimer = `
            <html>
                <head>
                    <title style="text-align: center;">Compte exploitation</title>
                    <style>
                        body { font-family: Arial, sans-serif; }
                        table { width: 100%; border-collapse: collapse; }
                        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                        th { background-color: #f2f2f2; }
                    </style>
                </head>
                <body>
                    <h2 style="text-align: center;">Fiche Inventaire  </h2>
                    <p style="text-align: center;">Code : {{ $inventaire->code }}</p>
                    <p style="text-align: center;">Réalisé le : {{ $inventaire->created_at->format('d-m-Y à H:i') }}</p>
                    ${$('.divPrint').html()}
                    <footer style="position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 12px; margin-top: 20px;">
                        <p>Imprimé le : ${new Date().toLocaleString()} par {{ Auth::user()->first_name }}</p>
                    </footer>
                </body>
            </html>
        `;

                // Écrire le contenu dans la nouvelle fenêtre
                fenetreImpression.document.write(contenuImprimer);

                // Fermer le document
                fenetreImpression.document.close();

                // Imprimer la fenêtre
                fenetreImpression.print();

                // Restaurer l'ID de la table après l'impression
                table.attr('id', originalId);

                // Réinitialiser DataTable après l'impression
                table.DataTable({
                    paging: true,
                    searching: true,
                    // Réinitialiser ici les options de DataTables si nécessaires
                });
            }

            // Ajouter un bouton d'impression
            $('#btnImprimer')
                .text('Imprimer le Rapport')
                .addClass('btn btn-primary mt-3')
                .on('click', imprimerRapport);
        });
    </script>
@endsection
