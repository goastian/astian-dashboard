<template>
	<div id="dashboard-app">
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
	z-index: 1000;
	background-color: var(--color-main-background) !important;
	position: relative;
	flex-basis: 100vw;
	min-height: 100%;
}

.app-ecloud-dashboard #dashboard-app .new-icons .welcome__label h2,
.app-ecloud-dashboard #dashboard-app .new-icons .app-container .item .item-label,
.app-ecloud-dashboard #dashboard-app .storage-main-div .storage,
.app-ecloud-dashboard #dashboard-app .storage-main-div .upgrade__main_div .usage-info,
.app-ecloud-dashboard #dashboard-app #storage-redeem .instructions__label,
.app-ecloud-dashboard #dashboard-app #storage-redeem .instructions__sublabel {
	color: var(--color-main-text);
}

#dashboard-app {
  width: 920px;
  margin: 7% auto;
  font-family: 'Roboto';
}

@media only screen and (max-width: 920px) {
  #dashboard-app {
    width: 70%;
  }
}

@media only screen and (max-width: 600px) {
  #dashboard-app {
    width: 90%;
  }
}
/* Medium devices (landscape tablets, 920px and up) */

@media only screen and (min-width: 920px) {
  #dashboard-app {
    width: 920px;
  }
}
</style>
