<template>
	<div id="edashboard-app">
		<AllApps />
		<StorageLayout />
	</div>
</template>
<script>
import AllApps from './components/AllApps.vue'
import StorageLayout from './components/StorageLayout.vue'
export default {
	name: 'App',
	components: {
		AllApps,
		StorageLayout,
	},
}
</script>

<script>
import AllApps from './components/AllApps.vue'
import StorageLayout from './components/StorageLayout.vue'
export default {
  name: 'App',
  components: {
    AllApps,
    StorageLayout,
  },
}
</script>

<style>
.app-ecloud-dashboard {
  background-color: white;
}

#edashboard-app {
  width: 920px;
  margin: 10% auto;
  font-family: 'Roboto';
}

@media only screen and (max-width: 920px) {
  #edashboard-app {
    width: 70%;
  }
}

/* Medium devices (landscape tablets, 920px and up) */

@media only screen and (min-width: 920px) {
  #edashboard-app {
    width: 920px;
  }
}
</style>
