import Vue from 'vue'
import Router from 'vue-router'
import Home from '../components/others/Home'
import Logout from '../components/others/Logout'
import OBUpload from '../components/business-card/OBUpload'
import OpenBusinessCard from '../components/business-card/OpenBusinessCard'
import CBUpload from '../components/business-card/CBUpload'
import CloseBusinessCard from '../components/business-card/CloseBusinessCard'
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
            path: '/website-list/business-card/OBUpload',
            name: 'OBUpload',
            component: OBUpload
        },
        {
            path: '/website-list/business-card/OpenBusinessCard',
            name: 'OpenBusinessCard',
            component: OpenBusinessCard
        },
        {
            path: '/website-list/business-card/CBUpload',
            name: 'CBUpload',
            component: CBUpload
        },
        {
            path: '/website-list/business-card/CloseBusinessCard',
            name: 'CloseBusinessCard',
            component: CloseBusinessCard
        },
        {
            path: '/website-list/website/WebsiteFilling',
            name: 'WebsiteFilling',
            component: WebsiteFilling
        },
        {
            path: '/website-list/website/WebsiteQuery',
            name: 'WebsiteQuery',
            component: WebsiteQuery
        },
        {
            path: '/job-matching/JobVacancies',
            name: 'JobVacancies',
            component: JobVacancies
        },
        {
            path: '/job-matching/ProjectFilling',
            name: 'ProjectFilling',
            component: ProjectFilling
        },
        {
            path: '/personal-skill/SkillFilling',
            name: 'SkillFilling',
            component: SkillFilling
        },
        {
            path: '/job-query/JobQuery',
            name: 'JobQuery',
            component: JobQuery
        },
        {
            path: '/job-query/FindMan',
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