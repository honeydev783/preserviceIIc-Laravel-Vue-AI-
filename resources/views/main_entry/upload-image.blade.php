@extends('layouts.master')
@section('contentheader_title','Upload Image')
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
   
<form action="{{route('main_entry.uploadImage.post')}}" method="POST" enctype="multipart/form-data">
    @csrf  
     <div class="row">               
        <div class="col-xs-6 col-sm-6 col-md-6">
            <input type="hidden" name="category" value="{{$category}}">
            <div class="form-group">
                <label><strong>File:</strong><input type="file" name="file" value="" required></label>
            </div>
        </div>
             
        <div class="col-xs-12 col-sm-12 col-md-12">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>        
    </div>   
</form>
@endsection