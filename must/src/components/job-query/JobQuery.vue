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
        <b-table v-if="selectType==1" striped hover outlined :fields="vacancyFields" :items="stateVacanceData.list">
          <template v-slot:cell(id)="row">{{row.index +1 }}</template>
          <template v-slot:cell(name)="row">
            <b-link :href="row.item.address" target="_blank">{{ row.item.name }}</b-link>
          </template>
          <template v-slot:cell(詳情)="row">
            <b-button size="sm" @click="row.toggleDetails" class="mr-2">
              {{ row.detailsShowing ? '縮小' : '詳情'}}
            </b-button>
          </template>
          <template v-slot:row-details="row">
          <b-card>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>序號:</b></b-col>
              <b-col>{{ row.item.id }}</b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>職缺內容描述:</b></b-col>
              <b-col>{{ row.item.description }}</b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>工作待遇:</b></b-col>
              <b-col>{{ row.item.offer }}</b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>上班地點:</b></b-col>
              <b-col>{{row.item.location}}</b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>公司網址:</b></b-col>
              <b-col><b-link :href="row.item.company_Website" target="_blank">{{ row.item.company_Website }}</b-link></b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>聯絡人:</b></b-col>
              <b-col>{{ row.item.contact_Name }}</b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>E-mail:</b></b-col>
              <b-col>{{ row.item.contact_Mail }}</b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>連絡電話:</b></b-col>
              <b-col>{{ row.item.contact_Phone }}</b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>方便聯絡時間:</b></b-col>
              <b-col>{{ row.item.contact_Time }}</b-col>
            </b-row>

            <b-button size="sm" @click="row.toggleDetails">縮小</b-button>
          </b-card>
        </template>
        </b-table>
        <b-table v-if="selectType==2" striped hover outlined :fields="projectFields" :items="stateProjectData.list">
          <template v-slot:cell(id)="row">{{row.index +1 }}</template>
          <template v-slot:cell(name)="row">
            <b-link :href="row.item.address" target="_blank">{{ row.item.name }}</b-link>
          </template>
          <template v-slot:cell(詳情)="row">
            <b-button size="sm" @click="row.toggleDetails" class="mr-2">
              {{ row.detailsShowing ? '縮小' : '詳情'}}
            </b-button>
          </template>
          <template v-slot:row-details="row">
          <b-card>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>序號:</b></b-col>
              <b-col>{{ row.item.id }}</b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>專案描述:</b></b-col>
              <b-col>{{ row.item.description }}</b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>案件預算:</b></b-col>
              <b-col>{{ row.item.offer }}</b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>截止期限:</b></b-col>
              <b-col>{{datetimeFormat(parseInt(row.item.deadline))}}</b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>公司網址:</b></b-col>
              <b-col><b-link :href="row.item.company_Website" target="_blank">{{ row.item.company_Website }}</b-link></b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>聯絡人:</b></b-col>
              <b-col>{{ row.item.contact_Name }}</b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>E-mail:</b></b-col>
              <b-col>{{ row.item.contact_Mail }}</b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>連絡電話:</b></b-col>
              <b-col>{{ row.item.contact_Phone }}</b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col sm="2" class=""><b>方便聯絡時間:</b></b-col>
              <b-col>{{ row.item.contact_Time }}</b-col>
            </b-row>

            <b-button size="sm" @click="row.toggleDetails">縮小</b-button>
          </b-card>
        </template>
        </b-table>
      </b-card-body>
    </b-card>        
    </div>
  </div>
</template>

<script>
    import {mapState, mapGetters, mapActions } from 'vuex';
    import DatePicker from 'vue2-datepicker' ;

    export default {
        components: {
        },
        data () {
          return {
            msg: '工作查詢',
            selectType:1,
            projectFields: [
              {key: 'id', label: 'NO'},
              {key: 'project_Name', label: '專案名稱'},
              {key: 'company_Name', label: '公司名稱'},
              {key: 'M_Name', label: '發布人'},
              {key: 'verifyTime', label: '發布日期'},
              '詳情',
            ],
            vacancyFields: [
              {key: 'id', label: 'NO'},
              {key: 'vacancy_Name', label: '職缺名稱'},
              {key: 'company_Name', label: '公司名稱'},
              {key: 'M_Name', label: '發布人'},
              {key: 'verifyTime', label: '發布日期'},
              '詳情',
            ],
          }
        },
        created() {
          this.action_project_get({status:1});
          this.action_vacance_get({status:1});
        },
        computed:{
          ...mapState(['stateProjectData','stateVacanceData']),
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