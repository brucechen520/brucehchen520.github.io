<template>
  <div>
  		<div v-if = "list = getJob.selected === 0? project_data : vacancy_data"> <!-- selected: 0 -> project_data, 1 -> vacancy_data   -->
  			<div v-for="(item, index) in list">
	          <div class="list-group container">
	            <div class="list-group-item list-group-item-action list-group-item-warning"> 職缺名稱: {{ item.Name }}  </div>
	            <div class="list-group-item list-group-item-action list-group-item-warning"> 公司名稱: {{ item.company_Name }} </div>
	            <div class="list-group-item list-group-item-action list-group-item-warning"> 內容描述: {{ abstractDescription[index] }}... </div>
	            <div class="list-group-item list-group-item-action list-group-item-warning"> 工作技能:
	            	<label v-for="sk in item.skills">
	            		{{ sk.value }}
	            	</label>
	            </div>
	            <div class="list-group-item list-group-item-action list-group-item-warning"> 工作地點: {{ item.location }} </div>
	            <div class="list-group-item list-group-item-action list-group-item-warning"> 工作薪資: {{ item.offer }} </div>
	            <div class="btn btn-info" data-toggle="modal" data-target="#showCase" @click="showPage(item)"> 詳情 </div>
	          </div>	     
	          <hr>
	        </div>
	    </div>
	    <case-page :pageData="itemPage"></case-page>
  </div>
</template>

<script>
	import { mapGetters, mapActions } from 'vuex';
	import * as api from '../lib/api';
	import CasePage from './CasePage.vue';
    export default {
    	components: {
    		CasePage
    	},
    	created() {
    		this.selectPrjoect();
    		this.selectVacancy();
    	},
    	data () {
    		return {
    			itemPage: '',
    			project_data: [{	
    							'PJ_Id': '', // PJID
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
	            single_vacancy: {
	            	'company_Name':'', // 公司名稱
	                'company_Website':'', // 公司網址
	                'Name':'', // 職缺名稱
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
	                'Name':'', // 職缺名稱
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
	                'offer':'',    // 案件預算
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
	        abstractDescription () {
	        	var _this = this
	        	var listD = _this.getJob.selected === 0? _this.project_data : _this.vacancy_data;
	        	return listD.map(arr => {
	        		if(arr.description !== null && arr.description !== '')
	        			return arr.description.slice(0, 50)
	        	})
	        }
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
                      		//console.log(data);
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
                      	   //console.log(data);
                           _this.vacancy_data = [...data];
                      }                        
                      else
                        alert(data.error);
                  })
                  .catch(function (error) {
                      alert(error);
                  })
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