<div class="header-bottom transparent-bar black-bg">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-2 col-md-2 col-sm-2">
                <div class="logo">
                    <?php if($setting != null): ?>
                        <a href="<?php echo e(route('accueil')); ?>">
                            <img alt="" src="<?php echo e(URL::asset($setting->getFirstMediaUrl('logo_header'))); ?>" alt="" width="50">
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7">
                <div class="main-menu">
                    <nav>
                        <ul class="d-flex justify-content-center">
                            <li><a href="<?php echo e(route('accueil')); ?>">Accueil</a></li>
                            <?php $__currentLoopData = $menu_link; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="<?php echo e(route('produit', $menu->slug)); ?>">
                                    <?php if($menu->slug === 'bar'): ?>
                                        Nos boissons
                                    <?php elseif($menu->slug === 'menu'): ?>
                                        Nos plats
                                    <?php else: ?>
                                        <?php echo e($menu->name); ?>

                                    <?php endif; ?>
                                </a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <li><a href="<?php echo e(route('menu')); ?>">Menu du jour</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="header-middle-right d-flex justify-content-end">
                    <div class="header-login px-3 header-cart">
                        <?php if(auth()->guard()->check()): ?>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="icon-user icons text-white"></i>
                                    <span class="text-white">Mon compte</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?php echo e(route('user.profile')); ?>">Mon profil</a></li>
                                    <li><a class="dropdown-item" href="<?php echo e(route('user.commande')); ?>">Mes commandes</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?php echo e(route('user.logout')); ?>">Se déconnecter</a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <a href="<?php echo e(route('user.login')); ?>">
                                <i class="icon-user icons text-white"></i>
                                <span class="text-white">Connexion</span>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="header-cart">
                        <a href="<?php echo e(route('panier')); ?>">
                            <i class="icon-handbag icons text-white"></i>
                            <span class="count-style totalQuantity text-white"><?php echo e(session('cart') ? Session::get('totalQuantity') : '0'); ?></span>
                            <span class="cart-digit-bold totalPrice text-white"><?php echo e(session('cart') ? Session::get('totalPrice') : '0'); ?> FCFA</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\restaurant\Restaurant-chez-jeanne\resources\views/site/layouts/menu_desktop/menu.blade.php ENDPATH**/ ?>