import Vue from 'vue'
import Router from 'vue-router'
import WebsiteFilling from '../components/website/WebsiteFilling'
import WebsiteQuery from '../components/website/WebsiteQuery'
import JobVacancies from '../components/job-matching/JobVacancies'
import ProjectFilling from '../components/job-matching/ProjectFilling'
import personalSkill from '../components/personal/SkillFilling'
import PersonalWeb from '../components/personal/Website'
import JobQuery from '../components/job-query/JobQuery'
import FindMan from '../components/job-query/FindMan'
import ReviewQuery from '../components/job-matching/ReviewQuery'
import parsonal from '../components/personalManage/personal'
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
            component: personalSkill
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
            path: '/personal',
            name: 'personal',
            component: parsonal,
            children: [{
                path: 'skill',
                name: 'personalSkill',
                component: personalSkill
            },{                
                path: 'vacancy',
                name: 'personalVacancy',
                component: JobVacancies
            },{
                path: 'project',
                name: 'personalProject',
                component: ProjectFilling
            },{
                path: 'web',
                name: 'personalWeb',
                component: PersonalWeb
            }]
        }
      ]
})
export default router; // 一定要加