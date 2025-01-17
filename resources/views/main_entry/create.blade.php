@extends('layouts.master')
@section('contentheader_title')
{{session('title')}} Create
@endsection 
@section('styles')
<style>
    .pull-right{
        float: right;
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
   
<form action="{{route(session::get('store_route_name'))}}" method="POST">
    @csrf  
     <div class="row">        
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>ELEMENT DESCRIPTION:</strong>
                <textarea class="form-control" style="height:150px" name="description"  required>{{old('description')}}</textarea>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>ELEMENT CODE:</strong>
                <input type="text" name="element_code" value="{{old('element_code')}}" class="form-control" required>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>COST / M2 GFA:</strong>
                <input type="number" name="cost_m2" step="0.01" value="{{old('cost_m2')}}" class="form-control" required>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>UNIT / M2:</strong>
                <input type="text" name="unit_m2" value="{{old('unit_m2')}}" class="form-control" required>
            </div>
        </div>
        <div class="col-xs-6 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>COST / SF GFA:</strong>
                <input type="number" name="cost_sf" step="0.01" value="{{old('cost_sf')}}" class="form-control" required>
            </div>
        </div>
        <div class="col-xs-6 col-sm-4= col-md-4">
            <div class="form-group">
                <strong>UNIT / SF:</strong>
                <input type="text" name="unit_sf" value="{{old('unit_sf')}}" class="form-control" required>
            </div>
        </div>        
        <div class="col-xs-6 col-sm-4= col-md-4">
            <div class="form-group">
                <strong>Country:</strong>
                <select name="country" id="" class="form-control">
                    <option value="">Please select country</option>
                    @foreach($countries as $country)
                        <option value="{{$country->id}}">{{$country->country_name}}</option>
                    @endforeach                            
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>        
    </div>   
</form>
@endsection