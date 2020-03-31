<template>
  <div id="app">
    <div class="container" style="float:left; ">
        <div class="marquee">
          <div>
            <span><a href="https://goo.gl/6npks4" target="_blank">各班失聯系友協尋名單</a></span>
          </div>  
        </div>

        <ul class="nav row justify-content-start">
          <li class="nav-item col-3-auto">
              <button class="btn alert-info" type="button" aria-haspopup="true" aria-expanded="false" data-display="static">
                  <a href="https://etouch.ee.fcu.edu.tw/ee/main.php" title="回會員系統">§ 回會員系統</a>
              </button>
          </li>
          <li class="nav-item col-3-auto">
            <div class="dropdown">
              <button class="btn alert-info dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                  §網站列表
              </button>
              <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropdownMenuButton1">
                <a class="dropdown-item">
                  <router-link to="/WebsiteQuery">
                    網站查詢
                  </router-link>
                </a>
                <a class="dropdown-item" href="https://goo.gl/HHXPvG" target="_blank">公開名片區</a>
              </div>
            </div>
          </li>

          <li class="nav-item col-3-auto">
            <div class="dropdown">
              <button class="btn alert-info dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                  §工作媒合
              </button>
              <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropdownMenuButton2">
                <a class="dropdown-item" v-if="users.name ==='訪客'">
                  <div >
                    請註冊會員再登入來查詢
                  </div>
                </a>
                <a class="dropdown-item">
                  <router-link to="/JobQuery">
                    工作查詢
                  </router-link>
                </a>
                <a class="dropdown-item">
                  <router-link to="/FindMan">
                    人才查詢
                  </router-link>
                </a>
              </div>
            </div>
          </li>
          
          <li class="nav-item col-3-auto" v-if="users.name !=='訪客'">
            <div class="dropdown">
              <button class="btn alert-info dropdown-toggle" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                  §個人專區
              </button>
              <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropdownMenuButton3">
                <div v-if="users.name !=='訪客'">
                    <a class="dropdown-item">
                      <router-link :to="{name:'personalSkill'}" >
                        基本資料
                      </router-link>
                    </a>
                  <!-- <div class="dropdown-submenu">
                    <span class = "dropdown-item">我的職缺</span>
                    <ul class="dropdown-menu">
                      <li class="dropdown-item">                        
                        <a class="dropdown-item">
                          <router-link to="/JobVacancies" >
                            新增職缺
                          </router-link>
                        </a>
                      </li>
                      <li class="dropdown-item">                        
                        <a class="dropdown-item">
                          <router-link to="/ProjectFilling" > 
                            新增專案
                          </router-link>
                        </a>
                      </li>
                      <li class="dropdown-item">                        
                        <a class="dropdown-item">
                          <router-link to="/myJob" >
                            修改職缺/專案
                          </router-link>
                        </a>
                      </li>
                    </ul>
                  </div> -->
                  <a class="dropdown-item">                  
                    <router-link :to="{name:'personalVacancy'}">發佈職缺</router-link>
                  </a>
                  <a class="dropdown-item">
                    <router-link :to="{name:'personalProject'}">發佈專案</router-link>
                  </a>
                  <a class="dropdown-item">
                    <router-link :to="{name:'personalWeb'}">發佈網站</router-link>
                  </a>
                  <div class="dropdown-submenu">
                    <span class = "dropdown-item">名片上傳</span>
                    <ul class="dropdown-menu">
                      <li class="dropdown-item">                        
                        <a class="dropdown-item" href="https://140.134.29.2:5001/sharing/wNhbCOzDw?fbclid=IwAR3QHKYUJCFoNFvBxHGvV0R72KkAqD5-r6EOudaWayZHNW7Il5Li_wxVg_8" target="_blank">公開名片區上傳</a>
                      </li>
                      <li class="dropdown-item">                        
                        <a class="dropdown-item" href="#" target="_blank">不公開名片區上傳</a>
                      </li>
                    </ul>                    
                  </div>              
                  
                  
                </div>
              </div>
            </div>
          </li>

          <li class="nav-item col-3-auto" v-if = "users.isAdmin">
            <div class="dropdown">
              <button class="btn alert-info dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                  §管理
              </button>
              <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropdownMenuButton4">
                <div>
                  <a class="dropdown-item">
                    <router-link :to="{name:'manageReview'}">
                      審核頁面
                    </router-link>
                  </a>
                  <a class="dropdown-item">
                    <router-link :to="{name:'manageLog'}">
                      操作紀錄
                    </router-link>
                  </a>             
                  <a class="dropdown-item" href="#" target="_blank">不公開名片區</a>
                </div>
              </div>
            </div>
          </li>

          <!-- <li class="nav-item col-3-auto">
            <div class="dropdown">
              <button class="btn alert-info dropdown-toggle" type="button" id="dropdownMenuButton5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                  §管理
              </button>
              <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                <li class="dropdown-item"><a href="#">Some action</a></li>
                <li class="dropdown-item"><a href="#">Some other action</a></li>
                <li class="dropdown-divider"></li>
                <li class="dropdown-submenu">
                  <a class="dropdown-item" tabindex="-1" href="#">Hover me for more options</a>
                  <ul class="dropdown-menu">
                    <li class="dropdown-item"><a tabindex="-1" href="#">Second level</a></li>
                    <li class="dropdown-submenu">
                      <a class="dropdown-item" href="#">Even More..</a>
                      <ul class="dropdown-menu">
                        <li class="dropdown-item"><a href="#">3rd level</a></li>
                        <li class="dropdown-submenu"><a class="dropdown-item" href="#">another level</a>
                          <ul class="dropdown-menu">
                            <li class="dropdown-item"><a href="#">4th level</a></li>
                            <li class="dropdown-item"><a href="#">4th level</a></li>
                            <li class="dropdown-item"><a href="#">4th level</a></li>
                          </ul>
                        </li>
                        <li class="dropdown-item"><a href="#">3rd level</a></li>
                      </ul>
                    </li>
                    <li class="dropdown-item"><a href="#">Second level</a></li>
                    <li class="dropdown-item"><a href="#">Second level</a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </li> -->

          <li class="nav-item col-3-auto">
            <div class="btn-group">
              <button class="btn alert-info" type="button" aria-haspopup="true" aria-expanded="false" data-display="static">
                  <a href="https://etouch.ee.fcu.edu.tw/ee/logout.php" title="登出">§ 登出</a>
              </button>
            </div>
          </li>
          <!-- <li @click="login">登入</li> -->
        </ul>  
        <div style="margin-top:20px;">
          <router-view></router-view>
        </div>
    </div>
  </div>
</template>

<script>
    import Vue from 'vue';
    import { mapGetters, mapActions } from 'vuex'
    export default {
      created () {
          this.$store.dispatch('acceptUser');
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

      }
    }
</script>
<style scoped>
    .marquee {
      height: 25px;
      width: 1024px;

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
    
    .dropdown-submenu{position:relative;}
    .dropdown-submenu>.dropdown-menu{top:0;left:100%;margin-top:-6px;margin-left:-1px;-webkit-border-radius:0 6px 6px 6px;-moz-border-radius:0 6px 6px 6px;border-radius:0 6px 6px 6px;}
    .dropdown-submenu:hover>.dropdown-menu{display:block;}
    .dropdown-submenu>a:after{display:block;content:" ";float:right;width:0;height:0;border-color:transparent;border-style:solid;border-width:5px 0 5px 5px;border-left-color:#cccccc;margin-top:5px;margin-right:-10px;}
    .dropdown-submenu:hover>a:after{border-left-color:#ffffff;}
    .dropdown-submenu.pull-left{float:none;}.dropdown-submenu.pull-left>.dropdown-menu{left:-100%;margin-left:10px;-webkit-border-radius:6px 0 6px 6px;-moz-border-radius:6px 0 6px 6px;border-radius:6px 0 6px 6px;}
</style>
