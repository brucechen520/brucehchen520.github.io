<template>
  <div class="container">
    <h1>我的職缺</h1>
    <span class="btn btn-info" @click="addVacancy">新增職缺</span>
    <div v-for="(item, index) in stateVacanceData.list" :key="index" >
        <div class="list-group container">
            <div class="list-group-item list-group-item-action list-group-item-warning"> 職缺名稱: {{ item.vacancy_Name }}  </div>
            <div class="list-group-item list-group-item-action list-group-item-warning"> 公司名稱: {{ item.company_Name }} </div>
            <div class="list-group-item list-group-item-action list-group-item-warning wordBreak"> 內容描述: {{ item.description }} </div>
            <div class="list-group-item list-group-item-action list-group-item-warning">
            <span>管理員審查意見: {{item.suggestion}} </span>
            </div>
            <div class="list-group-item list-group-item-action list-group-item-warning">
                <button class="btn btn-info" data-toggle="modal" data-target="#showCase" @click="showPage(item)"> 詳情 </button>
            </div>
        </div>
        <hr>
    </div>
    <modal id="modal-add-vacancy" class="modalform" name="modalVacancyAdd" transition="pop-out" :width="800" :height="widowHight08" :pivotX="0.5" :pivotY="0.3">
        <div class="modal-header">
          <h2>{{modalOption.title}}</h2>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModalAdd">
                        <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <span>公司名稱</span><input v-model="vacancyData.company_Name" placeholder="請輸入公司名稱" :readonly="modalOption.readonly">
          <span>公司網址</span><input v-model="vacancyData.company_Website" placeholder="請輸入公司網址" v-validate="'url'" name="url" :readonly="modalOption.readonly">
          <span v-show="errors.has('url')" class="validate-error-message">請輸入正確的網址</span>
          <span>職缺名稱</span><input v-model="vacancyData.vacancy_Name" placeholder="請輸入職缺名稱" :readonly="modalOption.readonly">
          <span>描述</span><textarea v-model="vacancyData.description" placeholder="請輸入職缺描述" :readonly="modalOption.readonly"></textarea>
          <span>工作待遇</span><input v-model="vacancyData.offer" placeholder="請輸入工作待遇" :readonly="modalOption.readonly">
          <span>上班地點</span><input v-model="vacancyData.location" placeholder="請輸入上班地點" :readonly="modalOption.readonly">
          <span>聯絡人</span><input v-model="vacancyData.contact_Name" placeholder="請輸入聯絡人" :readonly="modalOption.readonly">
          <span>E-mail</span><input v-model="vacancyData.contact_Mail" placeholder="請輸入聯絡E-mail" :readonly="modalOption.readonly">
          <span>連絡電話</span><input v-model="vacancyData.contact_Phone" placeholder="請輸入連絡電話" :readonly="modalOption.readonly">
          <span>方便聯絡時間</span><input v-model="vacancyData.contact_Time" placeholder="請輸入聯絡時間" :readonly="modalOption.readonly">
        </div>
        <div class="modal-footer">
        <div v-if="modalOption.status == 0">
          <button type="button" @click="modalOption.status = 2,modalOption.readonly = false">修改</button>
        </div>
        <div v-if="modalOption.status == 1">
          <button type="button" @click="addVacancyData" v-if="completeValidate()">新增</button>
          <button type="button" v-else class="disable">新增</button>
        </div>
        <div v-if="modalOption.status == 2">
          <button type="button" @click="updateVacancyData" v-if="completeValidate()">送出</button>
          <button type="button" v-else class="disable">不能送出</button>
        </div>
          <button type="button" @click="closeModalAdd">取消</button>
        </div>
    </modal>
  </div>
  
</template>

<script>
    import { mapState, mapGetters, mapActions } from 'vuex'
    import * as api from '../lib/api';
    export default {
        data () {
          return {
            widowHight08:window.innerHeight * 0.8,
            vacancyData:{
                company_Name:"",
                company_Website:"",
                vacancy_Name:"",
                description:"",
                offer:"",
                location:"",
                contact_Name:"",
                contact_Mail:"",
                contact_Phone:"",
                contact_Time:"",
            },
            modalOption:{
                get title(){
                    if(this.status == 0)
                        return "職缺詳情";
                    else if(this.status == 1)
                        return "新增職缺";
                    else
                        return "修改職缺";
                },
                readonly:false,
                status:0,//0:show, 1:insert , 2:update
            }
          }
        },
        components: {
        },
        created () {
            let self = this;
            this.action_vacance_get({Mem_Se:self.users.id}).then(function(){
                //self.website_sets = [...self.stateWebData.list];
            });
        },
        computed: {
            // ...mapGetters 為 ES7 寫法
            ...mapState(['stateVacanceData']),
            ...mapGetters({
                // getTodo return value 將會存在別名為 todos 的 webData 上
                users: 'getUser'
            })
        },
        methods: {
            ...mapActions([
  	            'action_vacancy_insert','action_vacance_get', 'action_vacancy_update'
  	        ]),
            addVacancy(){
                //this.modalOption.title = "新增職缺";
                this.modalOption.readonly = false;
                this.modalOption.status = 1;
                this.$modal.show("modalVacancyAdd");
            },
            closeModalAdd(){
                this.$modal.hide("modalVacancyAdd");
            },
            addVacancyData(){
                let self = this;
                self.action_vacancy_insert({data:self.vacancyData}).then(function(result){
                    if(result.code == 'success'){
                        alert('成功');
                    }
                    self.action_vacance_get({Mem_Se:self.users.id}).then(function(){
                    });
                });
                self.$modal.hide("modalVacancyAdd");
                self.vacancyData = {
                    company_Name:"",
                    company_Website:"",
                    vacancy_Name:"",
                    description:"",
                    offer:"",
                    location:"",
                    contact_Name:"",
                    contact_Mail:"",
                    contact_Phone:"",
                    contact_Time:"",
                }
            },
            updateVacancyData(){
                let self = this;
                self.action_vacancy_update({data:self.vacancyData}).then(function(result){
                    if(result.code == 'success'){
                        alert('成功');
                    }
                    self.action_vacance_get({Mem_Se:self.users.id}).then(function(){
                    });
                    self.$modal.hide("modalVacancyAdd");
                });
            },
            completeValidate() {
                if (this.errors.items.length > 0 || this.vacancyData.vacancy_Name == "") {
                    return false;
                } else {
                    return true;
                }
            },
            showPage(item){
                this.vacancyData = Object.assign({},item);
                //this.modalOption.title = "職缺詳情";
                this.modalOption.readonly = true;
                this.modalOption.status = 0;
                this.$modal.show("modalVacancyAdd");
            },
            liclick (e) { // stay dropdown open
                e.stopPropagation();
            },
            selectDropAll (title, isAll) { // 下拉式選單裡面的全選
                if(!isAll){
                    this.vacancyTypeName.filter(arr => {
                        if(arr.title === title){
                            this.vacancy_data.checked.filter((arr1, index) => { 
                                if(arr1.title === title){
                                    this.vacancy_data.checked[index].content = arr.content;
                                }
                            })
                        }
                    });
                }
                else{
                    this.vacancyTypeName.filter(arr => {
                        if(arr.title === title){
                            this.vacancy_data.checked.filter((arr1, index) => { 
                                if(arr1.title === title){
                                    this.vacancy_data.checked[index].content = [];
                                }
                            })
                        }
                    });
                }
            },
            toggleSkill (id) {
                var index = this.vacancy_data.skills.findIndex(arr => arr.id === id ); // 取出目前欄位的index 
                if(this.vacancy_data.skills[index].status){
                    this.vacancy_data.skills[index].status = false;  // 加號變減號
                    this.vacancy_data.skills = [...this.vacancy_data.skills, { // 新增一個陣列欄位，重新繪出視窗
                        'id':this.vacancy_data.skills[this.vacancy_data.skills.length-1].id + 1,
                        'status': true,
                        'value': ''
                        }];
                }
                else {
                    this.vacancy_data.skills = this.vacancy_data.skills.filter(arr => arr.id !== id); // 移除目前id的輸入視窗
                }
            },
            toggleLang (id) {
                var index = this.vacancy_data.language.findIndex(arr => arr.id === id ); // 取出目前欄位的index 
                if(this.vacancy_data.language[index].status){
                    this.vacancy_data.language[index].status = false;  // 加號變減號
                    this.vacancy_data.language = [...this.vacancy_data.language, { // 新增一個陣列欄位，重新繪出視窗
                        'id':this.vacancy_data.language[this.vacancy_data.language.length-1].id + 1,
                        'status': true,
                        'type': '',
                        'read': '',
                        'write': '',
                        'listen': '',
                        'speak': ''
                        }];
                }
                else {
                    this.vacancy_data.language = this.vacancy_data.language.filter(arr => arr.id !== id); // 移除目前id的輸入視窗
                }
            },
            isChecked () { // vacancyTypeName 欄位是否有填寫
                let count = 0
                this.vacancy_data.checked.map(arr => {
                    if(arr.content.length > 0)
                        count++
                })
                return count;
            },
            validateForm () {
                this.$validator.validateAll().then((result) => {
                    if (result && this.isChecked()) {
                        api.getData('/ee/api/api_vacancy.php', {
                            params: {
                                methods: 'insert',
                                data: this.vacancy_data
                            }
                        })
                        .then(function (user) {
                            console.log(user);
                            if(user.success)
                                alert(user.success);
                            else
                                alert(user.error);
                        })
                        .catch(function (error) {
                            alert(error);
                        })
                        return;
                    }
                    else
                        alert('Correct them errors!'); 
                })
            }
        }
    }
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip(); 
    });
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

    input:invalid {
        border-color: red;
    }
    textarea:invalid {
        border-color: red;
    }
    #modal-add-vacancy .modal-body{
        overflow-y: auto;
        max-height: calc(100% - 200px);
    }
    #modal-add-vacancy textarea{
        height:200px;
    } 

</style>