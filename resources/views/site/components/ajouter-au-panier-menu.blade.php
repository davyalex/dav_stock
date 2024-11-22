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

<script>
    $('.addCart').click(function(e) {
        e.preventDefault();

        // Récupérer les informations du produit et du complément
        var getId = $(this).data('id'); // ID du produit
        var getQuantity = $('#quantity').val() || 1; // Quantité (par défaut 1 si non précisé)
        var getPrice = $(this).closest('.card-footer').find('#price').data('price'); // Prix du produit
        var getComplement = $(this).closest('.card').find('#complement').val(); // Complément sélectionné

        // Vérifier si le produit a des compléments obligatoires
        var hasComplements = $(this).closest('.card').find('#complement').length > 0;

        // Validation : Si des compléments sont nécessaires mais non sélectionnés
        if (hasComplements && !getComplement) {
            Swal.fire({
                title: 'Complément manquant',
                text: 'Veuillez sélectionner un complément pour ce produit avant de l\'ajouter au panier.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return; // Arrêter l'exécution si un complément n'est pas sélectionné
        }

        // Requête AJAX pour ajouter le produit et le complément au panier
        $.ajax({
            type: "GET",
            url: "/add-menu/" + getId,
            data: {
                id: getId,
                complement_id: getComplement,
                quantity: getQuantity,
                price: getPrice
            },
            dataType: "json",
            success: function(response) {
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
</script>

<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js
"></script>
