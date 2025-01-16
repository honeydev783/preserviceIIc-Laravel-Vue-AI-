<style>

.pull-right {
  float: right;
}
.pull-left {
  float: left;
}

.btn-group-list .btn {
    width: 90px;
    margin-right: 4px;
    margin-bottom: 10px;
}
.btn-group-list {
    min-width: 210px;
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
  background-image: url("/images/glowing-ring.gif");
  background-size: 50px;
  background-repeat: no-repeat;
  background-position: center;
  z-index: 10000000;
  opacity: 0.4;
  filter: alpha(opacity=40);
}
span.select2 {
  width: 100% !important;
}

.select2-container--default .select2-results > .select2-results__options {
  max-height: 380px !important;
}
.icon_src {
  background-image: url("/images/icon.png");
  width: 20px;
  height: 20px;
  cursor: pointer;
}
@media (max-width: 575.98px) {
  .modal-fullscreen {
    padding: 0 !important;
  }
  .modal-fullscreen .modal-dialog {
    width: 100%;
    max-width: none;
    height: 100%;
    margin: 0;
  }
  .modal-fullscreen .modal-content {
    height: 100%;
    border: 0;
    border-radius: 0;
  }
  .modal-fullscreen .modal-body {
    overflow-y: auto;
  }
  .btn.btn-activity-component {
    cursor: none !important;
  }
}
@media (max-width: 767.98px) {
  .modal-fullscreen-sm {
    padding: 0 !important;
  }
  .modal-fullscreen-sm .modal-dialog {
    width: 100%;
    max-width: none;
    height: 100%;
    margin: 0;
  }
  .modal-fullscreen-sm .modal-content {
    height: 100%;
    border: 0;
    border-radius: 0;
  }
  .modal-fullscreen-sm .modal-body {
    overflow-y: auto;
  }
}
@media (max-width: 991.98px) {
  .modal-fullscreen-md {
    padding: 0 !important;
  }
  .modal-fullscreen-md .modal-dialog {
    width: 100%;
    max-width: none;
    height: 100%;
    margin: 0;
  }
  .modal-fullscreen-md .modal-content {
    height: 100%;
    border: 0;
    border-radius: 0;
  }
  .modal-fullscreen-md .modal-body {
    overflow-y: auto;
  }
}
@media (max-width: 1199.98px) {
  .modal-fullscreen-lg {
    padding: 0 !important;
  }
  .modal-fullscreen-lg .modal-dialog {
    width: 100%;
    max-width: none;
    height: 100%;
    margin: 0;
  }
  .modal-fullscreen-lg .modal-content {
    height: 100%;
    border: 0;
    border-radius: 0;
  }
  .modal-fullscreen-lg .modal-body {
    overflow-y: auto;
  }
}

@media (max-width: 1990px) {
  .jac{
    padding-top:20px;
  }
}
.modal-fullscreen-xl {
  padding: 0 !important;
}
.modal-fullscreen-xl .modal-dialog {
  width: 100%;
  max-width: none;
  height: 100%;
  margin: 0;
}
.modal-fullscreen-xl .modal-content {
  height: 100%;
  border: 0;
  border-radius: 0;
}
.modal-fullscreen-xl .modal-body {
  overflow-y: auto;
}

.btn-open-modal {
  margin-bottom: 0.5em;
}
.col-form-label {
  color: #000;
  font-weight: 700;
  font-size: 18x;
}
.form-control-plaintext {
  padding-left: 10px;
}
.show-currency {
  border: none;
}
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
/* input[type="number"] {
  -moz-appearance: textfield;
} */
.dollar {
  /* display:inline-block; */
  position: relative;
}
.dollar input {
  padding-left: 15px;
}
.dollar:before {
  position: absolute;
  content: "$";
  left: 6px;
  top: 6px;
  color: #5d6369;
}
</style>
<template>
  <div>
    <vue-progress-bar></vue-progress-bar>
    <div
      class="card text-white detail-form"
      style="background-color: rgba(24, 104, 172, 1)"
    >
      <div class="card-body">
        <div class="form">
          <div class="row">
            <div class="loader" v-if="loading"></div>
            <div class="col-md-8">
              <div class="row">
                <div class="col-xs-7 col-sm-7 col-md-7">
                  <div class="form-group">
                    <strong>Project Title:</strong>
                    <input
                      type="text"
                      class="form-control"
                      v-model="project_title"
                    />
                  </div>
                </div>
                <div class="col-xs-5 col-sm-5 col-md-5">
                  <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <strong>Estimate Type:</strong>
                        <select class="form-control" v-model="estimate_type">
                          <option value=""></option>
                          <option value="Building">Building</option>
                          <option value="Infrastructure">Infrastructure</option>
                          <option value="Sewage">Sewage</option>
                          <option value="Water Supply">Water Supply</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <strong>Country:</strong>
                        <select
                          class="form-control"
                          v-model="country"
                          @change="getComponents($event)"
                          id="country_id"
                        >
                          <option value=""></option>
                          <option
                            v-for="con in countrys"
                            :key="con.id"
                            :value="con.id"
                          >
                            {{ con.country_name }}
                          </option>
                        </select>
                        <!-- <input type="text" class="form-control" v-model="location"> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-7 col-sm-7 col-md-7">
                  <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <strong>ACTIVITY CODE:</strong>
                        <input
                          type="text"
                          v-model="activity_code"
                          class="form-control"
                        />
                      </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <strong>ACTIVITY CATEGORY:</strong>
                        <select
                          class="form-control"
                          v-model="category"
                          @change="getResults($event)"
                        >
                          <option value="">
                            [Select To View Relative Job Activity Listing:]
                          </option>
                          <option
                            v-for="temp in descriptions"
                            :key="temp.id"
                            :value="temp.id"
                          >
                            {{ temp.title }}
                          </option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <strong>IMPERIAL RATE:</strong>
                      <div class="form-group">
                        <!-- <vue-numeric class="form-control show-currency" currency="$" disabled={disabled} separator=","  :value="imperial_rate"></vue-numeric> -->
                        <input
                          type="text"
                          v-model="imperial_rate"
                          class="form-control"
                        />
                      </div>
                      <div class="form-group">
                        <strong>UNIT:</strong>
                        <input
                          class="form-control"
                          type="text"
                          v-model="imperial_unit"
                        />
                      </div>
                    </div>
                    <!-- <div class="col-xs-3 col-sm-3 col-md-3">
                        <div class="form-group">
                            <strong>UNIT:</strong>
                            <input class="form-control" type="text" v-model="imperial_unit">
                        </div>
                    </div>  -->
                    <div class="col-xs-6 col-sm-6 col-md-6">
                      <strong>METRIC RATE:</strong>
                      <div class="form-group">
                        <!-- <vue-numeric class="form-control show-currency" currency="$" disabled={disabled} separator=","  :value="metric_rate"></vue-numeric> -->

                        <input
                          type="text"
                          v-model="metric_rate"
                          class="form-control"
                        />
                      </div>
                      <div class="form-group">
                        <strong>UNIT:</strong>
                        <input
                          type="text"
                          v-model="metric_unit"
                          class="form-control"
                        />
                      </div>
                    </div>
                    <!-- <div class="col-xs-3 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <strong>UNIT:</strong>
                                        <input type="text" v-model="metric_unit" class="form-control">         
                                    </div>                              
                                </div>     -->
                  </div>
                </div>
                <div class="col-xs-5 col-sm-5 col-md-5">
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                        <strong>JOB ACTIVITY:</strong>
                        <!-- <select class="form-control" v-model="activity_description" @change="getComponents">  -->
                        <select
                          class="form-control"
                          id="select2"
                          v-model="activity_description"
                        >
                          <option value="" selected>
                            [Select To View Relative Job Activity Listing:]
                          </option>
                          <option
                            v-for="active in actives"
                            :key="active.id"
                            :value="active.id"
                          >
                            {{ active.description }}
                          </option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                        <strong style="width: 100%; float: left"
                          >JOB ACTIVITY QUANTITY - IMPERIAL</strong
                        >
                        <input
                          style="float: left; width: 25%"
                          type="number"
                          v-model="quantity"
                          class="form-control"
                          value="1"
                        />
                        <input
                          style="float: left; width: 15%"
                          type="text"
                          v-model="imperial_unit"
                          class="form-control"
                        />
                        <div style="float: left; width: 60%">
                          <span
                            style="float: left;width: 40%;margin-left: 5px;padding: 0.375rem 0.3rem !important"
                            class="btn btn-success"
                            @click="checkDetails"
                            >Add Quantity</span
                          >
                          <span
                            style="float: left;width: 50%;margin-left: 5px;padding: 0.375rem 0.5rem !important;"
                            class="btn btn-success"
                            @click="loadComponent"
                            >Load Job Activity</span
                          >
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="row">                        
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <br>
                                    <span class="btn btn-success" @click="checkDetails">Add Quantity</span>
                                    <span class="btn btn-success"   @click="loadComponent">Load Job Activity</span>
                                </div>      
                            </div> -->
                </div>
              </div>

              <div class="row">
                <div class="col-xs-7 col-sm-7 col-md-7">
                  <div class="form-group">
                    <strong>Project Discription:</strong>
                    <textarea id="project_discription"
                      class="form-control"
                      rows="11"
                      v-model="project_description"
                    ></textarea>
                  </div>
                </div>
                <div class="col-xs-5 col-sm-5 col-md-5">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <strong>LABOUR COST:</strong>
                        <!-- <span class="form-control"></span>  -->
                        <!-- <vue-numeric currency="$" class="form-control" separator=","  v-model="labour_cost"></vue-numeric> -->
                        <input
                          type="text"
                          class="form-control"
                          v-model="labour_cost"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <strong>EQUIPMENT COST:</strong>
                        <!-- <span class="form-control"></span>                                        -->
                        <!-- <vue-numeric currency="$" class="form-control" separator=","  v-model="equipment_cost"></vue-numeric> -->
                        <input
                          type="text"
                          class="form-control"
                          v-model="equipment_cost"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <strong>MATERIAL COST:</strong>
                        <input
                          type="text"
                          class="form-control"
                          v-model="material_cost"
                        />
                        <!-- <vue-numeric currency="$" class="form-control" separator=","  v-model="material_cost"></vue-numeric>                                     -->
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <strong>ADDITIONAL / DISCOUNT COST (+/-):</strong>
                        <!-- <vue-numeric class="form-control"  currency="$" separator=","  v-model="additional_cost"></vue-numeric>  -->
                        <input
                          type="text"
                          class="form-control"
                          v-model="additional_cost"
                          v-on:keyup="additionalCost"
                          v-on:mouseleave="additionalLeave"
                        />
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <strong>SUB-TOTAL:</strong>
                        <!-- <vue-numeric class="form-control" currency="$" separator=","  v-model="sub_total"></vue-numeric>  -->
                        <input
                          type="text"
                          class="form-control"
                          v-model="sub_total"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-4 jac">
                      <strong>%:</strong>
                      <input
                        type="number"
                        class="form-control"
                        v-model="preliminary_percentage"
                        max="100"
                        value="0"
                        placeholder="%"
                        v-on:keyup="preliminaryCost"
                      />
                    </div>
                    <div class="col-sm-8">
                      <div class="form-group">
                        <strong>PRELIMINARIES / GENERAL REQUIREMENTS COST:</strong>

                        <input
                          type="text"
                          class="form-control"
                          v-model="preliminary_cost"
                          v-on:keyup="preliminaryCostAmount"
                          v-on:mouseleave="preliminaryLeave"
                        />
                        <!-- <div class="dollar">
                                              <input type="text" class="form-control" v-model="preliminary_cost" value="0"  >  
                                        </div> -->
                        <!-- <vue-numeric class="form-control" currency="$" separator=","  v-model="preliminary_cost"></vue-numeric>  -->
                        <!-- <span class="currencyinput">$
                                         <input type="number" class="form-control" v-model="preliminary_cost" min="0" max="100" value="0"  >   
                                         </span>                                    -->
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-4">
                      <strong>%:</strong>

                      <input
                        type="number"
                        class="form-control"
                        v-model="overhead_percentage"
                        min="0"
                        max="100"
                        value="0"
                        placeholder="%"
                        v-on:keyup="overheadProfit"
                      />
                    </div>
                    <div class="col-sm-8">
                      <div class="form-group">
                        <strong>OVERHEADS & PROFIT:</strong>
                        <!-- <vue-numeric class="form-control" currency="$" separator=","  v-model="overhead_cost"></vue-numeric>  -->
                        <!-- <div class="dollar"> -->
                        <input
                          type="text"
                          class="form-control"
                          v-model="overhead_cost"
                          max="100"
                          value="0"
                          placeholder="%"
                          v-on:keyup="overheadCost"
                          v-on:mouseleave="overheadLeave"
                        />
                        <!-- </div> -->
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-4">
                      <strong>%:</strong>
                      <input
                        type="text"
                        class="form-control"
                        min="0"
                        max="100"
                        v-model="consistgency_percentage"
                        v-on:keyup="consistgencyCost"
                      />
                    </div>
                    <div class="col-sm-8">
                      <div class="form-group">
                        <strong>CONTINGENCY COST:</strong>
                        <!-- <vue-numeric class="form-control" currency="$" separator=","  v-model="consistgency_cost" v-on:change="consistgencyCostAmount"></vue-numeric>  -->
                        <!-- <div class="dollar"> -->
                        <input
                          type="text"
                          class="form-control"
                          v-model="consistgency_cost"
                          v-on:keyup="consistgencyCostAmount"
                          v-on:mouseleave="consistgencyLeave"
                        />
                        <!-- </div> -->
                        <!-- Val: {{this.consistgency_cost | currency}}                                   -->
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <strong>TOTAL ACTIVITY COST:</strong>

                        <input
                          type="text"
                          class="form-control"
                          v-model="total_cost"
                          min="0"
                          value="0"
                        />
                        <!-- <vue-numeric class="form-control" currency="$" separator=","  v-model="total_cost"></vue-numeric>  -->
                        <!-- <input type="number" class="form-control" v-model="total_cost" min="0"  >                                       -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 jac">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <span
                    class="btn btn-success form-control btn-activity-component"
                    style="cursor: auto !important"
                    >JOB ACTIVITY COMPONENT:</span
                  >
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div
                    class="form-group"
                    style="height: 400px;
                      overflow: scroll;
                      background: aliceblue;
                    "
                  >
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th style="width: 15%">ITEM #</th>
                          <th style="width: 35%">RESOURCE TYPE</th>
                          <th style="width: 20%">QUANTITY</th>
                          <th style="width: 10%">UNIT</th>
                          <th style="width: 10%">RATE</th>
                          <th style="width: 10%">AMOUNT</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(component, i) in components" :key="i">
                          <td style="width: 10%">{{ component.key }}</td>
                          <td style="width: 50%">
                            {{ component.resource_type }}
                          </td>
                          <td style="width: 10%">{{ component.quantity }}</td>
                          <td style="width: 10%">{{ component.unit }}</td>
                          <td align="right" style="width: 10%">
                            {{ component.rate | currency }}
                            <!-- <vue-numeric class="form-control show-currency" currency="$" disabled={disabled} separator=","  :value="component.rate"></vue-numeric> -->
                            <!-- ${{        new Intl.NumberFormat().format(parseFloat(component.rate).toFixed(2)) }} -->
                            <!-- ${{parseFloat(component.rate).toFixed(2).toLocaleString() }} -->
                          </td>
                          <td align="right" style="width: 10%">
                            {{ component.amount | currency }}
                            <!-- {{ formatter.format(component.amount) }} -->
                            <!-- $ {{ Number(parseFloat(component.amount).toFixed(2)).toLocaleString() }} -->
                            <!-- <vue-numeric class="form-control show-currency" currency="$" disabled={disabled} separator=","  :value="component.amount"></vue-numeric> -->
                            <!-- ${{        new Intl.NumberFormat({minimumFractionDigits: 2}).format(component.amount) }} -->
                            <!-- ${{parseFloat((component.amount) | currency).toFixed(2)}}  -->
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <strong>Job Activity Specification:</strong>
                    <textarea id="project_specification"
                      class="form-control"
                      rows="5"
                      v-model="project_specification"
                    ></textarea>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <strong>Component List & Prices:</strong>
                    <textarea id="component_note"
                      class="form-control"
                      rows="5"
                      v-model="component_note"
                    ></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <br />
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
              <!-- <span class="btn btn-success">Reset Form</span>
                    <span class="btn btn-success">Load Values</span>
                    <span class="btn btn-success">Estimate</span>
                    <span class="btn btn-success">Reset</span> -->
              <!-- <button class="btn btn-primary btn-lg btn-open-modal" data-toggle="modal" data-target="#modal-fullscreen-xl">
  Fullscreen modal xl down
</button> -->
              <!-- <span class="btn btn-success" @click="printPDF" >Print / Preview</span> -->
              <span
                class="btn btn-success btn-open-modal"
                data-toggle="modal"
                data-target="#modal-fullscreen-xl"
                @click="printForm"
                >Print Estimate</span
              >
              <span
                class="btn btn-success btn-open-modal"
                data-toggle="modal"
                data-target="#print2"
                @click="printForm"
                >Print / Est-Comp</span
              >
              <span
                class="btn btn-success btn-open-modal"
                data-toggle="modal"
                data-target="#print2-general"
                @click="printForm"
                >Project Resource List</span
              >
              <span class="btn btn-success btn-open-modal" @click="clearForm"
                >Clear / Reset Form</span
              >
              <span
                class="btn btn-success btn-open-modal"
                @click="showSaveModal"
                >Save Estimate</span
              >
              <span
                class="btn btn-success btn-open-modal" id="viewestimate"
                @click="viewEsitmate"
                >View Estimate</span
              >
              <span
                class="btn btn-success btn-open-modal"
                data-toggle="modal"
                data-target="#filterdata"
                @click="onClickResComponent('Labour')"
                >Labour</span
              >
              <span
                class="btn btn-success btn-open-modal"
                data-toggle="modal"
                data-target="#filterdata"
                @click="onClickResComponent('Equipment')"
                >Equipment</span
              >
              <span
                class="btn btn-success btn-open-modal"
                data-toggle="modal"
                data-target="#filterdata"
                @click="onClickResComponent('Material')"
                >Material</span
              >

              <div
                class="modal modal-fullscreen-xl printme"
                id="modal-fullscreen-xl"
                tabindex="-1"
                role="dialog"
                aria-hidden="true"
              >
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Modal title</h5>
                      <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                      >
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" id="print-this">
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000"> PROJECT TITLE </strong>
                        </label>
                        <div class="col-sm-10">
                          <input
                            style="border: 1px solid #ccc"
                            v-model="project_title_sum"
                            id="project_title_sum"
                            type="text"
                            class="form-control-plaintext"
                          />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000"> ESTIMATE TYPE </strong>
                        </label>
                        <div class="col-sm-10">
                          <input
                            type="text"
                            style="border: 1px solid #ccc"
                            v-model="estimate_type_sum"
                            id="estimate_type_sum"
                            class="form-control-plaintext"
                          />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000"> COUNTRY </strong>
                        </label>
                        <div class="col-sm-10">
                          <input
                            type="text"
                            style="border: 1px solid #ccc"
                            v-model="country_name"
                            id="country_name"
                            class="form-control-plaintext"
                          />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000"> CONTRACTOR </strong>
                        </label>
                        <div class="col-sm-10">
                          <input
                            type="text"
                            style="border: 1px solid #ccc"
                            v-model="contractor"
                            id="contractor"
                            class="form-control-plaintext"
                          />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000"> OWNER </strong>
                        </label>
                        <div class="col-sm-10">
                          <input
                            type="text"
                            style="border: 1px solid #ccc"
                            v-model="owner"
                            class="form-control-plaintext"
                            id="owner"
                          />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000">
                            PROJECT DESCRIPTION
                          </strong>
                        </label>
                        <div class="col-sm-10">
                          <textarea
                            v-model="project_description"
                            id="project_description"
                            class="form-control"
                          ></textarea>

                          <!-- <input type="text"  style="border:1px solid #ccc;height:200px"  v-model="project_description"  class="form-control-plaintext"   value=" NOTE:Project consist of reinforced concrete structures Etc"> -->
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000">
                            PROJECT SPECIFICATION
                          </strong>
                        </label>
                        <div class="col-sm-10">
                          <textarea
                            v-model="project_specification"
                            id="project_specification"
                            class="form-control"
                          ></textarea>

                          <!-- <input type="text"  style="border:1px solid #ccc;height:200px"  v-model="project_specification"  class="form-control-plaintext description-on"  value=" NOTE:Project specification described how the project to be carried out" > -->
                        </div>
                      </div>
                      <table
                        class="table table-striped table-bordered"
                        id="print_1"
                        style="background: aliceblue"
                        v-columns-resizable
                      >
                        <thead>
                          <tr>
                            <th width="8%">ACTIVITY CODE</th>
                            <th width="12%">ELEMENT DESCRIPTION</th>
                            <th width="25%">JOB ACTIVITY</th>
                            <th width="5%">QUANTITY</th>
                            <th width="5%">UNIT</th>
                            <th width="5%">RATE</th>
                            <th width="5%">LAB</th>
                            <th width="5%">EQUIP</th>
                            <th width="5%">MAT</th>
                            <th width="5%">ADD/DISC</th>
                            <th width="5%">OH&P</th>
                            <th width="5%">CONT</th>
                            <th width="5%">AMOUNT</th>
                          </tr>
                        </thead>
                        <tbody v-if="loadResourceComponent">
                          <tr
                            v-for="(component, i) in totalCalculation"
                            :key="i"
                          >
                            <td>{{ component.activity_code }}</td>
                            <td>{{ component.element_description }}</td>
                            <td>{{ component.job_activity }}</td>
                            <td>{{ component.quantity }}</td>
                            <td>{{ component.unit }}</td>
                            <td>{{ component.rate | currency }}</td>
                            <td>{{ component.lab | currency }}</td>

                            <td>{{ component.eqp | currency }}</td>
                            <td>{{ component.mat | currency }}</td>
                            <td>{{ component.addcost | currency }}</td>
                            <td>{{ component.ohp | currency }}</td>
                            <td>{{ component.cont | currency }}</td>
                            <td align="right">{{ component.amount | currency }}</td>
                          </tr>
                          <tr>
                            <td colspan="10"></td>
                            <td colspan="2">SUB-TOTAL-COST</td>
                            <td align="right">{{ this.total_amout_sum | currency }}</td>
                          </tr>
                          <tr>
                            <td colspan="10"></td>
                            <td colspan="2">TOTAL-LABOUR-COST</td>
                            <td align="right">{{ this.total_labour_sum | currency }}</td>
                          </tr>
                          <tr>
                            <td colspan="10"></td>
                            <td colspan="2">TOTAL-EQUIPMENT-COST</td>
                            <td align="right">{{ this.total_equipment_sum | currency }}</td>
                          </tr>
                          <tr>
                            <td colspan="10"></td>
                            <td colspan="2">TOTAL-MATERIAL-COST</td>
                            <td align="right">{{ this.total_material_sum | currency }}</td>
                          </tr>
                          <tr>
                            <td colspan="10"></td>

                            <td colspan="2">ADDITIONAL/DISCOUNT COST	</td>
                            <td align="right">{{ this.total_addition_sum | currency }}</td>
                          </tr>
                          <tr>
                            <td colspan="10"></td>
                            <td colspan="2">PRELIMINARY COST</td>

                            <td align="right">
                              {{
                                this.total_preliminary_sum_collect | currency
                              }}
                            </td>
                          </tr>
                          <tr>
                            <td colspan="10"></td>
                            <td colspan="2">OVERHEADS & PROFIT</td>

                            <td align="right">{{ this.total_ohp_sum | currency }}</td>
                          </tr>
                          <tr>
                            <td colspan="10"></td>

                            <td colspan="2">CONTINGENCY COST</td>
                            <td align="right">
                              {{
                                this.total_consistgency_sum_collect | currency
                              }}
                            </td>
                          </tr>
                          <tr>
                            <td colspan="10"></td>
                            <td colspan="2">TOTAL COST</td>
                            <td align="right">{{ this.total_amout_collect | currency }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="modal-footer">
                      <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                        @click="printCloseFirst()"
                      >
                        Close
                      </button>
                      <button
                        type="button"
                        class="btn btn-primary"
                        @click="print()"
                      >
                        Print
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <div
                class="modal modal-fullscreen-xl printme"
                id="print2"
                tabindex="-1"
                role="dialog"
                aria-hidden="true"
              >
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Modal title</h5>
                      <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                      >
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" id="print-this-two">
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000"> PROJECT TITLE </strong>
                        </label>
                        <div class="col-sm-10">
                          <input
                            style="border: 1px solid #ccc"
                            v-model="project_title_sum"
                            id="project_title_sum_two"
                            type="text"
                            class="form-control-plaintext"
                          />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000"> ESTIMATE TYPE </strong>
                        </label>
                        <div class="col-sm-10">
                          <input
                            type="text"
                            style="border: 1px solid #ccc"
                            v-model="estimate_type_sum"
                            id="estimate_type_sum_two"
                            class="form-control-plaintext"
                          />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000"> COUNTRY </strong>
                        </label>
                        <div class="col-sm-10">
                          <input
                            type="text"
                            style="border: 1px solid #ccc"
                            v-model="country_name"
                            id="country_name_two"
                            class="form-control-plaintext"
                          />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000"> CONTRACTOR </strong>
                        </label>
                        <div class="col-sm-10">
                          <input
                            type="text"
                            style="border: 1px solid #ccc"
                            v-model="contractor"
                            id="contractor_two"
                            class="form-control-plaintext"
                          />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000"> OWNER </strong>
                        </label>
                        <div class="col-sm-10">
                          <input
                            type="text"
                            style="border: 1px solid #ccc"
                            v-model="owner"
                            class="form-control-plaintext"
                            id="owner_two"
                          />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000">
                            PROJECT DESCRIPTION
                          </strong>
                        </label>
                        <div class="col-sm-10">
                          <textarea
                            v-model="project_description"
                            id="project_description_two"
                            class="form-control"
                          ></textarea>

                          <!-- <input type="text"  style="border:1px solid #ccc;height:200px"  v-model="project_description"  class="form-control-plaintext"   value=" NOTE:Project consist of reinforced concrete structures Etc"> -->
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000">
                            PROJECT SPECIFICATION
                          </strong>
                        </label>
                        <div class="col-sm-10">
                          <textarea
                            v-model="project_specification"
                            id="project_specification_two"
                            class="form-control"
                          ></textarea>

                          <!-- <input type="text"  style="border:1px solid #ccc;height:200px"  v-model="project_specification"  class="form-control-plaintext description-on"  value=" NOTE:Project specification described how the project to be carried out" > -->
                        </div>
                      </div>
                      <table
                        class="table table-striped table-bordered"
                        id="print_2"
                        style="background: aliceblue"
                        v-columns-resizable
                      >
                        <thead>
                          <tr>
                            <th width="8%">ACTIVITY CODE</th>
                            <th width="12%">ELEMENT DESCRIPTION</th>
                            <th width="25%">JOB ACTIVITY</th>
                            <th width="5%">QUANTITY</th>
                            <th width="5%">UNIT</th>
                            <th width="5%">RATE</th>
                            <th width="5%">LAB</th>
                            <th width="5%">EQUIP</th>
                            <th width="5%">MAT</th>
                            <th width="5%">ADD/DISC</th>
                            <th width="5%">OH&P</th>
                            <th width="5%">CONT</th>
                            <th width="5%">AMOUNT</th>
                          </tr>
                        </thead>
                        <tbody v-if="loadResourceComponent">
                          <tr
                            v-for="(component, i) in totalCalculation"
                            :key="i"
                          >
                            <td>{{ component.activity_code }}</td>
                            <td>{{ component.element_description }}</td>
                            <td>{{ component.job_activity }}</td>
                            <td>
                              {{ component.quantity }}
                              <table
                                class="table table-striped table-bordered"
                                style="background: aliceblue"
                                v-columns-resizable
                              >
                                <thead>
                                  <tr>
                                    <th colspan="6" align="center">
                                      (DETAIL ACTIVITY COMPONENTS)
                                    </th>
                                  </tr>
                                  <tr>
                                    <th>Item #</th>
                                    <th>Resource Type</th>
                                    <th>Component unitlist / Quantity</th>
                                    <th>Component Unit</th>
                                    <th>Rate</th>
                                    <th>Amount</th>
                                  </tr>
                                </thead>

                                <tbody>
                                  <tr
                                    v-for="(
                                      acd, i
                                    ) in component.activity_detail"
                                    :key="i"
                                  >
                                    <td>{{ acd.key }}</td>
                                    <td>{{ acd.resource_type }}</td>
                                    <td>{{ acd.quantity }}</td>
                                    <td>{{ acd.unit }}</td>
                                    <td align="right">
                                      {{ acd.rate | currency }}
                                    </td>
                                    <td align="right">{{ acd.amount | currency }}</td>                                    
                                  </tr>
                                  <tr>
                                    <td></td>
                                    <td>Total</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td align="right">{{ component.sum | currency }}</td>
                                  </tr>
                                </tbody>
                              </table>
                            </td>
                            <td>{{ component.unit }}</td>
                            <td>{{ component.rate | currency }}</td>
                            <td>{{ component.lab | currency }}</td>
                            <td>{{ component.eqp | currency }}</td>
                            <td>{{ component.mat | currency }}</td>
                            <td>{{ component.addcost | currency }}</td>
                            <td>{{ component.ohp | currency }}</td>
                            <td>{{ component.cont | currency }}</td>
                            <td align="right">{{ component.amount | currency }}</td>
                          </tr>

                          <tr>
                            <td colspan="9"></td>
                            <td colspan="3">SUB-TOTAL-COST</td>
                            <td align="right">{{ this.total_amout_sum | currency }}</td>
                          </tr>
                          <tr>
                            <td colspan="9"></td>
                            <td colspan="3">TOTAL-LABOUR-COST</td>
                            <td align="right">{{ this.total_labour_sum | currency }}</td>
                          </tr>
                          <tr>
                            <td colspan="9"></td>
                            <td colspan="3">TOTAL-EQUIPMENT-COST</td>
                            <td align="right">{{ this.total_equipment_sum | currency }}</td>
                          </tr>
                          <tr>
                            <td colspan="9"></td>
                            <td colspan="3">TOTAL-MATERIAL-COST</td>
                            <td align="right">{{ this.total_material_sum | currency }}</td>
                          </tr>
                          <tr>
                            <td colspan="9"></td>

                            <td colspan="3">ADDITIONAL/DISCOUNT COST</td>
                            <td align="right">{{ this.total_addition_sum | currency }}</td>
                          </tr>
                          <tr>
                            <td colspan="9"></td>
                            <td colspan="3">PRELIMINARY COST</td>

                            <td align="right">
                              {{
                                this.total_preliminary_sum_collect | currency
                              }}
                            </td>
                          </tr>
                          <tr>
                            <td colspan="9"></td>
                            <td colspan="3">OVERHEADS & PROFIT</td>

                            <td align="right">{{ this.total_ohp_sum | currency }}</td>
                          </tr>
                          <tr>
                            <td colspan="9"></td>

                            <td colspan="3">CONTINGENCY COST</td>
                            <td align="right">
                              {{
                                this.total_consistgency_sum_collect | currency
                              }}
                            </td>
                          </tr>
                          <tr>
                            <td colspan="9"></td>
                            <td colspan="3">TOTAL COST</td>
                            <td align="right">{{ this.total_amout_collect | currency }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="modal-footer">
                      <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                        @click="printCloseSecond()"
                      >
                        Close
                      </button>
                      <button
                        type="button"
                        class="btn btn-primary"
                        @click="print2()"
                      >
                        Print
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <div
                class="modal modal-fullscreen-xl printme"
                id="print2-general"
                tabindex="-1"
                role="dialog"
                aria-hidden="true"
              >
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Modal title</h5>
                      <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                      >
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" id="print-this-two">
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000"> PROJECT TITLE </strong>
                        </label>
                        <div class="col-sm-10">
                          <input
                            style="border: 1px solid #ccc"
                            v-model="project_title_sum"
                            id="project_title_sum_two"
                            type="text"
                            class="form-control-plaintext"
                          />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000"> ESTIMATE TYPE </strong>
                        </label>
                        <div class="col-sm-10">
                          <input
                            type="text"
                            style="border: 1px solid #ccc"
                            v-model="estimate_type_sum"
                            id="estimate_type_sum_two"
                            class="form-control-plaintext"
                          />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000"> COUNTRY </strong>
                        </label>
                        <div class="col-sm-10">
                          <input
                            type="text"
                            style="border: 1px solid #ccc"
                            v-model="country_name"
                            id="country_name_two"
                            class="form-control-plaintext"
                          />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000"> CONTRACTOR </strong>
                        </label>
                        <div class="col-sm-10">
                          <input
                            type="text"
                            style="border: 1px solid #ccc"
                            v-model="contractor"
                            id="contractor_two"
                            class="form-control-plaintext"
                          />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000"> OWNER </strong>
                        </label>
                        <div class="col-sm-10">
                          <input
                            type="text"
                            style="border: 1px solid #ccc"
                            v-model="owner"
                            class="form-control-plaintext"
                            id="owner_two"
                          />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000">
                            PROJECT DESCRIPTION
                          </strong>
                        </label>
                        <div class="col-sm-10">
                          <textarea
                            v-model="project_description"
                            id="project_description_two"
                            class="form-control"
                          ></textarea>

                          <!-- <input type="text"  style="border:1px solid #ccc;height:200px"  v-model="project_description"  class="form-control-plaintext"   value=" NOTE:Project consist of reinforced concrete structures Etc"> -->
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000">
                            PROJECT SPECIFICATION
                          </strong>
                        </label>
                        <div class="col-sm-10">
                          <textarea
                            v-model="project_specification"
                            id="project_specification_two"
                            class="form-control"
                          ></textarea>

                          <!-- <input type="text"  style="border:1px solid #ccc;height:200px"  v-model="project_specification"  class="form-control-plaintext description-on"  value=" NOTE:Project specification described how the project to be carried out" > -->
                        </div>
                      </div>
                      <table
                        class="table table-striped table-bordered"
                        id="print_2"
                        style="background: aliceblue"
                        v-columns-resizable
                      >
                        <thead>
                          <tr>
                            <th width="8%">ITEM #</th>
                            <th width="25%">RESOURCE TYPE</th>
                            <th width="10%">CATEGORY</th>
                            <th width="5%">QUANTITY</th>
                            <th width="25%">UNIT</th>
                          </tr>
                        </thead>
                        <tbody v-if="loadResourceComponent">
                          <tr
                            v-for="(component, i) in groupComponents()"
                            :key="i"
                          >
                            <td>{{ i+1 }}</td>
                            <td>{{ component.resource_type }}</td>
                            <td>{{ component.category }}</td>
                            <td>{{ component.quantity }}</td>
                            <td>{{ component.unit }}</td>
                          </tr>

                        </tbody>
                      </table>
                    </div>
                    <div class="modal-footer">
                      <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                        @click="printCloseSecond()"
                      >
                        Close
                      </button>
                      <button
                        type="button"
                        class="btn btn-primary"
                        @click="print2()"
                      >
                        Print
                      </button>
                    </div>
                  </div>
                </div>
              </div>

                <div
                class="modal modal-fullscreen-xl printme"
                id="filterdata"
                tabindex="-1"
                role="dialog"
                aria-hidden="true"
              >
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Modal title</h5>
                      <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                      >
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" id="print-this-three">
                        
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000"> PROJECT TITLE </strong>
                        </label>
                        <div class="col-sm-10">
                          <input
                            style="border: 1px solid #ccc"
                            v-model="project_title_sum"
                            id="p3_project_title_sum_two"
                            type="text"
                            class="form-control-plaintext"
                          />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000"> ESTIMATE TYPE </strong>
                        </label>
                        <div class="col-sm-10">
                          <input
                            type="text"
                            style="border: 1px solid #ccc"
                            v-model="estimate_type_sum"
                            id="p3_estimate_type_sum_two"
                            class="form-control-plaintext"
                          />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000"> COUNTRY </strong>
                        </label>
                        <div class="col-sm-10">
                          <input
                            type="text"
                            style="border: 1px solid #ccc"
                            v-model="country_name"
                            id="p3_country_name_two"
                            class="form-control-plaintext"
                          />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000"> CONTRACTOR </strong>
                        </label>
                        <div class="col-sm-10">
                          <input
                            type="text"
                            style="border: 1px solid #ccc"
                            v-model="contractor"
                            id="p3_contractor_two"
                            class="form-control-plaintext"
                          />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000"> OWNER </strong>
                        </label>
                        <div class="col-sm-10">
                          <input
                            type="text"
                            style="border: 1px solid #ccc"
                            v-model="owner"
                            class="form-control-plaintext"
                            id="p3_owner_two"
                          />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000">
                            PROJECT DESCRIPTION
                          </strong>
                        </label>
                        <div class="col-sm-10">
                          <textarea
                            v-model="project_description"
                            id="p3_project_description_two"
                            class="form-control"
                          ></textarea>

                          <!-- <input type="text"  style="border:1px solid #ccc;height:200px"  v-model="project_description"  class="form-control-plaintext"   value=" NOTE:Project consist of reinforced concrete structures Etc"> -->
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="staticEmail"
                          class="col-sm-2 col-form-label"
                        >
                          <strong style="color: 000000">
                            PROJECT SPECIFICATION
                          </strong>
                        </label>
                        <div class="col-sm-10">
                          <textarea
                            v-model="project_specification"
                            id="p3_project_specification_two"
                            class="form-control"
                          ></textarea>

                          <!-- <input type="text"  style="border:1px solid #ccc;height:200px"  v-model="project_specification"  class="form-control-plaintext description-on"  value=" NOTE:Project specification described how the project to be carried out" > -->
                        </div>
                      </div>
                      <table
                        class="table table-striped table-bordered"
                        id="print_3"
                        style="background: aliceblue"
                        v-columns-resizable
                      >
                        <thead>
                          <tr>
                            <th>ACTIVITY CODE</th>
                            <th>ELEMENT DESCRIPTION</th>
                            <th>JOB ACTIVITY</th>
                            <th>QUANTITY</th>
                            <th>UNIT</th>
                            <th>RATE</th>
                            <th v-if="lab_category">LAB</th>
                            <th v-if="eqp_category">EQUIP</th>
                            <th v-if="mat_category">MAT</th>
                            <th>ADD/DISC</th>
                            <th>OH&P</th>
                            <th>CONT</th>
                            <th>AMOUNT</th>
                          </tr>
                        </thead>
                        <tbody v-if="loadResourceComponent">
                          <tr
                            v-for="(rescomponent, i) in rescomponents"
                            :key="i"
                          >
                            <td>{{ rescomponent.activity_code }}</td>
                            <td>{{ rescomponent.element_description }}</td>
                            <td>{{ rescomponent.job_activity }}</td>
                            <td>
                              {{ rescomponent.quantity }}
                              <table
                                class="table table-striped table-bordered"
                                style="background: aliceblue"
                                v-columns-resizable
                              >
                                <thead>
                                  <tr>
                                    <th colspan="6" align="center">
                                      (DETAIL ACTIVITY COMPONENTS)
                                    </th>
                                  </tr>
                                  <tr>
                                    <th>Item #</th>
                                    <th>Resource Type</th>
                                    <th>Component unitlist / Quantity</th>
                                    <th>Component Unit</th>
                                    <th>Rate</th>
                                    <th>Amount</th>
                                  </tr>
                                </thead>

                                <tbody>
                                  <tr
                                    v-for="(
                                      acd, i
                                    ) in rescomponent.activity_details"
                                    :key="i"
                                  >
                                    <td>{{ i+1 }}</td>
                                    <td>{{ acd.resource_type }}</td>
                                    <td>{{ acd.quantity }}</td>
                                    <td>{{ acd.unit }}</td>
                                    <td align="right">
                                      {{ acd.rate | currency }}
                                    </td>
                                    <td align="right">{{ acd.amount | currency }}</td>                                    
                                  </tr>
                                  <tr>
                                    <td></td>
                                    <td>Total</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td align="right">{{ rescomponent.res_sum | currency }}</td>
                                  </tr>
                                </tbody>
                              </table>
                            </td>
                            <td>{{ rescomponent.unit }}</td>
                            <td>{{ (rescomponent.per_unit).toFixed(2) | currency }}</td>
                            
                            <!--<td v-if="lab_category">{{ (parseFloat(rescomponent.lab)/parseInt(rescomponent.quantity)) | currency }}</td>
                            <td v-if="eqp_category">{{ (parseFloat(rescomponent.eqp)/parseInt(rescomponent.quantity)) | currency }}</td>
                            <td v-if="mat_category">{{ (parseFloat(rescomponent.mat)/parseInt(rescomponent.quantity)) | currency }}</td>-->
                            
                            <td v-if="lab_category">{{ rescomponent.lab | currency }}</td>
                            <td v-if="eqp_category">{{ rescomponent.eqp | currency }}</td>
                            <td v-if="mat_category">{{ rescomponent.mat | currency }}</td>
                            <td>{{ rescomponent.addcost | currency }}</td>

                            <td v-if="lab_category">{{ (rescomponent.lab * overhead_percentage)/100 | currency }}</td>
                            <td v-if="eqp_category">{{ (rescomponent.eqp * overhead_percentage)/100 | currency }}</td>
                            <td v-if="mat_category">{{ (rescomponent.mat * overhead_percentage)/100 | currency }}</td>
                            
                            <td v-if="lab_category">{{ (rescomponent.lab * consistgency_percentage)/100 | currency }}</td>
                            <td v-if="eqp_category">{{ (rescomponent.eqp * consistgency_percentage)/100 | currency }}</td>
                            <td v-if="mat_category">{{ (rescomponent.mat * consistgency_percentage)/100 | currency }}</td>
                            
                            <td align="right" v-if="lab_category">{{ rescomponent.lab + ((rescomponent.lab * overhead_percentage)/100) + ((rescomponent.lab * consistgency_percentage)/100) + ((rescomponent.lab * preliminary_percentage)/100) | currency }}</td>
                            <td align="right" v-if="eqp_category">{{ rescomponent.eqp + ((rescomponent.eqp * overhead_percentage)/100) + ((rescomponent.eqp * consistgency_percentage)/100) + ((rescomponent.eqp * preliminary_percentage)/100) | currency }}</td>
                            <td align="right" v-if="mat_category">{{ rescomponent.mat + ((rescomponent.mat * overhead_percentage)/100) + ((rescomponent.mat * consistgency_percentage)/100) + ((rescomponent.mat * preliminary_percentage)/100) | currency }}</td>
                            
                          </tr>

                          <tr>
                            <td colspan="7"></td>
                            <td colspan="3">SUB-TOTAL-COST</td>
                            <td align="right">{{ this.rescomp_sub_total | currency }}</td>
                          </tr>
                          <tr v-if="lab_category"> 
                            <td colspan="7"></td>
                            <td colspan="3">TOTAL-LABOUR-COST</td>
                            <td align="right">{{ this.lab_category_sum | currency }}</td>
                          </tr>
                          <tr v-if="eqp_category">
                            <td colspan="7"></td>
                            <td colspan="3">TOTAL-EQUIPMENT-COST</td>
                            <td align="right">{{ this.eqp_category_sum | currency }}</td>
                          </tr>
                          <tr v-if="mat_category">
                            <td colspan="7"></td>
                            <td colspan="3">TOTAL-MATERIAL-COST</td>
                            <td align="right">{{ this.mat_category_sum | currency }}</td>
                          </tr>
                          <tr>
                            <td colspan="7"></td>

                            <td colspan="3">ADDITIONAL / DISCOUNT COST </td>
                            <td align="right">{{ this.total_addition_sum | currency }}</td>
                          </tr>
                          <tr>
                            <td colspan="7"></td>
                            <td colspan="3">PRELIMINARY COST</td>

                            <td align="right">
                              {{
                                this.total_preliminary_sum_collect | currency
                              }}
                            </td>
                          </tr>
                          <tr>
                            <td colspan="7"></td>
                            <td colspan="3">OVERHEADS & PROFIT</td>

                            <td align="right">{{ this.total_ohp_sum | currency }}</td>
                          </tr>
                          <tr>
                            <td colspan="7"></td>

                            <td colspan="3">CONTINGENCY COST</td>
                            <td align="right">
                              {{
                                this.total_consistgency_sum_collect | currency
                              }}
                            </td>
                          </tr>
                          <tr>
                            <td colspan="7"></td>
                            <td colspan="3">TOTAL COST</td>
                            <td align="right">{{ this.rescomp_total | currency }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="modal-footer">
                      <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                        @click="printCloseSecond()"
                      >
                        Close
                      </button>
                      <button
                        type="button"
                        class="btn btn-primary"
                        @click="print3()"
                      >
                        Print
                      </button>
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
                NOTE: USER HAVE THE OPTION TO ADD OR OMITT (APPLY NEGATIVE
                SIMBOL (-) IN FRONT OF A QUANITY VALUE TO OMITT PORTION OR FULL
                VALUE OF A COMPONENT ) COMPONENT(S) TO A JOB ACTIVITY BY
                SELECTING FROM THE COMPONENT LIST BELOW
              </p>
            </div>
          </div>
          <br />
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <form :action="route('upload.pdf')" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="pdf_file" accept=".pdf" required>
                    <button type="submit">Upload PDF</button>
                </form>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-xs-12 col-sm-12 col-md-12">
              <table
                class="table table-striped table-bordered"
                style="background: aliceblue"
              >
                <thead>
                  <tr>
                    <th width="30%">COMPONENT LIST</th>
                    <th width="10%">SELECT</th>
                    <th width="10%">OVER TIME</th>
                    <th width="10%">DOUBLE TIME</th>
                    <th width="10%">QUANTITY</th>
                    <th width="10%">UNIT</th>
                    <th width="10%">PRICE</th>
                    <th width="10%">AMOUNT</th>
                    <!-- <th>SUB-TOTAL COST</th> -->
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col-md-4">
                          <strong>Preliminaries / General Requirements:</strong>
                        </div>
                        <div class="col-md-8">
                          <select
                            class="form-control"
                            v-model="prelim_comp"
                            id="preliminries"
                          >
                            <option value=""></option>
                            <option
                              v-for="(cat, i) in preliminries"
                              :value="cat.id"
                              :key="i"
                            >
                              {{ cat.resource_type }}
                            </option>
                          </select>
                        </div>
                      </div>
                    </td>
                    <td>
                      <span class="btn btn-success" @click="addPreliminries"
                        >Add</span
                      >
                    </td>
                    <td></td>
                    <td></td>
                    <td>
                      <input
                        type="number"
                        v-model="preliminries_quantity"
                        v-on:keyup="preliminriesCost"
                      />
                    </td>

                    <td>
                      {{ preliminries_unit }}
                    </td>

                    <td>
                      <span v-if="preliminries_price">
                        <!-- $ {{ preliminries_price }} -->
                        <input
                          type="number"
                          v-model="preliminries_price"
                          v-on:keyup="preliminriesCost"
                        />
                        <!-- {{ preliminries_price | currency }} -->
                        <!-- <vue-numeric class="form-control show-currency" currency="$" disabled={disabled} separator=","  :value="preliminries_price"></vue-numeric> -->
                      </span>
                    </td>
                    <td>
                      <span v-if="preliminries_amount">
                        {{ preliminries_amount | currency }}
                        <!-- <vue-numeric class="form-control show-currency" currency="$" disabled={disabled} separator=","  :value="preliminries_amount"></vue-numeric> -->
                        <!-- $ {{ preliminries_amount }} -->
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col-md-4">
                          <strong>Labour:</strong>
                        </div>
                        <div class="col-md-8">
                          <select
                            class="form-control"
                            v-model="lab_comp"
                            id="labour"
                          >
                            <option value=""></option>
                            <option
                              v-for="(cat, i) in labour"
                              :value="cat.id"
                              :key="i"
                            >
                              {{ cat.resource_type }}
                            </option>
                          </select>
                        </div>
                      </div>
                    </td>
                    <td>
                      <span class="btn btn-success" @click="addLabour"
                        >Add</span
                      >
                    </td>
                    <td>
                      <span class="btn btn-success" @click="overTime()"
                        >1.5X</span
                      >
                    </td>
                    <td>
                      <span class="btn btn-success" @click="doubleTime()"
                        >2X</span
                      >
                    </td>
                    <td>
                      <input
                        type="number"
                        v-model="labour_quantity"
                        v-on:keyup="labourCost"
                      />
                    </td>

                    <td>
                      {{ labour_unit }}
                    </td>

                    <td>
                      <span v-if="labour_price">
                        <!-- {{ labour_price | currency }} -->
                        <input
                          type="number"
                          v-model="labour_price"
                          v-on:keyup="labourCost"
                        />
                        <!-- <vue-numeric class="form-control show-currency" currency="$" disabled={disabled} separator=","  :value="labour_price"></vue-numeric> -->

                        <!-- $ {{ labour_price }} -->
                      </span>
                    </td>
                    <td>
                      <span v-if="labour_amount">
                        <!-- <vue-numeric class="form-control show-currency" currency="$" disabled={disabled} separator=","  :value="labour_amount"></vue-numeric> -->
                        {{ labour_amount | currency }}
                        <!-- $ {{ labour_amount }} -->
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col-md-4">
                          <strong>Equipment:</strong>
                        </div>
                        <div class="col-md-8">
                          <select
                            class="form-control"
                            v-model="equipment_comp"
                            id="equipment"
                          >
                            <option value=""></option>
                            <option
                              v-for="(cat, i) in equipment"
                              :value="cat.id"
                              :key="i"
                            >
                              {{ cat.resource_type }}
                            </option>
                          </select>
                        </div>
                      </div>
                    </td>
                    <td>
                      <span class="btn btn-success" @click="addEquipment"
                        >Add</span
                      >
                    </td>
                    <td></td>
                    <td></td>
                    <td>
                      <input
                        type="number"
                        v-model="equipment_quantity"
                        v-on:keyup="equipmentCost"
                      />
                    </td>

                    <td>
                      {{ equipment_unit }}
                    </td>

                    <td>
                      <span v-if="equipment_price">
                        <!-- {{ equipment_price | currency }} -->
                        <input
                          type="number"
                          v-model="equipment_price"
                          v-on:keyup="equipmentCost"
                        />
                        <!-- <vue-numeric class="form-control show-currency" currency="$" disabled={disabled} separator=","  :value="equipment_price"></vue-numeric> -->

                        <!-- ${{ equipment_price }} -->
                      </span>
                    </td>
                    <td>
                      <span v-if="equipment_amount">
                        <!-- <vue-numeric class="form-control show-currency" currency="$" disabled={disabled} separator=","  :value="equipment_amount"></vue-numeric> -->
                        {{ equipment_amount | currency }}
                        <!-- $ {{ equipment_amount  }} -->
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col-md-4">
                          <strong>Material:</strong>
                        </div>
                        <div class="col-md-8">
                          <select
                            class="form-control"
                            v-model="material_comp"
                            id="material"
                          >
                            <option value="0.00" selected></option>
                            <option
                              v-for="(cat, i) in material"
                              :value="cat.id"
                              :key="i"
                            >
                              {{ cat.resource_type }}
                            </option>
                          </select>
                        </div>
                      </div>
                    </td>
                    <td>
                      <span class="btn btn-success" @click="addMaterial"
                        >Add</span
                      >
                    </td>
                    <td></td>
                    <td></td>
                    <td>
                      <input
                        type="number"
                        v-model="material_quantity"
                        v-on:keyup="materialCost"
                      />
                    </td>

                    <td>
                      {{ material_unit }}
                    </td>

                    <td>
                      <span v-if="material_price">
                        <!-- {{ material_price | currency }} -->
                        <input
                          type="number"
                          v-model="material_price"
                          v-on:keyup="materialCost"
                        />
                        <!-- <vue-numeric class="form-control show-currency" currency="$" disabled={disabled} separator=","  :value="material_price"></vue-numeric> -->

                        <!-- $ {{ material_price  }} -->
                      </span>
                    </td>
                    <td>
                      <span v-if="material_amount">
                        {{ material_amount | currency }}
                        <!-- <vue-numeric class="form-control show-currency" currency="$" disabled={disabled} separator=","  :value="material_amount"></vue-numeric> -->

                        <!-- $ {{ material_amount  }} -->
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div v-if="!job_activity_section" class="col-xs-12 col-sm-12 col-md-12">
              <a href="javascript:;" id="view-grid-btn" v-el:my-btn @click="viewGrid(true)" class="btn btn-info mb-3"><i class="fa fa-eye"></i> View Grid</a>
            </div>
            <div v-if="job_activity_section" class="col-xs-12 col-sm-12 col-md-12">
              <div class="table-responsive">
                <table
                  class="table table-striped table-bordered"
                  style="background: aliceblue"
                  v-columns-resizable
                  >
                  <thead>
                    <tr>
                      <th colspan="143">
                          <a href="javascript:;" @click="jobActivityWindow" class="btn btn-primary">Open as Separate Window</a>
                          <a href="javascript:;" @click="jobActivityWindow" class="btn btn-primary">UPLOAD AUTOCAD PDF DRAWINGS</a>
                      </th>
                    </tr>
                    <tr>
                      <th>ACTIVITY CODE</th>
                      <th>ELEMENT DESCRIPTION</th>
                      <th>JOB ACTIVITY</th>
                      <th>QUANTITY</th>
                      <th>UNIT</th>
                      <th>RATE</th>
                      <th>LAB</th>
                      <th>EQUIP</th>
                      <th>MAT</th>
                      <th>ADD/DISC</th>
                      <th>OH&P</th>
                      <th>CONT</th>
                      <th>AMOUNT 
                      </th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody v-if="loadResourceComponent" class="row_position detail-form-list">
                    <tr
                      v-for="(activity, i) in jobActivitiesList"
                      :key="i"
                      :id="i+'-row'"
                      :data="activity.activity_code"
                      :data-index="i"
                    >
                      <td>
                        <span :id="'activity_code_label' + i">{{
                          activity.activity_code
                        }}</span>
                        <input
                          class="form-control activity_code"
                          type="text"
                          :id="'activity_code_' + i"
                          style="display: none"
                          :value="activity.activity_code"
                        />
                      </td>
                      <td>
                        <span :id="'element_description_label' + i">{{
                          activity.element_description
                        }}</span>
                        <input
                          class="form-control element_description"
                          type="text"
                          :id="'element_description_' + i"
                          style="display: none"
                          :value="activity.element_description"
                        />
                      </td>
                      <td>
                        <span :id="'job_activity_label' + i">{{
                          activity.job_activity
                        }}</span>
                        <input
                          class="form-control job_activity"
                          type="text"
                          :id="'job_activity_' + i"
                          style="display: none;width:450px"
                          :value="activity.job_activity"
                        />
                      </td>
                      <td>{{ activity.quantity }}</td>
                      <td>{{ activity.unit }}</td>
                      <td align="right">{{ activity.rate | currency }}</td>
                      <td align="right">{{ activity.lab | currency }}</td>
                      <td align="right">{{ activity.eqp | currency }}</td>
                      <td align="right">{{ activity.mat | currency }}</td>
                      <td align="right">{{ activity.addcost | currency }}</td>
                      <td align="right">{{ activity.ohp | currency }}</td>
                      <td align="right">{{ activity.cont | currency }}</td>
                      <td align="right">{{ activity.amount | currency }}</td>
                      <td>
                        <div class="btn-group-list">
                          <span
                            class="btn btn-success editbtn"
                            :id="'edit-btn-' + i"
                            @click="edit(i)"
                            >Edit</span
                          >
                          <span
                            class="btn btn-success removebtn"
                            :id="'delete-btn-' + i"
                            @click="deleteFromSum(i)"
                            >Remove</span
                          >
                          <span
                            class="btn btn-success"
                            :id="'up-btn-' + i"
                            @click="up(activity.activity_code,i)"
                            >Up</span
                          >
                          <span
                            class="btn btn-success"
                            :id="'down-btn-' + i"
                            @click="down(activity.activity_code,i)"
                            >Down</span
                          >
                          <span
                            class="btn btn-success donebtn"
                            :id="'done-btn-' + i"
                            @click="doneUpdate(i)"
                            style="display: none"
                            >Done</span
                          >
                        </div>
                      </td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="10"></td>
                      <td colspan="2"><b>Total Cost</b></td>
                      <td align="right">
                        <b class="total_amount_sum">{{ total_amout_sum | currency }}</b>
                      </td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal
      name="save-form"
      height="auto"
      :clickToClose="false"
      :scrollable="true"
    >
      <div class="modal-content">
        <div class="modal-header" style="background-color: #28a745">
          <h4 style="color: white">Save Form</h4>
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
                  <input type="text" class="form-control" v-model="form_name" />
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="modal-body">
          <span @click="saveForm" class="btn btn-info pull-left">Save</span>
          <span @click="hideSaveModal" class="btn btn-danger pull-right"
            >Close</span
          >
        </div>
      </div>
    </modal>

    <div
      class="modal modal-fullscreen-xl printme"
      id="modal-jobactivitiylist"
      tabindex="-1"
      role="dialog"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group row">
              <label for="staticEmail" class="col-sm-2 col-form-label">
                <strong style="color: 000000"> PROJECT TITLE : </strong>
              </label>
              <div class="col-sm-10">
                <input
                  style="border: 1px solid #ccc"
                  v-model="project_title"
                  type="text"
                  class="form-control-plaintext"
                  readonly
                />
              </div>
            </div>
            <div class="form-group row">
              <label for="staticEmail" class="col-sm-2 col-form-label">
                <strong style="color: 000000"> ESTIMATE TYPE </strong>
              </label>
              <div class="col-sm-10">
                <input
                  type="text"
                  style="border: 1px solid #ccc"
                  v-model="estimate_type"
                  class="form-control-plaintext"
                  readonly
                />
              </div>
            </div>
            <div class="form-group row">
              <label for="staticEmail" class="col-sm-2 col-form-label">
                <strong style="color: 000000"> COUNTRY </strong>
              </label>
              <div class="col-sm-10">
                <input
                  type="text"
                  style="border: 1px solid #ccc"
                  v-model="country_job"
                  class="form-control-plaintext"
                  readonly
                />
              </div>
            </div>
            <div class="form-group row">
              <label for="staticEmail" class="col-sm-2 col-form-label">
                <strong style="color: 000000"> CONTRACTOR </strong>
              </label>
              <div class="col-sm-10">
                <input
                  type="text"
                  style="border: 1px solid #ccc"
                  v-model="contractor"
                  class="form-control-plaintext"
                  readonly
                />
              </div>
            </div>
            <div class="form-group row">
              <label for="staticEmail" class="col-sm-2 col-form-label">
                <strong style="color: 000000"> OWNER </strong>
              </label>
              <div class="col-sm-10">
                <input
                  type="text"
                  style="border: 1px solid #ccc"
                  v-model="owner"
                  class="form-control-plaintext"
                  readonly
                />
              </div>
            </div>
            <div class="form-group row">
              <label for="staticEmail" class="col-sm-2 col-form-label">
                <strong style="color: 000000"> PROJECT DESCRIPTION </strong>
              </label>
              <div class="col-sm-10">
                <textarea
                  v-model="project_description"
                  id="project_description"
                  class="form-control"
                ></textarea>
              </div>
            </div>
            <div class="form-group row">
              <label for="staticEmail" class="col-sm-2 col-form-label">
                <strong style="color: 000000"> PROJECT SPECIFICATION </strong>
              </label>
              <div class="col-sm-10">
                <textarea
                  v-model="project_specification"
                  id="project_specification"
                  class="form-control"
                ></textarea>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-xs-12 col-sm-12 col-md-12" id="activity-section">
                <table
                  class="table table-striped table-bordered"
                  style="background: aliceblue"
                  v-columns-resizable
                >
                  <thead>
                    <tr>
                      <th>ACTIVITY CODE</th>
                      <th>ELEMENT DESCRIPTION</th>
                      <th>JOB ACTIVITY</th>
                      <th>QUANTITY</th>
                      <th>UNIT</th>
                      <th>LAB</th>
                      <th>EQUIP</th>
                      <th>MAT</th>
                      <th>ADD/DISC</th>
                      <th>OH&P</th>
                      <th>CONT</th>
                      <th>RATE</th>
                      <th>AMOUNT</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody
                    v-if="loadResourceComponent"
                    class="modal_row_position"
                  >
                    <tr
                      v-for="(component, i) in totalCalculation"
                      :key="i"
                      :id="component.activity_code"
                    >
                      <td>
                        <span :id="'activity_code_label' + i">{{
                          component.activity_code
                        }}</span>
                        <input
                          class="form-control"
                          type="text"
                          :id="'activity_code_' + i"
                          style="display: none"
                        />
                      </td>
                      <td>
                        <span :id="'element_description_label' + i">{{
                          component.element_description
                        }}</span>
                        <input
                          class="form-control"
                          type="text"
                          :id="'element_description_' + i"
                          style="display: none"
                        />
                      </td>
                      <td>
                        <span :id="'job_activity_label' + i">{{
                          component.job_activity
                        }}</span>
                        <input
                          class="form-control"
                          type="text"
                          :id="'job_activity_' + i"
                          style="display: none"
                        />
                      </td>
                      <td>{{ component.quantity }}</td>
                      <td>{{ component.unit }}</td>
                      <td>{{ component.lab | currency }}</td>
                      <td>{{ component.eqp | currency }}</td>
                      <td>{{ component.mat | currency }}</td>
                      <td>{{ component.addcost | currency }}</td>
                      <td>{{ component.ohp | currency }}</td>
                      <td>{{ component.cont | currency }}</td>
                      <td>{{ component.rate | currency }}</td>
                      <td>{{ component.amount | currency }}</td>
                      <td>
                       <div class="btn-group-list">
                        <span
                          class="btn btn-success"
                          :id="'edit-btn-' + i"
                          @click="edit(i)"
                          >Edit</span
                        >
                        <span
                          class="btn btn-success"
                          :id="'delete-btn-' + i"
                          @click="deleteFromSum(i)"
                          >Remove</span
                        >
                        <span
                          class="btn btn-success"
                          :id="'up-btn-' + i"
                          @click="up(component.activity_code,i)"
                          >Up</span
                        >
                        <span
                          class="btn btn-success"
                          :id="'down-btn-' + i"
                          @click="down(component.activity_code,i)"
                          >Down</span
                        >
                        <span
                          class="btn btn-success"
                          :id="'done-btn-' + i"
                          @click="doneUpdate(i)"
                          style="display: none"
                          >Done</span
                        >
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="10"></td>
                      <td colspan="2"><b>Total Cost</b></td>
                      <td>
                        <b>{{ total_amout_sum | currency }}</b>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
              @click="printCloseFirst()"
            >
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
// import Activity from "./activity";
var id = $("#detail_id").val();

var vm;
$(document).ready(function () {
  $("#select2").select2();
  $("#preliminries").select2();
  $("#labour").select2();
  $("#equipment").select2();
  $("#material").select2();
});

import Input from "../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Input.vue";

export default {
  filters: {
    currency(value) {
      return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      }).format(value);
    },
  },

  async created() {
    const [cat] = await Promise.all([axios.get("/cost-estimate/detail-lists")]);

    this.getCountrys();

    this.getResults(cat.data.lists);
    if (id != 0) {
      this.formDetails();
    }
  },
  data() {
    return {
      loadResourceComponent: false,
      mat_category:false,
      project_title: "",
      estimate_type: "",
      location: "",
      category: "",
      preliminries: "",
      labour: "",
      equipment: "",
      material: "",
      country: "",
      loading: true,
      total: 0,
      quantity: 0,
      project_note: "",
      component_note: "",
      element_code: "",
      activity_code: "",
      project_description: "",
      imperial_rate: 0,
      imperial_rate_collect: 0,
      imperial_unit: 0,
      metric_rate: 0,
      metric_rate_collect: 0,
      metric_unit: 0,
      activity_quantity: 0,
      actives: {},
      job_activity: "",
      descriptions: {},
      total: 0,
      equipment_cost: 0,
      labour_cost: 0,
      material_cost: 0,
      equipment_cost_collect: 0,
      labour_cost_collect: 0,
      material_cost_collect: 0,
      sub_total: 0,
      preliminary_percentage: 0,
      preliminary_cost: 0,
      preliminary_cost_collect: 0,
      consistgency_cost: 0,
      consistgency_cost_collect: 0,
      consistgency_percentage: 0,
      overhead_cost: 0,
      overhead_cost_collect: 0,
      overhead_percentage: 0,
      total_cost: 0,
      total_cost_collect: 0,
      additional_cost: 0,
      additional_cost_collect: 0,
      //  total_labour_cost:0,
      total_labour: this.total_labour_cost,
      conservation_factor: 0,
      componentID: [],
      prelim_comp: "",
      preliminries_unit: null,
      preliminries_rate: null,
      preliminries_amount: null,
      preliminries_quantity: null,
      preliminries_price: null,

      lab_comp: "",
      labour_unit: null,
      labour_rate: null,
      labour_amount: null,
      labour_quantity: null,
      labour_price: null,
      labour_price_store: 0,

      equipment_comp: "",
      equipment_unit: null,
      equipment_rate: null,
      equipment_amount: null,
      equipment_quantity: null,
      equipment_price: null,

      material_comp: "",
      material_unit: null,
      material_rate: null,
      material_amount: null,
      material_quantity: null,
      material_price: null,
      selectedCategory: "",

      totalCalculation: [],
      jobActivitiesList: [],
      compQuantity: "",
      total_amout_sum: "",
      total_amout_collect: "",

      total_preliminary_sum: "",
      total_consistgency_sum: "",

      total_preliminary_sum_collect: "",
      total_consistgency_sum_collect: "",

      total_labour_sum: 0,
      total_equipment_sum: 0,
      total_material_sum: 0,
      total_ohp_sum: 0,
      total_addition_sum: 0,
      project_description: "",
      project_specification: "",
      owner: "",
      contractor: "",
      country_name: "",
      estimate_type_sum: "",
      project_title_sum: "",
      disabled: false,

      sub_total_collect: "",
      components: [],
      activity_all: [],
      form_name: "",
      countrys: {},
      country_job: "",
      open: false,
      activity: "",
      rescomponents: [],
      lab_category: false,
      eqp_category: false,
      mat_catehory: false,
      lab_category_sum: 0,
      eqp_category_sum: 0,
      mat_catehory_sum: 0,
      rescomp_sub_total: 0,
      rescomp_total: 0,
      trackActivity:0,
      job_activity_section:true,
      timestamp:Math.floor(Math.random() * 100000000),
    };
  },
  props: ["total_labour_cost", "totalCalculation1"],

  computed: {},
  mounted() {
    sessionStorage.setItem("startTrack",0);
    
    const vm = this;
    $("#select2").on("select2:select", function (e) {
      var job_activity_data = e.params.data;
      vm.activity_description = job_activity_data.id;
      vm.getActivity();
      vm.getVertexResults();
    });
    $("#preliminries").on("select2:select", function (e) {
      vm.prelim_comp = e.params.data.id;
      vm.selectPreliminries();
    });
    $("#labour").on("select2:select", function (e) {
      vm.lab_comp = e.params.data.id;
      vm.selectLabour();
    });
    $("#equipment").on("select2:select", function (e) {
      vm.equipment_comp = e.params.data.id;
      vm.selectEquipment();
    });
    $("#material").on("select2:select", function (e) {
      vm.material_comp = e.params.data.id;
      vm.selectMaterial();
    });
    setInterval(() => {
      // this.trackJobActivity()
      this.viewGrid();
    }, 2000);
    // this.$root.$on("detail-estimate-form", () => {
    //   // this.trackJobActivity();

      
    //   // let d = new Date();
    //   // d.setTime(d.getTime() + 1 * 24 * 60 * 60 * 1000);
    //   // let expires = "expires=" + d.toUTCString();
    //   // document.cookie = "jobActivities=CloseTestCookie;" + expires + ";path=/";

    //   window.close();
     
    //   // this.totalCalculation = [];

    //   // window.close();
    //   //   history.go(0);
    //   //   e.preventDefault();
    //   //     setTimeout(function() {
    //   // window.location.reload();
    //   //     },1000);
    //   // location.reload()
    //   // setTimeout( function(){

    //   // }, 5000)
    // });
    // alert(this.totalCalculation1);
  },
  methods: {
    getResults() {
      var _this = this;
      _this.$Progress.start();
      _this.loading = true;
      axios
        .get("/cost-estimate/detail-form/getResults?category=" + _this.category)
        .then(function (response) {
          _this.selectedCategory = response.data.data.catego;
          _this.actives = response.data.data.actives;

          _this.descriptions = response.data.data.descriptions;
          _this.$Progress.finish();
          _this.loading = false;
        });
    },
    getVertexResults: function () {
      var _this = this;
      _this.$Progress.start();
      _this.loading = true;
      var project_description = 'Project Discription of ' + _this.active.description;
      axios
        .get("/predict?text=" + project_description)
        .then(function (response) {
          _this.project_description = response.data.candidates.content.parts.text;

        //   _this.descriptions = response.data.data.descriptions;
          _this.$Progress.finish();
          _this.loading = false;
        });
    },
    getActivity: function () {
      var _this = this;
      if(_this.activity_description == ''){
        return false;
      }
      _this.$Progress.start();
      _this.loading = true;
      
      axios
        .get("/job_activities/" + _this.activity_description)
        .then(function (response) {
          _this.job_activity = response.data.data.description;
          _this.activity_code = response.data.data.activity_code;
          _this.imperial_unit = response.data.data.imperial_unit;
          _this.metric_unit = response.data.data.metric_unit;
          _this.conservation_factor = response.data.data.conservation_factor;
          _this.$Progress.finish();
          _this.loading = false;
        });
    },

    getComponents() {
      var _this = this;
      _this.$Progress.start();
      _this.loading = true;
      axios
        .get("/cost-estimate/detail-form/getcomponents?id=" + _this.country)
        .then(function (response) {
          _this.preliminries = response.data.data.Preliminries;
          _this.labour = response.data.data.Labour;
          _this.equipment = response.data.data.Equipment;
          _this.material = response.data.data.Material;
          
          _this.country_job = $("#country_id").find(":selected").text().trim();
          
          _this.$Progress.finish();
          _this.loading = false;
        });
    },
    getCountrys() {
      var _this = this;
      _this.$Progress.start();
      _this.loading = true;
      axios
        .get("/cost-estimate/detail-form/getCountry")
        .then(function (response) {
          _this.countrys = response.data.data.countrys;
          _this.$Progress.finish();
          _this.loading = false;
        });
    },
    loadComponent() {
      sessionStorage.removeItem('totalCalculation');
      this.loadResourceComponent = true;
      this.job_activity_section = true;
      var activity_all_data = [];
      var activity_sum = 0;

      this.components.forEach((value, index) => {        
        activity_all_data.push({
          key: value.key,
          category: value.category,
          resource_type: value.resource_type,
          quantity: value.quantity,
          unit: value.unit,
          rate: value.rate,
          amount: value.amount,
        });
        activity_sum += value.amount;
      });

      // alert(JSON.stringify(activity_all_data));
      let rate = this.total_cost_collect / this.quantity;
      var lists = {
        activity_code: this.activity_code,
        element_description: this.selectedCategory.title,
        job_activity: this.job_activity,
        quantity: this.quantity,
        unit: this.imperial_unit,
        lab: this.labour_cost_collect,
        mat: this.material_cost_collect,
        addcost: this.additional_cost_collect,
        cont: this.consistgency_cost_collect,
        eqp: this.equipment_cost_collect,
        ohp: this.overhead_cost_collect,
        rate: rate,
        amount: this.total_cost_collect,
        preliminary_cost: this.preliminary_cost_collect,
        consistgency_cost: this.consistgency_cost_collect,
        activity_detail: activity_all_data,
        sum: activity_sum,
      };

      let exists = 0;
      this.totalCalculation.forEach((value, key) => {
        if(value.activity_code == this.activity_code){
          exists = 1;
        }
      });
      this.jobActivitiesList.push(lists);
      this.totalCalculation.push(lists);
    
      // if(exists == 0){
      //   this.jobActivitiesList.push(lists);
      //   this.totalCalculation.push(lists);
      // }else{
      //   alert("Activity already added");
      // }
      
      
      this.total_amout_sum = this.totalCalculation.reduce(function (
        sum,
        current
      ) {
        return (sum += Number(parseFloat(current.amount).toFixed(2)));
      },
      0);
      this.total_labour_sum = this.totalCalculation.reduce(function (
        sum,
        current
      ) {
        return (sum += Number(parseFloat(current.lab).toFixed(2)));
      },
      0);

      this.total_equipment_sum = this.totalCalculation.reduce(function (
        sum,
        current
      ) {
        return (sum += Number(parseFloat(current.eqp).toFixed(2)));
      },
      0);

      this.total_material_sum = this.totalCalculation.reduce(function (
        sum,
        current
      ) {
        return (sum += Number(parseFloat(current.mat).toFixed(2)));
      },
      0);

      this.total_addition_sum = this.totalCalculation.reduce(function (
        sum,
        current
      ) {
        return (sum += Number(parseFloat(current.addcost).toFixed(2)));
      },
      0);

      this.total_preliminary_sum = this.totalCalculation.reduce(function (
        sum,
        current
      ) {
        return (sum += Number(parseFloat(current.preliminary_cost).toFixed(2)));
      },
      0);
      
      // this.total_ohp_sum = this.totalCalculation.reduce(function (
      //   sum,
      //   current
      // ) {
      //   return (sum += Number(parseFloat(current.ohp).toFixed(2)));
      // },
      // 0);

      this.total_preliminary_sum_collect = parseFloat(
        this.total_preliminary_sum
      );
      this.total_consistgency_sum = this.totalCalculation.reduce(function (
        sum,
        current
      ) {
        return (sum += Number(
          parseFloat(current.consistgency_cost).toFixed(2)
        ));
      },
      0);

      this.total_consistgency_sum_collect = parseFloat(
        this.total_consistgency_sum
      );

      this.total_amout_collect = this.total_amout_sum;
      // this.total_amout_collect = parseFloat(
      //   parseFloat(this.total_labour_sum) +
      //     parseFloat(this.total_equipment_sum) +
      //     parseFloat(this.total_material_sum) +
      //     parseFloat(this.total_preliminary_sum) +
      //     parseFloat(this.total_addition_sum) +
      //     parseFloat(this.total_ohp_sum) +
      //     parseFloat(this.total_consistgency_sum)
      // ).toFixed(2);

      var totalCalculationArray = this.totalCalculation;
      const vm1 = this;
      $(".detail-form-list").sortable({
        delay: 150
      });
      // $('#modal-jobactivitiylist').modal('show');
      // alert(JSON.stringify(this.totalCalculation));
      // console.log(this.total_amout_collect)
    },
    checkDetails() {
      var activity_data = [];
      var _this = this;
      _this.$Progress.start();
      _this.loading = true;
      axios
        .get(
          "/cost-estimate/detail-form/getInfo/Components?id=" +
            _this.activity_description +
            "&country=" +
            _this.country
        )
        .then((response) => {
          _this.components = response.data.data.components;

          _this.components = response.data.data.components.map((item, key) => {
            return {
              key: parseFloat(key) + 1,
              resource_type: item.resource_type,
              quantity: parseFloat(
                parseFloat(item.quantity).toFixed(4) * this.quantity
              ).toFixed(4),
              unit: item.unit,
              rate: item.rate,
              amount: item.quantity * this.quantity * item.rate,
              category: item.category,
            };
          });

          var labourTotal = 0;
          response.data.data.components.forEach((value, index) => {
            if (value.category == "Labour") {
              labourTotal += value.quantity * value.rate * this.quantity;
            }
          });
          var equipmentTotal = 0;
          response.data.data.components.forEach((value, index) => {
            if (value.category == "Equipment") {
              equipmentTotal += value.quantity * value.rate * this.quantity;
            }
          });
          var materialTotal = 0;
          response.data.data.components.forEach((value, index) => {
            if (value.category == "Material") {
              var m_c = parseFloat(
                value.quantity * value.rate * this.quantity
              ).toFixed(2);
              materialTotal = parseFloat(materialTotal) + parseFloat(m_c);
            }
          });

          this.labour_cost_collect = labourTotal;
          (this.labour_cost = new Intl.NumberFormat("en-US", {
            style: "currency",
            currency: "USD",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
          }).format(this.labour_cost_collect)),
            (this.equipment_cost_collect = equipmentTotal);
          (this.equipment_cost = new Intl.NumberFormat("en-US", {
            style: "currency",
            currency: "USD",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
          }).format(this.equipment_cost_collect)),
            (this.material_cost_collect = parseFloat(materialTotal));
          this.material_cost = new Intl.NumberFormat("en-US", {
            style: "currency",
            currency: "USD",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
          }).format(this.material_cost_collect);
          var addsub = 0;
          addsub = parseFloat(
            parseFloat(this.additional_cost_collect) +
              parseFloat(equipmentTotal) +
              parseFloat(labourTotal) +
              parseFloat(materialTotal)
          ).toFixed(2);

          this.sub_total = new Intl.NumberFormat("en-US", {
            style: "currency",
            currency: "USD",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
          }).format(addsub);
          this.sub_total_collect = addsub;
          this.total_cost = this.sub_total;
          this.total_cost_collect = this.sub_total_collect;
          _this.$Progress.finish();
          _this.loading = false;
        });
    },

    selectPreliminries() {
      var type = "preme";
      this.componentApi(this.prelim_comp, type);
    },
    selectLabour() {
      var type = "labour";
      this.componentApi(this.lab_comp, type);
    },
    selectEquipment() {
      var type = "equp";
      this.componentApi(this.equipment_comp, type);
    },

    selectMaterial() {
      var type = "mat";
      this.componentApi(this.material_comp, type);
    },

    componentApi(value, type) {
      axios
        .get(
          "/cost-estimate/detail-form-component/" + value + "/" + this.country
        )
        .then((response) => {
          console.log(response.data);
          this.component_result = response.data;

          if (type == "preme") {
            this.preliminries_unit = response.data.unit;
            this.preliminries_price = response.data.rate;
          }
          if (type == "labour") {
            this.labour_unit = response.data.unit;
            this.labour_price = response.data.rate;
            this.labour_price_store = response.data.rate;
          }
          if (type == "equp") {
            this.equipment_unit = response.data.unit;
            this.equipment_price = response.data.rate;
          }
          if (type == "mat") {
            this.material_unit = response.data.unit;
            this.material_price = response.data.rate;
          }

          // this.preliminries_quantity = response.data.data.quantity
          // this.preliminries_unit = response.data.data.unit
          // this.preliminries_price = response.data.data.rate
        });
    },
    addPreliminries() {
      var type = "preme";
      this.componentApiCall(this.prelim_comp, type);

      this.preliminries_unit = null;
      this.preliminries_rate = null;
      this.preliminries_amount = null;
      this.preliminries_quantity = null;
      this.preliminries_price = null;
    },
    addLabour() {
      var type = "labour";
      this.componentApiCall(this.lab_comp, type);

      this.labour_unit = null;
      this.labour_rate = null;
      this.labour_amount = null;
      this.labour_quantity = null;
      this.labour_price = null;
    },
    addEquipment() {
      var type = "equp";
      this.componentApiCall(this.equipment_comp, type);

      this.equipment_unit = null;
      this.equipment_rate = null;
      this.equipment_amount = null;
      this.equipment_quantity = null;
      this.equipment_price = null;
    },
    addMaterial() {
      var type = "mat";
      this.componentApiCall(this.material_comp, type);

      this.material_unit = null;
      this.material_rate = null;
      this.material_amount = null;
      this.material_quantity = null;
      this.material_price = null;
    },
    componentApiCall(value, type) {
      var totalpQuantity = 0;
      var price = 0;
      if (type == "labour") {
        totalpQuantity = this.labour_quantity;
        price = this.labour_price;
      }
      if (type == "preme") {
        totalpQuantity = this.preliminries_quantity;
        price = this.preliminries_price;
      }
      if (type == "equp") {
        totalpQuantity = this.equipment_quantity;
        price = this.equipment_price;
      }
      if (type == "mat") {
        totalpQuantity = this.material_quantity;
        price = this.material_price;
      }

      this.compQuantity = totalpQuantity;
      axios
        .get(
          "/cost-estimate/detail-form-component/" + value + "/" + this.country
        )
        .then((response) => {
          var lists = {
            key: this.components.length + 1,
            resource_type: response.data.resource_type,
            quantity: parseFloat(this.compQuantity).toFixed(2),
            unit: response.data.unit,
            rate: price,
            amount: this.compQuantity * price,
            category: response.data.category,
          };
          this.activity_final_sum += this.compQuantity * price;
          this.components.push(lists);
          if (response.data.category == "Labour") {
            var lbamout = parseFloat(this.compQuantity) * parseFloat(price);
            this.labour_cost_collect = this.labour_cost_collect + lbamout;
            this.labour_cost = new Intl.NumberFormat("en-US", {
              style: "currency",
              currency: "USD",
              minimumFractionDigits: 2,
              maximumFractionDigits: 2,
            }).format(this.labour_cost_collect);
          }

          if (response.data.category == "Equipment") {
            var eqamout = parseFloat(this.compQuantity) * parseFloat(price);

            this.equipment_cost_collect = this.equipment_cost_collect + eqamout;

            this.equipment_cost = new Intl.NumberFormat("en-US", {
              style: "currency",
              currency: "USD",
              minimumFractionDigits: 2,
              maximumFractionDigits: 2,
            }).format(this.equipment_cost_collect);
          }
          if (response.data.category == "Material") {
            var mlamout = parseFloat(this.compQuantity) * parseFloat(price);

            this.material_cost_collect =
              parseFloat(this.material_cost_collect) + parseFloat(mlamout);
            this.material_cost = new Intl.NumberFormat("en-US", {
              style: "currency",
              currency: "USD",
              minimumFractionDigits: 2,
              maximumFractionDigits: 2,
            }).format(this.material_cost_collect);
          }

          if (response.data.category == "Preliminries") {
            // (this.preliminary_cost_collect = this.compQuantity * price),
            this.preliminary_cost_collect  = this.components.reduce(function(sum, current) {
                  return sum += current.category == "Preliminries" ? Number(parseFloat(current.amount).toFixed(2)) : 0;
              }, 0);
              //  this.sub_total =  parseFloat(parseFloat(this.sub_total) + parseFloat(this.quantity*this.compQuantity*response.data.rate)).toFixed(2)
              (this.preliminary_cost = new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "USD",
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
              }).format(this.preliminary_cost_collect)),
              // this.preliminary_cost = Number(parseFloat(this.compQuantity*response.data.rate).toFixed(2)).toLocaleString()
              
              this.totalcostAmount();
          }
          this.sub_total_collect =
            parseFloat(this.additional_cost_collect) +
            parseFloat(this.equipment_cost_collect) +
            parseFloat(this.labour_cost_collect) +
            parseFloat(this.material_cost_collect);
          this.sub_total = new Intl.NumberFormat("en-US", {
            style: "currency",
            currency: "USD",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
          }).format(this.sub_total_collect);

          this.totalcostAmount();

          // this.overheadProfit()
          // this.consistgencyCost()
        });
    },
    additionalCost() {
      this.additional_cost_collect = this.additional_cost;
      this.sub_total_collect =
        parseFloat(this.additional_cost_collect) +
        parseFloat(this.equipment_cost_collect) +
        parseFloat(this.labour_cost_collect) +
        parseFloat(this.material_cost_collect);
      this.sub_total = new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      }).format(this.sub_total_collect);
      this.totalcostAmount();
    },
    additionalLeave() {
      this.additional_cost = this.additional_cost_collect;
      this.additional_cost = new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      }).format(this.additional_cost_collect);
    },

    preliminaryCost() {
      this.preliminary_cost_collect = parseFloat(
        (this.sub_total_collect * this.preliminary_percentage) / 100
      );
      (this.preliminary_cost = new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      }).format(this.preliminary_cost_collect)),
        this.totalcostAmount();
    },

    overheadCost() {
      this.overhead_cost_collect = this.overhead_cost;
      this.totalcostAmount();
    },
    overheadLeave() {
      this.overhead_cost = new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      }).format(this.overhead_cost_collect);
    },
    overheadProfit() {
      this.overhead_cost_collect = parseFloat(
        (this.sub_total_collect * this.overhead_percentage) / 100
      );
      this.overhead_cost = new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      }).format(this.overhead_cost_collect);
      this.totalcostAmount();
    },
    preliminaryCostAmount() {
      this.preliminary_cost_collect = this.preliminary_cost;
      // this.preliminary_cost = new Intl.NumberFormat("en-US",{ style: "currency", currency: "USD",minimumFractionDigits: 2,maximumFractionDigits: 2, }).format(this.preliminary_cost_collect );
      this.totalcostAmount();
    },
    preliminaryLeave() {
      this.preliminary_cost = new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      }).format(this.preliminary_cost_collect);
    },
    consistgencyCostAmount() {
      this.consistgency_cost_collect = this.consistgency_cost;
      this.totalcostAmount();
    },
    consistgencyLeave() {
      this.consistgency_cost = new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      }).format(this.consistgency_cost_collect);
    },
    consistgencyCost() {
      this.consistgency_cost_collect = parseFloat(
        (this.sub_total_collect * this.consistgency_percentage) / 100
      );

      this.consistgency_cost = Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      }).format(this.consistgency_cost_collect);
      this.totalcostAmount();
    },
    totalcostAmount() {
      this.total_cost_collect = parseFloat(
        parseFloat(this.sub_total_collect) +
          parseFloat(this.preliminary_cost_collect) +
          parseFloat(this.overhead_cost_collect) +
          parseFloat(this.consistgency_cost_collect)
      ).toFixed(2);

      this.total_cost = Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      }).format(this.total_cost_collect);
      this.imperial_rate_collect = this.total_cost_collect / this.quantity;

      this.imperial_rate = Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      }).format(this.imperial_rate_collect);

      this.metric_rate_collect =
        this.imperial_rate_collect * this.conservation_factor;
      this.metric_rate = Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      }).format(this.metric_rate_collect);
    },
    preliminriesCost() {
      this.preliminries_amount = parseFloat(
        parseFloat(this.preliminries_quantity) *
          parseFloat(this.preliminries_price)
      ).toFixed(2);
    },
    labourCost() {
      this.labour_amount = parseFloat(
        parseFloat(this.labour_quantity) * parseFloat(this.labour_price)
      ).toFixed(2);
    },
    equipmentCost() {
      this.equipment_amount = parseFloat(
        parseFloat(this.equipment_quantity) * parseFloat(this.equipment_price)
      ).toFixed(2);
    },
    materialCost() {
      this.material_amount = parseFloat(
        parseFloat(this.material_quantity) * parseFloat(this.material_price)
      ).toFixed(2);
    },
    deleteFromSum(index) {
      this.totalCalculation.splice(index, 1);
      this.activity_all.splice(index, 1);
      this.jobActivitiesList.splice(index, 1);
      this.total_amout_sum = this.totalCalculation.reduce(function (
        sum,
        current
      ) {
        return (sum += Number(parseFloat(current.amount).toFixed(2)));
      },
      0);
      this.total_labour_sum = this.totalCalculation.reduce(function (
        sum,
        current
      ) {
        return (sum += Number(parseFloat(current.lab).toFixed(2)));
      },
      0);

      this.total_equipment_sum = this.totalCalculation.reduce(function (
        sum,
        current
      ) {
        return (sum += Number(parseFloat(current.eqp).toFixed(2)));
      },
      0);

      this.total_material_sum = this.totalCalculation.reduce(function (
        sum,
        current
      ) {
        return (sum += Number(parseFloat(current.mat).toFixed(2)));
      },
      0);

      this.total_addition_sum = this.totalCalculation.reduce(function (
        sum,
        current
      ) {
        return (sum += Number(parseFloat(current.addcost).toFixed(2)));
      },
      0);

      this.total_preliminary_sum = this.totalCalculation.reduce(function (
        sum,
        current
      ) {
        return (sum += Number(parseFloat(current.preliminary_cost).toFixed(2)));
      },
      0);

      this.total_ohp_sum = this.totalCalculation.reduce(function (
        sum,
        current
      ) {
        return (sum += Number(parseFloat(current.ohp).toFixed(2)));
      },
      0);

      this.total_preliminary_sum_collect = parseFloat(
        this.total_preliminary_sum
      );
      this.total_consistgency_sum = this.totalCalculation.reduce(function (
        sum,
        current
      ) {
        return (sum += Number(
          parseFloat(current.consistgency_cost).toFixed(2)
        ));
      },
      0);

      this.total_consistgency_sum_collect = parseFloat(
        this.total_consistgency_sum
      );

      this.total_amout_collect = parseFloat(
        parseFloat(this.total_labour_sum) +
          parseFloat(this.total_equipment_sum) +
          parseFloat(this.total_material_sum) +
          parseFloat(this.total_preliminary_sum) +
          parseFloat(this.total_addition_sum) +
          parseFloat(this.total_ohp_sum) +
          parseFloat(this.total_consistgency_sum)
      ).toFixed(2);
    },

    printForm() {
      this.country_name = $("#country_id").find(":selected").text().trim();
      this.estimate_type_sum = this.estimate_type;
      this.project_title_sum = this.project_title;
      // this.project_specification = this.project_note;
      this.total_preliminary_sum = this.preliminary_cost;
      this.total_consistgency_sum = this.consistgency_cost;
      var total_ohp_sum = 0;
      this.totalCalculation.forEach((value, key) => {
        total_ohp_sum += value.ohp;
      });
      this.total_ohp_sum = total_ohp_sum;   
    },

    print() {
      $("#print_1 thead tr th").css("font-size", "10px");
      $("#print_1 thead tr th").css("text-align", "left");
      $("#print_1 thead tr th").css("padding-left", "0px !important");
      $("#print_1 tbody tr td").css("font-size", "10px");
      $("#print_1 tbody tr td").css("padding-left", "0px !important");
      $("#print_1 tbody tr td").css("vertical-align", "top");
      $("#modal-fullscreen-xl").css("font-family", "Tahoma");
      $("#project_title_sum").attr("value", this.project_title_sum);
      $("#estimate_type_sum").attr("value", this.estimate_type_sum);
      $("#country_name").attr("value", this.country_name);
      $("#contractor").attr("value", this.contractor);
      $("#owner").attr("value", this.owner);
      $("#project_description").text(this.project_description);
      $("#project_specification").text(this.project_specification);
      $("title").text("DETAIL COST ESTIMATION FORM");
      this.$htmlToPaper("print-this");
    },
    printCloseFirst() {
      $("#print_1 thead tr th").css("font-size", "1rem");
      $("#print_1 tbody tr td").css("font-size", "1rem");
      $("#print_2 thead tr th:nth-child(3)").css("width", "");
    },
    print2() {
      $("#print_2 thead tr th").css("font-size", "10px");
      $("#print_2 thead tr th").css("text-align", "left");
      $("#print_2 thead tr th:nth-child(3)").css("width", "40%");
      $("#print_2 thead tr th").css("padding-left", "0px !important");
      $("#print_2 tbody tr td").css("font-size", "10px");
      $("#print_2 tbody tr td").css("vertical-align", "top");
      $("#print_2 tbody tr td").css("padding-left", "0px !important");
      $("#print2").css("font-family", "Tahoma");
      $("#project_title_sum_two").attr("value", this.project_title_sum);
      $("#estimate_type_sum_two").attr("value", this.estimate_type_sum);
      $("#country_name_two").attr("value", this.country_name);
      $("#contractor_two").attr("value", this.contractor);
      $("#owner_two").attr("value", this.owner);
      $("#project_description_two").text(this.project_description);
      $("#project_specification_two").text(this.project_specification);
      $("title").text("DETAIL COST ESTIMATION FORM");
      this.$htmlToPaper("print-this-two");
    },
    print3() {
      $("#print_3 thead tr th").css("font-size", "10px");
      $("#print_3 thead tr th").css("text-align", "left");
      $("#print_3 thead tr th").css("padding-left", "0px !important");
      $("#print_3 tbody tr td").css("font-size", "10px");
      $("#print_3 tbody tr td").css("vertical-align", "top");
      $("#print_3 tbody tr td").css("padding-left", "0px !important");
      $("#print_3").css("font-family", "Tahoma");
      $("#p3_project_title_sum_two").attr("value", this.project_title_sum);
      $("#p3_estimate_type_sum_two").attr("value", this.estimate_type_sum);
      $("#p3_country_name_two").attr("value", this.country_name);
      $("#p3_contractor_two").attr("value", this.contractor);
      $("#p3_owner_two").attr("value", this.owner);
      $("#p3_project_description_two").text(this.project_description);
      $("#p3_project_specification_two").text(this.project_specification);
      $("title").text("DETAIL COST ESTIMATION FORM");
      this.$htmlToPaper("print-this-three");
    },
    printCloseSecond() {
      $("#print_2 thead tr th").css("font-size", "1rem");
      $("#print_2 tbody tr td").css("font-size", "1rem");
    },
    clearForm() {
      this.loadResourceComponent = false;
      this.job_activity_section = true;
      this.project_title = "";
      this.estimate_type = "";
      this.country = "";
      this.activity_code = "";
      this.category = "";
      this.imperial_rate = 0;
      this.imperial_unit = 0;
      this.metric_rate = 0;
      this.metric_unit = 0;
      this.activity_description = "";
      this.quantity = 0;
      this.project_description = "";
      this.labour_cost = 0;
      this.equipment_cost = 0;
      this.material_cost = 0;
      this.additional_cost = 0;
      this.sub_total = 0;
      this.preliminary_percentage = 0;
      this.preliminary_cost = 0;
      this.overhead_percentage = 0;
      this.overhead_cost = 0;
      this.consistgency_percentage = 0;
      this.consistgency_cost = 0;
      this.total_cost = 0;
      this.components = [];
      this.project_note = "";
      this.component_note = "";
      this.preliminries = "";
      this.labour = "";
      this.equipment = "";
      this.material = "";
      this.total_amout_collect = 0;
      this.actives = [];
      this.totalCalculation = [];
      $(".total_amount_sum").html("$0.00");
      
    },
    edit(index) {
      $("#edit-btn-" + index).css("display", "none");
      $("#delete-btn-" + index).css("display", "none");
      $("#up-btn-" + index).css("display", "none");
      $("#down-btn-" + index).css("display", "none");
      $("#activity_code_" + index).css("display", "flex");
      $("#element_description_" + index).css("display", "flex");
      $("#job_activity_" + index).css("display", "flex");
      $("#activity_code_label" + index).css("display", "none");
      $("#element_description_label" + index).css("display", "none");
      $("#job_activity_label" + index).css("display", "none");
      $("#done-btn-" + index).css("display", "block");
    },
    doneUpdate(index) {
      var activity_code = $("#activity_code_" + index).val();
      var element_description = $("#element_description_" + index).val();
      var job_activity = $("#job_activity_" + index).val();

      this.totalCalculation.forEach((value, key) => {
        if (key == index) {
          if (activity_code != "") {
            this.totalCalculation[key]["activity_code"] = activity_code;
          }
          if (element_description != "") {
            this.totalCalculation[key]["element_description"] =
              element_description;
          }
          if (job_activity != "") {
            this.totalCalculation[key]["job_activity"] = job_activity;
          }
        }
      });

      $("#edit-btn-" + index).css("display", "");
      $("#delete-btn-" + index).css("display", "");
      $("#up-btn-" + index).css("display", "");
      $("#down-btn-" + index).css("display", "");
      $("#activity_code_" + index).css("display", "none");
      $("#element_description_" + index).css("display", "none");
      $("#job_activity_" + index).css("display", "none");
      $("#activity_code_label" + index).css("display", "");
      $("#element_description_label" + index).css("display", "");
      $("#job_activity_label" + index).css("display", "");
      $("#done-btn-" + index).css("display", "none");
    },
    up(id,ind) {
      var selected = 0;
      var itemlist = $(".row_position");
      var len = $(itemlist).children().length;
      var selected = $("#" + ind+"-row").index();

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
    // up(id,ind) {
    //   var selected = 0;
    //   var itemlist = $(".row_position");
    //   var len = $(itemlist).children().length;
    //   var selected = $("#" + ind+"-row").index();

    //   if (selected > 0) {
    //     jQuery(
    //       $(itemlist)
    //         .children()
    //         .eq(selected - 1)
    //     ).before(jQuery($(itemlist).children().eq(selected)));
    //     selected = selected - 1;
    //   }

    //   var selectedData = new Array();
    //   var sortableArray = new Array();
    //   $(".row_position>tr").each(function () {
    //     selectedData.push($(this).attr("data"));
    //   });

    //   selectedData.forEach((value, index) => {
    //     if (value !== undefined) {
    //       this.totalCalculation.forEach((value1, index1) => {
    //         if (value1.activity_code == value) {
    //           sortableArray.push(value1);
    //         }
    //       });
    //     }
    //   });
    //   this.totalCalculation = sortableArray;
    // },
    down(id,ind) {
      var selected = 0;
      var itemlist = $(".row_position");
      var len = $(itemlist).children().length;
      var selected = $("#" + ind+"-row").index();

      if (selected < len) {
        jQuery(
          $(itemlist)
            .children()
            .eq(selected + 1)
        ).after(jQuery($(itemlist).children().eq(selected)));
        selected = selected + 1;
      }

      // var selectedData = new Array();
      // var sortableArray = new Array();
      // $(".row_position>tr").each(function () {
      //   selectedData.push($(this).attr("data"));
      // });

      // selectedData.forEach((value, index) => {
      //   if (value != undefined) {
      //     this.totalCalculation.forEach((value1, index1) => {
      //       if (value1.activity_code == value) {
      //         sortableArray.push(value1);
      //       }
      //     });
      //   }
      // });
      // this.totalCalculation = sortableArray;

      
    },
    onClickResComponent(type) {           
        this.rescomponents = [];   
        var alldatares = this.totalCalculation;        
        var allresdata = [];                
        var totaldata = alldatares;
        var i = 0;
        
        this.totalCalculation.forEach((value, index) => {
            var res_amount = 0;
            allresdata[index] = value; 
            // res_amount = parseFloat(value.addcost) + parseFloat(value.cont) + parseFloat(value.ohp) + parseFloat(value.rate);                                
            res_amount = parseFloat(value.addcost) + parseFloat(value.cont) + parseFloat(value.ohp);                                
            var resdata = [];
            var amount = 0;
            value.activity_detail.forEach((value1, index1) => {                                     
                if(value1.category == type)
                {
                    resdata.push(value1);     
                    // resdata[index1] = value1;        
                    amount += value1.amount;
                }
            });
            res_amount += parseFloat(amount);
            var a_amount = 0;
            if(type == 'Labour')
            { 
              a_amount = value.lab + ((value.lab * this.overhead_percentage)/100) + ((value.lab * this.consistgency_percentage)/100) + ((value.lab * this.preliminary_percentage)/100)
            }
            if(type == 'Equipment')
            { 
              a_amount = value.eqp + ((value.eqp * this.overhead_percentage)/100) + ((value.eqp * this.consistgency_percentage)/100) + ((value.eqp * this.preliminary_percentage)/100)
            }
            if(type == 'Material')
            { 
              a_amount = value.mat + ((value.mat * this.overhead_percentage)/100) + ((value.mat * this.consistgency_percentage)/100) + ((value.mat * this.preliminary_percentage)/100)
            }

            allresdata[index]['per_unit'] = a_amount/value.quantity;
            allresdata[index]['activity_details'] = resdata;  
            allresdata[index]['res_sum'] = amount;
            allresdata[index]['res_amount'] = res_amount;
        });

        this.rescomponents = allresdata;
        this.lab_category = false;
        this.eqp_category = false;
        this.mat_category = false;

        this.lab_category_sum = 0;
        this.eqp_category_sum = 0;
        this.mat_category_sum = 0;


      this.rescomp_sub_total = this.rescomponents.reduce(function (
        sum,
        current
      ) {
        return (sum += Number(parseFloat(current.res_amount).toFixed(2)));
      },
      0);

        if(type == 'Labour')
        {
          this.lab_category = true;
          this.lab_category_sum = this.rescomponents.reduce(function (sum, current){
            return (sum += Number(parseFloat(current.lab).toFixed(2)));
          }, 0);
          this.total_preliminary_sum_collect = (this.lab_category_sum * this.preliminary_percentage)/100;
          this.total_ohp_sum = (this.lab_category_sum * this.overhead_percentage)/100;
          this.total_consistgency_sum_collect = (this.lab_category_sum * this.consistgency_percentage)/100;

          this.rescomp_total = this.lab_category_sum + this.total_preliminary_sum_collect + this.total_ohp_sum + this.total_consistgency_sum_collect;
        }
        else if(type == 'Equipment'){
          this.eqp_category = true;
          this.eqp_category_sum = this.rescomponents.reduce(function (sum, current){
            return (sum += Number(parseFloat(current.eqp).toFixed(2)));
          }, 0);
          this.total_preliminary_sum_collect = (this.eqp_category_sum * this.preliminary_percentage)/100;
          this.total_ohp_sum = (this.eqp_category_sum * this.overhead_percentage)/100;
          this.total_consistgency_sum_collect = (this.eqp_category_sum * this.consistgency_percentage)/100;

          this.rescomp_total = this.eqp_category_sum + this.total_preliminary_sum_collect + this.total_ohp_sum + this.total_consistgency_sum_collect;

        }
        else if(type == 'Material')
        {
          this.mat_category = true;
          this.mat_category_sum = this.rescomponents.reduce(function (sum, current){
            return (sum += Number(parseFloat(current.mat).toFixed(2)));
          },0);
          this.total_preliminary_sum_collect = (this.mat_category_sum * this.preliminary_percentage)/100;
          this.total_ohp_sum = (this.mat_category_sum * this.overhead_percentage)/100;
          this.total_consistgency_sum_collect = (this.mat_category_sum * this.consistgency_percentage)/100;

          this.rescomp_total = this.mat_category_sum + this.total_preliminary_sum_collect + this.total_ohp_sum + this.total_consistgency_sum_collect;

        }
        this.rescomp_sub_total = this.rescomp_total;
      // this.rescomp_total = parseFloat(
      //   parseFloat(this.lab_category_sum) +
      //     parseFloat(this.eqp_category_sum) +
      //     parseFloat(this.mat_category_sum) +
      //     parseFloat(this.total_preliminary_sum) +
      //     parseFloat(this.total_addition_sum) +
      //     parseFloat(this.total_ohp_sum) +
      //     parseFloat(this.total_consistgency_sum)
      // ).toFixed(2);

    },
    sortableArray() {      
      var selectedData = new Array();
      var sortableArray = new Array();
      $(".row_position > tr").each(function () {
        selectedData.push($(this).attr("id"));
      });

      selectedData.forEach((value, index) => {
        if (value != undefined) {
          this.totalCalculation.forEach((value1, index1) => {
            if (value1.activity_code == value) {
              sortableArray.push(value1);
            }
          });
        }
      });
      this.totalCalculation = sortableArray;
    },
    showSaveModal() {
      this.$modal.show("save-form");
    },
    hideSaveModal() {
      this.$modal.hide("save-form");
    },
    overTime() {
      this.labour_price = this.labour_price_store * 1.5;
    },
    doubleTime() {
      this.labour_price = this.labour_price_store * 2;
    },
    saveForm() {
      var _this = this;

      var selectedData = new Array();
      var sortableArray = new Array();
      $(".row_position>tr").each(function () {
        selectedData.push($(this).attr("data"));
      });

      selectedData.forEach((value, index) => {
        if (value !== undefined) {
          this.totalCalculation.forEach((value1, index1) => {
            if (value1.activity_code == value) {
              sortableArray.push(value1);
            }
          });
        }
      });
      // _this.totalCalculation = sortableArray;
      axios
        .post("/cost-estimate/detail-form/saveForm", {
          id: id,
          form_name: _this.form_name,
          project_title: _this.project_title,
          estimate_type: _this.estimate_type,
          country: _this.country,
          activity_code: _this.activity_code,
          category: _this.category,
          activity_description: _this.activity_description,
          imperial_rate: _this.imperial_rate,
          quantity: _this.quantity,
          imperial_unit: _this.imperial_unit,
          metric_unit: _this.metric_unit,
          project_description: _this.project_description,
          labour_cost: _this.labour_cost,
          equipment_cost: _this.equipment_cost,
          material_cost: _this.material_cost,
          additional_cost: _this.additional_cost,
          sub_total: _this.sub_total,
          preliminary_percentage: _this.preliminary_percentage,
          preliminary_cost: _this.preliminary_cost,
          overhead_percentage: _this.overhead_percentage,
          overhead_cost: _this.overhead_cost,
          consistgency_percentage: _this.consistgency_percentage,
          consistgency_cost: _this.consistgency_cost,
          total_cost: _this.total_cost,
          project_note: _this.project_note,
          component_note: _this.component_note,
          components: _this.components,
          totalCalculation: sortableArray,
          metric_rate: _this.metric_rate,
        })
        .then(function (response) {
          _this.$toast.success("Form Save Successfully");
          location.reload();
          _this.hideSaveModal();
        })
        .catch((error) => {
          // if (error.response.status == 422) {
          //   _this.errors = error.response.data.errors;
          //   _this.success = "";
          // }
        });
    },    
    formDetails() {
      this.loading = true;
      var _this = this;
      axios
        .get("/cost-estimate/detail-form/getFormDetail?id=" + id)
        .then(function (response) {
          const formDetail = JSON.parse(
            response.data.data.detailForms.form_details
          );
          _this.form_name = response.data.data.detailForms.form_name;
          _this.project_title = formDetail.project_title;
          _this.estimate_type = formDetail.estimate_type;
          _this.country = formDetail.country;
          _this.activity_code = formDetail.activity_code;
          _this.category = formDetail.category;
          _this.activity_description = formDetail.activity_description;
          _this.imperial_rate = formDetail.imperial_rate;
          _this.quantity = formDetail.quantity;
          _this.imperial_unit = formDetail.imperial_unit;
          _this.metric_unit = formDetail.metric_unit;
          _this.project_description = formDetail.project_description;
          _this.labour_cost = formDetail.labour_cost;
          _this.equipment_cost = formDetail.equipment_cost;
          _this.material_cost = formDetail.material_cost;
          _this.additional_cost = formDetail.additional_cost;
          _this.sub_total = formDetail.sub_total;
          _this.preliminary_percentage = formDetail.preliminary_percentage;
          _this.preliminary_cost = formDetail.preliminary_cost;
          _this.overhead_percentage = formDetail.overhead_percentage;
          _this.overhead_cost = formDetail.overhead_cost;
          _this.consistgency_percentage = formDetail.consistgency_percentage;
          _this.consistgency_cost = formDetail.consistgency_cost;
          _this.total_cost = formDetail.total_cost;
          _this.project_note = formDetail.project_note;
          _this.component_note = formDetail.component_note;
          _this.components = formDetail.components;
          _this.totalCalculation = formDetail.totalCalculation;
          _this.jobActivitiesList = formDetail.totalCalculation;
          _this.metric_rate = formDetail.metric_rate;
          _this.owner = formDetail.owner;
          _this.contractor = formDetail.contractor;
          _this.project_specification = formDetail.project_specification;
          if(_this.country == null || _this.country == ''){
            alert("Please selecte the country");
          }
          _this.total_amout_sum = _this.totalCalculation.reduce(function (
            sum,
            current
          ) {
            return (sum += Number(parseFloat(current.amount).toFixed(2)));
          },
          0);

          _this.total_labour_sum = _this.totalCalculation.reduce(function (
            sum,
            current
          ) {
            return (sum += Number(parseFloat(current.lab).toFixed(2)));
          },
          0);

          _this.total_equipment_sum = _this.totalCalculation.reduce(function (
            sum,
            current
          ) {
            return (sum += Number(parseFloat(current.eqp).toFixed(2)));
          },
          0);

          _this.total_material_sum = _this.totalCalculation.reduce(function (
            sum,
            current
          ) {
            return (sum += Number(parseFloat(current.mat).toFixed(2)));
          },
          0);

          _this.total_addition_sum = _this.totalCalculation.reduce(function (
            sum,
            current
          ) {
            return (sum += Number(parseFloat(current.addcost).toFixed(2)));
          },
          0);

          _this.total_preliminary_sum = _this.totalCalculation.reduce(function (
            sum,
            current
          ) {
            return (sum += Number(
              parseFloat(current.preliminary_cost).toFixed(2)
            ));
          },
          0);
          _this.total_preliminary_sum_collect = parseFloat(
            _this.total_preliminary_sum
          );

          _this.total_ohp_sum = _this.totalCalculation.reduce(function (
            sum,
            current
          ) {
            return (sum += Number(parseFloat(current.ohp).toFixed(2)));
          },
          0);

          _this.total_consistgency_sum = _this.totalCalculation.reduce(
            function (sum, current) {
              return (sum += Number(
                parseFloat(current.consistgency_cost).toFixed(2)
              ));
            },
            0
          );
          _this.total_consistgency_sum_collect = parseFloat(
            _this.total_consistgency_sum
          );
          _this.total_amout_collect = parseFloat(
            parseFloat(_this.total_labour_sum) +
              parseFloat(_this.total_equipment_sum) +
              parseFloat(_this.total_material_sum) +
              parseFloat(_this.total_preliminary_sum) +
              parseFloat(_this.total_addition_sum) +
              parseFloat(_this.total_ohp_sum) +
              parseFloat(_this.total_consistgency_sum)
          ).toFixed(2);
          _this.getResults();
          _this.loadComponent();
          _this.loading = false;

          
        });
    },
    abc: function () {
      // alert('asdsad')
      // var newtotalCalculation = JSON.parse(sessionStorage.getItem("newtotalCalculation"));
      // this.totalCalculation = newtotalCalculation
      // alert(JSON.stringify(this.totalCalculation));
    },
    getCookie(name) {
      let cookie = {};
      document.cookie.split(';').forEach(function(el) {
        let [k,v] = el.split('=');
        cookie[k.trim()] = v;
      })
      return cookie[name];
    },
    setCookie(cname, cvalue) {
      // const d = new Date();
      // d.setTime(d.getTime() + (exdays*24*60*60*1000));
      // let expires = "expires="+ d.toUTCString();
      // document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";

      let d = new Date();
      d.setTime(d.getTime() + 1 * 24 * 60 * 60 * 1000);
      let expires = "expires=" + d.toUTCString();
      document.cookie = cname+"="+cvalue+";" + expires + ";path=/";
    },
    trackJobActivity: function(){
      var lastUpdated = this.getCookie("lastActivityUpdated");
      if(lastUpdated !== undefined){
        var data = lastUpdated.split(":");
        var code = data[0];
        var selected = $(".detail-form-list > tr[data="+code+"]").index();
        if(data[1] == 'up'){
          var itemlist = $(".detail-form-list");
          if (selected > 0) {
            jQuery(
              $(itemlist)
                .children()
                .eq(selected - 1)
            ).before(jQuery($(itemlist).children().eq(selected)));
             setTimeout(function(){
              document.cookie = 'lastActivityUpdated=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            },1000);
          }
        }else if(data[1] == 'down'){
          var itemlist = $(".detail-form-list");
          var len = $(itemlist).children().length;
          if (selected < len) {
            jQuery(
              $(itemlist)
                .children()
                .eq(selected + 1)
            ).after(jQuery($(itemlist).children().eq(selected)));
            setTimeout(function(){
              document.cookie = 'lastActivityUpdated=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            },1000);
            
          }
        }else if(data[1] == 'remove'){
           $(".detail-form-list > tr[data="+code+"]").find(".removebtn").trigger("click");
           setTimeout(function(){
              document.cookie = 'lastActivityUpdated=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            },1000);
         }else if(data[1] == 'edit'){
           var rowUpdated = this.getCookie("rowUpdated");
           if(rowUpdated !== undefined){
            rowUpdated = JSON.parse(rowUpdated);
            if(rowUpdated.edit_activity_code == data[0]){
                $(".detail-form-list > tr[data="+code+"]").find(".activity_code").val(rowUpdated.activity_code);
                $(".detail-form-list > tr[data="+code+"]").find(".element_description").val(rowUpdated.element_description);
                $(".detail-form-list > tr[data="+code+"]").find(".job_activity").val(rowUpdated.job_activity);
                $(".detail-form-list > tr[data="+code+"]").find(".editbtn").trigger("click");
                $(".detail-form-list > tr[data="+code+"]").find(".donebtn").trigger("click");
                
                setTimeout(function(){
                  document.cookie = 'lastActivityUpdated=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                  document.cookie = 'rowUpdated=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                },1000);
            }
           }
           
         }
      }
    },
    viewEsitmate(){
      this.job_activity_section = true;
      var _this = this;
      setTimeout(function(){
        _this.activityWindow();
      },500);
      
    },
    storeActivity(){
      var selectedData = [];
      $(".detail-form-list > tr").each(function () {
        selectedData.push({activity_code:$(this).attr("data"),index:$(this).attr("data-index")});
      });
      var result_arr = [];
      selectedData.forEach((value, index) => {
        this.totalCalculation.forEach((value1, index1) => {
          if (value1.activity_code == value.activity_code && value.index == index1) {
            result_arr.push(value1);
          }
        });
      });
      sessionStorage.setItem(
        "totalCalculation",
        JSON.stringify(result_arr)
      );
      sessionStorage.setItem(
        "timestamp",this.timestamp
      );
      this.trackActivity = 1;
      this.country_name = $("#country_id").find(":selected").text().trim();
      var formdata = {
        form_name:this.form_name,
        form_id:$("#detail_id").val(),
        project_title:this.project_title,
        estimate_type:this.estimate_type,
        country:this.country,
        country_job:this.country_name,
        contractor:this.contractor,
        owner:this.owner,
        project_description:this.project_description,
        project_specification:this.project_specification,
        activity_code: this.activity_code,
        category: this.category,
        activity_description: this.activity_description,
        imperial_rate: this.imperial_rate,
        quantity: this.quantity,
        imperial_unit: this.imperial_unit,
        metric_unit: this.metric_unit,
        labour_cost: this.labour_cost,
        equipment_cost: this.equipment_cost,
        material_cost: this.material_cost,
        additional_cost: this.additional_cost,
        sub_total: this.sub_total,
        preliminary_percentage: this.preliminary_percentage,
        preliminary_cost: this.preliminary_cost,
        overhead_percentage: this.overhead_percentage,
        overhead_cost: this.overhead_cost,
        consistgency_percentage: this.consistgency_percentage,
        consistgency_cost: this.consistgency_cost,
        total_cost: this.total_cost,
        project_note: this.project_note,
        component_note: this.component_note,
        components: this.components,
        metric_rate: this.metric_rate,
        contractor: this.contractor,
        owner: this.owner,
        project_specification: this.project_specification,
      };
      axios.post("/cost-estimate/store-activities", {
        results: result_arr,
        formdata:formdata,
        updated_from:'parent_window',
        grid_show:1
      })
      .then(function (response) {
        _this.$toast.success("Form Save Successfully");
        location.reload();
        _this.hideSaveModal();
      })
      .catch((error) => {
        // if (error.response.status == 422) {
        //   _this.errors = error.response.data.errors;
        //   _this.success = "";
        // }
      });
    },
    activityWindow() {      
      $(".detail-form-list").sortable({
        delay: 150
      });
      sessionStorage.setItem("startTrack",1);
      this.storeActivity();

      // chrome.tabs.getCurrent(function(tab){ 
      //   console.log("tab data: ",JSON.stringify(tab,null, 2)); 
      // })
      this.activity = window.open(
        "/cost-estimate/detail-form/activity",
        "Activity",
        "width=1500 height=1000"
      );
      
      // this.activity = window.open('http://127.0.0.1:8000/cost-estimate/detail-form/activity', 'Activity', 'width=1500 height=1000');
      // this.activity = window.open('', 'Activity', 'width=1500 height=1000');
      // this.windowRef.addEventListener('beforeunload', this.closePortal);
      // activity.edit();
      // var html = '';
      //     html += '<head>';
      //     html +=     '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"><\/script>';
      //     html += '</head>';
      //     html += '<table class="table table-striped table-bordered" border="2" style="background: aliceblue;">';
      //     html +=     '<thead>';
      //     html +=         '<tr>';
      //     html +=             '<th>ACTIVITY CODE</th>';
      //     html +=             '<th>ELEMENT DESCRIPTION</th>';
      //     html +=             '<th>JOB ACTIVITY</th>';
      //     html +=             '<th>QUANTITY</th>';
      //     html +=             '<th>UNIT</th>';
      //     html +=             '<th>LAB</th>';
      //     html +=             '<th>EQUIP</th>';
      //     html +=             '<th>MAT</th>';
      //     html +=             '<th>ADD/DISC</th>';
      //     html +=             '<th>OH&P</th>';
      //     html +=             '<th>CONT</th>';
      //     html +=             '<th>RATE</th>';
      //     html +=             '<th>AMOUNT</th>';
      //     html +=             '<th>Action</th>';
      //     html +=         '</tr>';
      //     html +=     '</thead>';
      //                 if(this.loadResourceComponent)
      //                 {
      //     html +=     '<tbody class="row_position">';
      //                     this.totalCalculation.forEach((component, i) =>
      //                     {
      //     html +=             '<tr key="'+i+'" id="'+component.activity_code+'">';
      //     html +=                 '<td>';
      //     html +=                     '<span id="poup_activity_code_label'+i+'">'+component.activity_code+'</span>';
      //     html +=                     '<input class="form-control" type="text" id="poup_activity_code_'+i+'" value="'+component.activity_code+'" style="display:none">';
      //     html +=                 '</td>';
      //     html +=                 '<td>';
      //     html +=                     '<span id="poup_element_description_label'+i+'">'+component.element_description+'</span>';
      //     html +=                     '<input class="form-control" type="text" id="poup_element_description_'+i+'" style="display:none">';
      //     html +=                 '</td>';
      //     html +=                 '<td>';
      //     html +=                     '<span id="poup_job_activity_label'+i+'">'+component.job_activity+'</span>';
      //     html +=                     '<input class="form-control" type="text" id="poup_job_activity_'+i+'" style="display:none">';
      //     html +=                 '</td>';
      //     html +=                 '<td>'+component.quantity+'</td>';
      //     html +=                 '<td>'+component.unit+'</td>';
      //     html +=                 '<td>'+component.lab+'</td>';
      //     html +=                 '<td>'+component.eqp+'</td>';
      //     html +=                 '<td>'+component.mat+'</td>';
      //     html +=                 '<td>'+component.addcost+'</td>';
      //     html +=                 '<td>'+component.ohp+'</td>';
      //     html +=                 '<td>'+component.cont+'</td>';
      //     html +=                 '<td>'+component.rate+'</td>';
      //     html +=                 '<td>'+component.amount+'</td>';
      //     html +=                 '<td>';
      //     html +=                     '<button class="btn btn-success" id="poup-edit-btn-'+i+'" onclick="edit('+i+')">Edit</button>';
      //     html +=                     '<button class="btn btn-success" id="poup-delete-btn-'+i+'" onclick="deleteFromSum('+i+')">Remove</button>';
      //     html +=                     '<button class="btn btn-success" id="poup-up-btn-'+i+'" onclick="up('+component.activity_code+')">Up</button>';
      //     html +=                     '<button class="btn btn-success" id="poup-down-btn-'+i+'" onclick="down('+component.activity_code+')">Down</button>';
      //     html +=                     '<button class="btn btn-success" id="poup-done-btn-'+i+'" onclick="doneUpdate('+i+')" style="display:none">Done</button>';
      //     html +=                 '</td>';
      //     html +=             '</tr>';
      //                     });
      //     html +=             '<tr>';
      //     html +=                 '<td colspan="10"></td>';
      //     html +=                 '<td colspan="2"><b>Total Cost</b></td>';
      //     html +=                 '<td><b>'+this.total_amout_sum+'</b></td>';
      //     html +=             '</tr>';
      //     html +=     '</tbody>';
      //             }
      //     html += '</table>';
      //     html += '<script>';
      //     // html += 'var totalCalculation = '+this.totalCalculation;
      //     html += 'function edit(index){';
      //     html +=     '$("#poup-edit-btn-"+index).css("display", "none");';
      //     html +=     "$('#poup-delete-btn-'+index).css('display', 'none');";
      //     html +=     "$('#poup-up-btn-'+index).css('display', 'none');";
      //     html +=     "$('#poup-down-btn-'+index).css('display', 'none');";
      //     html +=     "$('#poup_activity_code_'+index).css('display', 'flex');";
      //     html +=     "$('#poup_element_description_'+index).css('display', 'flex');";
      //     html +=     "$('#poup_job_activity_'+index).css('display', 'flex');";
      //     html +=     "$('#poup_activity_code_label'+index).css('display', 'none');";
      //     html +=     "$('#poup_element_description_label'+index).css('display', 'none');";
      //     html +=     "$('#poup_job_activity_label'+index).css('display', 'none');";
      //     html +=     "$('#poup-done-btn-'+index).css('display', 'block');";
      //     html += '}';
      //     html +=  'function doneUpdate(index){ ';
      //     html +=     'var totalCalculation = JSON.parse(sessionStorage.getItem("totalCalculation"));';
      //     html +=     'var activity_code_poup = $("#poup_activity_code_"+index).val();';
      //     html +=     'var element_description_poup = $("#poup_element_description_"+index).val();';
      //     html +=     'var job_activity_poup = $("#poup_job_activity_"+index).val();';
      //     html +=     'totalCalculation.forEach((value, key)=>{'+
      //                     'if(key == index)'+
      //                     '{'+
      //                         'if(activity_code_poup != "")'+
      //                         '{'+
      //                             ' totalCalculation[key][\'activity_code\'] = activity_code_poup;'+
      //                         '}'+
      //                         "if(element_description_poup != '')"+
      //                         "{"+
      //                             "totalCalculation[key][\'element_description\'] = element_description_poup;"+
      //                         "}"+
      //                         "if(job_activity_poup != '')"+
      //                         "{"+
      //                             "totalCalculation[key][\'job_activity\'] = job_activity_poup;"+
      //                         "}"+
      //                     "}"+
      //                 '});';
      //     html +=     'sessionStorage.setItem("totalCalculation", JSON.stringify(totalCalculation));'
      //     html +=     '$("#poup-edit-btn-"+index).css("display", "inline-flex");';
      //     html +=     '$("#poup-delete-btn-"+index).css("display", "inline-flex");';
      //     html +=     '$("#poup-up-btn-"+index).css("display", "inline-flex");';
      //     html +=     '$("#poup-down-btn-"+index).css("display", "inline-flex");';
      //     html +=     '$("#poup_activity_code_"+index).css("display", "none");';
      //     html +=     '$("#poup_element_description_"+index).css("display", "none");';
      //     html +=     '$("#poup_job_activity_"+index).css("display", "none");';
      //     html +=     '$("#poup_activity_code_label"+index).css("display", "inline-flex");';
      //     html +=     '$("#poup_element_description_label"+index).css("display", "inline-flex");';
      //     html +=     '$("#poup_job_activity_label"+index).css("display", "inline-flex");';
      //     html +=     '$("#poup-done-btn-"+index).css("display", "none");';
      //     html +=     '$("#poup_activity_code_label"+index).text(activity_code_poup);';
      //     html +=     '$("#poup_element_description_label"+index).text(element_description_poup);';
      //     html +=     '$("#poup_job_activity_label"+index).text(job_activity_poup);';
      //     // html +=     'var html1 = \'<tbody class="row_position">\'';
      //     // html +=      'totalCalculation.forEach((component, i) =>'+
      //     //                 '{';
      //     // html +=             'html1 += <tr key="+i+" id="+component.activity_code+">';
      //     // html +=                 'html1 += <td>';
      //     // html +=                     'html1 += <span id="poup_activity_code_label+i+">+component.activity_code+</span>';
      //     // html +=                     'html1 += <input class="form-control" type="text" id="poup_activity_code_+i+" style="display:none">';
      //     // html +=                 'html1 += </td>';
      //     // html +=                 'html1 += <td>';
      //     // html +=                     'html1 += <span id="poup_element_description_label+i+">+component.element_description+</span>';
      //     // html +=                     'html1 += <input class="form-control" type="text" id="poup_element_description_+i+" style="display:none">';
      //     // html +=                 'html1 += </td>';
      //     // html +=                 'html1 += <td>';
      //     // html +=                     'html1 += <span id="poup_job_activity_label+i+">+component.job_activity+</span>';
      //     // html +=                     'html1 += <input class="form-control" type="text" id="poup_job_activity_+i+" style="display:none">';
      //     // html +=                 'html1 += </td>';
      //     // html +=                 'html1 += <td>+component.quantity+</td>';
      //     // html +=                 'html1 += <td>+component.unit+</td>';
      //     // html +=                 'html1 += <td>+component.lab+</td>';
      //     // html +=                 'html1 += <td>+component.eqp+</td>';
      //     // html +=                 'html1 += <td>+component.mat+</td>';
      //     // html +=                 'html1 += <td>+component.addcost+</td>';
      //     // html +=                 'html1 += <td>+component.ohp+</td>';
      //     // html +=                 'html1 += <td>+component.cont+</td>';
      //     // html +=                 'html1 += <td>+component.rate+</td>';
      //     // html +=                 'html1 += <td>+component.amount+</td>';
      //     // html +=                 'html1 += <td>';
      //     // html +=                     'html1 += <button class="btn btn-success" id="poup-edit-btn-+i+" onclick="edit(+i+)">Edit</button>';
      //     // html +=                     'html1 += <button class="btn btn-success" id="poup-delete-btn-+i+" onclick="deleteFromSum(+i+)">Remove</button>';
      //     // html +=                     'html1 += <button class="btn btn-success" id="poup-up-btn-+i+" onclick="up(+component.activity_code+)">Up</button>';
      //     // html +=                     'html1 += <button class="btn btn-success" id="poup-down-btn-+i+" onclick="down(+component.activity_code+)">Down</button>';
      //     // html +=                     'html1 += <button class="btn btn-success" id="poup-done-btn-+i+" onclick="doneUpdate(+i+)" style="display:none">Done</button>';
      //     // html +=                 'html1 += </td>';
      //     // html +=             'html1 += </tr>';
      //     // html +=              'html1 += })';
      //     // html +=             'html1 += \'<tr>\'';
      //     // html +=                 'html1 += \'<td colspan="10"></td>\'';
      //     // html +=                 'html1 += \'<td colspan="2"><b>Total Cost</b></td>\'';
      //     // html +=                 'html1 += \'<td><b>'+this.total_amout_sum+'</b></td>\'';
      //     // html +=             'html1 += \'</tr>\'';
      //     // html +=     'html1 += \'</tbody>\'';
      //     // html +=     ' $(\'.row_position\').html(html1);';
      //     html += '}';
      //     html += '<\/script>';
      // this.activity.document.write(html);
      // alert(this.activity);
      // if(this.activity.closed)
      // {
      //     alert('ok');
      //     this.totalCalculation = JSON.parse(sessionStorage.getItem("totalCalculation"));
      // }
    },
    reloadData(data){
        this.totalCalculation = data;
        this.jobActivitiesList = data;
        this.loadResourceComponent = true;            

        this.total_amout_sum  = this.totalCalculation.reduce(function(sum, current) {
                return sum += Number(parseFloat(current.amount).toFixed(2));
        }, 0);
        this.total_labour_sum  = this.totalCalculation.reduce(function(sum, current) {
                return sum += Number(parseFloat(current.lab).toFixed(2));
        }, 0);

        this.total_equipment_sum  = this.totalCalculation.reduce(function(sum, current) {
                return sum += Number(parseFloat(current.eqp).toFixed(2));
        }, 0);

        this.total_material_sum  = this.totalCalculation.reduce(function(sum, current) {
                return sum += Number(parseFloat(current.mat).toFixed(2));
        }, 0);

        this.total_addition_sum  = this.totalCalculation.reduce(function(sum, current) {
                return sum += Number(parseFloat(current.addcost).toFixed(2));
        }, 0);
        
        this.total_preliminary_sum  = this.totalCalculation.reduce(function(sum, current) {
            return sum += Number(parseFloat(current.preliminary_cost).toFixed(2));
        }, 0);

        this.total_ohp_sum  = this.totalCalculation.reduce(function(sum, current) {
                return sum += Number(parseFloat(current.ohp).toFixed(2));
        }, 0);

        this.total_preliminary_sum_collect =  parseFloat(this.total_preliminary_sum);
        this.total_consistgency_sum  = this.totalCalculation.reduce(function(sum, current) {
            return sum += Number(parseFloat(current.consistgency_cost).toFixed(2));
        }, 0);

        this.total_consistgency_sum_collect =  parseFloat(this.total_consistgency_sum );
        this.total_amout_collect = parseFloat(parseFloat(this.total_labour_sum) + parseFloat(this.total_equipment_sum) + parseFloat(this.total_material_sum) + parseFloat(this.total_preliminary_sum) + parseFloat(this.total_addition_sum) + parseFloat(this.total_ohp_sum) + parseFloat(this.total_consistgency_sum)).toFixed(2)
    },
    viewGrid(status=false){
      console.log("job_activity_section",this.job_activity_section);
      // if(this.job_activity_section == false){
        var _this = this;
        axios.get("/cost-estimate/fetch-data")
        .then(function (response) {
          if(response.data.updated_from == 'popup_window'){
            _this.reloadData(response.data.results)
            _this.storeActivity();
            if(response.data.grid_show){
              _this.job_activity_section = true;
            }else{
              _this.job_activity_section = false;
            }
            if(status){
              _this.job_activity_section = true;
            }
          }
        });
      // }
    },
    jobActivityWindow() {
      $(".detail-form-list").sortable({
        delay: 150
      });
      this.job_activity_section = false;
      var selectedData = new Array();
      $(".detail-form-list > tr").each(function () {
        selectedData.push({activity_code:$(this).attr("data"),index:$(this).attr("data-index")});
      });
      // var result_arr = [];
      // selectedData.forEach((value, index) => {
      //   this.totalCalculation.forEach((value1, index1) => {
      //     if (value1.activity_code == value.activity_code && value.index == index1) {
      //       result_arr.push(value1);
      //     }
      //   });
      // });
      // sessionStorage.removeItem('totalCalculation');
      // sessionStorage.setItem(
      //   "totalCalculation",
      //   JSON.stringify(result_arr)
      // );
      // sessionStorage.setItem(
      //   "timestamp", this.timestamp
      // );
      // this.country_name = $("#country_id").find(":selected").text().trim();
     
      // var formdata = {
      //   form_name:this.form_name,
      //   form_id:$("#detail_id").val(),
      //   project_title:this.project_title,
      //   estimate_type:this.estimate_type,
      //   country:this.country,
      //   country_job:this.country_name,
      //   contractor:this.contractor,
      //   owner:this.owner,
      //   project_description:this.project_description,
      //   project_specification:this.project_specification,
      //   activity_code: this.activity_code,
      //   category: this.category,
      //   activity_description: this.activity_description,
      //   imperial_rate: this.imperial_rate,
      //   quantity: this.quantity,
      //   imperial_unit: this.imperial_unit,
      //   metric_unit: this.metric_unit,
      //   labour_cost: this.labour_cost,
      //   equipment_cost: this.equipment_cost,
      //   material_cost: this.material_cost,
      //   additional_cost: this.additional_cost,
      //   sub_total: this.sub_total,
      //   preliminary_percentage: this.preliminary_percentage,
      //   preliminary_cost: this.preliminary_cost,
      //   overhead_percentage: this.overhead_percentage,
      //   overhead_cost: this.overhead_cost,
      //   consistgency_percentage: this.consistgency_percentage,
      //   consistgency_cost: this.consistgency_cost,
      //   total_cost: this.total_cost,
      //   project_note: this.project_note,
      //   component_note: this.component_note,
      //   components: this.components,
      //   metric_rate: this.metric_rate,
      // };
      // axios.post("/cost-estimate/store-activities", {
      //   results: result_arr,
      //   formdata:formdata,
      //   grid_show:0
      // })
      // .then(function (response) {
        
      // })
      // .catch((error) => {
        
      // });
      this.storeActivity();
      this.trackActivity = 1;
      this.activity = window.open(
        "/cost-estimate/detail-form/activity",
        "Activity",
        "width=1500 height=1000"
      );
    },
    groupComponents() {
      var groupComponents = []; 
      this.totalCalculation.forEach((activity) => {
        activity.activity_detail.forEach((detail) => {
          var isExist = false;
          for (let i = 0; i < groupComponents.length; i++) {
            var term = groupComponents[i];
            if (detail.resource_type == term.resource_type) {
              var total = term.quantity + Math.ceil(detail.quantity);
              groupComponents[i].quantity = total;
              isExist = true;
              break;
            }
          }
          if (! isExist) {
            groupComponents.push({
              resource_type: detail.resource_type,
              quantity: Math.ceil(detail.quantity),
              unit: detail.unit,
              category: detail.category,
            });
          }
        })
      });
      groupComponents.sort((a, b) => {
        if (a.category < b.category) return -1;
        if (a.category > b.category) return 1;
        return 0;
      });
      return groupComponents;
    }
    //  printPDF(){

    //          var _this = this
    //              console.log(this.project_title_sum);
    //         axios.post('/cost-estimate/detail-form/savePDF',{

    //              project_description:_this.project_description,
    //             project_specification:_this.project_note,
    //             owner:_this.owner,
    //             contractor:_this.contractor,
    //             project_location:_this.location,
    //             estimate_type_sum:_this.estimate_type,
    //             project_title_sum:_this.project_title,
    //             total_calculation:_this.totalCalculation,
    //             total_amout_sum:_this.total_amout_sum,
    //             total_preliminary_sum:_this.total_preliminary_sum,
    //             total_consistgency_sum:_this.total_consistgency_sum,
    //         })
    //         .then(function(response){
    //             window.open("/cost-estimate/detail-form/totalPDF", "_blank");
    //         })
    //         .catch((error)=> {
    //             if (error.response.status == 422){
    //                 _this.errors = error.response.data.errors;
    //                 _this.success = '';
    //             }
    //       });
    //     },
  },
};

</script>
<style>
@media screen {
  #print {
    display: none;
  }
}

@media print {
  body * {
    visibility: hidden;
    font-size: 10px !important;
  }
  #print,
  #print * {
    visibility: visible;
  }
  #print {
    position: absolute;
    left: 0;
    top: 0;
  }
  @page {
    size: landscape;
  }
}
</style>