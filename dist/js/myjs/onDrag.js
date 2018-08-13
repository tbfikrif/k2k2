var currentMousePos = {
  x: -1,
  y: -1
};

jQuery(document).on("mousemove", function (event) {
  currentMousePos.x = event.pageX;
  currentMousePos.y = event.pageY;
  //console.log("X:"+currentMousePos.x+",Y:"+currentMousePos.y);
});

function isElemOverDiv() {
  var trashEl = jQuery('#trash');
  var ofs = trashEl.offset();
  var x1 = ofs.left;
  var x2 = ofs.left + trashEl.outerWidth(true);
  var y1 = ofs.top;
  var y2 = ofs.top + trashEl.outerHeight(true);
  if (currentMousePos.x >= x1 && currentMousePos.x <= x2 && currentMousePos.y >= y1 && currentMousePos.y <= y2) { 
    return true; 
  } else{
    return false;
  }
}