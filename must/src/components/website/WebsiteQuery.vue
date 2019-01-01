<template>
  <div>
      <!-- 查詢 -->
      <div>
          <button>查詢</button>
          <select v-model="query">
            <option disabled value="">請選擇</option>
            <option v-for="webList in website_lists" :value=webList>{{ webList }}</option>
          </select>
      </div>  
      <!-- 網站頁面 -->
      <div>
        <div v-for = "item in website_sets" class="content">
          <div> 姓名: {{ item.name}} </div>
          <div> 序號: {{ item.id}} </div>
          <div> 網站名稱: {{ item.wName}} </div>
          <div> 網站類型: {{ item.type}} </div>
          <div> 網址: {{ item.address}} </div>
          <div> 網站描述: {{ item.description}} </div>
        </div>

      </div>

  </div>
</template>

<script>
    export default {
        data () {
          return {
            query: '',
            website_lists: [
              'personal',
              'company',
              'others'
            ],
            website_sets: [
              {
                id: Number(1),
                type: 'others',
                name: '陳十二',
                wName: 'GOOGLE',
                address: 'https://www.google.com',
                description: '推薦很好的搜尋網站'
              }
            ],
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