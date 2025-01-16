@extends('layouts.master')
@section('contentheader_title','Approx Estimate Cost Form List')
@section('styles')
<style>
    .pull-right{
        float: right;
    }
    .is-countdown {
        background-color: transparent !important;
        border: none !important;
        font-size: 12px;
    }
    .table-bordered td, .table-bordered th {
        vertical-align: middle;
    }
    .expiry_time {
        font-size: 20px;
    }
</style>
@endsection
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>Form Name</th>        
            <th>Date</th>
            <th>Action</th>
            <th>Expiry Time</th>
        </tr>
        @foreach ($costForms as $costForm)
        <tr>
            <td>{{$costForm->form_name}}</td>
            <td>{{date('m/d/Y', strtotime($costForm->created_at))}}</td>
            <td>                                                
                <a class="btn btn-primary" href="{{route('cost-estimate.restore_form',$costForm->id)}}">Restore</a> 
                <a class="btn btn-danger" href="{{route('cost-estimate.destroy',$costForm->id)}}">Delete</a>
            </td>
            <td>
                @if($costForm->expiry_time != '')
                    <span class="expiry_time" data-expiry-time="{{ $costForm->expiry_time }}"></span>
                @else
                    <span>Endless</span>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
    {{$costForms->links()}}
@endsection

@section("scripts")

<script>
    $(document).ready(function(){
        initCounter();
        setInterval(() => {
            initCounter();
        }, 1000);
    });
    function initCounter(){
        $(".expiry_time").each(function(){
            var expiryTime = $(this).data("expiry-time"); 
            var time = countDown(expiryTime);
            $(this).html(time);
        });   
    }
</script>
@endsection