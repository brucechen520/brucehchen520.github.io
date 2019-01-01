<template>
  <div id="app">
      <div class="dropdown">
        <button class="dropbtn"><router-link to="/Home">§回會員系統</router-link></button>
      </div>
      <div class="dropdown">
        <button class="dropbtn">§網站列表</button>
        <div class="dropdown-content">
        <a>
          <router-link to="/website-list/business-card/OpenBcard">
            公開名片區
          </router-link>
        </a>  
        <a>
          <router-link to="/website-list/business-card/CloseBcard">
            不公開名片區
          </router-link>
        </a>
        <a>
          <router-link to="/website-list/business-card/OpenbcardUpload">
            公開名片區上傳
          </router-link>
        </a>
        <a>
          <router-link to="/website-list/business-card/ClosebcardUpload">
            不公開名片區上傳
          </router-link>
        </a>
        <a>
          <router-link to="/website-list/website/WebsiteQuery">
            網站查詢
          </router-link>
        </a>
        <a>
          <router-link to="/website-list/website/WebsiteFilling">
            網站填寫
          </router-link>
        </a>
        </div>
      </div>
      <div class="dropdown">
        <button class="dropbtn">§工作媒合</button>
        <div class="dropdown-content">
          <a>
            <router-link to="/job-matching/JobVacancies">
              職缺填寫
            </router-link>
          </a>
          <a>
            <router-link to="/job-matching/ProjectFilling">
              專案填寫
            </router-link>
          </a>
          <a>
            <router-link to="/personal-skill/SkillFilling">
              專長填寫
            </router-link>
          </a>
          <a>
            <router-link to="/job-query/JobQuery">
              工作查詢
            </router-link>
          </a>
          <a>
            <router-link to="/job-query/FindMan">
              人才查詢
            </router-link>
          </a>
        </div>
      </div>
      <div class="dropdown">
        <button class="dropbtn"><router-link to="/Logout">§登出</router-link></button>
      </div>
      
      <router-view></router-view>
  </div>
</template>

<script>
import Vue from 'vue';
export default {
  components: {
  }
}
</script>
<style scoped>
    
    .dropbtn {
      background-color: #CDEE82;
      padding: 16px;
      font-size: 16px;
      color:#F17CAF;
      border: none;
      cursor: pointer;
    }

    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
    }

    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown-content a:hover {background-color: #f1f1f1}

    .dropdown:hover .dropdown-content {
      display: block;
    }

    .dropdown:hover .dropbtn {
      background-color: #3e8e41;
    }
</style>
