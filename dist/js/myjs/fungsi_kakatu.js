 //rezki
  $.validate({
     modules : 'file'
  });
  //rezki
 //Fungsi Form Absensi
        //Proses Ambil Latitude & Longitude
        var y = document.getElementById("nonsupport");
        function getUserLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(getPosition);
            } else {
                y.innerHTML = "Geolocation is not supported by this browser.";
            }
        }
        var latitude = document.getElementById("latitude");
        var longitude = document.getElementById("longitude");
        function getPosition(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            var API_KEY = 'AIzaSyAn0sCC7HGqbJbWhwkgJnvyWFiTa7QGtVI';
            $.ajax({
                url: 'pages/fetchdata/fetch_data-alamat.php',
                type: 'post',
                data: {
                    latitude: lat,
                    longitude: lng
                },
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    console.log('address', response.address);
                    ///tes
                    $('#latitude').val(response.latitude);
                    $('#longitude').val(response.longitude);
                    //$('#address').val(response.address);
                    //tes
                    $('#address_hadirdiluar').val(response.address);
                    $('#address_sakit').val(response.address);
                    $('#address_izin').val(response.address);
                    $('#address_cuti').val(response.address);
                    //gambar lokasi
                    //var src = 'http://maps.googleapis.com/maps/api/staticmap?center=' + lat + ',' + lng + '&markers=size:midcolor:red|label:|' + lat + ',' + lng + '&zoom=17&size=600x400&key=' + API_KEY;
                    //$('#img-location').attr("src", src);
                },
                error: function (response) {
                    console.log(response);
    
                }
            });
    
        }
        var statussaya = document.getElementById("statussaya");
        var ketsaya = document.getElementById("statussaya")
        function formatPesan() {
            var waktuAbsen = document.getElementById("waktuAbsen").innerHTML;
            var idAbsen = document.getElementById("id_anggota_absen").value;
            document.getElementById("idsaya").innerHTML = idAbsen;
            var namaAbsen = document.getElementById("nama_absen").value;
            document.getElementById("namasaya").innerHTML = namaAbsen;
            var stat = x.options[x.selectedIndex].tex;
            var ket1;
            switch (stat) {
                case "Hadir":
                    ket1 = "Hadir";
                    break;
                case "Hadir (Diluar)":
                    ket1 = "Hadir diluar";
                    break;
                case "Sakit":
                    ket1 = "Sakit";
                    break;
                case "Izin":
                    ket1 = "Izin";
                    break;
            }
            statussaya.innerHTML = ket1;
            var ket2 = document.getElementById("keterangan_absen").value;
            document.getElementById("ketsaya").innerHTML = ket2;
            var lokasi = document.getElementById("adress").value;
            document.getElementById("lokasi").innerHTML = lokasi;
            var waMsg1 = "Waktu Absen: " + "\n" + waktuAbsen + "\n\n" + "ID Anggota: " + "\n" + idAbsen + "\n\n" + "Nama: " + "\n" + namaAbsen + "\n\n" + "Status: " + "\n" + ket1 + "\n\n" + "Keterangan: " + "\n" + ket2 + "\n\n" + "Lokasi: " + "\n" + lokasi;
            var waMsg1 = window.encodeURIComponent(waMsg1);
            var waMsg2 = document.getElementById("isiPesanWA").innerText;
            var isiPesanWA = "whatsapp://send?text=" + waMsg1;
            //alert(isiPesanWA);
            document.getElementById("pesanWA").setAttribute("href", isiPesanWA);
        }
        // End Proses Ambil Latitude & Longitude
        function validasiCuti(){
            var sisacuti = $("#sisacuti").val();
    
        }
        //End Fungsi Form Absensi
        
 //MASK MONEY
 $(function() {
    $(function(){
    $("#numeric").maskMoney({prefix:'Rp ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false, precision : 0});
  })
    $(function(){
    $("#gaji").maskMoney({prefix:'Rp ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false, precision : 0});
  })
    $(function(){
    $("#gaji1").maskMoney({prefix:'Rp ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false, precision : 0});
  })
  })
 //END MASK MONEY

 //MODAL GAMBAR PREVIEW
  $(document).on('click', '#close-preview', function(){ 
      $('.image-preview').popover('hide');
      // Hover befor close the preview
      $('.image-preview').hover(
          function () {
            $('.image-preview').popover('show');
          }, 
          function () {
            $('.image-preview').popover('hide');
          }
      );    
  });

  $(function() {
      // Create the close button
      var closebtn = $('<button/>', {
          type:"button",
          text: 'x',
          id: 'close-preview',
          style: 'font-size: initial;',
      });
      closebtn.attr("class","close pull-right");
      // Set the popover default content
      $('.image-preview').popover({
          trigger:'manual',
          html:true,
          title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
          content: "There's no image",
          placement:'bottom'
      });
      // Clear event
      $('.image-preview-clear').click(function(){
          $('.image-preview').attr("data-content","").popover('hide');
          $('.image-preview-filename').val("");
          $('.image-preview-clear').hide();
          $('.image-preview-input input:file').val("");
          $(".image-preview-input-title").text("Browse"); 
      }); 
      // Create the preview image
      $(".image-preview-input input:file").change(function (){     
          var img = $('<img/>', {
              id: 'dynamic',
              width:250,
              height:200
          });      
          var file = this.files[0];
          var reader = new FileReader();
          // Set preview image into the popover data-content
          reader.onload = function (e) {
              $(".image-preview-input-title").text("Change");
              $(".image-preview-clear").show();
              $(".image-preview-filename").val(file.name);            
              img.attr('src', e.target.result);
              $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
          }        
          reader.readAsDataURL(file);
      });
      
      
  });
 //END MODAL GAMBAR PREVIEW
 

 //Kumpulan fungsi
 $(function () {

      //KONFIGURASI FULLCALENDAR
      function init_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    init_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()
    $('#calendar').fullCalendar({
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'month,agendaDay,listMonth'
      },
      buttonText: {
        today: 'Hari Ini',
        month: 'Bulan',
        day  : 'Hari',
        list : 'List'
      },
      //Random default events
      events    : "pages/fetchdata/fetch_data_calendar-absen.php",
      eventLimit: true,
      businessHours: true, // display business hours
      navLinks: true, // can click day/week names to navigate views
      editable  : true,
      droppable : true, // this allows things to be dropped onto the calendar !!!
      drop      : function (date, allDay) { // this function is called when something is dropped

        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject')

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject)

        // assign it the date that was reported
        copiedEventObject.start           = date
        copiedEventObject.allDay          = allDay
        copiedEventObject.backgroundColor = $(this).css('background-color')
        copiedEventObject.borderColor     = $(this).css('border-color')

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)

        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove()
        }

      },
      eventClick: function(calEvent, jsEvent, view) {

        alert('Event: ' + calEvent.title);
        // change the border color just for fun
        $(this).css('border-color', 'red');

    }
    })

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    //Color chooser button
    var colorChooser = $('#color-chooser-btn')
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      //Save color
      currColor = $(this).css('color')
      //Add color effect to button
      $('#add-new-event').css({ 'background-color': currColor, 'border-color': currColor })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      //Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      //Create events
      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.html(val)
      $('#external-events').prepend(event)

      //Add draggable funtionality
      init_events(event)

      //Remove event from text input
      $('#new-event').val('')
    })
      //END KONFIGURASI FULLCALENDAR

      //KONFIGURASI TABEL
      $('#example').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false,
        "order": [[ 0, "desc" ]]
      })
      $('#data_credits').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false,
        "order": [[ 4, "desc" ]]
      })
      $('#data_absen_admin').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false,
        "order": [[ 0, "desc" ]]
      })
      $('#data_absen').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false,
        "order": [[ 0, "desc" ]]
      })
      $('#example1').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
      })

      $('#table_jabatan').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
      })
      $('#table_rekap').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false,
        "order": [[ 0, "asc" ]]
      })
      //END KONFIGURASI TABEL
      
     //DATE PICKER
        $('.select2').select2()    

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd-mm-YYYY', { 'placeholder': 'dd/mm/yyyy' })
            $('[data-mask]').inputmask()

        //Date range picker
        $('#tglRentangAbsenAdmin').daterangepicker({drops: 'up'})
        $('#tglRentangAbsenAdmin').on('apply.daterangepicker', function(ev, picker) {
          var start= picker.startDate.format('MM/DD/YYYY');
          var end = picker.endDate.format('MM/DD/YYYY');
          var date1 = new Date(start);
          var date2 = new Date(end);
          //var timeDiff = Math.abs(date2.getTime() - date1.getTime());
          //var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24))+1; 
          var sisaCuti;
          var cutiUsed;
          $.ajax({
            async: false, 
            type: "POST",
            url: "pages/fetchdata/fetch_data-hitungcutiused.php",
            data: {start:start,end:end},
            dataType:"json", 
            success: function (data) {
              console.log("Sisa Cuti: "+data.sisaCuti+" Cuti Used: "+data.cutiUsed);
              sisaCuti = data.sisaCuti;
              cutiUsed=data.cutiUsed;
            }
          });
          var status=$("#status_id_adminEdit").val();
          var today= new Date();
          var timeDiff2 = date1.getTime() - today.getTime();
          var diffDays2 = Math.ceil(timeDiff2 / (1000 * 3600 * 24));
          //var tglskrg = (today.getMonth()+1) + '/' + today.getDate() + '/' + today.getFullYear();
          if (diffDays2<0) {
              alert("Tidak boleh memilih tanggal yang telah lewat");
              $('#tglRentangCuti').val('');
          } else {
            if (cutiUsed>sisaCuti && status=="5") {
              alert("Cuti yang digunakan melebihi jatah cuti!");
              $('#tglRentangCuti').val('');
            }
          }

        })

        $('#tglRentangLibur').daterangepicker({drops: 'up'}) 
        $('#tglRentangLibur').on('apply.daterangepicker', function(ev, picker) {
          var start= picker.startDate.format('MM/DD/YYYY');
          var end = picker.endDate.format('MM/DD/YYYY');
          var date1 = new Date(start);
          var date2 = new Date(end);
          var today= new Date();
          var timeDiff2 = date1.getTime() - today.getTime();
          var diffDays2 = Math.ceil(timeDiff2 / (1000 * 3600 * 24));
          if (diffDays2<0) {
              alert("Tidak boleh memilih tanggal yang telah lewat");
              $('#tglRentangLibur').val('');
          }
        })
        $('#tglRentangLiburEdit').daterangepicker() 
        $('#tglRentangLiburEdit').on('apply.daterangepicker', function(ev, picker) {
          var start= picker.startDate.format('MM/DD/YYYY');
          var end = picker.endDate.format('MM/DD/YYYY');
          var date1 = new Date(start);
          var date2 = new Date(end);
          var today= new Date();
          var timeDiff2 = date1.getTime() - today.getTime();
          var diffDays2 = Math.ceil(timeDiff2 / (1000 * 3600 * 24));
          if (diffDays2<0) {
              alert("Tidak boleh memilih tanggal yang telah lewat");
              $('#tglRentangLiburEdit').val('');
          }
        })
        $('#tglRentangCuti').daterangepicker() 
        $('#tglRentangCuti').on('apply.daterangepicker', function(ev, picker) {
          var start= picker.startDate.format('MM/DD/YYYY');
          var end = picker.endDate.format('MM/DD/YYYY');
          var date1 = new Date(start);
          var date2 = new Date(end);
          console.log(start+"-"+end);
          //var timeDiff = Math.abs(date2.getTime() - date1.getTime());
          //var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24))+1; 
          //var sisacuti= <?php echo $_SESSION["sisacuti"] ?>;
          var sisaCuti;
          var cutiUsed;
          $.ajax({
            async: false, 
            type: "POST",
            url: "pages/fetchdata/fetch_data-hitungcutiused.php",
            data: {start:start,end:end},
            dataType:"json", 
            success: function (data) {
              console.log("Sisa Cuti: "+data.sisaCuti+" Cuti Used: "+data.cutiUsed);
              sisaCuti = data.sisaCuti;
              cutiUsed=data.cutiUsed;
            }
          });
          var today= new Date();
          var timeDiff2 = date1.getTime() - today.getTime();
          var diffDays2 = Math.ceil(timeDiff2 / (1000 * 3600 * 24));
          //var tglskrg = (today.getMonth()+1) + '/' + today.getDate() + '/' + today.getFullYear();
          if (diffDays2<0) {
              alert("Tidak boleh memilih tanggal yang telah lewat");
              $('#tglRentangCuti').val('');
          } else {
            if (cutiUsed>sisaCuti) {
              alert("Cuti yang digunakan melebihi jatah cuti!");
              $('#tglRentangCuti').val('');
            }
          }
        })
        $('#tglRentangIzin').daterangepicker({drops: 'up'})
        $('#tglRentangIzin').on('apply.daterangepicker', function(ev, picker) {
          var start= picker.startDate.format('MM/DD/YYYY');
          var end = picker.endDate.format('MM/DD/YYYY');
          var date1 = new Date(start);
          var date2 = new Date(end);
          var today= new Date();
          var timeDiff2 = date1.getTime() - today.getTime();
          var diffDays2 = Math.ceil(timeDiff2 / (1000 * 3600 * 24));
          if (diffDays2<0) {
              alert("Tidak boleh memilih tanggal yang telah lewat");
              $('#tglRentangIzin').val('');
          }
        })
        $('#tglRentangSakit').daterangepicker({drops: 'up'}) 
        $('#tglRentangSakit').on('apply.daterangepicker', function(ev, picker) {
          var start= picker.startDate.format('MM/DD/YYYY');
          var end = picker.endDate.format('MM/DD/YYYY');
          var date1 = new Date(start);
          var date2 = new Date(end);
          var today= new Date();
          var timeDiff2 = date1.getTime() - today.getTime();
          var diffDays2 = Math.ceil(timeDiff2 / (1000 * 3600 * 24));
          if (diffDays2<0) {
              alert("Tidak boleh memilih tanggal yang telah lewat");
              $('#tglRentangSakit').val('');
          }
        })
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'Y-m-d H:i:a',drops: 'up' })
        //Date range as a button
        $('#daterange-btn').daterangepicker(
          {
            ranges   : {
              'Today'       : [moment(), moment()],
              'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'This Month'  : [moment().startOf('month'), moment().endOf('month')],
              'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate  : moment()
          },
          function (start, end) {
            $('#daterange-btn span').html(start.format('Y-m-d H:i:a ') + ' s/d ' + end.format('Y-m-d H:i:a'))
          }
        )

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass   : 'iradio_minimal-blue'
        })

        //Date picker
        $('#start_date').datepicker({
          autoclose: true,
        })

        //Date picker
        $('#end_date').datepicker({
          autoclose: true
        })
     //END DATE PICKER
   
    // DONUT CHART PEMBAYARAN
    function configChartJumlahOperasional(dataJumlahOperasional){
      var donut = new Morris.Donut({
        element: 'sales-chart',
        resize: true,
        colors: ["#3c8dbc", "#f56954", "#00a65a","#DAA520","#ADEAEA","#3D1D49"],
        data: dataJumlahOperasional,
        hideHover: 'auto'
      });
    }
    function ajaxConfigChartJumlahOperasional(){
      $.ajax({
        type: "post",
        url: "pages/fetchdata/fetch_chart-jumlah-operasional.php",
        dataType: "json",
        success: function (data) {
          configChartJumlahOperasional(data);
        }
      });
    }
    
	// END DONUT CHART PEMBAYARAN
	
	// PIE CHART ABSENSI HARI INI
	function chartConfigAbsen(dataAbsen,truefalse){
    var canvas = document.getElementById("chart_absensi-hari-ini");
    var ctx = canvas.getContext("2d");
    var midX = canvas.width/2;
    var midY = canvas.height/2;
    var pieChart       = new Chart(ctx)
    //console.log(dataAbsen);
    var PieData        = dataAbsen;
    var pieOptions     = {
      showTooltips: false,
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke    : true,
      //String - The colour of each segment stroke
      segmentStrokeColor   : '#fff',
      //Number - The width of each segment stroke
      segmentStrokeWidth   : 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 0, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps       : 100,
      //String - Animation easing effect
      animationEasing      : 'easeOutBounce',
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate        : truefalse,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale         : truefalse,
      //Boolean - whether to make the chart responsive to window resizing
      responsive           : true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio  : false,
      onAnimationProgress: drawSegmentValues
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var myPieChart=pieChart.Pie(PieData, pieOptions);
    var radius = myPieChart.outerRadius;
    function drawSegmentValues()
      {
          for(var i=0; i<myPieChart.segments.length; i++) 
          {
              ctx.fillStyle="white";
              var textSize = canvas.width/20;
              ctx.font= textSize+"px Verdana";
              // Get needed variables
              var value = myPieChart.segments[i].value;
              var startAngle = myPieChart.segments[i].startAngle;
              var endAngle = myPieChart.segments[i].endAngle;
              var middleAngle = startAngle + ((endAngle - startAngle)/2);

              // Compute text location
			  //Untuk Donat
              //var posX = ((radius/2)+(radius/4)) * Math.cos(middleAngle) + midX;
              //var posY = ((radius/2)+(radius/4)) * Math.sin(middleAngle) + midY;
			  var posX = (radius/2) * Math.cos(middleAngle) + midX;
              var posY = (radius/2) * Math.sin(middleAngle) + midY;
              //console.log(radius);
              // Text offside by middle
              var w_offset = ctx.measureText(value).width/2;
              var h_offset = textSize/4;

              ctx.fillText(value, posX - w_offset, posY + h_offset);
          }
      }
  }
  function ajaxchartConfigAbsen(truefalse2){
      $.ajax({  
        url:"pages/fetchdata/fetch_chart-absenhariini.php",  
        method:"POST",   
        dataType:"json",  
        success:function(data){ 
          chartConfigAbsen(data,truefalse2);
          //setTimeout(function(){ajaxchartConfigAbsen(false);}, 10000);
        }  
      });
    }
    
	// PIE CHART ABSENSI HARI INI
	
	//Line CHART Total Absensi
  function chartConfigTotalAbsen(dataTotalAbsen){
      var bar = new Morris.Bar({
        element: 'absen-chart',
        resize: true,
        parseTime: false,
        data: dataTotalAbsen,
        xkey: 'Bulan',
        ykeys: ['hadir','sakit','izin','cuti','alpha'],
        yLabelFormat: function (y) { return y.toString() + ' hari'; },
        labels: ['Hadir','Sakit','Izin','Cuti','Alpha'],
        barColors: ['#00c0ef','#f56954','#f39c12','#00a65a','#c0c0c0']   
      });
    }
    function ajaxchartConfigTotalAbsen(){
        $.ajax({  
          url:"pages/fetchdata/fetch_chart-totalabsensi.php",  
          method:"POST",   
          dataType:"json",  
          success:function(data){
            //console.log(data);
            chartConfigTotalAbsen(data);
            //setTimeout(function(){ajaxchartConfigTotalAbsen();}, 30000);
          }  
        });
      }
      
	// END Line CHART Total Absensi
	
  // CHART TOTAL CREDITS
  function configChartCredit(dataCredits){
      var line = new Morris.Line({
      element: 'credit-chart',
      resize: true,
	    parseTime: false,
    
      data: dataCredits,
      xkey: 'Bulan',
      ykeys: ['Total'],
      
      yLabelFormat:function (y) {var formatter = new Intl.NumberFormat('id-ID', {
                                  style: 'currency',
                                  currency: 'IDR',
                                  minimumFractionDigits: 0,
                                });
                                return formatter.format(y.toString()); },
      labels: ['Total'],
	    lineColors: ['#3c8dbc'],
      hoverCallback: function (index, options, content) {
                              var formatter = new Intl.NumberFormat('id-ID', {
                                  style: 'currency',
                                  currency: 'IDR',
                                  minimumFractionDigits: 0,
                                });
                                var uang= options.data[index].Total;
                                var uang2= formatter.format(uang.toString());
                                return '<div style="color:#3c8dbc;">' + uang2 + '</div>';
                            }
        
      });
    }
    function ajaxconfigChartCredit(){
      $.ajax({
        type: "post",
        url: "pages/fetchdata/fetch_chart-total-credit.php",
        dataType: "json",
        success: function (data) {
          configChartCredit(data)
        }
      });
    }
  // END CHART TOTAL CREDITS
  
  // CHART TOTAL OPERASIONAL
  function chartTotalOperasinal(dataTotalOperasional){
        var line = new Morris.Line({
            element: 'chart-pembayaran-operasional',
            resize: true,
            parseTime: false,
            data: dataTotalOperasional,
            lineColors: ['#00a65a'],
            xkey: 'Bulan',
            ykeys: ['Total'],
            yLabelFormat:function (y) {var formatter = new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        minimumFractionDigits: 0,
                                      });
            return formatter.format(y.toString()); },
            labels: ['Total'],
            hoverCallback: function (index, options, content) {
                                    var formatter = new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        minimumFractionDigits: 0,
                                      });
                                      var uang= options.data[index].Total;
                                      var uang2= formatter.format(uang.toString());
                                      return '<div style="color:#00a65a;">' + uang2 + '</div>';
                                  }
          });
      }
      function ajaxChartTotalOperasinal(){
        $.ajax({
          type: "POST",
          url: "pages/fetchdata/fetch_chart-total-operasional.php",
          dataType: "json",
          success: function (data) {
            //console.log(data);
            chartTotalOperasinal(data);
          }
        });
      }
  // END CHART TOTAL OPERASIONAL

	// Progress BAR ABSENSI HARI INI
	function ajaxProgressAbsenHariIni(){
        $.ajax({  
          url:"pages/fetchdata/fetch_progress-bar-hari-ini.php",  
          method:"POST",   
          dataType:"json",  
          success:function(data){
            $('#progres-absen-hari-ini').css({'width':+data.persen+'%'});
            $('#progres-absen-hari-ini').attr("class","progress-bar progress-bar-striped "+data.warna);
            $('#progres-absen-hari-ini').text(data.persen+"%");
            //setTimeout(function(){ajaxProgressAbsenHariIni();}, 8000);
          }  
        });
      }
	// END Progress BAR ABSENSI HARI INI
 
  //Panggil Semua Fungsi
  ajaxProgressAbsenHariIni();
  ajaxchartConfigAbsen(true);
  ajaxchartConfigTotalAbsen();
  ajaxconfigChartCredit();
  ajaxConfigChartJumlahOperasional();
  ajaxChartTotalOperasinal();
  //Jika Terjadi Resize
  $(window).resize(function() {
    //resize just happened, pixels changed
    ajaxchartConfigAbsen(false);
  });
  //End Jika Terjadi Resize

  //Jika Ada data permbaruan absensi, maka server push data update Dashboard ke client
	//Socket IO
	var socket = io.connect("https://localhost:3000");
	    socket.on("submit_baru", function (data) {
			  //console.log(data);
        ajaxProgressAbsenHariIni();
        ajaxchartConfigAbsen(false);
        ajaxchartConfigTotalAbsen();
        ajaxconfigChartCredit();
        ajaxConfigChartJumlahOperasional();
        ajaxChartTotalOperasinal();
	    });
	//End Socket IO
 });