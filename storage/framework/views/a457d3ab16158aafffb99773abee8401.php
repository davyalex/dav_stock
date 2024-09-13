

<?php $__env->startSection('title', 'Panier'); ?>

<?php $__env->startSection('content'); ?>

    <!-- shopping-cart-area start -->
    <div class="cart-main-area pt-35 pb-100">
        <?php if(session('cart')): ?>
            <div class="container">
                <h3 class="page-title">Mon panier
                    <span class="quantityProduct">(<?php echo e(count((array) session('cart'))); ?> produits)</span>
                </h3>
                <?php $sousTotal = 0 ?>
                </h3>
                <div class="row">
                    <!-- ========== Start panier items ========== -->
                    <div class="col-12 col-md-12 col-lg-8 col-sm-12">
                        <div class="row">

                            <?php $__currentLoopData = session('cart'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-12 col-lg-6 mb-4" id="productDiv_<?php echo e($id); ?>">
                                    <div class="card h-100 p-3">
                                        <div class="d-flex align-items-center">
                                            <!-- Image du produit -->
                                            <div class="product-image me-3">
                                                <img src="<?php echo e($details['image']); ?>" class="img-fluid" width="150px"
                                                    height="150px" alt="Produit 2">
                                            </div>
                                            <!-- Détails du produit -->
                                            <div class="product-info flex-grow-1">
                                                <h6 class="card-title text-uppercase"> <?php echo e($details['title']); ?> </h6>
                                                
                                                <!-- Prix et quantité -->
                                                <div class="d-flex justify-content-between col-sm-12">
                                                    <div>
                                                        <p class="font-weight-bold text-danger">Prix :
                                                            <?php echo e(number_format($details['price'], 0, ',', ' ')); ?> FCFA</p>
                                                        <p>
                                                        <div class="product-quantity">
                                                            <div class="cart-plus-minus">
                                                                <div class="dec qtybutton"
                                                                    onclick="decreaseValue(<?php echo e($id); ?>)">-</div>
                                                                <input data-id="<?php echo e($id); ?>"
                                                                    id="quantity-<?php echo e($id); ?>"
                                                                    class="cart-plus-minus-box" type="text"
                                                                    name="quantity" value="<?php echo e($details['quantity']); ?>"
                                                                    min="1" readonly>
                                                                <div class="inc qtybutton"
                                                                    onclick="increaseValue(<?php echo e($id); ?>)">+</div>
                                                            </div>
                                                        </div>

                                                        </p>
                                                        <p class="font-weight-bold text-danger">Total :
                                                            <span
                                                                class="totalPriceQty-<?php echo e($id); ?>"><?php echo e(number_format($details['price'] * $details['quantity'], 0, ',', ' ')); ?>

                                                                FCFA</span>
                                                        </p>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button data-id="<?php echo e($id); ?>"
                                            class="btn btn-danger btn-sm me-2 remove">Supprimer</button>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    </div>

                    <!-- ========== End panier items ========== -->

                    <div class="col-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="col-lg-12 col-md-12">
                            <div class="grand-totall">
                                <div class="title-wrap">
                                    <h4 class="cart-bottom-title section-bg-gary-cart">Panier Total</h4>
                                </div>
                                
                                <h5>Nombre de produits <span class="totalQuantity"><?php echo e(session('totalQuantity')); ?>

                                    </span></h5>
                                <h5>Montant du panier <span class="totalPrice">
                                        <?php echo e(number_format(session('totalPrice'), 0, ',', ' ')); ?> FCFA </span></h5>

                              
                                <h4 class="grand-totall-title">Total: <span class="totalPrice">
                                        <?php echo e(number_format(session('totalPrice'), 0, ',', ' ')); ?> FCFA </span></h4>
                                <?php if(auth()->guard()->check()): ?>
                                    <a href="<?php echo e(route('cart.checkout')); ?>" id="btnnext">Finaliser ma commande</a>
                                <?php endif; ?>

                                <?php if(auth()->guard()->guest()): ?>
                                    <a href="<?php echo e(route('user.login')); ?>">Connectez vous pour finaliser la commande</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="cart-shiping-update-wrapper">
                            <div class="cart-shiping-update">
                                <a href="<?php echo e(route('accueil')); ?>">Continue mes achats</a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <h1 class="text-center"><i class="icon-handbag"></i></h1>
            <h4 class="text-center">Vous n'avez pas de produits dans votre panier</h4>
        <?php endif; ?>

    </div>


    <link href="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css
    " rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>


    <script type="text/javascript">
        // Gestion du panier

        // Fonction pour augmenter la quantité
        function increaseValue(id) {
            let quantityInput = $(`#quantity-${id}`);
            let currentQuantity = parseInt(quantityInput.val());

            if (currentQuantity >= 1) {
                let newQuantity = currentQuantity + 1;
                updateCartQuantity(id, newQuantity);
            }
        }

        // Fonction pour diminuer la quantité
        function decreaseValue(id) {
            let quantityInput = $(`#quantity-${id}`);
            let currentQuantity = parseInt(quantityInput.val());

            if (currentQuantity > 1) {
                let newQuantity = currentQuantity - 1;
                updateCartQuantity(id, newQuantity);
            }
        }

        // Fonction pour mettre à jour la quantité dans le panier
        function updateCartQuantity(id, newQuantity) {
            $.ajax({
                url: "<?php echo e(route('cart.update')); ?>", // La route pour la mise à jour du panier
                method: "POST",
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    id: id,
                    quantity: newQuantity
                },
                success: function(response) {
                    if (response.status === 'success') {

                        $(`#quantity-${id}`).val(newQuantity); // MAJ nouvelle quantité
                        $('.totalQuantity').html(response.totalQte) //MAJ quantité total panier icone
                        $('.totalPrice').html(response.totalPrice.toLocaleString("fr-FR") +
                            ' FCFA') // MAJ montant total panier 
                        $('.totalPriceQty-' + id).html(response.totalPriceQty.toLocaleString("fr-FR") +
                            ' FCFA') // MAJ montant total du produit * sa quantite

                        Swal.fire({
                            title: 'Mise à jour !',
                            text: 'Quantité modifié avec succès.',
                            icon: 'success',
                            showConfirmButton: false, // Masquer le bouton de confirmation
                            timer: 1000, // L'alerte disparaît après 3000 ms (3 secondes)
                            timerProgressBar: true // Affiche une barre de progression pour le timer
                        })



                    } else {
                        alert("Erreur lors de la mise à jour du panier.");
                    }
                },

            });
        }



        //Fonction pour supprimer un produit du panier
        $(".remove").click(function(e) {
            e.preventDefault();

            var IdProduct = $(this).attr('data-id');
            // console.log(productId);

            Swal.fire({
                title: 'Retirer du panier',
                text: "Vous ne pourrez pas annuler cela !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer !',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?php echo e(route('cart.remove')); ?>',
                        method: "POST",
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>',
                            id: IdProduct
                        },

                        success: function(response) {
                            if (response.status == 'success') {
                                $('.totalQuantity').html(response
                                    .totalQte) //MAJ quantité total panier icone
                                $('.totalPrice').html(response.totalPrice.toLocaleString(
                                        "fr-FR") +
                                    ' FCFA') // MAJ montant total panier 
                                $('.countProductCart').html(response
                                    .countProductCart) //MAJ quantité total panier icone

                                Swal.fire({
                                    title: 'Produit supprimé',
                                    text: 'Le produit a été supprimé du panier avec succès.',
                                    icon: 'success',
                                    showConfirmButton: false, // Masquer le bouton de confirmation
                                    timer: 1000, // L'alerte disparaît après delai ms (en secondes)
                                    timerProgressBar: true // Affiche une barre de progression pour le timer
                                });
                                $('#productDiv_' + IdProduct).remove(); // supprimer le produit 

                                //rafraichir la page si panier vide
                                if (response.countProductCart == 0) {
                                    window.location.href = "<?php echo e(route('panier')); ?>";
                                }
                            }

                        }
                    });


                }
            })


        });
    </script>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('site.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/site/pages/panier.blade.php ENDPATH**/ ?>