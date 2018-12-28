<template>
  <div>
      
  </div>
</template>

<script>
    export default {
        props: {
            whicitem: {
              Type: Number
            }
        },
        
        data: function () {
          return {
            subNavList: [
              [],
              ['公開名片區','不公開名片區','公開名片區上傳','不公開名片區上傳','網站查詢','網站填寫'],
              ['職缺填寫', '專案填寫', '專長填寫', '工作查詢', '人才查詢'],
              []
           ]
          }
        }
    }
</script>

<style>

</style>