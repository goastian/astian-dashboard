<template>
	<div class="new-icons">
		<div class="welcome__label">
			<h2>{{ WelcomeBack }} {{ userInfo.ownerDisplayName }}</h2>
		</div>
		<div @click="isHidden = !isHidden">
			<span v-if="!isHidden" class="toggle_apps show-all">{{ showAllApps }}</span>
			<span v-if="isHidden" class="toggle_apps show-less">{{ showLessApps }}</span>
		</div>
		<div class="app-container">
			<a v-for="entry in entries"
				:key="entry.message"
				class="item"
				:href="entry.href">
				<div class="color-icons" :class="entry.id" />
				<div class="item-label"> {{ entry.name }}</div>
			</a>
		</div>
		<div v-if="isHidden" class="app-container">
			<a v-for="entry in external"
				:key="entry.message"
				class="item"
				:href="entry.href">
				<div class="color-icons" :class="entry.id" />
				<div class="item-label"> {{ entry.name }}</div>
			</a>
		</div>
	</div>
</template>

<script>

import axios from '@nextcloud/axios'
import { generateUrl } from '@nextcloud/router'

export default {
  name: 'AllApps',
  data() {
    return {
      isHidden: false,
      entries: [],
      external: [],
      userInfo: [],
      showAllApps: OC.L10N.translate('ecloud-dashboard', 'Show All Apps'),
      showLessApps: OC.L10N.translate('ecloud-dashboard', 'Show Less Apps'),
      WelcomeBack: OC.L10N.translate('ecloud-dashboard', 'Welcome back'),
    }
  },
mounted() {
    this.getEntries()
    this.getDetails()
  },
  methods: {
    getEntries() {
      axios
        .get(generateUrl('/apps/ecloud-dashboard/get-apps'))
        .then(response => {
          this.entries = response.data.apps
          this.entries = this.entries.map(entry => {
            entry.active = window.location.pathname.includes(
              entry.href
            )
            return entry
          })
          this.external = this.entries.slice(6)
          this.entries = this.entries.slice(0, 6)
        })
    },
    getDetails() {
      axios
        .get(generateUrl('/apps/files/ajax/getstoragestats.php'))
        .then(response => {
          this.userInfo = response.data.data
        })
    },
  },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.welcome__label{
  margin-left: 0;
  letter-spacing: 1px;
}
.toggle_apps{
  font-family: 'Roboto';
  float: right;
  font-weight: 600;
  letter-spacing: 1px;
  font-size: 12px;
  color: #0086FF;
  background-repeat: no-repeat;
  background-position: right;
  padding-right: 20px;
  margin-right: 0px;
  margin-bottom: 20px;
  background-size: 10px;
  cursor: pointer;
  text-transform: uppercase;
}
.show-all{
  background-image: url('../assets/down.png');
}
.show-less{
  background-image: url('../assets/up.png');
}
.item-label{
  font-size: 14px;
  padding-top: 10px;
  font-weight: 500;
}
.item-sublabel{
  font-size: 10px;
  color: #949DA1;
}
.app-container {
  display: table;
  table-layout: fixed;
  width: 100%;
  box-sizing: border-box;
}
.item {
  vertical-align: middle;
  text-align: center;
  width: 16.6666667%;
  float: left;
  margin-top: 10px;
  margin-bottom: 10px;
}
@media only screen and (max-width: 768px) {
	.item {
		width: 33%;
	}
}
/* Medium devices (landscape tablets, 768px and up) */
@media only screen and (min-width: 768px) {
	.item {
		margin: auto;
	}
}
</style>
