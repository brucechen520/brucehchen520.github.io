var app = new Vue({
    el: '#app',
    data: {
      message: 'Hello Vue!'
    }
  })
var test = new Vue({
  el: '#test',
  data: {
    show: true
  },
  methods: { //方法 裡面可以放FUNCTION 但無論相依資料有無更改都會計算一次
    handleclose: function() {
      this.show = false;
    }
  }
})
var app2 = new Vue({
    el: '#app-2',
    data: {
        message: 'You loaded this page on ' + new Date().toLocaleString()
    }
})
var app3 = new Vue({
    el: '#app-3',
    data: {
        seen: true
    }
})
var app4 = new Vue({
    el: '#app-4',
    data: {
      todos: [
        { text: 'Learn JavaScript' },
        { text: 'Learn Vue' },
        { text: 'Build something awesome' }
      ]
    }
  })
var app5 = new Vue({
    el: '#app-5',
    data: {
        message: 'Hello Vue.js!'
    },
    methods: {
        reverseMessage: function () {
        this.message = this.message.split('').reverse().join('')
        }
    }
})
var app6 = new Vue({
    el: '#app-6',
    data: {
      message: 'Hello Vue!'
    }
})
Vue.component('todo-item', {
    props: ['todo'],
    template: '<li>{{ todo.text }}</li>'
  })
  
var app7 = new Vue({
    el: '#app-7',
    data: {
      groceryList: [
        { id: 0, text: 'Vegetables' },
        { id: 1, text: 'Cheese' },
        { id: 2, text: 'Whatever else humans are supposed to eat' }
      ]
    }
})
Vue.component('my-component', { //必須放在new Vue前面
  render: function (createElement) {
    return createElement(
      'div', {},
      [
        createElement('p', 'Hello World 2!'),
      ]
    )
  }
});
var ttt1 = new Vue({
  el: '#test2',
  delimiters: ['${', '}'], //避免{{}} 有些語言無法辨識
  data: {
    message: 'Hello Vue!'
  }
})
var priceCal = new Vue({ //計算總金額
  el: '#test3',
  delimiters: ['${', '}'],
  data: {
    package1: [
      {
        name: 'iPhone 7',
        price: 7199,
        count: 2
      },
      {
        name: 'iPad',
        price: 2888,
        count: 1
      }
    ],
    package2: [
      {
        name: 'apple',
        price: 3,
        count: 5
      },
      {
        name: 'banana',
        price: 2,
        count: 10
      }
    ]
  },
  computed: { //計算 裡面也可放function 但只有相依資料有更動時才會計算，較有效率的用法
    prices: function() {
      var prices = 0;
      for (var i = 0; i < this.package1.length; i++) {
        prices += this.package1[i].price * this.package1[i].count;
      }
      for (var i = 0; i < this.package2.length; i++) {
        prices += this.package2[i].price * this.package2[i].count;
      }
      return prices;
    }
  },
  methods: { //方法 裡面可以放FUNCTION 但無論相依資料有無更改都會計算一次
    getprices: function() {
      var prices1 = 0;
      for (var i = 0; i < this.package1.length; i++) {
        prices1 += this.package1[i].price * this.package1[i].count;
      }
      for (var i = 0; i < this.package2.length; i++) {
        prices1 += this.package2[i].price * this.package2[i].count;
      }
      return prices1;
    }
  }
})

var fName = new Vue({
  el: '#fullname',
  delimiters: ['${', '}'],
  data: {
    firstName: 'Twelve',
    lastName: "Chen"
  },
  computed: {
    fullName: {
      // getter, for read
      get: function () {
        return this.firstName + ' ' + this.lastName;
      },
      // setter, trigger by writting
      set: function (newValue) {
        var names = newValue.split(' ');
        this.firstName = names[0];
        this.lastName = names[names.length - 1];
      }
    }
  }
})
var tree1 = new Vue({
  el: '#tree1',
  delimiters: ['${', '}'],
  data: {
    text: '123,456'
  }
})
var tree2 = new Vue({
  el: '#tree2',
  delimiters: ['${', '}'],
  computed: {
    reversedText: function () {
      // this rely on instance tree1's data text
      return tree1.text.split(','),reverse().join(',');
    }
  }
})