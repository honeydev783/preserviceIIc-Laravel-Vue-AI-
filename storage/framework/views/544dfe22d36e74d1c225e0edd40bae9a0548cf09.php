<div class="flash-message">
    <?php $__currentLoopData = ['danger', 'warning', 'success', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php if(Session::has('alert-' . $message)): ?>
      <p class="alert alert-<?php echo e($message); ?>"><?php echo e(Session::get('alert-' . $message)); ?></p>
      <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div><?php /**PATH /home3/lobalpx1/public_html/admin/resources/views/layouts/flash-message.blade.php ENDPATH**/ ?>