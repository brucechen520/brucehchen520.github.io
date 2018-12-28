<template>
  <div class="hello-world">
    {{ msg }}
  </div>
</template>

<script>
export default {
  name: 'logout',
  data () {
    return {
      msg: 'Logout'
    }
  }
}
</script>

<style>
    .hello-world {
      color:red;
    }
</style>