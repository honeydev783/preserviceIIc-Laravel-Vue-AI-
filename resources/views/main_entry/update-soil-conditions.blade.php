@extends('layouts.master')
@section('contentheader_title','Update Soil Conditions Value')
@section('styles')
<style>
    .pull-right{
        float: right;
    }
</style>
@endsection
@section('content')

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif
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
   
<form action="{{route('main_entry.updateSoilConditions.post',$soil_condition->id)}}" method="POST">
    @csrf  
     <div class="row">               
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label><strong>Sandy Soil:</strong>
                    <input type="number" step="0.01" name="sandy_soil" value="{{$soil_condition->sandy_soil}}" required>
                    <input type="hidden" name="category" value="{{$soil_condition->category}}" required>
                </label>
            </div>
            <div class="form-group">
                <label><strong>Loam Soil:</strong>
                    <input type="number" step="0.01" name="loam_soil" value="{{$soil_condition->loam_soil}}" required>                    
                </label>
            </div>
            <div class="form-group">
                <label><strong>Soft Clay Soil:</strong>
                    <input type="number" step="0.01" name="soft_clay_soil" value="{{$soil_condition->soft_clay_soil}}" required>                    
                </label>
            </div>
            <div class="form-group">
                <label><strong>Stiff Clay Soil:</strong>
                    <input type="number" step="0.01" name="stiff_clay_soil" value="{{$soil_condition->stiff_clay_soil}}" required>                    
                </label>
            </div>
            <div class="form-group">
                <label><strong>Hard Soil:</strong>
                    <input type="number" step="0.01" name="hard_soil" value="{{$soil_condition->hard_soil}}" required>                    
                </label>
            </div>
            <div class="form-group">
                <label><strong>Soft Soil:</strong>
                    <input type="number" step="0.01" name="soft_soil" value="{{$soil_condition->soft_soil}}" required>                    
                </label>
            </div>
            <div class="form-group">
                <label><strong>Ordinary Soil:</strong>
                    <input type="number" step="0.01" name="ordinary_soil" value="{{$soil_condition->ordinary_soil}}" required>                    
                </label>
            </div>
        </div>
             
        <div class="col-xs-12 col-sm-12 col-md-12">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>        
    </div>   
</form>
@endsection