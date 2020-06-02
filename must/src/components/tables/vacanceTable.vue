<template>
    <div>
        <b-table striped hover outlined :fields="editable ? fieldsPersonal : fields" :items="items" @row-clicked="e => {e._showDetails = !e._showDetails}">
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
                    <b-col cols=2 class=""><b>序號:</b></b-col>
                    <b-col>{{ row.item.id }}</b-col>
                </b-row>
                <b-row class="mb-1">
                    <b-col cols=2 class=""><b>職缺內容描述:</b></b-col>
                    <b-col>{{ row.item.description }}</b-col>
                </b-row>
                    <b-row class="mb-1">
                    <b-col cols=2 class=""><b>工作待遇:</b></b-col>
                    <b-col>{{ row.item.offer }}</b-col>
                </b-row>
                <b-row class="mb-1">
                    <b-col cols=2 class=""><b>上班地點:</b></b-col>
                    <b-col>{{row.item.location}}</b-col>
                </b-row>
                <b-row class="mb-1">
                    <b-col cols=2 class=""><b>公司網址:</b></b-col>
                    <b-col><b-link :href="row.item.company_Website" target="_blank">{{ row.item.company_Website }}</b-link></b-col>
                </b-row>
                <b-row class="mb-1">
                    <b-col cols=2 class=""><b>聯絡人:</b></b-col>
                    <b-col>{{ row.item.contact_Name }}</b-col>
                </b-row>
                <b-row class="mb-1">
                    <b-col cols=2 class=""><b>E-mail:</b></b-col>
                    <b-col>{{ row.item.contact_Mail }}</b-col>
                </b-row>
                <b-row class="mb-1">
                    <b-col cols=2 class=""><b>連絡電話:</b></b-col>
                    <b-col>{{ row.item.contact_Phone }}</b-col>
                </b-row>
                <b-row class="mb-1">
                    <b-col cols=2 class=""><b>方便聯絡時間:</b></b-col>
                    <b-col>{{ row.item.contact_Time }}</b-col>
                </b-row>
                <b-row v-if="editable" class="mb-1">
                    <b-col sm="2" class=""><b>管理員建議:</b></b-col>
                    <b-col>{{ row.item.suggestion}}</b-col>
                </b-row>
                </b-col>
                <b-col cols=2 align="center">
                <b-button class="mb-2" size="sm" v-if="editable" variant="warning" @click="editItem(row.item)">修改</b-button><br>
                <b-button class="mb-2" size="sm" v-if="editable" variant="danger" @click="deleteItem(row.item)">刪除</b-button><br>
                <b-button size="sm" @click="row.toggleDetails">縮小</b-button>
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
            deleteItem:{type:Function}
        },
        components: {
        },
        data () {
          return {
            fields: [
              {key: 'id', label: 'NO'},
              {key: 'vacancy_Name', label: '職缺名稱'},
              {key: 'company_Name', label: '公司名稱'},
              {key: 'M_Name', label: '發布人'},
              {key: 'verifyTime', label: '發布日期'},
              {key: '_showDetails', label: '詳情'},
            ],
            fieldsPersonal: [
              {key: 'id', label: 'NO'},
              {key: 'vacancy_Name', label: '職缺名稱'},
              {key: 'company_Name', label: '公司名稱'},
              {key: 'M_Name', label: '發布人'},
              {key: 'verifyTime', label: '發布日期'},
              {key: 'status', label: '狀態',formatter: e => this.statusdesc[e]},
              {key: '_showDetails', label: '詳情'},
            ],
            statusdesc:["待審核","審核通過","審核不通過","已封存"],
          }
        },
    }
</script>