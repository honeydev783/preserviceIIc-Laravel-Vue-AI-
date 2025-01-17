@extends('layouts.master')
@section('contentheader_title','APPROXIMATE COST ESTIMATION FORM')
@section('content')
<input type="hidden" name="id" value="{{$data['id']}}" id="approx_id">
<cost-estimate-form></cost-estimate-form>
@endsection