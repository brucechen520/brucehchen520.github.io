<template>
  <div>
    <div class="container">
      <web-table :items="getterWebDataList"></web-table>
    </div>
  </div>
</template>

<script>
    import { mapState, mapGetters, mapActions } from 'vuex';  
    import webTable from '../tables/webTable.vue'
    export default {
        components: {
            webTable,
        },
        data () {
          return {
          }
        },
        created () {
            this.action_web_get({status:1});
        },
        computed: {
          ...mapGetters(['getterWebDataList'])
        },
        methods: {
          ...mapActions(['action_web_get']),
        }
    }
</script>

<style>
</style>