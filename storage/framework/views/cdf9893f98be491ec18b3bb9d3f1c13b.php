<!-- Danger Alert -->
<?php if($Msg = Session::get('error')): ?>
    <div class="alert alert-danger alert-top-border alert-dismissible fade show" role="alert">
    <i class="ri-error-warning-line me-3 align-middle fs-16 text-danger"></i><strong> <?php echo e($Msg); ?> </strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>





<?php /**PATH C:\laragon\www\admin\Laravel\master\resources\views/backend/components/alertMessage.blade.php ENDPATH**/ ?>