<template>
  <div>
      <h1>我的網站</h1>
      <span class="btn btn-info" @click="addweb">新增網站</span>
      <!-- 查詢 -->
      <div>
          <label>查詢:</label>
          <select v-model="query">
            <option v-for="webList in website_lists" :value=webList>{{ webList }}</option>
          </select>
      </div>
      <!--  Pagination  -->
      <div>
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
      </div>
      <!-- 網站頁面 -->
      <div>
        <div v-for = "item in webFilter.slice(pageStart, pageStart + this.pagination.itemPerPage)" >
          <div class="list-group ">
            <div class="list-group-item list-group-item-action list-group-item-warning"> 姓名: {{ item.name}} </div>
            <div class="list-group-item list-group-item-action list-group-item-warning"> 序號: {{ item.id}} </div>
            <div class="list-group-item list-group-item-action list-group-item-warning"> 網站名稱: <a :href="item.address" target="_blank">{{ item.wName}} </a></div>
            <div class="list-group-item list-group-item-action list-group-item-warning"> 網站類型: {{ item.type}} </div>
            <div class="list-group-item list-group-item-action list-group-item-warning"> 網站描述: {{ item.description}} </div>
            <div class="list-group-item list-group-item-action list-group-item-warning"> 發布日期: {{ datetimeFormat(item.verifyTime)}} </div>
            <div class="list-group-item list-group-item-action list-group-item-warning"> 狀態: {{statusdesc[item.status]}} </div>

          </div>
          <hr>
        </div>

      </div>
      <modal id="modal-addweb" name="modalWebAdd" transition="pop-out" :width="800" :height="550" :pivotX="0.5" :pivotY="0.3">
        <div class="modal-header">
          <h2>新增網站</h2>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModalAdd">
                        <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <span>名稱</span><input v-model="webAddData.name" placeholder="請輸入網站名稱">
          <span>網址</span><input v-model="webAddData.address" placeholder="請輸入完整網站網址">
          <span>是否公開</span>
          <select v-model="webAddData.permit">
            <option v-for="item in permitList" :value="item.value">{{ item.mes }}</option>
          </select>
          
          <span>類別</span>
          <select v-model="webAddData.type">
            <option  v-for="item in website_type" :value="item">{{ item }}</option>
          </select>
          
          <span>敘述</span><textarea v-model="webAddData.description" placeholder="請輸入網站敘述"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" @click="addWebData">新增</button>
          <button type="button" @click="closeModalAdd">取消</button>
        </div>
    </modal>
  </div>
</template>

<script>
    import { mapState, mapGetters, mapActions } from 'vuex';  
    import * as api from '../lib/api';
    export default {
        data () {
          return {
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
            permitList: [              
              {'mes': '完全公開', 'value': '0'},
              {'mes': '僅系友公開', 'value': '1'},
              {'mes': '不公開', 'value': '2'}],
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
              permit:'',
              type:'',
              description:'',
            }
          }
        },
        created () {
            let _this = this;
            this.action_web_get({Mem_Se:''}).then(function(){
                _this.website_sets = [..._this.stateWebData.list];
                _this.setPage();
            });
        },
        computed: {
          ...mapState(['stateProjectData','stateVacanceData','stateWebData']),
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
          // ...mapGetters 為 ES7 寫法
          ...mapGetters({
              // getUser return value 將會存在別名為 users 的 webData 上
              users: 'getUser'
          })
        },
        methods: {
          ...mapActions([
  	      'action_project_get','action_vacance_get','action_set_review_type','action_web_get','action_web_insert'
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
                    return "";
                var d = new Date(milliseconds*1000);
                if(formatStr=='YYYY-mm-dd HH:mm:ss'){
                    return d.getFullYear() +"-"+ ((d.getMonth()+1 >9)?(d.getMonth()+1):"0"+(d.getMonth()+1))+"-"+((d.getDate() >9)?d.getDate():"0"+d.getDate())+" "+(d.getHours()>9?d.getHours():"0"+d.getHours())+":"+(d.getMinutes()>9?d.getMinutes():"0"+d.getMinutes())+":"+(d.getSeconds()>9?d.getSeconds():"0"+d.getSeconds());
                }else{
                    return d.getFullYear() +"-"+ ((d.getMonth()+1 >9)?(d.getMonth()+1):"0"+(d.getMonth()+1))+"-"+((d.getDate() >9)?d.getDate():"0"+d.getDate());
                }
          },
          addweb(){
            this.$modal.show("modalWebAdd");
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
            });
            self.$modal.hide("modalWebAdd");
            self.webAddData = {
              name:'',
              address:'',
              permit:'',
              type:'',
              description:'',
            }
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