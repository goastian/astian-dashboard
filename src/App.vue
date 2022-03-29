<template> 
  <AllApps />
  <StorageLayout />
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
    width: 70%;
    margin: 10% auto;
}
.welcome-label{
  color: #333333;
  font-size: 16px;
  font-weight: 600;
}
</style>
