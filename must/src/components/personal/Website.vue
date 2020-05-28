<template>
  <div>
      <h1>我的網站</h1>
      <b-button variant="success" @click="addWeb" class="mb-2">新增網站</b-button>
      <!-- 查詢 -->
      <!-- <div>
          <label>查詢:</label>
          <select v-model="query">
            <option v-for="webList in website_lists" :value=webList>{{ webList }}</option>
          </select>
      </div> -->
      <b-table striped hover outlined :fields="myFields" :items="getterWebDataList">
        <template v-slot:cell(id)="row">{{row.index +1 }}</template>
        <template v-slot:cell(詳情)="row">
          <b-button size="sm" @click="row.toggleDetails" class="mr-2">
             {{ row.detailsShowing ? '縮小' : '詳情'}}
          </b-button>
        </template>
        <template v-slot:row-details="row">
        <b-card>
          <b-row class="mb-1">
            <b-col sm="2" class=""><b>序號:</b></b-col>
            <b-col>{{ row.item.id }}</b-col>
          </b-row>
          <b-row class="mb-1">
            <b-col sm="2" class=""><b>網站描述:</b></b-col>
            <b-col>{{ row.item.description }}</b-col>
          </b-row>
          <b-row class="mb-1">
            <b-col sm="2" class=""><b>詳細網址:</b></b-col>
            <b-col><b-link :href="row.item.address" target="_blank">{{ row.item.address }}</b-link></b-col>
          </b-row>
          <b-button size="sm" variant="warning" @click="editWeb(row.item)">修改</b-button>
          <b-button size="sm" variant="danger" v-b-modal.delete-check-modal @click="deleteId = row.item.id">刪除</b-button>
          <b-button size="sm" @click="row.toggleDetails">縮小</b-button>
        </b-card>
      </template>
      </b-table>
      <!--  Pagination  -->
      <!-- <div>
          <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
              <li :class="[pagination.currentPage === 1 ? 'page-item is-disabled': 'page-item']" @click="setPage(pagination.currentPage - 1)">
                <a class="page-link" href="#" tabindex="-1">Previous</a>
              </li>   
              <li class="page-item" v-for="n in pagination.items" @click="setPage(n)">
                <a :class="[pagination.currentPage === n ? 'page-link is-info': 'page-link']" href="#">{{ n }}</a>
              </li>
              <li :class="[pagination.currentPage === totalPage ? 'page-item is-disabled': 'page-item']" @click="setPage(pagination.currentPage + 1)">
                <a class="page-link" href="#">Next</a>
              </li>
            </ul>
          </nav>
      </div> -->
      <!-- 網站頁面 -->
      <modal id="modal-addweb" class="modalform" name="modalWebAdd" transition="pop-out" :width="800" :height="550" :pivotX="0.5" :pivotY="0.3">
        <div class="modal-header">
          <h2>{{modalOption.title}}</h2>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModalAdd">
                        <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <span>名稱</span><input v-model="webAddData.name" placeholder="請輸入網站名稱">
          <span>網址</span><input v-model="webAddData.address" placeholder="請輸入完整網站網址" v-validate="'url'" name="url">
          <span v-show="errors.has('url')" class="validate-error-message">請輸入正確的網址</span>
          <span>是否公開</span>
          <select v-model="webAddData.permit">
            <option v-for="item,index in permitList" :value="index">{{ item }}</option>
          </select>
          
          <span>類別</span>
          <select v-model="webAddData.type">
            <option  v-for="item in website_type" :value="item">{{ item }}</option>
          </select>
          
          <span>敘述</span><textarea v-model="webAddData.description" placeholder="請輸入網站敘述"></textarea>
        </div>
        <div class="modal-footer">
          <div v-if="modalOption.status == 2">
            <button type="button" @click="updateWebData" v-if="completeValidate">送出</button>
            <button type="button" v-else class="disable">不能送出</button>
          </div>
          <div v-if="modalOption.status == 1">
          <button type="button" @click="addWebData" v-if="completeValidate">新增</button>
          <button type="button" v-else class="disable">新增</button>
          </div>
          <button type="button" @click="closeModalAdd">取消</button>
        </div>
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
    import * as api from '../lib/api';
    export default {
        data () {
          return {
            myFields: [
              {key: 'id', label: 'NO',},
              {key: 'name', label: '網站名稱',},
              {key: 'type', label: '類型',},
              //{key: 'description', label: '網站描述',},
              {key: 'publisher', label: '發布人',},
              {key: 'verifyTime', label: '發布日期',formatter:'datetimeFormat'},
              {key: 'status', label: '狀態',formatter: e => this.statusdesc[e]},
              '詳情',
              ],
            deleteId:'',
            statusdesc:["待審核","審核通過","審核不通過","已封存"],
            pagination: {
              itemPerPage: 10, // 每頁呈現幾筆資料
              currentPage: 1, // 指定目前的頁碼
              items: [],
              range: 5 // 只呈現五個頁碼
            },            
            query: 'all',
            website_lists: [
              'all',
              'personal',
              'company',
              'github',
              'others'
            ],
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
            website_sets: [{
                id: Number(1),
                type: '',
                name: '',
                wName: '',
                address: '',
                description: ''
              }],
            webAddData:{
              name:'',
              address:'',
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
          }
        },
        created () {
            let self = this;
            this.action_web_get({Mem_Se:self.users.id}).then(function(){
                //self.website_sets = [...self.stateWebData.list];
                self.website_sets = self.stateWebData.list.map(e=>Object.assign({_showDetails: false},e));
                self.setPage();
            });
        },
        computed: {
          ...mapState(['stateProjectData','stateVacanceData','stateWebData','userInfo']),
          webFilter () {
              var _this = this ; 
              if(_this.query === 'all')
                return  _this.website_sets;
              else
                return  _this.website_sets.filter(arr=>arr.type===_this.query);        // 依據query查詢資料不同，filter相對應的資料
          },

          pageStart: function(){ // 依據目前的頁碼，決定要從哪一筆資料開始呈現
            return (this.pagination.currentPage - 1) * this.pagination.itemPerPage;
          },
          
          totalPage: function(){ // 總共的頁數
            return Math.ceil(this.webFilter.length / this.pagination.itemPerPage);
          },
          rangePage: function() { // 依據目前有多少資料調整最大呈現的頁數
              var _this = this;
              if(_this.totalPage < _this.pagination.range) /*  如果小於range 頁碼重新賦值  */
                return _this.totalPage
              else
                return _this.pagination.range
          },
          completeValidate() {
            if (this.errors.items.length > 0 || this.webAddData.name === "") {
                return false;
            } else {
                return true;
            }
          },
          // ...mapGetters 為 ES7 寫法
          ...mapGetters({users: 'getUser',getterWebDataList:'getterWebDataList'})
        },
        methods: {
          ...mapActions([
  	      'action_project_get','action_vacance_get','action_set_review_type','action_web_get','action_web_insert','action_web_update',,'action_web_delete',
          ]),
          setPage: function(clickedPage = 1){ // 設定頁碼
            let itemMax = this.totalPage; // 最大的頁碼
            let start  = 0;
            let end = 0;
            this.pagination.currentPage = clickedPage;
            if(this.pagination.currentPage < 3){
                start = 1;
                end = start + this.rangePage - 1;
            }
            else if(this.pagination.currentPage <= itemMax && this.pagination.currentPage > itemMax - this.rangePage + 2){
                start = itemMax - this.rangePage + 1;
                end = itemMax ;
            }
            else {
                start = this.pagination.currentPage - 2;
                end = this.pagination.currentPage + 2;
            }
            if( this.pagination.currentPage < 1 ){
              start = 1;
              end = 5; 
            }
            if(this.pagination.currentPage > itemMax ){
              start = itemMax - this.rangePage + 1;
              end = itemMax;
            }
            this.pagination.items = [];
            for(let i = start ; i <= end; i++)
                this.pagination.items = [...this.pagination.items, i];
          },
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
            this.modalOption.status = 2;
            console.log(webData);
            this.webAddData = Object.assign({},webData);
            this.$modal.show("modalWebAdd");
          },
          deleteWeb(){
            let self = this;
            self.action_web_delete({data:{id:self.deleteId}}).then(function(result){
                if(result.code == 'success'){
                    alert('成功');
                }
                self.$modal.hide("checkModal");
                self.action_web_get({Mem_Se:self.users.id});
                self.deleteId = '';
            });
          },
          clearWebData(){
              let self = this;
              self.webAddData = {
                name:'',
                address:'',
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
                  alert('成功');
              }
              self.action_web_get({Mem_Se:self.users.id}).then(function(){
                //self.website_sets = [...self.stateWebData.list];
                self.setPage();
            });
            });
            self.$modal.hide("modalWebAdd");
            self.webAddData = {
              name:'',
              address:'',
              permit:'0',
              type:'personal',
              description:'',
            }
          },
          updateWebData(){
            let self = this;
            self.action_web_update({data:self.webAddData}).then(function(result){
                if(result.code == 'success'){
                    alert('成功');
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
</style>