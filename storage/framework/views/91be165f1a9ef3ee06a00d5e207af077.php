

<?php $__env->startSection('content'); ?>


    <?php $__env->startComponent('backend.components.breadcrumb'); ?>
        <link href="<?php echo e(URL::asset('build/libs/dropzone/dropzone.css')); ?>" rel="stylesheet">

        <?php $__env->slot('li_1'); ?>
            Stock
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Faire un inventaire
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Créer une nouvelle vente</h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('vente.store')); ?>" method="POST" id="venteForm">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="client_id">Client</label>
                            <select name="client_id" id="client_id" class="form-control select2" required>
                                <option value="">Sélectionnez un client</option>
                                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($client->id); ?>"><?php echo e($client->nom); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="produit_id">Produit</label>
                            <select name="produit_id" id="produit_id" class="form-control select2">
                                <option value="">Sélectionnez un produit</option>
                                <?php $__currentLoopData = $produits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($produit->id); ?>" data-prix="<?php echo e($produit->prix); ?>" data-stock="<?php echo e($produit->stock); ?>"><?php echo e($produit->nom); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div id="produitInfo" style="display: none;">
                            <p>Prix: <span id="prixProduit"></span></p>
                            <p>Stock disponible: <span id="stockProduit"></span></p>
                            <div class="form-group">
                                <label for="quantite">Quantité</label>
                                <input type="number" name="quantite" id="quantite" class="form-control" min="1">
                            </div>
                            <button type="button" id="ajouterProduit" class="btn btn-primary">Ajouter</button>
                        </div>

                        <table class="table mt-3" id="produitTable">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Prix unitaire</th>
                                    <th>Quantité</th>
                                    <th>Sous-total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3">Total</th>
                                    <th id="totalVente">0</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>

                        <button type="submit" class="btn btn-success mt-3">Enregistrer la vente</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        let produits = [];

        $('#produit_id').change(function() {
            let produitId = $(this).val();
            if (produitId) {
                let option = $(this).find('option:selected');
                let prix = option.data('prix');
                let stock = option.data('stock');
                $('#prixProduit').text(prix);
                $('#stockProduit').text(stock);
                $('#produitInfo').show();
            } else {
                $('#produitInfo').hide();
            }
        });

        $('#ajouterProduit').click(function() {
            let produitId = $('#produit_id').val();
            let produitNom = $('#produit_id option:selected').text();
            let prix = parseFloat($('#prixProduit').text());
            let quantite = parseInt($('#quantite').val());
            let stock = parseInt($('#stockProduit').text());

            if (produitId && quantite && quantite <= stock) {
                if (!produits.some(p => p.id === produitId)) {
                    let sousTotal = prix * quantite;
                    produits.push({id: produitId, nom: produitNom, prix: prix, quantite: quantite, sousTotal: sousTotal});
                    updateTable();
                    $('#produit_id').val('').trigger('change');
                    $('#quantite').val('');
                    $('#produitInfo').hide();
                } else {
                    alert('Ce produit a déjà été ajouté.');
                }
            } else {
                alert('Veuillez sélectionner un produit et entrer une quantité valide.');
            }
        });

        function updateTable() {
            let tbody = $('#produitTable tbody');
            tbody.empty();
            let total = 0;
            produits.forEach((produit, index) => {
                tbody.append(`
                    <tr>
                        <td>${produit.nom}</td>
                        <td>${produit.prix}</td>
                        <td>${produit.quantite}</td>
                        <td>${produit.sousTotal}</td>
                        <td><button type="button" class="btn btn-danger btn-sm supprimerProduit" data-index="${index}">Supprimer</button></td>
                    </tr>
                `);
                total += produit.sousTotal;
            });
            $('#totalVente').text(total);
        }

        $(document).on('click', '.supprimerProduit', function() {
            let index = $(this).data('index');
            produits.splice(index, 1);
            updateTable();
        });

        $('#venteForm').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serializeArray();
            formData.push({name: 'produits', value: JSON.stringify(produits)});
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                success: function(response) {
                    alert('Vente enregistrée avec succès');
                    window.location.href = '<?php echo e(route("vente.index")); ?>';
                },
                error: function(xhr) {
                    alert('Une erreur est survenue');
                }
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/vente/create.blade.php ENDPATH**/ ?>