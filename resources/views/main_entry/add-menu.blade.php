@extends('layouts.master')
@section('Add Menu')
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
            <a class="btn btn-primary" href="{{route('dashboard')}}"> Back</a>                
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
   
<form action="{{route('save-menu')}}" method="POST">
    @csrf  
     <div class="row">        
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>Menu Name</strong>
                <input type="text" name="menu" value="{{old('menu')}}" class="form-control" required>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>Url Name</strong>
                <input type="text" name="url" value="{{old('url')}}" class="form-control" required>
            </div>
        </div>        
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <br>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>        
    </div>   
</form>
@endsection