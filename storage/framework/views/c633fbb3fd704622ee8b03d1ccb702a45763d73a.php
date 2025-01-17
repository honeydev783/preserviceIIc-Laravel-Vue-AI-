
<?php $__env->startSection('contentheader_title'); ?>
Resource Component Global Update
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
   
<form action="<?php echo e(route('resource_components.updateglobal')); ?>" method="POST" id="myform">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="previous_url" value="<?php echo e(url()->previous()); ?>"> 
    <div class="row">  
        <div class="col-xs-6 col-sm-6 col-md-6"> 
        <div class="card"> 
            <div class="card-body">                                      
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Category:</strong>
                        <select name="category" id="category" class="form-control" required>
                            <option value="">Please select category</option>
                            <option  <?php echo e(old('category') == 'Preliminries' ? "selected" : ""); ?> value="Preliminries">Preliminries</option>
                            <option  <?php echo e(old('category') == 'Labour' ? "selected" : ""); ?> value="Labour">Labour</option>
                            <option  <?php echo e(old('category') == 'Equipment' ? "selected" : ""); ?> value="Equipment">Equipment</option>
                            <option  <?php echo e(old('category') == 'Material' ? "selected" : ""); ?> value="Material">Material</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Country:</strong>
                        <select name="country[]" class="form-control js-example-basic-multiple" multiple="multiple" id="mySelect2" required>
                            <option value="all">All</option>
                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($country->id); ?>"><?php echo e($country->country_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div id="components">

                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>        
            </div>
        <div> 
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
    })

    $('#myform').submit(function(event) {
      // Prevent the default form submission
      event.preventDefault();

      // Show confirmation alert
      if (confirm("Are you sure you want to add all Countries to Resource compoenent?")) {
        this.submit();
      } else {
        return false;
      }
    });

    $('#mySelect2').on('select2:select', function (e) {
        var data = e.params.data;   
        var html = '';
        if (data.text == 'All') {
            $('#components').html('');
            $('#mySelect2').val($('#mySelect2 option:not(:first)').map(function() { 
                var id = $(this).val();
                var text = $(this).text();
                
                html += '<table class="table table-bordered" id="dynamicTable_'+id+'">';
                html +=     '<tr>';
                html +=         '<th colspan="3" align="center">'+text+'</th>';
                html +=     '</tr>';
                html +=     '<tr>';
                html +=         '<th>Rate</th>';
                html +=         '<th>Country Rate</th>';
                html +=     '</tr>';
                html +=     '<tbody class="row_position">';
                html +=     '<tr id="row_'+id+'_0">';  
                html +=         '<td>';
                html +=             '<div class="form-group">'
                html +=                 '<input type="text" id="input_rate_'+id+'" name="rate['+id+']" class="form-control" oninput="rateCal('+id+', this)">';
                html +=             '</div>'
                html +=         '</td>';
                html +=         '<td><input type="hidden" name="cal_rate['+id+']" id="cal_rate_'+id+'"> <span id="rate_'+id+'"></span></td>'
                html +=     '</tr>';
                html +=     '</tbody>';
                html += '</table>';
            }));
            $('#mySelect2').val($('#mySelect2 option:not(:first)').map(function() { return $(this).val(); }).get()).trigger('change');
        } else {

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
        }

        $('#components').append(html);
    });
    $('#mySelect2').on("select2:unselect", function(e){
        var value = e.params.data.id;
        $('#dynamicTable_'+value).remove();                
    });
    
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

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/gdomqnh9pbj7/public_html/admin.globalpreservicesllc.com/resources/views/components/global.blade.php ENDPATH**/ ?>