<?php 
    use App\Models\ResourceComponents;
?>
@extends('layouts.master')
@section('contentheader_title')
Job Activity Copy
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
   
<form action="{{route('job_activities.copydata')}}" method="POST">
    @csrf  
    <div class="row">  
        <div class="col-xs-6 col-sm-6 col-md-6"> 
            <div class="card"> 
                <div class="card-body">         
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>JOB ACTIVITY DESCRIPTION:</strong>
                            <textarea class="form-control" style="height:150px" name="description"  >{{$job_activity->description}}</textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>ACTIVITY CODE:</strong>
                            <input type="text" name="activity_code" value="{{$job_activity->activity_code}}" class="form-control" >
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>IMPERIAL UNIT:</strong>
                            <input type="text" name="imperial_unit" value="{{$job_activity->imperial_unit}}" class="form-control" >
                        </div>
                    </div>  
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>METRIC UNIT:</strong>
                            <input type="text" name="metric_unit" value="{{$job_activity->metric_unit}}" class="form-control" >
                        </div>
                    </div>  
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>CONVERSION FACTOR:</strong>
                            <input type="text" name="conservation_factor" value="{{$job_activity->conservation_factor}}" class="form-control" >
                        </div>
                    </div> 
                    {{-- <div class="col-md-12">
                        <div class="form-group">
                            <strong>COMPONENTS:</strong>
                            <select name="components[]" multiple class="form-control">
                                <option></option>
                                @foreach($components as $component)
                                    @if(in_array($component->id,$component_ids))
                                        <option value="{{$component->id}}" selected>{{$component->component_id}}</option>
                                    @else
                                        <option value="{{$component->id}}">{{$component->component_id}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div> 
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Quantity:</strong>
                            <input type="textbox" id="quantity" name="quantity" class="form-control" value="{{ $component->quantity }}">
                            
                        </div>
                    </div>    --}}
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>ELEMENT DESCRIPTION:</strong>
                            <select name="category" class="form-control" >
                                <option value=""></option>
                                @foreach($descriptions as $description)
                                    <option {{$description->id == $job_activity->category ? 'selected': ''}} value="{{$description->id}}">{{$description->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>                    
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>COUNTRY:</strong>
                            <select name="country[]" class="form-control js-example-basic-multiple" multiple="multiple" id="mySelect2">
                                <option value=""></option>
                                @foreach($countries as $countrie)
                                    <?php $country_ids = explode(',', $job_activity->country_id); ?>
                                    <option <?php if(in_array($countrie->id, $country_ids)) echo 'selected'; ?> value="{{$countrie->id}}">{{$countrie->country_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>  
                    <div id="components">
                        @if(!empty($job_component_data))
                            @foreach($job_component_data as $value)
                                <?php $rescomponenst = ResourceComponents::where('country', $value['country']['id'])->get() ?>
                                <table class="table table-bordered" id="dynamicTable_{{$value['country']['id']}}">  
                                    <tr>
                                        <th colspan="3">{{$value['country']['country_name']}}</th>
                                    </tr>
                                    <tr>
                                        <th>COMPONENTS</th>
                                        <th>QUANTITY</th>                                    
                                    </tr>                                
                                    @if(!empty($value['detail']))
                                        @foreach($value['detail'] as $key=>$res)                                    
                                            <tr>  
                                                <td>
                                                    <select name="addmore[{{ $value['country']['id'] }}][{{$key}}][component_id]" class="form-control">                                   
                                                        @foreach($rescomponenst as $component)
                                                            <option value="{{$component->id}}" @if($component->id == $res['component_id']) selected @endif>{{$component->component_id}}</option>
                                                        @endforeach
                                                    </select>    
                                                </td>  
                                                <td><input type="text" name="addmore[{{ $value['country']['id'] }}][{{$key}}][quantity]"  value={{ $res['quantity'] }} class="form-control" /></td>  
                                                <td>
                                                    @if($key == 0)
                                                        <button type="button" name="add" id="add" data-id="{{$value['country']['id']}}" class="btn btn-success">Add More</button>
                                                    @else
                                                        <button type="button" class="btn btn-danger remove-tr">Remove</button>
                                                    @endif
                                                </td>                            
                                            </tr> 
                                        @endforeach                                 
                                    @endif
                                </table>
                            @endforeach
                        @endif
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
<script>
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
            //                             @foreach($components as $component)
            // html +=                         '<option value="{{$component->id}}">'+{{$component->component_id}}+'</option>';
            //                             @endforeach   
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
    var i = {{ count($job_activity->resources) }};
       
    //    $("#add").click(function(){
      
    //        ++i;
      
    //        $("#dynamicTable").append(
    //            '<tr>'+
    //              '<td>'+
    //                 '<select name="addmore['+i+'][component_id]"  class="form-control">'+
    //                                 '<option></option>'+
    //                                 @foreach($components as $component)
    //                                 '<option value="{{$component->id}}">'+{{$component->component_id}}+'</option>'+
    //                                 @endforeach
    //                            '</select>'+
    //                 '</td>'+
    //                 '<td><input type="text" name="addmore['+i+'][quantity]" placeholder="Enter your Qty" class="form-control" />'+
    //                 '</td>'+
    //                     '</td>'+
    //                     '<td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
    //    });

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
 