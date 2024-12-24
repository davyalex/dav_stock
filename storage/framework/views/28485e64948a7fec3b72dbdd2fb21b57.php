

<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.datatables'); ?>
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
          Liste des commandes
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
        Gestion des commandes
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Liste des commandes <?php if(request()->has('filter')): ?> - <b><?php echo e(request('filter')); ?></b> <?php endif; ?></h5>

                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class=" ri ri-filter-2-fill"></i> Filtrer par statut
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="/admin/commande">Tous</a></li>
                            <?php $__currentLoopData = ['en attente' => 'En attente', 'confirmée' => 'Confirmée', 'livrée' => 'Livrée', 'annulée' => 'Annulée']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a class="dropdown-item" href="/admin/commande?filter=<?php echo e($key); ?>" ><?php echo e($value); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
              

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>N° de commande</th>
                                    <th>Date</th>
                                    <th>Montant</th>
                                    <th>Client</th>
                                    <th>Statut</th>
                                   <?php if(Auth::user()->hasRole('caisse')): ?>
                                   <th>Actions</th>
                                   <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $commandes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr id="row_<?php echo e($item['id']); ?>">
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><a class="fw-bold" href="<?php echo e(route('commande.show', $item->id)); ?>">#<?php echo e($item['code']); ?></a></td>
                                        <td><?php echo e($item['date_commande']); ?></td>
                                        <td><?php echo e(number_format($item['montant_total'], 0, ',', ' ')); ?> FCFA</td>
                                        <td><?php echo e($item['client']['first_name']); ?> <?php echo e($item['client']['last_name']); ?></td>
                                        <td>
                                            <?php if($item['statut'] == 'en attente'): ?>
                                                <span class="badge bg-warning">En attente</span>
                                            <?php elseif($item['statut'] == 'confirmée'): ?>
                                                <span class="badge bg-success">Confirmée</span>
                                            <?php elseif($item['statut'] == 'livrée'): ?>
                                                <span class="badge bg-info">Livrée</span>
                                            <?php elseif($item['statut'] == 'annulée'): ?>
                                                <span class="badge bg-danger">Annulée</span>
                                            <?php endif; ?>
                                        </td>
                                       <?php if(Auth::user()->hasRole('caisse')): ?>
                                       <td>
                                        <a href="<?php echo e(route('commande.show', $item->id)); ?>" class="btn btn-sm btn-info">Détails</a>
                                        
                                    </td>
                                       <?php endif; ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Aucune commande trouvée</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="<?php echo e(URL::asset('build/js/pages/datatables.init.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/vente/commande/index.blade.php ENDPATH**/ ?>