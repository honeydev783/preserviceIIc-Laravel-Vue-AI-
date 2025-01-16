<template>
    <div v-if="open">
        <!-- <button @click="save">save</button> -->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <table class="table table-striped table-bordered" style="background: aliceblue;" v-columns-resizable>
                    <thead>
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
                            <th>AMOUNT</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody v-if="loadResourceComponent" class="row_position">
                        <tr @click="drag" v-for="(component, i) in totalCalculation" :key="i" :id="component.activity_code">
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
                            <td>{{ component.rate |  currency}}</td>
                            <td>{{ component.lab |  currency}} </td>                                                     
                            <td>{{ component.eqp |  currency}}</td>
                            <td>{{ component.mat |  currency}}</td>
                            <td>{{ component.addcost |  currency}}</td>
                            <td>{{ component.ohp |  currency}}</td>
                            <td>{{component.cont | currency}}</td>                            
                            <td>{{ component.amount |  currency}}</td>
                            <td>
                                <span class="btn btn-success" :id="'poup-edit-btn-'+i" @click="edit(i)">Edit</span>
                                <span class="btn btn-success" :id="'poup-delete-btn-'+i" @click="deleteFromSum(i)">Remove</span>
                                <span class="btn btn-success" :id="'poup-up-btn-'+i" @click="up(component.activity_code)">Up</span>
                                <span class="btn btn-success" :id="'poup-down-btn-'+i" @click="down(component.activity_code)">Down</span>
                                <span class="btn btn-success" :id="'poup-done-btn-'+i" @click="doneUpdate(i)" style="display:none">Done</span>
                            </td>
                        </tr>   
                        <tr>
                            <td colspan="10"></td>
                            <td colspan="2"><b>Total Cost</b></td>
                            <td><b>{{total_amout_sum | currency}}</b></td>
                        </tr>                     
                    </tbody>
                </table>
            </div>
        </div>
        <detailEestimateForm  style="display: none" :totalCalculation1="totalCalculation" :estimate="estimate"></detailEestimateForm>
        <!-- <span class="btn btn-success" @click="save">Save</span> -->
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
                estimate: false,
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
            }
        },        
        mounted(){
            var session_totalCalculation = JSON.parse(sessionStorage.getItem("totalCalculation"));
            this.totalCalculation = session_totalCalculation;
            // alert(JSON.stringify(this.totalCalculation));
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
        methods:{   
            edit(index)
            {
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
                    $(".row_position").sortable({
                        delay: 150,
                        stop: function() {                        
                            var selectedData = new Array();   
                            var sortableArray = new Array();                                            
                            $('.row_position>tr').each(function() {
                                selectedData.push($(this).attr("id"));
                            });

                            selectedData.forEach((value, index) => {
                                if(value != undefined)
                                {
                                    totalCalculationArray.forEach((value1, index1)=>{                                    
                                        if(value1.activity_code == value)
                                        {                                            
                                            sortableArray.push(value1);
                                        }
                                    })                                
                                }
                            })    
                            vm1.totalCalculation = sortableArray;
                        }
                    });
                });
            },
            up(id)
            {
                // alert(id);
                var selected=0;
                var itemlist = $('.row_position');
                var len=$(itemlist).children().length;
                var selected = $('#'+id).index();        
                if(selected>0)
                {
                    jQuery($(itemlist).children().eq(selected-1)).before(jQuery($(itemlist).children().eq(selected)));
                    selected=selected-1;
                }
                
                var selectedData = new Array();   
                var sortableArray = new Array();                                            
                $('.row_position>tr').each(function() {
                    selectedData.push($(this).attr("id"));
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
                })    
                this.totalCalculation = sortableArray;           
                
            },
            down(id)
            {
                var selected=0;
                var itemlist = $('.row_position');
                var len=$(itemlist).children().length;
                var selected = $('#'+id).index();    
                if(selected < len)
                {
                    jQuery($(itemlist).children().eq(selected+1)).after(jQuery($(itemlist).children().eq(selected)));
                    selected=selected+1;
                }

                var selectedData = new Array();   
                var sortableArray = new Array();                                            
                $('.row_position>tr').each(function() {
                    selectedData.push($(this).attr("id"));
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
                })    
                this.totalCalculation = sortableArray;        
            },
            deleteFromSum(index){
                this.totalCalculation.splice(index, 1);             
                this.activity_all.splice(index, 1);

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
                sessionStorage.setItem("newtotalCalculation", JSON.stringify(this.totalCalculation));
                this.$root.$emit('detail-estimate-form')
            }
        }
    });
</script>