<template>
  <div>
      <div>
          <ul>
            <div>
              <li>姓名:<input type="text" v-model="name"></li>
            </div>
            <div>
                <li v-for="(website_set, index) in website_sets">
                  網站名稱:<input type="text" v-model="website_set.wName" :name="nameId[index].id" 
                                 :class="{'isNull': nameId[index].status}">
                  <label v-if="nameId[index].status">【請填寫網站名稱】</label>
                  類別:<select v-model="selected_category[index].value" :class="{'isNullSelect': selected_category[index].status}">
                          <option disabled value="">請選擇</option>
                          <option v-for="webList in website_lists" :value=webList>{{ webList }}</option>
                        </select>
                  網址:<input type="text" v-model="website_set.address" :name="networkId[index]"
                              :class="{'isNull': networkId[index].status}">
                  敘述:<input type="text" v-model="website_set.description" :name="descriptId[index]"
                              :class="{'isNull': descriptId[index].status}">
                  <button @click="deleteRow(index)">Delete</button>
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
            name: '',
            nameId: [{
              id: Number(1),
              status: false
            }],
            networkId: [{
              id: Number(1),
              status: false
            }],
            descriptId: [{
              id: Number(1),
              status: false
            }],
            selected_category: [
              {
                id: Number(1),
                status: false,
                value: ''
              }
            ],
            website_sets: [
              {
                id: Number(1),
                wName: '',
                address: '',
                description: ''
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
            this.website_sets.push({
              id: this.website_sets[this.website_sets.length-1].id + 1,
              wName: '',
              address: '',
              description: ''
            });
            this.selected_category.push({
              id: this.selected_category[this.selected_category.length-1].id + 1,
              status: false,
              value: ''              
            });
            this.nameId.push({
              id: this.nameId[this.nameId.length-1].id + 1,
              status: false
            });
            this.networkId.push({
              id: this.networkId[this.networkId.length-1].id + 1,
              status: false
            });
            this.descriptId.push({
              id: this.descriptId[this.descriptId.length-1].id + 1,
              status: false
            });
          },
          deleteRow(index) {
            this.website_sets.splice(index,1);
            this.selected_category.splice(index,1);
            this.nameId.splice(index,1);
            this.networkId.splice(index,1);
            this.descriptId.splice(index,1);
          },
          transmitt: function () {
              this.website_sets.map((arr, index) => {
                  if(!arr.wName){
                      this.nameId[index].status = true;
                      this.flag = true;
                  }            
                  else
                      this.flag = false ; 
                  if(!arr.address){
                      this.networkId[index].status = true;
                      this.flag = true;
                  }
                  else
                      this.flag = false ; 
                  if(!arr.description){
                      this.descriptId[index].status = true; 
                      this.flag = true ;
                  }
                  else
                      this.flag = false ;                
              });
              this.selected_category.map((arr, index) => {
                  if(!arr.value){
                      this.nameId[index].status = true;
                      this.flag = true ;
                  }
                  else
                      this.flag = false ;                    
              });
              if(this.flag)
                return false;
              else {
                // 送出資料至後端資料庫
                alert("123");
                console.log(this.name);
                this.website_sets.map(arr => console.log(arr.id+" "+arr.wName+" "+arr.address+" "+arr.description));
                this.selected_category.map(arr => console.log(arr.id+" "+arr.value));
              }
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