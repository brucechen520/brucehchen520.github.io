import Vue from 'vue'
import Router from 'vue-router'
import Home from '../components/others/Home'
import Logout from '../components/others/Logout'
import BusinessCard from '../components/business-card/BusinessCard'
import WebsiteFilling from '../components/website/WebsiteFilling'
import WebsiteQuery from '../components/website/WebsiteQuery'
import JobVacancies from '../components/job-matching/JobVacancies'
import ProjectFilling from '../components/job-matching/ProjectFilling'
import SkillFilling from '../components/personal-skill/SkillFilling'
import JobQuery from '../components/job-query/JobQuery'
import FindMan from '../components/job-query/FindMan'
Vue.use(Router)
const router = new Router({
    // use html5
    mode: 'history',
    base: __dirname,
    // route table
    routes: [
        {
            path: '/Home',
            name: 'Home',
            component: Home
        },
        {
            path: '/BusinessCard',
            name: 'BusinessCard',
            component: BusinessCard
        },
        {
            path: '/WebsiteFilling',
            name: 'WebsiteFilling',
            component: WebsiteFilling
        },
        {
            path: '/WebsiteQuery',
            name: 'WebsiteQuery',
            component: WebsiteQuery
        },
        {
            path: '/JobVacancies',
            name: 'JobVacancies',
            component: JobVacancies
        },
        {
            path: '/ProjectFilling',
            name: 'ProjectFilling',
            component: ProjectFilling
        },
        {
            path: '/SkillFilling',
            name: 'SkillFilling',
            component: SkillFilling
        },
        {
            path: '/JobQuery',
            name: 'JobQuery',
            component: JobQuery
        },
        {
            path: '/FindMan',
            name: 'FindMan',
            component: FindMan
        },
        {
            path: '/Logout',
            name: 'Logout',
            component: Logout
        }
      ]
})
export default router; // 一定要加