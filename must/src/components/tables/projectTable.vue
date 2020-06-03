<template>
    <div>
        <b-table striped hover outlined :fields="(editable || auditable) ? fieldsPersonal : fields" :items="items" @row-clicked="e => {e._showDetails = !e._showDetails}">
            <template v-slot:cell(id)="row">{{row.index +1 }}</template>
            <template v-slot:cell(name)="row">
            <b-link :href="row.item.address" target="_blank">{{ row.item.name }}</b-link>
            </template>
            <template v-slot:cell(_showDetails)="row">
            <b-button size="sm" @click="row.toggleDetails" class="mr-2" :class="{'btn-success':!row.detailsShowing}">
                {{ row.detailsShowing ? '縮小' : '詳情'}}
            </b-button>
            </template>
            <template v-slot:row-details="row">
                <b-card>
                <b-row align-v="center">
                <b-col cols=10>
                <b-row class="mb-1">
                <b-col cols=3 class=""><b>序號:</b></b-col>
                <b-col>{{ row.item.id }}</b-col>
                </b-row>
                <b-row class="mb-1">
                <b-col cols=3 class=""><b>專案描述:</b></b-col>
                <b-col>{{ row.item.description }}</b-col>
                </b-row>
                <b-row class="mb-1">
                <b-col cols=3 class=""><b>案件預算:</b></b-col>
                <b-col>{{ row.item.offer }}</b-col>
                </b-row>
                <b-row class="mb-1">
                <b-col cols=3 class=""><b>截止期限:</b></b-col>
                <b-col>{{datetimeFormat(parseInt(row.item.deadline))}}</b-col>
                </b-row>
                <b-row class="mb-1">
                <b-col cols=3 class=""><b>公司網址:</b></b-col>
                <b-col><b-link :href="row.item.company_Website" target="_blank">{{ row.item.company_Website }}</b-link></b-col>
                </b-row>
                <b-row class="mb-1">
                <b-col cols=3 class=""><b>聯絡人:</b></b-col>
                <b-col>{{ row.item.contact_Name }}</b-col>
                </b-row>
                <b-row class="mb-1">
                <b-col cols=3 class=""><b>E-mail:</b></b-col>
                <b-col>{{ row.item.contact_Mail }}</b-col>
                </b-row>
                <b-row class="mb-1">
                <b-col cols=3 class=""><b>連絡電話:</b></b-col>
                <b-col>{{ row.item.contact_Phone }}</b-col>
                </b-row>
                <b-row class="mb-1">
                <b-col cols=3 class=""><b>方便聯絡時間:</b></b-col>
                <b-col>{{ row.item.contact_Time }}</b-col>
                </b-row>
                <b-row v-if="editable || auditable" class="mb-1">
                    <b-col cols=3 class=""><b>管理員建議:</b></b-col>
                    <b-col>{{ row.item.suggestion}}</b-col>
                </b-row>
                </b-col>
                <b-col cols=2 align="center">
                <b-button class="mb-2" size="sm" v-if="editable" variant="warning" @click="editItem(row.item)">修改</b-button><br>
                <b-button class="mb-2" size="sm" v-if="editable" variant="danger" @click="deleteItem(row.item)">刪除</b-button><br>
                <b-button class="mb-2" size="sm" v-if="auditable" variant="info" @click="auditItem(row.item)">審核</b-button><br>
                <b-button class="mb-2" size="sm" @click="row.toggleDetails">縮小</b-button>
                </b-col>
                </b-row>
                </b-card>
            </template>
        </b-table>
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
              {key: 'project_Name', label: '專案名稱'},
              {key: 'company_Name', label: '公司名稱'},
              {key: 'M_Name', label: '發布人'},
              {key: 'verifyTime', label: '發布日期'},
              {key: '_showDetails', label: '詳情'},
            ],
            fieldsPersonal: [
              {key: 'id', label: 'NO'},
              {key: 'project_Name', label: '專案名稱'},
              {key: 'company_Name', label: '公司名稱'},
              {key: 'M_Name', label: '發布人'},
              {key: 'verifyTime', label: '發布日期'},
              {key: 'status', label: '狀態',formatter: e => this.statusdesc[e]},
              {key: '_showDetails', label: '詳情'},
            ],
            statusdesc:["待審核","審核通過","審核不通過","已封存"],
          }
        },
        methods:{
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