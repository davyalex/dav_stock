

<?php $__env->startSection('title', 'Accueil'); ?>

<?php $__env->startSection('content'); ?>


    <!-- ========== Start slider carousel ========== -->
    <?php echo $__env->make('site.sections.slider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- ========== End slider carousel ========== -->
    <style>
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

    <!-- ========== Start product with category ========== -->
    <div class="product-area pt-95 pb-70">
        <div class="custom-container">
            <div class="product-tab-list-wrap text-center mb-40 yellow-color">
                <div class="product-tab-list nav">
                    
                    <a class="active" href="#tab3" data-bs-toggle="tab">
                        <h4>Nos plats</h4>
                    </a>
                    <a href="#tab2" data-bs-toggle="tab">
                        <h4>Nos boissons</h4>
                    </a>
                </div>
                <p>Découvrez notre sélection de produits pour les boissons et les plats.</p>
            </div>
            <div class="tab-content jump yellow-color">
                <div id="tab1" class="tab-pane">
                    <div class="row">
                        <?php $__currentLoopData = $produitsMenu->concat($produitsBar); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="custom-col-5 mb-4">
                                <div class="product-wrapper">
                                    <div class="product-img">
                                        <a href="<?php echo e(route('produit.detail', $produit->slug)); ?>">
                                            <div class="produit-image-container">
                                                <img src="<?php echo e($produit->getFirstMediaUrl('ProduitImage')); ?>"
                                                    alt="<?php echo e($produit->nom); ?>">

                                                <?php if($produit->stock == 0 && $produit->categorie->famille == 'bar'): ?>
                                                    <div class="rupture-stock-overlay">Rupture de stock</div>
                                                <?php endif; ?>
                                            </div>
                                        </a>

                                    </div>
                                    <div class="product-content">
                                        <h4>
                                            <a href="<?php echo e(route('produit.detail', $produit->slug)); ?>"><?php echo e($produit->nom); ?></a>

                                        </h4>
                                        <div class="product-price-wrapper">
                                            <span id="price" data-price=<?php echo e($produit->prix); ?>>
                                                
                                                <?php echo e(number_format($produit->prix, 0, ',', ' ')); ?>

                                                FCFA
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div id="tab2" class="tab-pane">
                    <div class="row">
                        <?php $__currentLoopData = $produitsBar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-lg-3 col-md-3 col-6 ">
                                <div class="product-wrapper">
                                    <div class="product-img">
                                        <a href="<?php echo e(route('produit.detail', $produit->slug)); ?>">
                                            <div class="produit-image-container">
                                                <img src="<?php echo e($produit->getFirstMediaUrl('ProduitImage')); ?>"
                                                    alt="<?php echo e($produit->nom); ?>">

                                                <?php if($produit->stock == 0 && $produit->categorie->famille == 'bar'): ?>
                                                    <div class="rupture-stock-overlay">Rupture de stock</div>
                                                <?php endif; ?>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="product-content">
                                        <h4>
                                            <a href="<?php echo e(route('produit.detail', $produit->slug)); ?>"><?php echo e($produit->nom); ?></a>
                                        </h4>
                                        <div class="product-price-wrapper">
                                            <span id="price" data-price=<?php echo e($produit->prix); ?>>
                                                
                                                <?php echo e(number_format($produit->prix, 0, ',', ' ')); ?>

                                                FCFA
                                            </span>
                                        </div>

                                        <?php if($produit->stock == 0 && $produit->categorie->famille == 'bar'): ?>
                                        <span><span style="color: red" class="text-danger">Produit en rupture</span>
                                        <?php else: ?>
                                            <div class="mt-3">
                                                <button type="button" class="btn btn-danger addCart text-white"
                                                    data-id="<?php echo e($produit->id); ?>" style="border-radius: 10px">
                                                    <i class="fa fa-shopping-cart"></i> Commander
                                                </button>
                                            </div>
                                    <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>
                    <?php
                        $idCatBoisson = app\Models\Categorie::whereSlug('bar')->first();
                    ?>
                    <div class="col-12 col-md-6 col-lg-6  m-auto text-center mt-5">
                        <a href="<?php echo e(route('produit', $idCatBoisson->id)); ?>" class="btn btn-dark w-auto text-white fw-bolder"
                            style=" border-radius: 10px ; ">
                            Affichez plus de boissons <i class="fa fa-caret-right"></i>
                        </a>

                    </div>
                </div>


                <div id="tab3" class="tab-pane active">
                    <div class="row">
                        <?php $__currentLoopData = $produitsMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-lg-3 col-md-3 col-6">
                                <div class="product-wrapper">
                                    <div class="product-img">
                                        <a href="<?php echo e(route('produit.detail', $produit->slug)); ?>">
                                            <div class="produit-image-container">
                                                <img src="<?php echo e($produit->getFirstMediaUrl('ProduitImage')); ?>"
                                                    alt="<?php echo e($produit->nom); ?>">

                                                <?php if($produit->stock == 0 && $produit->categorie->famille == 'bar'): ?>
                                                    <div class="rupture-stock-overlay">Rupture de stock</div>
                                                <?php endif; ?>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="product-content">
                                        <h4>
                                            <a
                                                href="<?php echo e(route('produit.detail', $produit->slug)); ?>"><?php echo e($produit->nom); ?></a>
                                        </h4>
                                        <div class="product-price-wrapper">
                                            <span id="price" data-price=<?php echo e($produit->prix); ?>> <?php echo e(number_format($produit->prix, 0, ',', ' ')); ?> FCFA</span>
                                        </div>

                                        <?php if($produit->stock == 0 && $produit->categorie->famille == 'bar'): ?>
                                        <span><span style="color: red" class="text-danger">Produit en rupture</span>
                                        <?php else: ?>
                                            <div class="mt-2 mb-3">
                                                <button type="button" class="btn btn-danger addCart text-white"
                                                    data-id="<?php echo e($produit->id); ?>" style="border-radius: 10px">
                                                    <i class="fa fa-shopping-cart"></i> Commander
                                                </button>
                                            </div>
                                    <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php
                    $idCatPlat= app\Models\Categorie::whereSlug('bar')->first();
                ?>
                    <div class="col-12 col-md-6 col-lg-6  m-auto text-center mt-4">
                        <a href="<?php echo e(route('produit', $idCatPlat->id)); ?>"
                            class="btn btn-dark w-auto text-white fw-bolder" style="border-radius: 10px;">
                            Affichez plus de Plats <i class="fa fa-caret-right"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- ========== End product with category ========== -->



    <!-- ========== Start banner card ========== -->
    <div class="banner-area row-col-decrease pb-75 clearfix">
        <div class="container">
            <div class="row">
                <?php $__currentLoopData = $data_slide->where('type', 'petite-banniere'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="single-banner mb-30">
                            <div class="hover-style">
                                <a href="#">
                                    <img src="<?php echo e($item->getFirstMediaUrl('petite-banniere')); ?>" alt="bannière">
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    <!-- ========== End banner card ========== -->


    <!-- ========== Start best seller ========== -->
    <div class="best-food-area pb-95">
        <div class="custom-container">
            <div class="row">
                
                <div class="col-12">
                    <div class="product-top-bar section-border mb-25 yellow-color">
                        <div class="section-title-wrap">
                            <h3 class="section-title section-bg-white">Produits recommandés</h3>
                        </div>
                    </div>
                    <div class="tab-content jump yellow-color">
                        <div id="tab4" class="tab-pane active">
                            <div class="product-slider-active owl-carousel product-nav">
                                <?php $__currentLoopData = $produitsLesPlusCommandes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="product-wrapper">
                                        <div class="product-img">
                                            <a href="<?php echo e(route('produit.detail', $produit->slug)); ?>">
                                                <div>
                                                    <img src="<?php echo e($produit->getFirstMediaUrl('ProduitImage')); ?>"
                                                        alt="<?php echo e($produit->nom); ?>">
                                                </div>
                                            </a>
                                        </div>
                                        <div class="product-content">
                                            <h4>
                                                <a
                                                    href="<?php echo e(route('produit.detail', $produit->slug)); ?>"><?php echo e($produit->nom); ?></a>
                                            </h4>
                                            <div class="product-price-wrapper">
                                                
                                                <span id="price" data-price=<?php echo e($produit->prix); ?>><?php echo e(number_format($produit->prix, 0, ',', ' ')); ?> FCFA</span>
                                            </div>

                                            <?php if($produit->stock == 0 && $produit->categorie->famille == 'bar'): ?>
                                                <span><span style="color: red" class="text-danger">Produit en rupture</span>
                                                <?php else: ?>
                                                    <div class="my-2">
                                                        <button type="button" class="btn btn-danger addCart text-white"
                                                            data-id="<?php echo e($produit->id); ?>" style="border-radius: 10px">
                                                            <i class="fa fa-shopping-cart"></i> Commander
                                                        </button>
                                                    </div>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- ========== End best seller ========== -->



    <!-- ========== Start banner ========== -->
    <div class="banner-area mb-3">
        <div class="container">
            <?php $__currentLoopData = $data_slide->where('type', 'grande-banniere'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $item->getMedia('grande-banniere'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="discount-overlay bg-img pt-130 pb-130"
                        style="background-image:url('<?php echo e($media->getUrl()); ?>');">
                        <div class="discount-content text-center">
                            <h3><?php echo e($item->title); ?></h3>
                            <p><?php echo e($item->subtitle); ?></p>
                            <?php if($item->btn_url && $item->btn_name): ?>
                                <div class="banner-btn">
                                    <a href="<?php echo e($item->btn_url); ?>"><?php echo e($item->btn_name); ?></a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <!-- ========== End banner ========== -->
    <?php echo $__env->make('site.components.ajouter-au-panier', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('site.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/site/pages/accueil.blade.php ENDPATH**/ ?>