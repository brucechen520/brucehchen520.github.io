<template>
  <div>
    	<div class="list-group container">
          <div class="btn badge badge-pill badge-dark" @click="action_set_review_type(0)">外包專案</div>
          <div class="btn badge badge-pill badge-dark" @click="action_set_review_type(1)">工作職缺</div>
          <div class="btn badge badge-pill badge-dark" @click="action_set_review_type(2)">網站</div>
      </div>
  </div>
</template>

<script>
  import { api2 } from '../../assets/api.js'
	import { mapState, mapGetters, mapActions } from 'vuex';  
  import * as api from '../lib/api';
    export default {
      props: ['selectType'],
      created () {

      },
      mounted () {        
      },
      data () {
          return {
          }
      },
      computed: {
        // ...mapGetters 為 ES7 寫法
        ...mapState(['stateProjectData','stateVacanceData','stateWebData']),
      },
      methods: {
      	...mapActions([
  	      'action_project_get','action_vacance_get','action_set_review_type','action_web_get'
  	    ]),
      }
    }
</script>

<style>

</style>