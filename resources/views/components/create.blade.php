@extends('layouts.master')
@section('contentheader_title')
Resource Component Create
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
   
<form action="{{route('resource_components.store')}}" method="POST">
    @csrf
    <input type="hidden" name="previous_url" value="{{ url()->previous() }}"> 
    <div class="row">  
        <div class="col-xs-6 col-sm-6 col-md-6"> 
        <div class="card"> 
            <div class="card-body">                                      
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Component ID:</strong>
                        <input type="text" name="component_id" value="{{old('component_id')}}" class="form-control" >
                    </div>
                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Resource Type:</strong>
                        <input type="text" name="resource_type" value="{{old('resource_type')}}" class="form-control" >
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Category:</strong>
                        <select name="category" id="category" class="form-control">
                            <option value="">Please select category</option>
                            <option  {{ old('category') == 'Preliminries' ? "selected" : "" }} value="Preliminries">Preliminries</option>
                            <option  {{ old('category') == 'Labour' ? "selected" : "" }} value="Labour">Labour</option>
                            <option  {{ old('category') == 'Equipment' ? "selected" : "" }} value="Equipment">Equipment</option>
                            <option  {{ old('category') == 'Material' ? "selected" : "" }} value="Material">Material</option>
                        </select>
                    </div>
                </div>

                {{-- <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Quantity:</strong>
                        <input type="number" name="quantity" value="{{old('quantity')}}" class="form-control" >
                    </div>
                </div> --}}

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Unit:</strong>
                        <input type="text" name="unit" value="{{old('unit')}}" class="form-control" >
                    </div>
                </div>

                {{--<div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Rate:</strong>
                        <input type="text" name="rate" value="{{old('rate')}}" class="form-control" >
                    </div>
                </div>--}}

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Country:</strong>
                        {{-- <select name="country" id="" class="form-control">
                            <option value="">Please select country</option>
                            @foreach($countries as $country)
                                <option value="{{$country->id}}">{{$country->country_name}}</option>
                            @endforeach                            
                        </select> --}}
                        <select name="country[]" class="form-control js-example-basic-multiple" multiple="multiple" id="mySelect2">
                            <option value=""></option>
                            @foreach($countries as $countrie)
                            <option {{$countrie->id == old('country') ? 'selected': ''}} value="{{$countrie->id}}">{{$countrie->country_name}}</option>
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
        <div> 
        </div> 
    </div> 
</form>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script  type="text/javascript">            
    $(document).ready(function(){    
        $('.js-example-basic-multiple').select2();    
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
@endsection
