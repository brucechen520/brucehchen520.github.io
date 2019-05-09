<template>
  <div>
  		<div v-if = "list = getJob.selected === 0? project_data : vacancy_data"> <!-- selected: 0 -> project_data, 1 -> vacancy_data   -->
  			<div v-for=" item in list">
	          <div class="list-group ">
	            <div class="list-group-item list-group-item-action list-group-item-warning"> 姓名: {{ item.name}} </div>
	            <div class="list-group-item list-group-item-action list-group-item-warning"> 序號: {{ item.id}} </div>
	            <div class="list-group-item list-group-item-action list-group-item-warning"> </div>
	            <div class="list-group-item list-group-item-action list-group-item-warning"> 網站類型: {{ item.type}} </div>
	            <div class="list-group-item list-group-item-action list-group-item-warning"> 網站描述: {{ item.description}} </div>
	          </div>
	          <hr>
	        </div>
	    </div>    	
  </div>
</template>

<script>
	import { mapGetters, mapActions } from 'vuex';
	import * as api from '../lib/api';
    export default {
    	created() {
    		this.selectPrjoect();
    	},
    	data () {
    		return {
    			project_data: [{	
				                'company_Name':'', // 公司名稱
				                'company_Website':'', // 公司網址
				                'project_Name':'', // 職缺名稱
				                'description':'', // 描述
				                'checked': [             // 職務類別是否已被選擇                          
				                    {
				                        'title':'網路資訊相關',
				                        'content': []                     
				                    },
				                    {
				                        'title':'行銷企劃相關',
				                        'content': []
				                    }
				                ], 
				                'key':[],       // 關鍵字
				                'project_budget':'',    // 案件預算
				                'language':[{
				                                'type': '',
				                                'read': '',
				                                'write': '',
				                                'listen': '',
				                                'speak': ''
				                            }],  //  語文條件
				                'skills':[],  //  專長技能
				                'deadline':'',  //  截止期限
				                'contact_Name':'',  //  聯絡人姓名
				                'contact_Mail':'',  //  E-MAIL
				                'contact_Phone':'',  //  連絡電話
				                'contact_Time': ''   //  方便聯絡時間
    				            }],
	            vacancy_data: [{	
            					'id': Number(1),
            	                'company_Name':'', // 公司名稱
            	                'company_Website':'', // 公司網址
            	                'vacancy_Name':'', // 職缺名稱
            	                'description':'', // 描述
            	                'checked': [             // 職務類別是否已被選擇                          
            	                    {
            	                        'title':'軟體/工程類人員',
            	                        'content': []                     
            	                    },
            	                    {
            	                        'title':'MIS/網管類人員',
            	                        'content': []
            	                    },
            	                    {
            	                        'title':'工程研發類人員',
            	                        'content': []
            	                    },
            	                    {
            	                        'title':'化工材料研發類人員',
            	                        'content': []
            	                    },
            	                    {
            	                        'title':'生技/醫療研發類人員',
            	                        'content': []
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
            	                                'id': Number(1),
            	                                'status': true,
            	                                'type': '',
            	                                'read': '',
            	                                'write': '',
            	                                'listen': '',
            	                                'speak': ''
            	                            }],  //  語文條件
            	                'skills':[{
            	                    'id': Number(1),
            	                    'status': true,
            	                    'value':''
            	                }],  //  工作技能
            	                'contact_Name':'',  //  聯絡人姓名
            	                'contact_Mail':'',  //  E-MAIL
            	                'contact_Phone':'',  //  連絡電話
            	                'contact_Time': ''   //  方便聯絡時間
	            	            }],
	            single_vacancy: {
	            	'company_Name':'', // 公司名稱
	                'company_Website':'', // 公司網址
	                'vacancy_Name':'', // 職缺名稱
	                'description':'', // 描述
	                'checked': [             // 職務類別是否已被選擇                          
	                    {
	                        'title':'軟體/工程類人員',
	                        'content': []                     
	                    },
	                    {
	                        'title':'MIS/網管類人員',
	                        'content': []
	                    },
	                    {
	                        'title':'工程研發類人員',
	                        'content': []
	                    },
	                    {
	                        'title':'化工材料研發類人員',
	                        'content': []
	                    },
	                    {
	                        'title':'生技/醫療研發類人員',
	                        'content': []
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
	                                'id': Number(1),
	                                'status': true,
	                                'type': '',
	                                'read': '',
	                                'write': '',
	                                'listen': '',
	                                'speak': ''
	                            }],  //  語文條件
	                'skills':[{
	                    'id': Number(1),
	                    'status': true,
	                    'value':''
	                }],  //  工作技能
	                'contact_Name':'',  //  聯絡人姓名
	                'contact_Mail':'',  //  E-MAIL
	                'contact_Phone':'',  //  連絡電話
	                'contact_Time': ''   //  方便聯絡時間
	            },
	            single_project: {
	            	'company_Name':'', // 公司名稱
	                'company_Website':'', // 公司網址
	                'project_Name':'', // 職缺名稱
	                'description':'', // 描述
	                'checked': [             // 職務類別是否已被選擇                          
	                    {
	                        'title':'網路資訊相關',
	                        'content': []                     
	                    },
	                    {
	                        'title':'行銷企劃相關',
	                        'content': []
	                    }
	                ], 
	                'key':[{
	                    'id': Number(1),
	                    'status': true,
	                    'value':''
	                }],       // 關鍵字
	                'project_budget':'',    // 案件預算
	                'language':[{
	                                'id': Number(1),
	                                'status': true,
	                                'type': '',
	                                'read': '',
	                                'write': '',
	                                'listen': '',
	                                'speak': ''
	                            }],  //  語文條件
	                'skills':[{
	                    'id': Number(1),
	                    'status': true,
	                    'value':''
	                }],  //  專長技能
	                'deadline':'',  //  截止期限
	                'contact_Name':'',  //  聯絡人姓名
	                'contact_Mail':'',  //  E-MAIL
	                'contact_Phone':'',  //  連絡電話
	                'contact_Time': ''   //  方便聯絡時間
	            }
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
                      	   console.log(data);
                          // _this.vacancy_data = [...data];
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