<template>
    <div>
      <b-table class="gs-md" striped hover outlined :fields="(editable || auditable) ? fieldsPersonal : fields" :items="items" @row-clicked="e => {e._showDetails = !e._showDetails}">
        <template v-slot:cell(id)="row">{{row.index +1 }}</template>
        <template v-slot:cell(name)="row">
          <b-link :href="row.item.url" target="_blank">{{ row.item.name }}</b-link>
        </template>
        <template v-slot:cell(_showDetails)="row">
          <b-button size="sm" @click="row.toggleDetails" class="mr-2" :class="{'btn-success':!row.detailsShowing}">
             {{ row.detailsShowing ? '收合' : '詳情'}}
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
              <b-col><b-link :href="row.item.url" target="_blank">{{ row.item.urlShort }}</b-link></b-col>
            </b-row>
            <b-row v-if="editable || auditable" class="mb-1">
                <b-col sm="2" class=""><b>管理員建議:</b></b-col>
                <b-col>{{ row.item.suggestion}}</b-col>
            </b-row>
          </b-col>
          <b-col cols=2 align="center">
            <b-button class="mb-2" size="sm" v-if="editable" variant="warning" @click="editItem(row.item)">修改</b-button><br>
            <b-button class="mb-2" size="sm" v-if="editable" variant="danger" @click="deleteItem(row.item)">刪除</b-button><br>
            <b-button class="mb-2" size="sm" v-if="auditable" variant="info" @click="auditItem(row.item)">審核</b-button><br>
            <b-button size="sm" @click="row.toggleDetails">收合</b-button>
          </b-col>
          </b-row>
        </b-card>
        </template>
      </b-table>
      <div class="ls-md">
      <template v-for="item in items">
      <b-card :title="item.name" :sub-title="item.publisher + ' ' + datetimeFormat(item.verifyTime,'YYYY-mm-dd')" :key="item.id">
        <b-card-text>
          {{item.description}}
        </b-card-text>
        <b-button v-if="item.url" variant="success" :href="item.url" target="_blank">前往網站</b-button>
        <div v-if="(editable || auditable)">
        <hr>
        <b-badge :variant="badgeVariant[item.status]">{{statusdesc[item.status]}}</b-badge>
        <b-card-text v-if="item.suggestion">
          <div class="card-subtitle text-muted">管理員建議</div>
          {{item.suggestion}}
        </b-card-text>
        </div>
        <template v-if="(editable || auditable)" v-slot:footer>
        <b-button class="mr-2" v-if="editable" variant="warning" @click="editItem(item)">修改</b-button>
        <b-button class="mr-2" v-if="editable" variant="danger" @click="deleteItem(item)">刪除</b-button>
        <b-button class="mr-2" v-if="auditable" variant="info" @click="auditItem(item)">審核</b-button>
        </template>
      </b-card>
      </template>
      </div>
  </div>
</template>
<script>
    export default {
        props:{
            items:{
                type:Array,
                default:[],
            },
            editable:{default:false},
            editItem:{type:Function},
            deleteItem:{type:Function},
            auditable:{default:false},
            auditItem:{type:Function},
        },
        components: {
        },
        data () {
          return {
            fields: [
              {key: 'id', label: 'NO'},
              {key: 'name', label: '網站名稱'},
              {key: 'type', label: '類型'},
              {key: 'publisher', label: '發布人'},
              {key: 'verifyTime', label: '發布日期',formatter:'datetimeFormat'},
              {key: '_showDetails', label: '詳情'},
            ],
            fieldsPersonal: [
              {key: 'id', label: 'NO',},
              {key: 'name', label: '網站名稱',},
              {key: 'type', label: '類型',},
              {key: 'publisher', label: '發布人',},
              {key: 'verifyTime', label: '發布日期',formatter:'datetimeFormat'},
              {key: 'status', label: '狀態',formatter: e => this.statusdesc[e]},
              {key: '_showDetails', label: '詳情'},
              ],
            statusdesc:["待審核","審核通過","審核不通過","隱藏"],
            badgeVariant:["secondary","success","danger","dark"]
          }
        },
        methods: {
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
<style scoped>

</style>