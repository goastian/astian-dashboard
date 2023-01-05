<template>
	<div class="main---div">
		<div v-if="!entries.length">
			<ul class="o-vertical-spacing o-vertical-spacing--l">
				<li class="uiskeleton-post o-media">
					<div class="o-media__body">
						<div class="o-vertical-spacing">
							<h3 class="uiskeleton-post__headline">
								<span class="skeleton-box skeleton-headline__name" />
							</h3>
							<div class="uiskeleton-post__meta align__end">
								<span class="skeleton-box width-2_8" />
							</div>
							<div class="o-media__figure">
								<span class="skeleton-box skeleton-img" />
								<span class="skeleton-box skeleton-img" />
								<span class="skeleton-box skeleton-img" />
								<span class="skeleton-box skeleton-img" />
								<span class="skeleton-box skeleton-img" />
								<span class="skeleton-box skeleton-img" />
							</div>
						</div>
					</div>
				</li>
			</ul>
		</div>
		<div v-if="entries.length" class="new-icons">
			<div class="welcome__label">
				<h2>{{ WelcomeBack }} {{ userInfo.ownerDisplayName }}</h2>
			</div>
			<div @click="isHidden = !isHidden">
				<span v-if="!isHidden" class="toggle_apps show-all">{{
					showAllApps
				}}</span>
				<span v-if="isHidden" class="toggle_apps show-less">{{
					showLessApps
				}}</span>
			</div>
			<div class="app-container">
				<a v-for="entry in entries"
					:key="entry.message"
					class="item"
					v-bind:class="{ 'beta-app': entry.is_beta }"
					:href="entry.href"
					:target="entry.target"
					@click="handleOfficeClick(entry, $event)">
					<div class="color-icons" :class="entry.id" :style="entry.style" />
					<div class="item-label">{{ entry.name }}</div>
				</a>
			</div>
			<div v-if="isHidden" class="app-container">
				<a v-for="entry in external"
					:key="entry.message"
					class="item"
					v-bind:class="{ 'beta-app': entry.is_beta }"
					:href="entry.href"
					:target="entry.target"
					@click="handleOfficeClick(entry, $event)">
					<div class="color-icons" :class="entry.id" :style="entry.style" />
					<div class="item-label">{{ entry.name }}</div>
				</a>
			</div>
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
				.get(generateUrl('/apps/files/ajax/getstoragestats'))
				.then((response) => {
					this.userInfo = response.data.data
				})
		},
		handleOfficeClick(entry, e) {
			if (entry.type === 'onlyoffice') {
				e.preventDefault()
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
									window.open('/apps/onlyoffice/' + response.data.id, '_self')
								} else if (response.data.error && response.data.error.length) {
									showError(response.data.error)
								}
							}).catch(function() {
								showError(entry.t('murena_launcher', 'Error when trying to connect to ONLYOFFICE'))
							})
					}
				}).catch(function(error) {
					if (error.response && error.response.data) {
						const errorMessage = error.response.data.error
						showError(errorMessage)
					}
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
.skeleton-box {
  display: inline-block;
  height: 1em;
  position: relative;
  overflow: hidden;
  background-color: #DDDBDD;
  border-radius: 5px;
}
.skeleton-box::after {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  transform: translateX(-100%);
  background-image: linear-gradient(90deg, rgba(255, 255, 255, 0) 0, rgba(255, 255, 255, 0.2) 20%, rgba(255, 255, 255, 0.5) 60%, rgba(255, 255, 255, 0));
  -webkit-animation: shimmer 3s infinite;
          animation: shimmer 3s infinite;
  content: "";
}
@-webkit-keyframes shimmer {
  100% {
    transform: translateX(100%);
  }
}
@keyframes shimmer {
  100% {
    transform: translateX(100%);
  }
}

.uiskeleton-post__headline {
  font-size: 1.25em;
  font-weight: bold;
}
.uiskeleton-post__meta {
  font-size: 0.85em;
  color: #6b6b6b;
}
.o-media {
  display: flex;
}
.o-media__body {
  flex-grow: 1;
}
.o-vertical-spacing > * + * {
  margin-top: 3em;
}
.o-vertical-spacing--l > * + * {
  margin-top: 2em;
}
.o-media__figure span {
  margin-left: 1em;
  margin-right: 1em;
}
.align__end{
  text-align: end;
}
.skeleton-img
{
  width: 12%;
  height: 5em;
}
.width-2_8
{
  width:2.8em;
}
.skeleton-headline__name{
  width:30%;
  height: 1.2em;
}
a.item.beta-app {
    position: relative;
}
.beta-app:after {
	content: "BETA";
    position: absolute;
    top: 15%;
    background-color: #007fff;
    color: white;
    font-size: 12px;
    border-radius: 10px;
    line-height: normal;
    padding: 2px 10px;
    font-weight: 800;
}
</style>
