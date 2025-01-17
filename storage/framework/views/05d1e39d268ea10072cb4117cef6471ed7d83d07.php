
<?php $__env->startSection('contentheader_title','Countries'); ?>
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
            <div class="pull-left">
                
            </div>
            <div class="pull-right mb-2">                               
                <a class="btn btn-success" href="<?php echo e(route('countries.create')); ?>"> Create New</a>               
            </div>
        </div>
    </div>
   
    <?php if($message = Session::get('success')): ?>
        <div class="alert alert-success">
            <p><?php echo e($message); ?></p>
        </div>
    <?php endif; ?>

    <table class="table table-bordered">
        <tr>
            <th>COUNTRY</th>   
            <th>Labour Rate</th>
            <th>Equipment Rate</th>
            <th>Material Rate</th>
            <th>Action</th>
        </tr>
        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($country->country_name); ?></td>
            <td><?php echo e($country->labour_rate); ?></td>
            <td><?php echo e($country->equipment_rate); ?></td>
            <td><?php echo e($country->material_rate); ?></td>
            <td>
                <form action="<?php echo e(route('countries.destroy',$country->id)); ?>" method="POST">                    
                    <a class="btn btn-primary" href="<?php echo e(route('countries.edit',$country->id)); ?>">Edit</a>
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
  
    <?php echo $countries->links(); ?>

   
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gdomqnh9pbj7/public_html/admin1/resources/views/countries/index.blade.php ENDPATH**/ ?>