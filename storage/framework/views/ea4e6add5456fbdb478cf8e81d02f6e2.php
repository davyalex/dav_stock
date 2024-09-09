  <div class="grid-list-product-wrapper">
                        <div class="product-grid product-view pb-20">
                            <div class="row">
                                <!-- start si type categorie == boissons-->
                                <?php if($categorieRequest->type == 'boissons'): ?>
                                    <?php $__currentLoopData = $produits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $__currentLoopData = $produit->achats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30">
                                                <div class="product-wrapper">
                                                    <div class="product-img">
                                                        <a href="product-details.html">
                                                            <img src="<?php echo e($produit->getFirstMediaUrl('ProduitImage')); ?>"
                                                                alt="">
                                                        </a>
                                                        <div class="product-action">
                                                            <div class="pro-action-left">
                                                                <a title="Add Tto Cart" href="#"
                                                                    class="btn btn-danger text-white"><i
                                                                        class="ion-android-cart"></i>Je commande</a>
                                                            </div>
                                                            <div class="pro-action-right">
                                                                <a title="Wishlist" href="wishlist.html"><i
                                                                        class="ion-ios-heart-outline"></i></a>
                                                                <a title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModal" href="#"><i
                                                                        class="ion-android-open"></i></a>
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
                                <?php if($categorieRequest->type != 'boissons'): ?>
                                    <?php $__currentLoopData = $produits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30">
                                            <div class="product-wrapper">
                                                <div class="product-img">
                                                    <a href="product-details.html">
                                                        <img src="<?php echo e($produit->getFirstMediaUrl('ProduitImage')); ?>"
                                                            alt="">
                                                    </a>
                                                    <div class="product-action">
                                                        <div class="pro-action-left">
                                                            <a title="Add Tto Cart" href="#"
                                                                class="btn btn-danger text-white"><i
                                                                    class="ion-android-cart"></i>Je commande</a>
                                                        </div>
                                                        <div class="pro-action-right">
                                                            <a title="Wishlist" href="wishlist.html"><i
                                                                    class="ion-ios-heart-outline"></i></a>
                                                            <a title="Quick View" data-bs-toggle="modal"
                                                                data-bs-target="#exampleModal" href="#"><i
                                                                    class="ion-android-open"></i></a>
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
                    </div><?php /**PATH C:\laragon\www\Restaurant-NEUILLY-\resources\views/site/sections/menuproduit/menucategorieproduit.blade.php ENDPATH**/ ?>