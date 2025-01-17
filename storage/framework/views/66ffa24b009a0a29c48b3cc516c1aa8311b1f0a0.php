<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title>COST ESTIMATION FORM</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">         
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/2.8.0/css/flag-icon.min.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script>
        jQuery(document).ready(function($){
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
            });
            $('#navbarDropdown').click(function(e){
                e.preventDefault();
                $(e).addclass('show');                
            })
        })
        </script>
        <style>
            body {
            overflow-x: hidden;
            }
            #sidebar-wrapper {
                min-height: 100vh;
                margin-left: -230px;
                -webkit-transition: margin .25s ease-out;
                -moz-transition: margin .25s ease-out;
                -o-transition: margin .25s ease-out;
                transition: margin .25s ease-out;
            }
            #sidebar-wrapper .sidebar-heading {
                padding: 0.875rem 1.25rem;
                font-size: 1.2rem;
            }
            #sidebar-wrapper .list-group {
                width: 230px;
            }
            #page-content-wrapper {
                min-width: 100vw;
            }
            #wrapper.toggled #sidebar-wrapper {
                margin-left: 0;
            }
            @media (min-width: 768px) {
                #sidebar-wrapper {
                    margin-left: 0;
                }
                #page-content-wrapper {
                    min-width: 0;
                    width: 100%;
                }
                #wrapper.toggled #sidebar-wrapper {
                    margin-left: -230px;
                }
            }            
        </style>  
        <link rel="stylesheet" href="<?php echo e(asset('/css/bootadmin.css')); ?>">  
         <?php echo $__env->yieldContent('styles'); ?>
    </head>
    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar -->
            <?php if(!isset($data['sidebar'])): ?>
                <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <!-- /#sidebar-wrapper -->
            <!-- Page Content -->
            <div id="page-content-wrapper">
                <?php if(!isset($data['header'])): ?>
                    <?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
                <div class="container-fluid">
                    <?php echo $__env->make('layouts.flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div class="content p-4" id="app">                    
                        <?php echo $__env->make('layouts.content-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <?php echo $__env->yieldContent('content'); ?>
                    </div>          
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->
    </body>
  

    <script src="<?php echo e(mix('js/app.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.40/moment-timezone.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.40/moment-timezone-with-data.js"></script>
    <script>
    var timezone = "<?php echo e(date_default_timezone_get()); ?>";
    moment.tz.setDefault(timezone);
    function countDown(expire_time){
        
        var current_date = moment();
        var now = current_date.valueOf();
        var expire_time = moment(expire_time);
        var expires = expire_time.valueOf();
        var distance = expires - now;
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        var expire_time = days + "d " + hours + "h "+ minutes + "m " + seconds + "s ";
        if (distance < 0) {
            expire_time = "EXPIRED";
        }
        return expire_time;
    }
    </script>

    <?php echo $__env->yieldContent('scripts'); ?>
</html><?php /**PATH /home3/lobalpx1/public_html/admin/resources/views/layouts/master.blade.php ENDPATH**/ ?>