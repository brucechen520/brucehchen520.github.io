<template>
  <div>
    <b-modal :title="title" size="lg" id="product-modal">
      <ValidationProvider rules="required" v-slot="{ valid, errors }">
      <b-form-group label="商品名稱:" label-for="input-name" label-cols=2>
        <b-form-input id="input-name" :state="valid" v-model="product.name" type="text"></b-form-input>
      </b-form-group>
        <b-form-invalid-feedback :state="valid">
            {{ errors[0] }}
        </b-form-invalid-feedback>
      </ValidationProvider>
      <b-form-group label="是否公開:" label-for="input-2" label-cols=2>
        <b-form-select v-model="product.permit" :options="permitOption"></b-form-select>
      </b-form-group>
      <b-form-group label="描述:" label-for="input-biography" label-cols=2>
          <ValidationProvider rules="required" v-slot="{ valid, errors }">
          <b-form-textarea id="input-biography" :state="valid" placeholder="請輸入商品詳細描述" rows="8" v-model="product.description"></b-form-textarea>
          <b-form-invalid-feedback :state="valid">
              {{ errors[0] }}
          </b-form-invalid-feedback>
          </ValidationProvider>
      </b-form-group>
      <b-form-group label="商品照片:" label-for="input-photo" label-cols=2>
        <b-form-file
        id="input-photo"
        v-model="product.file"
        :state="Boolean(product.file)"
        placeholder="Choose a file or drop it here..."
        drop-placeholder="Drop file here..."
      ></b-form-file>
      </b-form-group>
    </b-modal>
  </div>
</template>

<script>
export default {
  name: 'logout',
  data () {
    return {
      msg: 'Logout',
      title: '新增商品',
      product:{
        name:'',
        permit:0,
        description:'',
        file:null,
      },
      permitOption: [
        { value:0, text:'完全公開'},
        { value:1, text:'僅系友公開'},        
      ],
    }
  }
}
</script>

<style>
</style>