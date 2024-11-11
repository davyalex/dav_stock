@extends('backend.layouts.master')

@section('content')
    @component('backend.components.breadcrumb')
        <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet">

        @slot('li_1')
            Vente
        @endslot
        @slot('title')
            Billeterie
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form id="formSend" autocomplete="off" class="needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="container my-4 divVariante">
                                        <div class="col-12 d-flex justify-content-center">
                                            <p>-------------------------------</p>
                                            <span class="fw-bold">Gestion de la billetterie</span>
                                            <p>-------------------------------</p>
                                        </div>
                                        <div class="alert alert-primary">
                                            <strong>Important !</strong> Veuillez Effectuer la billeterie pour verifier si
                                            montant en caisse physique correspont avotre montant de vente qui est
                                            <strong>{{ number_format($totalVente, 0, ',', ' ') }} FCFA</strong>.
                                        </div>
                                        <div id="variantes-container">
                                            <div class="row variante-row mb-4">
                                                <div class="col-2">
                                                    <label for="quantite" class="form-label">Quantité</label>
                                                    <select class="form-select quantite-select"
                                                        name="variantes[0][quantite]" required>
                                                        <option selected disabled value="">Sélectionner</option>
                                                        @for ($i = 1; $i <= 500; $i++)
                                                            <option value="{{ $i }}">{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-3">
                                                    <label for="type_monnaie" class="form-label">Type de monnaie</label>
                                                    <select class="form-select type-monnaie-select"
                                                        name="variantes[0][type_monnaie]" required>
                                                        <option selected disabled value="">Sélectionner</option>
                                                        @foreach ($type_monnaies as $key => $type_monnaie)
                                                            <option value="{{ $type_monnaie }}">{{ $type_monnaie }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-3">
                                                    <label for="valeur" class="form-label">Valeur</label>
                                                    <select class="form-select valeur-select" name="variantes[0][valeur]"
                                                        required>
                                                        <option selected disabled value="">Sélectionner</option>
                                                    </select>
                                                </div>
                                                <div class="col-3">
                                                    <label for="total" class="form-label">Total</label>
                                                    <input type="text" class="form-control total-input"
                                                        name="variantes[0][total]" readonly>
                                                </div>
                                            </div>


                                        </div>
                                        <button type="button" class="btn btn-primary mb-3"
                                            id="add-monnaie">Ajouter</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="grand-total" class="form-label fw-bold">Total Général :</label>
                            <input type="text" id="grand-total" class="form-control w-25" readonly>
                        </div>
                        {{-- <div class="text-end mt-3">
                            <h4>Total Billeterie : <span id="grand-total">0</span> FCFA</h4>
                        </div> --}}
                        <div class="text-end mb-3">
                            <a href={{ route('vente.cloture-caisse') }} class="btn btn-success w-lg btnCloturer">Cloturer la
                                caisse</a>
                        </div>
                    </form>

                </div>
                <!-- end row -->
                <!-- end card -->

            </div>
        </div><!-- end row -->
    </div><!-- end col -->


    <!--end row-->

@section('script')
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
    <script src="{{ URL::asset('build/js/pages/modal.init.js') }}"></script>
    {{-- <script src="{{ URL::asset('build/js/pages/form-editor.init.js') }}"></script> --}}
    <script src="{{ URL::asset('build/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/ecommerce-product-create.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const typeMonnaieData = @json($type_monnaies);
            const billetData = @json($billets);
            const pieceData = @json($pieces);
            var totalVente = @json($totalVente);

            let varianteIndex = 1;


            // Fonction pour calculer le total et mettre à jour le total general
            function updateGrandTotal() {
                let grandTotal = 0;
                document.querySelectorAll('.total-input').forEach(input => {
                    grandTotal += parseFloat(input.value) || 0;
                });
                document.getElementById('grand-total').value = grandTotal.toFixed(0);
                // if (grandTotal > totalVente) {
                //    $('.btnCloturer').prop('disabled', true);
                // } else {
                //     $('.btnCloturer').prop('disabled', false);
                // }
            }

            document.getElementById('add-monnaie').addEventListener('click', function() {
                const container = document.getElementById('variantes-container');
                const newRow = document.createElement('div');
                newRow.classList.add('row', 'variante-row', 'mb-4');
                newRow.innerHTML = `
            <div class="col-2">
                <label for="quantite">Quantité :</label>
                <select class="form-select quantite-select" name="variantes[${varianteIndex}][quantite]" required>
                    <option selected disabled value="">Sélectionner</option>
                    @for ($i = 1; $i <= 500; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-3">
                <label for="type_monnaie">Type de monnaie :</label>
                <select class="form-select type-monnaie-select" name="variantes[${varianteIndex}][type_monnaie]" required>
                    <option selected disabled value="">Sélectionner</option>
                    @foreach ($type_monnaies as $key => $type_monnaie)
                        <option value="{{ $type_monnaie }}">{{ $type_monnaie }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-3">
                <label for="valeur">Valeur :</label>
                <select class="form-select valeur-select" name="variantes[${varianteIndex}][valeur]" required>
                    <option selected disabled value="">Sélectionner</option>
                </select>
            </div>
            <div class="col-3">
                <label for="total">Total :</label>
                <input type="number" style="background-color: #f1f4f7;" class="form-control total-input" name="variantes[${varianteIndex}][total]" readonly>
            </div>

             <div class="col-1 mt-2">
                    <button type="button" class="btn btn-danger remove-variante mt-3"> <i class="mdi mdi-delete remove-variante"></i></button>
                </div>
        `;
                container.appendChild(newRow);
                varianteIndex++;

                // Mettre à jour le total général en temps réel
                updateGrandTotal();
            });

            document.getElementById('variantes-container').addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-variante')) {
                    e.target.closest('.variante-row').remove();


                    // Mise à jour du total général après la suppression d'une ligne
                    updateGrandTotal();
                }
            });



            document.getElementById('variantes-container').addEventListener('change', function(event) {
                const row = event.target.closest('.variante-row');

                if (event.target.classList.contains('type-monnaie-select')) {
                    // Remplir les options de 'valeur' selon le type de monnaie sélectionné
                    const valeurSelect = row.querySelector('.valeur-select');
                    const selectedTypeMonnaie = event.target.value;
                    valeurSelect.innerHTML = `<option selected disabled value="">Sélectionner</option>`;

                    const valeurs = selectedTypeMonnaie === "Billets" ? billetData : pieceData;


                    for (const key in valeurs) {
                        valeurSelect.innerHTML +=
                            `<option value="${valeurs[key]}">${valeurs[key]}</option>`;
                    }
                }

                if (event.target.classList.contains('quantite-select') || event.target.classList.contains(
                        'valeur-select')) {
                    // Calculer le total automatiquement
                    const quantite = parseFloat(row.querySelector('.quantite-select').value) || 0;
                    const valeur = parseFloat(row.querySelector('.valeur-select').value) || 0;
                    const total = quantite * valeur;

                    row.querySelector('.total-input').value = total.toFixed(0);

                    // Mise à jour du total général à chaque changement de sous-total
                    updateGrandTotal();
                }
            });

            $('.btnCloturer').click(function(e) {
                e.preventDefault();
                //recuperer le grand total
                const grandTotal = document.getElementById('grand-total').value;
                //recuperer le total vente
                const totalVente = @json($totalVente);
                //verifier si le grand total est inferieur au total vente
                if (grandTotal < totalVente || grandTotal > totalVente) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Le total de la billeterie doit être égal au total de vente !',
                    })
                    return;
                } else {
                    Swal.fire({
                        title: 'Confirmer la clôture de la caisse',
                        text: "Vous êtes sur le point de clôturer la caisse. Cette action est irréversible.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui, clôturer la caisse',
                        cancelButtonText: 'Annuler'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Caisse cloturée avec succès',
                                text: 'Déconnexion automatique.',
                                icon: 'success',
                                timer: 2000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading()
                                },
                                willClose: () => {
                                    window.location.href =
                                        '{{ route('vente.cloture-caisse') }}';
                                }
                            }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    console.log(
                                        'Redirection automatique vers la page de connexion'
                                        );
                                }
                            });
                        }
                    });
                }


            });
        });
    </script>
@endsection



@endsection
