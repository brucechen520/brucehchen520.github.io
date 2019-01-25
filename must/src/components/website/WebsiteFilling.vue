<template>
  <div>
      <div>
          users: {{ users }}
          <ul>
            <div>
              <li>姓名:<input type="text" v-model="name"></li>
            </div>
            <div>
                <li v-for="(website_set, index) in webData.website_sets">
                  網站名稱:<input type="text" 
                                  v-model="website_set.wName"
                                 :class="{'isNull': website_set.wstatus}"
                                 @change="ifchange(index)">

                  <label v-if="website_set.wstatus">【請填寫網站名稱】</label>
                  
                  類別:<select v-model="webData.selected_category[index].value" 
                              :class="{'isNullSelect': webData.selected_category[index].status}">

                          <option disabled value="">請選擇</option>
                          <option v-for="webList in website_lists" 
                                  :value="webList">{{ webList }}</option>
                        </select>

                  網址:<input type="text" 
                              v-model="website_set.address"
                              :class="{'isNull': website_set.astatus}"
                              @change="ifchange(index)">

                  敘述:<input type="text" 
                              v-model="website_set.description"
                              :class="{'isNull': website_set.dstatus}"
                              @change="ifchange(index)">
                  <button @click="deleteRow(website_set.id)" :disabled="index===0">Delete</button>
                </li>
                <button @click="addRow">Add row</button>
              </div>
            </div>
            <div>
              <li><button @click="transmitt" >送出</button></li>
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
              name:[],
              address:[],
              descript:[],
              type:[]
            },
            name: '',
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
                wstatus: false,
                address: '',
                astatus: false,
                description: '',
                dstatus: false
              }],
            },
            website_lists: [
              'personal',
              'company',
              'github',
              'others'
            ]
          } 
        },
        computed: {
            // ...mapGetters 為 ES7 寫法
            ...mapGetters({
                // getTodo return value 將會存在別名為 todos 的 webData 上
                users: 'getUser'
            }),
        },
        methods: {
          addRow() {
            this.webData.website_sets = [...this.webData.website_sets,{
              id: this.webData.website_sets[this.webData.website_sets.length-1].id + 1,
              wName: '',
              wstatus: false,
              address: '',
              astatus: false,
              description: '',
              dstatus: false
            }],
            this.webData.selected_category = [...this.webData.selected_category,{
              id: this.webData.selected_category[this.webData.selected_category.length-1].id + 1,
              status: false,
              value: ''
            }]
          },
          deleteRow(id) {
            // 把等於這個ID的欄位過濾出來，不等於得欄位都存在一個陣列中返回原本陣列
            this.webData.website_sets = this.webData.website_sets.filter(item => item.id !== id); 
            this.webData.selected_category = this.webData.selected_category.filter(item => item.id !== id);
          },
          transmitt: function () {
              this.webData.website_sets.map((arr, index) => {
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
              if(this.flag )
                return false;
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
                });
                _this.webData.selected_category.map((arr, index) =>{
                  _this.output.type[index] = arr.value;
                });
                //console.log(this.output);
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