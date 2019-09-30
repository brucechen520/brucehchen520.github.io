<template>
  <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="showCase" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	    <div class="modal-dialog modal-lg" role="document">
	        <div class="modal-content">
		        <div class="modal-header">
		            <h5 class="modal-title dialogHeader" id="showCase">{{ pageData.Name }} Content</h5>
		            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		            	<span aria-hidden="true">&times;</span>
		            </button>
		        </div>
		        <div class="modal-body">
		            <div v-if = "getJob.selected"> <!-- project -->
		            	<div class="container">
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">專案名稱</div>
		            			<div class="col alert alert-info">{{ pageData.Name }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">內容描述</div>
		            			<div class="col alert alert-info wordBreak">{{ pageData.description }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">職務類別</div>
		            			<div class="col alert alert-info">
		            				<ul>
		            					<li v-for="type in pageData.type">
		            						{{ type.content }} 		            						
		            					</li>
		            				</ul>
		            			</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">必備技能</div>
		            			<div class="col alert alert-info">
		            				<label v-for="skill in pageData.skills">
		            					{{ skill.value }}
		            				</label>
		            			</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">語言要求</div>
		            			<div class="col alert alert-info">
		            				<ul>
			            				<li v-for = " lang in pageData.language ">
			            					{{ lang.type }}: {{ lang.listen }}, {{ lang.speak }}, {{ lang.read }}, {{ lang.write }}
			            				</li>
			            			</ul>
		            			</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">公司名稱</div>
		            			<div class="col alert alert-info">{{ pageData.company_Name }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">公司網站</div>
		            			<div class="col alert alert-info">{{ pageData.company_Website }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">聯絡人</div>
		            			<div class="col alert alert-info">{{ pageData.contact_Name }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">聯絡人信箱</div>
		            			<div class="col alert alert-info">{{ pageData.contact_Mail }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">聯絡電話</div>
		            			<div class="col alert alert-info">{{ pageData.contact_Phone }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">聯絡時間</div>
		            			<div class="col alert alert-info">{{ pageData.contact_Time }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">修改時間</div>
		            			<div class="col alert alert-info">{{ pageData.modify }}</div>
		            		</div>
		            	</div>
		            </div>
		            <div v-else> <!-- vacancy -->
		            	<div class="container">
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">公司名稱</div>
		            			<div class="col alert alert-info">{{ pageData.company_Name }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">公司網站</div>
		            			<div class="col alert alert-info">{{ pageData.company_Website }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">職缺名稱</div>
		            			<div class="col alert alert-info">{{ pageData.Name }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">內容描述</div>
		            			<div class="col alert alert-info wordBreak">{{ pageData.description }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">職務類別</div>
		            			<div class="col alert alert-info">
		            				<ul>
		            					<li v-for="type in pageData.type">
		            						{{ type.content }} 		            						
		            					</li>
		            				</ul>
		            			</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">必備技能</div>
		            			<div class="col alert alert-info">
		            				<label v-for="skill in pageData.skills">
		            					{{ skill.value }}
		            				</label>
		            			</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">語言要求</div>
		            			<div class="col alert alert-info">
		            				<span v-for = " lang in pageData.language ">
		            					{{ lang.type }}: 聽: {{ lang.listen }}, 說: {{ lang.speak }}, 讀: {{ lang.read }}, 寫: {{ lang.write }}
		            				</span>
		            			</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">工作待遇</div>
		            			<div class="col alert alert-info">{{ pageData.offer }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">需求人數</div>
		            			<div class="col alert alert-info">{{ pageData.demandMans }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">休假制度</div>
		            			<div class="col alert alert-info">{{ pageData.vacation }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">學歷要求</div>
		            			<div class="col alert alert-info">{{ pageData.academicRequire }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">出差外派</div>
		            			<div class="col alert alert-info">{{ pageData.trip }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">上班時段</div>
		            			<div class="col alert alert-info">{{ pageData.officeHour }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">上班地點</div>
		            			<div class="col alert alert-info">{{ pageData.location }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">管理責任</div>
		            			<div class="col alert alert-info">{{ pageData.duty }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">工作經歷</div>
		            			<div class="col alert alert-info">{{ pageData.exprience }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">其他</div>
		            			<div class="col alert alert-info">{{ pageData.others }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">公司福利</div>
		            			<div class="col alert alert-info">{{ pageData.welfare }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">聯絡人</div>
		            			<div class="col alert alert-info">{{ pageData.contact_Name }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">聯絡人信箱</div>
		            			<div class="col alert alert-info">{{ pageData.contact_Mail }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">聯絡電話</div>
		            			<div class="col alert alert-info">{{ pageData.contact_Phone }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">聯絡時間</div>
		            			<div class="col alert alert-info">{{ pageData.contact_Time }}</div>
		            		</div>
		            		<div class="row">
		            			<div class="col-3 alert alert-secondary">修改時間</div>
		            			<div class="col alert alert-info">{{ pageData.modify }}</div>
		            		</div>
		            	</div>		            	
		            </div>
		        </div>
		        <div class="modal-footer">
		            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        </div>
	        </div>
	    </div>
    </div>
</template>

<script>
	import { mapGetters, mapActions } from 'vuex';
    export default {
    	props: ['pageData'],
    	data () {
 			return {

 			}   		
    	},
    	computed: {
    		// ...mapGetters 為 ES7 寫法
	        ...mapGetters({
	            // getTodo return value 將會存在別名為 todos 的 webData 上
	            getJob: 'getJob' // 0: project, 1: vacancy
        	}),
	    }
    }
</script>

<style>

</style>