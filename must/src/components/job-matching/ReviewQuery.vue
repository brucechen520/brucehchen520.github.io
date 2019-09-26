<template>
  <div>
      <div class="container">
        <div class="row">
          <div class="col-2"><list-type :selectType = "0"></list-type></div>
          <div class="col-10"><review-list></review-list></div>
        </div>          
      </div>
  </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';
    import * as api from '../lib/api';
    import DatePicker from 'vue2-datepicker' ;
    import ListType from '../job-query/ListType.vue';
    import ReviewList from './ReviewList.vue';
    export default {
        components: {
          ListType,
          ReviewList
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