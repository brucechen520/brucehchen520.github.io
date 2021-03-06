import * as types from './mutations_type.js'
import Vue from 'vue'

// state
export const state = {
  userInfo: 
    {
      'id':'',
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
  stateProjectData:{list:[]},
  stateVacanceData:{list:[]},
  stateWebData:{list:[]},
  stateReviewType:0,
  stateResumeData:{
    expertise:[],
    license:[],
    works:[],
  },
  stateMemberData:{list:[]},
  stateProductData:{list:[]},
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
    data.list.forEach(e => {
      e.urlType = e.company_Website.split("://")[0] + "://";
      e.urlShort = e.company_Website.split("://")[1];
    });
    state.stateProjectData = data;
  },
  [types.SET_PRODUCT_DATA] (state, data) {
      data.list.forEach(e => {
        e.urlType = e.url.split("://")[0] + "://";
        e.urlShort = e.url.split("://")[1];
      });
    state.stateProductData = data;
  },
  [types.SET_VACANCE_DATA] (state, data) {
    data.list.forEach(e => {
      e.urlType = e.company_Website.split("://")[0] + "://";
      e.urlShort = e.company_Website.split("://")[1];
    });
    state.stateVacanceData = data;
  },
  [types.SET_REVIEW_TYPE] (state, data) {
    state.stateReviewType = data;
  },
  [types.SET_WEB_DATA] (state, data) {
    data.list.forEach(e => {
      e.urlType = e.url.split("://")[0] + "://";
      e.urlShort = e.url.split("://")[1];
    });
    state.stateWebData = data;
  },
  [types.SET_RESUME_DATA] (state, data) {
    data.expertise = data.expertise || "";
    data.works = data.works || "";
    data.license = data.license || "";
    state.stateResumeData = data;
  },
  [types.SET_MEMBER_DATA] (state, data) {
    state.stateMemberData = data;
  },
  [types.SET_STATUS] (state, data) {
    if(state.stateReviewType == 0)
      state.stateProjectData.list.filter(e=>e.id == data.id)[0].status = data.status;
    else if(state.stateReviewType == 1)
      state.stateVacanceData.list.filter(e=>e.id == data.id)[0].status = data.status;
    else
      state.stateWebData.list.filter(e=>e.id == data.id)[0].status = data.status;
  },
}