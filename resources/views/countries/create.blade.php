@extends('layouts.master')
@section('contentheader_title')
Countries Create
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
   
<form action="{{route('countries.store')}}" method="POST">
    @csrf 
    <div class="row">  
        <div class="col-xs-6 col-sm-6 col-md-6"> 
            <div class="card"> 
                <div class="card-body">                                      
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Country Name:</strong>
                            <input type="text" name="country_name" value="{{old('country_name')}}" class="form-control" >
                        </div>
                    </div> 
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Labour Rate:</strong>
                            <input type="number" name="labour_rate" value="{{old('labour_rate')}}" class="form-control" min="0">
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Equipment Rate:</strong>
                            <input type="number" name="equipment_rate" value="{{old('equipment_rate')}}" class="form-control" min="0">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Material Rate:</strong>
                            <input type="number" name="material_rate" value="{{old('material_rate')}}" class="form-control" min="0">
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