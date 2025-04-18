@extends('backend.layouts.master')
@section('title')
    {{-- @lang('translation.datatables') --}}
    Dépenses
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
            Dépenses
        @endslot
        @slot('title')
            Liste des dépenses
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('depense.index') }}" method="GET">
                @csrf
                <div class="row mx-3">
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="statut" class="form-label">Categorie</label>
                            <select class="form-select" id="categorie" name="categorie">
                                <option value="">Toutes les depenses</option>
                                @foreach (App\Models\CategorieDepense::get() as $key => $value)
                                    <option value="{{ $value->id }}"
                                        {{ request('categorie') == $value->id ? 'selected' : '' }}>
                                        {{ $value->libelle }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="date_debut" class="form-label">Date de début</label>
                            <input type="date" class="form-control" id="date_debut" name="date_debut"
                                value="{{ request('date_debut') }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="date_fin" class="form-label">Date de fin</label>
                            <input type="date" class="form-control" id="date_fin" name="date_fin"
                                value="{{ request('date_fin') }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="statut" class="form-label">Periodes</label>
                            <select class="form-select" id="periode" name="periode">
                                <option value="">Toutes les periodes</option>
                                @foreach (['jour' => 'Jour', 'semaine' => 'Semaine', 'mois' => 'Mois', 'annee' => 'Année'] as $key => $value)
                                    <option value="{{ $key }}" {{ request('periode') == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 mt-4">
                        <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                    </div>

                </div>

            </form>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 id="filter" class="card-title mb-0" style="text-align: center">Liste des dépenses

                        @if (request()->has('categorie') && request('categorie') != null)
                            -
                            <strong>{{ ucfirst(App\Models\CategorieDepense::find(request('categorie'))->libelle) }}</strong>
                        @endif

                        @if (request()->has('periode') && request('periode') != null)
                            -
                            <strong>{{ request('periode') }}</strong>
                        @endif

                        @if (request('date_debut') || request('date_fin'))
                            du
                            @if (request('date_debut'))
                                {{ \Carbon\Carbon::parse(request('date_debut'))->format('d/m/Y') }}
                            @endif
                            @if (request('date_fin'))
                                au {{ \Carbon\Carbon::parse(request('date_fin'))->format('d/m/Y') }}
                            @endif
                        @endif
                    </h5>
                    <a href="{{ route('depense.create') }}" class="btn btn-primary">
                        Créer une dépense
                    </a>
                </div>
                <div class="card-body divPrint">

                    <div class="table-responsive">
                        <table id="buttons-datatables" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Catégorie</th>
                                    <th>Libellé</th>
                                    <th>Montant</th>
                                    <th>Créé par</th>
                                    <th>Date dépense</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total des dépenses :</th>
                                    <th id="totalMontant"></th>
                                    <th colspan="3"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Script DataTables avec Yajra -->
                    <!-- Script DataTables avec Yajra -->
                    <script>
                        $(document).ready(function() {
                            var table = $('#buttons-datatables').DataTable({
                                processing: true,
                                serverSide: true,
                                ajax: {
                                    url: "{{ route('depense.index') }}",
                                    type: 'GET',
                                    data: function(d) {
                                        d.date_debut = $('#date_debut').val();
                                        d.date_fin = $('#date_fin').val();
                                        d.categorie = $('#categorie').val();
                                        d.periode = $('#periode').val();
                                    },
                                    dataSrc: function(json) {
                                        $('#totalMontant').text(
                                            new Intl.NumberFormat('fr-FR').format(json.total_montant)
                                        );
                                        return json.data;
                                    }
                                },
                                columns: [{
                                        data: 'id',
                                        name: 'id'
                                    },
                                    {
                                        data: 'categorie',
                                        name: 'categorie'
                                    },
                                    {
                                        data: 'libelle',
                                        name: 'libelle',

                                    },
                                    {
                                        data: 'montant',
                                        name: 'montant'
                                    },
                                    {
                                        data: 'user',
                                        name: 'user'
                                    },
                                    {
                                        data: 'date_depense',
                                        name: 'date_depense'
                                    },
                                    {
                                        data: 'actions',
                                        name: 'actions',
                                        orderable: false,
                                        searchable: false
                                    }
                                ],
                                dom: 'Bfrtip', // La position des éléments (b = boutons, f = filtre, t = table, i = info, p = pagination)
                                buttons: [{
                                        extend: 'print', // Bouton pour imprimer
                                        text: 'Imprimer', // Texte du bouton
                                        exportOptions: {
                                            columns: [0, 1, 2, 3, 4, 5] // Colonnes à inclure dans l'impression
                                        },
                                        messageTop: function() {
                                            return 'Liste des Dépenses'; // Message au dessus du tableau lors de l'impression
                                        },
                                        title: 'Dépenses', // Titre de la page d'impression
                                        customize: function(win) {
                                            $(win.document.body).css('text-align', 'center');
                                            $(win.document.body).find('h1').css('text-align', 'center');
                                        }
                                    },
                                    {
                                        extend: 'excel', // Bouton pour exporter en Excel
                                        text: 'Exporter en Excel',
                                        exportOptions: {
                                            columns: [0, 1, 2, 3, 4, 5]
                                        }
                                    },
                                    {
                                        extend: 'csv', // Bouton pour exporter en CSV
                                        text: 'Exporter en CSV',
                                        exportOptions: {
                                            columns: [0, 1, 2, 3, 4, 5]
                                        }
                                    },
                                    {
                                        extend: 'copy', // Bouton pour copier les données
                                        text: 'Copier',
                                        exportOptions: {
                                            columns: [0, 1, 2, 3, 4, 5]
                                        }
                                    }
                                ],
                                drawCallback: function(settings) {
                                    // Calcul du total des montants
                                    var totalMontant = settings.json.data.reduce(function(total, row) {
                                        return total + parseFloat(row.montant.replace(',', ''));
                                    }, 0);
                                    $('#total-montant').text(totalMontant.toLocaleString());
                                }
                            });
                        });
                    </script>
                </div>
            </div>
            {{-- <button id="btnImprimer" class="w-100"><i class="ri ri-printer-fill"></i></button> --}}

        </div>
    </div>

    {{-- @include('backend.pages.depense.create') --}}
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
            if ($.fn.DataTable.isDataTable('#buttons-datatables')) {
                $('#buttons-datatables').DataTable().clear().destroy();
            }

            let table = $('#buttons-datatables').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('depense.index') }}",
                    data: function(d) {
                        d.date_debut = $('#date_debut').val();
                        d.date_fin = $('#date_fin').val();
                        d.categorie = $('#categorie').val();
                        d.periode = $('#periode').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'categorie',
                        name: 'categorie'
                    },
                    {
                        data: 'libelle',
                        name: 'libelle'
                    },
                    {
                        data: 'montant',
                        name: 'montant'
                    },
                    {
                        data: 'user',
                        name: 'user'
                    },
                    {
                        data: 'date_depense',
                        name: 'date_depense'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'print',
                        text: 'Imprimer',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        },
                        messageTop: function() {
                            return $('#filter').text().trim();
                        },
                        title: '',
                        customize: function(win) {
                            $(win.document.body)
                                .css('text-align', 'center');

                            $(win.document.body).find('h1')
                                .css('text-align', 'center');
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Exporter Excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    }
                ],
                drawCallback: function() {
                    var route = "depense";
                    delete_row(route); // ta fonction pour la suppression
                }
            });

            // Si tu utilises des filtres
            $('#filtrer').on('click', function() {
                table.draw();
            });
        });
    </script>
    </script>
@endsection
