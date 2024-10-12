
<?php $__env->startSection('title'); ?>
    Rapport d'exploitation
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
            Rapport d'exploitation
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Filtres</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('rapport.exploitation')); ?>" method="GET">
                        <?php echo csrf_field(); ?>
                        <div class="row">
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
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="categorie_depense" class="form-label">Catégorie de dépense</label>
                                    <select class="form-select" id="categorie_depense" name="categorie_depense">
                                        <option value="">Toutes les catégories</option>
                                        <?php if(request('categorie_depense')): ?>
                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($categorie->id); ?>"
                                                    <?php echo e(request('categorie_depense') == $categorie->id ? 'selected' : ''); ?>>
                                                    <?php echo e($categorie->libelle); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <?php $__currentLoopData = $categories_depense; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($categorie->id); ?>"
                                                    <?php echo e(request('categorie_depense') == $categorie->id ? 'selected' : ''); ?>>
                                                    <?php echo e($categorie->libelle); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
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
            <div class="card divPrint">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        Rapport d'exploitation
                        <?php if(request('date_debut') || request('date_fin') || request('categorie_depense')): ?>
                            du
                            <?php if(request('date_debut')): ?>
                                <?php echo e(\Carbon\Carbon::parse(request('date_debut'))->format('d/m/Y')); ?>

                            <?php endif; ?>
                            <?php if(request('date_fin')): ?>
                                au <?php echo e(\Carbon\Carbon::parse(request('date_fin'))->format('d/m/Y')); ?>

                            <?php endif; ?>
                            <?php if(request('categorie_depense')): ?>
                                - Catégorie de dépense :
                                <?php echo e($categories_depense->where('id', request('categorie_depense'))->first()->libelle); ?>

                            <?php endif; ?>
                        <?php endif; ?>
                    </h5>
                </div>
                <div class="card-body ">
                    <div class="table-responsive">
                        <table id="rapport-table" class="display table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Catégorie de dépense</th>
                                    <th>Montant total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $categories_depense; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="table-secondary">
                                        <td><strong><a
                                                    href="<?php echo e(route('rapport.detail', ['categorie_depense' => $categorie->id, 'date_debut' => request('date_debut'), 'date_fin' => request('date_fin')])); ?>" style="text-decoration: none; color: black;"><?php echo e($categorie->libelle); ?></a></strong>
                                        </td>
                                        <td><strong><?php echo e(number_format($depensesParCategorie->get($categorie->libelle, collect())->sum('total_montant'), 0, ',', ' ')); ?>

                                                FCFA</strong></td>
                                    </tr>
                                    <?php $__currentLoopData = $categorie->libelleDepenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $libelle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td style="padding-left: 20px;">- <a
                                                    href="<?php echo e(route('rapport.detail', ['libelle_depense' => $libelle->id, 'categorie_depense' => $categorie->id, 'date_debut' => request('date_debut'), 'date_fin' => request('date_fin')])); ?>" style="text-decoration: none; color: black;"><?php echo e($libelle->libelle); ?></a>
                                            </td>
                                            <td><?php echo e(number_format($depensesParCategorie->get($categorie->libelle, collect())->where('libelle_depense_id', $libelle->id)->sum('total_montant'),0,',',' ')); ?>

                                                FCFA</td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot>
                                <tr class="table-dark">
                                    <td><strong>Total des dépenses</strong></td>
                                    <td><strong><?php echo e(number_format($totalDepenses, 0, ',', ' ')); ?> FCFA</strong></td>
                                </tr>
                                <div class="row">
                                    <tr class="table-info">
                                        <td><strong>Total des ventes</strong></td>
                                        <td><strong><?php echo e(number_format($totalVentes, 0, ',', ' ')); ?> FCFA</strong>
                                        </td>
                                    </tr>

                                    <?php $__currentLoopData = $dataParFamille; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $famille => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td style="padding-left: 20px;">- <?php echo e($famille); ?></td>
                                            <td><strong><?php echo e(number_format($data['ventes'], 0, ',', ' ')); ?> FCFA</strong>
                                            </td>
                                        </tr>
                                        
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="table-success">
                                        <td><strong>Bénéfice</strong></td>
                                        <td><strong><?php echo e(number_format($benefice, 0, ',', ' ')); ?> FCFA</strong></td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td><strong>Ratio bénéfice/ventes</strong></td>
                                        <td><strong><?php echo e(number_format($ratio, 2)); ?>%</strong></td>
                                    </tr>
                                    
                                </div>


                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
            <button id="btnImprimer" class="w-100"><i class="ri ri-printer-fill"></i></button>
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

    

    <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>


    <script>
        $(document).ready(function() {
            // Fonction pour imprimer le rapport
            function imprimerRapport() {
                // Créer une nouvelle fenêtre pour l'impression
                var fenetreImpression = window.open('', '_blank');

                // Contenu à imprimer
                var contenuImprimer = `
                    <html>
                        <head>
                            <title style="text-align: center;">Compte exploitation</title>
                            <style>
                                body { font-family: Arial, sans-serif; }
                                table { width: 100%; border-collapse: collapse; }
                                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                                th { background-color: #f2f2f2; }
                            </style>
                        </head>
                        <body>
                            <h2 style="text-align: center;">Compte exploitation</h2>
                            ${$('.divPrint').html()}
                            <footer style="position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 12px; margin-top: 20px;">
                                <p>Imprimé le : ${new Date().toLocaleString()} par <?php echo e(Auth::user()->first_name); ?></p>
                            </footer>
                        </body>
                    </html>
                `;

                // Écrire le contenu dans la nouvelle fenêtre
                fenetreImpression.document.write(contenuImprimer);

                // Fermer le document
                fenetreImpression.document.close();

                // Imprimer la fenêtre
                fenetreImpression.print();
            }

            // Ajouter un bouton d'impression
            $('#btnImprimer')
                .text('Imprimer le Rapport')
                .addClass('btn btn-primary mt-3')
                .on('click', imprimerRapport);
            // .appendTo('.divPrint');
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/rapport/exploitation.blade.php ENDPATH**/ ?>