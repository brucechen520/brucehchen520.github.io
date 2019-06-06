<template>
  <div>
    	<div class="list-group container">
          <div class="badge badge-pill badge-dark" @click="changeSelected(0)">外包專案: {{ projectCount  }}</div>
          <div class="badge badge-pill badge-dark" @click="changeSelected(1)">工作職缺: {{ vacancytCount }}</div>
      </div>
  </div>
</template>

<script>
	import { mapGetters, mapActions } from 'vuex';  
  import * as api from '../lib/api';
    export default {
      created () {
        this.selectPrjoect();
        this.selectVacancy();
        this.setItemCount();
      },
      data () {
          return {
            project_data: [{  
                  'id': '', // PJID
                  'company_Name':'', // 公司名稱
                  'company_Website':'', // 公司網址
                  'Name':'', // 專案名稱
                  'description':'', // 描述
                  'type': [             // 職務類別是否已被選擇                          
                      {
                        'id':'',
                          'title':'',
                          'content': ''                   
                      }
                  ], 
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
                  'contact_Time': ''   //  方便聯絡時間
                  }],
            vacancy_data: [{
                      'id': '', // JBID
                      'company_Name':'', // 公司名稱
                      'company_Website':'', // 公司網址
                      'Name':'', // 職缺名稱
                      'description':'', // 描述
                      'type': [             // 職務類別是否已被選擇                          
                          {
                              'title':'',
                              'content': ''                    
                          }
                      ], 
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
                              }
                            ],  //  工作技能
                      'contact_Name':'',  //  聯絡人姓名
                      'contact_Mail':'',  //  E-MAIL
                      'contact_Phone':'',  //  連絡電話
                      'contact_Time': ''   //  方便聯絡時間
              }],
            projectCount: '',
            vacancytCount: ''
          }
      },
      computed: {
        // ...mapGetters 為 ES7 寫法
        ...mapGetters({
            // getTodo return value 將會存在別名為 todos 的 webData 上
            selected: 'getJob'
        }),
      },
      methods: {
      	...mapActions([
  	      'changeSelected'
  	    ]),
        setItemCount () {
            var _this = this;            
            _this.vacancytCount = this.vacancy_data.length;
            _this.projectCount = this.project_data.length;
            this.$store.dispatch('setCount', {
              projectCount: _this.projectCount,
              jobCount: _this.vacancytCount
            })
        },
	      selectPrjoect () {
              var _this = this ;
              api.getData('/ee/api/api_project.php', {
                  params: {
                    methods: 'select',
                  }
                })
                  .then(function (data) {
                      if(!data.error){
                          _this.project_data = [...data];
                      }
                      else
                        alert(data.error);
                  })
                  .catch(function (error) {
                      alert(error);
                  })
            },
        selectVacancy () {
          var _this = this ;
          api.getData('/ee/api/api_vacancy.php', {
              params: {
                methods: 'select',
              }
            })
              .then(function (data) {
                  if(!data.error){
                       _this.vacancy_data = [...data];
                  }                        
                  else
                    alert(data.error);
              })
              .catch(function (error) {
                  alert(error);
              })
        },
      }
    }
</script>

<style>

</style>