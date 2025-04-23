@extends('backend.layouts.master')
@section('title')
    Dépenses
@endsection
@section('content')
    @component('backend.components.breadcrumb')
        @slot('li_1')
            Dépenses
        @endslot
        @slot('title')
            Créer une nouvelle dépenses
        @endslot
    @endcomponent



    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <form class="row g-3 needs-validation" method="post"
                        action="{{ route('depense.update', $data_depense['id']) }}" novalidate>
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <label for="validationCustom01" class="form-label">Categorie</label>
                                <select name="categorie" class="form-control categorie-select"  required>
                                    <option disabled selected value="">Selectionner</option>
                                    @foreach ($categorie_depense as $data)
                                        <!-- Si la catégorie a des libelleDepenses, rendre l'option non cliquable -->
                                        <option style="font-weight:bold"
                                            {{ $data['id'] == $data_depense['categorie_depense_id'] ? 'selected' : '' }}value="{{ $data['id'] }}"
                                            class="categorie" >
                                            {{ strtoupper($data['libelle']) }}
                                        </option>

                                        <!-- Boucle pour les libelleDepenses de cette catégorie -->
                                        @foreach ($data->libelleDepenses as $data_libelle)
                                            <option
                                                {{ $data_libelle['id'] == $data_depense['libelle_depense_id'] ? 'selected' : '' }}
                                                value="{{ $data_libelle['id'] }}" class="libelle-depense">
                                                &nbsp;&nbsp;&nbsp;&nbsp;{{ $data_libelle['libelle'] }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>

                            <div class="col-md-2 mb-3">
                                <label for="validationCustom01" class="form-label">Montant</label>
                                <input type="number" name="montant" value="{{ $data_depense['montant'] }}"
                                    class="form-control" id="validationCustom01" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="meta-title-input">Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" id="currentDate" value="{{ $data_depense->date_depense }}"
                                    name="date_depense" class="form-control" required>
                            </div>

                            <div class="col-md-12">
                                <label for="validationCustom01" class="form-label">Objet</label>
                                <textarea class="form-control" name="description" id="" cols="30" rows="10">
                {{ $data_depense['description'] }}
             </textarea>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary ">Valider</button>
                    </form>

                </div>
            </div><!-- end row -->
        </div><!-- end col -->
    </div>
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



    {{-- <script>
        $(function() {
            document.querySelector('.btnAddLibelle').style.display = 'none';


            // Récupérer les catégories de dépenses
            let categories = @json($categorie_depense);

            // Écouter les changements sur la catégorie sélectionnée
            // document.querySelector('.categorie-depense').addEventListener('change', function(event) {

            //     // Si une catégorie est sélectionnée, afficher le bouton ajouter libellé
            //     if (event.target.value != '') {
            //         document.querySelector('.btnAddLibelle').style.display = 'block';
            //     } else {
            //         document.querySelector('.btnAddLibelle').style.display = 'none';
            //     }

            //     // Identifier l'élément de la catégorie sélectionnée
            //     let selectedCategorieId = event.target.value; // ID de la catégorie sélectionnée


            //     // mettre la valeur de la categorie dans CategorieId input
            //     document.querySelector('.CategorieId').value = selectedCategorieId;

            //     let libelleDropdown = document.querySelector(
            //         '.libelle-depense'); // Sélecteur de la liste déroulante des libellés
            //     libelleDropdown.innerHTML = ''; // Réinitialiser les options

            //     // Filtrer les libellés de dépenses en fonction de la catégorie sélectionnée
            //     let selectedCategorie = categories.find(cat => cat.id == selectedCategorieId);

            //     if (selectedCategorie && selectedCategorie.libelle_depenses && selectedCategorie
            //         .libelle_depenses.length > 0) {
            //         // Ajouter les libellés de dépenses disponibles
            //         selectedCategorie.libelle_depenses.forEach(function(libelle) {
            //             let option = document.createElement('option');
            //             option.value = libelle.id;
            //             option.textContent = libelle.libelle;
            //             libelleDropdown.appendChild(option);
            //         });
            //     } else {
            //         // Ajouter une option indiquant qu'aucun libellé n'est disponible
            //         let option = document.createElement('option');
            //         option.value = '';
            //         option.textContent = selectedCategorie ?
            //             'Aucun libellé disponible pour cette catégorie' :
            //             'Veuillez sélectionner une catégorie valide';
            //         libelleDropdown.appendChild(option);
            //     }


            //     //enregistrer le nouveau libelle depense avec ajax

            // });






            document.querySelector('.categorie-depense').addEventListener('change', function(event) {
                // Si une catégorie est sélectionnée, afficher le bouton ajouter libellé
                if (event.target.value != '') {
                    document.querySelector('.btnAddLibelle').style.display = 'block';
                } else {
                    document.querySelector('.btnAddLibelle').style.display = 'none';
                }

                // Identifier l'élément de la catégorie sélectionnée
                let selectedCategorieId = event.target.value; // ID de la catégorie sélectionnée

                //     // mettre la valeur de la categorie dans CategorieId input
                document.querySelector('.CategorieId').value = selectedCategorieId;
                let libelleDropdown = document.querySelector(
                    '.libelle-depense'); // Liste déroulante des libellés
                libelleDropdown.innerHTML = ''; // Réinitialiser les options

                // Filtrer les libellés de dépenses en fonction de la catégorie sélectionnée
                let selectedCategorie = categories.find(cat => cat.id == selectedCategorieId);

                if (selectedCategorie && selectedCategorie.libelle_depenses && selectedCategorie
                    .libelle_depenses.length > 0) {
                    // Ajouter les libellés de dépenses disponibles
                    selectedCategorie.libelle_depenses.forEach(function(libelle) {
                        let option = document.createElement('option');
                        option.value = libelle.id;
                        option.textContent = libelle.libelle;
                        libelleDropdown.appendChild(option);
                    });
                } else {
                    // Ajouter une option indiquant qu'aucun libellé n'est disponible
                    let option = document.createElement('option');
                    option.value = '';
                    option.textContent = selectedCategorie ?
                        'Aucun libellé disponible pour cette catégorie' :
                        'Veuillez sélectionner une catégorie valide';
                    libelleDropdown.appendChild(option);
                }
            });

            // Enregistrement du nouveau libellé dépense avec AJAX
            $('#formSave').on('submit', function(e) {
                e.preventDefault(); // Empêche le rechargement de la page

                const formData = new FormData(this); // Récupère les données du formulaire

                // Envoyer les données via AJAX
                $.ajax({
                    url: '{{ route('libelle-depense.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false, // Ne pas traiter les données
                    contentType: false, // Ne pas définir le contentType
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Inclure le token CSRF
                    },
                    success: function(response) {
                        console.log(response);
                        // Vérifier la présence du libellé dans la réponse
                        if (response.libelle) {
                           
                            
                            // Insérer le nouveau libellé dans la liste déroulante (au début)
                            const libelleDropdown = $('.libelle-depense');
                            const newOption = $('<option>', {
                                value: response.libelle.id,
                                text: response.libelle.libelle
                            });
                            libelleDropdown.prepend(newOption); // Ajouter en haut

                            // Sélectionner automatiquement ce nouvel élément
                            libelleDropdown.val(response.libelle.id);

                            // Réinitialiser le formulaire
                            $('#formSave')[0].reset();

                            // Fermer le modal
                            const myModal = bootstrap.Modal.getInstance($('#myModalAddLibelle')[
                                0]);
                            myModal.hide();

                            // Afficher un message de succès avec SweetAlert
                            Swal.fire({
                                icon: 'success',
                                title: 'Opération réussie',
                                text: 'Libellé ajouté avec succès.'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: 'Une erreur est survenue.'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: 'Erreur lors de l\'enregistrement.'
                        });
                    }
                });
            });

        })
        // cacher le boutton ajouter libelle depense
    </script> --}}
@endsection



@endsection
