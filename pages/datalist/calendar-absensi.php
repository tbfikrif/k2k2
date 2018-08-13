<?php
   if (!defined('DIDALAM_INDEX_PHP')){ 
    //echo "Dilarang broh!";
        header("Location: ../../tampil/home");
    }
?>

<div class="container fadeIn animated">
  <h2> CALENDAR  ABSENSI </h2>
  <br>
  <div id="calendarAbsenAnggota"></div>
 </div>
 
 <div id="dataModalAbsensiCalendar" class="modal fade" style="overflow: auto !important;">  
      <div class="modal-dialog modal-lg">  
           <div class="modal-content">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">Detail Kehadiran</h4>  
                </div>  
                <div class="modal-body" id="detail_kehadiran_calendar">  
                </div>  
                <div class="modal-footer">    
                     <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>  
                </div>  
           </div>  
      </div>  
</div>