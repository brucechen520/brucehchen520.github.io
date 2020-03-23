import axios from 'axios'
export const api2 = {
    $http: axios,
    API_HOST: 'http://140.134.29.2',
    init: function(){
        this.$http.defaults.headers = { 'Content-Type': 'application/json'}
        // if(window.$cookies.get("auth") && window.$cookies.get("auth").user && window.$cookies.get("auth").user.token){
        //     var token = window.$cookies.get("auth").user.token;
        //     this.$http.defaults.headers.token = token;
        // }
    },
    commonComplete : function(){
        
    },
    post: function (url, params, handleSuccess, handleComplete, handleError, loading) {
        //console.log("[POST] " + url);
        //console.log("   - params : "+ JSON.stringify(params));
        var self = this;
        self.init();   
        this.$http.post(url, params)
             .then(response => {
                if(handleSuccess){
                    //console.log(response);
                    handleSuccess(response.data);
                }else{
                    self.commonSuccess(response.data);
                }
              })
              .catch(error => {
                console.error(error);  
                if (handleError) {
                    handleError(error);
                } else {
                    //self.commonError(error, url);
                }
             })
             .then(function () {
                 // always executed
                 if(handleComplete){
                     handleComplete();
                 }else{
                     self.commonComplete();
                 }
          });
    },
    get: function (url, params, handleSuccess, handleComplete, handleError, loading) {
        params.v = new Date().getTime();
        //console.log("[GET] " + url);
        //console.log("   - params : "+ JSON.stringify(params));
        
        var self = this;
        self.init();
        if(loading == undefined || loading){
            self.showLoading();
        }
        this.$http.get(url, {params: params})
                .then(response => {
                self.checkLogin(response);
                if(handleSuccess){
                    handleSuccess(response.data);
                }else{
                    self.commonSuccess(response.data);
                }
              })
              .catch(error => {
                console.error(error);
                self.hideLoading();
                self.handle403Error(error);
                if (handleError) {
                    handleError(error);
                } else {
                    self.commonError(error, url);
                }
             })
             .then(function () {
                 if(loading == undefined || loading){
                    self.hideLoading();
                 }
                 // always executed
                 if(handleComplete){
                     handleComplete();
                 }else{
//                     self.$f7.preloader.hide();
                     self.commonComplete();
                 }
          });
    },
    vacance_get: function (param,handleSuccess, handleComplete, handleError){
        this.post(this.API_HOST + '/ee/api/api_vacancy_get.php',param, handleSuccess, handleComplete, handleError);
    },
    vacancy_insert: function (param,handleSuccess, handleComplete, handleError){
        this.post(this.API_HOST + '/ee/api/api_vacancy_insert.php',param, handleSuccess, handleComplete, handleError);
    },
    vacancy_update: function (param,handleSuccess, handleComplete, handleError){
        this.post(this.API_HOST + '/ee/api/api_vacancy_update.php',param, handleSuccess, handleComplete, handleError);
    },
    vacancy_delete: function (param,handleSuccess, handleComplete, handleError){
        this.post(this.API_HOST + '/ee/api/api_vacancy_delete.php',param, handleSuccess, handleComplete, handleError);
    },
    vacancy_comfirm: function (param,handleSuccess, handleComplete, handleError){
        this.post(this.API_HOST + '/ee/api/api_vacancy_comfirm.php',param, handleSuccess, handleComplete, handleError);
    },
    project_get: function (param,handleSuccess, handleComplete, handleError){
        this.post(this.API_HOST + '/ee/api/api_project_get.php',param, handleSuccess, handleComplete, handleError);
    },
    project_comfirm: function (param,handleSuccess, handleComplete, handleError){
        this.post(this.API_HOST + '/ee/api/api_project_comfirm.php',param, handleSuccess, handleComplete, handleError);
    },
    web_get: function (param,handleSuccess, handleComplete, handleError){
        this.post(this.API_HOST + '/ee/api/api_web_get.php',param, handleSuccess, handleComplete, handleError);
    },
    web_insert: function (param,handleSuccess, handleComplete, handleError){
        this.post(this.API_HOST + '/ee/api/api_web_insert.php',param, handleSuccess, handleComplete, handleError);
    },
    web_comfirm: function (param,handleSuccess, handleComplete, handleError){
        this.post(this.API_HOST + '/ee/api/api_web_comfirm.php',param, handleSuccess, handleComplete, handleError);
    },
    resume_insert: function (param,handleSuccess, handleComplete, handleError){
        this.post(this.API_HOST + '/ee/api/api_resume_insert.php',param, handleSuccess, handleComplete, handleError);
    },
    resume_update: function (param,handleSuccess, handleComplete, handleError){
        this.post(this.API_HOST + '/ee/api/api_resume_update.php',param, handleSuccess, handleComplete, handleError);
    },
    resume_get: function (param,handleSuccess, handleComplete, handleError){
        this.post(this.API_HOST + '/ee/api/api_resume_get.php',param, handleSuccess, handleComplete, handleError);
    },
    
}