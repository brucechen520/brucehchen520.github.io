<template>
  <div class="container">
    <div class="row">個人專案填寫頁面</div>
    <h1>專案填寫網站</h1>
    <div class="row">
        {{ users.level }}級:{{ users.name }}
    </div>
    <div class="row">
        <label class="col-2">公司名稱</label>
        <input class="col-2" v-model="project_data.company_Name" v-validate="'required|min: 3'" name = "company_Name">
        <label class="col-2">公司網址</label>
        <input class="col-2" v-model="project_data.company_Website" v-validate="'required|url'" name="url" type="text">
        <span v-show="errors.has('url')" class="help is-danger">{{ errors.first('url') }}</span>
    </div>
    <div class="row">
        <label class="col-2">案件名稱</label>
        <input v-model="project_data.project_Name" v-validate="'required'" name = "project_Name">
    </div>
    <div class="row">
        <label class="col-2">描述</label>
        <textarea rows="5" cols="100" v-model="project_data.description" v-validate="'required'" name="description"> </textarea>
        <span>{{ errors.first('description') }}</span>
    </div>
    <div class="row">
        <label class="col-2">關鍵字</label>
        <div v-for="(item, index) in project_data.key">
            <input v-model="item.value" v-validate="'required'" :name = "'keyWord_' +index">
            <label :class="[item.status ? 'fas fa-plus' : 'fas fa-minus']" @click="toggleKey(item.id)"></label>
            <span v-show="errors.has('keyWord_' + index)">{{ errors.first('keyWord_' + index) }}</span>
        </div>
    </div>
    <div class="row">
        <label class="col-2">案件預算</label>
        <input v-model="project_data.project_budget" v-validate="'required'" name = "project_budget">
    </div>
    <div class="row">
        <label class="col-2">案件類別</label>
        <button class="col-2 btn btn-primary" data-toggle="modal" data-target="#exampleModal">新增項目</button>
        <label class="col-2">專長技能</label>
        <div v-for="(item, index) in project_data.skills">
            <label> 專長 {{ index }} </label>
            <input v-model="item.value" v-validate="'required'" :name = "'skill_' +index">
            <label :class="[item.status ? 'fas fa-plus' : 'fas fa-minus']" @click="toggleSkill(item.id)"></label>
            <span v-show="errors.has('skill_' + index)">{{ errors.first('skill_' + index) }}</span>
        </div>
    </div>
    <div class="row">
        <label class="col-2">已勾選的內容</label>
        <ul>
            <li v-for="item in project_data.checked">
                {{ item.title }}: {{ item.content }}
            </li>
        </ul>
    </div>
    <div class="row">
        <label class="col-2" data-toggle="tooltip" data-placement="top" title="請輸入英文等語言">語言條件(Hover me)</label>
        <div v-for="(lang, index) in project_data.language">
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
        <label class="col-2">專案截止期限</label>
        <date-picker v-model="project_data.deadline" :lang="lang" :time-picker-options="timePickerOptions" value-type="timestamp" :not-before="new Date()" ></date-picker>
        <span v-show="errors.has('project_deadline')" class="help is-danger">{{ errors.first('project_deadline') }}</span>
        <input v-model = "project_data.deadline" v-show="false" v-validate="'required'" name = "project_deadline"/>
    </div>
    <div class="row">
        <label class="col-2">聯絡人資料</label>
    </div>
    <div class="row">
        <label class="col-2">聯絡人稱呼</label>
        <input v-model="project_data.contact_Name" v-validate="'required'" name = "contact_Name">
        <label class="col-2">E-Mail</label>
        <input v-model="project_data.contact_Mail" v-validate="'required|email'" type="email" name="email">
        <span>{{ errors.first('email') }}</span>
        <div class="w-100"></div>
        <label class="col-2">連絡電話</label>
        <input v-model="project_data.contact_Phone" v-validate="'numeric'" name = "contact_Phone">
        <label class="col-2">方便聯絡時間</label>
        <input v-model="project_data.contact_Time" v-validate="'required'" name = "contact_Time">
    </div>
    <div class="row">
        <button class="col-1" @click="validateForm">送出</button>
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
                        網路資訊相關
                        </button>
                        <ul class="dropdown-menu customClassForDropDown p-3 mb-2 bg-gradient-warning text-dark" > <!-- 使用flex: p-2 bg-info 和 白字text-white 滾輪:customClassForDropDown -->
                            <div class="list-group">
                                <li class="list-group-item-info">
                                    <input type="checkbox" @click="selectDropAll(prjoectTypeName[0].title, allsubSelected[0])" v-model="allsubSelected[0]">
                                    <label>網路資訊相關</label>
                                </li >
                                <li class="list-group-item" v-for="item in prjoectTypeName[0].content" @click="liclick($event)">
                                    <input type="checkbox" class="dropdown-item custom-control-input " 
                                            :id="item" :value="item" v-model="project_data.checked[0].content"
                                            
                                            >
                                    <label class="custom-control-label" :for="item"> {{ item }} </label>
                                </li>
                            </div>
                        </ul>
                    </div>
                    <div class="dropdown ">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        行銷企劃相關
                        </button>
                        <ul class="dropdown-menu customClassForDropDown p-3 mb-2 bg-gradient-warning text-dark" > <!-- 使用flex: p-2 bg-info 和 白字text-white -->
                            <div class="list-group">
                                <li class="list-group-item-info">
                                    <input type="checkbox" @click="selectDropAll(prjoectTypeName[1].title, allsubSelected[1])" v-model="allsubSelected[1]">
                                    <label>行銷企劃相關</label>
                                </li>
                                <li class="list-group-item" v-for="item in prjoectTypeName[1].content" @click="liclick($event)">
                                    <input type="checkbox" class="dropdown-item custom-control-input " 
                                            :id="item" :value="item" v-model="project_data.checked[1].content">
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
            allsubSelected: [false,false], // 全選了嗎 0: 網路資訊相關, 1: 行銷企劃相關 2:  
                                           //          3:  4: 
            project_data: {
                'company_Name':'', // 公司名稱
                'company_Website':'', // 公司網址
                'project_Name':'', // 職缺名稱
                'description':'', // 描述
                'checked': [             // 職務類別是否已被選擇                          
                    {
                        'title':'網路資訊相關',
                        'content': []                     
                    },
                    {
                        'title':'行銷企劃相關',
                        'content': []
                    }
                ], 
                'key':[{
                    'id': Number(1),
                    'status': true,
                    'value':''
                }],       // 關鍵字
                'project_budget':'',    // 案件預算
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
                }],  //  專長技能
                'deadline':'',  //  截止期限
                'contact_Name':'',  //  聯絡人姓名
                'contact_Mail':'',  //  E-MAIL
                'contact_Phone':'',  //  連絡電話
                'contact_Time': ''   //  方便聯絡時間
            },
            prjoectTypeName: [
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
                    this.prjoectTypeName.filter(arr => {
                        if(arr.title === title){
                            this.project_data.checked.filter((arr1, index) => { 
                                if(arr1.title === title){
                                    this.project_data.checked[index].content = arr.content;
                                }
                            })
                        }
                    });
                }
                else{
                    this.prjoectTypeName.filter(arr => {
                        if(arr.title === title){
                            this.project_data.checked.filter((arr1, index) => { 
                                if(arr1.title === title){
                                    this.project_data.checked[index].content = [];
                                }
                            })
                        }
                    });
                }
            },
            toggleKey (id) {
                var index = this.project_data.key.findIndex(arr => arr.id === id ); // 取出目前欄位的index 
                if(this.project_data.key[index].status){
                    this.project_data.key[index].status = false;  // 加號變減號
                    this.project_data.key = [...this.project_data.key, { // 新增一個陣列欄位，重新繪出視窗
                        'id':this.project_data.key[this.project_data.key.length-1].id + 1,
                        'status': true,
                        'value': ''
                        }];
                }
                else {
                    this.project_data.key = this.project_data.key.filter(arr => arr.id !== id); // 移除目前id的輸入視窗
                }
            },
            toggleSkill (id) {
                var index = this.project_data.skills.findIndex(arr => arr.id === id ); // 取出目前欄位的index 
                if(this.project_data.skills[index].status){
                    this.project_data.skills[index].status = false;  // 加號變減號
                    this.project_data.skills = [...this.project_data.skills, { // 新增一個陣列欄位，重新繪出視窗
                        'id':this.project_data.skills[this.project_data.skills.length-1].id + 1,
                        'status': true,
                        'value': ''
                        }];
                }
                else {
                    this.project_data.skills = this.project_data.skills.filter(arr => arr.id !== id); // 移除目前id的輸入視窗
                }
            },
            toggleLang (id) {
                var index = this.project_data.language.findIndex(arr => arr.id === id ); // 取出目前欄位的index 
                if(this.project_data.language[index].status){
                    this.project_data.language[index].status = false;  // 加號變減號
                    this.project_data.language = [...this.project_data.language, { // 新增一個陣列欄位，重新繪出視窗
                        'id':this.project_data.language[this.project_data.language.length-1].id + 1,
                        'status': true,
                        'type': '',
                        'read': '',
                        'write': '',
                        'listen': '',
                        'speak': ''
                        }];
                }
                else {
                    this.project_data.language = this.project_data.language.filter(arr => arr.id !== id); // 移除目前id的輸入視窗
                }
            },
            isChecked () { // prjoectTypeName 欄位是否有填寫
                let count = 0
                this.project_data.checked.map(arr => {
                    if(arr.content.length > 0)
                        count++
                })
                return count;
            },
            validateForm () {
                this.$validator.validateAll().then((result) => {
                    if (result && this.isChecked()) {
                        api.getData('/ee/api/api_project.php', {
                            params: {
                                methods: 'insert',
                                data: this.project_data
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