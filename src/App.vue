<template> 
  <div class="welcome__label"><b>Welcome back Gael</b></div>
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
.welcome__label{    
  margin-left: 2%;
}
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
