<template>
  <div>

      <!-- 網站頁面 -->
      <div>
        <div v-for = "item in stateMemberData" >
          <div class="list-group ">
            <div class="list-group-item list-group-item-action list-group-item-warning"> 姓名: {{ item.name}} </div>
            <div class="list-group-item list-group-item-action list-group-item-warning"> 電話: {{ item.cellphone}} </div>
            <div class="list-group-item list-group-item-action list-group-item-warning"> 信箱: {{ item.mail}} </div>
            <div class="list-group-item list-group-item-action list-group-item-warning"> 技能專長: {{ item.expertise}} </div>
            <div class="btn btn-info" @click="detail(item)"> 詳情 </div>
          </div>
          <hr>
        </div>
      </div>
      <modal id="modal-member-detail" class="modalform" name="modalMemberDetail" transition="pop-out" :width="800" :height="widowHight08" :pivotX="0.5" :pivotY="0.3">
        <div class="modal-header">
          <h2>個人檔案</h2>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                        <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <div class=""> 姓名: {{ memberDetailData.name}} </div>
            <div class=""> 電話: {{ memberDetailData.cellphone}} </div>
            <div class=""> 信箱: {{ memberDetailData.mail}} </div>
            <div class=""> 技能專長: {{ memberDetailData.expertise}} </div>
            <div class=""> 作品: {{ memberDetailData.works}} </div>
            <div class=""> 證照: {{ memberDetailData.license}} </div>
            <div class="wordBreak"> 自我介紹: {{ memberDetailData.biography}} </div>
            
        </div>
        <div class="modal-footer">
          <button type="button" @click="closeModal">確認</button>
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
            widowHight08:window.innerHeight * 0.6,
            pagination: {
              'itemPerPage': 10, // 每頁呈現幾筆資料
              'currentPage': 1, // 指定目前的頁碼
              'items': [],
              'range': 5 // 只呈現五個頁碼
            },            
            query: 'all',
            website_lists: [
              'all',
              'personal',
              'company',
              'github',
              'others'
            ],
            man_sets: [{
                'id': Number(1),
                'biography':'',
                'mail':'', // 信箱
                'cellphone':'', // 手機
                'permit':'', // 類別
                'expertise': [{  // 技能專長
                    'id': Number(1),
                    'value': '',
                    'status': true
                }], 
                'works': [{     // 作品
                    'id': Number(1),
                    'value': '',
                    'status': true
                }],
                'license': [{   // 證照
                    'id': Number(1),
                    'value': '',
                    'status': true
                }]
              }],
            memberDetailData:{},
          }
        },
        created () {
            this.select();
            this.action_member_get();
        },
        computed: {
          ...mapState(['stateMemberData']),
          manFilter () {
              var _this = this ; 
              if(_this.query === 'all')
                return  _this.man_sets;
              else
                return  _this.man_sets.filter(arr=>arr.type===_this.query);        // 依據query查詢資料不同，filter相對應的資料
          },

          pageStart: function(){ // 依據目前的頁碼，決定要從哪一筆資料開始呈現
            return (this.pagination.currentPage - 1) * this.pagination.itemPerPage;
          },
          
          totalPage: function(){ // 總共的頁數
            return Math.ceil(this.manFilter.length / this.pagination.itemPerPage);
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
          ...mapActions(['action_member_get']),
          detail(item){
            this.memberDetailData = item;
            this.$modal.show("modalMemberDetail");
          },
          closeModal(){
            this.$modal.hide("modalMemberDetail");
          },
          select() {
              var _this = this ;
              api.getData('/ee/api/api_skill.php', {
                  params: {
                    methods: 'select',
                  }
                })
                  .then(function (data) {
                      if(!data.error){
                          _this.man_sets = [...data];
                          _this.setPage();
                      }                        
                      else
                        alert(data.error);
                  })
                  .catch(function (error) {
                      alert(error);
                  })
          },
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
    .wordBreak{
      word-break: break-word;
    }
</style>