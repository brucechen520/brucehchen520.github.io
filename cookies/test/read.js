var fs = require('fs');

function getfile() {
    return new Promise((resolve, reject) => {
        fs.readFile('./json.txt', (err, data) => {
            err? reject(err) : resolve(data);
        })
    });
}
function toJson(data) {
    return JSON.parse(data.toString());
}
function tostring(data){
    return JSON.stringify(data);
}
function modify(data) {
    data.name = '耀徵';
    return data;
}
function setfile(data) {
    return new Promise((resolve, reject) => {
        fs.writeFile('./json.txt', data, (err) => {
            err? reject(err) : resolve("finished");
        })
    });
}
var a = getfile();
a
    .then(value=>value)
    .then(toJson)
    .then(modify)
    .then(tostring)
    .then(setfile)
    .then(value=>console.log(value))
    .catch(reason=>console.log(reason))