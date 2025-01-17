
<?php $__env->startSection('contentheader_title'); ?>
Resource Component Edit
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
   
<form action="<?php echo e(route('resource_components.update',$resource_component)); ?>" method="POST">
    <?php echo csrf_field(); ?> 
    <?php echo method_field('PUT'); ?>
    <input type="hidden" name="previous_url" value="<?php echo e(url()->previous()); ?>"> 
    <div class="row">  
        <div class="col-xs-6 col-sm-6 col-md-6"> 
            <div class="card"> 
                <div class="card-body">                                      
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Component ID:</strong>
                            <input type="text" name="component_id" value="<?php echo e($resource_component->component_id); ?>" class="form-control" >                        
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Resource Type:</strong>
                            <input type="text" name="resource_type" id="resource_type" value="<?php echo e($resource_component->resource_type); ?>" class="form-control" >
                            <input type="hidden" name="resource_category" id="resource_category" value="<?php echo e($resource_component->category); ?>" >
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Category:</strong>
                            <select name="category" id="category" class="form-control">
                                
                                <option value="Preliminries"<?php if($resource_component->category == 'Preliminries'): ?> selected <?php endif; ?>>Preliminries</option>
                                <option value="Labour"<?php if($resource_component->category == 'Labour'): ?> selected <?php endif; ?>>Labour</option>
                                <option value="Equipment"<?php if($resource_component->category == 'Equipment'): ?> selected <?php endif; ?>>Equipment</option>
                                <option value="Material"<?php if($resource_component->category == 'Material'): ?> selected <?php endif; ?>>Material</option>
                            </select>
                        </div>
                    </div>
    
                    
    
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Unit:</strong>
                            <input type="text" name="unit" value="<?php echo e($resource_component->unit); ?>" class="form-control" >
                        </div>
                    </div>
    
                    
    
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Country:</strong>
                            <select name="country[]" class="form-control js-example-basic-multiple" multiple="multiple" id="mySelect2">
                                <option value="">Please select country</option>
                                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option <?php if(in_array($country->id, $country_ids)) echo 'selected'; ?> value="<?php echo e($country->id); ?>"><?php echo e($country->country_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                            
                            </select>
                        </div>
                    </div>
                    <?php if(!empty($country_lists)): ?>
                        <div id="components">
                            <?php $__currentLoopData = $country_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $k += 1; ?>
                                <table class="table table-bordered" id="dynamicTable_<?php echo e($country->country); ?>">
                                    <tr>
                                        <th colspan="3" align="center"><?php echo e($country->countrys->country_name); ?></th>
                                    </tr>
                                    <tr>
                                        <th>Rate</th>
                                        <th>Country Rate</th>
                                    </tr>
                                    <tbody class="row_position">
                                        <tr id="row_<?php echo e($country->country); ?>_<?php echo e($k); ?>">
                                            <td>
                                                <div class="form-group">
                                                    <span>$</span><input type="text" id="input_rate_<?php echo e($country->country); ?>" name="rate[<?php echo e($country->country); ?>]" class="form-control" oninput="rateCal(<?php echo e($country->country); ?>, this)" value="<?php echo e($country->orignal_rate); ?>" style="display: inline-block; width: 90%;">
                                                </div>
                                            </td>
                                            <td><input type="hidden" name="cal_rate[<?php echo e($country->country); ?>]" value="<?php echo e($country->rate); ?>" id="cal_rate_<?php echo e($country->country); ?>"> $<span id="rate_<?php echo e($country->country); ?>"><?php echo e($country->rate); ?></span></td>
                                        </tr>
                                    </tbody>
                                </table>                        
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                     
                        </div>   
                    <?php else: ?>
                        <div id="components">
    
                        </div>
                    <?php endif; ?>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>        
                </div>
            <div> 
            </div> 
        </div>
    </div>
        <div class="col-xs-1 col-sm-1 col-md-1"> </div>
        <div class="col-xs-5 col-sm-5 col-md-5" style="border: 1px solid grey; padding: 30px;"> 
            <!--<h3>Online Vendors List and Prices of <?php echo e($resource_component->resource_type); ?></h3>-->
            <div id="resourceaicompdata"></div>
        </div>
</div>
</form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script  type="text/javascript">            
    $(document).ready(function(){    
        $('.js-example-basic-multiple').select2();    
        resourceaieditdata();
    })

    $('#mySelect2').on('select2:select', function (e) {
        var data = e.params.data;   
        var html = '';        
        html += '<table class="table table-bordered" id="dynamicTable_'+data.id+'">';
        html +=     '<tr>';
        html +=         '<th colspan="3" align="center">'+data.text+'</th>';
        html +=     '</tr>';
        html +=     '<tr>';
        html +=         '<th>Rate</th>';
        html +=         '<th>Country Rate</th>';
        html +=     '</tr>';
        html +=     '<tbody class="row_position">';
        html +=     '<tr id="row_'+data.id+'_0">';  
        html +=         '<td>';
        html +=             '<div class="form-group">'
        html +=                 '<input type="text" id="input_rate_'+data.id+'" name="rate['+data.id+']" class="form-control" oninput="rateCal('+data.id+', this)">';
        html +=             '</div>'
        html +=         '</td>';
        html +=         '<td><input type="hidden" name="cal_rate['+data.id+']" id="cal_rate_'+data.id+'"> <span id="rate_'+data.id+'"></span></td>'
        html +=     '</tr>';
        html +=     '</tbody>';
        html += '</table>';

        $('#components').append(html);
    });
    $('#mySelect2').on("select2:unselect", function(e){
        var value = e.params.data.id;
        $('#dynamicTable_'+value).remove();                
    });
    
    function resourceaieditdata() {
        if(document.getElementById('resource_category').value == "Labour") {
            var resource_comp_data = 'Generate an HTML code for average hourly rate cost value of ' + document.getElementById('resource_type').value + ' job skills in USA area';
        } else if(document.getElementById('resource_category').value == "Equipment") {
            var resource_comp_data = 'Generate an HTML code for average hourly cost and cost of purchasing one of ' + document.getElementById('resource_type').value + ' Equipment in USA area';
        } else {
            var resource_comp_data = 'Generate an HTML code for Online Vendors List and Prices ' + document.getElementById('resource_category').value + ' of ' + document.getElementById('resource_type').value;
        }
        
        axios.get("/predict?text=" + resource_comp_data).then(function (response) {                  
          $('#resourceaicompdata').html(response.data.candidates[0].content.parts[0].text);
        });
    }
    
    function rateCal(id, e)
    {
        var rate = $(e).val();
        var category = $('#category').val();
        var cal_rate = 0;
        // alert($('#mySelect2').val());
        if(category == 'Material')
        {
            $.ajax({
                type: "GET",
                url: "/country_details/"+id,
                dataType : 'json',
                success : function(result){  
                    cal_rate = rate * result.country.material_rate                    
                    $('#rate_'+id).text(cal_rate);
                    $('#cal_rate_'+id).val(cal_rate);
                }
            })
        }
        else{
            cal_rate = rate;
            $('#rate_'+id).text(cal_rate);
            $('#cal_rate_'+id).val(cal_rate);
        }        
    }

    $('#category').on('change', function(){
        var country = $('#mySelect2').val().toString();        
        var countrys = country.split(',')                
        for(var i = 0; i < countrys.length; i++)
        {            
            var rate = $('#input_rate_'+countrys[i]).val();            
            var cal_rate = 0;
            if($(this).val() == 'Material')
            {
                $.ajax({
                    type: "GET",
                    url: "/country_details/"+countrys[i],
                    dataType : 'json',
                    success : function(result){  
                        cal_rate = rate * result.country.material_rate                          
                        $('#rate_'+result.country.id).text(cal_rate);                                                   
                        $('#cal_rate_'+result.country.id).val(cal_rate);
                    }
                })
            }
            else{
                $('#rate_'+countrys[i]).text(rate);
                $('#cal_rate_'+countrys[i]).val(rate);
            }
        }
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gdomqnh9pbj7/public_html/admin.globalpreservicesllc.com/resources/views/components/edit.blade.php ENDPATH**/ ?>