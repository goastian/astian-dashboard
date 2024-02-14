<template>
	<div class="storage-main-div">
		<div v-if="!storageFetchStatus">
			<ul class="o-vertical-spacing o-vertical-spacing--l">
				<li class="uiskeleton-post o-media">
					<div class="o-media__body">
						<div class="o-vertical-spacing">
							<h3 class="uiskeleton-post__headline headline_1">
								<span class="skeleton-box width10" />
							</h3>
							<div class="uiskeleton-post__meta">
								<span class="skeleton-box width100" />
							</div>
							<h3 class="uiskeleton-post__headline headline_2">
								<span class="skeleton-box width10" />
							</h3>
							<div class="o-media__figure">
								<span class="skeleton-box width95" />
							</div>
						</div>
					</div>
				</li>
			</ul>
		</div>
		<div v-if="storageFetchStatus" class="row margin0">
			<div class="row margin0 storage-layout">
				<hr>
			</div>
			<div class="row margin0">
				<div class="row margintop10">
					<b class="storage">{{ t(appName, 'Storage') }}</b>
					<div class="progress">
						<div class="progress-bar"
							:style="{ width: totalSpaceUsedInPercentage + '%' }"
							style="background-color: #0086ff !important" />
					</div>
					<div class="upgrade__main_div">
						<div class="usage-info">
							{{ usageinfo }}
						</div>
						<div v-if="increaseStorageUrl.length && storageInfo.quota > 0" class="upgrade-storage__div">
							<a id="upgrade-btn" target="_blank" :href="increaseStorageUrl">
								{{ t(appName, 'Upgrade Storage') }}
							</a>
						</div>
					</div>
				</div>
				<div v-if="isReferralProgramActive && shopReferralProgramUrl.length" class="row margin0">
					<div class="col-lg-12 instructions">
						<div class="row margin0">
							<div id="storage-redeem" class="storage-space-div width90">
								<div class="instructions__label">
									{{ t(appName, 'getCredits') }}
								</div>
								<div class="instructions__sublabel">
									{{ t(appName, 'openAnAccount') }}
								</div>
								<div class="urllink">
									<a :href="shopReferralProgramUrl" target="_blank">{{ t(appName, 'Invite Your Friends') }}</a>
								</div>
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
import { formatFileSize } from '@nextcloud/files'
import { loadState } from '@nextcloud/initial-state'

export default {
	name: 'StorageLayout',
	components: {},
	data() {
		return {
			storageInfo: [],
			storageFetchStatus: false,
			isReferralProgramActive: loadState('murena-dashboard', 'isReferralProgramActive'),
			shopReferralProgramUrl: loadState('murena-dashboard', 'shopReferralProgramUrl'),
			increaseStorageUrl: loadState('murena-dashboard', 'increaseStorageUrl'),
			appName: 'murena-dashboard',
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
				const humanReadableUsed = formatFileSize(humanUsed)
				const humanReadableQuota = formatFileSize(humanQuota)
				let percent = (this.storageInfo.used * 100) / this.storageInfo.quota
				percent = percent.toFixed(2)
				if (this.storageInfo.quota > 0) {
					return (
						humanReadableUsed
            + ' of '
            + humanReadableQuota
            + ' ('
            + percent
            + '%)'
            + ' used'
					)
				} else {
					return humanReadableUsed + ' used'
				}
			} catch (err) {
				return err.message
			}
		},
	},
	mounted() {
		this.getStorageUsageDetails()
	},
	methods: {
		getStorageUsageDetails() {
			this.storageFetchStatus = false
			axios
				.get(generateUrl('/apps/files/api/v1/stats'))
				.then((response) => {
					this.storageInfo = response.data.data
					this.storageFetchStatus = true
				})
		},
	},
}
</script>

<style scoped="">
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

.instructions {
  display: inline-block;
  border: 1px solid;
  margin: 20px 0px;
  border-color: #d7d7d7;
  border-radius: 12px;
  padding: 20px 5px;
  font-size: 12px;
  margin-top: 20px;
}

.instructions__label {
    font-family: 'Roboto';
    font-size: 17px;
    font-weight: 600;
    letter-spacing: 1px;
    margin-bottom: 3px;
    color: #333333;
}

.instructions__sublabel {
  font-family: 'Roboto';
  font-size: 16px;
  color: #333333;
}

.padding0:first-child {
  padding-right: 12px;
  padding-left: 0px;
}

.padding0:last-child {
  padding-left: 12px;
  padding-right: 0px;
}

.margin0 {
  margin: 0%;
}

.margintop10 {
  margin-top: 10px;
}

.urllink a {
  color: #0075E0 !important;
  text-decoration: none;
  font-weight: 800;
  font-size: 13px;
  float: right;
  text-transform: uppercase;
}

.urllink {
  text-transform: uppercase;
  margin-top: 10px;
  margin-right: 3%;
}

.storage {
  font-family: 'Roboto';
  font-style: normal;
  font-weight: 600;
  letter-spacing: 1px;
  font-size: 20px;
  line-height: 100%;
  color: #333333;
  margin-bottom: 10px;
}

.usage-info {
  font-family: 'Roboto';
  font-size: 13px;
  font-weight: 500;
  color: #949da1;
  float: left;
}

.upgrade-storage__div #upgrade-btn {
  float: right;
  font-style: normal;
  font-family: 'Roboto';
  background: #0086ff;
  color: #FFFFFF;
  padding: 8px 15px 5px 15px;
  border-radius: 6px;
  font-size: 13px;
  border: 1px solid white;
  text-transform: uppercase;
  letter-spacing: 1.25px;
  font-weight: 500;
}

.upgrade__main_div {
  padding-right: 0;
}

.align-center {
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
  transition: width 0.6s ease;
}

.progress {
  padding: 0%;
  height: 5px;
  margin: 1% 0;
  display: flex;
  overflow: hidden;
  font-size: 0.75rem;
  background-color: #e9ecef;
  border-radius: 0.25rem;
}

.row {
  padding: 5px;
  flex-shrink: 0;
  width: 100%;
  max-width: 100%;
  padding-right: calc(var(--bs-gutter-x) * 0.5);
  padding-left: calc(var(--bs-gutter-x) * 0.5);
  margin-top: var(--bs-gutter-y);
}

.col-lg-12 {
  flex: 0 0 auto;
  width: 100%;
}

.storage-space-div {
  float: left;
}

.width90 {
  width: 90%;
}

#storage-redeem {
  background-image: url('../assets/redeem.svg');
  background-repeat: no-repeat;
  background-position: 3% 0;
  padding-left: 10%;
  width: 100%;
}

.storage-layout hr{
  position: static;
  width: 100%;
  height: 1px;
  left: 0px;
  top: 0px;
    border: 1px solid #f4f4f4;
  flex: none;
  order: 0;
  align-self: stretch;
  flex-grow: 0;
  margin: 10px 0px;
}

/* Extra small devices (phones, 600px and down) */

@media only screen and (max-width: 768px) {
  #storage-redeem {
    background-position: top center;
    padding-top: 50px;
  }
}

/* Medium devices (landscape tablets, 768px and up) */

@media only screen and (min-width: 768px) {
  #storage-redeem {
    background-position: 3% 0;
    padding-top: unset;
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
  margin-top: 0.70em;
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
.width100{
  width: 100%;
}
.width10{
  width: 10%;
}
.width95{
  width: 95%;
}
.headline_1 .skeleton-box{
  height: 1.2em
}
.uiskeleton-post__meta .skeleton-box{
  height: 0.2em
}
.headline_2 .skeleton-box{
  height: 0.80em
}
.o-media__figure .skeleton-box{
  height: 3.2em
}

</style>
