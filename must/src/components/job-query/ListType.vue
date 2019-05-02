<template>
  <div>
    	
  </div>
</template>

<script>
    export default {
      created () {
          
      },
      data () {

      },
      computed: {
        // ...mapGetters 為 ES7 寫法
        ...mapGetters({
            // getTodo return value 將會存在別名為 todos 的 webData 上
            selected: 'getJob'
        }),
      },
      methods: {
      	
      }
    }
</script>

<style>

</style>