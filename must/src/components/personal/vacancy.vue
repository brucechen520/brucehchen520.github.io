<template>
  <div class="container">
    <h1>我的職缺</h1>
    <b-button variant="success" @click="addVacancy" class="mb-2">新增職缺</b-button>
    <vacance-table :items="getterVacancyDataList" :editable="true" :editItem="editVacancy" :deleteItem="deleteItem"></vacance-table>
    <modal id="modal-add-vacancy" class="modalform" name="modalVacancyAdd" transition="pop-out" :width="800" :height="widowHight08" :pivotX="0.5" :pivotY="0.5">
        <div class="modal-header">
          <h2>{{modalOption.title}}</h2>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModalAdd">
                <span aria-hidden="true">×</span>
          </button>
        </div>
        <ValidationObserver v-slot="{ valid }">
        <div class="modal-body">
            <b-form-group label="公司名稱:" label-for="input-company_Name" label-cols=2>
                <b-form-input id="input-company_Name" v-model="vacancyData.company_Name" type="text" placeholder="請輸入公司名稱"></b-form-input>
            </b-form-group>
            <b-form-group label="公司網址:" label-for="input-company_Website" label-cols=2>
                <b-form-input id="input-company_Website" v-model="vacancyData.company_Website" type="text" placeholder="請輸入公司網址"></b-form-input>
            </b-form-group>
            <b-form-group label="職缺名稱:" label-for="input-vacancy_Name" label-cols=2>
                <ValidationProvider rules="required" v-slot="{ valid, errors }">
                <b-form-input id="input-vacancy_Name" :state="valid" v-model="vacancyData.vacancy_Name" type="text" placeholder="請輸入職缺名稱"></b-form-input>
                <b-form-invalid-feedback :state="valid">
                    {{ errors[0] }}
                </b-form-invalid-feedback>
                </ValidationProvider>
            </b-form-group>
            <b-form-group label="描述:" label-for="input-biography" label-cols=2>
                <ValidationProvider rules="required" v-slot="{ valid, errors }">
                <b-form-textarea id="input-biography" :state="valid" placeholder="請輸入職缺描述" rows="8" v-model="vacancyData.description"></b-form-textarea>
                <b-form-invalid-feedback :state="valid">
                    {{ errors[0] }}
                </b-form-invalid-feedback>
                </ValidationProvider>
            </b-form-group>
            <b-form-group label="工作待遇:" label-for="input-offer" label-cols=2>
                <b-form-input id="input-offer" v-model="vacancyData.offer" type="text" placeholder="請輸入工作待遇"></b-form-input>
            </b-form-group>
            <b-form-group label="上班地點:" label-for="input-location" label-cols=2>
                <b-form-input id="input-location" v-model="vacancyData.location" type="text" placeholder="請輸入上班地點"></b-form-input>
            </b-form-group>
            <b-form-group label="聯絡人:" label-for="input-contact_Name" label-cols=2>
                <ValidationProvider rules="required" v-slot="{ valid, errors }">
                <b-form-input id="input-contact_Name" :state="valid" v-model="vacancyData.contact_Name" type="text" placeholder="請輸入聯絡人"></b-form-input>
                <b-form-invalid-feedback :state="valid">
                    {{ errors[0] }}
                </b-form-invalid-feedback>
                </ValidationProvider>
            </b-form-group>
            <b-form-group label="E-mail:" label-for="input-contact_Mail" label-cols=2>
                <ValidationProvider rules="required" v-slot="{ valid, errors }">
                <b-form-input id="input-contact_Mail" :state="valid" v-model="vacancyData.contact_Mail" type="text" placeholder="請輸入聯絡E-mail"></b-form-input>
                <b-form-invalid-feedback :state="valid">
                    {{ errors[0] }}
                </b-form-invalid-feedback>
                </ValidationProvider>
            </b-form-group>
            <b-form-group label="連絡電話:" label-for="input-contact_Phone" label-cols=2>
                <ValidationProvider rules="required" v-slot="{ valid, errors }">
                <b-form-input id="input-contact_Phone" :state="valid" v-model="vacancyData.contact_Phone" type="text" placeholder="請輸入連絡電話"></b-form-input>
                <b-form-invalid-feedback :state="valid">
                    {{ errors[0] }}
                </b-form-invalid-feedback>
                </ValidationProvider>
            </b-form-group>
            <b-form-group label="方便聯絡時間:" label-for="input-contact_Time" label-cols=2>
                <ValidationProvider rules="required" v-slot="{ valid, errors }">
                <b-form-input id="input-contact_Time" :state="valid" v-model="vacancyData.contact_Time" type="text" placeholder="請輸入聯絡時間"></b-form-input>
                <b-form-invalid-feedback :state="valid">
                    {{ errors[0] }}
                </b-form-invalid-feedback>
                </ValidationProvider>
            </b-form-group>
          <!-- <span>公司名稱</span><input v-model="vacancyData.company_Name" placeholder="請輸入公司名稱" :readonly="modalOption.readonly">
          <span>公司網址</span><input v-model="vacancyData.company_Website" placeholder="請輸入公司網址" name="url" :readonly="modalOption.readonly">
          <span>職缺名稱</span><input v-model="vacancyData.vacancy_Name" placeholder="請輸入職缺名稱" :readonly="modalOption.readonly">
          <span>描述</span><textarea v-model="vacancyData.description" placeholder="請輸入職缺描述" :readonly="modalOption.readonly"></textarea>
          <span>工作待遇</span><input v-model="vacancyData.offer" placeholder="請輸入工作待遇" :readonly="modalOption.readonly">
          <span>上班地點</span><input v-model="vacancyData.location" placeholder="請輸入上班地點" :readonly="modalOption.readonly">
          <span>聯絡人</span><input v-model="vacancyData.contact_Name" placeholder="請輸入聯絡人" :readonly="modalOption.readonly">
          <span>E-mail</span><input v-model="vacancyData.contact_Mail" placeholder="請輸入聯絡E-mail" :readonly="modalOption.readonly">
          <span>連絡電話</span><input v-model="vacancyData.contact_Phone" placeholder="請輸入連絡電話" :readonly="modalOption.readonly">
          <span>方便聯絡時間</span><input v-model="vacancyData.contact_Time" placeholder="請輸入聯絡時間" :readonly="modalOption.readonly"> -->
        </div>
        <div class="modal-footer">
        <div v-if="modalOption.status == 0">
          <button type="button" @click="modalOption.status = 2,modalOption.readonly = false">修改</button>
        </div>
        <div v-if="modalOption.status == 1">
          <button type="button" @click="addVacancyData" v-if="valid">新增</button>
          <button type="button" v-else class="disable">新增</button>
        </div>
        <div v-if="modalOption.status == 2">
          <button type="button" @click="updateVacancyData" v-if="valid">送出</button>
          <button type="button" v-else class="disable">不能送出</button>
        </div>
          <button type="button" @click="closeModalAdd">取消</button>
        </div>
        </ValidationObserver>
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
    import vacanceTable from '../tables/vacanceTable.vue'
    export default {
        components: {
          vacanceTable,
        },
        data () {
          return {
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
                contact_Time:"任何時間",
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
        created () {
          let self = this;
            if(self.users.id)
              this.action_vacance_get({Mem_Se:self.users.id});
        },
        computed: {
            // ...mapGetters 為 ES7 寫法
            ...mapState(['stateVacanceData']),
            ...mapGetters({
                users: 'getUser',getterVacancyDataList:'getterVacancyDataList'
            })
        },
        watch:{
          users : function(user){
            this.action_vacance_get({Mem_Se:user.id});
          }
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
                        self.alertModal("發佈成功，需等管理員審核後，方可顯示供大家查詢！審核結果會email通知您。");
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
                    contact_Time:"任何時間",
                }
            },
            updateVacancyData(){
                let self = this;
                self.action_vacancy_update({data:self.vacancyData}).then(function(result){
                    if(result.code == 'success'){
                        self.alertModal("修改成功，需等管理員審核後，方可顯示供大家查詢！審核結果會email通知您。");
                    }
                    self.action_vacance_get({Mem_Se:self.users.id}).then(function(){
                    });
                    self.$modal.hide("modalVacancyAdd");
                });
            },
            completeValidate() {
                if (this.vacancyData.vacancy_Name == "") {
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
            deleteItem(item){
                this.vacancyData = item;
                this.$bvModal.show('delete-check-modal');
            },
            deleteVacancy(){
                let self = this;
                self.action_vacancy_delete({data:{id:self.vacancyData.id}}).then(function(result){
                    if(result.code == 'success'){
                        self.alertModal("已刪除");
                    }
                    self.$modal.hide("modalVacancyAdd");
                    self.action_vacance_get({Mem_Se:self.users.id});
                    self.clearVacancyData();
                });
            },

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