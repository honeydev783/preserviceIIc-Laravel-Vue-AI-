<?php 
    use App\Models\Countries;
?>

<?php $__env->startSection('contentheader_title','Job Activities'); ?>
<?php $__env->startSection('styles'); ?>
<style>
    .pull-right{
        float: right;
    }
    .pagination
    {
        display: table !important;
        width: 100% !important;
    }
    li.page-item {
        display: inline-block !important;
        margin-top: 5px !important;
    }
    .edit-actcode,.activity_edit{
        display: none;
    }
    textarea.edit-actcode.activity_edit.form-control {
        height: 99px;
    }
    .row_position th, .row_position td {
        vertical-align: middle;
    }
    .btn-action .btn {
        margin: 0px 5px;
        border-radius: 0px;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
        <div class="col-lg-12 margin-tb mb-3">
            <div class="pull-left">
                <form class="form-inline" method="post" action="<?php echo e(url('job_activities')); ?>">
                    <?php echo csrf_field(); ?>  
                    <div class="form-group mb-2 mr-2">
                        <input type="search" name="activity" class="form-control" id="inputPassword2" placeholder="Activity Code" style="width: 300px" value="<?php echo e($activity_code); ?>">
                    </div>
                    <button type="submit" class="btn btn-info mb-2">Go</button>
                </form>
            </div>
            <div class="pull-left ml-10" style="width:250px;margin-left:15px">
                <form class="form-inline" id="sort_form" method="get" action="<?php echo e(url('job_activities')); ?>">
                    
                    <select name="sort_by" class="sort_by">
                        <option value="">Sort By</option>
                        <option <?php echo e($sort_by == 'position_order'?'selected':''); ?> value="position_order">Position</option>
                        <option <?php echo e($sort_by == 'activity_code'?'selected':''); ?> value="activity_code">Activity Code</option>
                    </select>
                </form>
            </div>
            <div class="pull-right mb-2"> 
                <?php 
                    $last_page = $actives->lastPage();                
                    $page = 1;
                    if(isset($_GET['page']))
                    {
                        $page = $_GET['page'];
                    }
                ?>
                
                    <?php echo csrf_field(); ?>                      
                    <div class="btn-group btn-action">
                <?php 
                    if($page != 1)
                    {
                ?>                          
                        <!-- <a class="btn btn-primary" href="<?php echo e(route('job_activities.updateorderprv', $page)); ?>"> Prev Move</a>                -->
                        <button type="button" class="btn btn-info prev-move"> Prev Move</button>
                <?php
                    }  
                    if($last_page != $page)
                    {
                ?>
                        <button type="button" class="btn btn-info next-move"> Next Move</button>
                
                <?php 
                    }
                ?>
                        <button type="submit" form="form" class="btn btn-warning save-comp-ids edit-actcode">Save Activities</button>                  
                        <button type="button" class="btn btn-outline-secondary cancel-comp-btn edit-actcode">Cancel Edit</button>                  
                        <a class="btn btn-success" href="<?php echo e(route('job_activities.create')); ?>"> Create New</a>               
                    </div>
                
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
    <form id="form" name="form" action="<?php echo e(route('job_activities.updateActivityCode')); ?>" method="post">
       <?php echo csrf_field(); ?>
       <div class="table-responsive">
        <table id="dt_table" class="table table-bordered">
            <tr>
                <th>
                    <input type="checkbox" class="all-checkbox" />
                </th>
                <th>#</th>
                <th>ELEMENT DESCRIPTION</th>
                <th>ACTIVITY CODE</th>
                <th>ACTIVITY DESCRIPTION</th>
                <th>COUNTRY</th>
                <th>Imperial Unit</th>
                <th>Metric Unit</th>
                <th>Conversion Factor</th>
                <th>Components</th> 
                <th>Quantity</th>           
                <th>Action</th>
            </tr>
            <tbody class="row_position">
                <?php $__currentLoopData = $actives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $active): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr id="<?php echo e($active->id); ?>">
                    <th>
                        <input value="<?php echo e($active->id); ?>" type="checkbox" class="row-checkbox" />
                    </th>
                    <td width="10%">
                        <?php echo e($active->position_order); ?>

                    </td>
                    <td><?php echo e($active->category_name); ?></td>
                    <td>
                        <span class="act_text"><?php echo e($active->activity_code); ?></span>
                        <input type="text" disabled name="activity_code[<?php echo e($active->id); ?>][activity_code]" class="activity_edit form-control" value="<?php echo e($active->activity_code); ?>" />
                    </td>
                    <td>
                    <span class="act_text"><?php echo e($active->description); ?></span>
                        <textarea disabled name="activity_code[<?php echo e($active->id); ?>][description]" class="activity_edit form-control"><?php echo e($active->description); ?></textarea>
                    </td>
                    <?php 
                        $country_ids = explode(',', $active->country_id);
                        $countrys = Countries::whereIn('id', $country_ids)->get();                
                    ?>
                    <td>             
                        <select width="100%">
                            <?php $__currentLoopData = $countrys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option><?php echo e($country->country_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </td>
                    <td><?php echo e($active->imperial_unit); ?></td>
                    <td><?php echo e($active->metric_unit); ?></td>
                    <td><?php echo e($active->conservation_factor); ?></td>
                    <td>
                        <?php $__currentLoopData = $active->resources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($res->component->component_id ?? Null); ?>,
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td> 
                    <td>
                        <?php $__currentLoopData = $active->resources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($res->quantity); ?>,
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
                    </td>                   
                    <td>
                        <div class="btn-group btn-action">
                        <!-- <form action="<?php echo e(route('job_activities.destroy',$active->id)); ?>" method="POST">                     -->
                            <a class="btn btn-primary" href="<?php echo e(route('job_activities.edit',$active->id)); ?>">Edit</a>
                            <!-- <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>       -->
                            <button class="btn btn-danger" type="button" onclick="deleteActivity('<?php echo e($active->id); ?>')">Delete</button>
                            <a class="btn btn-primary" href="<?php echo e(route('job_activities.copy',$active->id)); ?>">Copy</a>
                        <!-- </form> -->
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
      </div>
    </form>
    <div class="d-flex justify-content-left">
        <nav>
            <?php 
                $total_pages = ceil($actives->total() / 50) ;
                if(isset($_GET['page']))
                {
                    $prv = $_GET['page'] - 1;
                    $next = $_GET['page'] + 1;
                    $page = $_GET['page'];
                }
                else{
                    $prv = 1;
                    $next = 1;
                    $page = 1;
                }
            ?>
            <ul class="pagination">                                                
                <?php if($page != 1): ?>                    
                    <li class="page-item"><a href="<?php echo e(url('/')); ?>/job_activities?page=<?php echo e($prv); ?>&sort_by=<?php echo e($sort_by); ?>" rel="prev" aria-label="« Previous" class="page-link">‹</a></li>                                
                <?php else: ?>
                    <li aria-disabled="true" aria-label="« Previous" class="page-item disabled"><span aria-hidden="true" class="page-link">‹</span></li>
                <?php endif; ?>
                <?php                     
                    for($i = 1; $i <= $total_pages; $i++){                                
                        ?>
                            <?php if($i == $page): ?>
                                <li aria-current="page" class="page-item active"><span class="page-link"><?php echo e($i); ?></span></li>
                            <?php else: ?>
                                <li class="page-item"><a href="<?php echo e(url('/')); ?>/job_activities?page=<?php echo e($i); ?>&sort_by=<?php echo e($sort_by); ?>" class="page-link"><?php echo e($i); ?></a></li>                
                            <?php endif; ?>                            
                    <?php }
                    ?> 
                <?php if($page == $total_pages): ?>
                    <li aria-disabled="true" aria-label="Next »" class="page-item disabled"><span aria-hidden="true" class="page-link">›</span></li>
                <?php else: ?>
                    <li class="page-item"><a href="<?php echo e(url('/')); ?>/job_activities?page=<?php echo e($next); ?>&sort_by=<?php echo e($sort_by); ?>" rel="next" aria-label="Next »" class="page-link">›</a></li>
                <?php endif; ?>                
            </ul>
        <nav>                    
        
        <!-- <?php echo $actives->onEachSide(30)->links(); ?>         -->
    </div>
<?php $__env->stopSection(); ?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
<?php $__env->startSection('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script  type="text/javascript">   
        $(document).ready(function(){
            $("select").select2();
            $(".sort_by").change(function(){
                $("#sort_form").submit();
            })
            $(".next-move").click(function(){

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');   
                var ids = [];
                if($(".row-checkbox:checked").length == 0){
                    alert("Select records to move next");
                    return false;
                }
                $(".row-checkbox:checked").each(function(){
                    ids.push($(this).val());
                });
                $(this).attr("disabled","disabled");
                $(this).html("Processing...");
                $.ajax({
                    url:"<?php echo e(route('job_activities.updateordernext', $page)); ?>",
                    type:'post',
                    dataType:"json",
                    data:{
                        _token: CSRF_TOKEN, 
                        ids:ids, 
                        page:<?php echo e($page); ?>

                    },
                    success:function(response){
                        location.reload();
                    }
                })
            });
            $(".prev-move").click(function(){
              
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');   
                var ids = [];
                if($(".row-checkbox:checked").length == 0){
                    alert("Select records to move prev");
                    return false;
                }
                $(".row-checkbox:checked").each(function(){
                    ids.push($(this).val());
                });       

                $(this).attr("disabled","disabled");
                $(this).html("Processing...");
                $.ajax({
                    url:"<?php echo e(route('job_activities.updateorderprv', $page)); ?>",
                    type:'post',
                    dataType:"json",
                    data:{
                        _token: CSRF_TOKEN, 
                        ids:ids, 
                        page:<?php echo e($page); ?>

                    },
                    success:function(response){
                        location.reload();
                    }
                })
            });
            $(".all-checkbox").change(function(){
                if($(this).is(":checked")){
                    $(".row-checkbox").prop("checked",true);
                    // $(this).parents('#dt_table').find(".activity_edit").attr("type","text");
                    $(this).parents('#dt_table').find(".activity_edit").show();
                    $(this).parents('#dt_table').find(".activity_edit").removeAttr("disabled");
                    $(this).parents('#dt_table').find(".act_text").hide();
                }else{
                    $(".row-checkbox").prop("checked",false);
                    // $(this).parents('#dt_table').find(".activity_edit").attr("type","hidden");
                    $(this).parents('#dt_table').find(".activity_edit").hide();
                    $(this).parents('#dt_table').find(".activity_edit").attr("disabled","disabled");
                    $(this).parents('#dt_table').find(".act_text").show();
                }
                if($(".row-checkbox:checked").length > 0){
                    $(".edit-actcode").show();
                }else{
                    $(".edit-actcode").hide();
                }
            })
            $(".row-checkbox").change(function(){
                if($(this).is(":checked")){
                    // $(this).parents('tr').find(".activity_edit").attr("type","text");
                    $(this).parents('tr').find(".activity_edit").show();
                    $(this).parents('tr').find(".activity_edit").removeAttr("disabled");
                    $(this).parents('tr').find(".act_text").hide();
                }else{
                    // $(this).parents('tr').find(".activity_edit").attr("type","hidden");
                    $(this).parents('tr').find(".activity_edit").hide();
                    $(this).parents('tr').find(".activity_edit").attr("disabled","disabled");
                    $(this).parents('tr').find(".act_text").show();
                }
                if($(".row-checkbox:checked").length > 0){
                    $(".edit-actcode").show();
                   
                }else{
                    $(".edit-actcode").hide();
                }
            });
            $(".cancel-comp-btn").click(function(){
                $(".edit-actcode").hide();
                $(".activity_edit").hide();
                $(".activity_edit").attr("disabled","disabled");
                $(".act_text").show();
                $(".row-checkbox,.all-checkbox").prop("checked",false);
            });
            // $(".save-comp-ids").click(function(){

            // })
        })     
        function deleteActivity(id)
        {
            if (confirm(' Data will be permanently deleted. Are you sure you want to delete?')) {                
                var url = '<?php echo e(URL::to("/")); ?>/job_activities/delete/'+id;                
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
                url:"job_activities/updateorder",
                type:'post',
                data:{_token: CSRF_TOKEN, position:data, page:page},
                success:function(){
                    location.reload();
                }
            })
        }        
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gdomqnh9pbj7/public_html/admin1/resources/views/job_activities/index.blade.php ENDPATH**/ ?>