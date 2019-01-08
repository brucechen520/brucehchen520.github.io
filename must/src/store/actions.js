import Vue from 'vue'
import mutations from './mutations'
// 引入 mutations_type （引用同一個 key）
import * as types from './mutations_type.js'

export const addTodo  = ({ commit }, newTodo) => {
    /*
    * 第二個參數是接收 Vue 傳遞的 value: num
    * template 上面我們是這們寫的:
    *   @click="actionIncrease(num)"
    */
    commit(types.ADD_TODO, newTodo);
}


