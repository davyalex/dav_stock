<link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css
" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
{{-- <script>
    $('.addCart').click(function(e) {
        e.preventDefault();

        var getId = $(this).data('id');
        var getQuantity = $('#quantity').val();
        var getPrice = $('#price').data('price');
        var getComplement = $('#complement').val();
        // console.log(getId);
        $.ajax({
            type: "GET",
            url: "/add/" + getId,
            data: {
                id: getId,
                complement_id: getComplement,
                quantity: getQuantity,
                price: getPrice

            },
            dataType: "json",
            success: function(response) {
                $('.totalQuantity').html(response.totalQte)
                $('.totalPrice').html(response.totalPrice + ' FCFA')
               
                Swal.fire({
                    title: 'Produit ajouté !',
                    text: 'Le produit a été ajouté à votre panier avec succès.',
                    icon: 'success',
                    showConfirmButton: false, // Masquer le bouton de confirmation
                    timer: 1000, // L'alerte disparaît après 3000 ms (3 secondes)
                    timerProgressBar: true // Affiche une barre de progression pour le timer
                })

            }
        });



    });
</script> --}}

{{-- <script>
    $('.addCart').click(function(e) {
        e.preventDefault();

        // Récupérer les informations du produit et du complément
        var getId = $(this).data('id'); // ID du produit
        var getQuantity = $(this).closest('.card').find('#quantity').val() ||
        1; // Quantité (par défaut 1 si non précisé)
        var getPrice = $(this).data('price'); // Prix du produit
        var getComplement = $(this).closest('.card').find('#complement').val() ||
            null; // Complément sélectionné (null si non sélectionné)
        var getGarniture = $(this).closest('.card').find('#garniture').val() ||
            null; // Garniture sélectionnée (null si non sélectionné)

        // Vérifier si le produit a des compléments ou des garnitures obligatoires
        var hasComplements = $(this).closest('.card').find('#complement').length > 0;
        var hasGarnitures = $(this).closest('.card').find('#garniture').length > 0;

        // Validation : Si des compléments ou des garnitures sont nécessaires mais non sélectionnés
        if ((hasComplements && !getComplement) || (hasGarnitures && !getGarniture)) {
            Swal.fire({
                title: 'Informations manquantes',
                text: 'Veuillez sélectionner un complément et garniture avant d\'ajouter au panier.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return; // Arrêter l'exécution si un complément ou une garniture n'est pas sélectionné
        }

        // console.log("ID du produit:", getId);
        // console.log("Quantité:", getQuantity);
        // console.log("Prix du produit:", getPrice);
        // console.log("Complément sélectionné:", getComplement);
        // console.log("Garniture sélectionnée:", getGarniture);
        // console.log("Le produit a des compléments obligatoires:", hasComplements);
        // console.log("Le produit a des garnitures obligatoires:", hasGarnitures);
        // Requête AJAX pour ajouter le produit et le complément au panier
        $.ajax({
            type: "GET",
            url: "/add-menu/" + getId,
            data: {
                id: getId,
                complement_id: getComplement,
                garniture_id: getGarniture,
                quantity: getQuantity,
                price: getPrice
            },
            dataType: "json",
            success: function(response) {

                console.log(response);

                // Mise à jour des totaux du panier
                $('.totalQuantity').html(response.totalQte);
                $('.totalPrice').html(response.totalPrice + ' FCFA');

                // Message de succès
                Swal.fire({
                    title: 'Produit ajouté !',
                    text: 'Le produit a été ajouté à votre panier avec succès.',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true
                });

                // Redirection vers la page panier
                // window.location.href = "{{ route('panier') }}";
            },
            error: function() {
                Swal.fire({
                    title: 'Erreur',
                    text: 'Une erreur est survenue lors de l\'ajout au panier.',
                    icon: 'error',
                    confirmButtonText: 'Réessayer'
                });
            }
        });
    });
</script> --}}

{{-- <script>
    $('.addCart').click(function(e) {
        e.preventDefault();

        let selectedItems = [];
        let errorMessage = '';

        // Parcourir tous les plats sélectionnés
        $('.plat-checkbox:checked').each(function() {
            let card = $(this).closest('.card');
            let productId = $(this).val();
            let quantity = card.find('.cart-plus-minus-box').val() || 1;
            let price = card.find('.price').attr('data-price')
            // Vérification des compléments et garnitures
            let hasComplements = card.find('.complement-checkbox').length > 0;
            let hasGarnitures = card.find('.garniture-checkbox').length > 0;

            let complementSelected = card.find('.complement-checkbox:checked').length > 0;
            let garnitureSelected = card.find('.garniture-checkbox:checked').length > 0;

            // Si le produit a des compléments ou garnitures et aucun n'est sélectionné
            if ((hasComplements && !complementSelected) || (hasGarnitures && !garnitureSelected)) {
                errorMessage =
                    'Veuillez sélectionner au moins un complément ou une garniture pour le plat sélectionné.';
                return false; // Arrête la boucle
            }

            // Ajouter les détails dans un tableau
            selectedItems.push({
                id: productId,
                complement_id: complementSelected ? card.find('.complement-checkbox:checked')
                    .val() : null,
                garniture_id: garnitureSelected ? card.find('.garniture-checkbox:checked')
                    .val() : null,
                quantity: quantity,
                price: price
            });

            // console.log(selectedItems);

        });

        // Si une erreur est détectée
        if (errorMessage) {
            Swal.fire({
                title: 'Erreur de sélection',
                text: errorMessage,
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Si aucun plat n'est sélectionné
        if (selectedItems.length === 0) {
            Swal.fire({
                title: 'Aucun produit sélectionné',
                text: 'Veuillez sélectionner au moins un produit avant d\'ajouter au panier.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Envoyer les données au backend via AJAX
        $.ajax({
            type: "POST",
            url: "{{ route('cart.add-menu') }}",
            data: {
                items: selectedItems,
                _token: "{{ csrf_token() }}" // Protection CSRF
            },
            dataType: "json",
            success: function(response) {
                Swal.fire({
                    title: 'Produits ajoutés !',
                    text: 'Les produits sélectionnés ont été ajoutés à votre panier avec succès.',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                });



                // Mise à jour du total du panier
                $('.totalQuantityMenu').html(response.totalQte);
                $('.totalPriceMenu').html(response.totalPrice + ' FCFA');

                // rediriger au panier
                window.location.href = "{{ route('panier') }}";
            },
            error: function() {
                Swal.fire({
                    title: 'Erreur',
                    text: 'Une erreur est survenue lors de l\'ajout au panier.',
                    icon: 'error',
                    confirmButtonText: 'Réessayer'
                });
            }
        });
    });
</script> --}}




<script>
    document.querySelector('.addCart').addEventListener('click', function() {
        const plats = document.querySelectorAll('.plat-checkbox:checked');
        const panier = [];
        let validationEchouee = false;

        plats.forEach((plat) => {
            const platId = plat.value;
            const platNom = plat.nextElementSibling.textContent.trim();
            const platQuantite = plat.closest('.form-check').querySelector('.quantityPlat').value;
            const prixPlat = plat.getAttribute('data-price');


            const complements = [];
            const garnitures = [];
            let complementManquant = false;
            let garnitureManquante = false;

            // Compléments
            const complementCheckboxes = plat.closest('.card-body').querySelectorAll(
                '.complement-checkbox');
            complementCheckboxes.forEach((complement) => {
                if (complement.checked) {
                    complements.push({
                        id: complement.value,
                        nom: complement.nextElementSibling.textContent.trim(),
                        quantity: complement.closest('.form-check').querySelector(
                            '.quantityComplement').value,
                    });
                }
            });

            if (complementCheckboxes.length > 0 && complements.length === 0) {
                complementManquant = true;
            }

            // Garnitures
            const garnitureCheckboxes = plat.closest('.card-body').querySelectorAll(
                '.garniture-checkbox');
            garnitureCheckboxes.forEach((garniture) => {
                if (garniture.checked) {
                    garnitures.push({
                        id: garniture.value,
                        nom: garniture.nextElementSibling.textContent.trim(),
                        quantity: garniture.closest('.form-check').querySelector(
                            '.quantityGarniture').value,
                    });
                }
            });

            if (garnitureCheckboxes.length > 0 && garnitures.length === 0) {
                garnitureManquante = true;
            }

            // Vérification des compléments et garnitures manquants
            if (complementManquant || garnitureManquante) {
                validationEchouee = true;
                const message = complementManquant ?
                    'Veuillez sélectionner au moins un complément pour le plat : ' + platNom :
                    'Veuillez sélectionner au moins une garniture pour le plat : ' + platNom;

                Swal.fire({
                    icon: 'error',
                    title: 'Attention',
                    text: message,
                });
                return;
            }

            // Ajouter au panier
            panier.push({
                plat: {
                    id: platId,
                    nom: platNom,
                    quantity: platQuantite,
                    price: prixPlat
                },
                complements,
                garnitures,
            });
        });

        if (validationEchouee) {
            return; // Stopper l'exécution si une validation échoue
        }

        if (panier.length > 0) {
            console.log('Panier :', panier);

            // Envoyer les données au backend via AJAX
            $.ajax({
                type: "POST",
                url: "{{ route('cart.add-menu') }}",
                data: {
                    items: panier,
                    _token: "{{ csrf_token() }}" // Protection CSRF
                },
                dataType: "json",
                success: function(response) {
                    Swal.fire({
                        title: 'Produits ajoutés !',
                        text: 'Les produits sélectionnés ont été ajoutés à votre panier avec succès.',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    console.log(response);


                    // Mise à jour du total du panier
                    $('.totalQuantityMenu').html(response.totalQte);
                    $('.totalPriceMenu').html(response.totalPrice + ' FCFA');

                    // rediriger au panier
                    window.location.href = "{{ route('panier') }}";
                },
                error: function(response) {
                    Swal.fire({
                        title: 'Erreur',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'Réessayer'
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Panier Menu vide',
                text: 'Aucun plat sélectionné pour le panier.',
            });
        }
    });
</script>



{{-- 
<script>
    document.querySelector('.addCart').addEventListener('click', function() {
        const plats = document.querySelectorAll('.plat-checkbox:checked');
        const panier = [];
        let validationEchouee = false;

        plats.forEach((plat) => {
            const platId = plat.value;
            const platNom = plat.nextElementSibling.textContent.trim();
            const platQuantite = plat.closest('.form-check').querySelector('.quantityPlat').value;
            const prixPlat = plat.getAttribute('data-price');

            const complements = [];
            const garnitures = [];
            let complementManquant = false;
            let garnitureManquante = false;

            // Compléments
            const complementCheckboxes = plat.closest('.card-body').querySelectorAll(
                '.complement-checkbox');
            complementCheckboxes.forEach((complement) => {
                if (complement.checked) {
                    complements.push({
                        id: complement.value
                    });
                }
            });

            if (complementCheckboxes.length > 0 && complements.length === 0) {
                complementManquant = true;
            }

            // Garnitures
            const garnitureCheckboxes = plat.closest('.card-body').querySelectorAll(
                '.garniture-checkbox');
            garnitureCheckboxes.forEach((garniture) => {
                if (garniture.checked) {
                    garnitures.push({
                        id: garniture.value
                    });
                }
            });

            if (garnitureCheckboxes.length > 0 && garnitures.length === 0) {
                garnitureManquante = true;
            }

            // Vérification des compléments et garnitures manquants
            if (complementManquant || garnitureManquante) {
                validationEchouee = true;
                const message = complementManquant ?
                    'Veuillez sélectionner au moins un complément pour le plat : ' + platNom :
                    'Veuillez sélectionner au moins une garniture pour le plat : ' + platNom;

                Swal.fire({
                    icon: 'error',
                    title: 'Validation échouée',
                    text: message,
                });
                return;
            }

            // Ajouter au panier
            panier.push({
                id: platId,
                quantity: platQuantite,
                price: prixPlat,
                complement_id: complements.map(c => c.id),
                garniture_id: garnitures.map(g => g.id),
            });
        });

        if (validationEchouee) {
            return; // Stopper l'exécution si une validation échoue
        }

        if (panier.length > 0) {
            // Envoyer les données au backend via AJAX
            console.log(panier);
            
            $.ajax({
                type: "POST",
                url: "{{ route('cart.add-menu') }}",
                data: {
                    items: panier,
                    _token: "{{ csrf_token() }}" // Protection CSRF
                },
                dataType: "json",
                success: function(response) {
                    Swal.fire({
                        title: 'Produits ajoutés !',
                        text: 'Les produits sélectionnés ont été ajoutés à votre panier avec succès.',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    console.log(response);

                    // Mise à jour du total du panier
                    $('.totalQuantityMenu').html(response.totalQte);
                    $('.totalPriceMenu').html(response.totalPrice + ' FCFA');

                    // Rediriger au panier
                    window.location.href = "{{ route('panier') }}";
                },
                error: function() {
                    Swal.fire({
                        title: 'Erreur',
                        text: 'Une erreur est survenue lors de l\'ajout au panier.',
                        icon: 'error',
                        confirmButtonText: 'Réessayer'
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Panier Menu vide',
                text: 'Aucun plat sélectionné pour le panier.',
            });
        }
    });
</script> --}}

<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js
"></script>
