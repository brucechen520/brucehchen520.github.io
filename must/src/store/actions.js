import Vue from 'vue'
import mutations from './mutations'
import { api2 } from '../assets/api.js'
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
export const action_project_get  = ({ commit }, param) => {
    return new Promise((resolve, reject) => {
        api2.project_get(param,function(result){
            if(result.code == 'success'){
              commit(types.SET_PROJECT_DATA, result.data);
            }
            resolve(result);
        }, false, function(error){                
            resolve("failed");                
        });       
    });     
}

export const action_vacance_get  = ({ commit }, param) => {
    return new Promise((resolve, reject) => {
        api2.vacance_get(param,function(result){
            if(result.code == 'success'){
              commit(types.SET_VACANCE_DATA, result.data);
            }
            resolve(result);
        }, false, function(error){                
            resolve("failed");                
        });       
    });      
}

export const action_web_get  = ({ commit }, param) => {
    return new Promise((resolve, reject) => {
        api2.web_get(param,function(result){
            if(result.code == 'success'){
                commit(types.SET_WEB_DATA, result.data);
            }
            resolve(result);
        }, false, function(error){                
            resolve("failed");                
        });       
    });       
}
export const action_vacancy_comfirm  = ({ commit }, param) => {
    return new Promise((resolve, reject) => {
        api2.vacancy_comfirm(param,function(result){
            if(result.code != 'success'){
                alert(result);
            }
            resolve(result);
        }, false, function(error){                
            resolve("failed");                
        });       
    });            
}

export const action_project_comfirm  = ({ commit }, param) => {
    return new Promise((resolve, reject) => {
        api2.project_comfirm(param,function(result){
            if(result.code != 'success'){
                alert(result);
            }
            resolve(result);
        }, false, function(error){                
            resolve("failed");                
        });       
    });    
}

export const action_web_comfirm  = ({ commit }, param) => {
    return new Promise((resolve, reject) => {
        api2.web_comfirm(param,function(result){
            if(result.code != 'success'){
                alert(result);
            }
            resolve(result);
        }, false, function(error){                
            resolve("failed");                
        });       
    });            
}

export const action_set_review_type  = ({ commit }, data) => {
    commit(types.SET_REVIEW_TYPE, data);
}

export const action_update_status  = ({ commit }, data) => {
    commit(types.SET_STATUS, data);
}

export const changeSelected  = ({ commit }, data) => {
    
    commit(types.CHANGE_SELECTED, data);
    /*
    * 第二個參數是接收 Vue 傳遞的 value: num
    * template 上面我們是這們寫的:
    *   @click="actionIncrease(num)"
    */
    
}

export const setCount  = ({ commit }, jobCount, projectCount) => {
    
    commit(types.CHANGE_SELECTED, jobCount, projectCount);
    /*
    * 第二個參數是接收 Vue 傳遞的 value: num
    * template 上面我們是這們寫的:
    *   @click="actionIncrease(num)"
    */
    
}
