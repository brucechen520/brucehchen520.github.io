<template>
  <div class="container">
    <h1>我的職缺</h1>
    <b-button variant="success" @click="addVacancy" class="mb-2">新增職缺</b-button>
    <b-table striped hover outlined :fields="vacancyFields" :items="stateVacanceData.list">
          <template v-slot:cell(id)="row">{{row.index +1 }}</template>
          <template v-slot:cell(name)="row">
            <b-link :href="row.item.address" target="_blank">{{ row.item.name }}</b-link>
          </template>
          <template v-slot:cell(詳情)="row">
            <b-button size="sm" @click="row.toggleDetails" class="mr-2">
              {{ row.detailsShowing ? '縮小' : '詳情'}}
            </b-button>
          </template>
          <template v-slot:row-details="row">
          <b-card>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>序號:</b></b-col>
              <b-col>{{ row.item.id }}</b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>職缺內容描述:</b></b-col>
              <b-col>{{ row.item.description }}</b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>工作待遇:</b></b-col>
              <b-col>{{ row.item.offer }}</b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>上班地點:</b></b-col>
              <b-col>{{row.item.location}}</b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>公司網址:</b></b-col>
              <b-col><b-link :href="row.item.company_Website" target="_blank">{{ row.item.company_Website }}</b-link></b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>聯絡人:</b></b-col>
              <b-col>{{ row.item.contact_Name }}</b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>E-mail:</b></b-col>
              <b-col>{{ row.item.contact_Mail }}</b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>連絡電話:</b></b-col>
              <b-col>{{ row.item.contact_Phone }}</b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>方便聯絡時間:</b></b-col>
              <b-col>{{ row.item.contact_Time }}</b-col>
            </b-row>
            <b-row class="mb-1">
            <b-col sm="2" class=""><b>管理員建議:</b></b-col>
            <b-col>{{ row.item.suggestion}}</b-col>
          </b-row>
            <b-button size="sm" variant="warning" @click="editVacancy(row.item)">修改</b-button>
            <b-button size="sm" variant="danger" v-b-modal.delete-check-modal @click="deleteId = row.item.id">刪除</b-button>
            <b-button size="sm" @click="row.toggleDetails">縮小</b-button>
          </b-card>
        </template>
        </b-table>

    <!-- <div v-for="(item, index) in stateVacanceData.list" :key="index" >
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
    </div> -->
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
    <b-modal id="delete-check-modal" centered danger title="刪除職缺" @ok="deleteVacancy">
      <p class="my-4">刪除後無法復原，確定刪除?</p>
      <template v-slot:modal-footer="{ ok, cancel }">
      <b-button size="sm" variant="danger" @click="ok()">
        刪除
      </b-button>
      <b-button size="sm" @click="cancel()">
        取消
      </b-button>
    </template>
    </b-modal>
  </div>
  
</template>

<script>
    import { mapState, mapGetters, mapActions } from 'vuex'
    export default {
        data () {
          return {
            vacancyFields: [
              {key: 'id', label: 'NO'},
              {key: 'vacancy_Name', label: '職缺名稱'},
              {key: 'company_Name', label: '公司名稱'},
              {key: 'M_Name', label: '發布人'},
              {key: 'verifyTime', label: '發布日期'},
              {key: 'status', label: '狀態',formatter: e => this.statusdesc[e]},
              '詳情',
            ],
            statusdesc:["待審核","審核通過","審核不通過","已封存"],
            deleteId:'',
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
            this.action_vacance_get({Mem_Se:this.users.id});
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
  	            'action_vacancy_insert','action_vacance_get', 'action_vacancy_update', 'action_vacancy_delete'
  	        ]),
            addVacancy(){
                //this.modalOption.title = "新增職缺";
                this.modalOption.readonly = false;
                this.modalOption.status = 1;
                this.$modal.show("modalVacancyAdd");
            },
            closeModalAdd(){
                this.$modal.hide("modalVacancyAdd");
                if(this.modalOption.status != 1)
                    this.clearVacancyData();
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
                self.clearVacancyData();

            },
            clearVacancyData(){
                let self = this;
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
            editVacancy(item){
                this.vacancyData = Object.assign({},item);
                this.modalOption.readonly = false;
                this.modalOption.status = 2;
                this.$modal.show("modalVacancyAdd");
            },
            deleteVacancy(){
                let self = this;
                self.action_vacancy_delete({data:{id:self.deleteId}}).then(function(result){
                    if(result.code == 'success'){
                        alert('成功');
                    }
                    self.$modal.hide("modalVacancyAdd");
                    self.action_vacance_get({Mem_Se:self.users.id});
                    self.clearVacancyData();
                });
            },
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