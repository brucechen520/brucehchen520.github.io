<template>
  <div class="container">
    <div class="row"></div>
    <h1>用戶操作紀錄</h1>
    <table id=logTable>
        <tr>
            <th>序號</th>
            <th>身分</th>
            <th>姓名</th>
            <th>類別</th>
            <th>動作</th>
            <th>詳情</th>
            <th>時間</th>
        </tr>
        <tr v-for="item in logData" :key="item.serial">
            <td>{{item.serial}}</td>
            <td>{{item.memberTitle}}</td>
            <td>{{item.memberName}}</td>
            <td>{{item.pageType}}</td>
            <td>{{item.actionType}}</td>
            <td>{{item.actionDetail}}</td>
            <td>{{item.actionTime}}</td>
        </tr>
    </table>
  </div>
  
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'
    import * as api from '../lib/api';
    import DatePicker from 'vue2-datepicker' 
    export default {
        data () {
          return {
            logData:[],
          }
        },
        computed: {
            // ...mapGetters 為 ES7 寫法
            ...mapGetters({
                // getTodo return value 將會存在別名為 todos 的 webData 上
                users: 'getUser'
            })
        },
        created () {
            let self = this;
            this.action_actionlog_get({Mem_Se:self.users.id}).then(function(result){
                self.logData = result.data.list;
                //self.website_sets = [...self.stateWebData.list];
            });
        },
        methods: {
            ...mapActions([
  	            'action_actionlog_get',
  	        ]),
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

    input:invalid {
        border-color: red;
    }
    textarea:invalid {
        border-color: red;
    }
        #logTable {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            width: 100%;
            border-collapse: collapse;
        }

        #logTable td, #logTable th {
            font-size: 1em;
            border: 1px solid #98bf21;
            padding: 3px 7px 2px 7px;
        }

        #logTable th {
            font-size: 1.1em;
            text-align: left;
            padding-top: 5px;
            padding-bottom: 4px;
            background-color: #A7C942;
            color: #ffffff;
        }

        #logTable tr.alt td {
            color: #000000;
            background-color: #EAF2D3;
        }
</style>