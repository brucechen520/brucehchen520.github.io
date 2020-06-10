<template>
  <div>
    <div class="container">
    <b-table striped hover outlined :fields="memberFields" :items="gettetMemberDataList" @row-clicked="e => {e._showDetails = !e._showDetails}">
        <template v-slot:cell(id)="row">{{row.index +1 }}</template>
        <template v-slot:cell(level)="row">{{row.item.level}}{{row.item.level?'級':''}}{{classDesc[row.item.class]}}{{row.item.class?'班':''}}</template>
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
            <b-col cols=2 class=""><b>作品:</b></b-col>
            <b-col>{{ row.item.works }}</b-col>
          </b-row>
          <b-row class="mb-1">
            <b-col cols=2 class=""><b>證照:</b></b-col>
            <b-col>{{ row.item.license }}</b-col>
          </b-row>
          <b-row class="mb-1">
            <b-col cols=2 class=""><b>自我介紹:</b></b-col>
            <b-col>{{ row.item.biography }}</b-col>
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
  </div>
  
</template>

<script>
    import { mapState, mapGetters, mapActions } from 'vuex';
    export default {
        data () {
          return {
            memberFields: [
              {key: 'id', label: 'NO'},
              {key: 'level', label: '級別班級'},
              {key: 'name', label: '姓名'},
              {key: 'expertise', label: '技能專長'},
              {key: '_showDetails', label: '詳情'},
            ],
            classDesc:{
              1:'甲',
              2:'乙',
              3:'丙',
              4:'丁'
            }
          }
        },
        created () {
            this.action_member_get();
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