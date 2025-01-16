@extends('layouts.master')
@section('contentheader_title')
Job Activity Global Set
@endsection 
@section('styles')
<style>
    .pull-right{
        float: right;
    }
</style>
@endsection
@section('content')
 
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
   
<form action="{{route('job_activities.updateglobal')}}" method="POST" id="myform">
    @csrf  
    <div class="row">  
        <div class="col-xs-6 col-sm-6 col-md-6"> 
            <div class="card"> 
                <div class="card-body">         
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>COUNTRY:</strong>
                            <select name="country[]" class="form-control js-example-basic-multiple" multiple="multiple" id="mySelect2">
                                <option value="all">All</option>
                                @foreach($countries as $country)
                                <option {{$country->id == old('country') ? 'selected': ''}} value="{{$country->id}}">{{$country->country_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>  
                    <div id="components">

                    </div>                         
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>   
</form>

@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script  type="text/javascript">            
$('#mySelect2').on('select2:select', function (e) {
    var data = e.params.data;
    console.log('select', data);
    
    if (data.text == 'All') {
        $('#mySelect2').val($('#mySelect2 option:not(:first)').map(function() { return $(this).val(); }).get()).trigger('change');
    }
});
$('#mySelect2').on("select2:unselect", function(e){
    var value=   e.params.data.id;
    // $('#dynamicTable_'+value).remove();                
});

$(document).ready(function(){  
    var components = [];
    var i = 0;
    // $.ajax({
    //     type: "GET",
    //     url: "/job_activities/getcomponents/0",
    //     dataType : 'json',
    //     success : function(result){
    //         components = result;
    //         var html = '';
    //         html += '<table class="table table-bordered">';
    //         html +=     '<tr>';
    //         html +=         '<th colspan="3" align="center">Job components</th>';
    //         html +=     '</tr>';
    //         html +=     '<tr>';
    //         html +=         '<th>COMPONENTS</th>';
    //         html +=         '<th>QUANTITY</th>';
    //         html +=         '<th>Action</th>';
    //         html +=         '<th>#</th>';
    //         html +=     '</tr>';
    //         html +=     '<tbody class="row_position" id="dynamicTable_0">';
    //         html +=     '<tr id="row_0_0">';  
    //         html +=         '<td>';
    //         html +=             '<select name="addmore[0][0][component_id]"  class="form-control">';
    //         html +=                 '<option></option>';
    //                                     $.each(components, function(k,v){
    //         html +=                         '<option value="'+v.id+'">'+v.component_id+'</option>';
    //                                     });                                         
    //         html +=             '</select>';
    //         html +=         '</td>';
    //         html +=         '<td><input type="text" name="addmore[0][0][quantity]" placeholder="Enter quantity" class="form-control" /></td>';
    //         html +=         '<td><button type="button" name="add" data-id="0" id="add-more" class="btn btn-success">Add More</button></td>';
    //         html +=         '<td></td>';
    //         html +=     '</tr>';
    //         html +=     '</tbody>';
    //         html += '</table>';

    //         $('#components').append(html);
    //         $('.row_position').sortable();        
    //     }
    // });

    $('#myform').submit(function(event) {
      // Prevent the default form submission
      event.preventDefault();

      // Show confirmation alert
      if (confirm("Are you sure you want to add all Countries to Job Activity/Activities?")) {
        // If user clicks 'Yes', submit the form
        this.submit();
      } else {
        // If user clicks 'No', do nothing
        return false;
      }
    });

    $('.js-example-basic-multiple').select2();    
    
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
      
    $(document).on('click', '.remove-tr', function(){  
        $(this).parents('tr').remove();
    });              
});

function up(id, index)
{    
    var selected=0;
    var itemlist = $('#dynamicTable_'+id);
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
    var itemlist = $('#dynamicTable_'+id);
    var len=$(itemlist).children().length;
    var selected = $('#row_'+id+'_'+index).index();    
    if(selected < len)
    {
        jQuery($(itemlist).children().eq(selected+1)).after(jQuery($(itemlist).children().eq(selected)));
        selected=selected+1;
    }
}

</script>
@endsection
 