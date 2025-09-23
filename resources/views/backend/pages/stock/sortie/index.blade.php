@extends('backend.layouts.master')
@section('title')
  Sortie
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
          Liste des sorties
        @endslot
        @slot('title')
        Gestion de stock
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            @include('backend.components.alertMessage')
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Liste des sorties</h5>
                    <a href="{{ route('sortie.create') }}" type="button" class="btn btn-primary ">Enregistrer
                        une sortie de stock</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>N°de sortie</th>
                                    <th>Date</th>
                                    <th>Crée par</th>
                                    <th class="d-none">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_sortie as $key => $item)
                                    <tr id="row_{{ $item['id'] }}">
                                        <td> {{ ++$key }} </td>
                                        <td> <a class="fw-bold" href="{{route('sortie.show' , $item->id)}}">#{{ $item['code'] }}</a> </td>
                                        <td> {{ \Carbon\Carbon::parse($item['date_sortie'])->format('d-m-Y à H:i') }} </td>
                                        <td> {{ $item['user']['first_name'] }} </td>  
                                        
                                        <td class="">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="{{ route('sortie.show', $item['id']) }}"
                                                    class="btn btn-outline-info btn-sm" title="Voir">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                {{-- <a href="{{ route('sortie.edit', $item['id']) }}"
                                                    class="btn btn-outline-success btn-sm" title="Modifier">
                                                    <i class="ri-edit-2-line"></i>
                                                </a> --}}
                                                <button class="btn btn-outline-danger btn-sm delete"
                                                    data-id="{{ $item['id'] }}" title="Supprimer">
                                                    <i class="ri-delete-bin-2-line"></i>
                                                </button>
                                            </div>
                                    </tr>
                                @endforeach
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

    <script>
        $(document).ready(function() {
            var route = "sortie";
            delete_row(route);
        })
    </script>
@endsection
