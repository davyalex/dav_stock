<link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css
" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $('.addCart').click(function(e) {
        e.preventDefault();

        var getId = $(this).data('id');


        var getQuantity = $('#quantity').val();
        var getPrice = $('#price').data('price');
        // console.log(getId);
        $.ajax({
            type: "GET",
            url: "/add/" + getId,
            data: {
                id: getId,
                quantity: getQuantity,
                price: getPrice

            },
            dataType: "json",
            success: function(response) {

                // console.log(totalPrice);

                $('.totalQuantity').html(response.totalQte)
                $('.totalPrice').html(response.totalPrice + ' FCFA')

                // // mise des infos du topBr 2
                $('.totalQuantityTop').html(response.qteNet);
                // Mettre à jour le montant total du panier
                $('.totalPriceTop').html(response.priceNet.toLocaleString("fr-FR") + ' FCFA');
                // Mise a jour total global
                $('.totalNet').html(response.priceNet.toLocaleString("fr-FR") + ' FCFA');   

                //   $('.pro-quantity').html(response.qte)
                //   $('.cart-price').html(response.price)
                //   $('.get-total').html(response.total)
                //   $('.img-cart').html('<img  src="'+response.image+ '">')
                // Swal.fire({
                //     toast: true,
                //     icon: 'success',
                //     title: 'Produit ajouté au panier avec succès',
                //     width: '100%',
                //     animation: false,
                //     position: 'top',
                //     background: '#0ab39c',
                //     iconColor: '#fff',
                //     color: '#fff',
                //     showConfirmButton: false,
                //     timer: 1000,
                //     timerProgressBar: true,
                // });

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
</script>
<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js
"></script>
