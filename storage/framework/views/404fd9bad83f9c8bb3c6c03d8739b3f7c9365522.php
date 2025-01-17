
<?php $__env->startSection('contentheader_title'); ?>
Countries Create
<?php $__env->stopSection(); ?> 
<?php $__env->startSection('styles'); ?>
<style>
    .pull-right{
        float: right;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
 
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
   
<form action="<?php echo e(route('countries.store')); ?>" method="POST">
    <?php echo csrf_field(); ?> 
    <div class="row">  
        <div class="col-xs-6 col-sm-6 col-md-6"> 
            <div class="card"> 
                <div class="card-body">                                      
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Country Name:</strong>
                            <input type="text" name="country_name" value="<?php echo e(old('country_name')); ?>" class="form-control" >
                        </div>
                    </div> 
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Labour Rate:</strong>
                            <input type="number" name="labour_rate" value="<?php echo e(old('labour_rate')); ?>" class="form-control" min="0">
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Equipment Rate:</strong>
                            <input type="number" name="equipment_rate" value="<?php echo e(old('equipment_rate')); ?>" class="form-control" min="0">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Material Rate:</strong>
                            <input type="number" name="material_rate" value="<?php echo e(old('material_rate')); ?>" class="form-control" min="0">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>      
                </div>
            <div> 
        </div> 
    </div> 
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gdomqnh9pbj7/public_html/admin.globalpreservicesllc.com/resources/views/countries/create.blade.php ENDPATH**/ ?>