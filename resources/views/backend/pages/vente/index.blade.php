@extends('backend.layouts.master')
@section('title')
    Vente
@endsection
@section('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" />
    <style>
        .dashboard-caisse .card-title {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .dashboard-caisse .card {
            min-height: 120px;
        }

        @media (max-width: 991px) {
            .dashboard-caisse .row>div {
                margin-bottom: 15px;
            }
        }
    </style>
@endsection
@section('content')
    @component('backend.components.breadcrumb')
        @slot('li_1')
            Liste des ventes
        @endslot
        @slot('title')
            Gestion des ventes
        @endslot
    @endcomponent

    <div class="dashboard-caisse">
        <div class="row g-3 mb-3">
            @if (auth()->user()->hasRole(['caisse', 'supercaisse']))
                <div class="col-12 mb-2 d-flex align-items-center flex-wrap">
                    <h5 class="card-title mb-0 me-3">
                        Date de vente actuelle :
                        <span id="heureActuelle" class="fw-bold text-primary">
                            {{ $sessionDate ? \Carbon\Carbon::parse($sessionDate)->format('d-m-Y') : 'non définie' }}
                        </span>
                    </h5>
                    @if ($venteCaisseCloture == 0)
                        <button type="button" class="btn btn-info ms-3" data-bs-toggle="modal"
                            data-bs-target="#dateSessionVenteModal">
                            {{ $sessionDate ? 'Modifier la date de la session vente' : 'Choisir une date pour la session vente' }}
                        </button>
                    @endif
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="card-title">Caisse actuelle:   </h5>
                                  <p class="h4 text-primary mb-0">{{ auth()->user()->caisse->libelle ?? 'Non définie' }}</p>
                                </div>
                                <i class="ri-store-2-line ms-auto text-info" style="font-size:2rem"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">Total ventes du jour</h5>
                            <p class="h4 text-success mb-0">    
                                {{ number_format($data_vente->sum('montant_total'), 0, ',', ' ') }} FCFA
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4 d-flex flex-column justify-content-between">
                    <div class="mb-2">

                        @if ($venteCaisseCloture > 0)
                            <a href="#" class="btn btn-danger w-100 mb-2 fermerCaisse">
                                Fermer la caisse <i class="ri ri-logout-box-fill"></i>
                            </a>
                            <a href="{{ route('vente.rapport-caisse') }}" class="btn btn-success w-100 mb-2">
                                Rapport caisse <i class="ri-file-list-3-line"></i>
                            </a>
                        @endif
                        @if ($sessionDate != null)
                            <a href="{{ route('vente.create') }}" class="btn btn-primary w-100">
                                Nouvelle vente 🛒
                            </a>
                        @else
                            <button type="button" class="btn btn-info w-100 btnChoiceDate">
                                Nouvelle vente 🛒
                            </button>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        @if (!auth()->user()->hasRole(['caisse', 'supercaisse']))
            <form action="{{ route('vente.index') }}" method="GET" class="mb-3">
                <div class="row g-2">
                    <div class="col-md-2">
                        <label for="periode" class="form-label">Périodes</label>
                        <select class="form-select" id="periode" name="periode">
                            <option value="">Toutes les périodes</option>
                            @foreach (['jour' => 'Jour', 'semaine' => 'Semaine', 'mois' => 'Mois', 'annee' => 'Année'] as $key => $value)
                                <option value="{{ $key }}" {{ request('periode') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="date_debut" class="form-label">Date de début</label>
                        <input type="date" value="{{ request('date_debut') }}" class="form-control" id="date_debut"
                            name="date_debut">
                    </div>
                    <div class="col-md-3">
                        <label for="date_fin" class="form-label">Date de fin</label>
                        <input type="date" value="{{ request('date_fin') }}" class="form-control" id="date_fin"
                            name="date_fin">
                    </div>
                    <div class="col-md-2">
                        <label for="caisse" class="form-label">Caisse</label>
                        <select class="form-select" id="caisse" name="caisse">
                            <option value="">Toutes les caisses</option>
                            @foreach ($caisses as $caisse)
                                <option value="{{ $caisse->id }}"
                                    {{ request('caisse') == $caisse->id ? 'selected' : '' }}>
                                    {{ $caisse->libelle }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                    </div>
                </div>
            </form>
        @endif

        @include('backend.components.alertMessage')

        <div class="card">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                <h5 class="card-title mb-0 filter text-center">
                    Liste des ventes
                    @if (request('date_debut') || request('date_fin') || request('caisse') || request('periode'))
                        @if (request()->has('periode') && request('periode') != null)
                            - <strong>{{ request('periode') }}</strong>
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
                        @if (request()->has('caisse') && request('caisse') != null)
                            - <strong>{{ ucfirst(App\Models\Caisse::find(request('caisse'))->libelle) }}</strong>
                        @endif
                    @else
                        du mois en cours - {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                    @endif
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="buttons-datatables" class="table table-bordered table-hover align-middle" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>N° de vente</th>
                                <th>Session vente</th>
                                <th>Montant</th>
                                <th>Vendu le</th>
                                <th>Vendu par</th>
                                <th>Caisse</th>
                                @if (auth()->user()->can('modifier-vente') || auth()->user()->can('supprimer-vente'))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data_vente as $key => $item)
                                <tr id="row_{{ $item['id'] }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a class="fw-bold"
                                            href="{{ route('vente.show', $item->id) }}">#{{ $item['code'] }}</a>
                                    </td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($item['date_vente'])->format('d-m-Y') }}
                                        {{ $item['created_at']->format('à H:i') }}
                                    </td>
                                    <td>{{ number_format($item['montant_total'], 0, ',', ' ') }} FCFA</td>
                                    <td>{{ $item['created_at']->format('d-m-Y à H:i') }}</td>
                                    <td>{{ $item['user']['first_name'] }} {{ $item['user']['last_name'] }}</td>
                                    <td>{{ $item['caisse']['libelle'] ?? '' }}</td>
                                    @if (auth()->user()->can('modifier-vente') || auth()->user()->can('supprimer-vente'))
                                        <td>
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill align-middle"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a href="#" class="dropdown-item remove-item-btn delete"
                                                            data-id="{{ $item['id'] }}">
                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                            Supprimer
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Aucune vente trouvée</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('backend.pages.vente.dateSessionVente')
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
            $('.btnChoiceDate').click(function() {
                Swal.fire({
                    title: 'Veuillez choisir une date de session de vente avant d\'effectuer une vente',
                    icon: 'warning',
                })
            });

            if ($.fn.DataTable.isDataTable('#buttons-datatables')) {
                $('#buttons-datatables').DataTable().destroy();
            }

            $('#buttons-datatables').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'print'
                ],
                drawCallback: function(settings) {
                    var route = "vente"
                    delete_row(route);
                }
            });



            //fermer la caisse en executant une route avec un compteur
            $('.fermerCaisse').on('click', function() {
                Swal.fire({
                    title: 'Confirmer la fermeture de la caisse',
                    text: "Vous êtes sur le point de fermer la caisse. Cette action est irréversible.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, fermer la caisse',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Caisse clôturée avec succès',
                            text: 'Déconnexion automatique.',
                            icon: 'success',
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading()
                            },
                            willClose: () => {
                                window.location.href =
                                    '{{ route('vente.fermer-caisse') }}';
                            }
                        });
                    }
                });
            })
        });
    </script>
@endsection
