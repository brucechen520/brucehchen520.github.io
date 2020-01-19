import * as types from './mutations_type.js'
import Vue from 'vue'

// state
export const state = {
  userInfo: 
    {
      'name':'',
      'level': '',
      'isAdmin': 0,
      'error':''
    },
  jobOpts: {
    'selected': 1,
    'projectCount': 0,
    'jobCount': 0
  },
  stateProjectData:{},
  stateVacanceData:{},
  stateWebData:{},
  stateReviewType:"",
}

// mutations
export const mutations = {
  // action 發出 commit 會對應到 mutation 使用的是 Object key 方式
  [types.ACCEPT_USER] (state, user) {
    // 在 mutation 改變 state（只有 mutation 可以改變！）
    this.state.userInfo = {...user};
  },
  [types.CHANGE_SELECTED] (state, selected) {
    // 在 mutation 改變 state（只有 mutation 可以改變！）
    this.state.jobOpts.selected = selected;
  },
  [types.SET_COUNT] (state, jobCount, projectCount) {
    // 在 mutation 改變 state（只有 mutation 可以改變！）
    this.state.jobOpts.projectCount = projectCount;
    this.state.jobOpts.jobCount = jobCount;
  },
  [types.ERROR] (state, error) {
    // 在 mutation 改變 state（只有 mutation 可以改變！）
    this.state.userInfo.error = error;
  },
  [types.SET_PROJECT_DATA] (state, data) {
    state.stateProjectData = data;
  },
  [types.SET_VACANCE_DATA] (state, data) {
    state.stateVacanceData = data;
  },
  [types.SET_REVIEW_TYPE] (state, data) {
    state.stateReviewType = data;
  },
  [types.SET_WEB_DATA] (state, data) {
    state.stateWebData = data;
  },
}