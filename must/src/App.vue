<template>
  <div id="app">
    <div class="container">
        <div class="marquee row">
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
              <button class="btn alert-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                  §網站列表
              </button>
              <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="https://goo.gl/HHXPvG" target="_blank">公開名片區</a>
                <a class="dropdown-item" href="https://140.134.29.2:5001/sharing/wNhbCOzDw?fbclid=IwAR3QHKYUJCFoNFvBxHGvV0R72KkAqD5-r6EOudaWayZHNW7Il5Li_wxVg_8" target="_blank">公開名片區上傳</a>
                <a class="dropdown-item" href="#" target="_blank">不公開名片區</a>
                <a class="dropdown-item" href="#" target="_blank">不公開名片區上傳</a>
                <a class="dropdown-item">
                  <router-link to="/WebsiteQuery">
                    網站查詢
                  </router-link>
                </a>
                <a class="dropdown-item" v-if="users.name ==='訪客'">
                  <div>
                    請註冊會員再登入來查詢
                  </div>
                </a>
                <a class="dropdown-item" v-if="users.name !=='訪客'">
                  <router-link to="/WebsiteFilling" >
                    網站填寫
                  </router-link>
                </a>
              </div>
            </div>
          </li>

          <li class="nav-item col-3-auto">
            <div class="dropdown">
              <button class="btn alert-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                  §工作媒合
              </button>
              <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" v-if="users.name ==='訪客'">
                  <div >
                    請註冊會員再登入來查詢
                  </div>
                </a>
                <a class="dropdown-item" v-if="users.name !=='訪客'">
                  <router-link to="/JobVacancies" >
                    職缺填寫
                  </router-link>
                </a>
                <a class="dropdown-item" v-if="users.name !=='訪客'">
                  <router-link to="/ProjectFilling" > 
                    專案填寫
                  </router-link>
                </a>
                <a class="dropdown-item" v-if="users.name !=='訪客'">
                  <router-link to="/SkillFilling" >
                    專長填寫
                  </router-link>
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
                <a class="dropdown-item">
                  <router-link to="/ReviewPage">
                    審核頁面
                  </router-link>
                </a>
              </div>
            </div>
          </li>
          
          <li class="nav-item col-3-auto">
            <div class="btn-group">
              <button class="btn alert-info" type="button" aria-haspopup="true" aria-expanded="false" data-display="static">
                  <a href="https://etouch.ee.fcu.edu.tw/ee/logout.php" title="登出">§ 登出</a>
              </button>
            </div>
          </li>
        </ul>
        <div class="row">
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
      components: {

      }
    }
</script>
<style scoped>
    .marquee {
      height: 25px;
      width: 420px;

      overflow: hidden;
      position: relative;
    }

    .marquee div {
      display: block;
      width: 200%;
      height: 30px;

      position: absolute;
      overflow: hidden;

      animation: marquee 10s linear infinite;
    }

    .marquee span {
      float: left;
      width: 50%;
    }

    @keyframes marquee {
      0% { left: 0; }
      25% { left: 50%; }
      50% { left: 100%; }
      75% { left: 50%; }
      100% { left: 0; }
    }
</style>
