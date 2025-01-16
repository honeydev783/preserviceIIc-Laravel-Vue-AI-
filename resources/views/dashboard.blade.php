@extends('layouts.master')
@section('contentheader_title','Dashboard') 
@section('styles')
<style>

    .is-countdown {
        background-color: transparent !important;
        border: none !important;
        font-size: 12px;
    }
    .note {
      font-size: 18px;
      color: #FF0000;
    }
</style>
@endsection
@section('content')
@if($exp_approx_forms > 0)
<!-- Modal -->
<div id="approxModal" data-keyboard="false" data-backdrop="static" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Approx Estimate Forms Expiry</h5>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body">
        <p class="note">
          <strong>Please note:</strong>
          Your saved data will become inaccessible,
          once your storage data allotted time is expired.
          Kindly review and print project promptly. Thank You!
        </p>
        <table class="table table-bordered">
            <tr>
                <th>Form Name</th>        
                <th>Date</th>
                <th>Expiry Time</th>
            </tr>
            @foreach ($approx_forms as $approx_form)
            <tr>
                <td>{{$approx_form->form_name}}</td>
                <td>{{date('m/d/Y', strtotime($approx_form->created_at))}}</td>
                <td>
                    @if($approx_form->expiry_time != '')
                        <span class="expiry_time" data-expiry-time="{{ $approx_form->expiry_time }}"></span>
                    @else
                        <span>Endless</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btn-lg" onclick="closeApprox()">Close</button>
      </div>
    </div>

  </div>
</div>
@endif

@if($exp_detail_forms > 0)
<!-- Modal -->
<div id="detailEstModel" data-keyboard="false" data-backdrop="static" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Estimate Expiry Form</h5>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body">
        <p class="note">
          <strong>Please note:</strong>
          Your saved data will become inaccessible,
          once your storage data allotted time is expired.
          Kindly review and print project promptly. Thank You!
        </p>
        <table class="table table-bordered">
            <tr>
                <th>Form Name</th>      
                <th>Expiry Time</th>
            </tr>
            @foreach ($detail_forms as $detail_form)
            
            <tr>
                <td>{{$detail_form->form_name}}</td>
                <td>
                    @if($detail_form->expiry_time != '')
                        <span class="expiry_time" data-expiry-time="{{ $detail_form->expiry_time }}"></span>
                    @else
                        <span>Endless</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btn-lg" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@endif
    <img src="{{asset('/images/bg.jpg')}}">          
@endsection

@section("scripts")
<script>
@if(count($exp_approx_forms) > 0)
    $("#approxModal").modal("show");
@elseif(count($exp_detail_forms) > 0)
    $("#detailEstModel").modal("show");
@endif
</script>
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

function closeApprox(){
    $("#approxModal").modal("hide");
    @if(count($exp_detail_forms) > 0)
        $("#detailEstModel").modal("show");
    @endif
}
</script>
@endsection