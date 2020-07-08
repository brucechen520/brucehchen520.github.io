<template>
  <div>
    <div class="container">
      <h1>我的網站</h1>
      <b-button variant="success" @click="addWeb" class="mb-2">新增網站</b-button>
      <web-table :items="getterWebDataList" :editable="true" :editItem="editWeb" :deleteItem="deleteItem"></web-table>
    </div>

    <modal id="modal-addweb" class="modalform" name="modalWebAdd" transition="pop-out" width="90%" :height="widowHight08" :pivotX="0.5" :pivotY="0.5">
      <div class="modal-header">
        <h2>{{modalOption.title}}</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModalAdd">
                      <span aria-hidden="true">×</span>
        </button>
      </div>
      <ValidationObserver v-slot="{ valid }">
      <div class="modal-body">
        <b-form-group label="名稱:" label-for="input-name" label-cols=2>
            <ValidationProvider rules="required" v-slot="{ valid, errors }">
            <b-form-input id="input-name" :state="valid" v-model="webAddData.name" type="text" placeholder="請輸入網站名稱"></b-form-input>
            <b-form-invalid-feedback :state="valid">
                {{ errors[0] }}
            </b-form-invalid-feedback>
            </ValidationProvider>
        </b-form-group>
        <b-form-group label="網址:" label-for="input-address" label-cols=2>
            <b-row><b-col cols=3><b-form-select v-model="webAddData.urlType" :options="urlTypes"></b-form-select></b-col>
            <b-col><ValidationProvider rules="required" v-slot="{ valid, errors }">
            <b-form-input id="input-address" :state="valid" v-model="webAddData.urlShort" type="text" placeholder="請輸入完整網站網址"></b-form-input>
            <b-form-invalid-feedback :state="valid">
                {{ errors[0] }}
            </b-form-invalid-feedback>
            </ValidationProvider>
            </b-col></b-row>
        </b-form-group>
        <b-form-group label="是否公開:" label-for="input-2" label-cols=2>
            <b-form-select v-model="webAddData.permit" :options="permitOption"></b-form-select>
        </b-form-group>
        <b-form-group label="類別:" label-for="input-2" label-cols=2>
            <b-form-select v-model="webAddData.type" :options="website_type"></b-form-select>
        </b-form-group>
        <b-form-group label="敘述:" label-for="input-description" label-cols=2>
                <ValidationProvider rules="required" v-slot="{ valid, errors }">
                <b-form-textarea id="input-description" :state="valid" placeholder="請輸入網站敘述" rows="8" v-model="webAddData.description"></b-form-textarea>
                <b-form-invalid-feedback :state="valid">
                    {{ errors[0] }}
                </b-form-invalid-feedback>
                </ValidationProvider>
            </b-form-group>
        <!-- <span>名稱</span><input v-model="webAddData.name" placeholder="請輸入網站名稱">
        <span>網址</span><input v-model="webAddData.address" placeholder="請輸入完整網站網址">
        <span>是否公開</span>
        <select v-model="webAddData.permit">
          <option v-for="item,index in permitList" :value="index">{{ item }}</option>
        </select>
        
        <span>類別</span>
        <select v-model="webAddData.type">
          <option  v-for="item in website_type" :value="item">{{ item }}</option>
        </select>
        
        <span>敘述</span><textarea v-model="webAddData.description" placeholder="請輸入網站敘述"></textarea> -->
      </div>
      <div class="modal-footer">
        <div v-if="modalOption.status == 2">
          <button type="button" @click="updateWebData" v-if="valid">送出</button>
          <button type="button" v-else class="disable">不能送出</button>
        </div>
        <div v-if="modalOption.status == 1">
        <button type="button" @click="addWebData" v-if="valid">新增</button>
        <button type="button" v-else class="disable">新增</button>
        </div>
        <button type="button" @click="closeModalAdd">取消</button>
      </div>
      </ValidationObserver>
  </modal>
  <b-modal id="delete-check-modal" centered danger title="刪除網站" @ok="deleteWeb">
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
    import { mapState, mapGetters, mapActions } from 'vuex';
    import webTable from '../tables/webTable.vue'
    import * as api from '../lib/api';
    export default {
        components: {
            webTable,
        },
        data () {
          return {
            widowHight08:window.innerHeight * 0.8,
            website_type: [
              'personal',
              'company',
              'github',
              'others'
            ],
            permitList:{
              0:'完全公開',
              1:'僅系友公開',
              2:'不公開'
            },
            permitOption: [
              { value:0, text:'完全公開'},
              { value:1, text:'僅系友公開'},
              { value:2, text:'不公開'},        
            ],
            website_sets: [{
                id: Number(1),
                type: '',
                name: '',
                wName: '',
                url: '',
                urlType:'http://',
                description: ''
              }],
            webAddData:{
              name:'',
              url:'',
              urlType:'http://',
              permit:'0',
              type:'personal',
              description:'',
            },
            modalOption:{
                get title(){
                    if(this.status == 0)
                        return "專案詳情";
                    else if(this.status == 1)
                        return "新增網站";
                    else
                        return "修改網站";
                },
                readonly:false,
                status:1,//0:show, 1:insert , 2:update
            },
            urlTypes:[
              { value:'http://', text:'http'},
              { value:'https://', text:'https'},
            ],
          }
        },
        created () {
            let self = this;
            if(self.users.id)
              this.action_web_get({Mem_Se:self.users.id});
        },
        computed: {
          ...mapState(['stateProjectData','stateVacanceData','stateWebData','userInfo']),
          completeValidate() {
            if (this.webAddData.name === "") {
                return false;
            } else {
                return true;
            }
          },
          // ...mapGetters 為 ES7 寫法
          ...mapGetters({users: 'getUser',getterWebDataList:'getterWebDataList'})
        },
        watch:{
          users : function(user){
            this.action_web_get({Mem_Se:user.id});
          }
        },
        methods: {
          ...mapActions([
  	      'action_project_get','action_vacance_get','action_set_review_type','action_web_get','action_web_insert','action_web_update',,'action_web_delete',
          ]),
          datetimeFormat(milliseconds,formatStr='YYYY-mm-dd HH:mm:ss'){
                if(!milliseconds)
                    return "未發布";
                var d = new Date(milliseconds*1000);
                if(formatStr=='YYYY-mm-dd HH:mm:ss'){
                    return d.getFullYear() +"-"+ ((d.getMonth()+1 >9)?(d.getMonth()+1):"0"+(d.getMonth()+1))+"-"+((d.getDate() >9)?d.getDate():"0"+d.getDate())+" "+(d.getHours()>9?d.getHours():"0"+d.getHours())+":"+(d.getMinutes()>9?d.getMinutes():"0"+d.getMinutes())+":"+(d.getSeconds()>9?d.getSeconds():"0"+d.getSeconds());
                }else{
                    return d.getFullYear() +"-"+ ((d.getMonth()+1 >9)?(d.getMonth()+1):"0"+(d.getMonth()+1))+"-"+((d.getDate() >9)?d.getDate():"0"+d.getDate());
                }
          },
          addWeb(){
            this.modalOption.status = 1;
            this.$modal.show("modalWebAdd");
          },
          editWeb(webData){
            this.webAddData = Object.assign({},webData);
            this.modalOption.readonly = false;
            this.modalOption.status = 2;
            this.$modal.show("modalWebAdd");
          },
          deleteItem(item){
            this.webAddData = item;
            this.$bvModal.show('delete-check-modal');
          },
          deleteWeb(){
            let self = this;
            self.action_web_delete({data:{id:self.webAddData.id}}).then(function(result){
                if(result.code == 'success'){
                    self.alertModal("已刪除");
                }
                self.$modal.hide("checkModal");
                self.action_web_get({Mem_Se:self.users.id});
            });
          },
          clearWebData(){
              let self = this;
              self.webAddData = {
                name:'',
                url:'',
                urlType:'http://',
                permit:'0',
                type:'personal',
                description:'',
              }
          },
          closeModalAdd(){
            this.$modal.hide("modalWebAdd");
          },
          addWebData(){
            let self = this;
            self.action_web_insert({data:self.webAddData}).then(function(result){
              if(result.code == 'success'){
                  self.alertModal("發佈成功，需等管理員審核後，方可顯示供大家查詢！審核結果會email通知您。");
              }
              self.action_web_get({Mem_Se:self.users.id});
            });
            self.$modal.hide("modalWebAdd");
            self.webAddData = {
              name:'',
                url:'',
                urlType:'http://',
                permit:'0',
                type:'personal',
                description:'',
            }
          },
          updateWebData(){
            let self = this;
            self.action_web_update({data:self.webAddData}).then(function(result){
                if(result.code == 'success'){
                    self.alertModal("修改成功，需等管理員審核後，方可顯示供大家查詢！審核結果會email通知您。");
                }
                console.log(self);
                self.action_web_get({Mem_Se:self.users.id}).then(function(){
                });
                self.$modal.hide("modalWebAdd");
            });
          }
        }
    }
</script>

<style>
    .content {
      border: 2px solid;
      padding: 20px; 
      width: 300px;
      resize: both;
      overflow: auto;
    }
    .is-info {
      background-color: #3273dc;
      border-width: 0;
      color: #fff;
    }
    .is-disabled {
      pointer-events: none;
    }
    #modal-addweb .modal-body{
        overflow-y: auto;
        max-height: calc(100% - 200px);
    }
</style>