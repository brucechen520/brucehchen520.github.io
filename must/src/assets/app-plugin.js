export default{
    install(Vue,options){
        Vue.mixin({
            methods:{
                alertModal(option){
                    this.$root.$emit('modalAlert', option);
                    if(typeof option !== "object"){
                        this.$root.$emit('modalAlert', {content:option});
                        //window.alertCallbackFn = false;
                    }else{
                        this.$root.$emit('modalAlert', option);
                        // if(option && option.callback){
                        //         window.alertCallbackFn = option.callback;
                        // }else{
                        //         window.alertCallbackFn = false;
                        // }      
                    }
                },    
            }
        });
    }
}