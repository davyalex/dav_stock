
<?php $__env->startSection('title'); ?>
    Détails de la commande
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
            Gestion des commandes
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Détails de la commande
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class=" p-3  mb-3">
                    <h6 class="text-muted">Détails de la commande</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>N° commande :</strong> #<?php echo e($commande->code); ?></p>
                            <p><strong>Date :</strong> <?php echo e($commande->created_at->format('d/m/Y à H:i')); ?></p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Client :</strong> <?php echo e($commande->client->first_name); ?>

                                <?php echo e($commande->client->last_name); ?></p>
                            <p><strong>Téléphone :</strong> <?php echo e($commande->client->phone); ?></p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Mode de livraison :</strong> <?php echo e($commande->mode_livraison); ?></p>
                            <p><strong>Adresse de livraison :</strong> <?php echo e($commande->adresse_livraison ?? 'Chez jeanne'); ?>

                            </p>
                            <p><strong>Mode de paiement :</strong> <?php echo e($commande->mode_paiement); ?></p>

                        </div>
                    </div>
                </div>
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Produits de la commande</h5>


                    <?php if(auth()->user()->hasRole('caisse')): ?>
                        <div class="d-flex justify-content-end mt-3">
                            

                            <button type="button" class="btn btn-info me-2 btnImprimerTicket" onclick="imprimerFacture()">
                                <i class="ri-printer-line align-bottom me-1"></i> Imprimer la facture
                            </button>
                            <select class="form-select w-auto" data-commande="<?php echo e($commande->id); ?>"
                                onchange="changerStatut(this)" <?php echo e($commande->statut == 'livrée' ? 'disabled' : ''); ?>>
                                <option value="">Changer le statut</option>
                                <?php if($commande->statut == 'annulée' || ($commande->statut != 'confirmée' && $commande->statut != 'livrée')): ?>
                                    <option value="en attente" <?php echo e($commande->statut == 'en attente' ? 'selected' : ''); ?>>En
                                        attente</option>
                                    <option value="confirmée" <?php echo e($commande->statut == 'confirmée' ? 'selected' : ''); ?>>
                                        Confirmée</option>
                                    <option value="livrée" <?php echo e($commande->statut == 'livrée' ? 'selected' : ''); ?>>Livrée
                                    </option>
                                    <option value="annulée" <?php echo e($commande->statut == 'annulée' ? 'selected' : ''); ?>>Annulée
                                    </option>
                                <?php elseif($commande->statut == 'confirmée' || $commande->statut == 'livrée'): ?>
                                    <option value="livrée" <?php echo e($commande->statut == 'livrée' ? 'selected' : ''); ?>>Livrée
                                    </option>
                                    <option value="annulée" <?php echo e($commande->statut == 'annulée' ? 'selected' : ''); ?>>Annulée
                                    </option>
                                <?php endif; ?>
                            </select>

                        </div>
                    <?php endif; ?>

                </div>


                <div class="card-body">
                    <div class="table-responsive">
                        <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Nom du produit</th>
                                    <th>Quantité</th>
                                    <th>Prix unitaire</th>
                                    <th>Montant total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $commande->produits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr id="row_<?php echo e($item['id']); ?>">
                                        <td><?php echo e(++$key); ?></td>
                                        <td>
                                            <img class="rounded avatar-sm"
                                                src="<?php echo e($item->hasMedia('ProduitImage') ? $item->getFirstMediaUrl('ProduitImage') : asset('assets/img/logo/logo_Chez-jeanne.jpg')); ?>"
                                                width="50px" alt="<?php echo e($item['nom']); ?>">
                                        </td>
                                        <td><?php echo e($item['nom']); ?></td>
                                        <td><?php echo e($item['pivot']['quantite']); ?></td>
                                        <td><?php echo e(number_format($item['pivot']['prix_unitaire'], 0, ',', ' ')); ?> FCFA</td>
                                        <td><?php echo e(number_format($item['pivot']['quantite'] * $item['pivot']['prix_unitaire'], 0, ',', ' ')); ?>

                                            FCFA</td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php $__currentLoopData = $commande->plats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr id="row_<?php echo e($item['id']); ?>">
                                        <td>
                                            <span class="badge bg-primary">Commande depuis Menu</span>
                                        </td>
                                        <td>
                                            <img class="rounded avatar-sm"
                                                src="<?php echo e($item->hasMedia('ProduitImage') ? $item->getFirstMediaUrl('ProduitImage') : asset('assets/img/logo/logo_Chez-jeanne.jpg')); ?>"
                                                width="50px" alt="<?php echo e($item['nom']); ?>">
                                        </td>
                                        <td> <b><?php echo e($item['nom']); ?></b>

                                            <?php if($item['pivot']['garniture']): ?>
                                                <ul>
                                                    <li>Garniture: <?php echo e($item['pivot']['garniture']); ?></li>
                                                </ul>
                                            <?php endif; ?>
                                            <?php if($item['pivot']['complement']): ?>
                                                <ul>
                                                    <li>Complément: <?php echo e($item['pivot']['complement']); ?></li>
                                                </ul>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($item['pivot']['quantite']); ?></td>
                                        <td><?php echo e(number_format($item['pivot']['prix_unitaire'], 0, ',', ' ')); ?> FCFA</td>
                                        <td><?php echo e(number_format($item['pivot']['quantite'] * $item['pivot']['prix_unitaire'], 0, ',', ' ')); ?>

                                            FCFA</td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end"><strong>Total de la commande:</strong></td>
                                    <td><strong><?php echo e(number_format($commande->montant_total, 0, ',', ' ')); ?> FCFA</strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>


            <!-- ========== Start facture generé ========== -->


            <div class="ticket-container col-8 m-auto"
                style="font-family: 'Courier New', monospace; font-size: 12px; width: 350px;">
                <div class="ticket-header" style="text-align: center;">
                    <h3>CHEZ JEANNE</h3>
                    <h4>RESTAURANT LOUNGE</h4>
                    <h5>AFRICAIN ET EUROPEEN</h5>
                    <p>-------------------------------</p>
                    <div style="display: flex; justify-content: space-between; padding: 0 10px;">
                        <span><strong>Commande:</strong> #<?php echo e($commande->code); ?></span>
                        <span><strong>Date:</strong> <?php echo e($commande->created_at->format('d/m/Y à H:i')); ?></span>
                    </div>
                </div>
                <div class="ticket-info" style="padding: 0 10px;">


                    <div style="display: flex; justify-content: space-between;">
                        <span><strong>Caisse:</strong> <?php echo e(Auth::user()->caisse->libelle ?? 'Non définie'); ?></span>
                        <span><strong>Caissier:</strong> <?php echo e(Auth::user()->first_name); ?>

                            <?php echo e(Auth::user()->last_name); ?></span>
                    </div>
                </div>
                <p style="text-align: center;">-------------------------------</p>
                <div class="ticket-products">
                    <table style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Designation</th>
                                <th>Qté</th>
                                <th>P.U.</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $commande->produits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($produit->nom); ?></td>
                                    <td><?php echo e($produit->pivot->quantite); ?></td>
                                    <td><?php echo e(number_format($produit->pivot->prix_unitaire, 0, ',', ' ')); ?></td>
                                    <td><?php echo e(number_format($produit->pivot->quantite * $produit->pivot->prix_unitaire, 0, ',', ' ')); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php $__currentLoopData = $commande->plats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($plat->nom); ?>

                                     
                                        <span>
                                            <?php if($plat['pivot']['garniture']): ?>
                                                <ul>
                                                    <li>Garniture: <?php echo e($plat['pivot']['garniture']); ?></li>
                                                </ul>
                                            <?php endif; ?>
                                            <?php if($plat['pivot']['complement']): ?>
                                                <ul>
                                                    <li>Complément: <?php echo e($plat['pivot']['complement']); ?></li>
                                                </ul>
                                            <?php endif; ?>
                                        </span>
                                    </td>
                                    <td><?php echo e($plat->pivot->quantite); ?></td>
                                    <td><?php echo e(number_format($plat->pivot->prix_unitaire, 0, ',', ' ')); ?></td>
                                    <td><?php echo e(number_format($plat->pivot->quantite * $plat->pivot->prix_unitaire, 0, ',', ' ')); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tfoot>
                            <tr>
                                <th colspan="3" style="text-align: right;">Total:</th>
                                <th><?php echo e(number_format($commande->montant_total, 0, ',', ' ')); ?> FCFA</th>
                            </tr>
                        </tfoot>
                        </tbody>
                    </table>
                </div>


                <p style="text-align: center;">-------------------------------</p>

                

                <div class="col-md-12 m-auto">
                    <span><strong>Nom du client:</strong> <?php echo e($commande->client->first_name); ?>

                        <?php echo e($commande->client->last_name); ?></span><br>
                    <span><strong>Contact du client:</strong> <?php echo e($commande->client->phone); ?></span><br>
                    <span><strong>mode de livraison:</strong> <?php echo e($commande->mode_livraison); ?></span><br>
                    <span><strong>Adresse de livraison:</strong>
                        <?php echo e($commande->adresse_livraison ?? 'Au restaurant'); ?></span>

                </div>

                <p style="text-align: center;">-------------------------------</p>

                <div class="ticket-footer" style="text-align: center;">
                    <p>MERCI DE VOTRE VISITE</p>
                    <p>AU REVOIR ET A BIENTÔT</p>
                    <p>RESERVATIONS: 07-49-88-95-18</p>
                    <p>A BIENTÔT</p>
                </div>
            </div>


            <script>
                function imprimerFacture() {
                    var ticketContent = document.querySelector('.ticket-container').innerHTML;
                    var win = window.open('', '', 'height=700,width=700');
                    win.document.write('<html><head><title>Facture de commande</title></head><body>');
                    win.document.write(ticketContent);
                    win.document.write('</body></html>');
                    win.document.close();
                    win.print();
                }
            </script>
            <!-- ========== End facture generé ========== -->

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="<?php echo e(URL::asset('build/js/pages/datatables.init.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>


    <script>
        function changerStatut(selectElement) {
            // Récupérer la valeur du statut sélectionné et l'ID de la commande
            var statut = $(selectElement).val();
            var commandeId = $(selectElement).data('commande');

            $.ajax({
                url: "<?php echo e(route('commande.statut')); ?>",
                type: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    statut: statut,
                    commandeId: commandeId // Assurez-vous que ce paramètre est utilisé dans la route
                },
                success: function(response) {
                    if (response.success) {
                        // Mettre à jour l'interface utilisateur si nécessaire
                        Swal.fire({
                            title: 'Succès!',
                            text: 'Le statut a été mis à jour avec succès',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        location.reload(); // Recharger la page pour afficher les changements
                    } else {
                        alert('Une erreur est survenue lors de la mise à jour du statut');
                    }
                },
                error: function() {
                    alert('Une erreur est survenue lors de la communication avec le serveur');
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/vente/commande/show.blade.php ENDPATH**/ ?>