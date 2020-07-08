<template>
  <div class="hello-world" @click="login">
    {{msg}}
  </div>
</template>

<script>
export default {
  name: 'home',
  data () {
    return {
      msg: '老MMMMMMM'
    }
  },
  methods:{
  login(){
    console.log(123);
    this.$store.dispatch('action_login').then(() =>{
      this.$store.dispatch('action_user_get');
    })
    
  },
  closenav(){
    $('#myNavbar').collapse('hide')
  },
},
}
</script>

<style>
    .hello-world {
      color:red;
    }
</style>