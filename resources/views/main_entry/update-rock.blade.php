@extends('layouts.master')
@section('contentheader_title','Update Rock')
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
   
<form action="{{route('main_entry.updateRock.post',$rock->id)}}" method="POST">
    @csrf  
     <div class="row">               
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label><strong>Rock Value:</strong>
                <input type="number" step="0.01" name="rock_value" value="{{$rock->rock_value}}" required>
                <input type="hidden" name="category" value="{{$rock->category}}" required>
            </label>
            </div>
        </div>
             
        <div class="col-xs-12 col-sm-12 col-md-12">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>        
    </div>   
</form>
@endsection