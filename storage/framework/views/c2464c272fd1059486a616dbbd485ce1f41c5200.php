<?php 
    use App\Models\Countries;
?>

<?php $__env->startSection('styles'); ?>
<style>
    .pull-right{
        float: right;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contentheader_title'); ?>
<?php echo e(session('title')); ?>

<?php $__env->stopSection(); ?> 
<?php $__env->startSection('action'); ?>
    <a class="btn btn-danger" href="<?php echo e(route('remove', session('category'))); ?>"> Remove</a> 
<?php $__env->stopSection(); ?> 
<?php $__env->startSection('content'); ?>
<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                
            </div>
            <div class="pull-right mb-2">
                <a class="btn btn-primary" href="<?php echo e(route('main_entry.viewSoilConditions')); ?>"> Soil Conditions</a>                 
                <a class="btn btn-danger" href="<?php echo e(route('main_entry.viewRock')); ?>"> Update Rock Value</a> 
                <a class="btn btn-info" href="<?php echo e(route('main_entry.uploadImage')); ?>"> Upload Image</a> 
                <a class="btn btn-success" href="<?php echo e(route(session('create_route_name'))); ?>"> Create New</a>               
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
            <th>ELEMENT CODE</th>
            <th>ELEMENT DESCRIPTION</th>
            <th>COUNTRY</th>
            <th>COST / M2 GFA</th>
            <th>UNIT / M2</th>
            <th>COST/SF GFA</th>
            <th>UNIT/SF</th>
            <th width="280px">Action</th>
        </tr>
        <?php $__currentLoopData = $entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($entry->element_code); ?></td>
            <td><?php echo e($entry->description); ?></td>
            <?php 
                $country_ids = explode(',', $entry->country_id);
                $countrys = Countries::whereIn('id', $country_ids)->get();                
            ?>
            <td>             
                <select width="100%">
                    <?php $__currentLoopData = $countrys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option><?php echo e($country->country_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </td>
            <td>$<?php echo e(number_format($entry->cost_ms,2)); ?></td>
            <td><?php echo e($entry->unit_m2); ?></td>
            <td>$<?php echo e(number_format($entry->cost_ms,2)); ?></td>
            <td><?php echo e($entry->unit_sf); ?></td>
            <td>
                <form action="<?php echo e(route(session::get('destroy_route_name'),$entry->id)); ?>" method="POST">                    
                    <a class="btn btn-primary" href="<?php echo e(route(session::get('edit_route_name'),$entry->id)); ?>">Edit</a>
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
  
    <?php echo $entries->links(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gdomqnh9pbj7/public_html/admin.globalpreservicesllc.com/resources/views/main_entry/index.blade.php ENDPATH**/ ?>