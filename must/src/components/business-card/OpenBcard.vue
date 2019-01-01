<template>
  <div>
      {{ msg }}
      <iframe name="content" width="1920" height="1080" style="border:none" src="https://goo.gl/HHXPvG"></iframe>
  </div>
</template>

<script>
    export default {
        data () {
          return {
            msg: '公開名片區' // https://goo.gl/HHXPvG
          }
        }
    }
</script>
