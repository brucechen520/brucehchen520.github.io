<template>
  <div id="app">
    <div class="container" style="float:center; ">
        <div class="marquee">
          <div>
            <span><a href="https://goo.gl/6npks4" target="_blank">各班失聯系友協尋名單</a></span>
          </div>  
        </div>
        <b-navbar sticky type="light" class="bg-navbar">
          <b-navbar-nav >
            <b-nav-item href="https://etouch.ee.fcu.edu.tw/ee/main.php">§ 回會員系統</b-nav-item>
            <b-nav-item-dropdown text="§網站列表" >
              <b-dropdown-item to="/WebsiteQuery">網站查詢</b-dropdown-item>
              <b-dropdown-item :to="{name:'products'}">商品查詢</b-dropdown-item>
              <b-dropdown-item href="https://goo.gl/HHXPvG">公開名片區</b-dropdown-item>
            </b-nav-item-dropdown>
            <b-nav-item-dropdown text="§工作媒合" >
              <b-dropdown-item to="/JobQuery">工作查詢</b-dropdown-item>
              <b-dropdown-item to="/FindMan">人才查詢</b-dropdown-item>
            </b-nav-item-dropdown>
            <b-nav-item-dropdown text="§個人專區" v-if="users.name !=='訪客'">
              <b-dropdown-item :to="{name:'personalSkill'}">基本資料</b-dropdown-item>
              <b-dropdown-item :to="{name:'personalVacancy'}">發佈職缺</b-dropdown-item>
              <b-dropdown-item :to="{name:'personalProject'}">發佈專案</b-dropdown-item>
              <b-dropdown-item :to="{name:'personalWeb'}">發佈網站</b-dropdown-item>
              <b-dropdown-item :to="{name:'personalProduct'}">發佈商品</b-dropdown-item>
              <b-dropdown-item :to="{name:'personalNameCard'}">名片上傳</b-dropdown-item>
            </b-nav-item-dropdown>
            <b-nav-item-dropdown text="§管理" v-if = "users.isAdmin">
              <b-dropdown-item :to="{name:'manageReview'}">審核頁面</b-dropdown-item>
              <b-dropdown-item :to="{name:'manageLog'}">操作紀錄</b-dropdown-item>
              <b-dropdown-item href="http://etouch.ee.fcu.edu.tw/photo/#!Albums/album_e7b3bbe58f8be5908de78987e694b6e7b48de58d802028e7b3bbe58f8be69c83e5b088e794a82de4b88de585ace9968b29" target="_blank">不公開名片區</b-dropdown-item>
            </b-nav-item-dropdown>
          </b-navbar-nav>
          <b-navbar-nav class="ml-auto">
            <b-nav-item-dropdown :text="users.name" v-if="users.name !=='訪客'">
              <b-nav-item href="https://etouch.ee.fcu.edu.tw/ee/logout.php">登出</b-nav-item>
            </b-nav-item-dropdown>
            <b-nav-item v-if="users.name =='訪客'" href="#" @click="login">§ 登入</b-nav-item>
          </b-navbar-nav>
        </b-navbar>
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
    export default {
      created () {
          this.$store.dispatch('action_user_get');
      },
      computed: {
          // ...mapGetters 為 ES7 寫法
          ...mapGetters({
              // getTodo return value 將會存在別名為 todos 的 webData 上
              users: 'getUser'
          }),
      },
      methods:{
        login(){
          this.$store.dispatch('action_login').then(() =>{
            this.$store.dispatch('action_user_get');
          })
          
        }
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
