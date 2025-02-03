<style>
#print_project_design {
    display: inline-block;
    position: relative;
}

#print_project_design img {
    display: block;
    max-width: none;
    /* Disable width restrictions */
    height: auto;
    /* Maintain aspect ratio */
}

.pull-right {
    float: right;
}

.pull-left {
    float: left;
}

.loader {
    /* Loader Div Class */
    position: absolute;
    top: 0px;
    right: 0px;
    width: 100%;
    height: 100%;
    background-color: #eceaea;
    /* background-image: url('http://localhost:8000/images/glowing-ring.gif'); */
    background-image: url('/images/glowing-ring.gif');
    background-size: 50px;
    background-repeat: no-repeat;
    background-position: center;
    z-index: 10000000;
    opacity: 0.4;
    filter: alpha(opacity=40);
}

.icon_src {
    background-image: url('/images/icon.png');
    width: 20px;
    height: 20px;
    cursor: pointer;
}

.btn-open-modal {
    margin-bottom: 0.5em;
}
</style>
<template>
    <div>
        <vue-progress-bar></vue-progress-bar>
        <div class="card text-white" style="background-color:rgba(24,104,172,1)">
            <div class="card-body">
                <div class="form">
                    <div class="row">
                        <div class="loader" v-if="loading"></div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <strong>Project Title:</strong>
                                        <input type="text" class="form-control" v-model="project_title">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <strong>Estimate Type:</strong>
                                                <select class="form-control" @change="getResults" id="category"
                                                    v-model="category">
                                                    <option value=""></option>
                                                    <option v-for="temp in estimate" :key="temp.id" :value="temp.id">
                                                        {{ temp.menu_name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <strong>Country:</strong>
                                                <select class="form-control" v-model="country" id="country"
                                                    @change="getResults(($event))">
                                                    <option value=""></option>
                                                    <option v-for="con in countrys" :key="con.id" :value="con.id">
                                                        {{ con.country_name }}</option>
                                                </select>
                                                <!--<input type="text" class="form-control" v-model="country"> -->
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <strong>BUILDING FOOTPRINT SQ/FT-QUANTITY:</strong>
                                        <input type="text" class="form-control" v-model="quantity_sq_ft">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <strong>NO. OF UNITS:</strong>
                                        <input type="text" class="form-control" v-model="num_unit">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <strong>NO. OF STORIES:</strong>
                                        <input type="text" class="form-control" v-model="num_story">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <strong>TOTAL CONSTRUCTION COST:</strong>
                                        <span class="form-control">{{currency + '$' + contract_sum_collect  }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <strong>COST / SF:</strong>
                                        <span class="form-control">{{currency + '$' + e_cost_sf_collect }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <strong>COST / M2:</strong>
                                        <span class="form-control">{{currency + '$' + e_cost_m2_collect  }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <strong>TOTAL PROJECT COST:</strong>
                                        <span class="form-control">{{ currency + '$' + project_cost_collect }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <strong>COST / SF:</strong>
                                        <span class="form-control">{{currency + '$' + cost_sf_collect }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <strong>COST / M2:</strong>
                                        <span class="form-control">{{currency + '$' + cost_m2_collect }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <strong>Project Discription:</strong>
                                        <textarea class="form-control" rows="11" v-model="description"
                                            id="description"></textarea>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">

                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <strong>TOTAL GROSS FLOOR AREA (GFA):SQ/SF</strong>
                                                <span class="form-control">{{ cost_gross }}</span>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <strong>SITE SOIL CONDITIONS:</strong>
                                                <select class="form-control" v-model="soil_conditions"
                                                    @change="getResults(($event))">
                                                    <option value="1">Ordinary Soil</option>
                                                    <option value="2">Sandy Soil</option>
                                                    <option value="3">Loam Soil</option>
                                                    <option value="4">Soft Clay Soil</option>
                                                    <option value="5">Stiff Clay Soil</option>
                                                    <option value="6">Hard Soil</option>
                                                    <option value="7">Soft Soil</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <strong>PERCENTAGE ROCK IN SUBSTRUCTURE(%):</strong>
                                        <input type="number" min="0" max="100" class="form-control"
                                            v-model="rock_percent">
                                    </div>

                                    <div class="form-group">
                                        <strong>UNIT COST:</strong>
                                        <span class="form-control">{{ currency + '$' + t_unit_cost_collect }}</span>
                                    </div>
                                    <div class="form-group">
                                        <strong>TOTAL UNIT COST:</strong>
                                        <span class="form-control">{{ currency + '$' + total_cost_collect  }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <span @click="showModal('Image')" class="btn btn-success form-control"
                                        style="height: 55px; font-size: 14px;">DESIGN CONCEPT IMAGE ( Upload Drawing
                                        Plan Image )</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12" id="project_design">
                                    <img :src="image_src" alt="Estimate Type Image" style="width:100%"></img>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Design Program Notes:</strong>
                                        <textarea class="form-control" rows="10" v-model="conceptual_note"
                                            id="conceptual_note"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <span @click="getResults" class="btn btn-success">ADD UNIT#</span>
                        <span @click="getEstimateResults" class="btn btn-success">RUN</span>
                        <span class="btn btn-success" @click="clearForm">Clear / Reset Form</span>
                        <!-- <span class="btn btn-success" @click="printPDF">Print / Preview</span> -->
                        <span class="btn btn-success" data-toggle="modal" data-target="#modal-fullscreen-xl"
                            @click="printForm">Print / Preview</span>
                        <span class="btn btn-success" @click="showSaveModal">Save Estimate</span>

                        <div class="modal modal-fullscreen-xl printme" id="modal-fullscreen-xl" tabindex="-1"
                            role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body " id="print-this">
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">
                                                <strong style="color:000000;">
                                                    PROJECT TITLE
                                                </strong>
                                            </label>
                                            <div class="col-sm-10">
                                                <input style="border:1px solid #ccc" v-model="project_title_sum"
                                                    type="text" class="form-control-plaintext" id="project_title_sum">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">
                                                <strong style="color:000000;">
                                                    ESTIMATE TYPE
                                                </strong>
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" style="border:1px solid #ccc"
                                                    v-model="estimate_type_sum" class="form-control-plaintext"
                                                    id="estimate_type_sum">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">
                                                <strong style="color:000000;">
                                                    PROJECT LOCATION
                                                </strong>
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" style="border:1px solid #ccc"
                                                    v-model="project_location" class="form-control-plaintext"
                                                    id="project_location">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-6 col-form-label">
                                                <h2><strong style="color:000000;">
                                                        Key Point Indicator (KPI)
                                                    </strong></h2>
                                            </label>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">
                                                <strong style="color:000000;">
                                                    Total Gross Floor Area (GFA):SQ/SF
                                                </strong>
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" style="border:1px solid #ccc" v-model="cost_gross"
                                                    class="form-control-plaintext" id="cost_gross">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">
                                                <strong style="color:000000;">
                                                    Cost / SF
                                                </strong>
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" style="border:1px solid #ccc" v-model="e_cost_sf_sum"
                                                    class="form-control-plaintext" id="e_cost_sf_sum">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">
                                                <strong style="color:000000;">
                                                    Cost / M2
                                                </strong>
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" style="border:1px solid #ccc" v-model="e_cost_m2_sum"
                                                    class="form-control-plaintext" id="e_cost_m2_sum">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">
                                                <strong style="color:000000;">
                                                    No Of Units
                                                </strong>
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" style="border:1px solid #ccc" v-model="num_unit"
                                                    class="form-control-plaintext" id="num_unit">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">
                                                <strong style="color:000000;">
                                                    No Of Stories
                                                </strong>
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" style="border:1px solid #ccc" v-model="num_story"
                                                    class="form-control-plaintext" id="num_story">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">
                                                <strong style="color:000000;">
                                                    Substructure Existing Condition
                                                </strong>
                                            </label>
                                            <div class="col-sm-10" style="display:flex;">
                                                <input type="text" style="border:1px solid #ccc; width:50px;"
                                                    v-model="rock_percent" class="form-control-plaintext"
                                                    id="rock_percent">
                                                <label for="staticEmail" class=" col-form-label">
                                                    <strong style="color:000000;">
                                                        &nbsp;% Rock Excavation
                                                    </strong>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">
                                                <strong style="color:000000;">
                                                    Total Project Cost
                                                </strong>
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" style="border:1px solid #ccc"
                                                    v-model="project_cost_sum" class="form-control-plaintext"
                                                    id="project_cost_sum">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">
                                                <strong style="color:000000;">
                                                    Project Discription
                                                </strong>
                                            </label>
                                            <div class="col-sm-10">
                                                <textarea type="text" style="border:1px solid #ccc"
                                                    v-model="description" class="form-control-plaintext"
                                                    id="description"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">
                                                <strong style="color:000000;">
                                                    Conceptual Notes
                                                </strong>
                                            </label>
                                            <div class="col-sm-10">
                                                <textarea type="text" style="border:1px solid #ccc"
                                                    v-model="conceptual_note" class="form-control-plaintext"
                                                    id="conceptual_note"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">
                                                <strong style="color:000000;">
                                                    Basis Of Estimate
                                                </strong>
                                            </label>
                                            <div class="col-sm-10">
                                                <textarea type="text" style="border:1px solid #ccc"
                                                    v-model="estimate_note" class="form-control-plaintext"
                                                    id="estimate_note"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">
                                                <strong style="color:000000;">
                                                    Inclustions & Exclustions Notes
                                                </strong>
                                            </label>
                                            <div class="col-sm-10">
                                                <textarea type="text" style="border:1px solid #ccc"
                                                    v-model="exculstion_note" class="form-control-plaintext"
                                                    id="exculstion_note"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">
                                                <strong style="color:000000;">
                                                    Image
                                                </strong>
                                            </label>
                                            <div class="col-sm-10">
                                                <div id="print_project_design">
                                                </div>
                                                <!-- <img :src="image_src" alt="Estimate Type Image"
                                                    style="width:400px !important"></img> -->
                                            </div>
                                        </div>
                                        <table class="table table-striped table-bordered" id="print_1"
                                            style="background: aliceblue;" v-columns-resizable>
                                            <thead>
                                                <tr>
                                                    <th width="10%">ELEMENT CODE</th>
                                                    <th width="30%">ELEMENT DESCRIPTION</th>
                                                    <th width="10%">COST / M2 GFA</th>
                                                    <th width="8%">UNIT / M2</th>
                                                    <th width="10%">COST/SF GFA</th>
                                                    <th width="8%">UNIT/SF</th>
                                                    <th width="13%">ELEMENT COST</th>
                                                    <th width="10%">FACTOR %</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="element in elements" :key="element.id">
                                                    <td>{{ element.element_code }}</td>
                                                    <td>{{ element.description }}</td>
                                                    <td>{{ currency + '$'+ Intl.NumberFormat('en-us', {minimumFractionDigits:2, maximumFractionDigits:2, maximumSignificantDigits:3,}).format(element.cost_m2) }}</td>
                                                    <td>{{ element.unit_m2 }}</td>
                                                    <td>{{ currency + '$'+ Intl.NumberFormat('en-us', {minimumFractionDigits:2, maximumFractionDigits:2, maximumSignificantDigits:3,}).format(element.cost_sf) }}</td>
                                                    <td>{{ element.unit_sf }}</td>
                                                    <td>{{ currency + '$'+ Intl.NumberFormat('en-us', {minimumFractionDigits:2, maximumFractionDigits:2, maximumSignificantDigits:3,}).format(element.element_cost) }}</td>
                                                    <td>{{  element.factor_type }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"><b>Total:</b></td>
                                                    <td>{{ currency + '$' + Intl.NumberFormat('en-us', {minimumFractionDigits:2, maximumFractionDigits:2, maximumSignificantDigits:3,}).format(total)  }}</td>
                                                    <td>{{ parseFloat(total_factor).toFixed(2) }} %</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-striped">
                                            <tr>
                                                <td Width="77%"><strong style="color:black">MAIN CONTRACTOR’S
                                                        PRELIMINARIES (General Requirements)</strong></td>
                                                <td width="13%" align="right"><strong style="color:black">{{
                                                    per_main_preliminary }} %</strong></td>
                                                <td width="10%" align="right"><strong style="color:black">{{
                                                    main_preliminary_collect_fmt }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td width="77%"><strong style="color:black">MAIN CONTRACTOR'S OVERHEADS
                                                        & PROFIT</strong></td>
                                                <td width="13%" align="right"><strong style="color:black">{{
                                                    per_main_profit }} %</strong></td>
                                                <td width="10%" align="right"><strong style="color:black">{{
                                                    main_profit_collect_fmt }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td width="77%"><strong style="color:black">TOTAL CONSTRUCTION COST -
                                                        Contract Sum ( Excluding Contengencies and Contractor's Design
                                                        Fees)</strong></td>
                                                <td width="13%" align="right"></td>
                                                <td width="10%" align="right"><strong style="color:black">{{
                                                    contract_sum_collect_fmt }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td width="77%"><strong style="color:black">PROJECT / DESIGN TEAM
                                                        FEES</strong></td>
                                                <td width="13%" align="right"><strong style="color:black">{{
                                                    per_team_fee }} %</strong></td>
                                                <td width="10%" align="right"><strong style="color:black">{{
                                                    team_fee_collect_fmt }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td width="77%"><strong style="color:black">OTHER DEVELOPMENT
                                                        COST</strong></td>
                                                <td width="13%" align="right"><strong style="color:black">{{
                                                    per_dev_cost }} %</strong></td>
                                                <td width="10%" align="right"><strong style="color:black">{{
                                                    dev_cost_collect_fmt }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td width="77%"><strong style="color:black">CONTENGENCIES (Client's
                                                        Risk)</strong></td>
                                                <td width="13%" align="right"><strong style="color:black">{{
                                                    per_client_risk }} %</strong></td>
                                                <td width="10%" align="right"><strong style="color:black">{{
                                                    client_risk_collect_fmt }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td width="77%"><strong style="color:black">TOTAL PROJECT COST</strong>
                                                </td>
                                                <td width="13%" align="right"></td>
                                                <td width="10%" align="right"><strong style="color:black">
                                                    {{ currency + '$' + Intl.NumberFormat('en-us', {minimumFractionDigits:2, maximumFractionDigits:2, maximumSignificantDigits:3}).format(project_cost) }}</strong></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                            @click="printCloseFirst()">Close</button>
                                        <button type="button" class="btn btn-primary" @click="print()">Print</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <p>
                            NOTE: ADD YOUR BUILDING SQUARE FOOTAGE; PERCENTAGE ROCK (ROCK SHALL MEAN ANY MEDUIM TO HARD
                            EARTH EXCAVATION) IN SUBSTRUCTURE EXCAVATION; PRESS RUN AND / OR PRINT TO OBTAIN YOUR
                            CONSTRUCTION COST
                        </p>
                        <p>
                            ADD: PERCENTAGE FOR PRELIMINARIES; OVERHEADS &PROFIT; DESIGN FEES; OTHER COST AND
                            CONTINGENIES, THEN CALCULATE TO OBTAIN PROJECT COST
                        </p>
                        <p><strong>Building Element Cost</strong></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" style="background: aliceblue;">
                                <thead>
                                    <tr>
                                        <th width="8%">ELEMENT CODE</th>
                                        <th width="28%">ELEMENT DESCRIPTION</th>
                                        <th width="8%">COST / M2 GFA</th>
                                        <th width="8%">UNIT / M2</th>
                                        <th width="8%">COST/SF GFA</th>
                                        <th width="8%">UNIT/SF</th>
                                        <th width="11%">ELEMENT COST</th>
                                        <th width="9%">FACTOR %</th>
                                        <th width="12%">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="row_position detail-form-list">
                                    <tr v-for="(element, i) in elements" :key="i" :id="i + '-row'"
                                        :data="element.element_code" :data-index="i">
                                        <td><span :id="'element_code_label' + i">{{ element.element_code }}</span>
                                            <input class="form-control" type="text" :id="'element_code_' + i"
                                                :value="element.element_code" style="display: none" />
                                        </td>
                                        <td><span :id="'element_description_label' + i">{{ element.description }}</span>
                                            <input class="form-control" type="text"
                                                :id="'element_description_code_' + i" :value="element.description"
                                                style="display: none" />
                                        </td>
                                        <td>
                                            {{ currency + '$' + Intl.NumberFormat('en-us', {minimumFractionDigits:2, maximumFractionDigits:2, maximumSignificantDigits:3,}).format(element.cost_m2)}}
                                        </td>
                                        <td>{{ element.unit_m2 }}</td>
                                        <td>{{ currency + '$' + Intl.NumberFormat('en-us', {minimumFractionDigits:2, maximumFractionDigits:2, maximumSignificantDigits:3,}).format(element.cost_sf) }}</td>
                                        <td>{{ element.unit_sf }}</td>
                                        <td>{{ currency + '$' + Intl.NumberFormat('en-us', {minimumFractionDigits:2, maximumFractionDigits:2, maximumSignificantDigits:3,}).format(element.element_cost) }}</td>
                                        <td>{{ element.factor_type }}</td>
                                        <td>
                                            <div class="btn-group-list">
                                                <span class="btn btn-success" :id="'edit-btn-' + i"
                                                    @click="edit(i)">Edit</span>
                                                <span class="btn btn-success" :id="'delete-btn-' + i"
                                                    @click="deleteFromSum(i)">Remove</span>
                                                <span class="btn btn-success" :id="'up-btn-' + i"
                                                    @click="up(element.element_code, i)">Up</span>
                                                <span class="btn btn-success" :id="'down-btn-' + i"
                                                    @click="down(element.element_code, i)">Down</span>
                                                <span class="btn btn-success" :id="'done-btn-' + i"
                                                    @click="doneUpdate(i)" style="display: none">Done</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6"><b>Total:</b></td>
                                        <td>{{ currency + '$' + Intl.NumberFormat('en-us', {minimumFractionDigits:2, maximumFractionDigits:2, maximumSignificantDigits:3,}).format(total) }}</td>
                                        <td>{{ parseFloat(total_factor).toFixed(2) }} %</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <table class="table table-bordered text-white">
                            <tbody>
                                <tr>
                                    <td width="70%">
                                        <strong>MAIN CONTRACTOR’S PRELIMINARIES (General Requirements)</strong>
                                    </td>
                                    <td width="10%">
                                        <input type="number" class="form-control" v-model="per_main_preliminary"
                                            @change="clearSummary">
                                    </td>
                                    <td width="5%"><strong>%</strong></td>
                                    <td width="15%">
                                        <input type="text" class="form-control" v-model="main_preliminary_collect_fmt"
                                            v-on:keyup="preliminaryKeyUp" v-on:mouseleave="permainpreliminary">
                                        <!-- <span class="form-control">{{main_preliminary|currency}}</span>  -->
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>MAIN CONTRACTOR'S OVERHEADS & PROFIT</strong>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" v-model="per_main_profit"
                                            @change="clearSummary">
                                    </td>
                                    <td><strong>%</strong></td>
                                    <td>
                                        <input type="text" class="form-control" v-model="main_profit_collect_fmt"
                                            v-on:keyup="mainProfitKeyUp" v-on:mouseleave="mainProfit">
                                        <!-- <span class="form-control">{{main_profit|currency}}</span> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <strong>TOTAL CONSTRUCTION COST - Contract Sum ( Excluding Contengencies and
                                            Contractor's Design Fees)</strong>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" v-model="contract_sum_collect_fmt"
                                            v-on:keyup="contractSumKeyUp" v-on:mouseleave="contractsum">
                                        <!-- <span class="form-control">{{contract_sum|currency}}</span> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>PROJECT / DESIGN TEAM FEES</strong>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" v-model="per_team_fee"
                                            @change="clearSummary">
                                    </td>
                                    <td><strong>%</strong></td>
                                    <td>
                                        <input type="text" class="form-control" v-model="team_fee_collect_fmt"
                                            v-on:keyup="teamFeeKeyUp" v-on:mouseleave="teamFee">
                                        <!-- <span class="form-control">{{team_fee|currency}}</span> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>OTHER DEVELOPMENT COST</strong>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" v-model="per_dev_cost"
                                            @change="clearSummary">
                                    </td>
                                    <td><strong>%</strong></td>
                                    <td>
                                        <input type="text" class="form-control" v-model="dev_cost_collect_fmt"
                                            v-on:keyup="devCostKeyUp" v-on:mouseleave="devCost">
                                        <!-- <span class="form-control">{{dev_cost|currency}}</span> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>CONTENGENCIES (Client's Risk)</strong>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" v-model="per_client_risk"
                                            @change="clearSummary">
                                    </td>
                                    <td><strong>%</strong></td>
                                    <td>
                                        <input type="text" class="form-control" v-model="client_risk_collect_fmt"
                                            v-on:keyup="clientRiskKeyUp" v-on:mouseleave="clientRisk">
                                        <!-- <span class="form-control">{{client_risk|currency}}</span>  -->
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <strong>TOTAL PROJECT COST</strong>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" v-model="project_cost_collect_fmt"
                                            v-on:mouseleave="projectCost">
                                        <!-- <span class="form-control">{{project_cost|currency}}</span>  -->
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <span @click="calculate" class="btn btn-success">CALCULATE</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>Basis of Estimate Notes:</strong>
                            <textarea class="form-control" rows="10" v-model="estimate_note"
                                id="estimate_note"></textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>Inclustions & Exclustions Notes:</strong>
                            <textarea class="form-control" rows="10" v-model="exculstion_note"
                                id="exculstion_note"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="image-upload-modal" height="auto" :clickToClose="false" :scrollable="true">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#28a745">
                    <h4 style="color:white;">Upload Image</h4>
                    <div class="icon_src" @click="hideModal('Image')"></div>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead class="thead-style">
                            <tr>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td width="10%"><b>File:</b></td>
                                <td width="90%">
                                    <input type="file" ref="file" accept="image/*" v-on:change="handleFileUpload()">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-body">
                    <span @click="UploadImage()" class="btn btn-info pull-left">Upload</span>
                    <span @click="hideModal('Image')" class="btn btn-danger pull-right">Close</span>
                </div>
            </div>
        </modal>

        <modal name="save-form" height="auto" :clickToClose="false" :scrollable="true">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#28a745">
                    <h4 style="color:white;">Save Form</h4>
                    <div class="icon_src" @click="hideSaveModal"></div>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead class="thead-style">
                            <tr>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td width="20%"><b>Form Name:</b></td>
                                <td width="80%">
                                    <input type="text" class="form-control" v-model="form_name">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-body">
                    <span @click="saveForm" class="btn btn-info pull-left">Save</span>
                    <span @click="hideSaveModal" class="btn btn-danger pull-right">Close</span>
                </div>
            </div>
        </modal>
    </div>
</template>
<script>
import { get } from 'jquery';

$(document).ready(function () {
   //$('#country').select2();
});
var id = $('#approx_id').val();
export default {
    
    created() {
        //this.getResults();
        this.getCountrys();
        this.getEstimateType();
        if (id != 0) {
            this.formDetails();
        }
        //this.getVertexResults();
    },

    data() {
        return {
            quantity_sq_ft: 0,
            num_unit: 1,
            num_story: 1,
            project_title: '',
            project_location: '',
            category: 1,
            country: '',
            cost_sf: 0,
            cost_sf_collect: 0,
            cost_m2: 0,
            cost_m2_collect: 0,
            e_cost_sf: 0,
            e_cost_sf_collect: 0,
            e_cost_m2: 0,
            e_cost_m2_collect: 0,
            element_factor: 0,
            rock_percent: 0,
            description: '',
            t_unit_cost: 0,
            t_unit_cost_collect: 0,
            total_cost: 0,
            total_cost_collect: 0,
            conceptual_note: '',
            estimate_note: '',
            exculstion_note: '',
            elements: {},
            loading: true,
            total: 0,
            main_preliminary: 0,
            per_main_preliminary: 0,
            per_main_profit: 0,
            main_profit: 0,
            contract_sum: 0,
            contract_sum_collect: 0,
            team_fee: 0,
            per_team_fee: 0,
            dev_cost: 0,
            per_dev_cost: 0,
            client_risk: 0,
            per_client_risk: 0,
            project_cost: 0,
            //project_cost_collect: 0,
            image_src: '',
            total_factor: 0,
            cost_gross: 0,
            cost_gross_calculat: 0,
            file: '',
            currency: '',
            exchange_rate: 0,

            main_preliminary_collect: 0,
            main_preliminary_collect_fmt: "0",
            main_profit_collect: 0,
            main_profit_collect_fmt: "0",
            contract_sum_collect: 0,
            contract_sum_collect_fmt: "0",
            team_fee_collect: 0,
            team_fee_collect_fmt: "0",
            dev_cost_collect: 0,
            dev_cost_collect_fmt: "0",
            client_risk_collect: 0,
            client_risk_collect_fmt: "0",
            project_cost_collect: 0,
            project_cost_collect_fmt: "0",
            form_name: '',
            estimate: {},

            countrys: {},

            project_title_sum: '',
            estimate_type_sum: '',
            category_name: '',
            e_cost_sf_sum: '',
            e_cost_m2_sum: '',
            project_cost_sum: '',
            soil_conditions: 1,
        }
    },
    mounted() {
        console.log('Estimation Form 1 Component');
        // const vm = this;
        // $('#country').on('select2:select', function (e) {
        //     var data = e.params.data;
        //     vm.country = data.text;
        //     vm.country_id = data.id;
        //     console.log("country==>", data.text);
        //     console.log("country id==>", data.id);

        // });

    },
    methods: {
        onResize(newRect) {
            console.log("Resizing:", newRect);

        },
        onDrag(newPosition) {
            console.log("Dragging:", newPosition);
        },
        //handle file 
        handleFileUpload() {
            this.file = this.$refs.file.files[0];
        },
        UploadImage() {
            var _this = this
            _this.$Progress.start()
            let formData = new FormData()
            formData.append('file', _this.file)
            formData.append('category', _this.category)
            formData.append('type', 2)
            axios.post('/main_entry/upload-image',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then(function (response) {
                _this.$Progress.finish()
                _this.$toast.success('Successfully Uploaded')
                _this.hideModal('Image')
                _this.image_src = response.data.image_src
                console.log(_this.image_src)
            })
                .catch((error) => {
                    if (error.response.status == 422) {
                        _this.errors = error.response.data.errors;
                        _this.success = '';
                    }
                });
        },
        getVertexResults() {
            var _this = this
            _this.$Progress.start()
            _this.loading = true
            var estimate = $('#category').find(":selected").text();
            console.log("estimate type==>", estimate);
            var country = $('#country').find(":selected").text();
            //var totalsqft = _this.quantity_sq_ft * _this.num_unit;
            const approx_project_description = 'Project Description text of ' + estimate + ' with ' + _this.quantity_sq_ft + ' per BUILDING GROSS FLOOR AREA :SQ/FT -QUANTITY and ' + _this.num_unit + ' NO. OF UNITS and ' + _this.num_story + ' NO. OF STORIES and ' + _this.cost_gross + ' TOTAL GROSS FLOOR AREA:SQ/SF include'+ _this.currency + '$' + 'Currency and ' + 'exchange rate from '+ _this.currency +'$1 to' + 'USD$ '+ _this.exchange_rate +  'and ' + country + ' current location and '+ _this.project_cost_collect +' TOTAL PROJECT COST and '+ _this.total_cost_collect +' TOTAL UNIT COST and ' + _this.contract_sum_collect + 'TOTAL CONSTRUCTION COST' + 'include  narrative explaining the type of project including market catering';
            const basis_estimate_notes = 'Basis of Estimate Notes of ' + estimate + ' with ' + _this.quantity_sq_ft + ' per BUILDING GROSS FLOOR AREA (SQ/FT) -QUANTITY and ' + _this.num_unit + ' NO. OF UNITS and ' + _this.num_story + ' NO. OF STORIES' + _this.cost_gross  +' TOTAL GROSS FLOOR AREA:SQ/SF include'+ country + 'current location';
            const design_program_notes = 'Design Program Notes text of ' + estimate + ' with ' + _this.quantity_sq_ft + ' per BUILDING GROSS FLOOR AREA (SQ/FT) -QUANTITY and ' + _this.num_unit + ' NO. OF UNITS and ' + _this.num_story + ' NO. OF STORIES and ' + _this.cost_gross + ' TOTAL GROSS FLOOR AREA (GFA):SQ/SF with individual room design plan include' + country + 'current location';
            const inclustions_exclustions_notes = "Project Inclusions and Project Exclusions of " + estimate +' with ' + _this.quantity_sq_ft + ' per BUILDING GROSS FLOOR AREA (SQ/FT) -QUANTITY and ' + _this.num_unit + ' NO. OF UNITS and ' + _this.num_story + ' NO. OF STORIES' + _this.cost_gross  + ' TOTAL GROSS FLOOR AREA:SQ/SF include' + country + ' current location';
            const project_specification_images = "Project Specification Images of " + estimate + ' with ' + _this.quantity_sq_ft + ' per BUILDING GROSS FLOOR AREA (SQ/FT) -QUANTITY and ' + _this.num_unit + ' NO. OF UNITS and ' + _this.num_story + ' NO. OF STORIES and ' + _this.cost_gross + ' TOTAL GROSS FLOOR AREA:SQ/SF include';
            axios.get("/predictimages1?text=" + project_specification_images, { timeout: 20000 }).then(function (response) {
                const targetElement = document.getElementById('project_design');
                // let sibling = targetElement.previousElementSibling;
                // while (sibling) {
                //     const prevSibling = sibling.previousElementSibling; // Store previous sibling
                //     sibling.remove(); // Remove current sibling
                //     sibling = prevSibling; // Move to the previous sibling
                // }
                // targetElement.insertAdjacentHTML('beforebegin', response.data);
                targetElement.innerHTML = response.data;

                const print_project_design = document.getElementById('print_project_design');
                print_project_design.innerHTML = response.data;
                $("#print_project_design").resizable({
                    aspectRatio: true, // Maintain the aspect ratio of the image
                    handles: "all",    // Allow resizing from all sides and corners
                    resize: function (event, ui) {
                        // Dynamically adjust the image size to match the container
                        ui.element.find("img").css({
                            width: ui.size.width + "px",
                            height: ui.size.height + "px"
                        });
                    }
                });
            });
            axios.get("/predict?text=" + approx_project_description).then(function (response) {
                _this.description = response.data.candidates[0].content.parts[0].text;
                const project_discription_textarea = document.getElementById('description');
                project_discription_textarea.value = '';
                project_discription_textarea.value = response.data.candidates[0].content.parts[0].text;
            });

            axios.get("/predict?text=" + basis_estimate_notes).then(function (response) {
                _this.estimate_note = response.data.candidates[0].content.parts[0].text;
                const basis_estimate_notes_textarea = document.getElementById('estimate_note');
                basis_estimate_notes_textarea.value = '';
                basis_estimate_notes_textarea.value = response.data.candidates[0].content.parts[0].text;
            });

            axios.get("/predict?text=" + design_program_notes).then(function (response) {
                _this.conceptual_note = response.data.candidates[0].content.parts[0].text;
                const design_program_notes_textarea = document.getElementById('conceptual_note');
                design_program_notes_textarea.value = '';
                design_program_notes_textarea.value = response.data.candidates[0].content.parts[0].text;
            });

            axios.get("/predict?text=" + inclustions_exclustions_notes).then(function (response) {
                _this.exculstion_note = response.data.candidates[0].content.parts[0].text;
                const inclustions_exclustions_notes_textarea = document.getElementById('exculstion_note');
                inclustions_exclustions_notes_textarea.value = '';
                inclustions_exclustions_notes_textarea.value = response.data.candidates[0].content.parts[0].text;
            });
            _this.$Progress.finish()
            _this.loading = false
        },
        displayFiexedValue() {
            var _this = this
            _this.total = Number.parseFloat(_this.total).toFixed(2);
            _this.total_cost = Number.parseFloat(_this.total_cost).toFixed(2);
            _this.t_unit_cost = Number.parseFloat(_this.t_unit_cost).toFixed(2);
            _this.e_cost_sf = Number.parseFloat(_this.e_cost_sf).toFixed(2);
            _this.e_cost_m2 = Number.parseFloat(_this.e_cost_m2).toFixed(2);
            _this.contract_sum = Number.parseFloat(_this.contract_sum).toFixed(2);
            _this.project_cost = Number.parseFloat(_this.project_cost).toFixed(2);
            _this.cost_sf = Number.parseFloat(_this.cost_sf).toFixed(2);
            _this.cost_m2 = Number.parseFloat(_this.cost_m2).toFixed(2);
            _this.total_collect = new Intl.NumberFormat("en-US", { minimumFractionDigits:2, maximumFractionDigits: 2,  maximumSignificantDigits: 3,  }).format(_this.total);
            _this.total_cost_collect = new Intl.NumberFormat("en-US", {minimumFractionDigits:2,  maximumFractionDigits: 2,  maximumSignificantDigits: 3,  }).format(_this.total_cost);
            _this.t_unit_cost_collect = new Intl.NumberFormat("en-US", { minimumFractionDigits:2, maximumFractionDigits: 2,  maximumSignificantDigits: 3,  }).format(_this.t_unit_cost);
            _this.e_cost_sf_collect = new Intl.NumberFormat("en-US", { minimumFractionDigits:2, maximumFractionDigits: 2,  maximumSignificantDigits: 3,  }).format(_this.e_cost_sf);
            _this.e_cost_m2_collect = new Intl.NumberFormat("en-US", { minimumFractionDigits:2, maximumFractionDigits: 2,  maximumSignificantDigits: 3,  }).format(_this.e_cost_m2);
            _this.contract_sum_collect = new Intl.NumberFormat("en-US", {minimumFractionDigits:2,  maximumFractionDigits: 2,  maximumSignificantDigits: 3,  }).format(_this.contract_sum);
            _this.project_cost_collect = new Intl.NumberFormat("en-US", { minimumFractionDigits:2,  maximumFractionDigits: 2,  maximumSignificantDigits: 3,  }).format(_this.project_cost);
            _this.cost_sf_collect = new Intl.NumberFormat("en-US", { minimumFractionDigits:2, maximumFractionDigits: 2,  maximumSignificantDigits: 3,  }).format(_this.cost_sf);
            _this.cost_m2_collect = new Intl.NumberFormat("en-US", { minimumFractionDigits:2, maximumFractionDigits: 2,  maximumSignificantDigits: 3,  }).format(_this.cost_m2);

        },  
        getResults() {
            var _this = this
            _this.$Progress.start()
            _this.loading = true
            if(_this.country == ''){
                _this.country = 2;
            }
            console.log("category==>", _this.category);
            console.log("country==>", _this.country);
           
            
            axios.get('/cost-estimate/cost-form/getResults?quantity_sq_ft=' + _this.quantity_sq_ft
                + '&category=' + _this.category + '&num_unit=' + _this.num_unit + '&num_story=' + _this.num_story +
                '&rock_percent=' + _this.rock_percent + '&country=' + _this.country + '&soil_conditions=' + _this.soil_conditions)
                .then(function (response) {
                    _this.elements = response.data.data.elements
                    _this.total = response.data.data.total
                    _this.total_cost = response.data.data.total
                    _this.total_factor = response.data.data.total_factor
                    _this.t_unit_cost = response.data.data.t_unit_cost
                    _this.image_src = response.data.data.image_src
                    _this.e_cost_sf = response.data.data.e_cost_sf
                    _this.e_cost_m2 = response.data.data.e_cost_m2
                    _this.cost_gross = new Intl.NumberFormat("en-US", { maximumFractionDigits: 2,  maximumSignificantDigits: 3,  }).format(response.data.data.cost_gross);
                    _this.cost_gross_calculat = response.data.data.cost_gross
                    _this.category_name = response.data.data.category_name
                    _this.currency = response.data.data.currency
                    _this.exchange_rate = Number.parseFloat(response.data.data.exchange_rate).toFixed(2)
                    _this.$Progress.finish()
                    _this.loading = false
                    console.log("response data===>", response.data.data);
                    console.log("ex_rate===>", _this.exchange_rate);
                    _this.displayFiexedValue();
                    //_this.getVertexResults();

                });

        },
        getEstimateResults(){
            var _this = this
                       
            axios.get('/cost-estimate/cost-form/getResults?quantity_sq_ft=' + _this.quantity_sq_ft
                + '&category=' + _this.category + '&num_unit=' + _this.num_unit + '&num_story=' + _this.num_story +
                '&rock_percent=' + _this.rock_percent + '&country=' + _this.country + '&soil_conditions=' + _this.soil_conditions)
                .then(function (response) {
                    _this.elements = response.data.data.elements
                    _this.total = response.data.data.total
                    _this.total_cost = response.data.data.total
                    _this.total_factor = response.data.data.total_factor
                    _this.t_unit_cost = response.data.data.t_unit_cost
                    _this.image_src = response.data.data.image_src
                    _this.e_cost_sf = response.data.data.e_cost_sf
                    _this.e_cost_m2 = response.data.data.e_cost_m2
                    _this.cost_gross = new Intl.NumberFormat("en-US", { maximumFractionDigits: 2,  maximumSignificantDigits: 3,  }).format(response.data.data.cost_gross);
                    _this.cost_gross_calculat = response.data.data.cost_gross
                    _this.category_name = response.data.data.category_name
                    _this.currency = response.data.data.currency
                    _this.exchange_rate = Number.parseFloat(response.data.data.exchange_rate).toFixed(2)
                    _this.$Progress.finish()
                    _this.loading = false
                    console.log("response data===>", response.data.data);
                    console.log("ex_rate===>", _this.exchange_rate);
                    _this.displayFiexedValue();
                    _this.getVertexResults();

                });
        },
        getCountrys() {
            var _this = this
            _this.$Progress.start()
            _this.loading = true
            axios.get('/cost-estimate/cost-form/getCountry')
                .then(function (response) {
                    _this.countrys = response.data.data.countrys
                    _this.$Progress.finish()
                    _this.loading = false
                    $(".detail-form-list").sortable({
                        delay: 150
                    })
                });

        },
        getEstimateType() {
            var _this = this
            _this.$Progress.start()
            _this.loading = true
            axios.get('/cost-estimate/cost-form/getEstimateType')
                .then(function (response) {
                    _this.estimate = response.data.data.menus
                    _this.$Progress.finish()
                    _this.loading = false
                });
        },
        clearForm() {
            this.quantity_sq_ft = 0
            this.num_unit = 1
            this.num_story = 1
            this.project_title = ''
            this.category = 1
            this.country = ''
            this.cost_sf = 0
            this.cost_m2 = 0
            this.element_factor = 0
            this.rock_percent = 0
            this.description = ''
            this.t_unit_cost = 0
            this.total_cost = 0
            this.conceptual_note = ''
            this.estimate_note = ''
            this.exculstion_note = ''
            this.cost_gross = 0
            this.cost_gross_calculat = 0
            this.clearSummary()
            this.getResults()
        },
        clearSummary() {
            var _this = this
            _this.main_preliminary = 0
            this.main_preliminary_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.main_preliminary);
            _this.main_profit = 0
            this.main_profit_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.main_profit);
            _this.contract_sum = 0
            this.contract_sum_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.contract_sum);
            _this.team_fee = 0
            this.team_fee_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.team_fee);
            _this.dev_cost = 0
            this.dev_cost_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.dev_cost);
            _this.client_risk = 0
            this.project_cost_c = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.client_risk);
            _this.project_cost = 0
            this.project_cost_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.project_cost);
        },
        /* edit, update, remove */
        edit(index) {

            $("#edit-btn-" + index).css("display", "none");
            $("#delete-btn-" + index).css("display", "none");
            $("#up-btn-" + index).css("display", "none");
            $("#down-btn-" + index).css("display", "none");
            $("#element_code_" + index).css("display", "flex");
            $("#element_description_code_" + index).css("display", "flex");
            $("#element_code_label" + index).css("display", "none");
            $("#element_description_label" + index).css("display", "none");
            $("#done-btn-" + index).css("display", "block");
        },
        doneUpdate(index) {
            var element_code = $("#element_code_" + index).val();
            var element_description = $("#element_description_code_" + index).val();

            this.elements.forEach((value, key) => {
                if (key == index) {
                    if (element_code != "") {
                        this.elements[key]["element_code"] = element_code;
                    }
                    if (element_description != "") {
                        this.elements[key]["description"] = element_description;
                    }

                }
            });

            $("#edit-btn-" + index).css("display", "");
            $("#delete-btn-" + index).css("display", "");
            $("#up-btn-" + index).css("display", "");
            $("#down-btn-" + index).css("display", "");
            $("#element_code_" + index).css("display", "none");
            $("#element_description_code_" + index).css("display", "none");
            $("#element_code_label" + index).css("display", "");
            $("#element_description_label" + index).css("display", "");
            $("#done-btn-" + index).css("display", "none");
        },
        up(id, ind) {
            var selected = 0;
            var itemlist = $(".row_position");
            var len = $(itemlist).children().length;
            var selected = $("#" + ind + "-row").index();

            if (selected > 0) {
                jQuery(
                    $(itemlist)
                        .children()
                        .eq(selected - 1)
                ).before(jQuery($(itemlist).children().eq(selected)));
                selected = selected - 1;
            }


            // this.totalCalculation = sortableArray;
        },
        down(id, ind) {
            var selected = 0;
            var itemlist = $(".row_position");
            var len = $(itemlist).children().length;
            var selected = $("#" + ind + "-row").index();

            if (selected < len) {
                jQuery(
                    $(itemlist)
                        .children()
                        .eq(selected + 1)
                ).after(jQuery($(itemlist).children().eq(selected)));
                selected = selected + 1;
            }
        },
        deleteFromSum(index) {
            this.total = this.total - this.elements[index].element_cost;
            this.elements.splice(index, 1);
            this.elements.forEach((value, key) => {
                value.factor_type = parseFloat(value.element_cost / this.total * 100).toFixed(2) + '%';
                console.log("key, id==>", value, key);
            });

            this.total = this.elements.reduce(function (
                sum,
                current
            ) {
                return (sum += Number(parseFloat(current.element_cost).toFixed(2)));
            },
                0);
            this.total_cost = this.total;
            this.t_unit_cost = this.total_cost / this.num_unit;
            this.total_factor = this.elements.reduce(function (
                sum,
                current
            ) {
                return (sum += Number(parseFloat(current.factor_type).toFixed(2)));
            },
                0);

        },
        showModal(type) {
            this.$modal.show('image-upload-modal')
        },
        hideModal() {
            this.$modal.hide('image-upload-modal')
        },
        permainpreliminary() {
            this.main_preliminary_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2,  maximumSignificantDigits: 3,  }).format(this.main_preliminary);
        },
        contractsum() {
            this.contract_sum_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.contract_sum);
        },
        mainProfit() {
            this.main_profit_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.main_profit);
        },
        teamFee() {
            this.team_fee_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.team_fee);
        },
        devCost() {
            this.dev_cost_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.dev_cost);
        },
        clientRisk() {
            this.client_risk_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.client_risk);
        },
        projectCost() {
            this.project_cost_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.project_cost);
        },
        preliminaryKeyUp() {
            this.main_preliminary = this.main_preliminary_collect;
            this.calculateAmount();
        },
        mainProfitKeyUp() {
            this.main_profit = this.main_profit_collect;
            this.calculateAmount();
        },
        contractSumKeyUp() {
            this.contract_sum = this.contract_sum_collect;
            this.calculateAmount();
        },
        teamFeeKeyUp() {
            this.team_fee = this.team_fee_collect;
            this.calculateAmount();
        },
        devCostKeyUp() {
            this.dev_cost = this.dev_cost_collect;
            this.calculateAmount();
        },
        clientRiskKeyUp() {
            this.client_risk = this.client_risk_collect;
            this.calculateAmount();
        },
        displayCurrencyString(){
            var _this = this
           
            //_this.project_cost_collect_fmt = _this.currency + _this.project_cost_collect;
            _this.main_preliminary_collect_fmt = _this.currency + _this.main_preliminary_collect;
            _this.main_profit_collect_fmt = _this.currency + _this.main_profit_collect;
            _this.contract_sum_collect_fmt = _this.currency + _this.contract_sum_collect;
            _this.team_fee_collect_fmt = _this.currency + _this.team_fee_collect;
            _this.dev_cost_collect_fmt = _this.currency + _this.dev_cost_collect;
            _this.client_risk_collect_fmt = _this.currency + _this.client_risk_collect;
            _this.project_cost_collect_fmt = _this.currency + '$' + _this.project_cost_collect;
        },
        calculate() {
            var _this = this
            if (_this.per_main_preliminary != 0) {
                _this.main_preliminary = (_this.total * _this.per_main_preliminary) / 100
            }
            this.main_preliminary_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.main_preliminary);

            if (_this.per_main_profit != 0) {
                _this.main_profit = (_this.total * _this.per_main_profit) / 100
            }
            this.main_profit_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.main_profit);

            _this.contract_sum = parseFloat(_this.total) + parseFloat(_this.main_preliminary) + parseFloat(_this.main_profit)

            if (_this.per_team_fee != 0) {
                _this.team_fee = (_this.contract_sum) * _this.per_team_fee / 100
            }
            this.team_fee_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.team_fee);

            if (_this.per_dev_cost != 0) {
                _this.dev_cost = (_this.contract_sum) * _this.per_dev_cost / 100
            }
            this.dev_cost_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.dev_cost);

            if (_this.per_client_risk != 0) {
                _this.client_risk = (_this.contract_sum) * _this.per_client_risk / 100
            }
            this.client_risk_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.client_risk);

            _this.project_cost = parseFloat(_this.contract_sum) + parseFloat(_this.team_fee) + parseFloat(_this.dev_cost) + parseFloat(_this.client_risk)

            this.project_cost_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.project_cost);

            this.contract_sum_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.contract_sum);

            _this.cost_sf = 0;
            // if(_this.cost_gross != 0) _this.cost_sf = Math.round(_this.project_cost/_this.cost_gross,2)
            if (_this.cost_gross != 0) _this.cost_sf = _this.project_cost / _this.cost_gross_calculat
            //if(_this.cost_gross != 0) _this.cost_m2 = Math.round(_this.project_cost/_this.cost_gross,2)            
            _this.cost_m2 = _this.cost_sf * 10.7646;
            _this.displayFiexedValue();
            _this.displayCurrencyString();
            _this.getVertexResults();

        },
        calculateAmount() {
            this.contract_sum = parseFloat(parseFloat(this.total) + parseFloat(this.main_preliminary) + parseFloat(this.main_profit)).toFixed(2)
            this.contract_sum_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.contract_sum);

            this.project_cost = parseFloat(parseFloat(this.contract_sum) + parseFloat(this.team_fee) + parseFloat(this.dev_cost) + parseFloat(this.client_risk));
            this.project_cost_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.project_cost);
        },
        showSaveModal() {
            this.$modal.show('save-form');
        },
        hideSaveModal() {
            this.$modal.hide('save-form');
        },
        saveForm() {
            var _this = this;

            axios.post('/cost-estimate/cost-form/saveForm', {
                id: id,
                form_name: this.form_name,
                project_title: this.project_title,
                category: this.category,
                country: this.country,
                quantity_sq_ft: this.quantity_sq_ft,
                num_unit: this.num_unit,
                num_story: this.num_story,
                contract_sum: this.contract_sum,
                e_cost_sf: this.e_cost_sf,
                e_cost_m2: this.e_cost_m2,
                project_cost: this.project_cost,
                cost_sf: this.cost_sf,
                cost_m2: this.cost_m2,
                description: this.description,
                cost_gross: this.cost_gross,
                rock_percent: this.rock_percent,
                t_unit_cost: this.t_unit_cost,
                total_cost: this.total_cost,
                conceptual_note: this.conceptual_note,
                estimate_note: this.estimate_note,
                exculstion_note: this.exculstion_note,
                per_main_preliminary: this.per_main_preliminary,
                main_preliminary_collect: this.main_preliminary_collect,
                per_main_profit: this.per_main_profit,
                main_profit_collect: this.main_profit_collect,
                contract_sum_collect: this.contract_sum_collect,
                per_team_fee: this.per_team_fee,
                team_fee_collect: this.team_fee_collect,
                per_dev_cost: this.per_dev_cost,
                dev_cost_collect: this.dev_cost_collect,
                per_client_risk: this.per_client_risk,
                client_risk_collect: this.client_risk_collect,
                project_cost: this.project_cost
            })
                .then(function (response) {
                    _this.$toast.success('Form Save Successfully')
                    _this.hideSaveModal()
                })
                .catch((error) => {
                    if (error.response.status == 422) {
                        _this.errors = error.response.data.errors;
                        _this.success = '';
                    }
                });
        },
        formDetails() {
            this.loading = true
            var _this = this
            axios.get('/cost-estimate/cost-form/getFormDetail?id=' + id)
                .then(function (response) {
                    const formDetail = JSON.parse(response.data.data.costForms.form_details);
                    _this.form_name = response.data.data.costForms.form_name
                    _this.project_title = formDetail.project_title
                    _this.category = formDetail.category
                    _this.country = formDetail.country
                    _this.quantity_sq_ft = formDetail.quantity_sq_ft
                    _this.num_unit = formDetail.num_unit
                    _this.num_story = formDetail.num_story
                    _this.contract_sum = formDetail.contract_sum
                    _this.e_cost_sf = formDetail.e_cost_sf
                    _this.e_cost_m2 = formDetail.e_cost_m2
                    _this.project_cost = formDetail.project_cost
                    _this.cost_sf = formDetail.cost_sf
                    _this.cost_m2 = formDetail.cost_m2
                    _this.description = formDetail.description
                    _this.cost_gross = formDetail.cost_gross
                    _this.rock_percent = formDetail.rock_percent
                    _this.t_unit_cost = formDetail.t_unit_cost
                    _this.total_cost = formDetail.total_cost
                    _this.total = formDetail.total_cost
                    _this.conceptual_note = formDetail.conceptual_note
                    _this.estimate_note = formDetail.estimate_note
                    _this.exculstion_note = formDetail.exculstion_note
                    _this.per_main_preliminary = formDetail.per_main_preliminary
                    _this.main_preliminary_collect = formDetail.main_preliminary_collect
                    _this.per_main_profit = formDetail.per_main_profit
                    _this.main_profit_collect = formDetail.main_profit_collect
                    _this.contract_sum_collect = formDetail.contract_sum_collect
                    _this.per_team_fee = formDetail.per_team_fee
                    _this.team_fee_collect = formDetail.team_fee_collect
                    _this.per_dev_cost = formDetail.per_dev_cost
                    _this.dev_cost_collect = formDetail.dev_cost_collect
                    _this.per_client_risk = formDetail.per_client_risk
                    _this.client_risk_collect = formDetail.client_risk_collect
                    _this.project_cost = formDetail.project_cost
                    _this.getResults();
                    _this.calculateTwo();
                    _this.loading = false
                    $(".detail-form-list").sortable({
                        delay: 150
                    });
                });
        },
        printForm() {
            this.project_title_sum = this.project_title
            this.estimate_type_sum = this.category_name
            this.project_location = $('#country').find(":selected").text();
            this.e_cost_sf_sum = this.currency + new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.cost_sf);
            this.e_cost_m2_sum = this.currency +new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.cost_m2);
            this.project_cost_sum = this.currency + new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.project_cost);
        },
        printCloseFirst() {
            $('#print_1 thead tr th').css('font-size', '1rem')
        },
        print() {
            $('#print_1 thead tr th').css('font-size', '10px')
            $('#print_1 thead tr th').css('text-align', 'left')
            $('#print_1 thead tr th').css('padding-left', '0px !important')
            $('#print_1 tbody tr td').css('font-size', '10px')
            $('#print_1 tbody tr td').css('padding-left', '0px !important')
            $('#modal-fullscreen-xl').css('font-family', 'Tahoma')
            $('#project_title_sum').attr("value", this.project_title_sum);
            $('#estimate_type_sum').attr("value", this.estimate_type_sum);
            $('#project_location').attr("value", this.project_location);
            $('#cost_gross').attr("value", this.cost_gross);
            $('#e_cost_sf_sum').attr("value", this.e_cost_sf_sum_collect);
            $('#e_cost_m2_sum').attr("value", this.e_cost_m2_sum_collect);
            $('#num_unit').attr("value", this.num_unit);
            $('#num_story').attr("value", this.num_story);
            $('#rock_percent').attr("value", this.rock_percent);
            $('#project_cost_sum').attr("value", this.project_cost_sum_collect);
            $('#description').attr("value", this.description);
            $('#conceptual_note').attr("value", this.conceptual_note);
            $('#estimate_note').attr("value", this.estimate_note);
            $('#exculstion_note').attr("value", this.exculstion_note);
            $('title').text('APPROXIMATE COST ESTIMATION FORM');
            this.$htmlToPaper('print-this');
        },
        calculateTwo() {
            var _this = this
            if (_this.per_main_preliminary != 0) {
                _this.main_preliminary = (_this.total * _this.per_main_preliminary) / 100
            }
            this.main_preliminary_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.main_preliminary);

            if (_this.per_main_profit != 0) {
                _this.main_profit = (_this.total * _this.per_main_profit) / 100
            }
            this.main_profit_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.main_profit);

            _this.contract_sum = parseFloat(_this.total) + parseFloat(_this.main_preliminary) + parseFloat(_this.main_profit)

            if (_this.per_team_fee != 0) {
                _this.team_fee = (_this.contract_sum) * _this.per_team_fee / 100
            }
            this.team_fee_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.team_fee);

            if (_this.per_dev_cost != 0) {
                _this.dev_cost = (_this.contract_sum) * _this.per_dev_cost / 100
            }
            this.dev_cost_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.dev_cost);

            if (_this.per_client_risk != 0) {
                _this.client_risk = (_this.contract_sum) * _this.per_client_risk / 100
            }
            this.client_risk_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.client_risk);

            _this.project_cost = parseFloat(_this.contract_sum) + parseFloat(_this.team_fee) + parseFloat(_this.dev_cost) + parseFloat(_this.client_risk)

            this.project_cost_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.project_cost);

            this.contract_sum_collect = new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", minimumFractionDigits: 2, maximumFractionDigits: 2, maximumSignificantDigits: 3,}).format(this.contract_sum);

        },
        //printPDF(){
        //     var _this = this                                
        //    axios.post('/cost-estimate/cost-form/savePDF',{
        //        main_preliminary:_this.main_preliminary,
        //        main_profit:_this.main_profit,
        //        contract_sum:_this.contract_sum,
        //        team_fee:_this.team_fee,
        //        dev_cost:_this.dev_cost,
        //        client_risk:_this.client_risk,
        //        project_cost:_this.project_cost, 
        //        total_cost:_this.total_cost,
        //        per_main_preliminary:_this.per_main_preliminary,
        //        per_main_profit:_this.per_main_profit,
        //        per_team_fee:_this.per_team_fee,
        //        per_dev_cost:_this.per_dev_cost,
        //        per_client_risk:_this.per_client_risk,
        //        country:_this.country,
        //        description:_this.description,
        //        estimate_note:_this.estimate_note,
        //        conceptual_note:_this.conceptual_note,
        //        exculstion_note:_this.exculstion_note,
        //        project_title:_this.project_title, 
        //        cost_sf:_this.cost_sf,
        //        cost_m2:_this.cost_m2               
        //    })
        //    .then(function(response){
        //        window.open("/cost-estimate/cost-form/printPDF", "_blank");        
        //    })
        //    .catch((error)=> {
        //        if (error.response.status == 422){
        //            _this.errors = error.response.data.errors;
        //            _this.success = '';                    
        //        }
        //  });            
        //},
    }

}
</script>