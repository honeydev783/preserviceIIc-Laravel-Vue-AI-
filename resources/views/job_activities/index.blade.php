<?php 
    use App\Models\Countries;
?>
@extends('layouts.master')
@section('contentheader_title','Job Activities')
@section('styles')
<style>
    .pull-right{
        float: right;
    }
    .pagination
    {
        display: table !important;
        width: 100% !important;
    }
    li.page-item {
        display: inline-block !important;
        margin-top: 5px !important;
    }
    .edit-actcode,.activity_edit{
        display: none;
    }
    textarea.edit-actcode.activity_edit.form-control {
        height: 99px;
    }
    .row_position th, .row_position td {
        vertical-align: middle;
    }
    .btn-action .btn {
        margin: 0px 5px;
        border-radius: 0px;
    }
</style>
@endsection
@section('content')
<div class="row">
        <div class="col-lg-12 margin-tb mb-3">
            <div class="pull-left">
                <form class="form-inline" method="post" action="{{ url('job_activities') }}">
                    @csrf  
                    <div class="form-group mb-2 mr-2">
                        <input type="search" name="activity" class="form-control" id="inputPassword2" placeholder="Activity Code" style="width: 300px" value="{{$activity_code}}">
                    </div>
                    <button type="submit" class="btn btn-info mb-2">Go</button>
                </form>
            </div>
            <div class="pull-left ml-10" style="width:250px;margin-left:15px">
                <form class="form-inline" id="sort_form" method="get" action="{{ url('job_activities') }}">
                    
                    <select name="sort_by" class="sort_by">
                        <option value="">Sort By</option>
                        <option {{$sort_by == 'position_order'?'selected':''}} value="position_order">Position</option>
                        <option {{$sort_by == 'activity_code'?'selected':''}} value="activity_code">Activity Code</option>
                    </select>
                </form>
            </div>
            <div class="pull-right mb-2"> 
                <?php 
                    $last_page = $actives->lastPage();                
                    $page = 1;
                    if(isset($_GET['page']))
                    {
                        $page = $_GET['page'];
                    }
                ?>
                
                    @csrf                      
                    <div class="btn-group btn-action">
                <?php 
                    if($page != 1)
                    {
                ?>                          
                        <!-- <a class="btn btn-primary" href="{{route('job_activities.updateorderprv', $page)}}"> Prev Move</a>                -->
                        <button type="button" class="btn btn-info prev-move"> Prev Move</button>
                <?php
                    }  
                    if($last_page != $page)
                    {
                ?>
                        <button type="button" class="btn btn-info next-move"> Next Move</button>
                
                <?php 
                    }
                ?>
                        <button type="submit" form="form" class="btn btn-warning save-comp-ids edit-actcode">Save Activities</button>                  
                        <button type="button" class="btn btn-outline-secondary cancel-comp-btn edit-actcode">Cancel Edit</button>                  
                        <a class="btn btn-success" href="{{route('job_activities.create')}}"> Create New</a>               
                        <a class="btn btn-info" href="{{route('job_activities.global')}}"> Set Global</a>               
                    </div>
                
            </div>
        </div>
    </div>
   
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
    <form id="form" name="form" action="{{ route('job_activities.updateActivityCode') }}" method="post">
       @csrf
       <div class="table-responsive">
        <table id="dt_table" class="table table-bordered">
            <tr>
                <th>
                    <input type="checkbox" class="all-checkbox" />
                </th>
                <th>#</th>
                <th>ELEMENT DESCRIPTION</th>
                <th>ACTIVITY CODE</th>
                <th>ACTIVITY DESCRIPTION</th>
                <th>COUNTRY</th>
                <th>Imperial Unit</th>
                <th>Metric Unit</th>
                <th>Conversion Factor</th>
                <th>Components / Quantity</th> 
                {{-- <th>Quantity</th>            --}}
                <th>Action</th>
            </tr>
            <tbody class="row_position">
                @foreach ($actives as $active)
                <tr id="{{$active->id}}">
                    <th>
                        <input value="{{$active->id}}" type="checkbox" class="row-checkbox" />
                    </th>
                    <td width="10%">
                        {{$active->position_order}}
                    </td>
                    <td>{{$active->category_name}}</td>
                    <td>
                        <span class="act_text">{{ $active->activity_code }}</span>
                        <input type="text" disabled name="activity_code[{{$active->id}}][activity_code]" class="activity_edit form-control" value="{{ $active->activity_code }}" />
                    </td>
                    <td>
                    <span class="act_text">{{ $active->description }}</span>
                        <textarea disabled name="activity_code[{{$active->id}}][description]" class="activity_edit form-control">{{ $active->description }}</textarea>
                    </td>
                    <?php 
                        $country_ids = explode(',', $active->country_id);
                        $countrys = Countries::whereIn('id', $country_ids)->get();                
                    ?>
                    <td>             
                        <select width="100%">
                            @foreach($countrys as $country)
                                <option>{{$country->country_name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>{{ $active->imperial_unit }}</td>
                    <td>{{ $active->metric_unit }}</td>
                    <td>{{ $active->conservation_factor }}</td>
                    <td>
                        @foreach($active->resources as $res)
                        {{ $res->component->component_id ?? Null  }} / {{ $res->quantity }} </br>
                        @endforeach
                    </td> 
                    {{-- <td>
                        @foreach($active->resources as $res)
                        {{ $res->component->component_id ?? Null }},
                        @endforeach
                    </td>  --}}
                    {{-- <td>
                        @foreach($active->resources as $res)
                        {{ $res->quantity }},
                        @endforeach    
                    </td>                    --}}
                    <td>
                        <div class="btn-group btn-action">
                        <!-- <form action="{{route('job_activities.destroy',$active->id)}}" method="POST">                     -->
                            <a class="btn btn-primary" href="{{route('job_activities.edit',$active->id)}}">Edit</a>
                            <!-- @csrf
                            @method('DELETE')       -->
                            <button class="btn btn-danger" type="button" onclick="deleteActivity('{{$active->id}}')">Delete</button>
                            <a class="btn btn-primary" href="{{route('job_activities.copy',$active->id)}}">Copy</a>
                        <!-- </form> -->
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </form>
    <div class="d-flex justify-content-left">
        <nav>
            <?php 
                $total_pages = ceil($actives->total() / 50) ;
                if(isset($_GET['page']))
                {
                    $prv = $_GET['page'] - 1;
                    $next = $_GET['page'] + 1;
                    $page = $_GET['page'];
                }
                else{
                    $prv = 1;
                    $next = 1;
                    $page = 1;
                }
            ?>
            <ul class="pagination">                                                
                @if($page != 1)                    
                    <li class="page-item"><a href="{{ url('/') }}/job_activities?page={{ $prv }}&sort_by={{$sort_by}}" rel="prev" aria-label="« Previous" class="page-link">‹</a></li>                                
                @else
                    <li aria-disabled="true" aria-label="« Previous" class="page-item disabled"><span aria-hidden="true" class="page-link">‹</span></li>
                @endif
                <?php                     
                    for($i = 1; $i <= $total_pages; $i++){                                
                        ?>
                            @if($i == $page)
                                <li aria-current="page" class="page-item active"><span class="page-link">{{$i}}</span></li>
                            @else
                                <li class="page-item"><a href="{{ url('/') }}/job_activities?page={{ $i }}&sort_by={{$sort_by}}" class="page-link">{{ $i }}</a></li>                
                            @endif                            
                    <?php }
                    ?> 
                @if($page == $total_pages)
                    <li aria-disabled="true" aria-label="Next »" class="page-item disabled"><span aria-hidden="true" class="page-link">›</span></li>
                @else
                    <li class="page-item"><a href="{{ url('/') }}/job_activities?page={{ $next }}&sort_by={{$sort_by}}" rel="next" aria-label="Next »" class="page-link">›</a></li>
                @endif                
            </ul>
        <nav>                    
        
        <!-- {!! $actives->onEachSide(30)->links() !!}         -->
    </div>
@endsection
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script  type="text/javascript">   
        $(document).ready(function(){
            $("select").select2();
            $(".sort_by").change(function(){
                $("#sort_form").submit();
            })
            $(".next-move").click(function(){

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');   
                var ids = [];
                if($(".row-checkbox:checked").length == 0){
                    alert("Select records to move next");
                    return false;
                }
                $(".row-checkbox:checked").each(function(){
                    ids.push($(this).val());
                });
                $(this).attr("disabled","disabled");
                $(this).html("Processing...");
                $.ajax({
                    url:"{{route('job_activities.updateordernext', $page)}}",
                    type:'post',
                    dataType:"json",
                    data:{
                        _token: CSRF_TOKEN, 
                        ids:ids, 
                        page:{{$page}}
                    },
                    success:function(response){
                        location.reload();
                    }
                })
            });
            $(".prev-move").click(function(){
              
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');   
                var ids = [];
                if($(".row-checkbox:checked").length == 0){
                    alert("Select records to move prev");
                    return false;
                }
                $(".row-checkbox:checked").each(function(){
                    ids.push($(this).val());
                });       

                $(this).attr("disabled","disabled");
                $(this).html("Processing...");
                $.ajax({
                    url:"{{route('job_activities.updateorderprv', $page)}}",
                    type:'post',
                    dataType:"json",
                    data:{
                        _token: CSRF_TOKEN, 
                        ids:ids, 
                        page:{{$page}}
                    },
                    success:function(response){
                        location.reload();
                    }
                })
            });
            $(".all-checkbox").change(function(){
                if($(this).is(":checked")){
                    $(".row-checkbox").prop("checked",true);
                    // $(this).parents('#dt_table').find(".activity_edit").attr("type","text");
                    $(this).parents('#dt_table').find(".activity_edit").show();
                    $(this).parents('#dt_table').find(".activity_edit").removeAttr("disabled");
                    $(this).parents('#dt_table').find(".act_text").hide();
                }else{
                    $(".row-checkbox").prop("checked",false);
                    // $(this).parents('#dt_table').find(".activity_edit").attr("type","hidden");
                    $(this).parents('#dt_table').find(".activity_edit").hide();
                    $(this).parents('#dt_table').find(".activity_edit").attr("disabled","disabled");
                    $(this).parents('#dt_table').find(".act_text").show();
                }
                if($(".row-checkbox:checked").length > 0){
                    $(".edit-actcode").show();
                }else{
                    $(".edit-actcode").hide();
                }
            })
            $(".row-checkbox").change(function(){
                if($(this).is(":checked")){
                    // $(this).parents('tr').find(".activity_edit").attr("type","text");
                    $(this).parents('tr').find(".activity_edit").show();
                    $(this).parents('tr').find(".activity_edit").removeAttr("disabled");
                    $(this).parents('tr').find(".act_text").hide();
                }else{
                    // $(this).parents('tr').find(".activity_edit").attr("type","hidden");
                    $(this).parents('tr').find(".activity_edit").hide();
                    $(this).parents('tr').find(".activity_edit").attr("disabled","disabled");
                    $(this).parents('tr').find(".act_text").show();
                }
                if($(".row-checkbox:checked").length > 0){
                    $(".edit-actcode").show();
                   
                }else{
                    $(".edit-actcode").hide();
                }
            });
            $(".cancel-comp-btn").click(function(){
                $(".edit-actcode").hide();
                $(".activity_edit").hide();
                $(".activity_edit").attr("disabled","disabled");
                $(".act_text").show();
                $(".row-checkbox,.all-checkbox").prop("checked",false);
            });
            // $(".save-comp-ids").click(function(){

            // })
        })     
        function deleteActivity(id)
        {
            if (confirm(' Data will be permanently deleted. Are you sure you want to delete?')) {                
                var url = '{{URL::to("/")}}/job_activities/delete/'+id;                
                window.location.assign(url);
            }            
        }
        $(".row_position").sortable({
            delay: 150,
            stop: function() {
                var selectedData = new Array();
                $('.row_position>tr').each(function() {
                    selectedData.push($(this).attr("id"));
                });
                updateOrder(selectedData);
            }
        });

        function updateOrder(data) {
            var page = '<?php echo $page; ?>';

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');            
            $.ajax({
                url:"job_activities/updateorder",
                type:'post',
                data:{_token: CSRF_TOKEN, position:data, page:page},
                success:function(){
                    location.reload();
                }
            })
        }        
    </script>
@endsection