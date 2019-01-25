<template>
  <div>
      {{ customers }}
      <div @click="postData">click</div>
  </div>
</template>

<script>
    export default {
        data () {
          return {
            customers:{"name":"rr"}
          }
        },
        methods: {
          postData () {
            let _this = this;
            _this.axios.post('/nan_test/123.php', { typ: "test" })
              .then(function (response) {
                console.log(response);
                _this.customers = response.data;
              })
              .catch(function (error) {
                  //error
                  console.log(error.message);
              });
            }
        }
    }
</script>

<style>

</style>