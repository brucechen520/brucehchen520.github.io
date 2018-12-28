<template>
  <div id="app">
      <dropdown trigger="hover">
        <button class=""><router-link to="/Home">§回會員系統</router-link></button>
      </dropdown>
      <dropdown trigger="hover">
        <button class="">§網站列表</button>
        <div slot="content">
            <menus>
              <menu-item >
                <router-link to="/website-list/business-card/OpenBusinessCard">
                  公開名片區
                </router-link>
              </menu-item>
              <menu-item >
                <router-link to="/website-list/business-card/CloseBusinessCard">
                  不公開名片區
                </router-link>
              </menu-item>
              <menu-item >
                <router-link to="/website-list/business-card/OBUpload">
                  公開名片區上傳
                </router-link>
              </menu-item>
              <menu-item >
                <router-link to="/website-list/business-card/CBUpload">
                  不公開名片區上傳
                </router-link>
              </menu-item>
              <menu-item >
                <router-link to="/website-list/website/WebsiteQuery">
                  網站查詢
                </router-link>
              </menu-item>
              <menu-item >
                <router-link to="/website-list/website/WebsiteFilling">
                  網站填寫
                </router-link>
              </menu-item>
            </menus>
        </div>
      </dropdown>
      <dropdown trigger="hover">
        <button class="">§工作媒合</button>
        <div slot="content">
            <menus>
              <menu-item >
                <router-link to="/job-matching/JobVacancies">
                  職缺填寫
                </router-link>
              </menu-item>
              <menu-item >
                <router-link to="/job-matching/ProjectFilling">
                  專案填寫
                </router-link>
              </menu-item>
              <menu-item >
                <router-link to="/personal-skill/SkillFilling">
                  專長填寫
                </router-link>
              </menu-item>
              <menu-item >
                <router-link to="/job-query/JobQuery">
                  工作查詢
                </router-link>
              </menu-item>
              <menu-item >
                <router-link to="/job-query/FindMan">
                  人才查詢
                </router-link>
              </menu-item>
            </menus>
        </div>
      </dropdown>
      <dropdown trigger="hover">
        <button class=""><router-link to="/Logout">§登出</router-link></button>
        <div slot="content">
        </div>
      </dropdown>
      <router-view></router-view>
  </div>
</template>

<script>
import Vue from 'vue';
import VueBlu from 'vue-blu'
Vue.use(VueBlu)
export default {
  components: {
  }
}
</script>