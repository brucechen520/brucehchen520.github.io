import Vue from 'vue'
import Router from 'vue-router'
import Home from '../components/others/Home'
import Logout from '../components/others/Logout'
import OpenbcardUpload from '../components/business-card/OpenbcardUpload'
import OpenBcard from '../components/business-card/OpenBcard'
import CloseBcard from '../components/business-card/CloseBcard'
import ClosebcardUpload from '../components/business-card/ClosebcardUpload'
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
            path: '/website-list/business-card/OpenBcard',
            name: 'OpenBcard',
            component: OpenBcard
        },
        {
            path: '/website-list/business-card/OpenbcardUpload',
            name: 'OpenbcardUpload',
            component: OpenbcardUpload
        },
        {
            path: '/website-list/business-card/CloseBcard',
            name: 'CloseBcard',
            component: CloseBcard
        },
        {
            path: '/website-list/business-card/ClosebcardUpload',
            name: 'ClosebcardUpload',
            component: ClosebcardUpload
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