
<?php $__env->startSection('contentheader_title','APPROXIMATE COST ESTIMATION FORM'); ?>
<?php $__env->startSection('content'); ?>
<input type="hidden" name="id" value="<?php echo e($data['id']); ?>" id="approx_id">
<cost-estimate-form></cost-estimate-form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Robert\resources\views/estimate_form/cost-form.blade.php ENDPATH**/ ?>