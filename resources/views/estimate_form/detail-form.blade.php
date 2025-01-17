@extends('layouts.master')
@section('contentheader_title','DETAIL COST ESTIMATION FORM')
@section('content')
<input type="hidden" name="id" value="{{$data['id']}}" id="detail_id">
<detail-estimate-form></detail-estimate-form>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
@endsection


