
<?php $__env->startSection('contentheader_title'); ?>
Resource Component Add
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
   
<form action="<?php echo e(route('resource_components.copydata')); ?>" method="POST">
    <?php echo csrf_field(); ?> 
    <input type="hidden" name="previous_url" value="<?php echo e(url()->previous()); ?>"> 
    <div class="row">  
        <div class="col-xs-6 col-sm-6 col-md-6"> 
        <div class="card"> 
            <div class="card-body">                                      
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Component ID:</strong>
                        <input type="text" name="component_id" value="<?php echo e($resource_component->component_id); ?>" class="form-control" >
                    </div>
                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Resource Type:</strong>
                        <input type="text" name="resource_type" value="<?php echo e($resource_component->resource_type); ?>" class="form-control" >
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Category:</strong>
                        <select name="category" id="" class="form-control">
                            
                            <option value="Preliminries"<?php if($resource_component->category == 'Preliminries'): ?> selected <?php endif; ?>>Preliminries</option>
                            <option value="Labour"<?php if($resource_component->category == 'Labour'): ?> selected <?php endif; ?>>Labour</option>
                            <option value="Equipment"<?php if($resource_component->category == 'Equipment'): ?> selected <?php endif; ?>>Equipment</option>
                            <option value="Material"<?php if($resource_component->category == 'Material'): ?> selected <?php endif; ?>>Material</option>
                        </select>
                    </div>
                </div>

                

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Unit:</strong>
                        <input type="text" name="unit" value="<?php echo e($resource_component->unit); ?>" class="form-control" >
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Rate:</strong>
                        <input type="number" name="rate" value="<?php echo e($resource_component->orignal_rate); ?>" class="form-control" >
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Country:</strong>
                        <select name="country" id="" class="form-control">
                            <option value="">Please select country</option>
                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option <?php echo e($country->id == $resource_component->country ? 'selected' : ""); ?> value="<?php echo e($country->id); ?>"><?php echo e($country->country_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                            
                        </select>
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gdomqnh9pbj7/public_html/admin1/resources/views/components/copy.blade.php ENDPATH**/ ?>