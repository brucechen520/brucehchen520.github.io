<template>
  <div>
    <b-alert variant="success" :show="dismissCountDown" @dismissed="dismissCountDown=0" @dismiss-count-down="countDownChanged" dismissible fade>{{option.content}}
    <b-badge variant="success" pill>{{dismissCountDown}}</b-badge>
    </b-alert>
  </div>
</template>

<script>
export default {
  created(){
    var self = this;
    this.$root.$on('modalAlert', (option) => {
        self.option = option;
        self.dismissCountDown = self.dismissSecs;
      })
    },
  data () {
    return {
      dismissCountDown: 0,
      dismissSecs:10,
      option:{
        content:"發佈成功，需等管理員審核後，方可顯示供大家查詢！審核結果會email通知您。"
      }
    }
  },
  methods:{
    countDownChanged(dismissCountDown){
      this.dismissCountDown = dismissCountDown;
    },
    show(){
      console.log('123');
      this.dismissCountDown = this.dismissSecs;
    }
  }
}
</script>

<style>

</style>