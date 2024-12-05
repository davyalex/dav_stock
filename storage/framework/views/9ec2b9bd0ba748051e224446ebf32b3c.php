
<?php $__env->startSection('title'); ?>
   Tableau de bord
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(URL::asset('build/libs/swiper/swiper-bundle.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col">

            <div class="h-100">
                <div class="row mb-3 pb-1">
                    <div class="col-12">
                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-16 mb-1">Bonjour, <?php echo e(Auth::user()->first_name . ' ' . Auth::user()->last_name); ?>

                                    !</h4>
                                <p class="text-muted mb-0">Voici ce qui se passe avec votre restaurant aujourd'hui.</p>
                            </div>
                            <div class="mt-3 mt-lg-0">
                                <form action="javascript:void(0);">
                                    <div class="row g-3 mb-0 align-items-center">
                                        <div class="col-sm-auto">
                                            <div class="input-group input-group-lg">
                                                <input type="text" class="form-control border-0 minimal-border shadow fs-5"
                                                    id="horloge" readonly>
                                                <input type="text" class="form-control border-0 minimal-border shadow fs-5"
                                                    id="date" readonly>
                                                <div class="input-group-text bg-primary border-primary text-white">
                                                    <i class="ri-time-line me-2"></i>
                                                    <i class="ri-calendar-line"></i>
                                                </div>
                                            </div>
                                            <script>
                                                function mettreAJourHorloge() {
                                                    var maintenant = new Date();
                                                    var heures = maintenant.getHours().toString().padStart(2, '0');
                                                    var minutes = maintenant.getMinutes().toString().padStart(2, '0');
                                                    var secondes = maintenant.getSeconds().toString().padStart(2, '0');
                                                    document.getElementById('horloge').value = heures + ':' + minutes + ':' + secondes;
                                                    
                                                    var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                                                    var dateEnFrancais = maintenant.toLocaleDateString('fr-FR', options);
                                                    document.getElementById('date').value = dateEnFrancais;
                                                }

                                                setInterval(mettreAJourHorloge, 1000);
                                                mettreAJourHorloge(); // Appel initial pour afficher l'heure et la date immédiatement
                                            </script>
                                        </div>
                                        <!--end col-->

                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                        </div><!-- end card header -->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->

                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Ventes totales</p>
                                    </div>
                                 
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                                data-target="<?php echo e($montantTotalVentes); ?>"><?php echo e($montantTotalVentes); ?></span> FCFA </h4>
                                      
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-success-subtle rounded fs-3">
                                            <i class="bx bx-dollar-circle text-success"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Commandes</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                     
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                                data-target="<?php echo e($nombreCommandes); ?>"><?php echo e($nombreCommandes); ?></span></h4>
                                        
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle rounded fs-3">
                                            <i class="bx bx-shopping-bag text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Produits en alerte</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                       
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                                data-target="<?php echo e($produitsEnAlerte); ?>"><?php echo e($produitsEnAlerte); ?></span> </h4>
                                      
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-warning-subtle rounded fs-3">
                                            <i class="bx bx-shopping-bag text-danger"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Depenses totales</p>
                                    </div>
                                   
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                                data-target="<?php echo e($montantTotalDepenses); ?>"><?php echo e(number_format($montantTotalDepenses, 0, ',', ' ')); ?></span> FCFA </h4>
                                     
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-primary-subtle rounded fs-3">
                                            <i class="bx bx-wallet text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div> <!-- end row-->

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header border-0 align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Revenus</h4>
                               
                            </div><!-- end card header -->

                            

                            <div class="card-body p-0 pb-2">
                                <div class="w-100">
                                    <div id="customer_impression_charts"
                                        data-colors='["--vz-primary", "--vz-success", "--vz-danger"]'
                                        data-colors-minimal='["--vz-light", "--vz-primary", "--vz-info"]'
                                        data-colors-saas='["--vz-success", "--vz-info", "--vz-danger"]'
                                        data-colors-modern='["--vz-warning", "--vz-primary", "--vz-success"]'
                                        data-colors-interactive='["--vz-info", "--vz-primary", "--vz-danger"]'
                                        data-colors-creative='["--vz-warning", "--vz-primary", "--vz-danger"]'
                                        data-colors-corporate='["--vz-light", "--vz-primary", "--vz-secondary"]'
                                        data-colors-galaxy='["--vz-secondary", "--vz-primary", "--vz-primary-rgb, 0.50"]'
                                        data-colors-classic='["--vz-light", "--vz-primary", "--vz-secondary"]'
                                        data-colors-vintage='["--vz-success", "--vz-primary", "--vz-secondary"]'
                                        class="apex-charts" dir="ltr"></div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

              
                    <!-- end col -->
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Produits les plus vendus</h4>
                               
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                        <thead class="text-muted table-light">
                                            <tr>
                                                <th scope="col">Code</th>
                                                <th scope="col">Produit</th>
                                                <th scope="col">Categorie</th>
                                                <th scope="col">Nombre de ventes</th>
                                                <th scope="col">Total vente</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $__currentLoopData = $produitsLesPlusVendus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <a href="apps-ecommerce-order-details"
                                                    class="fw-medium link-primary">#<?php echo e($item->code); ?> </a>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-2">
                                                        <?php echo e($item->nom); ?>

                                                        <img src="<?php echo e(URL::asset($item->getFirstMediaUrl('ProduitImage'))); ?>"
                                                            alt=" <?php echo e($item->nom); ?> "
                                                            class="avatar-xs rounded-circle material-shadow" />
                                                    </div>
                                                </div>
                                            </td>
                                         
                                            <td>
                                                <span class="text-success"><?php echo e($item->categorie->famille == 'bar' ? 'BAR' : 'Restaurant'); ?> </span>
                                            </td>
                                            <td> <?php echo e($item->ventes_count); ?>  </td>
                                            <td>
                                                <span > <?php echo e($item->total_ventes); ?> </span>
                                            </td>
                                          
                                        </tr><!-- end tr -->
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                           
                                        </tbody><!-- end tbody -->
                                    </table><!-- end table -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end row-->

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Commandes récentes</h4>

                            </div><!-- end card header -->

                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                        <thead class="text-muted table-light">
                                            <tr>
                                                <th scope="col">Order ID</th>
                                                <th scope="col">Customer</th>
                                                <th scope="col">Product</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Vendor</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Rating</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                           
                                        </tbody><!-- end tbody -->
                                    </table><!-- end table -->
                                </div>
                            </div>
                        </div> <!-- .card-->
                    </div> <!-- .col-->
                </div> <!-- end row-->

            </div> <!-- end .h-100-->

        </div> <!-- end col -->

   
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <!-- apexcharts -->
    <script src="<?php echo e(URL::asset('build/libs/apexcharts/apexcharts.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/jsvectormap/js/jsvectormap.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/jsvectormap/maps/world-merc.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/swiper/swiper-bundle.min.js')); ?>"></script>
    <!-- dashboard init -->
    <script src="<?php echo e(URL::asset('build/js/pages/dashboard-ecommerce.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/index.blade.php ENDPATH**/ ?>