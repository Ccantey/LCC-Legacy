$(function() { 

  //initial 'active' states
  $("#physicalSwitches, #naturalSwitches, #basemap").hide();
  $("#sidebarHelp, #mapToolsHelp").hide();
  $('.layernotification').hide();

  //activate tooltips
  $('[data-toggle="tooltip"]').tooltip();

  //reset toggles if someone hits refresh
  $('#laonoffswitch,#sponoffswitch,#sflayeronoffswitch,#wmalayeronoffswitch,#wmdlayeronoffswitch,' +
     '#snalayeronoffswitch,#wmdlayeronoffswitch,#bwcalayeronoffswitch,#nflayeronoffswitch,#nwrlayeronoffswitch,#countylayeronoffswitch,' +
     '#cononoffswitch, #senatelayeronoffswitch, #houselayeronoffswitch, #citylayeronoffswitch, #satlayeronoffswitch, #streetslayeronoffswitch').prop('checked', true);

  //set basemap toggle/notification
  $('#graylayeronoffswitch').prop('checked', false);
  addNotifications($('[data-layerlist-id="basemap"]'));

  //load map layers
  init();

  //filter layers on checkboxes
  $('#layercontrols input').click(function(){
      refreshLegacy();
  });

  // both key and enter fire geoCodeAddress
    $('#addressSearchButton').click(function(e){
      e.preventDefault();
      address = document.getElementById('addressSearch').value;
      geoCodeAddress(geocoder, map, address);
    });

  //Populate Search Select Boxes 
  $.getJSON("php/getCounty.php",function(data){
      var items="";
      items = "<option value='' selected>County</option>";
      for (i in data.features) {
        var option = data.features[i].properties.name;
        items+="<option value='"+option+"'>"+option+"</option>";
      }
      $("#cty2010").html(items); 
    });

    //Populate Search Select Boxes
    $.getJSON("php/getSenate.php",function(data){
      var items="";
      items = "<option value='' selected>Senate District</option>";
      for (i in data.features) {
        var option = data.features[i].properties.district;
        items+="<option value='"+option+"'>"+option+"</option>";
      }
      $("#sen2012").html(items); 
    });

    //Populate Search Select Boxes
    $.getJSON("php/getHouse.php",function(data){
      var items="";
      items = "<option value='' selected>House District</option>";
      for (i in data.features) {
        var option = data.features[i].properties.district;
        //console.log(data.features[i].properties.name);
        items+="<option value='"+option+"'>"+option+"</option>";
      }
      $("#hse2012_1").html(items); 
    });

    // select form events
    $('.locationzoom').change(function (e){
      var targetId = "#" + this.id;
      var selections = ['#cty2010', '#hse2012_1', '#sen2012'];

      //reset other select boxes
      for (var i = 0, il = selections.length; i < il; i++) {
        if (targetId !== selections[i]){
          $(selections[i]).prop('selectedIndex', 0);
        }
      }
      //pass to getSelectLayer
      $( targetId ).each(function() {
          getSelectLayer( $( this ).val(), this.id);
      });
    });//END select form helpers

  //Dark Gray (far left) sidebar navigation
 $('.navlist').click(function(e){
  	navTab($(this).data('navlist-id'), this);
  });

  //map layers navigation
  $('.layersli').click(function(e){
  	var id = $(this).data('layerlist-id');
  	$("#politicalSwitches, #physicalSwitches, #naturalSwitches, #basemap").hide();
  	$('#'+id).show();
    $("li.layersli").removeClass("active");
  	$( this ).addClass( "active" );
  });

  //map layers navigation
  $('.helpli').click(function(e){
    var id = $(this).data('helplist-id');
    $("#mapNavHelp, #sidebarHelp, #mapToolsHelp").hide();
    $('#'+id).show();
    // console.log($( this ))
    $("li.helpli").removeClass("active");
    $( this ).addClass( "active" );
  });

  $('.first').click(function(){
    clearmap();
    navTab('search', $("li[data-navlist-id='search']"));
    //clearmap();
  });

      //fetch overlay layers
  $('#laonoffswitch,#sponoffswitch,#sflayeronoffswitch,#wmalayeronoffswitch,#wmdlayeronoffswitch,' +
     '#snalayeronoffswitch,#wmdlayeronoffswitch,#bwcalayeronoffswitch,#nflayeronoffswitch,#nwrlayeronoffswitch,#countylayeronoffswitch,' +
     '#cononoffswitch, #senatelayeronoffswitch, #houselayeronoffswitch, #citylayeronoffswitch').click(function(){
       //console.log($(this), $(this).attr('id'));
        getOverlayLayers($(this), $(this).attr('id'));
        // console.log($(this));
        var parents = $(this).parents();
        var mapLayersTab = parents.parents();
        //console.log(two[0].id)
        addNotifications($('[data-layerlist-id='+mapLayersTab[0].id+']'));
  });
     
  $('#graylayeronoffswitch, #streetslayeronoffswitch, #satlayeronoffswitch').click(function(){
      //getBasemapLayer($(this), $(this).attr('id'));
      toggleBaseLayers($(this), grayBasemap, streetsBasemap, satelliteBasemap);
  });

  $('.closetab').click(function(){
    closeSidebar();
  });

  $('#legendToggle').click(function(){
    $('#legend').toggle();
  });
  // $('.legendhover').hover(function(e){
  //   var popupMap = {'artsandculture':'Arts & Cultural Heritage Fund', 'cleanwater':'Clean Water Fund', 'outdoorheritage':'Outdoor Heritage Fund','parksandtrails':'Parks & Trails Fund','enrtf':'Environment & Natural Resources Trust Fund'}
  //   var classList = $(this).attr('class').split(/\s+/);
  //   console.log(classList[2])
  // });

  console.log("Welcome to the 'Legacy Ammendment Projects' Mapping Application, developed by the MN State Legislative Coordinating Commission GIS. The application's responsive web design(RWD), open-source code can be found at 'https://github.com/LegislativeCoordinatingCommissionGIS'.")
});