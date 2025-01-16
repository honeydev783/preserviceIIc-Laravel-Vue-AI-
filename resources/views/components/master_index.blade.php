@extends('layouts.master')
@section('contentheader_title','Resource Components')
@section('styles')
<style>
    .pull-right{
        float: right;
    }
    .edit-compid{
        display: none;
    }
</style>
@endsection
@section('content')
<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <form class="form-inline" method="post" action="{{ url('resource_components') }}">
                    @csrf  
                    <div class="form-group mx-sm-3 mb-2">
                        <input type="search" name="resource_type" onkeyup="searchResource()" class="form-control" id="resource_type" placeholder="Seach by Resource Type" style="width: 300px" value="">
                    </div>
                    <button type="button" onclick="searchResource()" class="btn btn-info mb-2 mr-2">Go</button>
                    <button type="button" onclick="clearSearch()" class="btn btn-outline-secondary mb-2 mr-2">Clear</button>
                    <button type="button" class="btn btn-outline-primary edit-comp-btn mb-2" onclick="renumberID()"><i class="fa fa-edit"></i> Renumber ID</i></button>
                </form>
            </div>
            <div class="pull-right mb-2">             
                <!-- <button type="button" class="btn btn-outline-primary edit-comp-btn"><i class="fa fa-edit"></i> Edit Component Ids</i></button>                   -->
                <button type="submit" form="form" class="btn btn-warning save-comp-ids edit-compid">Save Component Ids</button>                  
                <button type="button" class="btn btn-outline-secondary cancel-comp-btn edit-compid">Cancel Edit</button>                  
                <a class="btn btn-success" href="{{route('resource_components.create')}}"> Create New</a>               
                <a class="btn btn-info" href="{{route('resource_components.global')}}"> Set Global</a>               
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
   <form id="form" name="form" action="{{ route('resource_components.updateComponentIds') }}" method="post">
       @csrf
    <table id="dt_table" class="table table-bordered">
        <tr>
            <th>
                <input type="checkbox" class="all-checkbox" />
            </th>
            <th>COMPONENT ID</th>
            <th>RESOURCE TYPE</th>
            <th>Country</th>
            <th>RATE</th>  
            <th>Category</th>
            {{-- <th>QUANTITY</th>            --}}
            <th>UNIT</th>                                
            <th>Action</th>
        </tr>
        @foreach ($components as $component)
        <tr>
            <th>
                <input type="checkbox" class="row-checkbox" />
            </th>
            <td>
                <span class="compid_text">{{$component->component_id}}</span>
                <input type="hidden" disabled name="component_id[{{$component->id}}]" class="component_id form-control" value="{{ $component->component_id }}" />
            </td>            
            <td data-type="{{ $component->resource_type }}">{{ $component->resource_type }}</td>
            <td>{{$component->countrys->country_name}}</td>
            <td>
                <?php 
                    if($component->category == 'Labour')
                    {
                        $rate = ($component->rate * ($component->countrys->labour_rate / 100));
                    }
                    elseif($component->category == 'Equipment')
                    {
                        $rate = ($component->rate * ($component->countrys->equipment_rate / 100));
                    }
                    elseif($component->category == 'Material')
                    {
                        $rate = ($component->rate * ($component->countrys->material_rate / 100));
                    }
                    else{
                        $rate = $component->rate;
                    }
                ?>                
                ${{ number_format($rate,2) }}</td>                    
            <td>{{ $component->category }}</td>
            {{-- <td>{{ $component->quantity }}</td> --}}
            <td>{{ $component->unit }}</td>            
            <td>
                <!-- <form action="{{route('resource_components.destroy',$component->id)}}" method="POST">                     -->
                    <a class="btn btn-primary" href="{{route('resource_components.edit',$component->id)}}">Edit</a>
                    <!-- @csrf
                    @method('DELETE')       -->
                    <!-- <button type="submit" class="btn btn-danger">Delete</button> -->
                    <button type="button" class="btn btn-danger" onclick="deleteComponent('{{$component->id}}')">Delete</button>
                    <a class="btn btn-primary" href="{{route('resource_components.copy',$component->id)}}">Copy</a>
                <!-- </form> -->
            </td>
        </tr>
        <?php $country_components = getComponent($component->component_id, $component->id) ?>
        @if(!empty($country_components))
            @foreach($country_components as $component)            
                <tr>
                    <th></th>
                    <td></td>            
                    <td></td>
                    <td>{{$component->countrys->country_name}}</td>
                    <td>
                        <?php 
                            if($component->category == 'Labour')
                            {
                                $rate = ($component->rate * ($component->countrys->labour_rate / 100));
                            }
                            elseif($component->category == 'Equipment')
                            {
                                $rate = ($component->rate * ($component->countrys->equipment_rate / 100));
                            }
                            elseif($component->category == 'Material')
                            {
                                $rate = ($component->rate * ($component->countrys->material_rate / 100));
                            }
                            else{
                                $rate = $component->rate;
                            }
                        ?>                
                        ${{ number_format($rate,2) }}</td>                    
                    <td>{{ $component->category }}</td>
                    <td>{{ $component->unit }}</td>
                    <td></td>
                </tr>
            @endforeach            
        @endif
        @endforeach
    </table>
    {{ $components->links() }}
   </form>
@endsection
@section('scripts')
    <script  type="text/javascript">        
        $(document).ready(function(){
            $(".all-checkbox").change(function(){
                if($(this).is(":checked")){
                    $(".row-checkbox").prop("checked",true);
                    $(this).parents('#dt_table').find(".component_id").attr("type","text");
                    $(this).parents('#dt_table').find(".component_id").removeAttr("disabled");
                    $(this).parents('#dt_table').find(".compid_text").hide();
                }else{
                    $(".row-checkbox").prop("checked",false);
                    $(this).parents('#dt_table').find(".component_id").attr("type","hidden");
                    $(this).parents('#dt_table').find(".component_id").attr("disabled","disabled");
                    $(this).parents('#dt_table').find(".compid_text").show();
                }
                if($(".row-checkbox:checked").length > 0){
                    $(".edit-compid").show();
                }else{
                    $(".edit-compid").hide();
                }
            })
            $(".row-checkbox").change(function(){
                if($(this).is(":checked")){
                    $(this).parents('tr').find(".component_id").attr("type","text");
                    $(this).parents('tr').find(".component_id").removeAttr("disabled");
                    $(this).parents('tr').find(".compid_text").hide();
                }else{
                    $(this).parents('tr').find(".component_id").attr("type","hidden");
                    $(this).parents('tr').find(".component_id").attr("disabled","disabled");
                    $(this).parents('tr').find(".compid_text").show();
                }
                if($(".row-checkbox:checked").length > 0){
                    $(".edit-compid").show();
                   
                }else{
                    $(".edit-compid").hide();
                }
            })
            $(".cancel-comp-btn").click(function(){
                $(".edit-compid").hide();
                $(".component_id").attr("type","hidden");
                $(".component_id").attr("disabled","disabled");
                $(".compid_text").show();
                $(".row-checkbox,.all-checkbox").prop("checked",false);
            });
            // $(".save-comp-ids").click(function(){

            // })
        })
        function deleteComponent(id)
        {
            if (confirm('Data will be permanently deleted. Are you sure you want to delete?')) {                
                var url = window.location.origin+'/resource_components/delete/'+id;                
                window.location.assign(url);
            }            
        }

        function renumberID()
        {
            if (confirm('Are you sure you want to renumber component ID #?')) {
                var url = window.location.origin+'/updateComponentIdsSequentially.php';
                window.location.assign(url);       
            }  
        }

        function searchResource() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("resource_type");
            filter = input.value.toUpperCase();
            table = document.getElementById("dt_table");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
                }       
            }
        }

        function clearSearch(){
            $("#resource_type").val('');
            searchResource();
        }
    </script>
@endsection