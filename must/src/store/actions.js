import Vue from 'vue'
import mutations from './mutations'
// 引入 mutations_type （引用同一個 key）
import * as types from './mutations_type.js';
import { getUserData } from '../components/lib/api';
export const acceptUser  = ({ commit }, data) => {
    
    getUserData('/ee/api/api_user.php', data)
        .then(function (user) {
            commit(types.ACCEPT_USER, user);
        })
        .catch(function (error) {
            commit(types.ERROR, error);
        })
    /*
    * 第二個參數是接收 Vue 傳遞的 value: num
    * template 上面我們是這們寫的:
    *   @click="actionIncrease(num)"
    */
    
}


