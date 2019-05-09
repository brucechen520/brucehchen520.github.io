<template>
  <div>
    	
  </div>
</template>

<script>
	import { mapGetters, mapActions } from 'vuex';
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
      	...mapActions([
	      'changeSelected',
	      'setCount'
	    ]),
	    
      }
    }
</script>

<style>

</style>