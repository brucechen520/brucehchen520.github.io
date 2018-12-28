<template>
  <div class="hello-world">
    {{ msg }}
  </div>
</template>

<script>
export default {
  name: 'home',
  data () {
    return {
      msg: 'HOME'
    }
  }
}
</script>

<style>
    .hello-world {
      color:red;
    }
</style>