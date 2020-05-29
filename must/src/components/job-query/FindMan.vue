<template>
  <div>
    <b-table striped hover outlined :fields="memberFields" :items="stateMemberData">
        <template v-slot:cell(id)="row">{{row.index +1 }}</template>
        <template v-slot:cell(詳情)="row">
          <b-button size="sm" @click="row.toggleDetails" class="mr-2">
             {{ row.detailsShowing ? '縮小' : '詳情'}}
          </b-button>
        </template>
        <template v-slot:row-details="row">
        <b-card>
          <b-row class="mb-1">
            <b-col sm="2" class=""><b>編號:</b></b-col>
            <b-col>{{ row.item.Mem_Se }}</b-col>
          </b-row>
          <b-row class="mb-1">
            <b-col sm="2" class=""><b>電話:</b></b-col>
            <b-col>{{ row.item.cellphone }}</b-col>
          </b-row>
          <b-row class="mb-1">
            <b-col sm="2" class=""><b>信箱:</b></b-col>
            <b-col>{{ row.item.mail }}</b-col>
          </b-row>
          <b-row class="mb-1">
            <b-col sm="2" class=""><b>作品:</b></b-col>
            <b-col>{{ row.item.works }}</b-col>
          </b-row>
          <b-row class="mb-1">
            <b-col sm="2" class=""><b>證照:</b></b-col>
            <b-col>{{ row.item.license }}</b-col>
          </b-row>
          <b-row class="mb-1">
            <b-col sm="2" class=""><b>自我介紹:</b></b-col>
            <b-col>{{ row.item.biography }}</b-col>
          </b-row>
          <b-button size="sm" @click="row.toggleDetails">縮小</b-button>
        </b-card>
      </template>
      </b-table>
  </div>
  
</template>

<script>
    import { mapState, mapGetters, mapActions } from 'vuex';
    export default {
        data () {
          return {
            memberFields: [
              {key: 'id', label: 'NO'},
              {key: 'name', label: '姓名'},
              {key: 'expertise', label: '技能專長'},
              '詳情',
            ],
          }
        },
        created () {
            this.action_member_get();
        },
        computed: {
          ...mapState(['stateMemberData']),
          // ...mapGetters 為 ES7 寫法
          ...mapGetters({
              // getUser return value 將會存在別名為 users 的 webData 上
              users: 'getUser'
          })
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