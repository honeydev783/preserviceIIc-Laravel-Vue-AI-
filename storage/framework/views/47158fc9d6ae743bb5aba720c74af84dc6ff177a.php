
<?php $__env->startSection('contentheader_title','Categories'); ?>
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
            <?php 
                    $last_page = $categories->lastPage();                
                    $page = 1;
                    if(isset($_GET['page']))
                    {
                        $page = $_GET['page'];
                    }
                ?>                    
                <?php 
                    if($page != 1)
                    {
                ?>                          
                    <a class="btn btn-primary" href="<?php echo e(route('categories.updateorderprv', $page)); ?>"> Prv Move</a>               
                <?php
                    }  
                    if($last_page != $page)
                    {
                ?>
                    <a class="btn btn-info" href="<?php echo e(route('categories.updateordernext', $page)); ?>"> Next Move</a>
                <?php 
                    }
                ?>                          
                <a class="btn btn-success" href="<?php echo e(route('categories.create')); ?>"> Create New</a>               
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
            <th>CATEGORY</th>   
            <th>ACTION</th>
        </tr>
        <tbody class="row_position">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr id="<?php echo e($category->id); ?>">
                <td><?php echo e($category->title); ?></td>
                <td>
                    <!-- <form action="<?php echo e(route('categories.destroy',$category->id)); ?>" method="POST">                     -->
                        <a class="btn btn-primary" href="<?php echo e(route('categories.edit',$category->id)); ?>">Edit</a>
                        <!-- <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>       -->
                        <button type="submit" onclick="deleteCategory('<?php echo e($category->id); ?>')" class="btn btn-danger">Delete</button>
                    <!-- </form> -->
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
  
    <?php echo $categories->links(); ?>

   
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script  type="text/javascript">        
        function deleteCategory(id)
        {
            if (confirm(' Data will be permanently deleted. Are you sure you want to delete?')) {                
                var url = '<?php echo e(URL::to("/")); ?>/categories/delete/'+id;                
                window.location.assign(url);
            }            
        }

        $(".row_position").sortable({
            delay: 150,
            stop: function() {
                var selectedData = new Array();
                $('.row_position>tr').each(function() {
                    selectedData.push($(this).attr("id"));
                });
                updateOrder(selectedData);
            }
        });

        function updateOrder(data) {
            var page = '<?php echo $page; ?>';

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');            
            $.ajax({
                url:"categories/updateorder",
                type:'post',
                data:{_token: CSRF_TOKEN, position:data, page:page},
                success:function(){
                    location.reload();
                }
            })
        }

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gdomqnh9pbj7/public_html/admin.globalpreservicesllc.com/resources/views/categories/index.blade.php ENDPATH**/ ?>