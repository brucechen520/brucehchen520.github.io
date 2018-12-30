<template>
  <div>
      <div>
        <ul>
          <div>
             <li>姓名:<input type="text" ></li>
          </div>
          <div>
              <li v-for="(website_set, index) in website_sets">
                網站名稱:<input type="text" v-model="website_set.name">
                類別:<select v-model="selected_category" >
                        <option value="">請選擇</option>
                        <option v-for="webList in website_lists" :value=webList>{{ webList }}</option>
                      </select>
                網址:<input type="text" v-model="website_set.address">
                敘述:<input type="text" v-model="website_set.description">
                <button @click="deleteRow(index)">Delete</button>
              </li>
              <button @click="addRow">Add row</button>
            </div>
          </div>
          <div>
             <li><button>送出</button></li>
          </div>
        </ul>
      </div>
  </div>
</template>

<script>
    export default {
        data () {
          return {
            selected_category: '',
            website_sets: [
              {
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
              wName: '',
              address: '',
              description: ''
            })
          },
          deleteRow(index) {
            this.website_sets.splice(index,1)
          }
        }
    }
</script>

<style scoped>
    
</style>