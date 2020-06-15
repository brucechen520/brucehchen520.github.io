import Vue from 'vue'
import Router from 'vue-router'
import WebsiteFilling from '../components/website/WebsiteFilling'
import WebsiteQuery from '../components/website/WebsiteQuery'
import JobVacancies from '../components/job-matching/JobVacancies'
import ProjectFilling from '../components/job-matching/ProjectFilling'
import personalSkill from '../components/personal/SkillFilling'
import JobQuery from '../components/job-query/JobQuery'
import FindMan from '../components/job-query/FindMan'

import products from '../components/website/products'

import manage from '../components/manage/manage'
import manageReview from '../components/manage/review'
import manageLog from '../components/manage/log'

import parsonal from '../components/personal/personal'
import personalVacancy from '../components/personal/vacancy'
import personalProject from '../components/personal/project'
import personalWeb from '../components/personal/website'
import personalProduct from '../components/personal/product'
import personalNameCard from '../components/personal/nameCard'

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
            path: '/products',
            name: 'products',
            component: products
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
            component: personalWeb
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
            component: manageReview
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
                component: personalVacancy
            },{
                path: 'project',
                name: 'personalProject',
                component: personalProject
            },{
                path: 'web',
                name: 'personalWeb',
                component: personalWeb
            },{
                path: 'product',
                name: 'personalProduct',
                component: personalProduct
            },{
                path: 'namecard',
                name: 'personalNameCard',
                component: personalNameCard
            }]
        },
        {
            path: '/manage',
            name: 'manage',
            component: manage,
            children: [{
                path: 'review',
                name: 'manageReview',
                component: manageReview
            },{                
                path: 'log',
                name: 'manageLog',
                component: manageLog
            }]
        },
      ]
})
export default router; // 一定要加