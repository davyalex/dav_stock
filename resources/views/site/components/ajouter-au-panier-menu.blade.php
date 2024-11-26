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
        var getQuantity = $(this).closest('.card').find('#quantity').val() ||1; // Quantité (par défaut 1 si non précisé)
        var getPrice =  $(this).data('price'); // Prix du produit
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

        console.log("ID du produit:", getId);
        console.log("Quantité:", getQuantity);
        console.log("Prix du produit:", getPrice);
        console.log("Complément sélectionné:", getComplement);
        console.log("Garniture sélectionnée:", getGarniture);
        console.log("Le produit a des compléments obligatoires:", hasComplements);
        console.log("Le produit a des garnitures obligatoires:", hasGarnitures);
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
