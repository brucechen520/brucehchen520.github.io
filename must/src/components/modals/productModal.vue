<template>
  <div>
    <b-modal :title="title" size="lg" id="product-modal" @ok="modalOk" @hide="modalCancel">
      <ValidationObserver ref="form">
      <ValidationProvider rules="required" v-slot="{ valid, errors }">
      <b-form-group label="商品名稱:" label-for="input-name" label-cols=2>
        <b-form-input id="input-name" :state="valid" v-model="product.name" type="text"></b-form-input>
              <b-form-invalid-feedback :state="valid">
            {{ errors[0] }}
        </b-form-invalid-feedback>
      </b-form-group>
      </ValidationProvider>
      <b-form-group label="是否公開:" label-for="input-2" label-cols=2>
        <b-form-select v-model="product.permit" :options="permitOption"></b-form-select>
      </b-form-group>
      <b-form-group label="商品網址:" label-for="input-url" label-cols=2>
        <b-row><b-col cols=3>
        <b-form-select v-model="product.urlType" :options="urlTypes"></b-form-select></b-col>
        <b-col><b-form-input id="input-url" v-model="product.urlShort" type="url"></b-form-input></b-col></b-row>
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
          accept="image/jpeg, image/png, image/gif, image/bmp"
          placeholder="選擇照片或將照片拖曳至此..."
          drop-placeholder="將照片拖曳至此..."
          @input="handleInput"
        ></b-form-file>
        </b-form-group>
      </b-overlay>
      </ValidationObserver>
      <template v-slot:modal-footer="{ ok, cancel }">
        <b-button v-if="option.mode == 'edit'" size="sm" variant="warning" @click="onSubmit()">
        修改
        </b-button>
        <b-button v-else size="sm" variant="success" @click="onSubmit()">
        新增
        </b-button>
        <b-button size="sm" @click="cancel()">
        取消
        </b-button>
        </template>
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
            modalCancel:null,
            option:{default:{mode:''}},
        },
  data () {
    return {
      uploading:false,
      file:null,
      permitOption: [
        { value:0, text:'完全公開'},
        { value:1, text:'僅系友公開'},        
      ],
      urlTypes:[
        { value:'http://', text:'http'},
        { value:'https://', text:'https'},
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
      this.product.images = this.product.images.filter(e=>e.name != photo.name);
    },
    onSubmit(){
      this.$refs.form.validate().then(success => {
        if (!success) {
          return;
        }
        this.modalOk();
        this.$bvModal.hide('product-modal');
      });
    },
  }
}
</script>

<style>
.bg-photo {
    background-color: #e0e0e0 !important;
}
</style>