
<?php $__env->startSection('title'); ?>
    Produit
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
            Liste des produits
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            produit
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>



    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Liste des produits
                        <?php if(request()->has('filter')): ?>
                            - <b><?php echo e(request('filter')); ?></b>
                        <?php endif; ?>
                    </h5>


                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class=" ri ri-filter-2-fill"></i> Filtrer par categorie
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="/admin/produit?filter=Restaurant">Restaurant</a></li>
                            <li><a class="dropdown-item" href="/admin/produit?filter=Bar">Bar</a></li>
                            <li><a class="dropdown-item" href="/admin/produit">Toutes les categories</a></li>
                        </ul>
                    </div>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('creer-produit')): ?>
                        <a href="<?php echo e(route('produit.create')); ?>" type="button" class="btn btn-primary ">Créer
                            un produit</a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>Code</th>
                                    <th>Image</th>
                                    <th>Nom</th>
                                    <th>Categorie (Famille)</th>
                                    
                                    <th>Stock</th>
                                    <th>Stock alerte</th>
                                    <th>Date creation</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $data_produit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr id="row_<?php echo e($item['id']); ?>">
                                        <td> <?php echo e(++$key); ?> </td>
                                        <td><?php echo e($item['id']); ?>


                                        <td><?php echo e($item['code']); ?>

                                            <span
                                                class="badge<?php echo e($item->statut == 'desactive' ? ' bg-danger' : ' bg-success'); ?>"><?php echo e($item['statut']); ?></span>
                                        </td>
                                        <td>
                                            <img class="rounded avatar-sm"
                                                src="<?php echo e($item->hasMedia('ProduitImage') ? $item->getFirstMediaUrl('ProduitImage') : asset('assets/img/logo/logo_Chez-jeanne.jpg')); ?>"
                                                width="50px" alt="<?php echo e($item['nom']); ?>">
                                        </td>
                                        <td><?php echo e($item['nom']); ?>

                                            <p> <?php echo e($item['valeur_unite'] ?? ''); ?>

                                                <?php echo e($item['unite']['libelle'] ?? ''); ?></p>

                                            

                                        </td>
                                        <td><?php echo e($item['categorie']['famille'] ?? ''); ?>(<?php echo e($item['categorie']['name'] ?? ''); ?>)
                                        </td>
                                        
                                        <td><?php echo e($item['stock']); ?> <?php echo e($item['uniteSortie']['libelle'] ?? ''); ?></td>
                                        <td><?php echo e($item['stock_alerte']); ?> <?php echo e($item['uniteSortie']['libelle'] ?? ''); ?></td>
                                        <td> <?php echo e($item['created_at']); ?> </td>
                                        <td>
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill align-middle"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('voir-produit')): ?>
                                                        <li><a href="<?php echo e(route('produit.show', $item['id'])); ?>"
                                                                class="dropdown-item"><i
                                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                                Detail</a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('modifier-produit')): ?>
                                                        <li><a href="<?php echo e(route('produit.edit', $item['id'])); ?>" type="button"
                                                                class="dropdown-item edit-item-btn"><i
                                                                    class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                                Modifier</a></li>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('supprimer-produit')): ?>
                                                        <li>
                                                            <a href="#" class="dropdown-item remove-item-btn delete"
                                                                data-id=<?php echo e($item['id']); ?>>
                                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                Supprimer
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
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
    <!--end row-->

    
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"></script>

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
    

    <script>
        $(document).ready(function() {

            // Vérifiez si la DataTable est déjà initialisée
            if ($.fn.DataTable.isDataTable('#buttons-datatables')) {
                // Si déjà initialisée, détruisez l'instance existante
                $('#buttons-datatables').DataTable().destroy();
            }

            // Initialisez la DataTable avec les options et le callback
            var table = $('#buttons-datatables').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'print'
                ],

                // Utilisez drawCallback pour exécuter delete_row après chaque redessin
                drawCallback: function(settings) {
                    var route = "produit";
                    delete_row(route);
                }
            });



            // // Vérifiez si la DataTable est déjà initialisée
            // if ($.fn.dataTable.isDataTable('#buttons-datatables')) {
            //     // Si déjà initialisée, détruisez l'instance existante
            //     $('#buttons-datatables').DataTable().destroy();
            // }

            // // Initialisez la DataTable
            // var table = $('#buttons-datatables').DataTable();

            // // Callback après chaque redessin de la table (pagination, filtrage, tri, etc.)
            // table.on('draw', function() {
            //     var route = "produit";
            //     delete_row(route);
            // });
        });
    </script>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/produit/index.blade.php ENDPATH**/ ?>