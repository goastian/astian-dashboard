<template> 
  <AllApps msg="Here Apps will be shown"/>
  <StorageLayout msg="Storage line here"/>
</template>

<script>
import AllApps from './components/AllApps.vue'
import StorageLayout from './components/StorageLayout.vue'

export default {
  name: 'App',
  components: {
    AllApps, 
    StorageLayout
  }
}
</script>

<style>
#app {
  font-family: system-ui;
  -moz-osx-font-smoothing: grayscale;
  /* text-align: center; */
  color: #2c3e50;
  width: 75%;
  position: absolute;
  left: 50%;
  top: 50%;
  -webkit-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}
</style>
