   <div class="footer-area black-bg-2 pt-70">
       <div class="footer-top-area pb-18">
           <div class="container">
               <div class="row">
                   <div class="col-lg-4 col-md-6 col-sm-6">
                       <div class="footer-about mb-40">
                           <div class="footer-logo">
                               <a href="#">
                                   <img src="<?php echo e($setting != null ? $setting->getFirstMediaUrl('logo_footer') : ''); ?>"
                                       width="50" alt="">
                               </a>
                           </div>
                           <p> <?php echo e($setting->projet_description ?? 'Bienvenue au restaurant CHEZ JEANNE!'); ?> </p>
                           
                       </div>
                   </div>
                   <div class="col-lg-2 col-md-6 col-sm-6">
                       <div class="footer-widget mb-40">
                           <div class="footer-title mb-22">
                               <h4>Information</h4>
                              
                           </div>
                           <div class="footer-content">
                               <ul>
                                   <li><a href="about-us.html">À propos de nous</a></li>
                                   
                               </ul>
                           </div>
                       </div>
                   </div>
                   <div class="col-lg-2 col-md-6 col-sm-6">
                       <div class="footer-widget mb-40">
                           <div class="footer-title mb-22">
                               <h4>Nos catégories</h4>
                           </div>
                           <div class="footer-content">
                               <ul>
                                   <li><a href="#">Nos plats</a></li>
                                   <li><a href="#">Nos boissons</a></li>
                                   <li><a href="#">Notre carte menu</a></li>

                               </ul>
                           </div>
                       </div>
                   </div>
                   <div class="col-lg-4 col-md-6 col-sm-6">
                       <div class="footer-widget mb-40">
                           <div class="footer-title mb-22">
                               <h4>Contactez-nous</h4>
                           </div>
                           <div class="footer-contact">
                               <ul>
                                   <li>Localisation: <a href="<?php echo e($setting->google_maps ?? ''); ?>" target="_blank"
                                           rel="noopener noreferrer" class="text-white">
                                           <?php echo e($setting->localisation ?? ''); ?></a>
                                   </li>
                                   <li>Telephone : <?php echo e($setting->phone1 ?? '(012) 800 456 789-987'); ?></li>
                                   <li>Email: <a href="#"><?php echo e($setting->email1 ?? 'Info@example.com'); ?></a></li>
                               </ul>
                           </div>
                           <div class="mt-35 footer-title mb-22">
                               <h4>Horaires d'ouverture</h4>
                           </div>
                           <div class="footer-time">
                               <ul>
                                   <li>Ouverture: <span><?php echo e($setting->horaire_ouverture ?? '11:00'); ?></span> - Fermeture:
                                       <span><?php echo e($setting->horaire_fermeture ?? '02:00'); ?></span>
                                   </li>
                                   <li>Lundi - Dimanche</li>
                               </ul>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <div class="footer-bottom-area border-top-4">
           <div class="container">
               <div class="row">
                   <div class="col-lg-6 col-md-6 col-sm-7">
                       <div class="copyright">
                           <p>&copy; <?php echo e(date('Y')); ?> <strong> <?php echo e($setting->projet_title ?? 'Restaurant Jeanne'); ?>

                               </strong> Made with <i class="fa fa-heart text-danger"></i>
                               by <a href="https://ticafrique.com/" target="_blank"><strong>Ticafrique</strong></a>
                           </p>
                       </div>
                   </div>
                   <div class="col-lg-6 col-md-6 col-sm-5">
                       <div class="footer-social">
                           <ul>
                               <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                               <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                               <li><a href="#"><i class="ion-social-instagram-outline"></i></a></li>
                               <li><a href="#"><i class="ion-social-googleplus-outline"></i></a></li>
                               <li><a href="#"><i class="ion-social-rss"></i></a></li>
                               <li><a href="#"><i class="ion-social-dribbble-outline"></i></a></li>
                           </ul>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <!-- Modal -->
   <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
       <div class="modal-dialog" role="document">
           <div class="modal-content">
               <div class="modal-header">
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <div class="row">
                       <div class="col-md-5 col-sm-5 col-xs-12">
                           <!-- Thumbnail Large Image start -->
                           <div class="tab-content">
                               <div id="pro-1" class="tab-pane fade show active">
                                   <img src="assets/img/product-details/product-detalis-l1.jpg" alt="">
                               </div>
                               <div id="pro-2" class="tab-pane fade">
                                   <img src="assets/img/product-details/product-detalis-l2.jpg" alt="">
                               </div>
                               <div id="pro-3" class="tab-pane fade">
                                   <img src="assets/img/product-details/product-detalis-l3.jpg" alt="">
                               </div>
                               <div id="pro-4" class="tab-pane fade">
                                   <img src="assets/img/product-details/product-detalis-l4.jpg" alt="">
                               </div>
                           </div>
                           <!-- Thumbnail Large Image End -->
                           <!-- Thumbnail Image End -->
                           <div class="product-thumbnail">
                               <div class="thumb-menu owl-carousel nav nav-style" role="tablist">
                                   <button class="active" id="pro-1-tab" data-bs-toggle="tab" data-bs-target="#pro-1"
                                       type="button" role="tab" aria-controls="pro-1" aria-selected="true">
                                       <img src="assets/img/product-details/product-detalis-s1.jpg"
                                           alt="product-thumbnail">
                                   </button>
                                   <button id="pro-2-tab" data-bs-toggle="tab" data-bs-target="#pro-2"
                                       type="button" role="tab" aria-controls="pro-2" aria-selected="true">
                                       <img src="assets/img/product-details/product-detalis-s2.jpg"
                                           alt="product-thumbnail">
                                   </button>
                                   <button id="pro-3-tab" data-bs-toggle="tab" data-bs-target="#pro-3"
                                       type="button" role="tab" aria-controls="pro-3" aria-selected="true">
                                       <img src="assets/img/product-details/product-detalis-s3.jpg"
                                           alt="product-thumbnail">
                                   </button>
                                   <button id="pro-4-tab" data-bs-toggle="tab" data-bs-target="#pro-4"
                                       type="button" role="tab" aria-controls="pro-4" aria-selected="true">
                                       <img src="assets/img/product-details/product-detalis-s4.jpg"
                                           alt="product-thumbnail">
                                   </button>
                               </div>
                           </div>
                           <!-- Thumbnail image end -->
                       </div>
                       <div class="col-md-7 col-sm-7 col-xs-12">
                           <div class="modal-pro-content">
                               <h3>PRODUCTS NAME HERE </h3>
                               <div class="product-price-wrapper">
                                   <span>$120.00</span>
                                   <span class="product-price-old">$162.00 </span>
                               </div>
                               <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis
                                   egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet.</p>
                               <div class="quick-view-select">
                                   <div class="select-option-part">
                                       <label>Size*</label>
                                       <select class="select">
                                           <option value="">S</option>
                                           <option value="">M</option>
                                           <option value="">L</option>
                                       </select>
                                   </div>
                                   <div class="quickview-color-wrap">
                                       <label>Color*</label>
                                       <div class="quickview-color">
                                           <ul>
                                               <li class="blue">b</li>
                                               <li class="red">r</li>
                                               <li class="pink">p</li>
                                           </ul>
                                       </div>
                                   </div>
                               </div>
                               <div class="product-quantity">
                                   <div class="cart-plus-minus">
                                       <input class="cart-plus-minus-box" type="text" name="qtybutton"
                                           value="02">
                                   </div>
                                   <button>Add to cart</button>
                               </div>
                               <span><i class="fa fa-check"></i> In stock</span>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <!-- Modal end -->





   <!-- all js here -->
   <?php echo $__env->make('site.layouts.vendor-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH C:\laragon\www\restaurant\resources\views/site/layouts/footer.blade.php ENDPATH**/ ?>