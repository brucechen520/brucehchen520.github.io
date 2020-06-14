<template>
  <div>
    <b-modal :title="title" size="lg" id="product-modal" @ok="modalOk">
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
      <b-overlay :show="uploading" rounded="sm">
        <b-form-group label="商品照片:" label-for="input-photo" label-cols=2>
          <b-container v-if="product.images.length != 0" fluid class="p-4 text-center">
          <b-row class="justify-content-md-center">
            <b-col cols=4 v-for="(image) in product.images" :key="image.name" class="bg-photo pt-2 pb-2">
              <b-img thumbnail fluid :src="image.url" :alt="image.name"></b-img>
              <b-button class="mt-2" size="sm" variant="danger" @click="deleteImage(image)">刪除</b-button>
            </b-col>
          </b-row>
        </b-container>
          <b-form-file v-if="product.images.length < 3"
          id="input-photo"
          v-model="file"
          accept="image/jpeg, image/png, image/gif"
          placeholder="選擇照片或將照片拖曳至此..."
          drop-placeholder="Drop file here..."
          @input="handleInput"
        ></b-form-file>
        </b-form-group>
      </b-overlay>
    </b-modal>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex'
export default {
  name: 'product-modal',
  props:{
            userId:'',
            product:{},
            modalOk:null,
            option:{default:{mode:''}},
        },
  data () {
    return {
      msg: 'Logout',
      //title: '123',
      //title: '新增商品',

      uploading:false,
      file:null,
      permitOption: [
        { value:0, text:'完全公開'},
        { value:1, text:'僅系友公開'},        
      ],
      
    }
  },
  computed:{
      title(){
        if(this.option && this.option.mode == 'edit')
            return "修改商品";
        else
            return "新增商品";
      },
  },
  methods:{
    ...mapActions(['action_photo_update']),
    handleInput(file){
      if(file == null) return;
      let self = this;
      this.uploading = true;
      let formData = new FormData();
      formData.append('photo',file);
      formData.append('userId',this.userId);
      this.action_photo_update(formData).then(result => {
          self.product.images.push(result.data);
          self.uploading = false;
          self.file = null;
      });
    },
    deleteImage(photo){
      console.log('delete');
      console.log(photo);
      this.product.images = this.product.images.filter(e=>e.name != photo.name);
    }
  }
}
</script>

<style>
.bg-photo {
    background-color: #e0e0e0 !important;
}
</style>