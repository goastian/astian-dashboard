<template>
  <div id="ecloud-dashboard">  
    <div class="welcome__label"><b>Welcome back {{userinfo.name}}</b></div>
    <div v-on:click="isHidden = !isHidden">
      <span v-if="!isHidden" class="toggle_apps show-all">SHOW ALL APPS</span>
      <span v-if="isHidden" class="toggle_apps show-less">SHOW LESS APPS</span>
    </div> 
    <div  class="app-container">  
      <div class="item"  v-for="entry in entries" :key="entry.message">
        <div class="color-icons" v-bind:class="entry.name"></div>
        <div class="item-label"> {{ entry.name }}</div>
      </div>
    </div> 
   <div  class="app-container" v-if="isHidden">         
      <div class="item"  v-for="entry in external" :key="entry.message">
        <div class="color-icons" v-bind:class="entry.name"></div>
        <div class="item-label"> {{ entry.name }}</div>
      </div>
   </div> 
</div>
</template>

<script>
import axios from '@nextcloud/axios';
import { generateUrl } from '@nextcloud/router';

export default {
  name: 'AllApps',
  components: {
	},
  props: {
  },
  data () {
    return {
      isHidden: false,
      entries: [],
			external: [],
      userinfo: []
    }
  },
  mounted() {
		this.getEntries(),
		this.getUserinfo()
	},
  methods: {
    getEntries() {
			axios
				.get(generateUrl('/apps/ecloud-dashboard/apps'))
				.then(response => {
					this.entries = response.data.apps
					this.entries = this.entries.map(entry => {
						entry.active = window.location.pathname.includes(
							entry.href
						)
						return entry
					}); 
         	this.external = this.entries.slice(6)
         	this.entries = this.entries.slice(0,6)
          console.log('this.entries');
          console.log(this.entries);
				})
		},
    getUserinfo() {
			axios
				.get(generateUrl('/apps/ecloud-dashboard/apps/getuserinfo'))
				.then(response => {
					this.userinfo = response.data.userinfo
				})
		}
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.welcome__label{    
  margin-left: 2%;
}
.toggle_apps{
  float: right;
  font-size: 10px;
  color: #0086FF;
  background-repeat: no-repeat;
  background-position: right;
  padding-right: 20px;
  margin-right: 30px;
  margin-bottom: 20px;
  background-size: 10px;
  cursor: pointer;
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
  /* border-spacing: 10px; */
}
.item {
    /* display: table-cell; */
  vertical-align: middle;
  text-align: center;
  width: 16.6666667%;
  float: left;
  margin-top: 10px;
  margin-bottom: 10px;
}
</style>
