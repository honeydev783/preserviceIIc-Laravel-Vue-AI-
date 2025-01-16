
<?php $__env->startSection('contentheader_title','Resource Components'); ?>
<?php $__env->startSection('styles'); ?>
<style>
    .pull-right{
        float: right;
    }
    .edit-compid{
        display: none;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <form class="form-inline" method="post" action="<?php echo e(url('resource_components')); ?>">
                    <?php echo csrf_field(); ?>  
                    <div class="form-group mx-sm-3 mb-2">
                        <input type="search" name="resource_type" onkeyup="searchResource()" class="form-control" id="resource_type" placeholder="Seach by Resource Type" style="width: 300px" value="">
                    </div>
                    <button type="button" onclick="searchResource()" class="btn btn-info mb-2 mr-2">Go</button>
                    <button type="button" onclick="clearSearch()" class="btn btn-outline-secondary mb-2">Clear</button>
                </form>
            </div>
            <div class="pull-right mb-2">             
                <!-- <button type="button" class="btn btn-outline-primary edit-comp-btn"><i class="fa fa-edit"></i> Edit Component Ids</i></button>                   -->
                <button type="submit" form="form" class="btn btn-warning save-comp-ids edit-compid">Save Component</button>                  
                <button type="button" class="btn btn-outline-secondary cancel-comp-btn edit-compid">Cancel Edit</button>                  
                <a class="btn btn-success" href="<?php echo e(route('resource_components.create')); ?>"> Create New</a>               
            </div>
        </div>
    </div>
   
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
   <form id="form" name="form" action="<?php echo e(route('resource_components.updateComponentIds')); ?>" method="post">
       <?php echo csrf_field(); ?>
    <table id="dt_table" class="table table-bordered">
        <tr>
            <th>
                <input type="checkbox" class="all-checkbox" />
            </th>
            <th>COMPONENT ID</th>
            <th>RESOURCE TYPE</th>
            <th>Country</th>
            <th>RATE</th>  
            <th>Category</th>
            
            <th>UNIT</th>                                
            <th>Action</th>
        </tr>
        <?php $__currentLoopData = $components; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $component): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <th>
                <input type="checkbox" class="row-checkbox" />
            </th>
            <td>
                <span class="compid_text"><?php echo e($component->component_id); ?></span>
                <input type="hidden" disabled name="component_id[<?php echo e($component->id); ?>][component_id]" class="component_id form-control" value="<?php echo e($component->component_id); ?>" />
            </td>            
            <td data-type="<?php echo e($component->resource_type); ?>">
                <span class="compid_text"><?php echo e($component->resource_type); ?></span>
                <input type="hidden" disabled name="component_id[<?php echo e($component->id); ?>][resource_type]" class="component_id form-control" value="<?php echo e($component->resource_type); ?>" />
            </td>
            <td><?php echo e($component->countrys->country_name); ?></td>
            <td>
                <?php 
                    if($component->category == 'Labour')
                    {
                        $rate = ($component->rate * ($component->countrys->labour_rate / 100));
                    }
                    elseif($component->category == 'Equipment')
                    {
                        $rate = ($component->rate * ($component->countrys->equipment_rate / 100));
                    }
                    elseif($component->category == 'Material')
                    {
                        $rate = ($component->rate * ($component->countrys->material_rate / 100));
                    }
                    else{
                        $rate = $component->rate;
                    }
                ?>                
                $<?php echo e(number_format($rate,2)); ?></td>                    
            <td><?php echo e($component->category); ?></td>
            
            <td><?php echo e($component->unit); ?></td>            
            <td>
                <!-- <form action="<?php echo e(route('resource_components.destroy',$component->id)); ?>" method="POST">                     -->
                    <a class="btn btn-primary" href="<?php echo e(route('resource_components.edit',$component->id)); ?>">Edit</a>
                    <!-- <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>       -->
                    <!-- <button type="submit" class="btn btn-danger">Delete</button> -->
                    <button type="button" class="btn btn-danger" onclick="deleteComponent('<?php echo e($component->id); ?>')">Delete</button>
                    <a class="btn btn-primary" href="<?php echo e(route('resource_components.copy',$component->id)); ?>">Copy</a>
                <!-- </form> -->
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
   </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script  type="text/javascript">        
        $(document).ready(function(){
            $(".all-checkbox").change(function(){
                if($(this).is(":checked")){
                    $(".row-checkbox").prop("checked",true);
                    $(this).parents('#dt_table').find(".component_id").attr("type","text");
                    $(this).parents('#dt_table').find(".component_id").removeAttr("disabled");
                    $(this).parents('#dt_table').find(".compid_text").hide();
                }else{
                    $(".row-checkbox").prop("checked",false);
                    $(this).parents('#dt_table').find(".component_id").attr("type","hidden");
                    $(this).parents('#dt_table').find(".component_id").attr("disabled","disabled");
                    $(this).parents('#dt_table').find(".compid_text").show();
                }
                if($(".row-checkbox:checked").length > 0){
                    $(".edit-compid").show();
                }else{
                    $(".edit-compid").hide();
                }
            })
            $(".row-checkbox").change(function(){
                if($(this).is(":checked")){
                    $(this).parents('tr').find(".component_id").attr("type","text");
                    $(this).parents('tr').find(".component_id").removeAttr("disabled");
                    $(this).parents('tr').find(".compid_text").hide();
                }else{
                    $(this).parents('tr').find(".component_id").attr("type","hidden");
                    $(this).parents('tr').find(".component_id").attr("disabled","disabled");
                    $(this).parents('tr').find(".compid_text").show();
                }
                if($(".row-checkbox:checked").length > 0){
                    $(".edit-compid").show();
                   
                }else{
                    $(".edit-compid").hide();
                }
            })
            $(".cancel-comp-btn").click(function(){
                $(".edit-compid").hide();
                $(".component_id").attr("type","hidden");
                $(".component_id").attr("disabled","disabled");
                $(".compid_text").show();
                $(".row-checkbox,.all-checkbox").prop("checked",false);
            });
            // $(".save-comp-ids").click(function(){

            // })
        })
        function deleteComponent(id)
        {
            if (confirm('Data will be permanently deleted. Are you sure you want to delete?')) {                
                var url = window.location.origin+'/resource_components/delete/'+id;                
                window.location.assign(url);
            }  
        }

        function searchResource() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("resource_type");
            filter = input.value.toUpperCase();
            table = document.getElementById("dt_table");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
                }       
            }
        }

        function clearSearch(){
            $("#resource_type").val('');
            searchResource();
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/lobalpx1/public_html/admin/resources/views/components/index.blade.php ENDPATH**/ ?>