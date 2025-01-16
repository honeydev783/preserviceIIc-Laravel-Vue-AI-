<?php $__env->startSection('contentheader_title','Dashboard'); ?> 
<?php $__env->startSection('styles'); ?>
<style>

    .is-countdown {
        background-color: transparent !important;
        border: none !important;
        font-size: 12px;
    }
    .note {
      font-size: 18px;
      color: #FF0000;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php if($exp_approx_forms > 0): ?>
<!-- Modal -->
<div id="approxModal" data-keyboard="false" data-backdrop="static" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Approx Estimate Forms Expiry</h5>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body">
        <p class="note">
          <strong>Please note:</strong>
          Your saved data will become inaccessible,
          once your storage data allotted time is expired.
          Kindly review and print project promptly. Thank You!
        </p>
        <table class="table table-bordered">
            <tr>
                <th>Form Name</th>        
                <th>Date</th>
                <th>Expiry Time</th>
            </tr>
            <?php $__currentLoopData = $approx_forms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $approx_form): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($approx_form->form_name); ?></td>
                <td><?php echo e(date('m/d/Y', strtotime($approx_form->created_at))); ?></td>
                <td>
                    <?php if($approx_form->expiry_time != ''): ?>
                        <span class="expiry_time" data-expiry-time="<?php echo e($approx_form->expiry_time); ?>"></span>
                    <?php else: ?>
                        <span>Endless</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btn-lg" onclick="closeApprox()">Close</button>
      </div>
    </div>

  </div>
</div>
<?php endif; ?>

<?php if($exp_detail_forms > 0): ?>
<!-- Modal -->
<div id="detailEstModel" data-keyboard="false" data-backdrop="static" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Estimate Expiry Form</h5>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body">
        <p class="note">
          <strong>Please note:</strong>
          Your saved data will become inaccessible,
          once your storage data allotted time is expired.
          Kindly review and print project promptly. Thank You!
        </p>
        <table class="table table-bordered">
            <tr>
                <th>Form Name</th>      
                <th>Expiry Time</th>
            </tr>
            <?php $__currentLoopData = $detail_forms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail_form): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
            <tr>
                <td><?php echo e($detail_form->form_name); ?></td>
                <td>
                    <?php if($detail_form->expiry_time != ''): ?>
                        <span class="expiry_time" data-expiry-time="<?php echo e($detail_form->expiry_time); ?>"></span>
                    <?php else: ?>
                        <span>Endless</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btn-lg" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<?php endif; ?>
    <img src="<?php echo e(asset('/images/bg.jpg')); ?>">          
<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
<script>
<?php if(count($exp_approx_forms) > 0): ?>
    $("#approxModal").modal("show");
<?php elseif(count($exp_detail_forms) > 0): ?>
    $("#detailEstModel").modal("show");
<?php endif; ?>
</script>
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

function closeApprox(){
    $("#approxModal").modal("hide");
    <?php if(count($exp_detail_forms) > 0): ?>
        $("#detailEstModel").modal("show");
    <?php endif; ?>
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gdomqnh9pbj7/public_html/admin1/resources/views/dashboard.blade.php ENDPATH**/ ?>