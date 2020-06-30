<template>
  <div id="app">
    <div class="container" style="float:center; ">
        <div class="marquee">
          <div>
            <span><a href="https://goo.gl/6npks4" target="_blank">各班失聯系友協尋名單</a></span>
          </div>  
        </div>
        <nav class="navbar navbar-expand-md navbar-light bg-navbar">
            <div class="ls-md">電機系工商服務平台</div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myNavbar" aria-controls="myNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="myNavbar">
            <b-navbar-nav >
            <template v-for="item in getterNavItemWithAuth" >
              <b-nav-item v-if="item.href" :href="item.href" :key="item.text">{{item.text}}</b-nav-item>
              <b-nav-item-dropdown v-else-if="item.children" :text="item.text" :key="item.text">
                <template v-for="child in item.children">
                  <b-dropdown-item v-if="child.to" :to="child.to" @click="closenav" :key="child.to">{{child.text}}</b-dropdown-item>
                  <b-dropdown-item v-else-if="child.name" :to="{name:child.name}" @click="closenav" :key="child.name">{{child.text}}</b-dropdown-item>
                  <b-dropdown-item v-else-if="child.href" :href="child.href" target="_blank" @click="closenav" :key="child.href">{{child.text}}</b-dropdown-item>
                </template>
              </b-nav-item-dropdown>
            </template>
          </b-navbar-nav>
          <b-navbar-nav class="ml-auto">
            <b-nav-item-dropdown :text="users.name" v-if="users.name !=='訪客'">
              <b-nav-item href="https://etouch.ee.fcu.edu.tw/ee/logout.php">登出</b-nav-item>
            </b-nav-item-dropdown>
            <b-nav-item v-if="users.name =='訪客'" href="#" @click="login">§ 登入</b-nav-item>
          </b-navbar-nav>
            </div>
        </nav>
        <common-alert></common-alert>
        <div style="margin-top:20px;">
          <router-view></router-view>
        </div>
    </div>
  </div>
</template>

<script>
    import Vue from 'vue';
    import { mapGetters, mapActions } from 'vuex'
    import commonAlert from './components/common/alert.vue'
    import navItem from './assets/navbar.json';
    export default {
      data(){        
        return{
          sbVisable:true,
        }},
      created () {
          this.$store.dispatch('action_user_get');
      },
      computed: {
          ...mapGetters({
              users: 'getUser'
          }),
          getterNavItemWithAuth(){
            let navitem = navItem;
            if(this.users.name =='訪客')
              navitem = navitem.filter(e=>e.auth != 'user')
            if(!this.users.isAdmin)
              navitem = navitem.filter(e=>e.auth != 'admin')
            return navitem;
          }
      },
      methods:{
        login(){
          this.$store.dispatch('action_login').then(() =>{
            this.$store.dispatch('action_user_get');
          })
          
        },
        closenav(){
          $('#myNavbar').collapse('hide')
        },
      },
      components: {
        commonAlert,
      }
    }
</script>
<style scoped>

    .bg-navbar {
        background-color: #d1ecf1 !important;
    }
    .md-navbar {
        background-color: #d1ecf1 !important;
        /* background-color: #5ed6eb !important; */
    }
    @media screen and (max-width: 768px) {
      .bg-navbar {
          /* display: none; */
          /* background-color: #5ed6eb !important; */
      }
    }
    @media screen and (min-width: 768px) {
      .md-navbar {
          display: none;
          background-color: #d1ecf1 !important;
          /* background-color: #5ed6eb !important; */
      }
      .ls-md{
        display: none;
      }
    }
    .marquee {
      height: 25px;
      overflow: hidden;
      position: relative;
    }

    .marquee div {
      display: block;
      width: 200%;
      height: 30px;

      position: absolute;
      overflow: hidden;

      animation: marquee 20s linear infinite;
    }

    .marquee div:hover {
      animation-play-state: paused;
    }

    .marquee span {
      float: left;
      width: 100%;
    }

    @keyframes marquee {
      0% { left: 0; }
      25% { left: 50%; }
      50% { left: 100%; }
      75% { left: 50%; }
      100% { left: 0; }
    }
</style>
