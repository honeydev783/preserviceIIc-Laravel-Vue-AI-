
<style type="text/css" media="print">
 

/* @page {size:landscape}  */ 
@media print {
    @page {size:landscape;max-height:100%; max-width:100%}


body{width:100%;
    height:100%;
    -webkit-transform: rotate(-90deg) scale(.68,.68); 
    -moz-transform:rotate(-90deg) scale(.58,.58) }    
}

</style>

<style>
.btn-group-list .btn {
    width: 76px;
    margin-right: 4px;
    margin-bottom: 10px;
}
.btn-group-list {
    width: 184px;
}
.btn-save {
    position: absolute;
    right: 40px;
    top: 22px;
}
.load-data{
    font-size: 18px;
}
.goback-btn {
    position: absolute;
    right: 0px;
    top: -69px;
    width: auto;
    padding: 10px;
    display: flex;
    margin-right: -13px;
}
.goback-btn .btn {
    flex: 1 1 0;
    width: 155px;
    margin: 0px 5px;
}
</style>
<template>

    <div v-if="open">
        <div class="pull-right position-relative">
            <div class="goback-btn">
                <button type="button" class="btn btn-danger" @click="showSaveModal()">Save Esitmate</button>
                <button type="button" class="btn btn-success" @click="updateEstimate()">Update Esitmate</button>
                <button type="button" class="btn btn-primary" @click="printEstimate()">Print</button>
            </div>
        </div>
        <modal
            name="save-estimate-form"
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
                <span @click="saveEstimate" class="btn btn-info pull-left">Save</span>
                <span @click="hideSaveModal" class="btn btn-danger pull-right"
                    >Close</span
                >
                </div>
            </div>
        </modal>
        <div class="row print-estimate">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <table class="table table-striped table-bordered" style="background: aliceblue;" v-columns-resizable>
                    <thead>
                        <tr>
                            <th>CODE</th>
                            <th>ELEMENT</th>
                            <th class="activity">ACTIVITY</th>
                            <th class="qty">QTY</th>
                            <th>UNIT</th>
                            <th>RATE</th>
                            <th>LAB</th>
                            <th>EQUIP</th>
                            <th>MAT</th>
                            <th class="adddis">ADD/DISC</th>
                            <th>OH&P</th>
                            <th>CONT</th>                            
                            <th>AMOUNT</th>
                            <th class="action">Action</th>
                        </tr>
                    </thead>
                    <tbody v-if="loadResourceComponent" class="row_position acitivity-list">
                        <tr @click="drag" v-for="(component, i) in totalCalculation" :key="i" :data="component.activity_code" :id="i" :data-index="i">
                            <td>
                                <span :id="'poup_activity_code_label'+i">{{component.activity_code}}</span>
                                <input class="form-control" type="text" :id="'poup_activity_code_'+i" style="display:none" :value="component.activity_code">   
                            </td>
                            <td>
                                <span :id="'poup_element_description_label'+i">{{component.element_description}}</span>                                                       
                                <input class="form-control" type="text" :id="'poup_element_description_'+i" style="display:none" :value="component.element_description">
                            </td>
                            <td>
                                <span :id="'poup_job_activity_label'+i">{{component.job_activity}}</span>
                                <input class="form-control" type="text" :id="'poup_job_activity_'+i" style="display:none" :value="component.job_activity">
                            </td>
                            <td>{{component.quantity}}</td>
                            <td>{{component.unit}}</td>
                            <td align="right">{{ component.rate |  currency}}</td>
                            <td align="right">{{ component.lab |  currency}} </td>                                                     
                            <td align="right">{{ component.eqp |  currency}}</td>
                            <td align="right">{{ component.mat |  currency}}</td>
                            <td align="right">{{ component.addcost |  currency}}</td>
                            <td align="right">{{ component.ohp |  currency}}</td>
                            <td align="right">{{component.cont | currency}}</td>                            
                            <td align="right">{{ component.amount |  currency}}</td>
                            <td class="action">
                                <div class="btn-group-list">
                                    <span class="btn btn-success" :id="'poup-edit-btn-'+i" @click="edit(i,component.activity_code)">Edit</span>
                                    <span class="btn btn-success" :id="'poup-delete-btn-'+i" @click="deleteFromSum(i,component.activity_code)">Remove</span>
                                    <span class="btn btn-success" :id="'poup-up-btn-'+i" @click="actUp(component.activity_code,i)">Up</span>
                                    <span class="btn btn-success" :id="'poup-down-btn-'+i" @click="actDown(component.activity_code,i)">Down</span>
                                    <span class="btn btn-success" :id="'poup-done-btn-'+i" @click="doneUpdate(i)" style="display:none">Done</span>
                                </div>
                            </td>
                        </tr>                     
                    </tbody>
                    <tfoot>
                        <tr class="nosort">
                            <td colspan="10"></td>
                            <td colspan="2"><b>Total Cost</b></td>
                            <td><b>{{total_amout_sum | currency}}</b></td>
                        </tr>   
                    </tfoot>
                </table>
                <div v-if="loading" class="text-center load-data">Fetching data....</div>
            </div>
        </div>
       
        <div id="print-area">
            
            <div class="form-area" style="margin-bottom:20px">
                <table class="table table-bordered" style="display:none;margin-bottom:20px" id="print-table">
                    <tr>
                        <th align="left">
                            PROJECT TITLE
                        </th>
                        <td align="left">
                            {{ project_title }}
                        </td>
                    </tr>
                    <tr>
                        <th align="left">
                            ESTIMATE TYPE
                        </th>
                        <td align="left">
                            {{ estimate_type }}
                        </td>
                    </tr>
                    <tr>
                        <th align="left">
                            COUNTRY
                        </th>
                        <td align="left">
                            {{ country }}
                        </td>
                    </tr>
                    <tr>
                        <th align="left">
                            CONTRACTOR
                        </th>
                        <td align="left">
                            {{ contractor }}
                        </td>
                    </tr>
                    <tr>
                        <th align="left">
                            OWNER
                        </th>
                        <td align="left">
                            {{ owner }}
                        </td>
                    </tr>
                    <tr>
                        <th align="left">
                            PROJECT DESCRIPTION
                        </th>
                        <td align="left">
                            {{ project_description }}
                        </td>
                    </tr>
                    <tr>
                        <th align="left">
                            PROJECT SPECIFICATION
                        </th>
                        <td align="left">
                            {{ project_specification }}
                        </td>
                    </tr>
                </table>
                <table class="table table-bordered" id="print-form">
                    <tr>
                        <th align="left">
                            PROJECT TITLE
                        </th>
                        <td align="left">
                            <input
                                style="border: 1px solid #ccc"
                                v-model="project_title"
                                type="text"
                                class="form-control-plaintext"
                            />
                        </td>
                    </tr>
                    <tr>
                        <th align="left">
                            ESTIMATE TYPE
                        </th>
                        <td align="left">
                            <input
                                type="text"
                                style="border: 1px solid #ccc"
                                v-model="estimate_type"
                                class="form-control-plaintext"
                                
                            />
                        </td>
                    </tr>
                    <tr>
                        <th align="left">
                            COUNTRY
                        </th>
                        <td align="left">
                            <input
                                type="text"
                                style="border: 1px solid #ccc"
                                v-model="country_job"
                                class="form-control-plaintext"
                                
                            />
                        </td>
                    </tr>
                    <tr>
                        <th align="left">
                            CONTRACTOR
                        </th>
                        <td align="left">
                            <input
                                type="text"
                                style="border: 1px solid #ccc"
                                v-model="contractor"
                                class="form-control-plaintext"
                                
                            />
                        </td>
                    </tr>
                    <tr>
                        <th align="left">
                            OWNER
                        </th>
                        <td align="left">
                            <input
                            type="text"
                            style="border: 1px solid #ccc"
                            v-model="owner"
                            class="form-control-plaintext"
                            
                            />
                        </td>
                    </tr>
                    <tr>
                        <th align="left">
                            PROJECT DESCRIPTION
                        </th>
                        <td align="left">
                            <textarea
                            v-model="project_description"
                            id="project_description"
                            class="form-control"
                            ></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th align="left">
                            PROJECT SPECIFICATION
                        </th>
                        <td align="left">
                            <textarea
                            v-model="project_specification"
                            id="project_specification"
                            class="form-control"
                            ></textarea>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="print-grid"></div>
        </div>
        <detailEestimateForm  style="display: none" :totalCalculation1="totalCalculation" :estimate="estimate"></detailEestimateForm>

    </div>
    
</template>

<script>
    import detailEestimateForm from "./detail-form";
    export default({
        components:{
            detailEestimateForm,
        },
        data(){
            
            return{
                form_id:"",
                estimate: false,
                estimate_type:'',
                project_title:'',
                country_job: "",
                contractor:"",
                owner:"",
                project_description:"",
                project_specification:"",
                loading:true,
                open: true,
                loadResourceComponent: false,
                totalCalculation: {},
                activity_all: [],
                total_amout_sum:'',
                total_labour_sum:0,
                total_equipment_sum:0,
                total_material_sum:0,
                total_addition_sum:0,
                total_preliminary_sum:'',
                total_ohp_sum:0,
                total_preliminary_sum_collect:'',
                total_consistgency_sum_collect:'',
                total_amout_collect:'',
                edit_activity_code:'',

                activity_code: '',
                category: '',
                activity_description: '',
                imperial_rate: '',
                quantity: '',
                imperial_unit: '',
                metric_unit: '',
                labour_cost: '',
                equipment_cost: '',
                material_cost: '',
                additional_cost: '',
                sub_total: '',
                preliminary_percentage: '',
                preliminary_cost: '',
                overhead_percentage: '',
                overhead_cost: '',
                consistgency_percentage: '',
                consistgency_cost: '',
                total_cost: '',
                project_note: '',
                component_note: '',
                components: '',
                metric_rate: '',
            }
        },        
        mounted(){
            this.loadData();
        },
        methods:{
            showSaveModal() {
                this.$modal.show("save-estimate-form");
            },
            hideSaveModal() {
                this.$modal.hide("save-estimate-form");
            },
            printEstimate(){
                // if (window.opener != null && !window.opener.closed) {
                //     // window.opener.location.reload();
                //     console.log(window.opener);
                //     window.opener.location;    
                // }
                $("#print-area #print-table").show();
                $("#print-area #print-form").hide();
                var html = $(".print-estimate").html();
                $("#print-area .print-grid").html(html);
                // $("#print-area .print-grid table").attr("border","1");
                // $("#print-area .print-grid table").attr("cellpadding","1");
                // $("#print-area .print-grid table .activity").attr("width","10%");
                // $("#print-area .print-grid table .adddis").attr("width","10%");
                $("#print-area .print-grid table td").css("width","20%");
                // $("#print-area .print-grid table td").css("word-break","break-all");
                $("#print-area .action").hide();
                this.$htmlToPaper("print-area");
                $("#print-area .print-grid").html('');
                $("#print-area #print-table").hide();
                $("#print-area #print-form").show();
            },
            reloadData(data,formdata){
                this.form_id = formdata.form_id,
                this.form_name = formdata.form_name;
                this.totalCalculation = data;
                this.estimate_type = formdata.estimate_type;
                this.project_title = formdata.project_title;
                this.country = formdata.country;
                this.country_job = formdata.country_job;
                this.contractor = formdata.contractor;
                this.owner = formdata.owner;
                this.project_description = formdata.project_description;
                this.project_specification = formdata.project_specification;

                this.activity_code =  formdata.activity_code;
                this.category =  formdata.category;
                this.activity_description = formdata.activity_description;
                this.imperial_rate = formdata.imperial_rate;
                this.quantity = formdata.quantity;
                this.imperial_unit = formdata.imperial_unit;
                this.metric_unit = formdata.metric_unit;
                this.labour_cost = formdata.labour_cost;
                this.equipment_cost = formdata.equipment_cost;
                this.material_cost = formdata.material_cost;
                this.additional_cost = formdata.additional_cost;
                this.sub_total = formdata.sub_total;
                this.preliminary_percentage = formdata.preliminary_percentage;
                this.preliminary_cost = formdata.preliminary_cost;
                this.overhead_percentage = formdata.overhead_percentage;
                this.overhead_cost = formdata.overhead_cost;
                this.consistgency_percentage = formdata.consistgency_percentage;
                this.consistgency_cost = formdata.consistgency_cost;
                this.total_cost = formdata.total_cost;
                this.project_note = formdata.project_note;
                this.component_note = formdata.component_note;
                this.components = formdata.components;
                this.metric_rate = formdata.metric_rate;
                
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
                this.loading = false;
            },
            loadData(){
                var _this = this;
                this.loading = true;
                // this.reloadData();
                axios.get("/cost-estimate/fetch-data")
                .then(function (response) {
                    // var session_totalCalculation = JSON.parse(sessionStorage.getItem("totalCalculation"));
                    var session_totalCalculation = response.data.results;
                    _this.reloadData(response.data.results,response.data.formdata);
                    
                });
                
            },
            saveEstimate() {
                var _this = this;

                var selectedData = new Array();
                var sortableArray = new Array();
                $('.acitivity-list > tr').each(function() {
                    selectedData.push({activity_code:$(this).attr("data"),index:$(this).attr("data-index")});
                });
                selectedData.forEach((value, index) => {
                    this.totalCalculation.forEach((value1, index1) => {
                    if (value1.activity_code == value.activity_code && value.index == index1) {
                        sortableArray.push(value1);
                    }
                    });
                });
                // _this.totalCalculation = sortableArray;
                axios.post("/cost-estimate/detail-form/saveForm", {
                    id: _this.form_id,
                    form_name: _this.form_name,
                    project_title: _this.project_title,
                    estimate_type: _this.estimate_type,
                    country: _this.country,
                    activity_code: '',
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
                    contractor: _this.contractor,
                    owner: _this.owner,
                    project_specification: _this.project_specification,

                })
                .then(function (response) {
                    _this.$toast.success("Form Save Successfully");
                    setTimeout(function(){
                        window.opener.location.reload();
                        window.close();
                    },2500);
                    
                })
                .catch((error) => {
                    // if (error.response.status == 422) {
                    //   _this.errors = error.response.data.errors;
                    //   _this.success = "";
                    // }
                });
            },
            updateEstimate() {
                var selectedData = [];
                $('.acitivity-list > tr').each(function() {
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
                sessionStorage.removeItem('totalCalculation');
                sessionStorage.setItem(
                    "totalCalculation",
                    JSON.stringify(result_arr)
                );
                sessionStorage.setItem(
                    "timestamp", this.timestamp
                );
                var _opener = window.opener;
                var formdata = {
                    project_title:this.project_title,
                    estimate_type:this.estimate_type,
                    country:this.country_name,
                    country_job:this.country_job,
                    contractor:this.contractor,
                    owner:this.owner,
                    project_description:this.project_description,
                    project_specification:this.project_specification
                };
                axios.post("/cost-estimate/store-activities", {
                    results: result_arr,
                    grid_show:true,
                    updated_from:'popup_window',
                    formdata:formdata,
                })
                .then(function (response) {
                    console.log(window.opener);
                    // _opener.Vue.component.viewParentFunc();
                    window.opener.CallParentfunction();
                //    window.opener.callParentFunc();  
                })
                .catch((error) => {
                    
                });
            },
            edit(index,code)
            {

                var lastUpdated = code+':edit';
                let d = new Date();
                d.setTime(d.getTime() + 1 * 24 * 60 * 60 * 1000);
                let expires = "expires=" + d.toUTCString();
                document.cookie = "lastActivityUpdated="+lastUpdated+";" + expires + ";path=/";
                this.edit_activity_code = code;
                $('#poup-edit-btn-'+index).css('display', 'none');            
                $('#poup-delete-btn-'+index).css('display', 'none');
                $('#poup-up-btn-'+index).css('display', 'none');
                $('#poup-down-btn-'+index).css('display', 'none');
                $('#poup_activity_code_'+index).css('display', 'flex');
                $('#poup_element_description_'+index).css('display', 'flex');
                $('#poup_job_activity_'+index).css('display', 'flex');
                $('#poup_activity_code_label'+index).css('display', 'none');
                $('#poup_element_description_label'+index).css('display', 'none');
                $('#poup_job_activity_label'+index).css('display', 'none');
                $('#poup-done-btn-'+index).css('display', 'block');
            },
            doneUpdate(index)
            {
                var activity_code = $('#poup_activity_code_'+index).val();
                var element_description = $('#poup_element_description_'+index).val();
                var job_activity = $('#poup_job_activity_'+index).val();

                var rowUpdated = {
                    "edit_activity_code":this.edit_activity_code,
                    "activity_code":activity_code,
                    "element_description":element_description,
                    "job_activity":job_activity,
                };
                // rowUpdated['edit_activity_code'] = this.edit_activity_code;
                // rowUpdated['activity_code'] = activity_code;
                // rowUpdated['element_description'] = element_description;
                // rowUpdated['job_activity'] = job_activity;
                console.log(rowUpdated);
                let d = new Date();
                d.setTime(d.getTime() + 1 * 24 * 60 * 60 * 1000);
                let expires = "expires=" + d.toUTCString();
                document.cookie = "rowUpdated="+JSON.stringify(rowUpdated)+";" + expires + ";path=/";

                this.totalCalculation.forEach((value, key)=>{
                    if(key == index)
                    {
                        if(activity_code != '')
                        {
                            this.totalCalculation[key]['activity_code'] = activity_code;
                        }
                        if(element_description != '')
                        {
                            this.totalCalculation[key]['element_description'] = element_description;
                        }
                        if(job_activity != '')
                        {
                            this.totalCalculation[key]['job_activity'] = job_activity;
                        }
                    }
                })

                $('#poup-edit-btn-'+index).css('display', 'inline-flex');
                $('#poup-delete-btn-'+index).css('display', 'inline-flex');
                $('#poup-up-btn-'+index).css('display', 'inline-flex');
                $('#poup-down-btn-'+index).css('display', 'inline-flex');
                $('#poup_activity_code_'+index).css('display', 'none');
                $('#poup_element_description_'+index).css('display', 'none');
                $('#poup_job_activity_'+index).css('display', 'none');
                $('#poup_activity_code_label'+index).css('display', 'inline-flex');
                $('#poup_element_description_label'+index).css('display', 'inline-flex');
                $('#poup_job_activity_label'+index).css('display', 'inline-flex');
                $('#poup-done-btn-'+index).css('display', 'none');
            },
            drag()
            {
                var totalCalculationArray =  this.totalCalculation;
                const vm1 = this;        
                totalCalculationArray.forEach((v,k) => {                                                             
                    $(".acitivity-list").sortable({
                        delay: 150,
                        items: "tr:not(.nosort)",
                        stop: function() {                        
                            var selectedData = new Array();   
                            var sortableArray = new Array();                                            
                            $('.acitivity-list > tr').each(function() {
                                // selectedData.push($(this).attr("data"));
                                selectedData.push({activity_code:$(this).attr("data"),index:$(this).attr("data-index")});
                            });

                            selectedData.forEach((value, index) => {
                                if(value != undefined)
                                {
                                    totalCalculationArray.forEach((value1, index1)=>{    
                                        if (value1.activity_code == value.activity_code && value.index == index1) {                                
                                        // if(value1.activity_code == value)
                                        // {                                            
                                            sortableArray.push(value1);
                                        }
                                    })                                
                                }
                            })    
                            // vm1.totalCalculation = sortableArray;
                        }
                    });
                });
            },
            updateRecord(){
                var selectedData = new Array();   
                var sortableArray = new Array();                                            
                $('.acitivity-list > tr').each(function() {
                    selectedData.push($(this).attr("data"));
                });
                selectedData.forEach((value, index) => {
                    if(value != undefined)
                    {
                        this.totalCalculation.forEach((value1, index1)=>{                                    
                            if(value1.activity_code == value)
                            {                                            
                                sortableArray.push(value1);
                            }
                        })                                
                    }
                });

                // var timestamp = sessionStorage.getItem("timestamp");
                // axios
                // .post("/cost-estimate/detail-form/saveTempData", {
                //     timestamp: timestamp,
                //     data: JSON.stringify(sortableArray)
                // })
                // .then(function (response) {
                
                // })
                // .catch((error) => {
                
                // });       
            },
            actUp(id,index)
            {
                var selected=0;
                var itemlist = $('.acitivity-list');
                sessionStorage.setItem("startTrack",2);
                var len=$(itemlist).children().length;
                var selected = $('#'+index).index();        
                if(selected > 0)
                {
                    jQuery($(itemlist).children().eq(selected-1)).before(jQuery($(itemlist).children().eq(selected)));
                    selected=selected-1;
                }
                var lastUpdated = id+':up';

                let d = new Date();
                d.setTime(d.getTime() + 1 * 24 * 60 * 60 * 1000);
                let expires = "expires=" + d.toUTCString();
                document.cookie = "lastActivityUpdated="+lastUpdated+";" + expires + ";path=/";
                // this.actSetCookie("lastActivityUpdated",lastUpdated);
                // this.updateRecord();
                // var selectedData = new Array();   
                // var sortableArray = new Array();                                            
                // $('.row_position > tr').each(function() {
                //     selectedData.push($(this).attr("data"));
                // });
                // selectedData.forEach((value, index) => {
                //     if(value != undefined)
                //     {
                //         this.totalCalculation.forEach((value1, index1)=>{                                    
                //             if(value1.activity_code == value)
                //             {                                            
                //                 sortableArray.push(value1);
                //             }
                //         })                                
                //     }
                // });
                // this.totalCalculation = sortableArray;           
                
                // sessionStorage.setItem("latestSequence",JSON.stringify(sortableArray));
            },
            actDown(id,index)
            {
                var selected=0;
                var itemlist = $('.acitivity-list');
                var len=$(itemlist).children().not(".nosort").length;
                var selected = $('#'+index).index(); 
                if(selected < len)
                {
                    jQuery($(itemlist).children().eq(selected+1)).after(jQuery($(itemlist).children().eq(selected)));
                    selected=selected+1;
                }

                var lastUpdated = id+':down';

                let d = new Date();
                d.setTime(d.getTime() + 1 * 24 * 60 * 60 * 1000);
                let expires = "expires=" + d.toUTCString();
                document.cookie = "lastActivityUpdated="+lastUpdated+";" + expires + ";path=/";

                // this.updateRecord();
                // var selectedData = new Array();   
                // var sortableArray = new Array();                                            
                // $('.row_position>tr:not(.nosort)').each(function() {
                //     selectedData.push($(this).attr("data"));
                // });
                // selectedData.forEach((value, index) => {
                //     if(value != undefined)
                //     {
                //         this.totalCalculation.forEach((value1, index1)=>{                                    
                //             if(value1.activity_code == value)
                //             {                                            
                //                 sortableArray.push(value1);
                //             }
                //         })                                
                //     }
                // })    
                // this.totalCalculation = sortableArray;    

                // sessionStorage.setItem("latestSequence",JSON.stringify(sortableArray));
            },
            deleteFromSum(index,code){
                this.totalCalculation.splice(index, 1);             
                this.activity_all.splice(index, 1);
                
                var lastUpdated = code+':remove';

                let d = new Date();
                d.setTime(d.getTime() + 1 * 24 * 60 * 60 * 1000);
                let expires = "expires=" + d.toUTCString();
                document.cookie = "lastActivityUpdated="+lastUpdated+";" + expires + ";path=/";
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
            save: function()
            {
                // component('detail-estimate-form').abc(); 
                // sessionStorage.setItem("newtotalCalculation", JSON.stringify(this.totalCalculation));
                this.$root.$emit('detail-estimate-form');
            }
        }
    });
</script>
