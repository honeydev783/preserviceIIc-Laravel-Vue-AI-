@extends('layouts.master')
@section('contentheader_title','Countries')
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
            <div class="pull-left">
                
            </div>
            <div class="pull-right mb-2">                               
                <a class="btn btn-success" href="{{route('detail_estimate.create')}}"> Create New</a>               
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>COUNTRY</th>   
            <th>Labour Rate</th>
            <th>Equipment Rate</th>
            <th>Material Rate</th>
            <th>Action</th>
        </tr>
        @foreach ($countries as $country)
        <tr>
            <td>{{$country->country_name}}</td>
            <td>{{$country->labour_rate}}</td>
            <td>{{$country->equipment_rate}}</td>
            <td>{{$country->material_rate}}</td>
            <td>
                <form action="{{route('detail_estimate.destroy',$country->id)}}" method="POST">                    
                    <a class="btn btn-primary" href="{{route('detail_estimate.edit',$country->id)}}">Edit</a>
                    @csrf
                    @method('DELETE')      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $countries->links() !!}
   
@endsection