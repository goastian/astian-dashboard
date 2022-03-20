<template>
  <div class="app-container">
    <div class="item">
      <img width="60" height="60" src="../assets/files.png" />
      <div class="item-label">Files</div>
    </div>

     <div class="item">
      <img width="60" height="60" src="../assets/email.png" />
      <div class="item-label">Email</div>
    </div>

     <div class="item">
      <img width="60" height="60" src="../assets/calendar.png" />
      <div class="item-label">Calendar</div>
    </div>

     <div class="item">
      <img width="60" height="60" src="../assets/photos.png" />
      <div class="item-label">Photos</div>
    </div>

     <div class="item">
      <img width="60" height="60" src="../assets/contacts.png" />
      <div class="item-label">Contacts</div>
    </div>

     <div class="item">
      <img width="60" height="60" src="../assets/notes.png" />
      <div class="item-label">Notes</div>
    </div>
    
     <div class="item">
      <img width="60" height="60" src="../assets/tasks.png" />
      <div class="item-label">Tasks</div>
    </div>
    
  </div>
</template>

<script>
export default {
  name: 'HelloWorld',
  props: {
    msg: String
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.item-label{
  font-size: 12px;
  padding-top: 10px;
  font-weight: 500;
}
.app-container {
  display: table;
  table-layout: fixed;
  width: 100%;
  box-sizing: border-box;
  border-spacing: 10px;
}
.item {
  /* float:left; */
  display: table-cell;
  vertical-align: middle;
  text-align: center;
}
</style>
