<template>
  <div>
      <div class="container">
        <b-card title="Card Title" no-body>
        <b-card-header header-tag="nav">
          <b-nav card-header tabs>
            <b-nav-item :active="selectType==1" @click="selectType=1,focusStatusChange(0)">職缺類({{stateVacanceData.totalCount}})</b-nav-item>
            <b-nav-item :active="selectType==2" @click="selectType=2,focusStatusChange(0)">專案類({{stateProjectData.totalCount}})</b-nav-item>
            <b-nav-item :active="selectType==3" @click="selectType=3,focusStatusChange(0)">網站類({{stateWebData.totalCount}})</b-nav-item>
          </b-nav>
        </b-card-header>

        <b-card-body class="text-left">
          <b-dropdown id="dropdown-1" :text="statusdesc[focusStatusType].text" variant="primary" class="mb-2">
            <b-dropdown-item v-for="status in statusdesc" @click="focusStatusChange(status.value)" :key="status.index">{{status.text}}</b-dropdown-item>
          </b-dropdown>
          <!-- tables -->
          <vacance-table v-if="selectType==1" :items="getterVacancyDataList" :auditable="true" :auditItem="auditItem"></vacance-table>
          <project-table v-if="selectType==2" :items="getterProjectDataList" :auditable="true" :auditItem="auditItem"></project-table>
          <web-table v-if="selectType==3" :items="getterWebDataList" :auditable="true" :auditItem="auditItem"></web-table>
        </b-card-body>
        </b-card>
        <b-modal
          id="modal-audit"
          :title="audit.modalTitle"
          @ok="auditItemOK"
        >
          <form ref="form" >
            <b-form-group
              label="管理員建議"
              label-for="suggestion-textarea"
            >
              <b-form-textarea
                id="suggestion-textarea"
                rows="5"
                placeholder="請輸入您的建議"
                v-model="audit.suggestion"
              ></b-form-textarea>
            </b-form-group>
            <b-form-group
              label="審核結果"
              label-for="audit-status"
            >
              <b-form-select 
                id="audit-status"
                v-model="audit.status"
                :options="statusdesc"
              ></b-form-select>
            </b-form-group>
          </form>
        </b-modal>        
      </div>
  </div>
</template>

<script>
    import {mapState, mapGetters, mapActions } from 'vuex';
    import * as api from '../lib/api';
    import DatePicker from 'vue2-datepicker' ;
    import ListType from '../job-query/ListType.vue';
    import ReviewList from './ReviewList.vue';
    import vacanceTable from '../tables/vacanceTable.vue'
    import projectTable from '../tables/projectTable.vue'
    import webTable from '../tables/webTable.vue'
    export default {
        components: {
          ListType,
          ReviewList,
          vacanceTable,
          projectTable,
          webTable
        },
        computed:{
          ...mapState(['stateProjectData','stateVacanceData','stateWebData']),
          ...mapGetters(['getterVacancyDataList','getterProjectDataList','getterWebDataList'])
        },
        created() {
          this.action_project_get({status:0});
          this.action_vacance_get({status:0});
          this.action_web_get({status:0});
        },
        data () {
          return {
            msg: '工作查詢',
            selectType:1,
            audit:{
              suggestion:'',
              status:0,
            },
            statusdesc:[
              {value:"0",text:'待審核'},
              {value:"1",text:'審核通過'},
              {value:"2",text:'審核不通過'},
              {value:"3",text:'隱藏'}
            ],
            focusStatusType:0,
            focusItem:{},
            modalTitle:{1:"審核職缺",2:"審核專案",3:"審核網站"}
          }
        },
        methods:{
          ...mapActions(['action_project_get','action_vacance_get','action_web_get','action_vacancy_comfirm','action_project_comfirm','action_web_comfirm']),
          auditItem(item){
              this.audit = {
                modalTitle:this.modalTitle[this.selectType],
                suggestion:item.suggestion,
                status:item.status,
              }
              this.focusItem = item;
              this.$bvModal.show('modal-audit');
          },
          auditItemOK(){
            let self = this;
            var param;
            switch(this.selectType){
              case 1 :
                param = {
                  'id': this.focusItem.id,
                  'suggestion': this.audit.suggestion,
                  'status': this.audit.status,
                  'creater': this.focusItem.M_Name,
                  'publisherId':this.focusItem.publisherId,
                  'vacancy_Name' : this.focusItem.vacancy_Name
                }
                self.action_vacancy_comfirm(param).then(function(result){
                    alert('成功');
                    self.action_vacance_get({status:self.focusStatusType});
                });
                break;
              case 2 :
                param = {
                  'id': this.focusItem.id,
                  'suggestion': this.audit.suggestion,
                  'status': this.audit.status,
                  'creater': this.focusItem.M_Name,
                  'publisherId':this.focusItem.publisherId,
                  'project_Name' : this.focusItem.project_Name
                }
                self.action_project_comfirm(param).then(function(result){
                    alert('成功');
                    self.action_project_get({status:self.focusStatusType});
                });
                break;
              case 3 :
                param = {
                  'id': this.focusItem.id,
                  'suggestion': this.audit.suggestion,
                  'status': this.audit.status,
                  'publisher':this.focusItem.publisher,
                  'publisherId':this.focusItem.publisherId,
                  'name':this.focusItem.name,
                  }
                self.action_web_comfirm(param).then(function(result){
                  alert('成功');
                  self.action_web_get({status:self.focusStatusType});
                });
                break;
            }
            
          },
          focusStatusChange(status){
              this.focusStatusType = status;
              switch(this.selectType){
              case 1 :
                  this.action_vacance_get({status:this.focusStatusType});
                break;
              case 2 :
                  this.action_project_get({status:this.focusStatusType});
                break;
              case 3 :
                  this.action_web_get({status:this.focusStatusType});
                break;
            }
          },
          datetimeFormat(milliseconds,formatStr='YYYY-mm-dd HH:mm:ss'){
            if(!milliseconds)
                return "";
            var d = new Date(milliseconds);
            if(formatStr=='YYYY-mm-dd HH:mm:ss'){
                return d.getFullYear() +"-"+ ((d.getMonth()+1 >9)?(d.getMonth()+1):"0"+(d.getMonth()+1))+"-"+((d.getDate() >9)?d.getDate():"0"+d.getDate())+" "+(d.getHours()>9?d.getHours():"0"+d.getHours())+":"+(d.getMinutes()>9?d.getMinutes():"0"+d.getMinutes())+":"+(d.getSeconds()>9?d.getSeconds():"0"+d.getSeconds());
            }else{
                return d.getFullYear() +"-"+ ((d.getMonth()+1 >9)?(d.getMonth()+1):"0"+(d.getMonth()+1))+"-"+((d.getDate() >9)?d.getDate():"0"+d.getDate());
            }
          },
        }
    }
</script>

<style>

</style>