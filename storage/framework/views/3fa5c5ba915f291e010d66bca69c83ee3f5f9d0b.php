<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <button class="btn btn-sm" id="menu-toggle"><span class="navbar-toggler-icon"></span></button>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mt-2 mt-lg-0">
            <li class="nav-item">
                <a href="http://globalprecisionalservicesllc.com/">Home</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">             
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo e(Auth::user()->name); ?>

            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Profile</a>                 
                <div class="dropdown-divider"></div>                
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();
                        this.closest('form').submit();">Log Out</a>
                </form>
            </div>
            </li>
        </ul>
    </div>
</nav><?php /**PATH /home/gdomqnh9pbj7/public_html/admin1/resources/views/layouts/header.blade.php ENDPATH**/ ?>