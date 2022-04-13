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

<style>
.app-ecloud-dashboard {
    background-color: white;
}
#edashboard-app {
    width: 70%;
    margin: 10% auto;
    font-family: 'Roboto';
}
.welcome-label{
  color: #333333;
  font-size: 16px;
  font-weight: 600;
}
</style>
