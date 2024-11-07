<!-- Liens Flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


<div class="modal fade" id="dateSessionVenteModal" tabindex="-1" aria-labelledby="dateSessionVenteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dateSessionVenteModalLabel">Sélectionnez la date de la session de vente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" action="<?php echo e(route('vente.session-date')); ?>" method="POST" novalidate>
            <div class="modal-body">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label for="dateSessionVente" class="col-form-label">Date:</label>
                        <?php
                        $sessionDate = Session::get('session_date', 'Non définie')
                   ?>
                        <input type="date" value="<?php echo e($sessionDate); ?>"  name="session_date" class="form-control" id="dateSessionVente" required>
                        <!-- type="text" pour Flatpickr -->
                    </div>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>

        </form>
        </div>
    </div>
</div>





<?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/vente/dateSessionVente.blade.php ENDPATH**/ ?>