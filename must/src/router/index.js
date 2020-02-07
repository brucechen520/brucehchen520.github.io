import Vue from 'vue'
import Router from 'vue-router'
import WebsiteFilling from '../components/website/WebsiteFilling'
import WebsiteQuery from '../components/website/WebsiteQuery'
import JobVacancies from '../components/job-matching/JobVacancies'
import ProjectFilling from '../components/job-matching/ProjectFilling'
import SkillFilling from '../components/personal/SkillFilling'
import PersonalWeb from '../components/personal/Website'
import JobQuery from '../components/job-query/JobQuery'
import FindMan from '../components/job-query/FindMan'
import ReviewQuery from '../components/job-matching/ReviewQuery'
import myJob from '../components/personalManage/myJob'
import projectPersonal from '../components/personalManage/projectPersonal'
import reviewPersonal from '../components/personalManage/reviewPersonal'
import vacancyPersonal from '../components/personalManage/vacancyPersonal'
import websitePersonal from '../components/personalManage/websitePersonal'
Vue.use(Router)
const router = new Router({
    // route table
    routes: [
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
            alias: 'JobVacancies',
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
            path: '/PersonalWeb',
            name: 'PersonalWeb',
            component: PersonalWeb
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
            path: '/ReviewQuery',
            name: 'ReviewQuery',
            component: ReviewQuery
        },
        {
            path: '/myJob',
            name: 'myJob',
            component: myJob,
            children: [{
                path: '/myJob/perosnalProject',
                component: projectPersonal
            },{
                path: '/myJob/perosnalReview',
                component: reviewPersonal
            },{
                path: '/myJob/perosnalVacancy',
                component: vacancyPersonal
            },{
                path: '/myJob/perosnalWebsite',
                component: websitePersonal
            }]
        }
      ]
})
export default router; // 一定要加