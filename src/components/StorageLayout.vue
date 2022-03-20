<template>
  <div class="row margin0">
    <div class="row margin0">
      <div class="row margintop10">
        <b class="font20">Storage</b>
        <div>You are using 129,41 GB of 200 GB (64.7%)</div>
        <div class="progress">
          <div class="progress-bar" role="progressbar" style="width: 64.7%;" aria-valuenow="64.7" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>
      <div  class="row margin0">
        <div class="col-lg-4 padding0">
          <div class="col-lg-12  instructions">
          <div class="row margin0">
              <div class="col-lg-1"> <img width="15" height="15" src="../assets/cloud_storage.png" alt="Storage Space"/> </div>
              <div class="col-lg-10">
                Display the composition of the used space or free storage space.
                <div class="urllink"><a href="#">Show storage space</a></div>
              </div>
          </div>
          </div>
        </div>
        <div class="col-lg-4 padding0">
          <div class="col-lg-12  instructions">
            <div class="row margin0">
              <div class="col-lg-1"> <img width="15" height="15" src="../assets/mobile.png" alt="Backup"/> </div>
              <div class="col-lg-10">
                  Check the details about the backup of your Murena Phone.
                <div class="urllink"><a href="#">Check backup</a></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 padding0">
          <div class="col-lg-12  instructions">
            <div class="row margin0">
              <div class="col-lg-1"> <img width="15" height="15" src="../assets/grow_up.png" alt="subscription"/> </div>
              <div class="col-lg-10">
                  Upgrade your subscription to get more storage
                <div class="urllink"><a href="#">View subscription</a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'StorageLayout',
  props: {
    msg: String
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
}
.urllink{
  margin-top: 10px;
}
.font20{
  font-size: 20px;
}
</style>
