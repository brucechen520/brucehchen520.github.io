<template>
  <div>
      <div>
          <ul>
            <div>
              <li>姓名:<input type="text" v-model="name"></li>
            </div>
            <div>
                <li v-for="(website_set, index) in website_sets">
                  網站名稱:<input type="text" 
                                  v-model="website_set.wName"
                                 :class="{'isNull': website_set.wstatus}"
                                 @change="ifchange(index)">

                  <label v-if="website_set.wstatus">【請填寫網站名稱】</label>
                  
                  類別:<select v-model="selected_category[index].value" 
                              :class="{'isNullSelect': selected_category[index].status}">

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
    export default { 
        data () {
          return {
            flag: false,
            select_flag: false,
            name: '',
            selected_category: [ //下拉式選單
              {
                id: Number(1),
                status: false, // 沒有填寫到的欄位會CSS變化
                value: ''
              }
            ],
            website_sets: [
              {
                id: Number(1),
                wName: '',
                wstatus: false,
                address: '',
                astatus: false,
                description: '',
                dstatus: false
              }
            ],
            website_lists: [
              'personal',
              'company',
              'others'
            ]
          } 
        },
        methods: {
          addRow() {
            this.website_sets = [...this.website_sets,{
              id: this.website_sets[this.website_sets.length-1].id + 1,
              wName: '',
              wstatus: false,
              address: '',
              astatus: false,
              description: '',
              dstatus: false
            }],
            this.selected_category = [...this.selected_category,{
              id: this.selected_category[this.selected_category.length-1].id + 1,
              status: false,
              value: ''
            }]
          },
          deleteRow(id) {
            // 把等於這個ID的欄位過濾出來，不等於得欄位都存在一個陣列中返回原本陣列
            this.website_sets = this.website_sets.filter(item => item.id !== id); 
            this.selected_category = this.selected_category.filter(item => item.id !== id);
          },
          transmitt: function () {
              this.website_sets.map((arr, index) => {
                  if(!arr.wName){
                      this.website_sets[index].wstatus = true;
                      this.flag = true;
                  }
                  else
                      this.flag = false ; 
                  if(!arr.address){
                      this.website_sets[index].astatus = true;
                      this.flag = true;
                  }
                  else
                      this.flag = false ; 
                  if(!arr.description){
                      this.website_sets[index].dstatus = true; 
                      this.flag = true ;
                  }
                  else
                      this.flag = false ;                
              });
              this.selected_category.map((arr, index) => {
                  if(!arr.value){
                      this.selected_category[index].status = true;
                      this.select_flag = true ;
                  }
                  else
                      this.select_flag = false ;             
              });
              if(this.flag )
                return false;
              else {
                // 送出資料至後端資料庫
                alert("123");
                console.log(this.name);
                this.website_sets.map(arr => console.log(arr.id+" "+arr.wName+" "+arr.address+" "+arr.description));
                this.selected_category.map(arr => console.log(arr.id+" "+arr.value));
              }
            },
            ifchange (index) {
                this.website_sets.map((arr, index) => {
                  if(arr.wName) {
                    this.website_sets[index].wstatus = false;
                  }
                  if(arr.address) {
                    this.website_sets[index].astatus = false;
                  } 
                  if(arr.description) {
                    this.website_sets[index].dstatus = false;
                  }
                });
                this.selected_category.map((arr, index) => {
                  if(arr.value) {
                    this.selected_category[index].status = false;
                  }
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