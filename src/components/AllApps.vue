<template>
	<div class="new-icons">
		<div class="welcome__label">
			<h2>{{ WelcomeBack }} {{ userInfo.ownerDisplayName }}</h2>
		</div>
		<div @click="isHidden = !isHidden"  v-if="entries.length">
			<span v-if="!isHidden" class="toggle_apps show-all">{{
				showAllApps
			}}</span>
			<span v-if="isHidden" class="toggle_apps show-less">{{
				showLessApps
			}}</span>
		</div>
		<div v-if="!entries.length">
			Loading...
		</div>
		<div class="app-container" v-if="entries.length">
			<a
				v-for="entry in entries"
				:key="entry.message"
				class="item"
				:href="entry.href"
				@click="handleOfficeClick(entry, $event)">
				<div class="color-icons" :class="entry.id" :style="entry.style" />
				<div class="item-label">{{ entry.name }}</div>
			</a>
		</div>
		<div v-if="isHidden" class="app-container">
			<a
				v-for="entry in external"
				:key="entry.message"
				class="item"
				:href="entry.href"
				@click="handleOfficeClick(entry, $event)">
				<div class="color-icons" :class="entry.id" :style="entry.style" />
				<div class="item-label">{{ entry.name }}</div>
			</a>
		</div>
	</div>
</template>
<script>
import axios from '@nextcloud/axios'
import { generateUrl } from '@nextcloud/router'
import { showError } from '@nextcloud/dialogs'

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
				.then((response) => {
					this.entries = response.data.apps
					this.entries = this.entries.map((entry) => {
						entry.active = window.location.pathname.includes(entry.href)
						return entry
					})
					this.external = this.entries.slice(6)
					this.entries = this.entries.slice(0, 6)
				})
		},
		getDetails() {
			axios
				.get(generateUrl('/apps/files/ajax/getstoragestats.php'))
				.then((response) => {
					this.userInfo = response.data.data
				})
		},
		handleOfficeClick(entry, e) {
			if (entry.type === 'onlyoffice') {
				e.preventDefault()
				const newWindow = window.open('about:blank', '_blank')
				axios.get('/apps/murena_launcher/getDocumentsFolder').then(function(response) {
					const dir = response.data.dir
					if (dir && dir.length) {
						let docName = 'untitled'
						if (entry.id === 'onlyoffice_docx') {
							docName += '.docx'
						}
						if (entry.id === 'onlyoffice_pptx') {
							docName += '.pptx'
						}
						if (entry.id === 'onlyoffice_xlsx') {
							docName += '.xlsx'
						}
						axios
							.post(entry.href, {
								name: docName,
								dir,
							})
							.then(function(response) {
								if (response.data.id) {
									newWindow.location.href = '/apps/onlyoffice/' + response.data.id
								} else if (response.data.error && response.data.error.length) {
									showError(response.data.error)
									newWindow.close()
								}
							}).catch(function() {
								showError(entry.t('murena_launcher', 'Error when trying to connect to ONLYOFFICE'))
								newWindow.close()
							})
					}
				}).catch(function(error) {
					if (error.response && error.response.data) {
						const errorMessage = error.response.data.error
						showError(errorMessage)
					}
					newWindow.close()
				})

			}
		},
	},
}
</script>
<style scoped="">
.welcome__label {
  margin-left: 0;
  letter-spacing: 1px;
  line-height: 100%;
}
.welcome__label h2{
  font-family: 'Roboto';
  font-style: normal;
  font-weight: 600;
  font-size: 24px;
  color: #333333;
}
.toggle_apps {
  font-family: 'Roboto';
  float: right;
  font-weight: 600;
  letter-spacing: 1px;
  font-size: 13px;
  color: #0086ff;
  background-repeat: no-repeat;
  background-position: right;
  padding-right: 20px;
  margin-right: 0px;
  margin-bottom: 20px;
  background-size: 10px;
  cursor: pointer;
  text-transform: uppercase;
}
.show-all {
  background-image: url('../assets/down.png');
}
.show-less {
  background-image: url('../assets/up.png');
}
.item-label {
  font-family: 'Roboto';
  font-style: normal;
  font-weight: 400;
  font-size: 16px;
  line-height: 100%;
  padding-top: 10px;
  color: #333333;
  padding-left: 0;
  padding-right: 0;
  margin-right: 0;
  margin-left: 0;
}
.item-sublabel {
  font-size: 10px;
  color: #949da1;
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
  padding: 20px 0;
}
@media only screen and (max-width: 768px) {
  .item {
    width: 33%;
  }
}
@media only screen and (max-width: 600px) {
  .item-label {
    font-size: small;
  }
}
/* Medium devices (landscape tablets, 768px and up) */
@media only screen and (min-width: 768px) {
  .item {
    margin: auto;
  }
}
</style>
