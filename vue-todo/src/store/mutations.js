import * as types from './mutations_type.js'
import Vue from 'vue'

// state
export const state = {
  todos: [
  ],
  listid: 1
}

// mutations
export const mutations = {
  // action 發出 commit 會對應到 mutation 使用的是 Object key 方式
  [types.ADD_TODO] (state, newTodo) {
    // 在 mutation 改變 state（只有 mutation 可以改變！）
    state.todos.push({
        id: state.listid, // 序號
        done: false,
        message: newTodo,
    });
    state.listid = state.listid + 1;
  },

  [types.EDIT_TODO] (state) {
    // 在 mutation 改變 state（只有 mutation 可以改變！）
    
  },
  [types.TODO_COMPLETED] (state, id) {
    // 在 mutation 改變 state（只有 mutation 可以改變！）

    state.todos = state.todos.map( todo => todo.id === id 
        ? { 
            'id':todo.id, 
            'done': !todo.done,
            'message': todo.message}
        : todo)
    // state.todos[ id - 1 ].done = !state.todos[ id - 1 ].done; 
  },

  [types.DELETE_TODO] (state, id) {
    // 在 mutation 改變 state（只有 mutation 可以改變！）
    state.todos = state.todos.filter(item => item.id !== id)
    console.log(id);
  },
  
  [types.CHECKED_TODO] (state) {
    // 在mutation 改變 state （只有 mutation 可以改變 !）

    
  }
  
}