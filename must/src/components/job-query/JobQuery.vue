<template>
  <div>
      
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