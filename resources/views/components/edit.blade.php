@extends('layouts.master')
@section('contentheader_title')
Resource Component Edit
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

<form action="{{route('resource_components.update',$resource_component)}}" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="previous_url" value="{{ url()->previous() }}">
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Component ID:</strong>
                            <input type="text" name="component_id" value="{{$resource_component->component_id}}" class="form-control">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Resource Type:</strong>
                            <input type="text" name="resource_type" id="resource_type" value="{{$resource_component->resource_type}}" class="form-control">
                            <input type="hidden" name="resource_category" id="resource_category" value="{{$resource_component->category}}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Category:</strong>
                            <select name="category" id="category" class="form-control">

                                <option value="Preliminries" @if($resource_component->category == 'Preliminries') selected @endif>Preliminries</option>
                                <option value="Labour" @if($resource_component->category == 'Labour') selected @endif>Labour</option>
                                <option value="Equipment" @if($resource_component->category == 'Equipment') selected @endif>Equipment</option>
                                <option value="Material" @if($resource_component->category == 'Material') selected @endif>Material</option>
                            </select>
                        </div>
                    </div>

                    {{-- <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Quantity:</strong>
                            <input type="number" name="quantity" value="{{$resource_component->quantity}}" class="form-control" >
                </div>
            </div> --}}

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Unit:</strong>
                    <input type="text" id="component_unit" name="unit" value="{{$resource_component->unit}}" class="form-control">
                </div>
            </div>

            {{-- <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Rate:</strong>
                            <input type="text" name="rate" value="{{$resource_component->orignal_rate}}" class="form-control" >
        </div>
    </div> --}}

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Country:</strong>
            <select name="country[]" class="form-control js-example-basic-multiple" multiple="multiple" id="mySelect2">
                <option value="">Please select country</option>
                @foreach($countries as $country)
                <option <?php if (in_array($country->id, $country_ids)) echo 'selected'; ?> value="{{$country->id}}">{{$country->country_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @if(!empty($country_lists))
    <div id="components">
        @foreach($country_lists as $k => $country)
        <?php $k += 1; ?>
        <table class="table table-bordered" id="dynamicTable_{{$country->country}}">
            <tr>
                <th colspan="3" align="center">{{$country->countrys->country_name}}</th>
            </tr>
            <tr>
                <th>Rate</th>
                <th>Country Rate</th>
            </tr>
            <tbody class="row_position">
                <tr id="row_{{$country->country}}_{{$k}}">
                    <td>
                        <div class="form-group">
                            <span>$</span><input type="text" id="input_rate_{{$country->country}}" name="rate[{{$country->country}}]" class="form-control" oninput="rateCal({{$country->country}}, this)" value="{{$country->orignal_rate}}" style="display: inline-block; width: 90%;">
                        </div>
                    </td>
                    <td><input type="hidden" name="cal_rate[{{$country->country}}]" value="{{$country->rate}}" id="cal_rate_{{$country->country}}"> $<span id="rate_{{$country->country}}">{{$country->rate}}</span></td>
                </tr>
            </tbody>
        </table>
        @endforeach
    </div>
    @else
    <div id="components">

    </div>
    @endif
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    </div>
    <div>
    </div>
    </div>
    </div>
    <div class="col-xs-1 col-sm-1 col-md-1"> </div>
    <div class="col-xs-5 col-sm-5 col-md-5" style="border: 1px solid grey; padding: 30px;">
        <!--<h3>Online Vendors List and Prices of {{$resource_component->resource_type}}</h3>-->
        <div id="resourceaicompdata"></div>
    </div>
    </div>
</form>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
        resourceaieditdata();
    })

    $('#mySelect2').on('select2:select', function(e) {
        var data = e.params.data;
        console.log("select event data************", data);
        var html = '';
        html += '<table class="table table-bordered" id="dynamicTable_' + data.id + '">';
        html += '<tr>';
        html += '<th colspan="3" align="center">' + data.text + '</th>';
        html += '</tr>';
        html += '<tr>';
        html += '<th>Rate</th>';
        html += '<th>Country Rate</th>';
        html += '</tr>';
        html += '<tbody class="row_position">';
        html += '<tr id="row_' + data.id + '_0">';
        html += '<td>';
        html += '<div class="form-group">'
        html += '<input type="text" id="input_rate_' + data.id + '" name="rate[' + data.id + ']" class="form-control" oninput="rateCal(' + data.id + ', this)">';
        html += '</div>'
        html += '</td>';
        html += '<td><input type="hidden" name="cal_rate[' + data.id + ']" id="cal_rate_' + data.id + '"> <span id="rate_' + data.id + '"></span></td>'
        html += '</tr>';
        html += '</tbody>';
        html += '</table>';

        $('#components').append(html);
    });
    $('#mySelect2').on("select2:unselect", function(e) {
        var value = e.params.data.id;
        $('#dynamicTable_' + value).remove();
    });

    async function resourceaieditdata() {
        if (document.getElementById('resource_category').value == "Labour") {
            var resource_comp_data = 'Generate an HTML code for average hourly rate cost value of ' + document.getElementById('resource_type').value + ' job skills in USA area';
            axios.get("/predict?text=" + resource_comp_data).then(function(response) {
                $('#resourceaicompdata').html(response.data.candidates[0].content.parts[0].text);
            });
        } else if (document.getElementById('resource_category').value == "Equipment") {
            var resource_comp_data = 'Generate an HTML code for average hourly cost and cost of purchasing one of ' + document.getElementById('resource_type').value + ' Equipment in USA area';
            axios.get("/predict?text=" + resource_comp_data).then(function(response) {
                $('#resourceaicompdata').html(response.data.candidates[0].content.parts[0].text);
            });
        } else if (document.getElementById('resource_category').value == "Preliminries") {
            // var resource_comp_data = 'Generate an HTML code to get Prices ' + ' of' + document.getElementById('resource_category').value + 'consist of ' + document.getElementById('resource_type').value + 'as much as possible in USA area';
            var resource_comp_data = 'Generate an HTML code for  description, Component List, average hourly costs and company list with contact information of ' + result + ' Preliminries in USA area';
            
            // var resource_type = document.getElementById('resource_type').value;
            // const charsToRemove = "#"; // Characters to remove
            // const regex = new RegExp(`[${charsToRemove}]`, 'g'); // Create a regex to match the characters
            // const result = resource_type.replace(regex, '');
            // console.log("sfsfsfsdfs", document.getElementById('resource_type').value);
            axios.get("/predict?text=" + resource_comp_data).then(function(response) {
                $('#resourceaicompdata').html(response.data.candidates[0].content.parts[0].text);
            });
        }  else {
            var resource_type = document.getElementById('resource_type').value;
            const charsToRemove = "#"; // Characters to remove
            const regex = new RegExp(`[${charsToRemove}]`, 'g'); // Create a regex to match the characters
            const result = resource_type.replace(regex, '');
            console.log("sfsfsfsdfs", document.getElementById('resource_type').value);
            const unit = document.getElementById('component_unit').value;
            var query='Average cost of ' + result + 'per' + unit + ' Material in USA area';
            var html='';
            var resource_comp_data ='Generate an HTML table code for ' + ' famous USA construction material Suppliers only official website link  and contact information for ' + result + 'no need narrative';
            await axios.get("/predictprice?text=" + resource_comp_data).then(function(response) {
                var aidata = response.data;
                for(let i=0; i<aidata.length; i++) {
                    html+= aidata[i].candidates[0].content.parts[0].text;
                }
                  // $('#resourceaicompdata').html(html);
            }); 
            
            axios.get("/predict?text=" + query).then(function(response) {
                    html += response.data.candidates[0].content.parts[0].text;
                    $('#resourceaicompdata').html(html);
                });
        }



    }

    function rateCal(id, e) {
        console.log("rateCal e************", e);
        var rate = $(e).val();
        console.log("rateCal rate************", rate);
        var category = $('#category').val();
        var cal_rate = 0;
        // alert($('#mySelect2').val());
        if (category == 'Material') {
            $.ajax({
                type: "GET",
                url: "/country_details/" + id,
                dataType: 'json',
                success: function(result) {
                    cal_rate = rate * result.country.material_rate
                    $('#rate_' + id).text(cal_rate);
                    $('#cal_rate_' + id).val(cal_rate);
                }
            })
        } else {
            cal_rate = rate;
            $('#rate_' + id).text(cal_rate);
            $('#cal_rate_' + id).val(cal_rate);
        }
    }

    $('#category').on('change', function() {
        var country = $('#mySelect2').val().toString();
        var countrys = country.split(',')
        for (var i = 0; i < countrys.length; i++) {
            var rate = $('#input_rate_' + countrys[i]).val();
            var cal_rate = 0;
            if ($(this).val() == 'Material') {
                $.ajax({
                    type: "GET",
                    url: "/country_details/" + countrys[i],
                    dataType: 'json',
                    success: function(result) {
                        cal_rate = rate * result.country.material_rate
                        $('#rate_' + result.country.id).text(cal_rate);
                        $('#cal_rate_' + result.country.id).val(cal_rate);
                    }
                })
            } else {
                $('#rate_' + countrys[i]).text(rate);
                $('#cal_rate_' + countrys[i]).val(rate);
            }
        }
    })
</script>
@endsection