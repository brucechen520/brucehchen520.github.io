<template>
  <div>
      
  </div>
</template>

<script>
    import Panel from './panel'
    import Vue from 'vue'

    export default {
       data: function () {
         return {
           navList: [
             {
               label: '§回會員系統'               
             },
             
             {
               label: '§網站列表',
               children: [
                  { label: '公開名片區' },
                  { label: '不公開名片區' },
                  { label: '公開名片區上傳' },
                  { label: '不公開名片區上傳' },
                  { label: '網站查詢' },
                  { label: '網站填寫' }
               ]
             },
             {
               label: '§工作媒合',
               children: [
                  { label: '職缺填寫' },
                  { label: '專案填寫' },
                  { label: '專長填寫' },
                  { label: '工作查詢' },
                  { label: '人才查詢' }
               ]
             },
             {
               label: '§登出'
             }
           ],
           show: false,
         }
       },
       methods: {
         DisplaySubDiv: function (child) {
            this.show = child !== undefined ? !this.show : this.show ;
            
         },
        
       }
    }
</script>

<style scoped>
    [v-cloak] {
      display: none;
    }

    body {
      font-family: "Open Sans", sans-serif;
      font-size: 18px;
      font-weight: 300;
      line-height: 1em;
    }
    
    .isShow {
        display:none;
    }


    .tabs {
        font-size: 14px;
        color: #657180;
    }

    .tabs-bar:after {
        content: '';
        display: block;
        width: 100%;
        height: 1px;
        background: #d7dde4;
        margin-top: -1px;
    }

    .tabs-tab {
        display: inline-block;
        padding: 4px 16px;
        margin-right: 6px;
        background: #fff;
        border: 1px solid #d7dde4;
        cursor: pointer;
        position: relative;
    }

    .tabs-tab-active {
        color: #3399ff;
        border-top: 1px solid #3399ff;
        border-bottom: 1px solid #fff;
    }

    .tabs-tab-active:before{
        content: '';
        display: block;
        height: 1px;
        background: #3399ff;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
    }

    .tab-content{
        padding: 8px 0;
    }
    .close {
        
        width: 60px;
        height: 60px;
        position: relative;
    }
    .close:after {
        content: '';
        height: 30px;
        border-left: 4px solid red;
        position: absolute;
        transform: rotate(45deg);
        left: 28px;
    }
    .close:before {
        content: '';
        height: 30px;
        border-left: 4px solid red;
        position: absolute;
        transform: rotate(-45deg);
        left: 28px;
    }
    


    
</style>
