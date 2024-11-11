
<?php $__env->startSection('title'); ?>
    Vente
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
            Liste des ventes
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Gestion des ventes
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>



    <div class="row">
        <div class="col-lg-12">

            <div class="alert alert-info alert-dismissible fade show d-flex justify-content-center align-items-center"
                role="alert">
                <div class="me-3">
                    <h5 class="card-title mb-0">Date de vente actuelle : <span id="heureActuelle"><?php echo e(Session::get('session_date') !=null
                        ? \Carbon\Carbon::parse(Session::get('session_date'))->format('d-m-Y')
                        : 'non defini'); ?></span>
                    </h5>
                </div>

                <button type="button" class="btn btn-info ms-3" data-bs-toggle="modal"
                    data-bs-target="#dateSessionVenteModal">
                    <?php echo e(Session::get('session_date') !=null ? 'Modifier la date de la session de vente' : ' Choisir une date pour la session vente'); ?>

                   
                </button>

                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Liste des ventes </strong></h5>
                    <?php if(auth()->user()->hasRole('caisse')): ?>
                        <?php if(Session::get('session_date') !=null): ?>
                            <a href="<?php echo e(route('vente.create')); ?>" type="button" class="btn btn-primary">
                                Nouvelle vente</a>
                        <?php else: ?>
                            <button type="button" class="btn btn-info ms-3 btnChoiceDate">
                                Nouvelle vente
                            </button>
                        <?php endif; ?>
                    <?php endif; ?>



                    <?php if(!auth()->user()->hasRole('caisse')): ?>
                        <form action="<?php echo e(route('vente.index')); ?>" method="GET">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="date_debut" class="form-label">Date de début</label>
                                    <input type="date" class="form-control" id="date_debut" name="date_debut">
                                </div>
                                <div class="col-md-3">
                                    <label for="date_fin" class="form-label">Date de fin</label>
                                    <input type="date" class="form-control" id="date_fin" name="date_fin">
                                </div>
                                <div class="col-md-3">
                                    <label for="caisse" class="form-label">Caisse</label>
                                    <select class="form-select" id="caisse" name="caisse">
                                        <option value="">Toutes les caisses</option>
                                        <?php $__currentLoopData = $caisses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $caisse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($caisse->id); ?>"><?php echo e($caisse->libelle); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="col-md-3 mt-4">
                                    <button type="submit" class="btn btn-primary">Filtrer</button>
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>

                </div>

                <?php if(auth()->user()->hasRole('caisse')): ?>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Caisse actuelle</h5>
                                    <p class="card-text h3 text-primary">
                                        <?php echo e(auth()->user()->caisse->libelle ?? 'Non définie'); ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body d-flex justify-content-around">
                                    <h5 class="card-title">Total des ventes du jour : <br> <strong
                                            class="text-primary fs-3"><?php echo e(number_format($data_vente->sum('montant_total'), 0, ',', ' ')); ?>

                                            FCFA</strong> </h5>
                                    <p class="card-text h3 text-success">


                                        <?php if($data_vente->sum('montant_total') > 0): ?>
                                            <a href="<?php echo e(route('vente.billeterie-caisse')); ?>"
                                                class="btn btn-danger ">Procéder a la Clóturer
                                                la caisse</a>
                                        <?php else: ?>
                                            <button class="btn btn-danger" disabled>Procéder a la Clóturer la caisse</button>
                                        <?php endif; ?>
                                    </p>


                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>N° de vente</th>
                                    <th>Type de vente</th>
                                    <th>Session vente</th>
                                    <th>Montant</th>
                                    <th>Vendu le</th>
                                    <th>Vendu par</th>
                                    <th>Caisse</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $data_vente; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr id="row_<?php echo e($item['id']); ?>">
                                        <td> <?php echo e($loop->iteration); ?> </td>
                                        <td> <a class="fw-bold"
                                                href="<?php echo e(route('vente.show', $item->id)); ?>">#<?php echo e($item['code']); ?></a> </td>
                                        <td> <?php echo e($item['type_vente']); ?> 

                                            <?php if($item['type_vente'] == 'commande'): ?>
                                              <br>  <a href="<?php echo e(route('commande.show', $item['commande_id'])); ?>" class="text-primary fw-bold">#<?php echo $item['commande']['code']; ?></a>
                                            <?php endif; ?>
                                        </td>
                                        <td> <?php echo e(\Carbon\Carbon::parse($item['date_vente'])->format('d-m-Y')); ?>

                                            <?php echo e($item['created_at']->format('à H:i')); ?> </td>
                                        <td> <?php echo e(number_format($item['montant_total'], 0, ',', ' ')); ?> FCFA </td>
                                        <td> <?php echo e($item['created_at']->format('d-m-Y à H:i')); ?> </td>
                                        <td> <?php echo e($item['user']['first_name']); ?> <?php echo e($item['user']['last_name']); ?> </td>
                                        <td> <?php echo e($item['caisse']['libelle'] ?? ''); ?> </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Aucune vente trouvée</td>
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

    <?php echo $__env->make('backend.pages.vente.dateSessionVente', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
            $('.btnChoiceDate').click(function() {
                Swal.fire({
                    title: 'Veuillez choisir une date de session de vente avant d\'effectuer une vente',
                    // text: "Vous êtes sur le point de clôturer la caisse. Cette action est irréversible.",
                    icon: 'warning',
                    // showCancelButton: true,
                    // confirmButtonColor: '#3085d6',
                    // cancelButtonColor: '#d33',
                    // confirmButtonText: 'Oui, clôturer la caisse',
                    // cancelButtonText: 'Annuler'
                })
            })


            // $('.btnCloturer').click(function(e) {
            //     e.preventDefault();
            //     Swal.fire({
            //         title: 'Confirmer la clôture de la caisse',
            //         text: "Vous êtes sur le point de clôturer la caisse. Cette action est irréversible.",
            //         icon: 'warning',
            //         showCancelButton: true,
            //         confirmButtonColor: '#3085d6',
            //         cancelButtonColor: '#d33',
            //         confirmButtonText: 'Oui, clôturer la caisse',
            //         cancelButtonText: 'Annuler'
            //     }).then((result) => {
            //         if (result.isConfirmed) {
            //             Swal.fire({
            //                 title: 'Caisse cloturée avec succès',
            //                 text: 'Déconnexion automatique.',
            //                 icon: 'success',
            //                 timer: 2000,
            //                 timerProgressBar: true,
            //                 didOpen: () => {
            //                     Swal.showLoading()
            //                 },
            //                 willClose: () => {
            //                     window.location.href =
            //                         '<?php echo e(route('vente.cloture-caisse')); ?>';
            //                 }
            //             }).then((result) => {
            //                 if (result.dismiss === Swal.DismissReason.timer) {
            //                     console.log(
            //                         'Redirection automatique vers la page de connexion');
            //                 }
            //             });
            //         }
            //     });
            // });
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/vente/index.blade.php ENDPATH**/ ?>