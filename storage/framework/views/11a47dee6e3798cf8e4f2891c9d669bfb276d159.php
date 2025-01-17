
<?php $__env->startSection('contentheader_title','DETAIL COST ESTIMATION FORM'); ?>
<?php $__env->startSection('content'); ?>
<input type="hidden" name="id" value="<?php echo e($data['id']); ?>" id="detail_id">
<detail-estimate-form></detail-estimate-form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/lobalpx1/public_html/admin/resources/views/estimate_form/detail-form.blade.php ENDPATH**/ ?>