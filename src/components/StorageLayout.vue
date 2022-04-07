<template>
	<div class="row margin0">
		<div class="row margin0">
			<div class="row margintop10">
				<b class="storage">{{ storage }}</b>
				<div class="progress">
					<div class="progress-bar"
						:style="{ width: totalSpaceUsedInPercentage + '%' }"
						style="background-color: rgb(204, 228, 255) !important " />
				</div>
				<div class="upgrade__main_div">
					<div class="usage-info">
						{{ usageinfo }}
					</div>
					<div class="upgrade-storage__div">
						<a id="upgrad-btn" :href="storageLink">
							{{ upgradeStorage }}
						</a>
					</div>
				</div>
			</div>
			<div class="row margin0">
				<div class="col-lg-12  instructions">
					<div class="row margin0">
						<div id="storage-redeem" class="storage-space-div width90">
							<div class="instructions__label">
								{{ getCredits }}
							</div>
							<div class="instructions__sublabel">
								{{ openAnAccount }}
							</div>
							<div class="urllink">
								<a :href="redirectURL">{{ inviteYourFriends }}</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>

import axios from '@nextcloud/axios'
import { generateUrl } from '@nextcloud/router'

export default {
	name: 'StorageLayout',
	components: {
	},
	data() {
		return {
			storageInfo: [],
			redirectURL: '',
	  storageLink: '',
			storage: OC.L10N.translate('ecloud-dashboard', 'Storage'),
			upgradeStorage: OC.L10N.translate('ecloud-dashboard', 'Upgrade Storage'),
			getCredits: OC.L10N.translate('ecloud-dashboard', 'getCredits'),
			openAnAccount: OC.L10N.translate('ecloud-dashboard', 'openAnAccount'),
			inviteYourFriends: OC.L10N.translate('ecloud-dashboard', 'Invite Your Friends'),
		}
	},
	computed: {
		totalSpaceUsedInPercentage() {
			const percent = (this.storageInfo.used * 100) / this.storageInfo.quota
			return percent.toFixed(2)
		},
		usageinfo() {
			try {
				const humanUsed = this.storageInfo.used
				const humanQuota = this.storageInfo.quota
				const humanReadableUsed = OC.Util.humanFileSize(humanUsed)
				const humanReadableQuota = OC.Util.humanFileSize(humanQuota)
				let percent = (this.storageInfo.used * 100) / this.storageInfo.quota
				percent = percent.toFixed(2)
				if (this.storageInfo.quota > 0) {
					return humanReadableUsed + ' of ' + humanReadableQuota + ' (' + percent + '%)' + ' used'
				} else {
					return humanReadableUsed + ' used'
				}
			} catch (err) {
				return err.message
			}
		},
	},
	mounted() {
		this.getRedirections()
		this.getDetails()
	},
	methods: {
		getDetails() {
			axios
				.get(generateUrl('/apps/files/ajax/getstoragestats.php'))
				.then(response => {
					this.storageInfo = response.data.data
				})
		},
		getRedirections() {
			axios
				.get('apps/get-redirections')
				.then(response => {
					this.storageLink = response.data.storageLink
					this.redirectURL = response.data.redirectURL
				})
		},
	},
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
.instructions{
  display: inline-block;
  border: 1px solid;
  margin: 20px 5px;
  border-color: #d7d7d7;
  border-radius: 5px;
  padding: 20px 5px;
  font-size: 12px;
  margin-top: 20px;
}
.instructions__label{
  font-size: 12px;
  font-weight: bold;
}
.instructions__sublabel{
  font-size: 10px;
}
.padding0:first-child {
  padding-right: 12px;
  padding-left: 0px;
}
.padding0:last-child {
  padding-left: 12px;
  padding-right: 0px;
}
.margin0{
  margin: 0%;
}
.margintop10{
  margin-top: 10px;
}
.urllink a
{
  color: #0d6efd !important;
  text-decoration: none;
  font-weight: 800;
  font-size: 12px;
  float: right;
  text-transform: uppercase;
}
.urllink{
  text-transform: uppercase;
  margin-top: 10px;
}
.storage{
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 10px;
}
.usage-info{
  font-size: 12px;
  font-weight: 400;
  color: #949DA1;
  float: left;
}
.upgrade-storage__div #upgrad-btn{
  float: right;
  background: #0086FF;
  padding: 5px 15px;
  border-radius: 4px;
  font-size: 10px;
  color: white;
  border: 1px solid white;
  text-transform: uppercase;
}
.upgrade__main_div{
  padding-right: 0;
}
.align-center{
  text-align: center;
}
.progress-bar {
  display: flex;
  flex-direction: column;
  justify-content: center;
  overflow: hidden;
  color: #fff;
  text-align: center;
  white-space: nowrap;
  background-color: #0d6efd;
  transition: width .6s ease;
}
.progress{
  padding: 0%;
  height: 5px;
  margin: 1% 0;
  display: flex;
  overflow: hidden;
  font-size: .75rem;
  background-color: #e9ecef;
  border-radius: 0.25rem;
}
.row{
  padding: 5px;
  flex-shrink: 0;
  width: 100%;
  max-width: 100%;
  padding-right: calc(var(--bs-gutter-x) * .5);
  padding-left: calc(var(--bs-gutter-x) * .5);
  margin-top: var(--bs-gutter-y);
}
.col-lg-12 {
  flex: 0 0 auto;
  width: 100%;
}
.storage-space-div{
  float: left;
}
.width90{
  width: 90%;
}
#storage-redeem{
	background-image: url('../assets/redeem.svg');
	background-repeat: no-repeat;
  background-position: 5% 5%;
  padding-left: 10%;
}
/* Extra small devices (phones, 600px and down) */
@media only screen and (max-width: 768px) {
  #storage-redeem{
      background-position: top center;
	padding-top: 50px;
  }
}
/* Medium devices (landscape tablets, 768px and up) */
@media only screen and (min-width: 768px) {
  #storage-redeem{
    background-position: 5% 5%;
  padding-top: unset;
  }
}

</style>
