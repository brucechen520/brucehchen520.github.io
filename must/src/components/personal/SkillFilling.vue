<template>
  <div class="container">
<div v-if="stateResumeData.Mem_Se != null">
    <div v-if="!isModify">
    <h1>我的資料</h1>
    <div class="row">
        <label class="col-12 col-md-auto">{{ users.level }}級:{{ users.name }}</label>
    </div>
    <div class="row"><label class="col-12 col-md-auto">姓名是否公開:{{permitdesc[stateResumeData.permit.name]}}</label></div>
    <div class="row"><label class="col-12 col-md-auto">信箱:{{stateResumeData.mail}}</label></div>
    <div class="row"><label class="col-12 col-md-auto">信箱是否公開:{{permitdesc[stateResumeData.permit.mail]}}</label></div>
    <div class="row"><label class="col-12 col-md-auto">手機:{{stateResumeData.cellphone}}</label></div>
    <div class="row"><label class="col-12 col-md-auto">手機是否公開:{{permitdesc[stateResumeData.permit.phone]}}</label></div>
    <div class="row"><label class="col-12 col-md-auto">技能專長:{{stateResumeData.expertise}}</label></div>
    <div class="row"><label class="col-12 col-md-auto">作品:{{stateResumeData.works}}</label></div>
    <div class="row"><label class="col-12 col-md-auto">證照:{{stateResumeData.license}}</label></div>
    <div class="row"><label class="col-12 col-md-auto">自我介紹:{{stateResumeData.biography}}</label></div>
        <span class="btn btn-info" @click="toModifyData">修改</span>
    </div>
    <div v-else>
        <h1>個人資料修改</h1>
        <div class="row" style="color:red">*為必填</div>
        <div class="row">
            <label class="col-12 col-md-auto">{{ users.level }}級:{{ users.name }}</label>
        </div>
        <div class="row">
            <label class="col-12 col-md-auto">姓名是否公開<span style="color:red">*</span></label>
                    <select class="col-12 col-md-auto" v-model="modifyData.permit.name" v-validate="'required'" >
          <option v-for="item in permitList" :key="item.value" :value="item.value" >{{ item.mes }}</option>
        </select>
        </div>
        <div class="row">
            <label class="col-12 col-md-auto">信箱<span style="color:red">*</span></label>
                <input class="col-12 col-md-auto" v-model="modifyData.mail" v-validate="'required|email'" type="email" name="email">
                <span>{{ errors.first('email') }}</span>
    </div>
    <div class="row">
            <label class="col-12 col-md-auto">信箱是否公開<span style="color:red">*</span></label>
                    <select class="col-12 col-md-auto" v-model="modifyData.permit.mail" v-validate="'required'" >
          <option v-for="item in permitList" :key="item.value" :value="item.value" >{{ item.mes }}</option>
        </select>
        </div>
    <div class="row">
        <label class="col-12 col-md-auto">手機</label>
        <input class="col-12 col-md-auto" v-model="modifyData.cellphone" v-validate="'numeric'">
        <label class="col-12 col-md-auto">手機是否公開<span style="color:red">*</span></label>
        <select class="col-12 col-md-auto" v-model="modifyData.permit.phone" v-validate="'required'" >
          <option v-for="item in permitList" :key="item.value" :value="item.value" >{{ item.mes }}</option>
        </select>
    </div>
    <div class="row">
        <label class="col-12 col-md-auto">技能專長</label>
        <div v-for="(item, index) in modifyData.expertise" :key="index">
            <input v-model="item.value" :name = "'keyWord_' +index">
            <label :class="[item.status ? 'fas fa-plus' : 'fas fa-minus']" @click="toggleKey2(item.id,item ,'expertise')"></label>
        </div></div>
    <div class="row">
        <label class="col-12 col-md-auto">作品</label>
        <div v-for="(item, index) in modifyData.works" :key="index">
            <input v-model="item.value" :name = "'keyWord_' +index">
            <label :class="[item.status ? 'fas fa-plus' : 'fas fa-minus']" @click="toggleKey2(item.id, item , 'works')"></label>
        </div></div>
    <div class="row">
        <label class="col-12 col-md-auto">證照</label>
        <div v-for="(item, index) in modifyData.license" :key="index">
            <input v-model="item.value" :name = "'keyWord_' +index">
            <label :class="[item.status ? 'fas fa-plus' : 'fas fa-minus']" @click="toggleKey2(item.id, item , 'license')"></label>
        </div>
    </div>
    <div class="row">
        <label class="col-2">自我介紹</label>
        <textarea rows="5" cols="100" v-model="modifyData.biography" name="description"> </textarea>
    </div>
        <span class="btn btn-info" @click="modifyCancel">取消</span>
        <span class="btn btn-info" @click="validateForm2">送出</span>
    </div>
</div>
<div v-else>
    <h1>專長填寫</h1>
    <div class="row" style="color:red">*為必填</div>
    <div class="row">
        <label class="col-12 col-md-auto">{{ users.level }}級:{{ users.name }}</label>
    </div>
    <div class="row">
        <label class="col-12 col-md-auto">姓名是否公開<span style="color:red">*</span></label>
        <select class="col-12 col-md-auto" v-model="skill_data.permit.name" v-validate="'required'" >
            <option v-for="item in permitList" :key="item.value" :value="item.value" >{{ item.mes }}</option>
        </select>
    </div>
    <div class="row">    
    <label class="col-12 col-md-auto">信箱<span style="color:red">*</span></label>
        <input class="col-12 col-md-auto" v-model="skill_data.mail" v-validate="'required|email'" type="email" name="email">
        <span>{{ errors.first('email') }}</span>
    </div>
    <div class="row">
        <label class="col-12 col-md-auto">信箱是否公開<span style="color:red">*</span></label>
        <select class="col-12 col-md-auto" v-model="skill_data.permit.mail" v-validate="'required'" >
            <option v-for="item in permitList" :key="item.value" :value="item.value" >{{ item.mes }}</option>
        </select>
    </div>
    <div class="row">
        <label class="col-12 col-md-auto">手機</label>
        <input class="col-12 col-md-auto" v-model="skill_data.cellphone" v-validate="'numeric'">
        <label class="col-12 col-md-auto">手機是否公開<span style="color:red">*</span></label>
        <select class="col-12 col-md-auto" v-model="skill_data.permit.phone" v-validate="'required'" >
          <option v-for="item in permitList" :key="item.value" :value="item.value" >{{ item.mes }}</option>
        </select>
    </div>
    <div class="row">
        <label class="col-12 col-md-auto">技能專長</label>
        <div v-for="(item, index) in skill_data.expertise" :key="index">
            <input v-model="item.value" :name = "'keyWord_' +index">
            <label :class="[item.status ? 'fas fa-plus' : 'fas fa-minus']" @click="toggleKey(item.id,item ,'expertise')"></label>
        </div></div>
    <div class="row">
        <label class="col-12 col-md-auto">作品</label>
        <div v-for="(item, index) in skill_data.works" :key="index">
            <input v-model="item.value" :name = "'keyWord_' +index">
            <label :class="[item.status ? 'fas fa-plus' : 'fas fa-minus']" @click="toggleKey(item.id, item , 'works')"></label>
        </div></div>
    <div class="row">
        <label class="col-12 col-md-auto">證照</label>
        <div v-for="(item, index) in skill_data.license" :key="index">
            <input v-model="item.value" :name = "'keyWord_' +index">
            <label :class="[item.status ? 'fas fa-plus' : 'fas fa-minus']" @click="toggleKey(item.id, item , 'license')"></label>
        </div>
    </div>
    <div class="row">
        <label class="col-2">自我介紹</label>
        <textarea rows="5" cols="100" v-model="skill_data.biography" name="description"> </textarea>
    </div>
    <div class="row">
        <button class="col-12 col-md-auto" @click="validateForm">送出</button>
    </div>

    </div>
</div>
  
</template>

<script>
    import { mapState, mapGetters, mapActions } from 'vuex';
    import * as api from '../lib/api';
    export default {
        data () {
          return {
            isModify : false,
            modifyData:{},
            skill_data: {
                'biography':'',
                'mail':'', // 信箱
                'cellphone':'', // 手機
                'permit':{
                    name:0,
                    mail:0,
                    phone:0
                },
                'expertise': [{  // 技能專長
                    'id': Number(1),
                    'value': '',
                    'status': true
                }], 
                'works': [{     // 作品
                    'id': Number(1),
                    'value': '',
                    'status': true
                }],
                'license': [{   // 證照
                    'id': Number(1),
                    'value': '',
                    'status': true
                }]
            },
            permitList: [
              {'mes': '對系友公開', 'value': '0'},
              {'mes': '對訪客公開', 'value': '1'},
              {'mes': '不公開', 'value': '2'},        
            ],
            permitdesc:['對系友公開','對訪客公開','不公開'],
          }
        },
        computed: {
            // ...mapGetters 為 ES7 寫法
            ...mapState(['stateResumeData']),
            ...mapGetters({
                // getTodo return value 將會存在別名為 todos 的 webData 上
                users: 'getUser'
            }),
        },
        mounted(){
            this.action_resume_get({id:this.users.id});
        },
        methods: {
            liclick (e) { // stay dropdown open
                e.stopPropagation();
            },
            ...mapActions([
  	            'action_resume_insert', 'action_resume_get','action_resume_update'
  	        ]),
            toggleKey (id, item, key) {
                var index = this.skill_data[key].findIndex(arr => arr.id === id ); // 取出目前欄位的index 
                if(this.skill_data[key][index].status){
                    this.skill_data[key][index].status = false;  // 加號變減號
                    this.skill_data[key] = [...this.skill_data[key], { // 新增一個陣列欄位，重新繪出視窗
                        'id':this.skill_data[key][this.skill_data[key].length-1].id + 1,
                        'status': true,
                        'value': ''
                        }];
                }
                else {
                    this.skill_data[key] = this.skill_data[key].filter(arr => arr.id !== id); // 移除目前id的輸入視窗
                }
            },
            toggleKey2 (id, item, key) {
                var index = this.modifyData[key].findIndex(arr => arr.id === id ); // 取出目前欄位的index 
                if(this.modifyData[key][index].status){
                    this.modifyData[key][index].status = false;  // 加號變減號
                    this.modifyData[key] = [...this.modifyData[key], { // 新增一個陣列欄位，重新繪出視窗
                        'id':this.modifyData[key][this.modifyData[key].length-1].id + 1,
                        'status': true,
                        'value': ''
                        }];
                }
                else {
                    this.modifyData[key] = this.modifyData[key].filter(arr => arr.id !== id); // 移除目前id的輸入視窗
                }
            },
            validateForm () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        let param = {
                            biography:this.skill_data.biography,
                            mail:this.skill_data.mail,
                            cellphone:this.skill_data.cellphone,
                            permit:this.skill_data.permit,
                            expertise:this.skill_data.expertise,
                            works:this.skill_data.works,
                            license:this.skill_data.license,
                        }
                        param.expertise = param.expertise.map(e=>e.value).toString().replace(/,/g,'、');
                        param.works = param.works.map(e=>e.value).toString().replace(/,/g,'、');
                        param.license = param.license.map(e=>e.value).toString().replace(/,/g,'、');
                        this.action_resume_insert({data:param}).then(function(result){
                            if(result.code == 'success'){
                                alert('成功');
                                this.action_resume_get({id:this.users.id});
                                modifyCancel();
                            }
                        });
                    }
                    else
                        alert('Correct them errors!'); 
                })
            },
            validateForm2 () {
                this.$validator.validateAll().then((result) => {
                    let self = this;
                    if (result) {
                        let param = Object.assign({},self.modifyData);
                        param.expertise = param.expertise.map(e=>e.value).toString().replace(/,/g,'、');
                        param.works = param.works.map(e=>e.value).toString().replace(/,/g,'、');
                        param.license = param.license.map(e=>e.value).toString().replace(/,/g,'、');
                        self.action_resume_update({data:param}).then(function(result){
                            if(result.code == 'success'){
                                alert('成功');
                                self.action_resume_get({id:self.users.id});
                                self.modifyCancel();
                            }
                        });
                    }
                    else
                        alert('Correct them errors!'); 
                })
            },
            toModifyData(){
                this.modifyData = Object.assign({},this.stateResumeData);
                function toObj(e,index,arr){
                    let obj = {
                        id:index+1,
                        value:e,
                        status:(index+1 == arr.length)
                    }
                    return obj;
                };
                this.modifyData.expertise = this.modifyData.expertise.split("、").map(toObj);
                this.modifyData.works = this.modifyData.works.split("、").map(toObj);
                this.modifyData.license = this.modifyData.license.split("、").map(toObj);
                this.isModify = true;
            },
            modifyCancel(){
                this.isModify = false;
            }

        }
    }
</script>

<style>
    
    .modal-block {
        background-color: #D2EBF7;
    }
    .customClassForDropDown
    {
       height: 640px;
       overflow-y: auto;
    }
</style>