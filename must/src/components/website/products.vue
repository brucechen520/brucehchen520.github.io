<template>
  <div>
    <div class="container">
      <product-table :items="getterProductDataList"></product-table>
    </div>
  </div>
</template>

<script>
    import { mapState, mapGetters, mapActions } from 'vuex';  
    import productTable from '../tables/productTable.vue'
    export default {
        components: {
            productTable,
        },
        data () {
          return {
          }
        },
        created () {
            this.action_product_get({status:1});
        },
        computed: {
          ...mapGetters(['getterProductDataList'])
        },
        methods: {
          ...mapActions(['action_product_get']),
        }
    }
</script>

<style>
</style>