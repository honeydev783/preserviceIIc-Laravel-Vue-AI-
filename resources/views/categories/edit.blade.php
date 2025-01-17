@extends('layouts.master')
@section('contentheader_title')
Category Edit
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
   
<form action="{{route('categories.update', $category->id)}}" method="POST">
    @csrf 
    @method('PUT')
    <div class="row">  
        <div class="col-xs-6 col-sm-6 col-md-6"> 
            <div class="card"> 
                <div class="card-body">                                      
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Category Name:</strong>
                            <input type="text" name="title" value="{{$category->title}}" class="form-control" >
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