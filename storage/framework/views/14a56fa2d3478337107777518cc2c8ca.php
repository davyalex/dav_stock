<div class="header-middle">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-12 col-sm-4">
                <div class="logo">
                    <?php if($setting !=null): ?>
                    <a href="<?php echo e(route('accueil')); ?>">
                        <img alt="" src="<?php echo e(URL::asset($setting->getFirstMediaUrl('logo_header'))); ?>" alt=""  width="50">
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-9 col-md-8 col-12 col-sm-8">
                <div class="header-middle-right f-right">
                    
                    
                    <div class="header-cart">
                        <a href="<?php echo e(route('panier')); ?>">
                            <div class="header-icon-style">
                                <i class="icon-handbag icons"></i>
                                <span class="count-style totalQuantity"><?php echo e(Session::get('totalQuantity') ?? '0'); ?></span>
                            </div>
                            <div class="cart-text">
                                <span class="digit">Mon panier</span>
                                <span class="cart-digit-bold totalPrice"><?php echo e(Session::get('totalPrice') ?? '0'); ?> FCFA</span>
                            </div>
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\restaurant\resources\views/site/layouts/topbar2.blade.php ENDPATH**/ ?>