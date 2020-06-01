<template>
  <div>
      <b-table striped hover outlined :fields="myFields" :items="getterWebDataList" @row-clicked="e => {e._showDetails = !e._showDetails}">
        <template v-slot:cell(id)="row">{{row.index +1 }}</template>
        <template v-slot:cell(name)="row">
          <b-link :href="row.item.address" target="_blank">{{ row.item.name }}</b-link>
        </template>
        <template v-slot:cell(詳情)="row">
          <b-button size="sm" @click="row.toggleDetails" class="mr-2" :class="{'btn-success':!row.detailsShowing}">
             {{ row.detailsShowing ? '縮小' : '詳情'}}
          </b-button>
        </template>
        <template v-slot:row-details="row">
        <b-card>
          <b-row align-v="center">
          <b-col cols=10>
            <b-row class="mb-1">
              <b-col cols="2" class=""><b>序號:</b></b-col>
              <b-col>{{ row.item.id }}</b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col cols="2" class=""><b>網站描述:</b></b-col>
              <b-col>{{ row.item.description }}</b-col>
            </b-row>
            <b-row class="mb-1">
              <b-col cols="2" class=""><b>詳細網址:</b></b-col>
              <b-col><b-link :href="row.item.address" target="_blank">{{ row.item.address }}</b-link></b-col>
            </b-row>
          </b-col>
          <b-col cols=2 align="center">
          <b-button size="sm" @click="row.toggleDetails">縮小</b-button>
          </b-col>
          </b-row>
        </b-card>
      </template>
      </b-table>
  </div>
</template>

<script>
    import { mapState, mapGetters, mapActions } from 'vuex';  
    import * as api from '../lib/api';
    export default {
        data () {
          return {
            myFields: [
              {key: 'id', label: 'NO',},
              {key: 'name', label: '網站名稱',},
              {key: 'type', label: '類型',},
              {key: 'publisher', label: '發布人',},
              {key: 'verifyTime', label: '發布日期',formatter:'datetimeFormat'},
              {key: '_showDetails', label: '詳情',},
            ],
          }
        },
        created () {
            let _this = this;
            this.action_web_get({status:1});
        },
        computed: {
          ...mapGetters(['getterWebDataList'])
        },
        methods: {
          ...mapActions(['action_web_get']),
          datetimeFormat(milliseconds,formatStr='YYYY-mm-dd HH:mm:ss'){
                if(!milliseconds)
                    return "";
                var d = new Date(milliseconds*1000);
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