<template>
  <div>
    	<div class="list-group container">
          <div class="btn badge badge-pill badge-dark" @click="action_set_review_type(0)">外包專案: {{ stateProjectData.totalCount }}</div>
          <div class="btn badge badge-pill badge-dark" @click="action_set_review_type(1)">工作職缺: {{ stateVacanceData.totalCount }}</div>
          <div class="btn badge badge-pill badge-dark" @click="action_set_review_type(2)">網站: {{ stateWebData.totalCount }}</div>
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
        this.action_project_get({status:0});
        this.action_vacance_get({status:0});
        this.action_web_get({status:0});
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