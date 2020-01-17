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
        console.log('123');   
        this.$http.post(url, params)
             .then(response => {
                if(handleSuccess){
                    console.log(response);
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
    vacancy_conform: function (param,handleSuccess, handleComplete, handleError){
        this.$http.post(this.API_HOST + '/ee/api/api_vacancy_comfirm.php',param, handleSuccess, handleComplete, handleError);
    }
}