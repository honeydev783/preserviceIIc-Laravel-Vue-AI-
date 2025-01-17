<style>
.btn-group-list .btn {
    width: 76px;
    margin-right: 4px;
    margin-bottom: 10px;
}
.btn-group-list {
    width: 184px;
}
</style>
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
                    <tbody v-if="loadResourceComponent" class="row_position acitivity-list">
                        <tr @click="drag" v-for="(component, i) in totalCalculation" :key="i" :data="component.activity_code" :id="i">
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
                            <td>
                                <div class="btn-group-list">
                                    <span class="btn btn-success" :id="'poup-edit-btn-'+i" @click="edit(i)">Edit</span>
                                    <span class="btn btn-success" :id="'poup-delete-btn-'+i" @click="deleteFromSum(i)">Remove</span>
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
            </div>
        </div>
        <detailEestimateForm  style="display: none" :totalCalculation1="totalCalculation" :estimate="estimate"></detailEestimateForm>

        <div class="text-center">
            <span class="btn btn-success btn-lg" @click="save">Save</span>
        </div>
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
                    $(".acitivity-list").sortable({
                        delay: 150,
                        items: "tr:not(.nosort)",
                        stop: function() {                        
                            var selectedData = new Array();   
                            var sortableArray = new Array();                                            
                            $('.acitivity-list > tr').each(function() {
                                selectedData.push($(this).attr("data"));
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
                sessionStorage.setItem("latestSequence",JSON.stringify(sortableArray));
                sessionStorage.setItem("startTrack",2);
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
                this.updateRecord();
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
                sessionStorage.setItem("startTrack",2);
                if(selected < len)
                {
                    jQuery($(itemlist).children().eq(selected+1)).after(jQuery($(itemlist).children().eq(selected)));
                    selected=selected+1;
                }
                this.updateRecord();
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
                // sessionStorage.setItem("newtotalCalculation", JSON.stringify(this.totalCalculation));
                this.$root.$emit('detail-estimate-form');
            }
        }
    });
</script>