

<?php $__env->startSection('title', 'Liste du menu'); ?>

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

            <?php if($menu && $produitsFiltres): ?>
                <div class="row flex-row">
                    <!-- start sidebar categorie-->
                    <div class="col-lg-3">
                        <div class="shop-sidebar-wrapper gray-bg-7 shop-sidebar-mrg">
                            <div class="shop-widget">
                                <h4 class="shop-sidebar-title"> <?php echo e($menu->libelle); ?> </h4>
                                <div class="shop-catigory">
                                    <ul id="faq">
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parentId => $categorieGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $parentCategory = \App\Models\Categorie::find($parentId);
                                            ?>

                                            <li>
                                                <a data-bs-toggle="collapse" data-bs-parent="#faq"
                                                    href="#category-<?php echo e($parentCategory->id); ?>">
                                                    <?php echo e($parentCategory->name); ?>

                                                    <i class="ion-ios-arrow-down"></i>
                                                </a>
                                                <ul id="category-<?php echo e($parentCategory->id); ?>"
                                                    class="panel-collapse collapse show">
                                                    <?php $__currentLoopData = $categorieGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php echo $__env->make('site.sections.categorie.categoriemenu', [
                                                            'categorie' => $categorie,
                                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end sidebar categorie-->
                    <div class="col-lg-9">

                        <div class="product-area pt-95 pb-70">
                            <div class="custom-container">
                                <div class="product-tab-list-wrap text-center mb-40 yellow-color">
                                    <div class="product-tab-list nav">
                                        <!-- Onglet pour tous les produits -->
                                        <a class="<?php echo e(is_null(request('categorie')) ? 'active' : ''); ?>" href="#tab_all"
                                            data-bs-toggle="tab">
                                            <h4>Tous les produits</h4>
                                        </a>

                                        <!-- Onglets pour chaque catégorie principale -->
                                        <?php $__currentLoopData = $produitsFiltres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoriePrincipale => $produits): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a href="#tab_<?php echo e(Str::slug($categoriePrincipale)); ?>"
                                                class="<?php echo e(request('categorie') == Str::slug($categoriePrincipale) ? 'active' : ''); ?>"
                                                data-bs-toggle="tab">
                                                <h4><?php echo e($categoriePrincipale); ?></h4>
                                            </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>

                                <div class="tab-content jump yellow-color">
                                    <!-- Onglet Tous les produits -->
                                    <div id="tab_all"
                                        class="tab-pane <?php echo e(is_null(request('categorie')) ? 'active' : ''); ?>">
                                        <div class="row">
                                            <?php $__currentLoopData = $menu->produits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($produit->categorie->getPrincipalCategory()->type == 'boissons'): ?>
                                                    <?php $__currentLoopData = $produit->achats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $achat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="col-4">
                                                            <div class="product-wrapper mb-25">
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
                                                                            <a class="btn btn-danger text-white"
                                                                                title="Add To Cart" href="#">
                                                                                <i class="ion-android-cart text-white"></i>
                                                                                Je
                                                                                commande
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="product-content">
                                                                    <h4><a
                                                                            href="<?php echo e(route('produit.detail', $produit->slug)); ?>"><?php echo e($produit->nom); ?></a>
                                                                    </h4>
                                                                    <div class="product-price-wrapper">
                                                                        <span><?php echo e($achat->prix_vente_unitaire); ?> FCFA</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <div class="col-4">
                                                        <div class="product-wrapper mb-25">
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
                                                                        <a class="btn btn-danger text-white"
                                                                            title="Add To Cart" href="#">
                                                                            <i class="ion-android-cart text-white"></i> Je
                                                                            commande
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="product-content">
                                                                <h4>
                                                                    <a
                                                                        href="<?php echo e(route('produit.detail', $produit->slug)); ?>"><?php echo e($produit->nom); ?></a>
                                                                </h4>
                                                                <div class="product-price-wrapper">
                                                                    <span><?php echo e($produit->prix); ?> FCFA</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>

                                    <!-- Onglets pour chaque catégorie principale -->
                                    <?php $__currentLoopData = $produitsFiltres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoriePrincipale => $produits): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div id="tab_<?php echo e(Str::slug($categoriePrincipale)); ?>"
                                            class="tab-pane <?php echo e(request('categorie') ? 'active' : ''); ?>">
                                            <div class="row">
                                                <?php $__currentLoopData = $produits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($produit->categorie->getPrincipalCategory()->type == 'boissons'): ?>
                                                        <?php $__currentLoopData = $produit->achats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $achat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="col-5">
                                                                <div class="product-wrapper mb-25">
                                                                    <div class="product-img">
                                                                        <a
                                                                            href="<?php echo e(route('produit.detail', $produit->slug)); ?>">
                                                                            <img src="<?php echo e($produit->getFirstMediaUrl('ProduitImage')); ?>"
                                                                                alt="<?php echo e($produit->nom); ?>">
                                                                        </a>
                                                                        <!-- Sticker de catégorie -->
                                                                        <span
                                                                            class="category-sticker"><?php echo e($produit->categorie->name); ?></span>

                                                                        <div class="product-action">
                                                                            <div class="pro-action-left">
                                                                                <a class="btn btn-danger text-white"
                                                                                    title="Add To Cart" href="#">
                                                                                    <i
                                                                                        class="ion-android-cart text-white"></i>
                                                                                    Je
                                                                                    commande
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-content">
                                                                        <h4><a
                                                                                href="<?php echo e(route('produit.detail', $produit->slug)); ?>"><?php echo e($produit->nom); ?></a>
                                                                        </h4>
                                                                        <div class="product-price-wrapper">
                                                                            <span><?php echo e($achat->prix_vente_unitaire); ?>

                                                                                FCFA</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <div class="col-5">
                                                            <div class="product-wrapper mb-25">
                                                                <div class="product-img position-relative">
                                                                    <a
                                                                        href="<?php echo e(route('produit.detail', $produit->slug)); ?>">
                                                                        <img src="<?php echo e($produit->getFirstMediaUrl('ProduitImage')); ?>"
                                                                            alt="<?php echo e($produit->nom); ?>">
                                                                    </a>
                                                                    <!-- Sticker de catégorie -->
                                                                    <span
                                                                        class="category-sticker"><?php echo e($produit->categorie->name); ?></span>

                                                                    <div class="product-action">
                                                                        <div class="pro-action-left">
                                                                            <a class="btn btn-danger text-white"
                                                                                title="Add To Cart" href="#">
                                                                                <i class="ion-android-cart text-white"></i>
                                                                                Je
                                                                                commande
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="product-content">
                                                                    <h4><a
                                                                            href="<?php echo e(route('produit.detail', $produit->slug)); ?>"><?php echo e($produit->nom); ?></a>
                                                                    </h4>
                                                                    <div class="product-price-wrapper">
                                                                        <span><?php echo e($produit->prix); ?> FCFA</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            <?php else: ?>
                <span>Pas de menu disponible</span>
            <?php endif; ?>

        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('site.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Restaurant-NEUILLY-\resources\views/site/pages/menu.blade.php ENDPATH**/ ?>