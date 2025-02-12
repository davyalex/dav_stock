
<?php $__env->startSection('title'); ?>
    Rapport des ventes par catégorie
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
            Rapport des ventes
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Filtres</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('rapport.vente')); ?>" method="GET">
                        <?php echo csrf_field(); ?>
                        <div class="row">

                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="caisse_id" class="form-label">Caisse</label>
                                    <select class="form-select" id="caisse_id" name="caisse_id">
                                        <option value="">Toutes les caisses</option>
                                        <?php $__currentLoopData = $caisses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $caisse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($caisse->id); ?>"
                                                <?php echo e(request('caisse_id') == $caisse->id ? 'selected' : ''); ?>>
                                                <?php echo e($caisse->libelle); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="date_debut" class="form-label">Famille</label>
                                <select class="form-select" id="categorie" name="categorie_famille">
                                    <option value="">Toutes les catégories</option>
                                    <?php $__currentLoopData = $famille; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->famille); ?>"
                                            <?php echo e(request('categorie_famille') == $item->famille ? 'selected' : ''); ?>>
                                            <?php if($item->famille == 'menu'): ?>
                                                Cuisine interne
                                            <?php elseif($item->famille == 'bar'): ?>
                                                Boissons
                                            <?php else: ?>
                                                <?php echo e($item->famille); ?>

                                            <?php endif; ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <option value="plats du menu"  <?php echo e(request('categorie_famille') == 'plats du menu' ? 'selected' : ''); ?>>Menu</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="date_debut" class="form-label">Date de début</label>
                                    <input type="date" class="form-control" id="date_debut" name="date_debut"
                                        value="<?php echo e(request('date_debut')); ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="date_fin" class="form-label">Date de fin</label>
                                    <input type="date" class="form-control" id="date_fin" name="date_fin"
                                        value="<?php echo e(request('date_fin')); ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="statut" class="form-label">Periodes</label>
                                    <select class="form-select" id="periode" name="periode">
                                        <option value="">Toutes les periodes</option>
                                        <?php $__currentLoopData = ['jour' => 'Jour', 'semaine' => 'Semaine', 'mois' => 'Mois', 'annee' => 'Année']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($key); ?>"
                                                <?php echo e(request('periode') == $key ? 'selected' : ''); ?>>
                                                <?php echo e($value); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 mt-4">
                                <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                            </div>
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
                        Rapport des ventes
                        <?php if(request('caisse_id')): ?>
                            <strong> <?php echo e($caisses->find(request('caisse_id'))->libelle); ?></strong>
                        <?php endif; ?>
                        <?php if(request('categorie_famille')): ?>
                            <?php if(request('categorie_famille') == 'bar'): ?>
                                pour les Boissons
                            <?php elseif(request('categorie_famille') == 'menu'): ?>
                                pour la Cuisine interne
                            <?php else: ?>
                                pour <?php echo e(request('categorie_famille')); ?>

                            <?php endif; ?>
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
                        <?php if(request()->has('periode') && request('periode') != null): ?>
                        -
                        <strong><?php echo e(request('periode')); ?></strong>
                    <?php endif; ?>
                    </h5>
                </div>
                <div class="card-body">

                    <?php
                        // Ordre personnalisé pour trier les familles
                        $ordreFamilles = [
                            'menu' => 1, // Cuisine interne en premier
                            'bar' => 2, // Boissons en deuxième
                            'plat_du_menu' => 3, // Plat du menu

                            // Ajoute d'autres familles si nécessaire avec des numéros plus grands
];

// Trier les familles en fonction de l'ordre personnalisé
                        $produitsVendus = $produitsVendus
                            ->groupBy('famille')
                            ->sortBy(function ($produits, $famille) use ($ordreFamilles) {
                                return $ordreFamilles[$famille] ?? 999; // Si la famille n'est pas définie dans l'ordre, elle sera mise à la fin
                            });

                        // Groupe les produits par famille
                        $produitsVendus = $produitsVendus->map(function ($produits, $famille) {
                            return $produits;
                        });
                    ?>
                    <?php $__currentLoopData = $produitsVendus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $famille => $produits): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <h3>
                            <?php if($famille == 'menu'): ?>
                                Cuisine interne
                            <?php elseif($famille == 'bar'): ?>
                                Boissons
                            <?php else: ?>
                                <?php echo e($famille); ?>

                            <?php endif; ?>
                        </h3>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Designation</th>
                                        <th>Catégorie</th>
                                        <th>Quantité vendue</th>
                                        <th>Prix de vente</th>
                                        <th>Montant total</th>
                                        <th>Stock disponible</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $produits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($produit['code']); ?></td>
                                            <td><?php echo e($produit['designation']); ?></td>
                                            <td><?php echo e($produit['categorie']); ?></td>
                                            <td><?php echo e($produit['quantite_vendue']); ?></td>
                                            <td><?php echo e(number_format($produit['prix_vente'], 0, ',', ' ')); ?> FCFA</td>
                                            <td><?php echo e(number_format($produit['montant_total'], 0, ',', ' ')); ?> FCFA</td>
                                            <td><?php echo e($produit['stock']); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="7">
                                            <div class="text-end">
                                                
                                                <div>Nombre d'articles : <?php echo e($produits->sum('quantite_vendue')); ?></div>
                                                <div>Montant total :
                                                    <?php echo e(number_format($produits->sum('montant_total'), 0, ',', ' ')); ?> FCFA
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    
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

    <script src="<?php echo e(URL::asset('build/js/pages/datatables.init.js')); ?>"></script>

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
                            <title style="text-align: center;">Rapport de Vente</title>
                            <style>
                                body { font-family: Arial, sans-serif; }
                                table { width: 100%; border-collapse: collapse; }
                                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                                th { background-color: #f2f2f2; }
                            </style>
                        </head>
                        <body>
                            <h2 style="text-align: center;">Rapport de Vente</h2>
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

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/rapport/vente.blade.php ENDPATH**/ ?>