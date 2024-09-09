

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
    </style>
    <div class="shop-page-area pt-10 pb-100">
        <div class="container">
            <div class="row flex-row">
                <!-- start sidebar categorie-->
                <div class="col-lg-3">
                    <div class="shop-sidebar-wrapper gray-bg-7 shop-sidebar-mrg">
                        <div class="shop-widget">
                            <h4 class="shop-sidebar-title">Nos <?php echo e($categorieSelect->name); ?> </h4>
                            <div class="shop-catigory">
                                

                                <?php echo $__env->make('site.sections.categorie.categorieproduit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end sidebar categorie-->
                <div class="col-lg-9">
                    <div class="banner-area pb-30">
                        <a href="product-details.html"><img alt="" src="assets/img/banner/banner-49.jpg"></a>
                    </div>

                    <div class="grid-list-product-wrapper">
                        <div class="product-grid product-view pb-20">
                            <div class="row">
                                <!-- start si type categorie == boissons-->
                                <?php if($categorieSelect->type == 'boissons'): ?>
                                    <?php $__currentLoopData = $produits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $__currentLoopData = $produit->achats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30">
                                                <div class="product-wrapper">
                                                    <div class="product-img position-relative">
                                                        <a href="<?php echo e(route('produit.detail', $produit->slug)); ?>">
                                                            <img src="<?php echo e($produit->getFirstMediaUrl('ProduitImage')); ?>"
                                                                alt="<?php echo e($produit->nom); ?>">
                                                        </a>
                                                        <!-- Sticker de catégorie -->
                                                        <span
                                                            class="category-sticker"><?php echo e($produit->categorie->name); ?></span>

                                                        <div class="product-action">
                                                            <div class="pro-action-left">
                                                                <a class="btn btn-danger text-white" title="Add To Cart"
                                                                    href="#">
                                                                    <i class="ion-android-cart text-white"></i>
                                                                    Je
                                                                    commande
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="product-content">
                                                        <h4>
                                                            <a href="product-details.html"> <?php echo e($produit->nom); ?> </a>
                                                        </h4>
                                                        <div class="product-price-wrapper">
                                                            <span><?php echo e($item->prix_vente_unitaire); ?> FCFA</span>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                <!-- end si type categorie == boissons-->



                                <!-- start si type categorie != boissons-->
                                <?php if($categorieSelect->type != 'boissons'): ?>
                                    <?php $__currentLoopData = $produits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30">
                                            <div class="product-wrapper">
                                                 <div class="product-img position-relative">
                                                        <a href="<?php echo e(route('produit.detail', $produit->slug)); ?>">
                                                            <img src="<?php echo e($produit->getFirstMediaUrl('ProduitImage')); ?>"
                                                                alt="<?php echo e($produit->nom); ?>">
                                                        </a>
                                                        <!-- Sticker de catégorie -->
                                                        <span
                                                            class="category-sticker"><?php echo e($produit->categorie->name); ?></span>

                                                        <div class="product-action">
                                                            <div class="pro-action-left">
                                                                <a class="btn btn-danger text-white" title="Add To Cart"
                                                                    href="#">
                                                                    <i class="ion-android-cart text-white"></i>
                                                                    Je
                                                                    commande
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <div class="product-content">
                                                    <h4>
                                                        <a href="product-details.html"> <?php echo e($produit->nom); ?> </a>
                                                    </h4>
                                                    <div class="product-price-wrapper">
                                                        <span><?php echo e($produit->prix); ?> FCFA</span>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                <!-- end si type categorie != boissons-->
                            </div>
                        </div>
                        <div class="pagination-total-pages">
                            <div class="pagination-style">
                                <ul>
                                    <li><a class="prev-next prev" href="#"><i class="ion-ios-arrow-left"></i> Prev</a>
                                    </li>
                                    <li><a class="active" href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">...</a></li>
                                    <li><a href="#">10</a></li>
                                    <li><a class="prev-next next" href="#">Next<i class="ion-ios-arrow-right"></i>
                                        </a></li>
                                </ul>
                            </div>
                            <div class="total-pages">
                                <p>Showing 1 - 20 of 30 results </p>
                            </div>
                        </div>
                    </div>
                </div>






            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('site.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/site/pages/produit.blade.php ENDPATH**/ ?>