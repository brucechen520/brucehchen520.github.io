<template>
  <div>
    <div class="container">
    <b-table class="gs-md" striped hover outlined :fields="memberFields" :items="gettetMemberDataList" @row-clicked="e => {e._showDetails = !e._showDetails}">
        <template v-slot:cell(id)="row">{{row.index +1 }}</template>
        <template v-slot:cell(level)="row">{{row.item.level}}{{row.item.level?'級':''}}{{classDesc[row.item.class]}}{{row.item.class?'班':''}}</template>
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
            <b-col cols=2 class=""><b>編號:</b></b-col>
            <b-col>{{ row.item.Mem_Se }}</b-col>
          </b-row>
          <b-row class="mb-1">
            <b-col cols=2 class=""><b>電話:</b></b-col>
            <b-col>{{ row.item.cellphone }}</b-col>
          </b-row>
          <b-row class="mb-1">
            <b-col cols=2 class=""><b>信箱:</b></b-col>
            <b-col>{{ row.item.mail }}</b-col>
          </b-row>
          <b-row class="mb-1">
            <b-col cols="2" class=""><b>技能專長:</b></b-col>
            <b-col>{{ row.item.expertise }}</b-col>
        </b-row>
          <b-row class="mb-1">
            <b-col cols=2 class=""><b>作品:</b></b-col>
            <b-col>{{ row.item.works }}</b-col>
          </b-row>
          <b-row class="mb-1">
            <b-col cols=2 class=""><b>證照:</b></b-col>
            <b-col>{{ row.item.license }}</b-col>
          </b-row>
          <b-row class="mb-1">
            <b-col cols=2 class=""><b>自我介紹:</b></b-col>
            <b-col><pre>{{ row.item.biography }}</pre></b-col>
          </b-row>
          </b-col>
          <b-col cols=2 align="center">
          <b-button size="sm" @click="row.toggleDetails">收合</b-button>
          </b-col>
          </b-row>
        </b-card>
      </template>
      </b-table>
          <div class="ls-md">
      <template v-for="item in gettetMemberDataList">
        <b-card :key="item.Mem_Se">
          <div class="d-flex justify-content-between">
          <h4 class="d-inline-block">{{item.name}}</h4>
          <h6 class="d-inline-block text-muted">{{item.level + (item.level?'級':'')}}{{classDesc[item.class] + (item.class?'班':'')}}</h6>
          </div>
          <hr />
          <b-card-text>{{item.jobExpect}}</b-card-text>
          <b-button variant="success" block @click="$bvModal.show('bv-modal-example'),focusItem=item">詳情</b-button>
        </b-card>
      </template>
    </div>
    <b-modal id="bv-modal-example" hide-footer>
      <template v-slot:modal-title>詳情</template>
      <b-card>
        <b-row class="mb-1">
          <b-col cols="5">
            <b>編號:</b>
          </b-col>
          <b-col>{{ focusItem.Mem_Se }}</b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="5">
            <b>姓名:</b>
          </b-col>
          <b-col>{{ focusItem.name }}</b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="5">
            <b>電話:</b>
          </b-col>
          <b-col>{{ focusItem.cellphone }}</b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="5" class>
            <b>信箱:</b>
          </b-col>
          <b-col>{{ focusItem.mail }}</b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="5" class>
            <b>技能專長:</b>
          </b-col>
          <b-col>{{focusItem.expertise}}</b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="5" class>
            <b>作品:</b>
          </b-col>
           <b-col>{{focusItem.works}}</b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="5" class>
            <b>證照:</b>
          </b-col>
          <b-col>{{ focusItem.license }}</b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="12">
            <b>自我介紹:</b>
          </b-col>
          <b-col><div class="p-2 bg-light"><pre>{{ focusItem.biography }}</pre></div></b-col>
        </b-row>
      </b-card>
      <b-button class="mt-3" block @click="$bvModal.hide('bv-modal-example')">關閉</b-button>
    </b-modal>
    </div>
  </div>
  
</template>

<script>
    import { mapState, mapGetters, mapActions } from 'vuex';
    export default {
        data () {
          return {
            memberFields: [
              {key: 'id', label: 'NO'},
              {key: 'level', label: '級別班級',thAttr:{style:'width:100px'}},
              {key: 'name', label: '姓名'},
              {key: 'jobExpect', label: '期望工作內容'},
              {key: '_showDetails', label: '詳情'},
            ],
            classDesc:{
              1:'甲',
              2:'乙',
              3:'丙',
              4:'丁'
            },
            focusItem:{},
          }
        },
        created () {
            this.action_member_get({isJobSearching:true});
        },
        computed: {
          ...mapGetters(['gettetMemberDataList'])
        },
        methods: {
          ...mapActions(['action_member_get']),
        }
    }
</script>

<style>
    .content {
      border: 2px solid;
      padding: 20px; 
      width: 300px;
      resize: both;
      overflow: auto;
    }
    .is-info {
      background-color: #3273dc;
      border-width: 0;
      color: #fff;
    }
    .is-disabled {
      pointer-events: none;
    }
    .wordBreak{
      word-break: break-word;
    }
</style>