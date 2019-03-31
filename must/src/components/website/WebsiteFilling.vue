<template>
  <div>
      <div>
          <!--  users: {{ users }}  -->
          <ul class="list-group">
            <div>
                <li class="list-group-item list-group-item-info"
                    v-for="(website_set, index) in webData.website_sets">
                    <label>是否公開:</label>
                    <select v-model="webData.website_sets[index].permit"
                            :class="{'isNullSelect': website_set.pstatus}">
                          <option v-for="item in permitList" 
                                  :value="item.Permit_Id">{{ item.Permit_Value }}</option>
                    </select>
                    <label>網站名稱:</label>
                    <input type="text" 
                          v-model="website_set.wName"
                          :class="{'isNull': website_set.wstatus}"
                          @change="ifchange(index)">

                  <label v-if="website_set.wstatus">【請填寫網站名稱】</label>
                  <label>類別:</label>
                  <select v-model="webData.selected_category[index].value" 
                              :class="{'isNullSelect': webData.selected_category[index].status}">

                          <option disabled value="">請選擇</option>
                          <option v-for="webList in website_lists" 
                                  :value="webList">{{ webList }}</option>
                        </select>
                  <label>網址:</label>
                  <input type="text" 
                              v-model="website_set.address"
                              :class="{'isNull': website_set.astatus}"
                              @change="ifchange(index)">
                  <label>敘述:</label>
                  <input type="text" 
                              v-model="website_set.description"
                              :class="{'isNull': website_set.dstatus}"
                              @change="ifchange(index)">
                  <label :class="[website_set.rowStatus ? 'fas fa-plus' : 'fas fa-minus']" @click="toggleInput(website_set.id)"></label>
                </li>
                
              </div>
            </div>
            <div>
              <li class="list-group-item list-group-item-info"><button @click="transmitt" >送出</button></li>
            </div>
          </ul>
      </div>
  </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'
    import * as api from '../lib/api';
    export default { 
        data () {
          return {
            output:{ // 傳給後端API的資料
              name:[], // 網站名稱
              address:[], // 網站位址
              descript:[], // 網站描述
              type:[], // 網站類別
              permit: [] // 權限
            },
            flag: false,
            select_flag: false,
            webData: {
              selected_category: [ //下拉式選單
                {
                  id: Number(1),
                  status: false, // 沒有填寫到的欄位會CSS變化
                  value: ''
                }],
              website_sets: [
              {
                id: Number(1),
                wName: '',
                wstatus: false,  // 名稱狀態
                address: '',
                astatus: false,  // 網址狀態
                description: '',
                dstatus: false,  // 描述狀態
                permit: '',
                pstatus: false, // 權限狀態
                rowStatus: true // 加減號狀態
              }],
            },
            website_lists: [
              'personal',
              'company',
              'github',
              'others'
            ],
            permitList: []
          }
        },
        computed: {
            // ...mapGetters 為 ES7 寫法
            ...mapGetters({
                // getTodo return value 將會存在別名為 todos 的 webData 上
                users: 'getUser'
            }),
        },
        created () {
          this.getPermit()
        },
        methods: {
          getPermit () {
              let _this = this
              api.getData('/ee/api/api_permit.php', {
                  params: {
                    methods: 'select'
                  }
                })
                  .then(function (data) {
                      console.log(data);
                      if(!data.error)
                        _this.permitList = [...data]
                      else
                        alert(data.error);
                  })
                  .catch(function (error) {
                      alert(error);
                  })
          },
          toggleInput (id) {
              var index = this.webData.website_sets.findIndex(arr => arr.id === id ); // 取出目前欄位的index 
              if(this.webData.website_sets[index].rowStatus){
                  this.webData.website_sets[index].rowStatus = false;  // 加號變減號
                  this.webData.website_sets = [...this.webData.website_sets,{
                    id: this.webData.website_sets[this.webData.website_sets.length-1].id + 1,
                    wName: '',
                    wstatus: false,
                    address: '',
                    astatus: false,
                    description: '',
                    dstatus: false,
                    permit: '', // 存取權限
                    rowStatus: true
                  }],
                  this.webData.selected_category = [...this.webData.selected_category,{
                    id: this.webData.selected_category[this.webData.selected_category.length-1].id + 1,
                    status: false,
                    value: ''
                  }]
              }
              else {
                this.webData.website_sets = this.webData.website_sets.filter(item => item.id !== id); 
                this.webData.selected_category = this.webData.selected_category.filter(item => item.id !== id); // 移除目前id的輸入視窗
              }
          },
          transmitt: function () {
              this.webData.website_sets.map((arr, index) => {
                  if(!arr.permit){  // 網站權限
                      this.webData.website_sets[index].pstatus = true;
                      this.flag = true;
                  }
                  else
                      this.flag = false ; 
                  if(!arr.wName){
                      this.webData.website_sets[index].wstatus = true;
                      this.flag = true;
                  }
                  else
                      this.flag = false ; 
                  if(!arr.address){
                      this.webData.website_sets[index].astatus = true;
                      this.flag = true;
                  }
                  else
                      this.flag = false ; 
                  if(!arr.description){
                      this.webData.website_sets[index].dstatus = true; 
                      this.flag = true ;
                  }
                  else
                      this.flag = false ;
              });
              this.webData.selected_category.map((arr, index) => {
                  if(!arr.value){
                      this.webData.selected_category[index].status = true;
                      this.select_flag = true ;
                  }
                  else
                      this.select_flag = false ;             
              });
              if(this.flag || this.select_flag){
                  alert("尚有欄位未填寫");
                  return false;
              }                
              else {
                this.outData();
                // 送出資料至後端資料庫
                /*
                api.postData('/ee/api/api_web.php',{
                    methods: 'insert',
                    data: this.output
                  })
                  .then(function (user) {
                      console.log(user);
                      alert('傳輸成功');
                  })
                  .catch(function (error) {
                      
                  })
                */
                
                api.getData('/ee/api/api_web.php', {
                  params: {
                    methods: 'insert',
                    data: this.output
                  }
                })
                  .then(function (user) {
                      console.log(user);
                      if(user.success)
                        alert(user.success);
                      else
                        alert(user.error);
                  })
                  .catch(function (error) {
                      alert(error);
                  })
                  
              }
            },
            ifchange (index) {
                this.webData.website_sets.map((arr, index) => {
                  if(arr.wName) {
                    this.webData.website_sets[index].wstatus = false;
                  }
                  if(arr.address) {
                    this.webData.website_sets[index].astatus = false;
                  } 
                  if(arr.description) {
                    this.webData.website_sets[index].dstatus = false;
                  }
                  if(arr.permit) {
                    this.webData.website_sets[index].pstatus = false;
                  }
                });
                this.webData.selected_category.map((arr, index) => {
                  if(arr.value) {
                    this.webData.selected_category[index].status = false;
                  }
                });
            },
            outData() { // 將該網頁的資料存進output中
                var _this = this;
                _this.webData.website_sets.map((arr, index) =>{
                  _this.output.name[index] = arr.wName;
                  _this.output.address[index] = arr.address;
                  _this.output.descript[index] = arr.description;
                  _this.output.permit[index] = arr.permit;
                });
                _this.webData.selected_category.map((arr, index) =>{
                  _this.output.type[index] = arr.value;
                });
            }
          }
    }
</script>

<style scoped>
    .isNull {
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #EC0D9A;
      box-sizing: border-box;
    }
    .isNullSelect {
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border-color: #EC0D9A;
      box-sizing: border-box;
    }
</style>