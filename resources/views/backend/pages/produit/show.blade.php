@extends('backend.layouts.master')
@section('title')
    Produit
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
            Detail produit
        @endslot
        @slot('title')
            Produit
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-body border border-primary border-dashed">
                            <div class="mb-4 d-flex justify-content-around">

                                <p>Sku : <span class="fw-bold" id="sku">{{ $data_produit['code'] }} </span></p>
                                <p>Nom : <span class="fw-bold" id="sku">{{ $data_produit['nom'] }}

                                    </span></p>
                                <p>Stock actuel : <span class="fw-bold" id="stock">{{ $data_produit['stock'] }}</span>
                                </p>
                                <p>Stock alerte : <span class="fw-bold text-danger"
                                        id="stockAlerte">{{ $data_produit['stock_alerte'] }}</span>
                                </p>
                                <p>Categorie : <span class="fw-bold"
                                        id="categorie">{{ $data_produit['categorie']['name'] }}</span>
                                </p>
                                <p>Prix : <span class="fw-bold" id="prix">{{ $data_produit['prix'] ?? 0 }}</span>
                                </p>


                            </div>
                        </div>


                       
                    </div>
                    <!-- end card -->



                </div>


                <div class="text-center col-lg-2">
                    <div class="text-center">
                        <div class="position-relative d-inline-block">
                            <div class="avatar-lg">
                                <div class="avatar-title bg-light rounded" id="product-img">
                                    <img src="{{ asset($data_produit->getFirstMediaUrl('ProduitImage')) }}" id="product-img"
                                        class="avatar-md h-auto" />
                                </div>
                            </div>
                        </div>
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
            $('.delete').on("click", function(e) {
                e.preventDefault();
                var Id = $(this).attr('data-id');
                Swal.fire({
                    title: 'Etes-vous sûr(e) de vouloir supprimer ?',
                    text: "Cette action est irréversible!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Supprimer!',
                    cancelButtonText: 'Annuler',
                    customClass: {
                        confirmButton: 'btn btn-primary w-xs me-2 mt-2',
                        cancelButton: 'btn btn-danger w-xs mt-2',
                    },
                    buttonsStyling: false,
                    showCloseButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: "/achat/delete/" + Id,
                            dataType: "json",

                            success: function(response) {
                                if (response.status == 200) {
                                    Swal.fire({
                                        title: 'Supprimé!',
                                        text: 'Votre fichier a été supprimé.',
                                        icon: 'success',
                                        customClass: {
                                            confirmButton: 'btn btn-primary w-xs mt-2',
                                        },
                                        buttonsStyling: false
                                    })

                                    $('#row_' + Id).remove();
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
