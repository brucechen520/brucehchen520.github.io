<template>
  <div class="container">
    <h1>專長填寫</h1>
    <div class="row">
        <label class="col-12 col-md-auto">{{ users.level }}級:{{ users.name }}</label>
        <label class="col-12 col-md-auto">信箱</label>
        <input class="col-12 col-md-auto" v-model="skill_data.mail">
    </div>
    <div class="row">
        <label class="col-12 col-md-auto">手機</label>
        <input class="col-12 col-md-auto" v-model="skill_data.cellphone">
        <label class="col-12 col-md-auto">類別</label>
        <select class="col-12 col-md-auto" v-model="skill_data.type">
          <option v-for="item in permitList" 
                  :value="item">{{ item }}</option>
        </select>
    </div>
    <div class="row">
        <label class="col-12 col-md-auto">技能專長</label>
        <div  v-for="(item, index) in skill_data.expertise">
            <input v-model="item.value">
            <label :class="[item.status ? 'fas fa-plus' : 'fas fa-minus']" @click="toggleKey(item.id)"></label>
        </div>
        <label class="col-12 col-md-auto">作品</label>
        <div v-for="(item, index) in skill_data.expertise">
            <input v-model="item.value">
            <label :class="[item.status ? 'fas fa-plus' : 'fas fa-minus']" @click="toggleKey(item.id)"></label>
        </div>
        <label class="col-12 col-md-auto">證照</label>
        <div v-for="(item, index) in skill_data.expertise">
            <input v-model="item.value">
            <label :class="[item.status ? 'fas fa-plus' : 'fas fa-minus']" @click="toggleKey(item.id)"></label>
        </div>
    </div>
    <div class="row">
        <button class="col-12 col-md-auto">送出</button>
    </div>
    

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">案件類別選單</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="dropdown ">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        {{ expertiseTypeName[0].title }}
                        </button>
                        <ul class="dropdown-menu customClassForDropDown p-3 mb-2 bg-gradient-warning text-dark" > <!-- 使用flex: p-2 bg-info 和 白字text-white 滾輪:customClassForDropDown -->
                            <div class="list-group">
                                <li class="list-group-item-info">
                                    <label>{{ expertiseTypeName[0].title }}</label>
                                </li >
                                <li class="list-group-item" v-for="item in expertiseTypeName[0].content" @click="liclick($event)">
                                    <input type="checkbox" class="dropdown-item custom-control-input " 
                                            :id="item" :value="item" v-model="skill_data.checked[0].content">
                                    <label class="custom-control-label" :for="item"> {{ item }} </label>
                                </li>
                            </div>
                        </ul>
                    </div>
                    <div class="dropdown ">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        {{ expertiseTypeName[1].title }}
                        </button>
                        <ul class="dropdown-menu customClassForDropDown p-3 mb-2 bg-gradient-warning text-dark" > <!-- 使用flex: p-2 bg-info 和 白字text-white -->
                            <div class="list-group">
                                <li class="list-group-item-info">
                                    <label>{{ expertiseTypeName[1].title }}</label>
                                </li>
                                <li class="list-group-item" v-for="item in expertiseTypeName[1].content" @click="liclick($event)">
                                    <input type="checkbox" class="dropdown-item custom-control-input " 
                                            :id="item" :value="item" v-model="skill_data.checked[1].content">
                                    <label class="custom-control-label" :for="item"> {{ item }} </label>
                                </li>
                            </div>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

  </div>
  
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'
    import * as api from '../lib/api';
    export default {
        data () {
          return {
            allsubSelected: [false,false], // 全選了嗎 0: 網路資訊相關, 1: 行銷企劃相關 2:  
                                           //          3:  4: 
            skill_data: {
                'mail':'', // 信箱
                'cellphone':'', // 手機
                'type':'', // 類別
                'expertise': [{  // 技能專長
                    'id': Number(1),
                    'value': '',
                    'status': false
                }], 
                'works': [{     // 作品
                    'id': Number(1),
                    'value': '',
                    'status': false
                }],
                'license': [{   // 證照
                    'id': Number(1),
                    'value': '',
                    'status': false
                }],
                'checked': [             // 類別是否已被選擇                          
                    {
                        'title':'網路資訊相關',
                        'content': []                     
                    },
                    {
                        'title':'行銷企劃相關',
                        'content': []
                    }
                ], 
            },
            permitList: [
              '對系友公開', // 0
              '對訪客公開(不含姓名)', // 1
              '對訪客全公開', // 2
              '不公開'        // 3 只有管理員看的到
            ],
            expertiseTypeName: [
                {
                    'title':'網路資訊相關',
                    'content': [
                        '不拘',        '網路應用程式',   '軟體程式設計',           '虛擬主機/代管',
                        '韌體設計',     '電子電路設計',      '企業資源規劃',     '網路規劃舖設',
                        '系統整合維護',  '光學元件設計',    '系統分析設計',     '學生專題製作',
                        '網站規劃建置',  '資料庫程式',    '系統整合建置',     '通訊系統建置',
                        'IC電路設計',  '無線通信電路',    '驅動程式設計',     '軟體硬體修護',
                        '軟體測試',  '硬體程式設計',    '演講/教學人員',     '其他'
                    ]
                },
                {
                    'title':'行銷企劃相關',
                    'content': [
                        '不拘',     '行銷企劃',   '網站企劃',         '市場分析規劃',
                        '廣告企劃',    '影片/腳本企劃',      '其他',      '產品行銷',
                        '宣傳/活動企劃',     '營運企劃撰寫',   '公關企劃',         '傳播媒體企劃',
                        '遊戲企劃'
                    ]
                }
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
            toggleKey (id, item) {
                var index = this.item.id.findIndex(arr => arr.id === id ); // 取出目前欄位的index 
                if(this.skill_data.key[index].status){
                    this.skill_data.key[index].status = false;  // 加號變減號
                    this.skill_data.key = [...this.skill_data.key, { // 新增一個陣列欄位，重新繪出視窗
                        'id':this.skill_data.key[this.skill_data.key.length-1].id + 1,
                        'status': true,
                        'value': ''
                        }];
                }
                else {
                    this.skill_data.key = this.skill_data.key.filter(arr => arr.id !== id); // 移除目前id的輸入視窗
                }
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