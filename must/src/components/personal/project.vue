<template>
  <div class="container">
    <h1>我的專案</h1>
    <b-button variant="success" @click="addProject" class="mb-2">新增專案</b-button>
    <project-table :items="getterProjectDataList" :editable="true" :editItem="editProject" :deleteItem="deleteItem"></project-table>
    <modal id="modal-add-project" class="modalform" name="modalProject" transition="pop-out" :width="800" :height="widowHight08" :pivotX="0.5" :pivotY="0.5">
        <div class="modal-header">
          <h2>{{modalOption.title}}</h2>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModalAdd">
                        <span aria-hidden="true">×</span>
          </button>
        </div>
        <ValidationObserver v-slot="{ valid }">
        <div class="modal-body">
                        <b-form-group label="公司名稱:" label-for="input-company_Name" label-cols=2>
                <b-form-input id="input-company_Name" v-model="projectData.company_Name" type="text" placeholder="請輸入公司名稱"></b-form-input>
            </b-form-group>
            <b-form-group label="公司網址:" label-for="input-company_Website" label-cols=2>
                <b-form-input id="input-company_Website" v-model="projectData.company_Website" type="text" placeholder="請輸入公司網址"></b-form-input>
            </b-form-group>
            <b-form-group label="案件名稱:" label-for="input-project_Name" label-cols=2>
                <ValidationProvider rules="required" v-slot="{ valid, errors }">
                <b-form-input id="input-project_Name" :state="valid" v-model="projectData.project_Name" type="text" placeholder="請輸入案件名稱"></b-form-input>
                <b-form-invalid-feedback :state="valid">
                    {{ errors[0] }}
                </b-form-invalid-feedback>
                </ValidationProvider>
            </b-form-group>
            <b-form-group label="描述:" label-for="input-biography" label-cols=2>
                <ValidationProvider rules="required" v-slot="{ valid, errors }">
                <b-form-textarea id="input-biography" :state="valid" placeholder="請輸入職缺描述" rows="8" v-model="projectData.description"></b-form-textarea>
                <b-form-invalid-feedback :state="valid">
                    {{ errors[0] }}
                </b-form-invalid-feedback>
                </ValidationProvider>
            </b-form-group>
            <b-form-group label="案件預算:" label-for="input-offer" label-cols=2>
                <b-form-input id="input-offer" v-model="projectData.offer" type="text" placeholder="請輸入案件預算"></b-form-input>
            </b-form-group>
            <b-form-group label="專案截止期限:" label-for="input-deadline" label-cols=2>
                <date-picker id="input-deadline" v-model="projectData.deadline" :time-picker-options="timePickerOptions" value-type="timestamp" :not-before="new Date()" >{{projectData.deadline}}</date-picker>
            </b-form-group>
            <b-form-group label="聯絡人:" label-for="input-contact_Name" label-cols=2>
                <ValidationProvider rules="required" v-slot="{ valid, errors }">
                <b-form-input id="input-contact_Name" :state="valid" v-model="projectData.contact_Name" type="text" placeholder="請輸入聯絡人"></b-form-input>
                <b-form-invalid-feedback :state="valid">
                    {{ errors[0] }}
                </b-form-invalid-feedback>
                </ValidationProvider>
            </b-form-group>
            <b-form-group label="E-mail:" label-for="input-contact_Mail" label-cols=2>
                <ValidationProvider rules="required" v-slot="{ valid, errors }">
                <b-form-input id="input-contact_Mail" :state="valid" v-model="projectData.contact_Mail" type="text" placeholder="請輸入聯絡E-mail"></b-form-input>
                <b-form-invalid-feedback :state="valid">
                    {{ errors[0] }}
                </b-form-invalid-feedback>
                </ValidationProvider>
            </b-form-group>
            <b-form-group label="連絡電話:" label-for="input-contact_Phone" label-cols=2>
                <ValidationProvider rules="required" v-slot="{ valid, errors }">
                <b-form-input id="input-contact_Phone" :state="valid" v-model="projectData.contact_Phone" type="text" placeholder="請輸入連絡電話"></b-form-input>
                <b-form-invalid-feedback :state="valid">
                    {{ errors[0] }}
                </b-form-invalid-feedback>
                </ValidationProvider>
            </b-form-group>
            <b-form-group label="方便聯絡時間:" label-for="input-contact_Time" label-cols=2>
                <ValidationProvider rules="required" v-slot="{ valid, errors }">
                <b-form-input id="input-contact_Time" :state="valid" v-model="projectData.contact_Time" type="text" placeholder="請輸入聯絡時間"></b-form-input>
                <b-form-invalid-feedback :state="valid">
                    {{ errors[0] }}
                </b-form-invalid-feedback>
                </ValidationProvider>
            </b-form-group>
          <!-- <span>公司名稱</span><input v-model="projectData.company_Name" placeholder="請輸入公司名稱" :readonly="modalOption.readonly">
          <span>公司網址</span><input v-model="projectData.company_Website" placeholder="請輸入公司網址" v-validate="'url'" name="url" :readonly="modalOption.readonly">
          <span>案件名稱</span><input v-model="projectData.project_Name" placeholder="請輸入案件名稱" :readonly="modalOption.readonly">
          <span>描述</span><textarea v-model="projectData.description" placeholder="請輸入專案描述" :readonly="modalOption.readonly"></textarea>
          <span>案件預算</span><input v-model="projectData.offer" placeholder="請輸入工作待遇" :readonly="modalOption.readonly">
          <span>專案截止期限</span><br>
          <date-picker v-model="projectData.deadline" :time-picker-options="timePickerOptions" value-type="timestamp" :not-before="new Date()" >{{projectData.deadline}}</date-picker><br>
          <span>聯絡人</span><input v-model="projectData.contact_Name" placeholder="請輸入聯絡人" :readonly="modalOption.readonly">
          <span>E-mail</span><input v-model="projectData.contact_Mail" placeholder="請輸入聯絡E-mail" :readonly="modalOption.readonly">
          <span>連絡電話</span><input v-model="projectData.contact_Phone" placeholder="請輸入連絡電話" :readonly="modalOption.readonly">
          <span>方便聯絡時間</span><input v-model="projectData.contact_Time" placeholder="請輸入聯絡時間" :readonly="modalOption.readonly"> -->
        </div>
        <div class="modal-footer">
        <div v-if="modalOption.status == 0">
          <button type="button" @click="modalOption.status = 2,modalOption.readonly = false">修改</button>
        </div>
        <div v-if="modalOption.status == 1">
          <button type="button" @click="addProjectData" v-if="valid">新增</button>
          <button type="button" v-else class="disable">新增</button>
        </div>
        <div v-if="modalOption.status == 2">
          <button type="button" @click="updateProjectData" v-if="valid">送出</button>
          <button type="button" v-else class="disable">不能送出</button>
        </div>
          <button type="button" @click="closeModalAdd">取消</button>
        </div>
        </ValidationObserver>
    </modal>
    <b-modal id="delete-check-modal" centered danger title="刪除專案" @ok="deleteProject">
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
    import DatePicker from 'vue2-datepicker'
    import projectTable from '../tables/projectTable.vue'
    export default {
        components: {
            DatePicker,
            projectTable
        },
        data () {
          return {
            widowHight08:window.innerHeight * 0.8,
            projectData:{
                company_Name:"",
                company_Website:"",
                project_Name:"",
                description:"",
                offer:"",
                deadline:"",
                contact_Name:"",
                contact_Mail:"",
                contact_Phone:"",
                contact_Time:"任何時間",
            },
            modalOption:{
                get title(){
                    if(this.status == 0)
                        return "專案詳情";
                    else if(this.status == 1)
                        return "新增專案";
                    else
                        return "修改專案";
                },
                readonly:false,
                status:0,//0:show, 1:insert , 2:update
            },
            // custom range shortcuts
            timePickerOptions:{
                start: '00:00',
                step: '00:30',
                end: '23:30'
            },
          }
        },
        created () {
            let self = this;
            if(self.users.id)
              this.action_project_get({Mem_Se:self.users.id});
        },
        computed: {
            // ...mapGetters 為 ES7 寫法
            ...mapState(['stateProjectData']),
            ...mapGetters({
                // getTodo return value 將會存在別名為 todos 的 webData 上
                users: 'getUser',
                getterProjectDataList:'getterProjectDataList'
            })
        },
        watch:{
          users : function(user){
            this.action_project_get({Mem_Se:user.id});
          }
        },
        methods: {
            ...mapActions([
  	            'action_project_insert','action_project_get', 'action_project_update', 'action_project_delete'
  	        ]),
            addProject(){
                this.modalOption.readonly = false;
                this.modalOption.status = 1;
                this.$modal.show("modalProject");
            },
            closeModalAdd(){
                this.$modal.hide("modalProject");
                if(this.modalOption.status != 1)
                    this.clearProjectData();
            },
            addProjectData(){
                let self = this;
                self.action_project_insert({data:self.projectData}).then(function(result){
                    if(result.code == 'success'){
                        alert('成功');
                    }
                    self.action_project_get({Mem_Se:self.users.id}).then(function(){
                    });
                });
                self.$modal.hide("modalProject");
                self.clearProjectData();

            },
            editProject(item){
                this.projectData = Object.assign({},item);
                this.modalOption.readonly = false;
                this.modalOption.status = 2;
                this.$modal.show("modalProject");
            },
            completeValidate() {
                if (this.projectData.project_Name == "") {
                    return false;
                } else {
                    return true;
                }
            },
            detail(item){
                this.projectData = Object.assign({},item);
                //this.modalOption.title = "專案詳情";
                this.modalOption.readonly = true;
                this.modalOption.status = 0;
                this.$modal.show("modalProject");
            },
            clearProjectData(){
                let self = this;
                self.projectData = {
                    company_Name:"",
                    company_Website:"",
                    project_Name:"",
                    description:"",
                    offer:"",
                    deadline:"",
                    contact_Name:"",
                    contact_Mail:"",
                    contact_Phone:"",
                    contact_Time:"任何時間",
                }
            },
            deleteItem(item){
                this.projectData = item;
                this.$bvModal.show('delete-check-modal');
            },
            deleteProject(){
                let self = this;
                self.action_project_delete({data:{id:self.projectData.id}}).then(function(result){
                    if(result.code == 'success'){
                        alert('成功');
                    }
                    self.$modal.hide("modalProject");
                    self.action_project_get({Mem_Se:self.users.id});
                    self.clearProjectData();
                });
            },
            updateProjectData(){
                let self = this;
                self.action_project_update({data:self.projectData}).then(function(result){
                    if(result.code == 'success'){
                        alert('成功');
                    }
                    self.action_project_get({Mem_Se:self.users.id}).then(function(){
                    });
                    self.$modal.hide("modalProject");
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
    #modal-add-project .modal-body{
        overflow-y: auto;
        max-height: calc(100% - 200px);
    }
    #modal-add-project textarea{
        height:200px;
    } 
</style>