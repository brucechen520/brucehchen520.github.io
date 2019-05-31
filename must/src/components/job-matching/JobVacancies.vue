<template>
  <div class="container">
    <h1>職缺填寫網站</h1>
    <div class="row">
        {{ users.level }}級:{{ users.name }}
    </div>
    <div class="row">
        <label class="col-2">公司名稱</label>
        <input class="col-2" v-model="vacancy_data.company_Name" v-validate="'required'" name = "company_Name">
        <label class="col-2">公司網址</label>
        <input class="col-2" v-model="vacancy_data.company_Website" v-validate="'required|url'" name="url" type="text">
        <span v-show="errors.has('url')" class="help is-danger">{{ errors.first('url') }}</span>
    </div>
    <div class="row">
        <label class="col-2">職缺名稱</label>
        <input v-model="vacancy_data.vacancy_Name" v-validate="'required'" name = "vacancy_Name">
    </div>
    <div class="row"> 
        <label class="col-2">描述</label>
        <textarea rows="5" cols="100" v-model="vacancy_data.description" v-validate="'required'" name="description"> </textarea>
        <span>{{ errors.first('description') }}</span> 
    </div>
    <div class="row">
        <label class="col-2">職務類別</label>
        <button class="col-2 btn btn-primary" data-toggle="modal" data-target="#exampleModal">新增項目</button>
        <label class="col-2">工作待遇</label>
        <input v-model="vacancy_data.offer" v-validate="'required'" name = "offer">
    </div>
    <div class="row">
        <label class="col-2">已勾選的內容</label>
        <ul>
            <li v-for="item in vacancy_data.checked">
                {{ item.title }}: {{ item.content }}
            </li>
        </ul>
    </div>
    <div class="row">
        <label class="col-2">上班地點</label>
        <input v-model="vacancy_data.location" v-validate="'required'" name = "location">
        <label class="col-2">管理責任</label>
        <input v-model="vacancy_data.duty" v-validate="'required'" name = "duty">
    </div>
    <div class="row">
        <label class="col-2">出差外派</label>
        <input v-model="vacancy_data.trip" v-validate="'required'" name = "trip">
        <label class="col-2">上班時段</label>
        <input v-model="vacancy_data.officeHour" v-validate="'required'" name = "officeHour">
    </div>
    <div class="row">
        <label class="col-2">休假制度</label>
        <input v-model="vacancy_data.vacation" v-validate="'required'" name = "vacation">
        <label class="col-2">需求人數</label>
        <input v-model="vacancy_data.demandMans" v-validate="'required'" name = "demandMans">
    </div>
    <div class="row">
        <label class="col-2">工作經歷</label>
        <input v-model="vacancy_data.exprience" v-validate="'required'" name = "exprience">
        <label class="col-2">學歷要求</label>
        <input v-model="vacancy_data.academicRequire" v-validate="'required'" name = "academicRequire">
    </div>
    <div class="row">
        <label class="col-2 " data-toggle="tooltip" data-placement="top" title="請輸入英文等語言">語言條件(Hover me)</label>
        <div v-for="(lang, index) in vacancy_data.language">
            <input v-model="lang.type" v-validate="'required'" :name = "'lang ' + index">
            <span v-show="errors.has('lang ' + index)">{{ errors.first('lang ' + index) }}</span>
            <label>聽</label>
            <select v-model="lang.listen" v-validate="'required'" :name = "'listen ' + index">
                <option v-for="item in degree"> {{ item }} </option>
            </select>
            <span v-show="errors.has('listen ' + index)">{{ errors.first('listen ' + index) }}</span>
            <label>說</label>
            <select v-model="lang.speak" v-validate="'required'" :name = "'speak ' + index">
                <option v-for="item in degree"> {{ item }} </option>
            </select>
            <span v-show="errors.has('speak ' + index)">{{ errors.first('speak ' + index) }}</span>
            <label>讀</label>
            <select v-model="lang.read" v-validate="'required'" :name = "'read ' + index">
                <option v-for="item in degree"> {{ item }} </option>
            </select>
            <span v-show="errors.has('read ' + index)">{{ errors.first('read ' + index) }}</span>
            <label>寫</label>
            <select v-model="lang.write" v-validate="'required'" :name = "'write ' + index">
                <option v-for="item in degree"> {{ item }} </option>
            </select>
            <span v-show="errors.has('write ' + index)">{{ errors.first('write ' + index) }}</span>
            <label :class="[lang.status ? 'fas fa-plus' : 'fas fa-minus']" @click="toggleLang(lang.id)"></label>
        </div>
    </div>
    <div class="row">
        <label class="col-3">工作技能(擅長工具)</label>
        <div v-for="(item, index) in vacancy_data.skills">
            <label> 技能 </label>
            <input v-model="item.value" v-validate="'required'" :name = "'skill_' +index" >
            <label :class="[item.status ? 'fas fa-plus' : 'fas fa-minus']" @click="toggleSkill(item.id)"></label>
            <span v-show="errors.has('skill_' + index)">{{ errors.first('skill_' + index) }}</span>
        </div>
    </div>
    <div class="row">
        <label class="col-2">其他條件</label>
        <input v-model="vacancy_data.others" name = "others">
    </div>
    <div class="row"> 
        <label class="col-2">公司福利</label>
        <textarea rows="5" cols="100" v-model="vacancy_data.welfare" v-validate="'required'" name="welfare"> </textarea>
        <span>{{ errors.first('description') }}</span> 
    </div>
    <div class="row">
        <label class="col-2">聯絡人資料</label>
    </div>
    <div class="row">
        <label class="col-2">聯絡人稱呼</label>
        <input v-model="vacancy_data.contact_Name" v-validate="'required'" name = "contact_Name">
        <label class="col-2">E-Mail</label>
        <input v-model="vacancy_data.contact_Mail" v-validate="'required|email'" type="email" name="email">
        <span>{{ errors.first('email') }}</span>
        <div class="w-100"></div>
        <label class="col-2">連絡電話</label>
        <input v-model="vacancy_data.contact_Phone" v-validate="'numeric'" name = "contact_Phone">
        <label class="col-2">方便聯絡時間</label>
        <input v-model="vacancy_data.contact_Time" v-validate="'required'" name = "contact_Time">
    </div>
    <div class="row">
        <button class="col-1" @click="validateForm">送出</button>
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
                                <input type="checkbox" @click="selectDropAll(vacancyTypeName[0].title, allsubSelected[0])" v-model="allsubSelected[0]">
                                <label>軟體/工程類人員</label>
                            </li>
                            <li class="list-group-item" v-for="item in vacancyTypeName[0].content" @click="liclick($event)">
                                <input type="checkbox" class="dropdown-item custom-control-input " 
                                        :id="item" :value="item" v-model="vacancy_data.checked[0].content">
                                <label class="custom-control-label" :for="item"> {{ item }} </label>
                            </li>
                        </div>
                        <hr>
                        <div class="list-group">
                            <li class="list-group-item-info">
                                <input type="checkbox" @click="selectDropAll(vacancyTypeName[1].title, allsubSelected[1])" v-model="allsubSelected[1]">
                                <label>MIS/網管類人員</label>
                            </li>
                            <li class="list-group-item" v-for="item in vacancyTypeName[1].content" @click="liclick($event)">
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
                                <input type="checkbox" @click="selectDropAll(vacancyTypeName[2].title, allsubSelected[2])" v-model="allsubSelected[2]">
                                <label>工程研發類人員</label>
                            </li>
                            <li class="list-group-item" v-for="item in vacancyTypeName[2].content" @click="liclick($event)">
                                <input type="checkbox" class="dropdown-item custom-control-input " 
                                        :id="item" :value="item" v-model="vacancy_data.checked[2].content">
                                <label class="custom-control-label" :for="item"> {{ item }} </label>
                            </li>
                        </div>
                        <hr>
                        <div class="list-group">
                            <li class="list-group-item-info">
                                <input type="checkbox" @click="selectDropAll(vacancyTypeName[3].title, allsubSelected[3])" v-model="allsubSelected[3]">
                                <label>化工材料研發類人員</label>
                            </li>
                            <li class="list-group-item" v-for="item in vacancyTypeName[3].content" @click="liclick($event)">
                                <input type="checkbox" class="dropdown-item custom-control-input " 
                                        :id="item" :value="item" v-model="vacancy_data.checked[3].content">
                                <label class="custom-control-label" :for="item"> {{ item }} </label>
                            </li>
                        </div>
                        <hr>
                        <div class="list-group">
                            <li class="list-group-item-info">
                                <input type="checkbox" @click="selectDropAll(vacancyTypeName[4].title, allsubSelected[4])" v-model="allsubSelected[4]">
                                <label>生技/醫療研發類人員</label>
                            </li>
                            <li class="list-group-item" v-for="item in vacancyTypeName[4].content" @click="liclick($event)">
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
    import DatePicker from 'vue2-datepicker' 
    export default {
        data () {
          return {
            degree: ['不會', '略懂', '中等', '精通'],
            // custom lang
            lang: {
                days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                pickers: ['next 7 days', 'next 30 days', 'previous 7 days', 'previous 30 days'],
                placeholder: {
                    date: 'Select Date',
                }
            },
            // custom range shortcuts
            shortcuts: [
                {
                    text: 'Today',
                    onClick: () => new Date()
                }
            ],
            timePickerOptions:{
                start: '00:00',
                step: '00:30',
                end: '23:30'
            },
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
                'location':'', // 上班地點
                'duty':'', // 管理責任
                'offer':'',    // 工作待遇
                'officeHour':'', // 上班時段
                'trip': '',  // 出差外派
                'vacation':'', // 休假制度
                'demandMans':'', // 需求人數
                'academicRequire': '', // 學歷要求
                'exprience': '', // 工作經歷
                'others':'', // 其他福利
                'welfare':'', // 公司福利
                'language':[{
                                'id': Number(1),
                                'status': true,
                                'type': '',
                                'read': '',
                                'write': '',
                                'listen': '',
                                'speak': ''
                            }],  //  語文條件
                'skills':[{
                    'id': Number(1),
                    'status': true,
                    'value':''
                }],  //  工作技能
                'contact_Name':'',  //  聯絡人姓名
                'contact_Mail':'',  //  E-MAIL
                'contact_Phone':'',  //  連絡電話
                'contact_Time': ''   //  方便聯絡時間
            },
            vacancyTypeName: [
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
            DatePicker
        },
        computed: {
            // ...mapGetters 為 ES7 寫法
            ...mapGetters({
                // getTodo return value 將會存在別名為 todos 的 webData 上
                users: 'getUser'
            })
        },
        methods: {
            liclick (e) { // stay dropdown open
                e.stopPropagation();
            },
            selectDropAll (title, isAll) { // 下拉式選單裡面的全選
                if(!isAll){
                    this.vacancyTypeName.filter(arr => {
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
                    this.vacancyTypeName.filter(arr => {
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
            toggleSkill (id) {
                var index = this.vacancy_data.skills.findIndex(arr => arr.id === id ); // 取出目前欄位的index 
                if(this.vacancy_data.skills[index].status){
                    this.vacancy_data.skills[index].status = false;  // 加號變減號
                    this.vacancy_data.skills = [...this.vacancy_data.skills, { // 新增一個陣列欄位，重新繪出視窗
                        'id':this.vacancy_data.skills[this.vacancy_data.skills.length-1].id + 1,
                        'status': true,
                        'value': ''
                        }];
                }
                else {
                    this.vacancy_data.skills = this.vacancy_data.skills.filter(arr => arr.id !== id); // 移除目前id的輸入視窗
                }
            },
            toggleLang (id) {
                var index = this.vacancy_data.language.findIndex(arr => arr.id === id ); // 取出目前欄位的index 
                if(this.vacancy_data.language[index].status){
                    this.vacancy_data.language[index].status = false;  // 加號變減號
                    this.vacancy_data.language = [...this.vacancy_data.language, { // 新增一個陣列欄位，重新繪出視窗
                        'id':this.vacancy_data.language[this.vacancy_data.language.length-1].id + 1,
                        'status': true,
                        'type': '',
                        'read': '',
                        'write': '',
                        'listen': '',
                        'speak': ''
                        }];
                }
                else {
                    this.vacancy_data.language = this.vacancy_data.language.filter(arr => arr.id !== id); // 移除目前id的輸入視窗
                }
            },
            isChecked () { // vacancyTypeName 欄位是否有填寫
                let count = 0
                this.vacancy_data.checked.map(arr => {
                    if(arr.content.length > 0)
                        count++
                })
                return count;
            },
            validateForm () {
                this.$validator.validateAll().then((result) => {
                    if (result && this.isChecked()) {
                        api.getData('/ee/api/api_vacancy.php', {
                            params: {
                                methods: 'insert',
                                data: this.vacancy_data
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
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip(); 
    });
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