<template>
  <div class="container">
    <h1>職缺填寫網站</h1>
    <div class="row">
        {{ users.level }}級:{{ users.name }}
    </div>
    <div class="row">
        <label class="col-1">公司名稱</label>
        <input class="col-2" v-model="vacancy_data.company_Name">
        <label class="col-1">公司網址</label>
        <input class="col-2" v-model="vacancy_data.company_Website">
    </div>
    <div class="row">
        <label class="col-1">職缺名稱</label>
        <input v-model="vacancy_data.vacancy_Name">
    </div>
    <div class="row">
        <label class="col-1">描述</label>
        <textarea rows="5" cols="100" v-model="vacancy_data.description"> </textarea>
    </div>
    <div class="row">
        <label class="col-1">職務類別</label>
        <button class="col-2 btn btn-primary" data-toggle="modal" data-target="#exampleModal">新增項目</button>
        <label class="col-1">工作待遇</label>
        <input v-model="vacancy_data.offer">
    </div>
    <div class="row">
        <label class="col-1">上班地點</label>
        <input v-model="vacancy_data.work_Location">
        <label class="col-1">管理責任</label>
        <input v-model="vacancy_data.duty">
    </div>
    <div class="row">
        <label class="col-1">出差外派</label>
        <input v-model="vacancy_data.work_Trip">
        <label class="col-1">上班時段</label>
        <input v-model="vacancy_data.work_Time">
    </div>
    <div class="row">
        <label class="col-1">休假制度</label>
        <input v-model="vacancy_data.vacation">
        <label class="col-1">需求人數</label>
        <input v-model="vacancy_data.demand_Man">
    </div>
    <div class="row">
        <label class="col-1">工作經歷</label>
        <input v-model="vacancy_data.work_Exprience">
        <label class="col-1">學歷要求</label>
        <input v-model="vacancy_data.academic_Require">
    </div>
    <div class="row"> 
        <label class="col-1">語文條件</label>
        <input v-model="vacancy_data.language">
        <label class="col-1">擅長工具</label>
        <input v-model="vacancy_data.tools">
    </div>
    <div class="row">
        <label class="col-1">工作技能</label>
        <input v-model="vacancy_data.work_skills">
        
    </div>
    <div class="row">
        <label class="col-1">其他條件</label>
        <input v-model="vacancy_data.others">
    </div>
    <div class="row">
        <label class="col-1">公司福利</label>
        <textarea rows="5" cols="100" v-model="vacancy_data.welfare"> </textarea>
    </div>
    <div class="row">
        <label class="col-2">聯絡人資料</label>
    </div>
    <div class="row">
        <label class="col-2">聯絡人姓名</label>
        <input v-model="vacancy_data.contact_Name">
        <label class="col-1">E-Mail</label>
        <input v-model="vacancy_data.contact_Mail">
        <label class="col-1">連絡電話</label>
        <input v-model="vacancy_data.contact_Phone">
    </div>
    <div class="row">
        <button class="col-1">送出</button>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">職務類別選單</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="dropdown ">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    資訊軟體系統類
                    </button>
                    <ul class="dropdown-menu customClassForDropDown p-3 mb-2 bg-gradient-warning text-dark row" > <!-- 使用flex: p-2 bg-info 和 白字text-white -->
                        <div class="list-group">
                            <li class="list-group-item-info">
                                <input type="checkbox" @click="selectDropAll(softVName[0].title, allsubSelected[0])" v-model="allsubSelected[0]">
                                <label>軟體/工程類人員</label>
                            </li>
                            <li class="list-group-item" v-for="item in softVName[0].content" @click="liclick($event)">
                                <input type="checkbox" class="dropdown-item custom-control-input " 
                                        :id="item" :value="item" v-model="vacancy_data.checked[0].content">
                                <label class="custom-control-label" :for="item"> {{ item }} </label>
                            </li>
                        </div>
                        <hr>
                        <div class="list-group">
                            <li class="list-group-item-info">
                                <input type="checkbox" @click="selectDropAll(softVName[1].title, allsubSelected[1])" v-model="allsubSelected[1]">
                                <label>MIS/網管類人員</label>
                            </li>
                            <li class="list-group-item" v-for="item in softVName[1].content" @click="liclick($event)">
                                <input type="checkbox" class="dropdown-item custom-control-input " 
                                        :id="item" :value="item" v-model="vacancy_data.checked[1].content">
                                <label class="custom-control-label" :for="item"> {{ item }} </label>
                            </li>
                        </div>
                    </ul>
                </div>
                <div class="dropdown ">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    研發相關類
                    </button>
                    <ul class="dropdown-menu customClassForDropDown p-3 mb-2 bg-gradient-warning text-dark " > <!-- 使用flex: p-2 bg-info 和 白字text-white -->
                        <div class="list-group">
                            <li class="list-group-item-info">
                                <input type="checkbox" @click="selectDropAll(softVName[2].title, allsubSelected[2])" v-model="allsubSelected[2]">
                                <label>工程研發類人員</label>
                            </li>
                            <li class="list-group-item" v-for="item in softVName[2].content" @click="liclick($event)">
                                <input type="checkbox" class="dropdown-item custom-control-input " 
                                        :id="item" :value="item" v-model="vacancy_data.checked[2].content">
                                <label class="custom-control-label" :for="item"> {{ item }} </label>
                            </li>
                        </div>
                        <hr>
                        <div class="list-group">
                            <li class="list-group-item-info">
                                <input type="checkbox" @click="selectDropAll(softVName[3].title, allsubSelected[3])" v-model="allsubSelected[3]">
                                <label>化工材料研發類人員</label>
                            </li>
                            <li class="list-group-item" v-for="item in softVName[3].content" @click="liclick($event)">
                                <input type="checkbox" class="dropdown-item custom-control-input " 
                                        :id="item" :value="item" v-model="vacancy_data.checked[3].content">
                                <label class="custom-control-label" :for="item"> {{ item }} </label>
                            </li>
                        </div>
                        <hr>
                        <div class="list-group">
                            <li class="list-group-item-info">
                                <input type="checkbox" @click="selectDropAll(softVName[4].title, allsubSelected[4])" v-model="allsubSelected[4]">
                                <label>生技/醫療研發類人員</label>
                            </li>
                            <li class="list-group-item" v-for="item in softVName[4].content" @click="liclick($event)">
                                <input type="checkbox" class="dropdown-item custom-control-input " 
                                        :id="item" :value="item" v-model="vacancy_data.checked[4].content">
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
            allsubSelected: [false,false,false,false,false], // 全選了嗎 0: 軟體/工程類人員, 1: MIS/網管類人員 2:工程研發類人員  
                                                             // 3:化工材料研發類人員  4: 生技/醫療研發類人員
            vacancy_data: {
                'company_Name':'', // 公司名稱
                'company_Website':'', // 公司網址
                'vacancy_Name':'', // 職缺名稱
                'description':'', // 描述
                'checked': [             // 職務類別是否已被選擇                          
                            {
                                'title':'軟體/工程類人員',
                                'content': []                     
                            },
                            {
                                'title':'MIS/網管類人員',
                                'content': []
                            },
                            {
                                'title':'工程研發類人員',
                                'content': []
                            },
                            {
                                'title':'化工材料研發類人員',
                                'content': []
                            },
                            {
                                'title':'生技/醫療研發類人員',
                                'content': []
                            }
                        ], 
                'offer':'', // 工作待遇
                'work_Location':'',     // 上班地點
                'duty':'',          // 管理責任
                'work_Trip':'',     // 出差外派
                'work_Time':'',     // 上班時段  
                'vacation':'',  // 休假制度
                'demand_Man':'',  //  需求人數
                'work_Exprience':'',  //  工作經歷
                'academic_Require':'',  //  學歷要求
                'language':'',  //  語文條件
                'tools':'',  //  擅長工具
                'work_skills':'',  //  工作技能
                'others':'',  //  其他條件
                'welfare':'',  //  公司福利
                'contact_Name':'',  //  聯絡人姓名
                'contact_Mail':'',  //  E-MAIL
                'contact_Phone':'',  //  連絡電話
            },
            softVName: [
                {
                    'title':'軟體/工程類人員',
                    'content': [
                        '軟體專案主管',        '通訊軟體工程師',   '韌體工程師',           '電腦系統分析師',
                        '其他資訊專業人員',     'BIOS工程師',      '電子商務技術主管',     '軟體設計工程師',
                        'Internet程式設計師',  '電玩程式設計師',    '資訊助理人員',     '演算法開發工程師'
                    ]
                },
                {
                    'title':'MIS/網管類人員',
                    'content': [
                        'MIS/網管主管',     'MIS程式設計師',   '網路管理工程師',         '資訊設備管制人員',
                        '資料庫管理人員',    'MES工程師',      '系統維護/操作人員',      '網路安全分析師',
                    ]
                },
                {
                    'title':'工程研發類人員',
                    'content': [
                        '硬體工程研發主管',     '通訊工程研發主管',   '電機技師/工程師',         '機構工程師',
                        '電子工程師',    '硬體研發工程師',      '電源工程師',      '數位IC設計工程師',
                        '微機電工程師',             '光學工程師',        'RF通訊工程師',     '助理工程師',
                        '其他特殊工程師',             '太陽能技術工程師',        '聲學/噪音工程師',     '光學工程研發主管',
                        '其他工程研發主管',             '機械工程師',        '機電技師/工程師',     '零件工程師',
                        'PCB佈線工程師',             '類比IC設計工程師',        '半導體工程師',     '光電工程師',
                        '電信/通訊系統工程師',             'IC佈局工程師',        '工程助理',     '電子產品系統工程師',
                        '熱傳工程師'
                    ]
                },
                {
                    'title':'化工材料研發類人員',
                    'content': [
                        '化工化學工程師',     '紡織化學工程師',   '特用化學工程師',         '材料研發人員',
                        '實驗化驗人員'
                    ]
                },
                {
                    'title':'生技/醫療研發類人員',
                    'content': [
                        '食品研發人員',     '醫藥研發人員',   '生物科技研發人員',         '化學工程研發人員',
                        '病理藥理研究人員',    '農藝/畜產研究人員',      '醫療器材研發工程師'
                    ]
                }
            ]
          }
        },
        components: {
            
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
            selectDropAll (title, isAll) { // 下拉式選單裡面的全選
                if(!isAll){
                    this.softVName.filter(arr => {
                        if(arr.title === title){
                            this.vacancy_data.checked.filter((arr1, index) => { 
                                if(arr1.title === title){
                                    this.vacancy_data.checked[index].content = arr.content;
                                }
                            })
                        }
                    });
                }
                else{
                    this.softVName.filter(arr => {
                        if(arr.title === title){
                            this.vacancy_data.checked.filter((arr1, index) => { 
                                if(arr1.title === title){
                                    this.vacancy_data.checked[index].content = [];
                                }
                            })
                        }
                    });
                }
                
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
</style>