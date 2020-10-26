<template>
  <div>
    <div v-if="!isModify && stateResumeData.Mem_Se != null">
    <h1>我的資料</h1>
    <b-button variant="success" @click="toModifyData" class="mb-2">修改資料</b-button>
    <b-card :title="users.name" :sub-title="users.level+'級'" border-variant="Success">
        <b-card-body>
            <b-row class="border-bottom p-2">
                <b-col cols="12" md="3">信箱:</b-col><b-col cols="12" md="9">{{stateResumeData.mail}}</b-col>
            </b-row>
            <b-row class="border-bottom p-2">
                <b-col cols="12" md="3">手機:</b-col><b-col cols="12" md="9">{{stateResumeData.cellphone}}</b-col>
            </b-row>
            <b-row class="border-bottom p-2">
                <b-col cols="12" md="3">技能專長:</b-col><b-col cols="12" md="9">{{stateResumeData.expertise}}</b-col>
            </b-row>
            <b-row class="border-bottom p-2">
                <b-col cols="12" md="3">作品:</b-col><b-col cols="12" md="9">{{stateResumeData.works}}</b-col>
            </b-row>
            <b-row class="border-bottom p-2">
                <b-col cols="12" md="3">證照:</b-col><b-col cols="12" md="9">{{stateResumeData.license}}</b-col>
            </b-row>
            <b-row class="border-bottom p-2">
                <b-col cols="12" md="3">自我介紹:</b-col><b-col cols="12" md="9"><pre>{{stateResumeData.biography}}</pre></b-col>
            </b-row>
        </b-card-body>
        <b-card-text class="small text-muted">隱私設定</b-card-text>
        <b-card-body>
            <b-row class="border-bottom p-2">
                <b-col>姓名:</b-col><b-col  cols="8" md="9">{{permitdesc[stateResumeData.permit.name]}}</b-col>
            </b-row>
            <b-row class="border-bottom p-2">
                <b-col>信箱:</b-col><b-col  cols="8" md="9">{{permitdesc[stateResumeData.permit.mail]}}</b-col>
            </b-row>
            <b-row class="border-bottom p-2">
                <b-col>手機:</b-col><b-col  cols="8" md="9">{{permitdesc[stateResumeData.permit.phone]}}</b-col>
            </b-row>
        </b-card-body>
    </b-card>
    </div>
    <div v-else>
        <h1>{{isModify?'個人資料修改':'個人資料填寫'}}</h1>
        <ValidationObserver v-slot="{ valid }">
            <b-form>
                <b-row>
                    <b-col cols=12 md="7"><b-form-group label="姓名:" label-for="input-name" label-cols=4 label-cols-md=2>
                            <b-form-input id="input-name"  :value="users.name" type="text" readonly></b-form-input>
                    </b-form-group></b-col>
                    <b-col cols=12 md="5"><b-form-group label="是否公開:" label-for="input-2" label-cols=4 label-cols-md=4>
                            <b-form-select v-model="modifyData.permit.name" :options="permitOption"></b-form-select>
                    </b-form-group></b-col>
                </b-row>
                <b-row>
                    <b-col cols=12 md="7"><b-form-group label="信箱:" label-for="input-email" label-cols=4 label-cols-md=2>
                            <ValidationProvider rules="required|email" v-slot="{ valid, errors }">
                            <b-form-input id="input-email" :state="valid" v-model="modifyData.mail" type="email" required placeholder="輸入信箱"></b-form-input>
                            <b-form-invalid-feedback :state="valid">
                                {{ errors[0] }}
                            </b-form-invalid-feedback>
                            </ValidationProvider>
                    </b-form-group></b-col>
                    <b-col cols=12 md="5"><b-form-group label="是否公開:" label-for="input-2" label-cols=4>
                        <b-form-select v-model="modifyData.permit.mail" :options="permitOption"></b-form-select>
                    </b-form-group></b-col>
                </b-row>         
                <b-row>
                    <b-col cols=12 md="7"><b-form-group label="手機:" label-for="input-phone" label-cols=4 label-cols-md=2>
                            <ValidationProvider rules="required" v-slot="{ valid, errors }">
                            <b-form-input id="input-phone" :state="valid" v-model="modifyData.cellphone" type="tel" required placeholder="輸入手機"></b-form-input>
                            <b-form-invalid-feedback :state="valid">
                                {{ errors[0] }}
                            </b-form-invalid-feedback>
                            </ValidationProvider>
                    </b-form-group></b-col>
                    <b-col cols=12 md="5"><b-form-group label="是否公開:" label-for="input-2" label-cols=4>
                        <b-form-select v-model="modifyData.permit.phone" :options="permitOption"></b-form-select>
                    </b-form-group></b-col>
                </b-row>
                <b-form-group label="技能專長:" label-for="input-expertise" label-cols=12 label-cols-md=2>
                    <b-form-tags id="input-expertise" placeholder="輸入技能專長(enter即可新增)" remove-on-delete size="lg" tag-variant="success" v-model="modifyData.expertiseArray" tagClass="tag-block-md"></b-form-tags>
                </b-form-group>
                <b-form-group label="作品:" label-for="input-work" label-cols=12 label-cols-md=2>
                    <b-form-tags id="input-work" placeholder="輸入作品(enter即可新增)" remove-on-delete size="lg" tag-variant="info" v-model="modifyData.worksArray" tagClass="tag-block-md"></b-form-tags>
                </b-form-group>
                <b-form-group label="證照:" label-for="input-license" label-cols=12 label-cols-md=2>
                    <b-form-tags id="input-license" placeholder="輸入證照(enter即可新增)" remove-on-delete size="lg" tag-variant="danger" v-model="modifyData.licenseArray" tagClass="tag-block-md"></b-form-tags>
                </b-form-group>
                <b-form-group label="自我介紹:" label-for="input-biography" label-cols=12 label-cols-md=2>
                    <ValidationProvider rules="required" v-slot="{ valid, errors }">
                    <b-form-textarea id="input-biography" :state="valid" placeholder="介紹一下你自己" rows="8" v-model="modifyData.biography"></b-form-textarea>
                    <b-form-invalid-feedback :state="valid">
                        {{ errors[0] }}
                    </b-form-invalid-feedback>
                    </ValidationProvider>
                </b-form-group>
                <b-form-group label="是否求職中:" label-for="input-license" label-cols=12 label-cols-md=2>
                    <b-form-checkbox v-model="modifyData.isJobSearching" name="check-button" switch size="lg">
                    <b>{{ modifyData.isJobSearching ? '是' : '否' }}</b>
                </b-form-checkbox>
                </b-form-group>
                <b-form-group label="期望工作內容:" label-for="input-biography" label-cols=12 label-cols-md=2>
                    <ValidationProvider v-if="modifyData.isJobSearching" rules="required" v-slot="{ valid, errors }">
                    <b-form-textarea id="input-biography" :state="valid" placeholder="期望工作內容" rows="8" v-model="modifyData.jobExpect"></b-form-textarea>
                    <b-form-invalid-feedback :state="valid">
                        {{ errors[0] }}
                    </b-form-invalid-feedback>
                    </ValidationProvider>
                    <b-form-textarea v-else id="input-biography" placeholder="期望工作內容" rows="8" v-model="modifyData.jobExpect" disabled></b-form-textarea>

                </b-form-group>
                
                <b-button v-if="valid" variant="success" @click="modify" class="tag-block-md mb-1">送出</b-button>
                <b-button v-else class="tag-block-md pb-1">送出</b-button>
                <b-button @click="modifyCancel" class="tag-block-md  pb-1">取消</b-button>
            </b-form>
        </ValidationObserver>
    </div>
</div>
</template>

<script>
    import { mapState, mapGetters, mapActions } from 'vuex';
    import * as api from '../../assets/api';
    export default {
        data () {
          return {
            isModify : false,
            modifyData:{
                Mem_Se:'',
                biography:"",
                cellphone:"",
                expertiseArray:[],
                licenseArray:[],
                mail:"",
                modify:"",
                permit:{mail:0,
                        name:0,
                        phone:0,
                        },
                worksArray:[],
                isJobSearching:false,
                jobExpect:"",
                },
            permitOption: [
              { value:0, text:'完全公開'},
              { value:1, text:'僅系友公開'},
              { value:2, text:'不公開'},        
            ],
            permitdesc:['完全公開','僅系友公開','不公開'],
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
            let self = this;
            !self.users.id && api.api2.user_get({}, function(users) {
                self.action_resume_get({id:users.id});
            }, false, false);
            self.users.id && self.action_resume_get({id:self.users.id});
        },
        methods: {
            liclick (e) { // stay dropdown open
                e.stopPropagation();
            },
            ...mapActions([
  	            'action_resume_insert', 'action_resume_get','action_resume_update'
  	        ]),
            modify(){
                let self = this;
                let param = Object.assign({},self.modifyData);
                param.expertise = param.expertiseArray.toString().replace(/,/g,'、');
                param.works = param.worksArray.toString().replace(/,/g,'、');
                param.license = param.licenseArray.toString().replace(/,/g,'、');
                if(this.isModify){
                    self.action_resume_update({data:param}).then(function(result){
                        if(result.code == 'success'){
                            self.alertModal("已更新資料");
                            self.action_resume_get({id:self.users.id});
                            self.modifyCancel();
                        }
                    });
                }
                else{
                    self.action_resume_insert({data:param}).then(function(result){
                        if(result.code == 'success'){
                            self.alertModal("已更新資料");
                            self.action_resume_get({id:self.users.id});
                            self.modifyCancel();
                        }
                    });
                }
            },
            toModifyData(){
                this.modifyData = Object.assign({},this.stateResumeData);
                this.modifyData.expertiseArray = this.modifyData.expertise.split("、");
                this.modifyData.worksArray = this.modifyData.works.split("、");
                this.modifyData.licenseArray = this.modifyData.license.split("、");
                this.isModify = true;
            },
            modifyCancel(){
                this.isModify = false;
            }

        }
    }
</script>

<style>
@media screen and (max-width: 768px) {
    .tag-block-md{
      display: block;
      width: 100%;
    }
  }
</style>