
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
            Liste des achats
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Achat
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Liste des ajustements</h5>
                    <a href="<?php echo e(route('achat.create')); ?>" type="button" class="btn btn-primary ">Faire
                        un achat</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>code</th>
                                    <th>reference achat</th>
                                    <th>Type de produit</th>
                                    <th>Produit</th>
                                    <th>Stock actuel</th>
                                    <th>stock ajusté</th>
                                    <th>Mouvement</th>
                                    <th>Crée par</th>
                                    <th>Date creation</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $data_ajustement; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr id="row_<?php echo e($item['id']); ?>">
                                        <td> <?php echo e(++$key); ?> </td>
                                        <td><?php echo e($item['code']); ?></td>
                                        <td><?php echo e($item['achat']['code']); ?></td>
                                        <td><?php echo e($item['achat']['type_produit']['name']); ?></td>
                                        <td><?php echo e($item['achat']['produit']['nom']); ?></td>
                                        <td><?php echo e($item['stock_actuel']); ?></td>
                                        <td> <?php echo e($item['stock_ajustement']); ?> </td>
                                        <td> <?php echo e($item['mouvement']); ?> </td> 
                                        <td> <?php echo e($item['user']['first_name']); ?> </td>
                                        <td> <?php echo e($item['created_at']); ?> </td>

                                        
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

    <script>
        $(document).ready(function() {
            $('.delete').on("click", function(e) {
                e.preventDefault();
                var Id = $(this).attr('data-id');
                Swal.fire({
                    title: 'Etes-vous sûr(e) de vouloir supprimer ?',
                    text: "Cette action est irréversible!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Supprimer!',
                    cancelButtonText: 'Annuler',
                    customClass: {
                        confirmButton: 'btn btn-primary w-xs me-2 mt-2',
                        cancelButton: 'btn btn-danger w-xs mt-2',
                    },
                    buttonsStyling: false,
                    showCloseButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: "/achat/delete/" + Id,
                            dataType: "json",

                            success: function(response) {
                                if (response.status == 200) {
                                    Swal.fire({
                                        title: 'Supprimé!',
                                        text: 'Votre fichier a été supprimé.',
                                        icon: 'success',
                                        customClass: {
                                            confirmButton: 'btn btn-primary w-xs mt-2',
                                        },
                                        buttonsStyling: false
                                    })

                                    $('#row_' + Id).remove();
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/stock/ajustement/index.blade.php ENDPATH**/ ?>