
<template>
  <div>  
    <div v-on:click="isHidden = !isHidden">
      <span v-if="!isHidden" class="toggle_apps show-all">SHOW ALL APPS</span>
      <span v-if="isHidden" class="toggle_apps show-less">SHOW LESS APPS</span>
    </div> 
    
    <div  class="app-container"> 
      <div class="item">
        <img width="60" height="60" src="../assets/files.png" />
        <div class="item-label">Drive</div>
        <div class="item-sublabel">405 MB</div>
      </div>

     <div class="item">
      <img width="60" height="60" src="../assets/calendar.png" />
      <div class="item-label">Calendar</div>
      <div class="item-sublabel">9 MB</div>
    </div>

     <div class="item">
      <img width="60" height="60" src="../assets/photos.png" />
      <div class="item-label">Photos</div>
      <div class="item-sublabel">144 MB</div>
    </div>

     <div class="item">
      <img width="60" height="60" src="../assets/contacts.png" />
      <div class="item-label">Contacts</div>
      <div class="item-sublabel">0.44 MB</div>
    </div>

     <div class="item">
      <img width="60" height="60" src="../assets/notes.png" />
      <div class="item-label">Notes</div>
      <div class="item-sublabel">18 MB</div>
    </div>
    
     <div class="item">
      <img width="60" height="60" src="../assets/tasks.png" />
      <div class="item-label">Tasks</div>
      <div class="item-sublabel">2.7 MB</div>
    </div>
    </div>

    <div v-if="isHidden"  class="app-container">
      <div class="item">
        <img width="60" height="60" src="../assets/Docs.png" />
        <div class="item-label">Docs</div>
        <div class="item-sublabel">11.7 MB</div>
      </div>

      <div class="item">
        <img width="60" height="60" src="../assets/Spreadsheet.png" />
        <div class="item-label">Spreadsheet</div>
        <div class="item-sublabel">1.26 MB</div>
      </div>

      <div class="item">
        <img width="60" height="60" src="../assets/presentation.png" />
        <div class="item-label">Presentation</div>
        <div class="item-sublabel">25.2 MB</div>
      </div>


      <div class="item">
        <img width="60" height="60" src="../assets/other.png" />
        <div class="item-label">Activity</div>
        <div class="item-sublabel">2.7 MB</div>
      </div>

      <div class="item">
        <img width="60" height="60" src="../assets/other.png" />
        <div class="item-label">Carnet</div>
        <div class="item-sublabel">2.7 MB</div>
      </div>

      <div class="item">
        <img width="60" height="60" src="../assets/other.png" />
        <div class="item-label">Deck</div>
        <div class="item-sublabel">2.7 MB</div>
      </div>

      <div class="item">
        <img width="60" height="60" src="../assets/other.png" />
        <div class="item-label">Bookmarks</div>
        <div class="item-sublabel">2.7 MB</div>
      </div>

      <div class="item">
        <img width="60" height="60" src="../assets/other.png" />
        <div class="item-label">News</div>
        <div class="item-sublabel">2.7 MB</div>
      </div>

      <div class="item">
        <img width="60" height="60" src="../assets/other.png" />
        <div class="item-label">Gitlab</div>
        <div class="item-sublabel">2.7 MB</div>
      </div>

      
    </div>
</div>


</template>

<script>
export default {
  name: 'AllApps',
  props: {
    msg: String
  }
  ,
  data () {
    return {
      isHidden: false
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
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
