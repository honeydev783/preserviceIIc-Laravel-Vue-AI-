<div class="bg-light border-right" id="sidebar-wrapper">
    <div class="sidebar-heading" style="width:230px !important">
        <img src="<?php echo e(asset('images/logo.jpeg')); ?>" style="width:100%">
        <img src="<?php echo e(asset('images/logo-1.jpg')); ?>" style="width:40%">
    </div>
    <div class="list-group list-group-flush">       
        <div class="sidebar sidebar-light"> 
        <ul class="list-unstyled">
            <li class="<?php echo e(strpos(Route::currentRouteName(),'dashboard') !== false ? 'active' : ''); ?>">
                <a href="<?php echo e(route('dashboard')); ?>" class="">
                    <i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>
            <?php if(Auth::user()->role == 1): ?>
                <li class="<?php echo e(strpos(Route::currentRouteName(),'settings') !== false ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('settings')); ?>" class="">
                        <i class="fas fa-list-alt"></i> Settings</a>
                </li> 
                <li class="<?php echo e(strpos(Route::currentRouteName(),'categories') !== false ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('categories.index')); ?>" class="">
                        <i class="fas fa-list-alt"></i> Category</a>
                </li> 
                <li>
                    <a class="nav-link" data-toggle="collapse" href="#countries-layouts-requests"
                        aria-expanded="<?php echo e(strpos(Route::currentRouteName(), 'detail_estimate') !== false ? 'false' : ''); ?>              
                   <?php echo e(strpos(Route::currentRouteName(), 'approx_estimate') !== false ? 'false' : ''); ?>"
                        aria-controls="countries-layouts-requests">
                        <i class="fas fa-globe"></i> Countries
                    </a>
                    <div class="collapse non-padding <?php echo e(strpos(Route::currentRouteName(), 'detail_estimate') !== false ? 'show' : ''); ?>             
                <?php echo e(strpos(Route::currentRouteName(), 'approx_estimate') !== false ? 'show' : ''); ?>"
                        id="countries-layouts-requests">
                        <ul class="list-unstyled">
                            <li
                                class="<?php echo e(strpos(Route::currentRouteName(), 'detail_estimate') !== false ? 'active' : ''); ?>">
                                <a class="submenu" href="<?php echo e(route('detail_estimate.index')); ?>">
                                    <i class="fas fa-info-circle"></i> Detail Estimate
                                </a>
                            </li>
                            <li
                                class="<?php echo e(strpos(Route::currentRouteName(), 'approx_estimate') !== false ? 'active' : ''); ?>">
                                <a class="submenu" href="<?php echo e(route('approx_estimate.index')); ?>">
                                    <i class="fas fa-calendar-alt"></i> Approx Estimate
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                                       
                <li>
                    <a class="nav-link"  data-toggle="collapse" href="#main-entries-layouts-requests" 
                    aria-expanded="<?php echo e(strpos(Route::currentRouteName(),'low_concrete') !== false ?'false':''); ?>              
                    <?php echo e(strpos(Route::currentRouteName(),'high_concrete') !== false ?'false':''); ?>

                    <?php echo e(strpos(Route::currentRouteName(),'high_commercial') !== false ?'false':''); ?>

                    <?php echo e(strpos(Route::currentRouteName(),'low_commercial') !== false ?'false':''); ?>

                    <?php echo e(strpos(Route::currentRouteName(),'ware_house') !== false ?'false':''); ?>" 
                    aria-controls="main-entries-layouts-requests"> 
                    <i class="fas fa-folder"></i> Approx Main Entries</a>
                    <div class="collapse non-padding <?php echo e(strpos(Route::currentRouteName(),'low_concrete') !== false ?'show':''); ?>             
                    <?php echo e(strpos(Route::currentRouteName(),'high_concrete') !== false ?'show':''); ?>

                    <?php echo e(strpos(Route::currentRouteName(),'high_commercial') !== false ?'show':''); ?>

                    <?php echo e(strpos(Route::currentRouteName(),'low_commercial') !== false ?'show':''); ?>

                    <?php echo e(strpos(Route::currentRouteName(),'ware_house') !== false ?'show':''); ?>" id="main-entries-layouts-requests">
                        <ul class="list-unstyled">

                            <!-- <li class="<?php echo e(strpos(Route::currentRouteName(),'low_concrete') !== false ? 'active' : ''); ?>">
                                <a class="submenu" href="<?php echo e(route('low_concrete.index')); ?>">
                                    <i class="fas fa-file"></i> Building Low End Concrete Dwelling</a>
                            </li>

                            <li class="<?php echo e(strpos(Route::currentRouteName(),'high_concrete') !== false ? 'active' : ''); ?>">
                                <a class="submenu" href="<?php echo e(route('high_concrete.index')); ?>">
                                    <i class="fas fa-file"></i> Building High End Concrete Dwelling</a>
                            </li>

                            <li class="<?php echo e(strpos(Route::currentRouteName(),'low_commercial') !== false ? 'active' : ''); ?>">
                                <a class="submenu" href="<?php echo e(route('low_commercial.index')); ?>">
                                    <i class="fas fa-file"></i> Building Low End Commercial Offices</a>
                            </li>

                            <li class="<?php echo e(strpos(Route::currentRouteName(),'high_commercial') !== false ? 'active' : ''); ?>">
                                <a class="submenu" href="<?php echo e(route('high_commercial.index')); ?>">
                                    <i class="fas fa-file"></i> Building High End Commercial Offices</a>
                            </li>

                            <li class="<?php echo e(strpos(Route::currentRouteName(),'ware_house') !== false ? 'active' : ''); ?>">
                                <a class="submenu" href="<?php echo e(route('ware_house.index')); ?>">
                                    <i class="fas fa-file"></i> Building Ware House</a>
                            </li> -->
                            <?php $menus = getMenus(); 
                                foreach($menus as $menu)
                                { ?>
                                    <li class="<?php echo e(strpos(Route::currentRouteName(),$menu->url) !== false ? 'active' : ''); ?>">
                                        <a class="submenu" href="<?php echo e(route($menu->url.'.index')); ?>">
                                        <i class="fas fa-file"></i> Building <?php echo e($menu->menu_name); ?></a>
                                    </li>
                            <?php }
                            ?>
                            <li class="<?php echo e(strpos(Route::currentRouteName(),'add-menu') !== false ? 'active' : ''); ?>">
                                <a class="submenu" href="<?php echo e(route('add-menu')); ?>">
                                    <i class="fas fa-plus"></i> Add</a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="<?php echo e(strpos(Route::currentRouteName(),'job_activities') !== false ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('job_activities.index')); ?>" class="">
                        <i class="fas fa-address-card"></i> Job Activities</a>
                </li>
                <!-- <li class="<?php echo e(strpos(Route::currentRouteName(),'resource_components') !== false ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('resource_components.index')); ?>" class="">
                        <i class="fas fa-address-card"></i> Resource Components</a>
                </li> -->

                <li>
                    <a class="nav-link"  data-toggle="collapse" href="#country" 
                    aria-expanded="<?php echo e(strpos(Route::currentRouteName(),'resource_components') !== false ?'false':''); ?>" 
                    aria-controls="country"> 
                    <i class="fas fa-folder"></i> Resource Components</a>
                    <div class="collapse non-padding <?php echo e(strpos(Route::currentRouteName(),'resource_components') !== false ?'show':''); ?>" id="country">
                        <ul class="list-unstyled">
                            <?php 
                                $param1 = \Request::segment(1); 
                                $param = \Request::segment(3);
                            ?>
                            <li class="<?php if(!empty($param1) && $param1 == 'resource_components' && empty($param)) echo 'active' ?>">
                                <a class="submenu" href="<?php echo e(route('resource_components.index')); ?>">
                                <i class="fas fa-file"></i> Master Resource Components</a>
                            </li>
                            <?php $countrys = getCountrys();                             
                            // echo '<pre>'; print_r($param);
                                foreach($countrys as $country)
                                { ?>
                                    <li class="<?php if(!empty($param) && $param == base64_encode($country->id)) echo 'active'; ?>">
                                        <a class="submenu" href="<?php echo e(route('resource_components.country', base64_encode($country->id))); ?>">
                                        <i class="fas fa-file"></i> <?php echo e($country->country_name); ?></a>
                                    </li>
                            <?php }
                            ?>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>
            <li class="<?php echo e(strpos(Route::currentRouteName(),'cost-estimate.form') !== false ? 'active' : ''); ?>">
                <a href="<?php echo e(route('cost-estimate.form')); ?>" class="">
                    <i class="fas fa-file-invoice-dollar"></i> Approx Estimate Form</a>                    
            </li>
            <li class="<?php echo e(strpos(Route::currentRouteName(),'detail-estimate.form') !== false ? 'active' : ''); ?>">
                <a href="<?php echo e(route('detail-estimate.form')); ?>" class="">
                    <i class="fas fa-file-invoice-dollar"></i> Detail Estimate Form</a>                    
            </li>
            <li class="<?php echo e(strpos(Route::currentRouteName(),'approx_form_list') !== false ? 'active' : ''); ?>">
                <a href="<?php echo e(route('approx_form_list')); ?>" class="">
                    <i class="fas fa-file-invoice-dollar"></i> Approx Estimate Saved List</a>                    
            </li>
            <li class="<?php echo e(strpos(Route::currentRouteName(),'detail_form_list') !== false ? 'active' : ''); ?>">
                <a href="<?php echo e(route('detail_form_list')); ?>" class="">
                    <i class="fas fa-file-invoice-dollar"></i> Detail Estimate Saved List</a>                    
            </li>
            <li class="<?php echo e(strpos(Route::currentRouteName(),'demo') !== false ? 'active' : ''); ?>">
                <a href="<?php echo e(route('demo')); ?>" class="">
                    <i class="fas fa-file"></i> Demo</a>                    
            </li>
        </ul> 
        </div>   
    </div>
</div>
 <?php /**PATH E:\Robert\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>