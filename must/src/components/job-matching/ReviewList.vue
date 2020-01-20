<template>
  <div>
      <div v-if="stateReviewType === 0">
        <h3 class="mt-0 header"> 專案列表審核 </h3>
      </div>
      <div v-else-if="stateReviewType === 1">
        <h3 class="mt-0 header"> 職缺列表審核 </h3>
      </div>
      <div v-else >
        <h3 class="mt-0 header"> 網站列表審核 </h3>
      </div>
      <div v-if = "stateReviewType ==0"> <!-- selected: 0 -> project_data, 1 -> vacancy_data   -->
        <div v-for="(item, index) in stateProjectData.list">
            <div class="list-group container">
              <div class="list-group-item list-group-item-action list-group-item-warning"> 專案名稱: {{ item.Name }}  </div>
              <div class="list-group-item list-group-item-action list-group-item-warning"> 公司名稱: {{ item.company_Name }} </div>
              <div class="list-group-item list-group-item-action list-group-item-warning wordBreak"> 內容描述: {{ item.description }} </div>
              <div class="list-group-item list-group-item-action list-group-item-warning">
                <span>管理員審查意見: </span>
                <div :class="[isShow? 'show': 'hidden']">
                             {{ item.suggestion }}</div>
                <textarea class="list-group-item list-group-item-action list-group-item-secondary"
                          :class="[isShow? 'hidden': 'show']"
                          v-model = "item.suggestion" > 
                             {{ item.suggestion }} </textarea>
                <button @click="changeShow" class="btn btn-info">{{ isShow? "編輯": "完成" }}</button>
              </div>
              <div class="list-group-item list-group-item-action list-group-item-warning">
                  <button class="btn btn-info" data-toggle="modal" data-target="#showCase" @click="showPage(item)"> 詳情 </button>
                  <select v-model="item.examined">
                    <option v-for="isPass in passOrNoPass" :value="isPass.value">{{ isPass.msg }}</option>
                  </select>
                  <!-- <button class="btn btn-info" @click="update({'data': {'id': getJob.selected === 0? item.PJ_Id : item.JB_Id, 'suggestion': item.suggestion, 'examined': item.examined}})"> 送出 </button>  -->
                  <button class="btn btn-info" @click="update({'id': stateReviewType === 0? item.PJ_Id : item.JB_Id, 'suggestion': item.suggestion, 'examined': item.examined})"> 送出 </button> 
              </div>
            </div>
            <hr>
        </div>
      </div>
      <div v-if = "stateReviewType == 1"> <!-- selected: 0 -> project_data, 1 -> vacancy_data   -->
        <div v-for="(item, index) in stateVacanceData.list">
            <div class="list-group container">
              <div class="list-group-item list-group-item-action list-group-item-warning"> 職缺名稱: {{ item.Name }}  </div>
              <div class="list-group-item list-group-item-action list-group-item-warning"> 公司名稱: {{ item.company_Name }} </div>
              <div class="list-group-item list-group-item-action list-group-item-warning wordBreak"> 內容描述: {{ item.description }} </div>
              <div class="list-group-item list-group-item-action list-group-item-warning">
                <span>管理員審查意見: </span>
                <div :class="[isShow? 'show': 'hidden']">
                             {{ item.suggestion }}</div>
                <textarea class="list-group-item list-group-item-action list-group-item-secondary"
                          :class="[isShow? 'hidden': 'show']"
                          v-model = "item.suggestion" > 
                             {{ item.suggestion }} </textarea>
                <button @click="changeShow" class="btn btn-info">{{ isShow? "編輯": "完成" }}</button>
              </div>
              <div class="list-group-item list-group-item-action list-group-item-warning">
                  <button class="btn btn-info" data-toggle="modal" data-target="#showCase" @click="showPage(item)"> 詳情 </button>
                  <select v-model="item.examined">
                    <option v-for="isPass in passOrNoPass" :value="isPass.value">{{ isPass.msg }}</option>
                  </select>
                  <!-- <button class="btn btn-info" @click="update({'data': {'id': getJob.selected === 0? item.PJ_Id : item.JB_Id, 'suggestion': item.suggestion, 'examined': item.examined}})"> 送出 </button>  -->
                  <button class="btn btn-info" @click="update({'id': stateReviewType === 0? item.PJ_Id : item.JB_Id, 'suggestion': item.suggestion, 'examined': item.examined})"> 送出 </button> 
              </div>
            </div>
            <hr>
        </div>
      </div>
      <div v-if = "stateReviewType === 2"> <!-- selected: 0 -> project_data, 1 -> vacancy_data   -->
        <div v-for="(item, index) in stateWebData.list">
            <div class="list-group container">
              <div class="list-group-item list-group-item-action list-group-item-warning"> 網站名稱: {{ item.wName }}  </div>
              <div class="list-group-item list-group-item-action list-group-item-warning"> 網站屬性: {{ item.type }}  </div>
              <div class="list-group-item list-group-item-action list-group-item-warning"> 網站網址: {{ item.address }} </div>
              <div class="list-group-item list-group-item-action list-group-item-warning wordBreak"> 內容描述: {{ item.description }} </div>
              <div class="list-group-item list-group-item-action list-group-item-warning wordBreak"> 建立人: {{ item.name }} </div>
              <div class="list-group-item list-group-item-action list-group-item-warning">
                <span>管理員審查意見: </span>
                <div :class="[isShow? 'show': 'hidden']">
                             {{ item.suggestion }}</div>
                <textarea class="list-group-item list-group-item-action list-group-item-secondary"
                          :class="[isShow? 'hidden': 'show']"
                          v-model = "item.suggestion" > 
                             {{ item.suggestion }} </textarea>
                <button @click="changeShow" class="btn btn-info">{{ isShow? "編輯": "完成" }}</button>
              </div>
              <div class="list-group-item list-group-item-action list-group-item-warning">
                  <!-- <button class="btn btn-info" data-toggle="modal" data-target="#showCase" @click="showPage(item)"> 詳情 </button> -->
                  <select v-model="item.examined">
                    <option v-for="isPass in passOrNoPass" :value="isPass.value">{{ isPass.msg }}</option>
                  </select>
                  <!-- <button class="btn btn-info" @click="update({'data': {'id': getJob.selected === 0? item.PJ_Id : item.JB_Id, 'suggestion': item.suggestion, 'examined': item.examined}})"> 送出 </button>  -->
                  <button class="btn btn-info" @click="updateWeb({'id': item.id, 'suggestion': item.suggestion, 'examined': item.examined})"> 送出 </button> 
              </div>
            </div>
            <hr>
        </div>
      </div>
      <case-page :pageData="itemPage"></case-page>
  </div>
</template>

<script>
    import * as api from '../lib/api.js';
    import { api2 } from '../../assets/api.js'
    import { mapState, mapGetters, mapActions } from 'vuex';
    import CasePage from '../job-query/CasePage.vue';
    export default {
      components: {
        CasePage
      },
      created() {
      },
      data () {
        return {
          response: [],
          itemPage: '',
          isShow: true,
          passOrNoPass: [{"msg": "未審核", "value": 0}, {"msg": "通過", "value": 1}, {"msg": "不通過", "value": 2}],
          requestData: {
                'url_api_project': '/ee/api/api_project.php',
                'url_api_vacancy': '/ee/api/api_vacancy.php',
                'type': '0'                
          },
          project_data: [{  
                'PJ_Id': '', // PJID
                'company_Name':'', // 公司名稱
                'company_Website':'', // 公司網址
                'Name':'', // 專案名稱
                'description':'', // 描述
                'type': [{ // 職務類別是否已被選擇 
                  'id':'',
                  'title':'',
                  'content': ''                   
                }], 
                'key':[{}],       // 關鍵字
                'offer':'',    // 案件預算
                'language':[{
                  'id':'',
                  'type': '',
                  'listen': '',
                  'speak': '',
                  'read': '',
                  'write': ''
                }],  //  語文條件
                'skills':[{
                  'id': '',
                  'value':''
                }],  //  專長技能
                'deadline':'',  //  截止期限
                'contact_Name':'',  //  聯絡人姓名
                'contact_Mail':'',  //  E-MAIL
                'contact_Phone':'',  //  連絡電話
                'contact_Time': '',   //  方便聯絡時間
                'suggestion': '', // 建議
                'adminer': '', // 管理員
                'verifyTime': '', //
                'examined': '', // 審核
              }],
          vacancy_data: [{
              'JB_Id': '', // JBID
              'company_Name':'', // 公司名稱
              'company_Website':'', // 公司網址
              'Name':'', // 職缺名稱
              'description':'', // 描述
              'type': [{
                  'title':'',
                  'content': ''                    
              }], 
              'location':'', // 上班地點
              'duty':'', // 管理責任
              'offer':'',    // 工作待遇
              'officeHour':'', // 上班時段
              'trip': '',  // 出差外派
              'vacation':'', // 休假制度
              'demandMans':'', // 需求人數
              'academicRequire': '', // 學歷要求
              'exprience': '', // 工作經歷
              'others':'', // 其他福利
              'welfare':'', // 公司福利
              'language':[{
                  'id':'',
                  'type': '',
                  'listen': '',
                  'speak': '',
                  'read': '',
                  'write': ''
              }],  //  語文條件
              'skills':[{
                  'id': '',
                  'value':''
              }],  //  工作技能
              'contact_Name':'',  //  聯絡人姓名
              'contact_Mail':'',  //  E-MAIL
              'contact_Phone':'',  //  連絡電話
              'contact_Time': '',   //  方便聯絡時間
              'examined': '', // 審核
            }],
        }
      },
      computed: {
        // ...mapGetters 為 ES7 寫法
        ...mapState(['stateProjectData','stateVacanceData','stateReviewType','stateWebData']),
        ...mapGetters({
            // getTodo return value 將會存在別名為 todos 的 webData 上
            getJob: 'getJob'
        }),
      },
      methods: {
        ...mapActions([
  	      'changeSelected','action_project_get','action_vacance_get','action_set_review_type','action_vacancy_comfirm', 'action_project_comfirm', 'action_web_comfirm'
  	    ]),
        update (param) {
          var _this = this;
          if(_this.stateReviewType == 0)
            _this.action_project_comfirm(param);
          else
            _this.action_vacancy_comfirm(param);
        },
        updateWeb(param){
          this.action_web_comfirm(param);
        },
        showPage (item) {
          let _this = this;
          _this.itemPage = item;
        },
        changeShow () {
          var _this = this;
          _this.isShow = !_this.isShow;
        }
      }
    }
</script>

<style>
  .wordBreak {
    word-wrap: break-word;
  }
  .show {
    display:inline;
  }
  .hidden {
    display:none;
  }
</style> 