<template>
  <div class="about container">
    <h1 class="page-header">About</h1>
    <p>Client manager sample app built Starter | Vue.js framework</p>
    <p>Version {{ version }}</p>
  </div>
</template>

<script>
export default {
  name: 'about',
  data () {
    return {
        version: window.app_version
    }
  }
}
</script>
