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
            Liste
        @endslot
        @slot('title')
            Paie
        @endslot
    @endcomponent



    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0 filter">Liste des paies</h5>
                    <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#myModal">Créer
                        une nouveau employés</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>code</th>
                                    <th>Employe</th>
                                    <th>Montant</th>
                                    <th>Mois</th>
                                    <th>Année</th>
                                    <th>Type de paie</th>
                                    <th>Statut</th>
                                    <th>Date creation</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $moisNoms = [
                                        1 => 'Janvier',
                                        2 => 'Février',
                                        3 => 'Mars',
                                        4 => 'Avril',
                                        5 => 'Mai',
                                        6 => 'Juin',
                                        7 => 'Juillet',
                                        8 => 'Août',
                                        9 => 'Septembre',
                                        10 => 'Octobre',
                                        11 => 'Novembre',
                                        12 => 'Décembre',
                                    ];
                                @endphp
                                @foreach ($data_paie as $key => $item)
                                    <tr id="row_{{ $item['id'] }}">
                                        <td> {{ ++$key }} </td>
                                        <td>{{ $item['code'] }}</td>
                                        <td>{{ $item['employe']['nom'] }} {{ $item['employe']['prenom'] }}</td>
                                        <td>{{ $item['montant'] }}</td>
                                        <td>{{ $moisNoms[$item['mois']] ?? 'Inconnu' }}</td>
                                        <td>{{ $item['annee'] }}</td>
                                        <td>{{ $item['typePaie']['libelle'] }}</td>
                                        <td>{{ $item['statut'] }}</td>
                                        <td> {{ $item['created_at'] }} </td>
                                        <td>
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill align-middle"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">

                                                    <li><a type="button" class="dropdown-item edit-item-btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#myModalEdit{{ $item['id'] }}"><i
                                                                class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                            Modifier</a></li>
                                                    <li>
                                                        <a href="#" class="dropdown-item remove-item-btn delete"
                                                            data-id={{ $item['id'] }}>
                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                            Supprimer
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @include('backend.pages.rh.paie.edit')
                                @endforeach


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->

    @include('backend.pages.rh.paie.create')
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
            // Afficher la liste des depenses depuis la depense.getList
            // Détruire DataTable s’il existe déjà
            if ($.fn.DataTable.isDataTable('#buttons-datatables')) {
                $('#buttons-datatables').DataTable().destroy();
            }


            // Réinitialiser DataTable
            $('#buttons-datatables').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'print'
                ],
                buttons: [{
                        extend: 'print',
                        text: 'Imprimer',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5,6,7,8]
                        },
                        messageTop: function() {
                            return $('.filter').text().trim();
                        },
                        title: '',
                        customize: function(win) {
                            $(win.document.body).css('text-align', 'center');
                            $(win.document.body).find('h1').css('text-align',
                                'center');
                        }
                    },
                    // {
                    //     extend: 'pdf',
                    //     text: 'Pdf',
                    //     className: 'btn btn-danger',
                    //     exportOptions: {
                    //         columns: [0, 1, 2, 3, 4, 5,6,7,8]
                    //     },
                    //     messageTop: function() {
                    //         return $('.filter').text().trim();
                    //     },
                    //     title: '',
                    //     // customize: function(win) {
                    //     //     $(win.document.body).css('text-align', 'center');
                    //     //     $(win.document.body).find('h1').css('text-align',
                    //     //         'center');
                    //     // }
                    // },

                    {
                        extend: 'csv',
                        text: 'Csv',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5,6,7,8]
                        },
                        messageTop: function() {
                            return $('.filter').text().trim();
                        },
                        title: '',
                        // customize: function(win) {
                        //     $(win.document.body).css('text-align', 'center');
                        //     $(win.document.body).find('h1').css('text-align',
                        //         'center');
                        // }
                    },

                    {
                        extend: 'copy',
                        text: 'Copy',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5,6,7,8]
                        },
                        messageTop: function() {
                            return $('.filter').text().trim();
                        },
                        title: '',
                        // customize: function(win) {
                        //     $(win.document.body).css('text-align', 'center');
                        //     $(win.document.body).find('h1').css('text-align',
                        //         'center');
                        // }
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5,6,7,8]
                        },
                        messageTop: function() {
                            return $('.filter').text().trim();
                        },
                        title: '',
                        // customize: function(win) {
                        //     $(win.document.body).css('text-align', 'center');
                        //     $(win.document.body).find('h1').css('text-align',
                        //         'center');
                        // }
                    }





                ],
                drawCallback: function(settings) {
                    let route = "paie";
                    if (typeof delete_row === "function") {
                        delete_row(route);
                    }
                }
            });
            // },
            // error: function(xhr, status, error) {
            // console.error("Erreur AJAX :", error);
            // }
            // });

        });
    </script>
@endsection
