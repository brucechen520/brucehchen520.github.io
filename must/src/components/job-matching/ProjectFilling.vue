<template>
  <div class="container">
    <h1>專案填寫網站</h1>
    <div class="row">
        {{ graduate }}級:{{ name }}
    </div>
    <div class="row">
        <label class="col-2">公司名稱</label>
        <input class="col-2" v-model="project_data.company_Name">
        <label class="col-2">公司網址</label>
        <input class="col-2" v-model="project_data.company_Website">
    </div>
    <div class="row">
        <label class="col-2">案件名稱</label>
        <input v-model="project_data.project_Name">
    </div>
    <div class="row">
        <label class="col-2">描述</label>
        <textarea rows="5" cols="100" v-model="project_data.description"> </textarea>
    </div>
    <div class="row">
        <label class="col-2">關鍵字</label>
        <div v-for="(item, index) in project_data.key">
            <input v-model="item.value">
            <label :class="[item.status ? 'fas fa-plus' : 'fas fa-minus']" @click="toggleKey(item.id)"></label>
        </div>
    </div>
    <div class="row">
        <label class="col-2">案件預算</label>
        <input v-model="project_data.project_budget">
    </div>
    <div class="row">
        <label class="col-2">案件類別</label>
        <button class="col-2 btn btn-primary" data-toggle="modal" data-target="#exampleModal">新增項目</button>
        <label class="col-2">專長技能</label>
        <input v-model="project_data.skills">
    </div>
    <div class="row">
        <label class="col-2">語言能力</label>
        <input v-model="project_data.language">
        <label class="col-2">專案截止期限</label>
        <input v-model="project_data.deadline">
    </div>
    <div class="row">
        <label class="col-2">聯絡人資料</label>
    </div>
    <div class="row">
        <label class="col-2">聯絡人稱呼</label>
        <input v-model="project_data.contact_Name">
        <label class="col-2">E-Mail</label>
        <input v-model="project_data.contact_Mail">
        <div class="w-100"></div>
        <label class="col-2">連絡電話</label>
        <input v-model="project_data.contact_Phone">
        <label class="col-2">方便聯絡時間</label>
        <input v-model="project_data.contact_Time">
    </div>
    <div class="row">
        <button class="col-1">送出</button>
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
                                        :id="item" :value="item" v-model="project_data.checked[0].content">
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
     
    export default {
        data () {
          return {
            name: '陳十二',
            graduate: '104',
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
                'language':'',  //  語文條件
                'skills':'',  //  專長技能
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