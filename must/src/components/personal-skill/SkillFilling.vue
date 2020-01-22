<template>
  <div class="container">
      <!-- <div v-if=""> -->
    <!-- <div v-if="stateResumeData.Mem_Se != null"> -->
    <h1>專長填寫</h1>
    <div class="row" style="color:red">*為必填</div>
    <div class="row">
        <label class="col-12 col-md-auto">{{ users.level }}級:{{ users.name }}</label>
    </div>
    <div class="row">    
    <label class="col-12 col-md-auto">信箱<span style="color:red">*</span></label>
        <input class="col-12 col-md-auto" v-model="skill_data.mail" v-validate="'required|email'" type="email" name="email">
        <span>{{ errors.first('email') }}</span>
    </div>
    <div class="row">
        <label class="col-12 col-md-auto">手機</label>
        <input class="col-12 col-md-auto" v-model="skill_data.cellphone" v-validate="'numeric'">
        <label class="col-12 col-md-auto">手機是否公開<span style="color:red">*</span></label>
        <select class="col-12 col-md-auto" v-model="skill_data.permit" v-validate="'required'" >
          <option v-for="item in permitList" 
                  :value="item.value">{{ item.mes }}</option>
        </select>
    </div>
    <div class="row">
        <label class="col-12 col-md-auto">技能專長</label>
        <div  v-for="(item, index) in skill_data.expertise">
            <input v-model="item.value" :name = "'keyWord_' +index">
            <label :class="[item.status ? 'fas fa-plus' : 'fas fa-minus']" @click="toggleKey(item.id,item ,'expertise')"></label>
        </div></div>
    <div class="row">
        <label class="col-12 col-md-auto">作品</label>
        <div v-for="(item, index) in skill_data.works">
            <input v-model="item.value" :name = "'keyWord_' +index">
            <label :class="[item.status ? 'fas fa-plus' : 'fas fa-minus']" @click="toggleKey(item.id, item , 'works')"></label>
        </div></div>
    <div class="row">
        <label class="col-12 col-md-auto">證照</label>
        <div v-for="(item, index) in skill_data.license">
            <input v-model="item.value" :name = "'keyWord_' +index">
            <label :class="[item.status ? 'fas fa-plus' : 'fas fa-minus']" @click="toggleKey(item.id, item , 'license')"></label>
        </div>
    </div>
    <div class="row">
        <label class="col-2">自我介紹</label>
        <textarea rows="5" cols="100" v-model="skill_data.biography" name="description"> </textarea>
    </div>
    <div class="row">
        <button class="col-12 col-md-auto" @click="validateForm">送出</button>
    </div>

    </div>
  <!-- </div> -->
  
</template>

<script>
    import { mapState, mapGetters, mapActions } from 'vuex';
    import * as api from '../lib/api';
    export default {
        data () {
          return {
            skill_data: {
                'biography':'',
                'mail':'', // 信箱
                'cellphone':'', // 手機
                'permit':0, // 類別
                'expertise': [{  // 技能專長
                    'id': Number(1),
                    'value': '',
                    'status': true
                }], 
                'works': [{     // 作品
                    'id': Number(1),
                    'value': '',
                    'status': true
                }],
                'license': [{   // 證照
                    'id': Number(1),
                    'value': '',
                    'status': true
                }]
            },
            permitList: [
              {'mes': '對系友公開', 'value': '0'},
              {'mes': '對訪客公開', 'value': '1'},
              {'mes': '不公開', 'value': '2'},        
            ]
          }
        },
        computed: {
            // ...mapGetters 為 ES7 寫法
            ...mapState(['stateResumeData']),
            ...mapGetters({
                // getTodo return value 將會存在別名為 todos 的 webData 上
                users: 'getUser'
            }),
        },
        mounted(){
            this.action_resume_get({id:this.users.id});
        },
        methods: {
            liclick (e) { // stay dropdown open
                e.stopPropagation();
            },
            ...mapActions([
  	            'action_resume_insert', 'action_resume_get'
  	        ]),
            toggleKey (id, item, key) {
                var index = this.skill_data[key].findIndex(arr => arr.id === id ); // 取出目前欄位的index 
                if(this.skill_data[key][index].status){
                    this.skill_data[key][index].status = false;  // 加號變減號
                    this.skill_data[key] = [...this.skill_data[key], { // 新增一個陣列欄位，重新繪出視窗
                        'id':this.skill_data[key][this.skill_data[key].length-1].id + 1,
                        'status': true,
                        'value': ''
                        }];
                }
                else {
                    this.skill_data[key] = this.skill_data[key].filter(arr => arr.id !== id); // 移除目前id的輸入視窗
                }
            },
            validateForm () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.action_resume_insert({data:this.skill_data}).then(function(result){
                            if(result.code == 'success')
                                alert('成功');
                        });
                        /*api.getData('/ee/api/api_skill.php', {
                            params: {
                                methods: 'insert',
                                data: this.skill_data
                            }
                        })
                        .then(function (user) {
                            console.log(user);
                            if(user.success)
                                alert(user.success);
                            else
                                alert(user.error);
                        })
                        .catch(function (error) {
                            alert(error);
                        })
                        return;*/
                    }
                    else
                        alert('Correct them errors!'); 
                })
            }

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
</style>