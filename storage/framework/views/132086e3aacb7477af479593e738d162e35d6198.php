<?php 
    use App\Models\ResourceComponents;
?>

<?php $__env->startSection('contentheader_title'); ?>
Job Activity Edit
<?php $__env->stopSection(); ?> 
<?php $__env->startSection('styles'); ?>
<style>
    .pull-right{
        float: right;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
 
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
   
<form action="<?php echo e(route('job_activities.update',$job_activity)); ?>" method="POST">
    <?php echo csrf_field(); ?>  
    <?php echo method_field('PUT'); ?>
    <div class="row">  
        <div class="col-xs-6 col-sm-6 col-md-6"> 
            <div class="card"> 
                <div class="card-body">         
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>JOB ACTIVITY DESCRIPTION:</strong>
                            <textarea class="form-control" style="height:150px" name="description"  ><?php echo e($job_activity->description); ?></textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>ACTIVITY CODE:</strong>
                            <input type="text" name="activity_code" value="<?php echo e($job_activity->activity_code); ?>" class="form-control" >
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>IMPERIAL UNIT:</strong>
                            <input type="text" name="imperial_unit" value="<?php echo e($job_activity->imperial_unit); ?>" class="form-control" >
                        </div>
                    </div>  
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>METRIC UNIT:</strong>
                            <input type="text" name="metric_unit" value="<?php echo e($job_activity->metric_unit); ?>" class="form-control" >
                        </div>
                    </div>  
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>CONVERSION FACTOR:</strong>
                            <input type="text" name="conservation_factor" value="<?php echo e($job_activity->conservation_factor); ?>" class="form-control" >
                        </div>
                    </div> 
                    
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>ELEMENT DESCRIPTION:</strong>
                            <select name="category" class="form-control" >
                                <option value=""></option>
                                <?php $__currentLoopData = $descriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $description): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option <?php echo e($description->id == $job_activity->category ? 'selected': ''); ?> value="<?php echo e($description->id); ?>"><?php echo e($description->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>                    
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>COUNTRY:</strong>
                            <select name="country[]" class="form-control js-example-basic-multiple" multiple="multiple" id="mySelect2">
                                <option value=""></option>
                                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $countrie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $country_ids = explode(',', $job_activity->country_id); ?>
                                    <option <?php if(in_array($countrie->id, $country_ids)) echo 'selected'; ?> value="<?php echo e($countrie->id); ?>"><?php echo e($countrie->country_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>  
                    <div id="components">
                        <?php if(!empty($job_component_data)): ?>
                        
                        <?php $rescomponenst = ResourceComponents::all() ?>
                        
                            <table class="table table-bordered" id="dynamicTable_0">  
                                
                                    <tr>
                                        <th>COMPONENTS</th>
                                        <th>QUANTITY</th>      
                                        <th>Action</th>                              
                                        <th>#</th>
                                    </tr>   
                                    
                                    <tbody class="row_position"  id="dynamicTbodyTable_0"> 
                                        <?php $__currentLoopData = $job_component_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        
                                            
                                                
                                                <tr id="row_0_<?php echo e($key); ?>">  
                                                    <td>
                                                        <select name="addmore[0][<?php echo e($key); ?>][component_id]" class="form-control"> 
                                                            <option></option>                                  
                                                            <?php $__currentLoopData = $rescomponenst; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $component): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($component->id); ?>" <?php if($component->id == $res['component_id']): ?> selected <?php endif; ?>><?php echo e($component->component_id); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>    
                                                    </td> 
                                                    <td><input type="text" name="addmore[0][<?php echo e($key); ?>][quantity]"  value="<?php echo e($res['quantity']); ?>" class="form-control" /></td>  
                                                    <td>
                                                        
                                                            <button type="button" class="btn btn-danger remove-tr">Remove</button>
                                                    </td>             
                                                    
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-warning" onclick="up(0, <?php echo e($key); ?>)">Up</button> 
                                                        <button type="button" class="btn btn-sm btn-warning" onclick="down(0, <?php echo e($key); ?>)">Down</button>
                                                    </td>
                                                </tr>                                             
                                            
                                            
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <?php ++$key ?>
                                            <td>
                                                <select name="addmore[0][<?php echo e($key); ?>][component_id]" class="form-control"> 
                                                    <option></option>                                  
                                                    <?php $__currentLoopData = $rescomponenst; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $component): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($component->id); ?>" ><?php echo e($component->component_id); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>    
                                            </td>
                                            <td><input type="text" name="addmore[0][<?php echo e($key); ?>][quantity]" class="form-control" /></td>  
                                            <td><button type="button" name="add" id="add-more" data-id="0" class="btn btn-success">Add More</button></td> 
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                        <?php endif; ?>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>     
                </div>
            </div>
        </div>   
    </div>   
</form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
$('#mySelect2-no').on('select2:select', function (e) {
    var data = e.params.data;   
    $.ajax({
        type: "GET",
        url: "/job_activities/getcomponents/"+data.id,
        dataType : 'json',
        success : function(result){         
            var html = '';
            html += '<table class="table table-bordered" id="dynamicTable_'+data.id+'">';
            html +=     '<tr>';
            html +=         '<th colspan="3" align="center">'+data.text+'</th>';
            html +=     '</tr>';
            html +=     '<tr>';
            html +=         '<th>COMPONENTS</th>';
            html +=         '<th>QUANTITY</th>';
            html +=         '<th></th>';
            html +=         '<th>Action</th>';
            html +=     '</tr>';
            html +=     '<tbody class="row_position" id="dynamicTbodyTable_'+data.id+'">';
            html +=     '<tr>';  
            html +=         '<td>';
            html +=             '<select name="addmore['+data.id+'][0][component_id]"  class="form-control">';
            html +=                 '<option></option>';
                                        $.each(result, function(k,v){
            html +=                         '<option value="'+v.id+'">'+v.component_id+'</option>';
                                        });                                         
            html +=             '</select>';
            html +=         '</td>';
            html +=         '<td><input type="text" name="addmore['+data.id+'][0][quantity]" placeholder="Enter quantity" class="form-control" /></td>';
            html +=         '<td><button type="button" name="add" data-id="'+data.id+'" id="add" class="btn btn-success">Add More</button></td>';
            html +=     '</tr>';
            html +=     '</tbody>';
            html += '</table>';

            $('#components').append(html);
            $('.row_position').sortable();        
        }
    })
    
});

$('#mySelect2').on("select2:unselect", function(e){
    var value=   e.params.data.id;
    // $('#dynamicTable_'+value).remove();                
});

$(document).ready(function(){
    var components = [];
    $('.row_position').sortable();        
    $('.js-example-basic-multiple').select2();    
    var i = <?php echo e(count($job_activity->resources)); ?>;      
    // var html = '';
    //     html += '<tr id="row_'+id+'_'+i+'">';
    //     html +=     '<td>';
    //     html +=         '<select name="addmore['+id+']['+i+'][component_id]"  class="form-control">';
    //     html +=             '<option></option>';
    //                         $.each(components, function(k,v){
    //     html +=                 '<option value="'+v.id+'">'+v.component_id+'</option>';
    //                         });
    //     html +=         '</select>';
    //     html +=     '</td>';
    //     html +=     '<td><input type="text" name="addmore['+id+']['+i+'][quantity]" placeholder="Enter your Qty" class="form-control" /></td>';
    //     html +=     '<td><button type="button" name="add" data-id="0" id="add-more" class="btn btn-success">Add More</button></td>';                    
    //     html +=     '<td></td>';                    
    //     html +=     '</tr>';                    
    // $("#dynamicTable_"+id).append(html);  
    $(document).on('click', '#add', function(){
        var id = $(this).attr('data-id');               
        ++i;            
        $.ajax({
            type: "GET",
            url: "/job_activities/getcomponents/"+id,
            dataType : 'json',
            success : function(result){
                var html = '';
                html +=  '<tr id="row_'+id+'_'+i+'">';
                html +=      '<td>';
                html +=          '<select name="addmore['+id+']['+i+'][component_id]"  class="form-control">';
                html +=              '<option></option>';
                                    $.each(result, function(k,v){
                html +=                 '<option value="'+v.id+'">'+v.component_id+'</option>';
                                    });
                html +=         '</select>';
                html +=     '</td>';
                html +=     '<td><input type="text" name="addmore['+id+']['+i+'][quantity]" placeholder="Enter your Qty" class="form-control" /></td>';
                html +=     '<td><button type="button" class="btn btn-danger remove-tr">Remove</button></td>';
                html +=     '<td><button type="button" class="btn btn-sm btn-warning" onclick="up('+id+', '+i+')">Up</button> <button type="button" class="btn btn-sm btn-warning" onclick="down('+id+', '+i+')">Down</button></td></tr>';
                html += '</tr>';                    
                $("#dynamicTable_"+id).append(html);
            }
        });           
    });        
    $(document).on('click', '.remove-tr', function(){  
        $(this).parents('tr').remove();
    });  
    $.ajax({
        type: "GET",
        url: "/job_activities/getcomponents/0",
        dataType : 'json',
        success : function(result){
            components = result;
        }
    });  
    $(document).on('click', '#add-more', function(){
        var id = $(this).attr('data-id');   
        $(this).closest('td').next('td').html(`
            <button type="button" class="btn btn-sm btn-warning" onclick="up(${id}, ${i})">Up</button> <button type="button" class="btn btn-sm btn-warning" onclick="down(${id}, ${i})">Down</button>
        `);
        $(this).closest('td').html(`
            <button type="button" class="btn btn-danger remove-tr">Remove</button>
        `);         
        ++i;
        var html = '';
        html += '<tr id="row_'+id+'_'+i+'">';
        html +=     '<td>';
        html +=         '<select name="addmore['+id+']['+i+'][component_id]"  class="form-control">';
        html +=             '<option></option>';
                            $.each(components, function(k,v){
        html +=                 '<option value="'+v.id+'">'+v.component_id+'</option>';
                            });
        html +=         '</select>';
        html +=     '</td>';
        html +=     '<td><input type="text" name="addmore['+id+']['+i+'][quantity]" placeholder="Enter your Qty" class="form-control" /></td>';
        html +=     '<td><button type="button" name="add" data-id="0" id="add-more" class="btn btn-success">Add More</button></td>';                    
        html +=     '<td></td>';                    
        html +=     '</tr>';                    
        $("#dynamicTable_"+id).append(html);
    });  
});

function up(id, index)
{    
    var selected=0;
    var itemlist = $('#dynamicTbodyTable_'+id);
    var len=$(itemlist).children().length;
    var selected = $('#row_'+id+'_'+index).index();    
    if(selected>0)
    {
        jQuery($(itemlist).children().eq(selected-1)).before(jQuery($(itemlist).children().eq(selected)));
        selected=selected-1;
    }
}

function down(id, index)
{    
    var selected=0;
    var itemlist = $('#dynamicTbodyTable_'+id);
    var len=$(itemlist).children().length;
    var selected = $('#row_'+id+'_'+index).index();    
    if(selected < len)
    {
        jQuery($(itemlist).children().eq(selected+1)).after(jQuery($(itemlist).children().eq(selected)));
        selected=selected+1;
    }
}

</script>
<?php $__env->stopSection(); ?>
 
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gdomqnh9pbj7/public_html/admin.globalpreservicesllc.com/resources/views/job_activities/edit.blade.php ENDPATH**/ ?>