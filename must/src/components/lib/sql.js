import * as api from '../lib/api';
export function select (url, type) {
  var _this = this ;
  api.getData(url, {
      params: {
        methods: 'select',
        examined: type,
      }
    })
     .then(function (data) {
        // console.log("+++++++++++++++++++");
        // console.log(data);
        return data;
      })
}