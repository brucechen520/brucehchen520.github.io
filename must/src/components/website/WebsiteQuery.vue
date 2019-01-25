<template>
  <div>
      <!-- 查詢 -->
      <div>
          <label>查詢:</label>
          <select v-model="query">
            <option v-for="webList in website_lists" :value=webList>{{ webList }}</option>
          </select>
      </div>  
      <div>
          <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
              <li :class="[currentpage === 1 ? 'page-item disabled': 'page-item']" @click="setPage(currentpage - 1)">
                <a class="page-link" href="#" tabindex="-1">Previous</a>
              </li>   
              <li class="page-item" v-for="n in totalPage" @click="setPage(n)">
                <a class="page-link" href="#">{{ n }}</a>
                </li>
              <li :class="[currentpage === totalPage ? 'page-item disabled': 'page-item']" @click="setPage(currentpage + 1)">
                <a class="page-link" href="#">Next</a>
              </li>
            </ul>
          </nav>
      </div>
      <!-- 網站頁面 -->
      <div>
        <div v-for = "item in webFilter.slice(pageStart, pageStart + countOfPage)" class="content">
          <div> 姓名: {{ item.name}} </div>
          <div> 序號: {{ item.id}} </div>
          <div> 網站名稱: <a :href="item.address">{{ item.wName}} </a></div>
          <div> 網站類型: {{ item.type}} </div>
          <div> 網站描述: {{ item.description}} </div>
        </div>

      </div>

  </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'
    import * as api from '../lib/api';
    export default {
        data () {
          return {
            currentpage: 1, // 指定目前的頁碼
            countOfPage: 2, // 每頁呈現幾筆資料
            query: 'all',
            website_lists: [
              'all',
              'personal',
              'company',
              'github',
              'others'
            ],
            website_sets: [{
                id: Number(1),
                type: '',
                name: '',
                wName: '',
                address: '',
                description: ''
              }],
          }
        },
        created () {
            this.select();
        },
        computed: {
          webFilter () {
              var _this = this ; 
              if(_this.query === 'all')
                return  _this.website_sets;
              else
                return  _this.website_sets.filter(arr=>arr.type===_this.query);
          },
          pageStart: function(){
            return (this.currentpage - 1) * this.countOfPage;
          },
          totalPage: function(){
            return Math.ceil(this.webFilter.length / this.countOfPage);
          },
          // ...mapGetters 為 ES7 寫法
          ...mapGetters({
              // getTodo return value 將會存在別名為 todos 的 webData 上
              users: 'getUser'
          })
        },
        methods: {
          select() {
              var _this = this ;
              api.getData('/ee/api/api_web.php', {
                  params: {
                    methods: 'select',
                  }
                })
                  .then(function (user) {
                      console.log(user);
                      //console.log(user[1].address);
                      if(!user.error){
                          _this.website_sets = [...user];
                          /*
                          user.map(arr => {
                            _this.website_sets = [..._this.website_sets,{
                              id: arr.id,
                              type: arr.type,
                              name: arr.name,
                              wName: arr.wName,
                              address: arr.address,
                              description: arr.description
                            }];
                          })*/
                      }                        
                      else
                        alert(user.error);
                  })
                  .catch(function (error) {
                      alert(error);
                  })
          },
          setPage: function(idx){
            if( idx <= 0 || idx > this.totalPage ){
              return;
            }
            this.currentpage = idx;
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
</style>