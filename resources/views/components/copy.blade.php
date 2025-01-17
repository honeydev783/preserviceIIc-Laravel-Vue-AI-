@extends('layouts.master')
@section('contentheader_title')
Resource Component Add
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
   
<form action="{{route('resource_components.copydata')}}" method="POST">
    @csrf 
    <input type="hidden" name="previous_url" value="{{ url()->previous() }}"> 
    <div class="row">  
        <div class="col-xs-6 col-sm-6 col-md-6"> 
        <div class="card"> 
            <div class="card-body">                                      
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Component ID:</strong>
                        <input type="text" name="component_id" value="{{$resource_component->component_id}}" class="form-control" >
                    </div>
                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Resource Type:</strong>
                        <input type="text" name="resource_type" value="{{$resource_component->resource_type}}" class="form-control" >
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Category:</strong>
                        <select name="category" id="" class="form-control">
                            
                            <option value="Preliminries"@if($resource_component->category == 'Preliminries') selected @endif>Preliminries</option>
                            <option value="Labour"@if($resource_component->category == 'Labour') selected @endif>Labour</option>
                            <option value="Equipment"@if($resource_component->category == 'Equipment') selected @endif>Equipment</option>
                            <option value="Material"@if($resource_component->category == 'Material') selected @endif>Material</option>
                        </select>
                    </div>
                </div>

                {{-- <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Quantity:</strong>
                        <input type="number" name="quantity" value="{{$resource_component->quantity}}" class="form-control" >
                    </div>
                </div> --}}

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Unit:</strong>
                        <input type="text" name="unit" value="{{$resource_component->unit}}" class="form-control" >
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Rate:</strong>
                        <input type="number" name="rate" value="{{$resource_component->orignal_rate}}" class="form-control" >
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Country:</strong>
                        <select name="country" id="" class="form-control">
                            <option value="">Please select country</option>
                            @foreach($countries as $country)
                                <option {{$country->id == $resource_component->country ? 'selected' : "" }} value="{{$country->id}}">{{$country->country_name}}</option>
                            @endforeach                            
                        </select>
                    </div>
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