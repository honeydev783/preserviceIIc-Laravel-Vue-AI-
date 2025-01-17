@extends('layouts.master')
@section('contentheader_title')
    Countries Edit
@endsection
@section('styles')
    <style>
        .pull-right {
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

    <form action="{{ route('approx_estimate.update', $country->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Country Name:</strong>
                                <input type="text" name="country_name" value="{{ $country->country_name }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Cost Index:</strong>
                                <input type="number" name="labour_rate" value="{{ $country->labour_rate }}"
                                    class="form-control" min="0">
                            </div>
                        </div>

                        <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Equipment Rate:</strong>
                                <input type="number" name="equipment_rate" value="{{ $country->equipment_rate }}"
                                    class="form-control" min="0">
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Material Rate:</strong>
                                <input type="number" name="material_rate" value="{{ $country->material_rate }}"
                                    class="form-control" min="0">
                            </div>
                        </div> -->
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    <div>
                    </div>
                </div>
    </form>
@endsection
