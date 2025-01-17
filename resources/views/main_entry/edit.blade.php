@extends('layouts.master')
@section('contentheader_title')
{{session('title')}} Edit
@endsection 
@section('styles')
<style>
    .pull-right{
        float: right;
    }
    .checkbox{
        width:100%;
        height:30px;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">       
        <div class="pull-right">            
            <a class="btn btn-primary" href="{{route(session::get('index_route_name'))}}"> Back</a>                
        </div>
    </div>
</div>

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

<form action="{{ route(session::get('update_route_name'),$entry->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">        
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>ELEMENT DESCRIPTION:</strong>
                <textarea class="form-control" style="height:150px" name="description"  required>{{$entry->description}}</textarea>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>ELEMENT CODE:</strong>
                <input type="text" name="element_code" value="{{$entry->element_code}}" class="form-control" required>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>COST / M2 GFA:</strong>
                <input type="number" name="cost_m2" step="0.01" value="{{$entry->cost_m2}}" class="form-control" required>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>UNIT / M2:</strong>
                <input type="text" name="unit_m2" value="{{$entry->unit_m2}}" class="form-control" required>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>COST / SF GFA:</strong>
                <input type="number" name="cost_sf" step="0.01" value="{{$entry->cost_sf}}" class="form-control" id="cost_sf" required>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>UNIT / SF:</strong>
                <input type="text" name="unit_sf" value="{{$entry->unit_sf}}" class="form-control" required>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <label><strong>NO. OF STORIES:</strong>
                <input type="checkbox" name="is_story"  @if($entry->is_story) checked @endif  class="checkbox">
                </label>               
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>Country:</strong>
                <select name="country[]" class="form-control js-example-basic-multiple" multiple="multiple" id="mySelect2">
                    <option value=""></option>
                    @foreach($countries as $country)
                        <?php $country_ids = explode(',', $entry->country_id); ?>
                        <option <?php if(in_array($country->id, $country_ids)) echo 'selected'; ?> value="{{$country->id}}">{{$country->country_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @if($entry->description == 'Substructure')
            <div class="col-xs-4 col-sm-4 col-md-4">
                <div class="form-group">
                    <strong>Soil Condition:</strong>
                    <select name="soil_condition" id="soil_condition" class="form-control">
                        <option value="">select Soil Condition</option>
                        <option value="1" {{($entry->soil_condition == 1) ? 'selected' : ''}}>Ordinary Soil</option>
                        <option value="2" {{($entry->soil_condition == 2) ? 'selected' : ''}}>Sandy Soil</option>
                        <option value="3" {{($entry->soil_condition == 3) ? 'selected' : ''}}>Loam Soil</option>
                        <option value="4" {{($entry->soil_condition == 4) ? 'selected' : ''}}>Soft Clay Soil</option>
                        <option value="5" {{($entry->soil_condition == 5) ? 'selected' : ''}}>Stiff Clay Soil</option>
                        <option value="6" {{($entry->soil_condition == 6) ? 'selected' : ''}}>Hard Soil</option>
                        <option value="7" {{($entry->soil_condition == 7) ? 'selected' : ''}}>Soft Soil</option>
                    </select>
                </div>
            </div>
        @endif
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>        
    </div>   

</form>
@endsection
@section('scripts')
<script>
    var cost_sf = $('#cost_sf').val();
    $(document).on('change', '#soil_condition', function(){        
        var cost_sf_sum = 0;
        $.ajax({
            type: "GET",
            url: "/main_entry/getsoilcondition/"+$(this).val(),
            dataType : 'json',
            success : function(result){
                cost_sf_sum = parseInt(cost_sf) + parseInt(result);
                $('#cost_sf').val(cost_sf_sum);
            }
        })
    })
    $('#mySelect2').on('select2:select', function (e) {
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
            html +=     '</tr>';
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
            html += '</table>';

            $('#components').append(html);
        }
    })
    
});

$('#mySelect2').on("select2:unselect", function(e){
    var value=   e.params.data.id;
    $('#dynamicTable_'+value).remove();                
});

$(document).ready(function(){
    $('.js-example-basic-multiple').select2();
    var i = 0;
    
        $(document).on('click', '#add', function(){
            var id = $(this).attr('data-id');               
           ++i;            
           $.ajax({
                type: "GET",
                url: "/job_activities/getcomponents/"+id,
                dataType : 'json',
                success : function(result){
                   var html = '';
                    html +=  '<tr>';
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
                    html += '</tr>';                    
                   $("#dynamicTable_"+id).append(html);
                }
           });           
        });        
       $(document).on('click', '.remove-tr', function(){  
            $(this).parents('tr').remove();
       });      
});
</script>
@endsection