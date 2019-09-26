<template>
  <div>
      <div v-if="getJob.selected === 0">
        <h3 class="mt-0 header"> 專案列表審核 </h3>
      </div>
      <div v-else>
        <h3 class="mt-0 header"> 職缺列表審核 </h3>
      </div>
      <div v-if = "list = getJob.selected === 0? project_data : vacancy_data"> <!-- selected: 0 -> project_data, 1 -> vacancy_data   -->
        <div v-for="(item, index) in list">
            <div class="list-group container">
              <div class="list-group-item list-group-item-action list-group-item-warning"> 職缺名稱: {{ item.Name }}  </div>
              <div class="list-group-item list-group-item-action list-group-item-warning"> 公司名稱: {{ item.company_Name }} </div>
              <div class="list-group-item list-group-item-action list-group-item-warning"> 內容描述: {{ item.description }} </div>
              <textarea class="list-group-item list-group-item-action list-group-item-secondary"
                        v-click = ""> 管理員審查意見: {{ item.suggestion }} </textarea>
              <div >
                  <button class="btn btn-info" data-toggle="modal" data-target="#showCase" @click="showPage(item)"> 詳情 </button>
                  <select v-model="item.examined">
                    <option disabled value="">請選擇</option>
                    <option v-for="isPass in passOrNoPass" 
                            :value="isPass.value">{{ isPass.msg }}</option>
                  </select>
                  <button class="btn btn-info" @click="sendData(item)"> 送出 </button> 
              </div>
            </div>
            <hr>
          </div>
      </div>
      <case-page :pageData="itemPage"></case-page>
  </div>
</template>

<script>
    import * as sql from '../lib/sql';
    import { mapGetters, mapActions } from 'vuex';
    import CasePage from '../job-query/CasePage.vue';
    export default {
      created() {
        this.response = this.select(this.requestData['url_api_project'], this.requestData['type']);
        this.project_data = this.response;
        this.response = this.select(this.requestData['url_api_vacancy'], this.requestData['type']);
        this.vacancy_data = this.response;
      },
      data () {
        return {
          response: [],
          itemPage: '',
          passOrNoPass: [{"msg": "不通過", "value": 0}, {"msg": "通過", "value": 1}],
          requestData: {
                'url_api_project': '/ee/api/api_project.php',
                'url_api_vacancy': '/ee/api/api_vacancy.php',
                'type': '0'                
          },
          project_data: [{  
                'id': '', // PJID
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
              'id': '', // JBID
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
        ...mapGetters({
            // getTodo return value 將會存在別名為 todos 的 webData 上
            getJob: 'getJob'
        }),
      },
      methods: {
        select (url, type) {
          return sql.select(url, type);
        },
        showPage (item) {
          let _this = this;
          _this.itemPage = item;
        }
      }
    }
</script>

<style>

</style> 