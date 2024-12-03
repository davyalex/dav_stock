   <div class="footer-area black-bg-2 pt-70">
       <div class="footer-top-area pb-18">
           <div class="container">
               <div class="row">
                   <div class="col-lg-6 col-md-6 col-sm-6">
                       <div class="footer-about mb-40">
                        <div class="footer-title mb-22">
                            <h4 class="text-center">A propos de nous</h4>
                        </div>
                           <div class="footer-logo">
                            <div class="row">
                                <div class="col-lg-4">
                                    <a href="#">
                                        <img src="<?php echo e($setting != null ? $setting->getFirstMediaUrl('logo_footer') : ''); ?>"
                                            width="150" alt="">
                                    </a>
     
                                </div>
                                <div class="col-lg-8">
                                    <p class="text-white"> <?php echo e($setting->projet_description ?? 'Bienvenue au restaurant CHEZ JEANNE!'); ?> </p>

                                </div>
                            </div>
                             
                           </div>
                       
                           
                       </div>
                   </div>
                   
                   <div class="col-lg-2 col-md-6 col-sm-6">
                       <div class="footer-widget mb-40">
                           <div class="footer-title mb-22">
                               <h4>Accès rapide</h4>
                           </div>
                           <div class="footer-content">
                               <ul>
                                   <li><a href="#">Nos plats</a></li>
                                   <li><a href="#">Nos boissons</a></li>
                                   <li><a href="#">Notre menu du jour</a></li>

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
                                   <li>7jrs / 7</li>
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
                           <p>&copy; <?php echo e(date('Y')); ?> <strong> <?php echo e($setting->projet_title ?? 'Restaurant Chez Jeanne'); ?>

                               </strong> Conçu par <i class="fa fa-heart text-danger"></i>
                               by <a href="https://ticafrique.com/" target="_blank"><strong>Ticafrique</strong></a>
                           </p>
                       </div>
                   </div>
                   <div class="col-lg-6 col-md-6 col-sm-5">
                       <div class="footer-social">
                           <ul>
                               <li><a href=" <?php echo e($setting->facebook_link ?? '#'); ?>" target="_blank"><i class="ion-social-facebook"></i></a></li>
                               
                           </ul>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <!-- Modal -->
 
   <!-- Modal end -->





   <!-- all js here -->
   <?php echo $__env->make('site.layouts.vendor-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH C:\laragon\www\restaurant\resources\views/site/layouts/footer.blade.php ENDPATH**/ ?>