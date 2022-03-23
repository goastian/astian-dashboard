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
  /* -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  width: 70%;
  position: absolute;
  left: 50%;
  top: 50%;
  -webkit-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%); */
  width: 70%;
  transform: translate(20%, 10%);

}
.welcome-label{
  color: #333333;
  font-size: 16px;
  font-weight: 600;
}
</style>
