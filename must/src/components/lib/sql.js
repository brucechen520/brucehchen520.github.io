import * as api from '../lib/api';
export function select (url, type) {
  var _this = this ;
  console.log(url);
  api.getData(url, {
      params: {
        methods: 'select',
        examined: type,
      }
    })
  	.then(function (data) {
      if(!data.error){
      		console.log(data);
        	return data;
      }                        
      else
        alert(data.error);
  	})
  	.catch(function (error) {
      alert(error);
  	})
}