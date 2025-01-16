
<?php $__env->startSection('Add Menu'); ?>
<?php $__env->stopSection(); ?> 
<?php $__env->startSection('styles'); ?>
<style>
    .pull-right{
        float: right;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-12 margin-tb">       
        <div class="pull-right">            
            <a class="btn btn-primary" href="<?php echo e(route('dashboard')); ?>"> Back</a>                
        </div>
    </div>
</div>
   
<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>
   
<form action="<?php echo e(route('save-menu')); ?>" method="POST">
    <?php echo csrf_field(); ?>  
     <div class="row">        
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>Menu Name</strong>
                <input type="text" name="menu" value="<?php echo e(old('menu')); ?>" class="form-control" required>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>Url Name</strong>
                <input type="text" name="url" value="<?php echo e(old('url')); ?>" class="form-control" required>
            </div>
        </div>        
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <br>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>        
    </div>   
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gdomqnh9pbj7/public_html/admin.globalpreservicesllc.com/resources/views/main_entry/add-menu.blade.php ENDPATH**/ ?>