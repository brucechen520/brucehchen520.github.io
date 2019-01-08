<template>
  <div>
      <ul>
            <li v-for="card in cards">
                <a :href="card.href">{{ card.title  }}</a>
            </li>
      </ul>
  </div>
</template>

<script>
    export default {
        data () {
          return {
            cards: [
                {  'title':'公開名片區', 'href': 'https://goo.gl/HHXPvG' },
                {  'title':'公開名片區上傳', 'href': 'https://140.134.29.2:5001/sharing/wNhbCOzDw?fbclid=IwAR3QHKYUJCFoNFvBxHGvV0R72KkAqD5-r6EOudaWayZHNW7Il5Li_wxVg_8' },
                {  'title':'不公開名片區', 'href': '#' },
                {  'title':'不公開名片區上傳', 'href': '#' },
            ]
          }
        }
    }
</script>
