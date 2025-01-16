<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css";>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js";></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js";></script>
        <title>Cost Estimate Form</title>
        <style>
           .pull-right{
                float: right;
            }
        </style>
    </head>
    <body>
        <div class="card text-white">
            <div class="card-body">
                <div class="form">   
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h2>Cost Estimate Agreement</h2>
                        </div>
                    </div>       
                    <div class="row">
                        <div class="col-md-12">
                            <table>
                                <tbody>
                                    <tr>
                                        <td><b>User Name:</b></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><b>Company Name:</b></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><b>Client's Name:</b></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><b>Estimate Date:</b></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><b>Project Description:</b></td>
                                        <td>{{$data['description']}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Project Location:</b></td>
                                        <td>{{$data['country']}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>         
                    <br/>                             
                    <div class="row">
                        <div class="col-md-12">
                            <h4>APPROXIMATE COST ESTIMATE</h4>
                        </div>  
                        <div class="col-md-12">
                            <b>Key Point Indicator (KPI)</b>
                        </div>                   
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <table>
                                <tbody>
                                    <tr>
                                        <td width="50%">
                                            <table>
                                                <tr>
                                                    <td><b>Project Type:</b></td>
                                                    <td>
                                                        @if($data['category'] == 1) Low End Concrete Dwelling
                                                        @elseif($data['category'] == 2) High End Concrete Dwelling
                                                        @elseif($data['category'] == 3) Low End Commercial Offices
                                                        @elseif($data['category'] == 4) High End Commercial Offices
                                                        @else Ware House
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>TOTAL GROSS FLOOR AREA (GFA):SQ/SF</b></td>
                                                    <td>{{number_format($data['cost_gross'])}}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>COST / SF:</b></td>
                                                    <td>${{number_format($data['cost_sf'],2)}}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>COST / M2:</b></td>
                                                    <td>${{number_format($data['cost_m2'],2)}}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>NO. OF UNITS:</b></td>
                                                    <td>{{$data['num_unit']}}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>NO. OF STORIES:</b></td>
                                                    <td>{{$data['num_story']}}</td>
                                                </tr>
                                                <tr>
                                                    <td> <b>Substructure Existing Conditions:</b></td>
                                                    <td>{{number_format($data['rock_percent'],2)}}%</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Total Project Cost:</b></td>
                                                    <td>${{number_format($data['project_cost'],2)}}</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td width="50%">
                                            <img src="{{$data['image_src']}}" alt="Building Image" style="width:100%">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>                             
                        </div>                                                          
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <b>Conceptual Notes:</b>
                        </div>
                        <div class="col-md-12">
                            {{$data['conceptual_note']}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <b>Basis of Estimate:</b>
                        </div>
                        <div class="col-md-12">
                            {{$data['estimate_note']}}
                        </div>
                    </div>
                    <br/>
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <h4>Building Elemental List</h4>
                        </div>                       
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="13%">ELEMENT CODE</th>
                                        <th width="18%">ELEMENT DESCRIPTION</th>
                                        <th width="13%">COST / M2 GFA</th>
                                        <th width="10%">UNIT / M2</th>
                                        <th width="13%">COST/SF GFA</th>
                                        <th width="10%">UNIT/SF</th>
                                        <th width="13%">ELEMENT COST</th>
                                        <th width="10%">FACTOR %</th>
                                    </tr>
                                </thead>
                                <tbody>                                
                                    @foreach($data['elements'] as $element)
                                    <tr>
                                        <td>{{$element->element_code}}</td>
                                        <td>{{$element->description}}</td>
                                        <td>${{number_format($element->cost_m2,2)}}</td>
                                        <td>{{$element['unit_m2']}}</td>
                                        <td>${{number_format($element->cost_sf,2)}}</td>
                                        <td>{{$element->unit_sf}}</td>
                                        <td>${{number_format($element->element_cost,2)}}</td>
                                        <td>{{$element->factor_type}}</td>
                                    </tr>
                                    @endforeach                                
                                    <tr>
                                        <td colspan="6"><b>Total:</b></td>
                                        <td>${{number_format($data['total'],2)}}</td>
                                        <td>{{$data['total_factor']}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table>
                                <tbody>
                                    <tr>
                                        <td width="85%"><b>MAIN CONTRACTORS PRELIMINARIES:</b></td>
                                        <td width="5%">{{$data['per_main_preliminary']}}%</td>
                                        <td width="10%">${{number_format($data['main_preliminary'],2)}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>MAIN CONTRACTOR'S OVERHEADS & PROFIT:</b></td>
                                        <td>{{$data['per_main_profit']}}%</td>
                                        <td>${{number_format($data['main_profit'],2)}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>TOTAL CONSTRUCTION COST - Contract Sum ( Excluding Contengencies and Contractor's Design Fees):</b></td>                                        
                                        <td>${{number_format($data['contract_sum'],2)}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>PROJECT / DESIGN TEAM FEES:</b></td>
                                        <td>{{$data['per_team_fee']}}%</td>
                                        <td>${{number_format($data['team_fee'],2)}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>CONTENGENCIES (Client's Risk):</b></td>
                                        <td>{{$data['per_client_risk']}}%</td>
                                        <td>${{number_format($data['client_risk'],2)}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>TOTAL PROJECT COST:</b></td>
                                        <td>${{number_format($data['project_cost'],2)}}</td>                                        
                                    </tr>                                  
                                </tbody>
                            </table>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-md-12">
                            <b>Inclusions & Exclusions:</b>
                        </div>      
                        <div class="col-md-12">
                            {{$data['exculstion_note']}}
                        </div>                                                                           
                    </div>
                    <br/>
                    <br/>
                    <div class="row">
                        <div class="col-md-12">
                            <table>
                                <tbody>
                                    <tr>                                        
                                        <td width="50%"><b>User Signature:</b></td>
                                        <td width="50%"></td>                                                          
                                    </tr>
                                </tbody>
                            </table>                                                    
                        </div>                                                                                                    
                    </div>
                    <!-- <div class="row">
                        <div class="col-md-12">
                            <table>
                                <tbody>
                                    <tr>
                                        <td width="70%">         
                                        <p style="color:white">Global Provisional Services LLCGlobal Provisional Services LLC</b></p>               
                                        </td>                                                                                                           
                                        <td width="30%">
                                            <p><b>Global Provisional Services LLC</b></p>
                                            <p><b>4350 SW 112th Terrace Miramar FL</b></p>
                                            <p><b>T: (954) 866- 2500</b></p>
                                            <p><b>E:info@globalpreservicesllc.com</b></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>                                                    
                        </div>                                                                                                    
                    </div> -->
                </div>
            </div>  
        </div>
    </body>
</html>