

<?php $__env->startSection('title', 'Mes commandes'); ?>


<?php $__env->startSection('content'); ?>
  
<div class="row">
<?php $__empty_1 = true; $__currentLoopData = $commandes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$commande): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-12 col-lg-6 mb-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="list-unstyled">
                        <li class=""><h5 class="panel-title"><span> <?php echo e(++$key); ?> </span> <a data-bs-toggle="collapse" data-bs-target="#payment-<?php echo e($commande->id); ?>"> #<?php echo e($commande->code); ?>  </a></h5>
                        </li>
                        <li><i class="px-4 text-lowercase">Date : <?php echo e($commande->date_commande); ?></i></li>

                        <li><i class="px-4 text-lowercase">Statut : <?php echo e($commande->statut); ?></i></li>
                    </ul>
                </div>
                <div id="payment-<?php echo e($commande->id); ?>" class="panel-collapse collapse" data-bs-parent="#faq">
                    <div class="panel-body">
                        <div class="order-review-wrapper">
                            <div class="order-review">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="width-1">Produit</th>
                                                <th class="width-2">prix</th>
                                                <th class="width-3">Qté</th>
                                                <th class="width-4">total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php $__currentLoopData = $commande->produits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                           <tr>
                                            <td>
                                                <div class="o-pro-dec">
                                                    <p> <a href="<?php echo e(route('produit.detail' , $produit->slug)); ?>"><img src="<?php echo e($produit->getFirstMediaUrl('ProduitImage')); ?>" width="50"> <?php echo e($produit->nom); ?></a> </p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="o-pro-price">
                                                    <p><?php echo e($produit->pivot->prix_unitaire); ?></p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="o-pro-qty">
                                                    <p><?php echo e($produit->pivot->quantite); ?></p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="o-pro-subtotal">
                                                    <p><?php echo e($produit->pivot->total); ?></p>
                                                </div>
                                            </td>
                                        </tr>
                                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3">Grand Total</td>
                                                <td colspan="1"> <?php echo e($commande->montant_total); ?> </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <h3>Vous n'avez pas encore passé de commande </h3>
<?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('site.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/site/sections/user-auth/commande.blade.php ENDPATH**/ ?>