<template>
  <div class="row margin0">
    <div class="row margin0">
      <div class="row margintop10">
        <b class="storage">Storage</b>
        <div class="progress">
          <div class="progress-bar" 
          v-bind:style="{ width: totalspaceusedinpercentage + '%' }" 
          style="background-color: rgb(204, 228, 255) !important ">
          </div>
        </div>
        <div class="upgrade__main_div">
          <div class="usage-info">{{usageinfo}}</div>
          <div class="upgrade-storage__div">
            <button>UPGRADE STORAGE</button>  
          </div>
        </div>
      </div>
      <div  class="row margin0"> 
          <div class="col-lg-12  instructions">
            <div class="row margin0">
                <div class="col-lg-1 align-center"> <img width="25" height="25" src="../assets/redeem.png" alt="Storage Space"/> </div>
                <div class="col-lg-10">
                  <div class="instructions__label">Get up to 40€ of credits for your cloud storage by inviting your friends!</div>
                  <div class="instructions__sublabel">For every friend who opens an account, you will both earn 2€ to be used for cloud storage on ecloud.</div>
                  <div class="urllink"><a href="#">INVITE YOUR FRIENDS</a></div>
                </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</template>


<script>

import axios from '@nextcloud/axios';
import { generateUrl } from '@nextcloud/router'

export default {
  name: 'AllApps',
  components: {
  },
  props: {
  },
  data () {
    return {
      storageinfo: [],
      quotatoshowprogressbar : []
    }
  },
  mounted() {
    // this.getStorageinfo(),
    this.getDetails()
  },
  methods: {
    getDetails() {
      axios
        .get(generateUrl('/apps/files/ajax/getstoragestats.php'))
        .then(response => {
          this.storageinfo = response.data.data
        })
    }
  },
  computed: {
    totalspaceusedinpercentage() {
      let percent = (this.storageinfo.used * 100 ) / this.storageinfo.quota
      return percent.toFixed(2)
    },
    usageinfo(){
        var humanUsed = OC.Util.humanFileSize(this.storageinfo.used, true);
        var percent = (this.storageinfo.used * 100 ) / this.storageinfo.quota
        if (this.storageinfo.quota > 0) {
          var humanQuota = OC.Util.humanFileSize(this.storageinfo.quota, true);
          return humanUsed+' of '+humanQuota+ '('+percent+'%)' + ' used';
        }else{
          return humanUsed+' used';
        }
    }
  }
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
.progress{
  padding: 0%;
  height: 5px;
  margin: 1% 2%;
}
.instructions{
  border: 1px solid;
  margin: 20px 5px;
  border-color: #d7d7d7;
  border-radius: 5px;
  padding: 25px 4px;
  font-size: 12px;
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
}
.urllink{
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
.upgrade-storage__div button{
  float: right;
  background: #0086FF;
  padding: 5px 15px;
  border-radius: 4px;
  font-size: 10px;
  color: white;
  border: 1px solid white;
  margin-right: -15px;
}
.upgrade__main_div{
  padding-right: 0;
}
.align-center{
  text-align: center;
}
</style>
