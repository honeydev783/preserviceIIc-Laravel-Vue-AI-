
<?php $__env->startSection('contentheader_title','Update Soil Conditions Value'); ?>
<?php $__env->startSection('styles'); ?>
<style>
    .pull-right{
        float: right;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php if($message = Session::get('success')): ?>
    <div class="alert alert-success">
        <p><?php echo e($message); ?></p>
    </div>
<?php endif; ?>
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
   
<form action="<?php echo e(route('main_entry.updateSoilConditions.post',$soil_condition->id)); ?>" method="POST">
    <?php echo csrf_field(); ?>  
     <div class="row">               
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label><strong>Sandy Soil:</strong>
                    <input type="number" step="0.01" name="sandy_soil" value="<?php echo e($soil_condition->sandy_soil); ?>" required>
                    <input type="hidden" name="category" value="<?php echo e($soil_condition->category); ?>" required>
                </label>
            </div>
            <div class="form-group">
                <label><strong>Loam Soil:</strong>
                    <input type="number" step="0.01" name="loam_soil" value="<?php echo e($soil_condition->loam_soil); ?>" required>                    
                </label>
            </div>
            <div class="form-group">
                <label><strong>Soft Clay Soil:</strong>
                    <input type="number" step="0.01" name="soft_clay_soil" value="<?php echo e($soil_condition->soft_clay_soil); ?>" required>                    
                </label>
            </div>
            <div class="form-group">
                <label><strong>Stiff Clay Soil:</strong>
                    <input type="number" step="0.01" name="stiff_clay_soil" value="<?php echo e($soil_condition->stiff_clay_soil); ?>" required>                    
                </label>
            </div>
            <div class="form-group">
                <label><strong>Hard Soil:</strong>
                    <input type="number" step="0.01" name="hard_soil" value="<?php echo e($soil_condition->hard_soil); ?>" required>                    
                </label>
            </div>
            <div class="form-group">
                <label><strong>Soft Soil:</strong>
                    <input type="number" step="0.01" name="soft_soil" value="<?php echo e($soil_condition->soft_soil); ?>" required>                    
                </label>
            </div>
            <div class="form-group">
                <label><strong>Ordinary Soil:</strong>
                    <input type="number" step="0.01" name="ordinary_soil" value="<?php echo e($soil_condition->ordinary_soil); ?>" required>                    
                </label>
            </div>
        </div>
             
        <div class="col-xs-12 col-sm-12 col-md-12">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>        
    </div>   
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gdomqnh9pbj7/public_html/admin.globalpreservicesllc.com/resources/views/main_entry/update-soil-conditions.blade.php ENDPATH**/ ?>