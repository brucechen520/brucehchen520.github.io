<template>
  <div>
    <div class="container">
      <b-card title="Card Title" no-body>
      <b-card-header header-tag="nav">
        <b-nav card-header tabs>
          <b-nav-item :active="selectType==1" @click="selectType=1">職缺類({{stateVacanceData.totalCount}})</b-nav-item>
          <b-nav-item :active="selectType==2" @click="selectType=2">專案類({{stateProjectData.totalCount}})</b-nav-item>
        </b-nav>
      </b-card-header>

      <b-card-body class="text-left">
        <vacance-table v-if="selectType==1" :items="getterVacancyDataList"></vacance-table>
        <project-table v-if="selectType==2" :items="getterProjectDataList"></project-table>
      </b-card-body>
    </b-card>        
    </div>
  </div>
</template>

<script>
    import {mapState, mapGetters, mapActions } from 'vuex';
    import vacanceTable from '../tables/vacanceTable.vue'
    import projectTable from '../tables/projectTable.vue'
    export default {
        components: {
          vacanceTable,
          projectTable
        },
        data () {
          return {
            msg: '工作查詢',
            selectType:1,
          }
        },
        created() {
          this.action_project_get({status:1});
          this.action_vacance_get({status:1});
        },
        computed:{
          ...mapState(['stateProjectData','stateVacanceData']),
          ...mapGetters(['getterVacancyDataList','getterProjectDataList'])
        },
        methods:{
          ...mapActions(['action_project_get','action_vacance_get',]),
          datetimeFormat(milliseconds,formatStr='YYYY-mm-dd HH:mm:ss'){
            if(!milliseconds)
                return "";
            var d = new Date(milliseconds);
            if(formatStr=='YYYY-mm-dd HH:mm:ss'){
                return d.getFullYear() +"-"+ ((d.getMonth()+1 >9)?(d.getMonth()+1):"0"+(d.getMonth()+1))+"-"+((d.getDate() >9)?d.getDate():"0"+d.getDate())+" "+(d.getHours()>9?d.getHours():"0"+d.getHours())+":"+(d.getMinutes()>9?d.getMinutes():"0"+d.getMinutes())+":"+(d.getSeconds()>9?d.getSeconds():"0"+d.getSeconds());
            }else{
                return d.getFullYear() +"-"+ ((d.getMonth()+1 >9)?(d.getMonth()+1):"0"+(d.getMonth()+1))+"-"+((d.getDate() >9)?d.getDate():"0"+d.getDate());
            }
          },
        }
    }
</script>

<style>

</style>