
<?php $__env->startSection('title'); ?>
    État des stocks
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <!--datatable css-->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <!--datatable responsive css-->
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet"
        type="text/css" />
    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('backend.components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Gestion de stock
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            État des stocks
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Liste des produits en stock</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Nom</th>
                                    <th>Catégorie</th>
                                    <th>Stock actuel</th>
                                    <th>Stock alerte</th>
                                    <th>État du stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $produits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td>
                                         
                                                <img class="rounded avatar-sm"
                                                src="<?php echo e($produit->hasMedia('ProduitImage') ? $produit->getFirstMediaUrl('ProduitImage') : asset('assets/img/logo/logo_Chez-jeanne.jpg')); ?>"
                                                width="50px" alt="<?php echo e($produit['nom']); ?>">
                                        </td>
                                        <td><?php echo e($produit->nom); ?>

                                            <p> <?php echo e($produit['valeur_unite'] ?? ''); ?>

                                                <?php echo e($produit['unite']['libelle'] ?? ''); ?>  <?php echo e($produit->unite ? '('. $produit['unite']['abreviation'] .')' : ''); ?>   </p>
                                        </td>
                                        <td><?php echo e($produit->categorie->name); ?></td>
                                        <td><?php echo e($produit->stock); ?>     <?php echo e($produit['uniteSortie']['libelle'] ?? ''); ?>  <?php echo e($produit->unite ? '('. $produit['uniteSortie']['abreviation'] .')' : ''); ?> </td>
                                        <td><?php echo e($produit->stock_alerte); ?> <?php echo e($produit['uniteSortie']['libelle'] ?? ''); ?>  <?php echo e($produit->unite ? '('. $produit['uniteSortie']['abreviation'] .')' : ''); ?> </td>
                                        <td>
                                            <?php if($produit->stock <= $produit->stock_alerte): ?>
                                                <span class="badge bg-danger">Alerte</span>
                                            <?php else: ?>
                                                <span class="badge bg-success">Normal</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/datatables.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/stock/etat-stock/index.blade.php ENDPATH**/ ?>