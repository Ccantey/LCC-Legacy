//core business logic
var map, bounds, LandAcquisitions, overlayLayers={}, switchMap = {};
//map Layers
var pushPinMarker, grayBasemap, streetsBasemap, satelliteBasemap, selectedIcon;
//map overlay layers... called like overlayLayers.CongressionalBoundaryLayer
var previousSelection = [];
var geocoder = null;


//Set initial basemap with init() - called in helper.js
function init () {

    var southWest = L.latLng(41.86956, -105.7140625),
        northEast = L.latLng(50.1487464, -84.202832);
    bounds = L.latLngBounds(southWest, northEast);

    map = L.map("map", {
        center: L.latLng(46.1706, -94.9678),
        maxBounds: bounds,
        zoom: 7
    });
    geocoder = new google.maps.Geocoder;

    // Add gray basemap
    grayBasemap = L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoiY2NhbnRleSIsImEiOiJjaWVsdDNubmEwMGU3czNtNDRyNjRpdTVqIn0.yFaW4Ty6VE3GHkrDvdbW6g', {
        maxZoom: 18,
        minZoom: 6,
        zIndex: 1,
        attribution: 'Basemap data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a>, ' +
                'Legislative data &copy; <a href="http://www.gis.leg.mn/">LCC-GIS</a>, ' +
                'Imagery Â© <a href="http://mapbox.com">Mapbox</a>',
        id: 'mapbox.light'
    }).addTo(map);

    // Add streets basemap
    streetsBasemap = L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoiY2NhbnRleSIsImEiOiJjaWVsdDNubmEwMGU3czNtNDRyNjRpdTVqIn0.yFaW4Ty6VE3GHkrDvdbW6g', {
        maxZoom: 18,
        minZoom: 6,
        zIndex: 1,
        attribution: 'Basemap data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a>, ' +
                'Legislative data &copy; <a href="http://www.gis.leg.mn/">LCC-GIS</a>, ' +
                'Imagery Â© <a href="http://mapbox.com">Mapbox</a>',
        id: 'mapbox.streets'
    });

    // Add satellite basemap
    satelliteBasemap = L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoiY2NhbnRleSIsImEiOiJjaWVsdDNubmEwMGU3czNtNDRyNjRpdTVqIn0.yFaW4Ty6VE3GHkrDvdbW6g', {
        maxZoom: 18,
        minZoom: 6,
        zIndex: 1,
        attribution: 'Basemap data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a>, ' +
                'Legislative data &copy; <a href="http://www.gis.leg.mn/">LCC-GIS</a>, ' +
                'Imagery Â© <a href="http://mapbox.com">Mapbox</a>',
        id: 'mapbox.streets-satellite'
    });

    // Add LandAq data
    $.getJSON("php/getOverlayLayersAsGeoJSON.php", function (data) {

        LandAcquisitions = L.geoJson(data, {
            //style:myStyle,
            pointToLayer: function (feature, latlng) {
                // alternatively use image icons - i prefer divIcons for styling
                // var deselectedIcon = L.icon({iconUrl: 'images/pushpin.png'});
                // var selectedIcon = L.icon({iconUrl:'images/selectedpushpin.png'});
                deselectedIcon = L.divIcon({className: 'deselected-icon', html: "<div class='divtext'>" + feature.properties.lccmrid + "</div>"});
                
                pushPinMarker = L.marker(latlng, {icon: deselectedIcon})
                    .on('click', function (e) {
                    	var selectedProperty = e.target;
                        showParcelTable(selectedProperty);
                    }); //end onclick
                return pushPinMarker;
            } //end pointToLayer method
        }) //end LandAcquisition object
    }).done( function (e) {  //end $.geoJSON begin leaflet cluster group next
            var clusters = L.markerClusterGroup({
                spiderfyOnMaxZoom:false,
                disableClusteringAtZoom: 16,
                polygonOptions: {
                    color: '#ae4b37',
                    weight: 4,
                    opacity: 1,
                    fillOpacity: 0.5
            },
                // this method defines how the graduated symbol clusters are created
                iconCreateFunction: function (cluster) {
                    // get the number of items in the cluster
                    var count = cluster.getChildCount();
                    // figure out how many digits long the number is
                    var scale;
                    // Set graduated symbol scaling
                    if (count <= 10) {
                    	scale = 1;
                    }
                    if (count > 10 && count <= 33) {
                    	scale = 2;
                    }
                    if (count > 33 && count <= 50) {
                    	scale = 3;
                    }
                    if (count > 50) {
                    	scale = 4;
                    }
                    // return a new L.DivIcon with our classes so we can
                    // style them with CSS. You have to set iconSize to null
                    // if you want to use CSS to set the width and height.
                    return new L.divIcon({
                        html: count,
                        className:'cluster scale-' + scale,
                        iconSize: null
                    });
                } //end iconCreateFunction method
            }); //end clusters object
            clusters.addLayer(LandAcquisitions);
            clusters.addTo(map);
    }); //getJson
    //toggleBaseLayers($('#graylayeronoffswitch'),grayBasemap,streetsBasemap);
} //end init()

function showParcelTable (selection) {
    var html = "";
    $('#propertyinfo').show();
    $('#noshow').hide();
    $('#data').html(html);
    //console.log(selection);
    for (prop in selection.feature.properties) {
    	//console.log(prop)
    	if (prop === 'lccmrid') {
            html += "<tr><th>" + prop + ": </th><td><a href='http://www.lccmr.leg.mn/LandAcquisitions/Initial_Report_PDFs/" + selection.feature.properties[prop] + ".pdf' target = '_blank'>" + selection.feature.properties[prop] + "</a></td></tr>";
        }
    	if (prop !== 'memid' && prop !== 'lccmrid') {
            html += "<tr><th>" + prop + ": </th><td>" + selection.feature.properties[prop] + "</td></tr>";
        }        
    };
    $('#data').append(html);
	showSelectedIcon(selection);
}

function showSelectedIcon (selection) {	
    //display the correct id, otherwise displays current selection to previous selection point	
    previousSelection.push(selection.feature.properties.lccmrid);

    toggleIcon(2);

    selectedIcon = L.divIcon({className: 'selected-icon', html: "<div class='divtext'>" + selection.feature.properties.lccmrid + "</div>"});

    selection.setIcon(selectedIcon);
    //load geojson parcel, make available only at scale below x, zoom to it, if zoom out back to selectedIcon
    loadParcel(selection.feature.properties.lccmrid)
}

//common task, requires the last index of array - if a property is selected only once before clearmap(), throws an error
//so index will always be either 1 or 2
//give a selected appearance to point data
function toggleIcon (index) {
	LandAcquisitions.eachLayer(function (layer) {
        //toggle navigation tab
        navTab('results', $("li[data-navlist-id='results']"));
        if (layer.options.icon.options.className === "selected-icon") {
            deselectedIcon = L.divIcon({className: 'deselected-icon', html: "<div class='divtext'>" + previousSelection[previousSelection.length - index] + "</div>"});
            layer.setIcon(deselectedIcon);
        }
    });
}

function loadParcel (id) {
	var lccmrid = {id:id};
	$.ajax("php/getParcelData.php", {
		data: lccmrid,
		success: function(result){			
			showParcel(result);
		}, 
		error: function(){
			console.log('error');
		}
	});
}

function showParcel (d) {
    // console.log(d);
    if (typeof parcelGeoJSON !== "undefined" ){ 
        map.removeLayer(parcelGeoJSON);			
    }
    //parcel polygon overlay styling
    var myStyle = {
        "color": "#991a36",
        "weight": 2,
        "opacity": 0.65
    };
    parcelGeoJSON = L.geoJson(d, {
        style:myStyle
    }).addTo(map);
    //zoom to selection
    $('#data').show();
    var parcelBounds = parcelGeoJSON.getBounds();
    map.fitBounds(parcelBounds, {maxZoom:14});
}

function navTab (id, tab) {
    $("li.navlist").removeClass("active");
    $(tab).addClass("active");
    $("#search, #layers, #results, #lccmr").hide();
    openSidebar();
    $('.leaflet-left').css('left', '330px');
    switch (id) {
    case "search":
        $('#' + id).show();
        break;
    case "layers":
        $('#' + id).show();
        break;
    case "results":
        $('#' + id).show();
        break;
    case "lccmr":
        $('#' + id).show();
        break;
    }
}
function clearmap () {
    $('#propertyinfo').hide();
    $('#noshow').show();
    $('#data').hide();	
	map.fitBounds(bounds).setZoom(7);
	toggleIcon(1);
    $('.locationzoom').prop('selectedIndex',0);
	resetLayers();
	toggleLayerSwitches();
	$('.layernotification').hide();// hide notificaions and set their values = 0
    $('#geocodeFeedback').hide();

}

function resetLayers() {
    if (typeof parcelGeoJSON !== "undefined" ){
        map.removeLayer(parcelGeoJSON);
        delete parcelGeoJSON;
    };
    if (typeof selectionGeoJSON !== "undefined" ){
        map.removeLayer(selectionGeoJSON);
        delete selectionGeoJSON;
    }pushPinMarker
    if (typeof pushPinMarker !== "undefined" ){
        map.removeLayer(pushPinMarker);
        delete pushPinMarker;
    }
    $('.layernotification').hide();
    //Remove all layers except the basemap -- down here because its an asychronous thead apparently
    map.eachLayer(function(layer){
        //Remove map layers except mapbox
        if (typeof layer.defaultWmsParams !== "undefined"){
            map.removeLayer(layer);             
        };  
    });
}
function toggleLayerSwitches (){
    var inputs = $(".onoffswitch-checkbox.overlay");
    for (var i = 0, il = inputs.length; i < il; i++) {
    	var inputsID = '#'+ inputs[i].id;
        if($(inputsID).not(':checked')){
        	$(inputsID).prop('checked', true);
        }         
    }	
    //except 
}

//toggle basemap layers
function toggleBaseLayers(el, gray, street, sat){
 
    var switchid = $(el).attr('id');
    switch (switchid) {
    case "streetslayeronoffswitch":
        map.removeLayer(gray);
        map.removeLayer(sat);
        map.addLayer(street);
        $('#streetslayeronoffswitch').attr("disabled", true);
        $('#graylayeronoffswitch').prop('checked', true).attr("disabled", false);
        $('#satlayeronoffswitch').prop('checked', true).attr("disabled", false);
        break;
    case "graylayeronoffswitch":
        map.removeLayer(street);
        map.removeLayer(sat);
        map.addLayer(gray);
        $('#graylayeronoffswitch').attr("disabled", true);
        $('#streetslayeronoffswitch').prop('checked', true).attr("disabled", false);
        $('#satlayeronoffswitch').prop('checked', true).attr("disabled", false);
        break;
    case "satlayeronoffswitch":
        map.removeLayer(street);
        map.removeLayer(gray);
        map.addLayer(sat);
        $('#satlayeronoffswitch').attr("disabled", true);
        $('#streetslayeronoffswitch').prop('checked', true).attr("disabled", false);
        $('#graylayeronoffswitch').prop('checked', true).attr("disabled", false);
        break;
    }

}
//fetch the overlay layers from WMS, published through FOSS mapserver (mapserver.org) - much faster than fetching large vector datasets through PGIS
function getOverlayLayers(el, switchId){
    $('#loading').show();

    switchMap = {"laonoffswitch": "polygon",
                 "sponoffswitch": "StateParks",
                 "sflayeronoffswitch": "StateForests",
                 "wmalayeronoffswitch": "WildlifeManagementAreas",
                 "snalayeronoffswitch": "ScientificNaturalArea",
                 "wmdlayeronoffswitch": "WetlandManagementDistricts",
                 "bwcalayeronoffswitch": "BoundaryWaterCanoeArea",
                 "nflayeronoffswitch": "NationalForest",
                 "nwrlayeronoffswitch": "NationalWildlifeRefuges",
                 "countylayeronoffswitch": "cty2010", 
                 "citylayeronoffswitch":"mcd2010", 
                 "cononoffswitch":"cng2012", 
                 "senatelayeronoffswitch":"sen2012", 
                 "houselayeronoffswitch":"hse2012_1"}
    // console.log(typeof switchMap[switchId]);
   
    if(el.is(':checked')){
    	map.removeLayer(overlayLayers[switchMap[switchId]]);
        $('.leaflet-marker-icon.'+switchMap[switchId]).hide();
		$('#loading').hide();
    } else {
    	$('.leaflet-marker-icon.'+switchMap[switchId]).show();
        //console.log(switchMap[switchId]);
    	if(typeof overlayLayers[switchMap[switchId]] === 'undefined'){
            if (switchMap[switchId] === 'polygon'){
            	
				overlayLayers[switchMap[switchId]].addTo(map);

            } else {

    		overlayLayers[switchMap[switchId]] = L.tileLayer.wms('/cgi-bin/mapserv?map=/web/gis/iMaps/LCCMR/landAcq/data/mapserver.map', {
			    format: 'image/png',
			    transparent: false,
			    minZoom: 6,
			    zIndex: 3,
                crs:L.CRS.EPSG4326,
			    layers: switchMap[switchId]
			}).addTo(map);
			$('#loading').hide();
            }
		} else {
			overlayLayers[switchMap[switchId]].addTo(map);
			$('#loading').hide();
		}
    }
}

//select form queries
//could pass this in from 3rd party as: http://ww2.commissions.leg.state.mn.us/gis/iMaps/LCCMR-LA/php/getSelectionData.php?db=hse2012_1&val=08A&col=district
function getSelectLayer(val, db) {
    //console.log(val, db);
    var columnMap = {"cty2010":"name","hse2012_1":"district", "sen2012":"district"};
    var q = {db:db, val:val, col:columnMap[db]};
    $.ajax("php/getSelectionData.php", {
        data: q,
        success: function(result){          
            zoomToSelection(result, db);
        }, 
        error: function(){
            console.log('error');
        }
    });
}

function zoomToSelection(d, db) {
    //console.log(d);
    toggleLayerSwitches();
    resetLayers();
    $('.layernotification').hide()
    //parcel polygon overlay styling
    var myStyle = {
        "clickable":false,
        "color": "#333",
        "weight": 2,
        "opacity": 0.65
    };
    selectionGeoJSON = L.geoJson(d, {
        style:myStyle
    }).addTo(map);
    //zoom to selection
    $('#data').show();
    var parcelBounds = selectionGeoJSON.getBounds();
    map.fitBounds(parcelBounds, {maxZoom:14});

    //delete all lines below to remove layer/switch toggle on search by:
    var reverseSwitchMap = { "cty2010": "countylayeronoffswitch", 
                             "sen2012": "senatelayeronoffswitch", 
                             "hse2012_1": "houselayeronoffswitch"}

    //check the switch box
    if ($('#'+reverseSwitchMap[db]).is(':checked')===true){
        $('#'+reverseSwitchMap[db]).prop('checked', false);
    }
    //add notification
    var parents = $('#'+reverseSwitchMap[db]).parents();
    var mapLayersTab = parents.parents();
    addNotifications($('[data-layerlist-id='+mapLayersTab[0].id+']'));

    //turn on layers
    getOverlayLayers($(reverseSwitchMap[db]), reverseSwitchMap[db])
}

function openSidebar(){
    if ($('.sidebar').hasClass('closed')){
        $('.sidebar').removeClass('closed');
        $('.sidebar').animate({ 'left': '48px' }, { duration: 300, queue: false });
        $('.leaflet-left').animate({ 'left': '330px' }, { duration: 433, queue: false });        
    } 
}

function closeSidebar(){
    if ($('.sidebar').hasClass('closed')){
        $('.sidebar').removeClass('closed');
        $('.sidebar').animate({ 'left': '48px' }, 500);
    } else {
        $('.leaflet-left').animate({ 'left': '48px' }, 300);
        $('.sidebar').addClass('closed');
        $('.sidebar').animate({ 'left': '-100%' }, 500);
    }
}


function addNotifications(el){
      //console.log(el);
      var notificationCount = 0;
      var notification = $(el).find('.layernotification');
       //will assign that number
      notification.hide();
      var layerTabId = '#' + $(el).data('layerlist-id');
      var layerSwitches = $(layerTabId).find('.onoffswitch');
      for (var i = 0, il = layerSwitches.length; i < il; i++) {
        var toggleId = '#'+layerSwitches[i].id;
        //console.log(toggleId)
        if ($(toggleId).children().is(':checked')===false){
            notification.show();
            //console.log($(toggleId).selector);
            notificationCount += 1;
        } else {
          //notification.hide();
        }    
      }
      notification.html(notificationCount);
}

function geoCodeAddress(geocoder, resultsMap) {
  var address = document.getElementById('addressSearch').value;
  $("#loading").show();

  //clear searchboxes
  var selections = ['#cty2010', '#hse2012_1', '#sen2012'];
   for (var i = 0, il = selections.length; i < il; i++) {        
          $(selections[i]).prop('selectedIndex', 0);
    }      
      

  geocoder.geocode({'address': address}, function(results, status) {
    if (status === google.maps.GeocoderStatus.OK) {
      var precision = results[0].geometry.location_type;
      var components = results[0].address_components;
      var pos = {
        latlng: {lat:results[0].geometry.location.lat(),lng:results[0].geometry.location.lng()},
        lat:results[0].geometry.location.lat(),
        lng:results[0].geometry.location.lng()
      };
      // console.log(pos.lat);
      // console.log(pos.lng);
      map.setView(L.latLng(pos.lat,pos.lng),13);
      toggleLayerSwitches();
      resetLayers();
      addMarker(pos);
      
      geocodeFeedback(precision, components);
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
      $('#loading').hide();
    }
  });
}

function geocodeFeedback(precision, components){
    //console.log(precision, 'location, center of ', components[0].types[0]);
    var message = "";
    var componentMap = {"street_number": "street", "postal_code": "zip code", "administrative_area_level_1": "state", "locality": "city", "administrative_area_level_2": "county", "route": "route", "intersection": "intersection", "political": "political division", "country": "country","administrative_area_level_3": "minor civil division", "administrative_area_level_4": 'minor civil division', "administrative_area_level_5": "minor civil division", "colloquial_area": "country", "neighborhood": "neighborhood", "premise": "building", "subpremise": "building", "natural_feature": "natural feature", "airport": "airport", "park": "park", "point_of_interest": "point of interest"};

    if (precision == "ROOFTOP"){
        message = "Address match!";
        $('#geocodeFeedback').html(message).css('color', 'green');
        $('#geocodeFeedback').show();
    } else {
        message = "Approximate location! Center of " + componentMap[components[0].types[0]];
        $('#geocodeFeedback').html(message).css('color', 'red');
        $('#geocodeFeedback').show();
    }
    
    
}

function addMarker(e){
    //remove sidebar formatting

    //remove old pushpin and previous selected district layers 
    if (typeof pushPinMarker !== "undefined" ){ 
        map.removeLayer(pushPinMarker);         
    }
    //add marker
    pushPinMarker = new L.marker(e.latlng).addTo(map);
}

//submit search text box - removed button for formatting space
function keypressInBox(e) {
    var code = (e.keyCode ? e.keyCode : e.which);
    if (code == 13) { //Enter keycode                        
        e.preventDefault();
        dataLayer.push({'event': 'enterKeyGeocode'});
        geoCodeAddress(geocoder, map);
    }
};