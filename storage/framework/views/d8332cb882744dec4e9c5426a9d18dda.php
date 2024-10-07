
<?php $__env->startSection('title'); ?>
    Rapport des produits
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
            Rapports
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Rapport des produits
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Filtres</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('rapport.produit')); ?>" method="GET">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="categorie" class="form-label">Catégorie</label>
                                    <select class="form-select" id="categorie" name="categorie">
                                        <option value="">Toutes les catégories</option>
                                        
                                        <?php $__currentLoopData = $categorie_famille; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($item->famille); ?>" <?php echo e(request('categorie') == $item->famille ? 'selected' : ''); ?>>
                                                <?php if($item->famille == 'bar'): ?>
                                                    Boissons
                                                <?php elseif($item->famille == 'menu'): ?> 
                                                    Cuisine interne
                                                <?php else: ?>
                                                    <?php echo e($item->famille); ?>

                                                <?php endif; ?>
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="date_debut" class="form-label">Date de début</label>
                                    <input type="date" class="form-control" id="date_debut" name="date_debut"
                                        value="<?php echo e(request('date_debut')); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="date_fin" class="form-label">Date de fin</label>
                                    <input type="date" class="form-control" id="date_fin" name="date_fin"
                                        value="<?php echo e(request('date_fin')); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Filtrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        Rapport des produits 
                        <?php if(request('categorie')): ?>
                            <?php echo e(request('categorie') == 'bar' ? 'boissons' : 'cuisine interne'); ?>

                        <?php endif; ?>
                        <?php if(request('date_debut') || request('date_fin')): ?>
                            du 
                            <?php if(request('date_debut')): ?>
                                <?php echo e(\Carbon\Carbon::parse(request('date_debut'))->format('d/m/Y')); ?>

                            <?php endif; ?>
                            <?php if(request('date_fin')): ?>
                                au <?php echo e(\Carbon\Carbon::parse(request('date_fin'))->format('d/m/Y')); ?>

                            <?php endif; ?>
                        <?php endif; ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Designation</th>
                                    
                                    <th>Catégorie</th>
                                    <th>Prix de vente</th>
                                    <th>Quantité vendue</th>
                                    <th>Montant total des ventes</th>
                                    <th>Stock disponible</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $produits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(++$key); ?></td>
                                        <td><?php echo e($produit->code); ?></td>
                                        <td><?php echo e($produit->nom); ?></td>
                                        
                                        <td><?php echo e($produit->categorie->name); ?></td>
                                        <td>
                                            
                                            <?php echo e($produit->ventes[0]->pivot->prix_unitaire ?? 0); ?>

                                        </td>
                                        <td><?php echo e($produit->quantite_vendue); ?></td>
                                        <td><?php echo e(number_format($produit->montant_total_ventes, 0, ',', ' ')); ?> FCFA</td>
                                        <td><?php echo e($produit->stock ?? 'N/A'); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>

                        <tfoot>
                           
                            <tr>
                                <th colspan="7">Résumé</th>
                            </tr>
                            <tr>
                                <td colspan="3">Nombre de produits :</td>
                                <td colspan="4"><?php echo e($produits->count()); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3">Montant total des ventes :</td>
                                <td colspan="4"><?php echo e(number_format($produits->sum('montant_total_ventes'), 0, ',', ' ')); ?> FCFA</td>
                            </tr>
                            <tr>
                                <td colspan="3">Quantité totale vendue :</td>
                                <td colspan="4"><?php echo e($produits->sum('quantite_vendue')); ?></td>
                            </tr>
                        </tfoot>
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

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/rapport/produit.blade.php ENDPATH**/ ?>