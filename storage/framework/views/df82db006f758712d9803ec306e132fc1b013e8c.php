
<?php $__env->startSection('contentheader_title'); ?>
<?php echo e(session('title')); ?> Create
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
            <a class="btn btn-primary" href="<?php echo e(route(session::get('index_route_name'))); ?>"> Back</a>                
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
   
<form action="<?php echo e(route(session::get('store_route_name'))); ?>" method="POST">
    <?php echo csrf_field(); ?>  
     <div class="row">        
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>ELEMENT DESCRIPTION:</strong>
                <textarea class="form-control" style="height:150px" name="description"  required><?php echo e(old('description')); ?></textarea>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>ELEMENT CODE:</strong>
                <input type="text" name="element_code" value="<?php echo e(old('element_code')); ?>" class="form-control" required>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>COST / M2 GFA:</strong>
                <input type="number" name="cost_m2" step="0.01" value="<?php echo e(old('cost_m2')); ?>" class="form-control" required>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>UNIT / M2:</strong>
                <input type="text" name="unit_m2" value="<?php echo e(old('unit_m2')); ?>" class="form-control" required>
            </div>
        </div>
        <div class="col-xs-6 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>COST / SF GFA:</strong>
                <input type="number" name="cost_sf" step="0.01" value="<?php echo e(old('cost_sf')); ?>" class="form-control" required>
            </div>
        </div>
        <div class="col-xs-6 col-sm-4= col-md-4">
            <div class="form-group">
                <strong>UNIT / SF:</strong>
                <input type="text" name="unit_sf" value="<?php echo e(old('unit_sf')); ?>" class="form-control" required>
            </div>
        </div>        
        <div class="col-xs-6 col-sm-4= col-md-4">
            <div class="form-group">
                <strong>Country:</strong>
                <select name="country" id="" class="form-control">
                    <option value="">Please select country</option>
                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($country->id); ?>"><?php echo e($country->country_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                            
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>        
    </div>   
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gdomqnh9pbj7/public_html/admin.globalpreservicesllc.com/resources/views/main_entry/create.blade.php ENDPATH**/ ?>