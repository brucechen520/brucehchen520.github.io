<template>
  <div class="container">
    <div>
        <div class="col-2">
            <router-link to="/JobVacancies">
              審核頁面
            </router-link>
        </div>
            
        <router-view></router-view>
    </div>
  </div>
  
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'
    import * as api from '../lib/api';
    import JobVacancies from '../job-matching/JobVacancies'
    import ProjectFilling from '../job-matching/ProjectFilling'
    export default {
        data () {
          return {
            skill_data: {
                'biography':'',
                'mail':'', // 信箱
                'cellphone':'', // 手機
                'permit':'', // 類別
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
            ...mapGetters({
                // getTodo return value 將會存在別名為 todos 的 webData 上
                users: 'getUser'
            }),
        },
        methods: {
            liclick (e) { // stay dropdown open
                e.stopPropagation();
            },
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
                        api.getData('/ee/api/api_skill.php', {
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
                        return;
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