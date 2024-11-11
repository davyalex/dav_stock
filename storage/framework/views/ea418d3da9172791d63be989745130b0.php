

<?php $__env->startSection('title', 'Liste des ' . $categorieSelect->name); ?>

<?php $__env->startSection('content'); ?>

    <style>
        .product-img img {
            width: 100%;
            /* Adapter à la largeur du conteneur */
            height: 250px;
            /* Fixer une hauteur spécifique */
            object-fit: contain;
            /* Maintenir les proportions tout en remplissant la zone */
        }

        .category-sticker {
            position: absolute;
            top: 10px;
            /* Ajuster la position verticale */
            left: 10px;
            /* Ajuster la position horizontale */
            background-color: rgba(0, 0, 0, 0.7);
            /* Fond semi-transparent */
            color: white;
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 5px;
            z-index: 10;
        }


        .produit-image-container {
            position: relative;
            display: inline-block;
        }

        .produit-image-container img {
            width: 100%;
            /* Ajuste la taille selon tes besoins */
        }

        .rupture-stock-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 0, 0, 0.7);
            /* Fond rouge avec opacité */
            color: white;
            padding: 10px 20px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            border-radius: 5px;
        }

        .product-content {
            text-align: center;
            text-transform: uppercase;
        }

        .product-price-wrapper span {
            font-weight: bold;
            color: rgba(255, 0, 0, 0.641)
        }
    </style>
    <div class="shop-page-area pt-10 pb-100">
        <div class="container">
            <div class="row flex-row">
                <!-- start sidebar categorie-->
                <div class="col-lg-3">
                    <div class="shop-sidebar-wrapper gray-bg-7 shop-sidebar-mrg">
                        <div class="shop-widget">
                            <h4 class="shop-sidebar-title">MENU <i class="fa fa-angle-right"></i>
                                <small><?php echo e($categorieSelect->name); ?> </small>
                            </h4>
                            <div class="shop-catigory">
                                

                                <?php echo $__env->make('site.sections.categorie.categorieproduit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end sidebar categorie-->
                <div class="col-lg-9">
                    <div class="banner-area pb-30">
                        <a href="#"><img alt="" src="assets/img/banner/banner-49.jpg"></a>
                    </div>

                    <div class="grid-list-product-wrapper">
                        <div class="product-grid product-view pb-20">
                            <div class="row">

                                <?php $__empty_1 = true; $__currentLoopData = $produits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6 mb-30">
                                        <div class="product-wrapper">
                                            <div class="product-img position-relative">
                                                <a href="<?php echo e(route('produit.detail', $produit->slug)); ?>">
                                                    <div class="produit-image-container">
                                                        <img src="<?php echo e($produit->getFirstMediaUrl('ProduitImage')); ?>"
                                                            alt="<?php echo e($produit->nom); ?>">

                                                        <?php if($produit->stock == 0 && $produit->categorie->famille == 'bar'): ?>
                                                            <div class="rupture-stock-overlay">Rupture de stock</div>
                                                        <?php endif; ?>
                                                    </div>
                                                </a>
                                                <!-- Sticker de catégorie -->
                                                <span class="category-sticker"><?php echo e($produit->categorie->name); ?></span>

                                            </div>
                                            <div class="product-content">
                                                <h4>
                                                    <a href="#"> <?php echo e($produit->nom); ?> </a>
                                                </h4>
                                                <div class="product-price-wrapper">
                                                    <span><?php echo e(number_format($produit->prix, 0, ',', ' ')); ?> FCFA</span>
                                                    
                                                </div>

                                                <div class="mt-3">
                                                    <button type="button" class="btn btn-danger addCart text-white"
                                                        data-id="<?php echo e($produit->id); ?>"
                                                        style="border-radius: 10px">
                                                       <i class="fa fa-shopping-cart"></i>  Commander
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <h3 class="text-center">Aucun produit <marquee behavior="scroll" direction="">
                                            <?php echo e($categorieSelect->name); ?></marquee> disponible</h3>
                                <?php endif; ?>

                            </div>
                        </div>
                        <div class="pagination-total-pages">
                            <nav aria-label="Navigation des pages">
                                <?php echo e($produits->links('pagination::bootstrap-5')); ?>

                            </nav>
                            <div class="text-center mt-3">
                                <p class="text-muted">
                                    Affichage de <?php echo e($produits->firstItem()); ?> - <?php echo e($produits->lastItem()); ?> sur
                                    <?php echo e($produits->total()); ?> résultats
                                </p>
                            </div>
                        </div>

                    </div>
                </div>






            </div>
        </div>
    </div>

    <?php echo $__env->make('site.components.ajouter-au-panier', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('site.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/site/pages/produit.blade.php ENDPATH**/ ?>