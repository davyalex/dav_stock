

<?php $__env->startSection('title', 'Produit detail /' . $produit->nom); ?>

<?php $__env->startSection('content'); ?>

    <div class="product-details pt-100 pb-90">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="product-details-img">
                        <img class="zoompro" src="<?php echo e($produit->getFirstMediaUrl('ProduitImage' , 'standard-size')); ?>"
                            data-zoom-image="<?php echo e($produit->getFirstMediaUrl('ProduitImage')); ?>" 
                            alt="<?php echo e($produit->nom); ?>" />
                        <div id="gallery" class="mt-20 product-dec-slider owl-carousel">
                            <?php $__currentLoopData = $produit->getMedia('galleryProduit'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a data-image="<?php echo e($media->getUrl('standard-size')); ?>" data-zoom-image="<?php echo e($media->getUrl('standard-size')); ?>">
                                    <img src="<?php echo e($media->getUrl('small-size')); ?>" alt="<?php echo e($media->name); ?>">
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <span> <?php echo e($produit->categorie->name); ?> </span>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="product-details-content">
                        <h4><?php echo e($produit->nom); ?> </h4>

                        <span>
                            <?php echo e($produit->achats->isNotEmpty() ? $produit->achats[0]->prix_vente_unitaire : $produit->prix); ?>

                            FCFA </span>

                        <?php if($produit->achats->isNotEmpty()): ?>
                            <div class="in-stock">
                                <p>En stock: <span> <?php echo e($produit->achats->isNotEmpty() ? $produit->stock : ''); ?> </span></p>
                            </div>
                        <?php endif; ?>

                        <p> <?php echo e($produit->description); ?> </p>

                        <div class="pro-details-cart-wrap d-flex">

                            <div class="product-quantity">
                                <div class="cart-plus-minus">
                                    <input class="cart-plus-minus-box" type="text" name="qtybutton" value="2">
                                </div>
                            </div>
                            <div class="shop-list-cart-wishlist mx-3">
                                <a title="Ajouter au panier" href="#">
                                    <i class="ion-android-cart"></i>
                                </a>

                            </div>

                        </div>
                        <div class="pro-dec-categories">
                            <ul>
                                <li class="categories-title">Categories:</li>
                                <li><a href="#"><?php echo e($produit->categorie->getPrincipalCategory()->name); ?> ,</a></li>
                                <li><a href="#"> <?php echo e($produit->categorie->name); ?> </a></li>

                            </ul>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="description-review-area pb-100">
        <div class="container">
            <div class="description-review-wrapper">
                <div class="description-review-topbar nav text-center">
                    <a class="active" data-bs-toggle="tab" href="#des-details1">Description</a>
                    
                </div>
                <div class="tab-content description-review-bottom">
                    <div id="des-details1" class="tab-pane active">
                        <div class="product-description-wrapper">
                            <?php echo e($produit->description); ?>

                        </div>
                    </div>
                    <div id="des-details2" class="tab-pane">
                        <div class="product-anotherinfo-wrapper">
                            <ul>
                                <li><span>Tags:</span></li>
                                <li><a href="#"> All,</a></li>
                                <li><a href="#"> Cheesy,</a></li>
                                <li><a href="#"> Fast Food,</a></li>
                                <li><a href="#"> French Fries,</a></li>
                                <li><a href="#"> Hamburger,</a></li>
                                <li><a href="#"> Pizza</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="des-details3" class="tab-pane">
                        <div class="rattings-wrapper">
                            <div class="sin-rattings">
                                <div class="star-author-all">
                                    <div class="ratting-star f-left">
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <span>(5)</span>
                                    </div>
                                    <div class="ratting-author f-right">
                                        <h3>tayeb rayed</h3>
                                        <span>12:24</span>
                                        <span>9 March 2022</span>
                                    </div>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Utenim ad minim veniam, quis nost rud
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor
                                    sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                                    dolore magna aliqua. Utenim ad minim veniam, quis nost.</p>
                            </div>
                            <div class="sin-rattings">
                                <div class="star-author-all">
                                    <div class="ratting-star f-left">
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <span>(5)</span>
                                    </div>
                                    <div class="ratting-author f-right">
                                        <h3>farhana shuvo</h3>
                                        <span>12:24</span>
                                        <span>9 March 2022</span>
                                    </div>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Utenim ad minim veniam, quis nost rud
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor
                                    sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                                    dolore magna aliqua. Utenim ad minim veniam, quis nost.</p>
                            </div>
                        </div>
                        <div class="ratting-form-wrapper">
                            <h3>Add your Comments :</h3>
                            <div class="ratting-form">
                                <form action="#">
                                    <div class="star-box">
                                        <h2>Rating:</h2>
                                        <div class="ratting-star">
                                            <i class="ion-star theme-color"></i>
                                            <i class="ion-star theme-color"></i>
                                            <i class="ion-star theme-color"></i>
                                            <i class="ion-star theme-color"></i>
                                            <i class="ion-star"></i>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="rating-form-style mb-20">
                                                <input placeholder="Name" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="rating-form-style mb-20">
                                                <input placeholder="Email" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="rating-form-style form-submit">
                                                <textarea name="message" placeholder="Message"></textarea>
                                                <input type="submit" value="add review">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

<?php $__env->stopSection(); ?>

<?php echo $__env->make('site.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/site/pages/produit-detail.blade.php ENDPATH**/ ?>