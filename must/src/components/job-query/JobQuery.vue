<template>
  <div>
      <div class="container">
        <div></div>
        <div class="row">
          <div class="col-4"><list-type></list-type></div>
          <div class="col-8"><show-list></show-list></div>
        </div>          
      </div>
  </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';
    import * as api from '../lib/api';
    import DatePicker from 'vue2-datepicker' ;
    import CasePage from './CasePage.vue';
    import ListType from './ListType.vue';
    import ShowList from './ShowList.vue';
    export default {
        components: {
          CasePage,
          ListType,
          ShowList
        },
        data () {
          return {
            msg: '工作查詢'
          }
        }
    }
</script>

<style>

</style>