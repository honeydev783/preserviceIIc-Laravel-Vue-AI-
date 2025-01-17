
<?php $__env->startSection('contentheader_title','Update Rock'); ?>
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
   
<form action="<?php echo e(route('main_entry.updateRock.post',$rock->id)); ?>" method="POST">
    <?php echo csrf_field(); ?>  
     <div class="row">               
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label><strong>Rock Value:</strong>
                <input type="number" step="0.01" name="rock_value" value="<?php echo e($rock->rock_value); ?>" required>
                <input type="hidden" name="category" value="<?php echo e($rock->category); ?>" required>
            </label>
            </div>
        </div>
             
        <div class="col-xs-12 col-sm-12 col-md-12">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>        
    </div>   
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gdomqnh9pbj7/public_html/admin.globalpreservicesllc.com/resources/views/main_entry/update-rock.blade.php ENDPATH**/ ?>