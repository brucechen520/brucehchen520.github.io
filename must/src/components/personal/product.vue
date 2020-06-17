<template>
  <div class="container">
    <h1>我的商品</h1>
    <b-button v-b-modal="'product-modal'" variant="success" class="mb-2" @click="modalOption.mode = 'add'">新增商品</b-button>
    <product-table :items="getterProductDataList" :editable="true" :editItem="editProduct" :deleteItem="deleteItem"></product-table>
    <b-modal id="delete-check-modal" centered danger title="刪除產品" @ok="deleteProduct">
        <p class="my-4">刪除後無法復原，確定刪除?</p>
        <template v-slot:modal-footer="{ ok, cancel }">
        <b-button size="sm" variant="danger" @click="ok()">
        刪除
        </b-button>
        <b-button size="sm" @click="cancel()">
        取消
        </b-button>
        </template>
    </b-modal>
    <product-modal :userId="users.id" :product="product" :modalOk="productModalOK" :modalCancel="productModalCancel" :option="modalOption"></product-modal>
  </div>
</template>

<script>
    import { mapState, mapGetters, mapActions } from 'vuex'
    import productTable from '../tables/productTable.vue'
    import productModal from '../modals/productModal.vue'
    export default {
        components: {
            productTable,
            productModal,
        },
        data () {
          return {
            product:{
                name:'',
                permit:0,
                description:'',
                images:[],
                urlType:'http://',
            },
            modalOption:{
                mode:''
            },
          }
        },
        created () {
            let self = this;
            if(self.users.id)
              this.action_product_get({Mem_Se:self.users.id});
        },
        computed: {
            // ...mapGetters 為 ES7 寫法
            ...mapState(['stateProjectData']),
            ...mapGetters({
                // getTodo return value 將會存在別名為 todos 的 webData 上
                users: 'getUser',
                getterProductDataList:'getterProductDataList'
            })
        },
        watch:{
          users : function(user){
            this.action_product_get({Mem_Se:user.id});
          }
        },
        methods: {
            ...mapActions([
  	            'action_product_insert','action_product_get', 'action_product_update', 'action_product_delete'
              ]),
            productModalOK(){
                let self = this;
                if(this.modalOption.mode == 'add'){
                    self.action_product_insert({data:self.product}).then(function(result){
                        if(result.code == 'success'){
                            self.alertModal("發佈成功，需等管理員審核後，方可顯示供大家查詢！審核結果會email通知您。");
                        }
                        self.action_product_get({Mem_Se:self.users.id})
                        self.clearProductData();
                    });
                    
                }
                if(this.modalOption.mode == 'edit'){
                    self.action_product_update({data:self.product}).then(function(result){
                        if(result.code == 'success'){
                            self.alertModal("修改成功，需等管理員審核後，方可顯示供大家查詢！審核結果會email通知您。");
                        }
                        self.action_product_get({Mem_Se:self.users.id})
                        self.clearProductData();
                    });
                }
            },
            productModalCancel(){
                if(this.modalOption.mode == 'edit'){
                    this.clearProductData();
                }
            },
            clearProductData(){
                this.product = {
                    name:'',
                    permit:0,
                    description:'',
                    images:[],
                    urlType:'http://',
                }
            },
            editProduct(item){
                this.product = Object.assign({},item);
                this.product.images = [...item.images];
                this.modalOption.mode = 'edit';
                this.$bvModal.show('product-modal')
            },
            deleteItem(item){
                this.product = item;
                this.$bvModal.show('delete-check-modal');
            },
            deleteProduct(){
                let self = this;
                self.action_product_delete({data:{id:self.product.id}}).then(function(result){
                    if(result.code == 'success'){
                        self.alertModal("已刪除");
                    }
                    self.$modal.hide("modalProject");
                    self.action_product_get({Mem_Se:self.users.id});
                    self.clearProductData();
                });
            },
        }
    }
</script>

<style>
    
    .modal-block {
        background-color: #D2EBF7;
    }
    .customClassForDropDown
    {
       height: 640px;
       overflow-y: auto;
    }

    input:invalid {
        border-color: red;
    }
    textarea:invalid {
        border-color: red;
    }
</style>