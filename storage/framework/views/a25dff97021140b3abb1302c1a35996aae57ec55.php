
<?php $__env->startSection('contentheader_title','Detail Estimate Cost Form List'); ?>
<?php $__env->startSection('styles'); ?>
<style>
    .pull-right{
        float: right;
    }
    .is-countdown {
        background-color: transparent !important;
        border: none !important;
        font-size: 12px;
    }
    .table-bordered td, .table-bordered th {
        vertical-align: middle;
    }
    .expiry_time {
        font-size: 20px;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php if($message = Session::get('success')): ?>
        <div class="alert alert-success">
            <p><?php echo e($message); ?></p>
        </div>
    <?php endif; ?>
    <div id="defaultCountdown"></div>
    <table class="table table-bordered">
        <tr>
            <th>Form Name</th>        
            <th>Date</th>
            <th>Action</th>
            <th>Expiry Time</th>
        </tr>
        <?php $__currentLoopData = $costForms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costForm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        
        <tr>
            <td><?php echo e($costForm->form_name); ?></td>
            <td><?php echo e(date('m/d/Y', strtotime($costForm->created_at))); ?></td>
            <td>                
                <a class="btn btn-primary" href="<?php echo e(route('detail-estimate.restore_form',$costForm->id)); ?>">Restore</a>
                <a class="btn btn-danger" href="<?php echo e(route('detail-estimate.destroy',$costForm->id)); ?>">Delete</a>
            </td>
            <td>
                <?php if($costForm->expiry_time != ''): ?>
                    <span class="expiry_time" data-expiry-time="<?php echo e($costForm->expiry_time); ?>"></span>
                <?php else: ?>
                    <span>Endless</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
    <?php echo e($costForms->links()); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>

<script>
    $(document).ready(function(){
        initCounter();
        setInterval(() => {
            initCounter();
        }, 1000);
    });
    function initCounter(){
        $(".expiry_time").each(function(){
            var expiryTime = $(this).data("expiry-time"); 
            var time = countDown(expiryTime);
            $(this).html(time);
        });   
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/lobalpx1/public_html/admin/resources/views/estimate_form/detail-form-list.blade.php ENDPATH**/ ?>