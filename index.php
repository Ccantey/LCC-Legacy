<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, minimal-ui, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="description" content="Interactive mapping tool for Environment and Natural Resources Trust Fund funded fee Legacy Amendment projects.">
	<meta name="author" content="Leg. Coordinating Commission GIS">
	<meta name="keywords" content="Legacy, LCCMR, LCC, ENRTF, MNDNR">
    <!--Facebook Share customization open graph meta tags. https://developers.facebook.com/tools/debug/og/object/-->
    <meta property="fb:app_id" content="944707115597875" />
	<meta property="og:url"                content="http://www.gis.leg.mn/iMaps/Legacy/" />
	<meta property="og:type"               content="website" />
	<meta property="og:title"              content="Legacy Amendment Projects Map" />
	<meta property="og:description"        content="Interactive mapping tool for Environment and Natural Resources Trust Fund funded fee title and conservation easement land acquisitions." />
	<meta property="og:image"              content="http://www.gis.leg.mn/iMaps/Legacy/images/legacy_logo_rgb.jpg" />
    
    <!-- favicon and iPhone icon -->
    <link rel="apple-touch-icon" href="http://www.gis.leg.mn/iMaps/Legacy/images/legacy_logo_rgb.jpg">
    <link rel="icon" href="images/favicon.ico">

    <!-- mapping stylesheets -->
    <link href='https://api.mapbox.com/mapbox.js/v2.3.0/mapbox.css' rel='stylesheet' />
    <link rel="stylesheet" href="css/MarkerCluster.css"/>

    <!-- Bootstrap, fontawesome, google fonts core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,400italic,700' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this application -->
    <link href="css/app.css" rel="stylesheet">

    <!-- geocoding api -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqo2j28SDRSRhrCJJFvesI8PBTzb0NipA" ></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <!-- <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet"> -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <title>Legacy</title>
  </head>

  <body>

    <div class="container">

        <div class="row">
         
        <!--sideNav -->
	        <div id="navtabs">
	        	<ul class="nav nav-sidebar">
	            <li class="navlist active" data-navlist-id="search"><a class="navtext"><i class="fa fa-search fa-lg"></i>Search</a></li>
	            <li class="navlist" data-navlist-id="layers"><a class="navtext"><i class="fa fa-map fa-lg"></i>Layers</a></li>
	            <li class="navlist" data-navlist-id="results"><a class="navtext"><i class="fa fa-database fa-lg"></i>Results</a></li>
	            <li class="navlist" data-navlist-id="lccmr"><a class="navtext"><i class="fa fa-question-circle fa-2x"></i> Help </a></li>
	          </ul>
	        </div>

            <!-- begin sidebar -->
	        <div class="col-sm-3 col-md-2 sidebar">

			<!-- - - - - - - - - - - - - Sidebar/Search Div - - - - - - - - - - - - -->
	          <div id="search">
	          <div class='closetab'><i class="fa fa-caret-square-o-left fa-lg"></i></div>
	            <div class="navtitle">Search Projects</div>
		            <div class="searchform">
						<form id='mainsearchform' onsubmit="geoCodeAddress();">
						  <div class="form-group">
						    <label for="addressSearch">Search by Address</label>
						    <input type="text" class="form-control" id="addressSearch" placeholder="Address"><button id="addressSearchButton" type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
						    <p id="geocodeFeedback"></p>
						  </div>
						 </form>
					 </div>

					  <div class="selectform">
						<form>
						  <div class="form-group">
						    <label for="addressSearch">Search by:</label>
						    <select class="form-control locationzoom" id="cty2010">					  
                               <!-- Loaded in helper.js -->
							</select>

							<select class="form-control locationzoom" id="hse2012_1">
                               <!-- Loaded in helper.js -->
							</select>
                                
							<select class="form-control locationzoom" id="sen2012">
                               <!-- Loaded in helper.js -->
							</select>


							<div id="replink">
							   <a  href="http://www.gis.leg.mn/OpenLayers/districts/" target="_blank">Who Represents Me?</a>
							</div>
						  </div>
						 </form>
					 </div>
                      
					 <form id = "layercontrols" class="selectform">
                        <div style="font-weight: 600;">Filter by funding type:</div>
                         
                      <div class="legacygroup">Legacy Amendment</div>
                      <div id="artsdiv" class="onoffswitch filter">
				      <input type="checkbox" name='filters'  class="onoffswitch-checkbox legacy" id="artslayeronoffswitch" value="Arts & Cultural Heritage Fund">
					    <!-- <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked> -->
					    <label class="onoffswitch-label" for="artslayeronoffswitch">
					    <!-- <label class="onoffswitch-label" for="myonoffswitch"> -->
					        <span class="onoffswitch-inner"></span>
					        <!-- <span class="onoffswitch-inner"></span> -->
					        <span class="onoffswitch-switch"></span>
					        <!-- <span class="onoffswitch-switch"></span> -->
					    </label>
					  </div>
					  <div class='layersswitchLabel'><div class="leaflet-marker-icon artsandculture" style="margin-left:-22px;"></div>Arts & Cultural Heritage Fund</div>

					    <div id="cleanwaterdiv" class="onoffswitch filter">
				      <input type="checkbox" name="filters" class="onoffswitch-checkbox legacy" id="cleanwaterlayeronoffswitch" value="Clean Water Fund">
					    <!-- <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked> -->
					    <label class="onoffswitch-label" for="cleanwaterlayeronoffswitch">
					    <!-- <label class="onoffswitch-label" for="myonoffswitch"> -->
					        <span class="onoffswitch-inner"></span>
					        <!-- <span class="onoffswitch-inner"></span> -->
					        <span class="onoffswitch-switch"></span>
					        <!-- <span class="onoffswitch-switch"></span> -->
					    </label>
					  </div>
					  <div class='layersswitchLabel'><div class="leaflet-marker-icon cleanwater" style="margin-left:-22px;"></div>Clean Water Fund</div>

					    <div id="outdoordiv" class="onoffswitch filter">
				      <input type="checkbox" name="filters" class="onoffswitch-checkbox legacy" id="outdoorlayeronoffswitch" value="Outdoor Heritage Fund">
					    <!-- <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked> -->
					    <label class="onoffswitch-label" for="outdoorlayeronoffswitch">
					    <!-- <label class="onoffswitch-label" for="myonoffswitch"> -->
					        <span class="onoffswitch-inner"></span>
					        <!-- <span class="onoffswitch-inner"></span> -->
					        <span class="onoffswitch-switch"></span>
					        <!-- <span class="onoffswitch-switch"></span> -->
					    </label>
					  </div>
					  <div class='layersswitchLabel'><div class="leaflet-marker-icon outdoorheritage" style="margin-left:-22px;"></div>Outdoor Heritage Fund</div>

					    <div id="parksdiv" class="onoffswitch filter">
				      <input type="checkbox" name="filters" class="onoffswitch-checkbox legacy" id="parkslayeronoffswitch" value="Parks & Trails Fund">
					    <!-- <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked> -->
					    <label class="onoffswitch-label" for="parkslayeronoffswitch">
					    <!-- <label class="onoffswitch-label" for="myonoffswitch"> -->
					        <span class="onoffswitch-inner"></span>
					        <!-- <span class="onoffswitch-inner"></span> -->
					        <span class="onoffswitch-switch"></span>
					        <!-- <span class="onoffswitch-switch"></span> -->
					    </label>
					  </div>
					  <div class='layersswitchLabel'><div class="leaflet-marker-icon parksandtrails" style="margin-left:-22px;"></div>Parks & Trails Fund</div>
                    <div class="legacygroup">Trust Fund Amendment</div>
					<div id="enrtfdiv" class="onoffswitch filter">
				      <input type="checkbox" name="filters" class="onoffswitch-checkbox legacy" id="enrtflayeronoffswitch" value="Environment & Natural Resources Trust Fund">
					    <!-- <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked> -->
					    <label class="onoffswitch-label" for="enrtflayeronoffswitch">
					    <!-- <label class="onoffswitch-label" for="myonoffswitch"> -->
					        <span class="onoffswitch-inner"></span>
					        <!-- <span class="onoffswitch-inner"></span> -->
					        <span class="onoffswitch-switch"></span>
					        <!-- <span class="onoffswitch-switch"></span> -->
					    </label>
					  </div>
                      <div class='layersswitchLabel'><div class="leaflet-marker-icon enrtf" style="margin-left:-22px;"></div>Environment & Natural <br>Resources Trust Fund</div>

<!-- 						<div class="checkbox">
						<div class="leaflet-marker-icon artsandculture" style="margin-left:20px;"></div>
						    <label>
						        <input type="checkbox" name='filters' value='Arts & Cultural Heritage Fund' onclick='showClusters()' checked>
                                <span class="fundlabel">Arts & Cultural Heritage Fund</span>
						    </label>
						</div>
						<div class="checkbox"> -->


<!-- 						<div class="leaflet-marker-icon cleanwater" style="margin-left:20px;"></div>
						    <label>
						        <input type="checkbox" name='filters' value='Clean Water Fund' checked>
						        <span class="fundlabel">Clean Water Fund</span>
						    </label>
						</div>
						<div class="checkbox">
						<div class="leaflet-marker-icon enrtf" style="margin-left:20px;"></div>
						    <label>
						        <input type="checkbox" name='filters' value='Environment & Natural Resources Trust Fund' checked>
						        <span class="fundlabel">Environment & Natural Resources Trust Fund</span>
						    </label>
						</div>
						<div class="checkbox">
						<div class="leaflet-marker-icon outdoorheritage" style="margin-left:20px;"></div>
						    <label>
						        <input type="checkbox" name='filters' value='Outdoor Heritage Fund' checked>
						        <span class="fundlabel">Outdoor Heritage Fund</span>
						    </label>
						</div>
						<div class="checkbox">
						<div class="leaflet-marker-icon parksandtrails" style="margin-left:20px;"></div>
						    <label>
						      <input type="checkbox" name='filters' value='Parks & Trails Fund' checked>
						      <span class="fundlabel">Parks & Trails Fund</span>
						    </label>
						</div> -->
					 </form>
	             <div class="logo">
		          	<a href="http://www.legacy.leg.mn/"><img src="images/logo-new.png" alt="logo"/></a>
		        </div>
					 
		        </div> <!-- search -->

                <!-- - - - - - - - - - - - - Sidebar/Layers tab Div - - - - - - - - - - - - - -->
	            <div id="layers" style="display: none">
	            <div class='closetab'><i class="fa fa-caret-square-o-left fa-lg"></i></div>
	            	<div class="navtitle">Map Layers</div>
	            	<ul class="nav navbar-nav layersul">
			            <li class="active layersli rightline verticlealign" data-layerlist-id="politicalSwitches">
			                <a class="navtext-layers" href="#"><div class="layernotification">1</div>Political</a>
			            </li>

			            <li class="layersli rightline verticlealign" data-layerlist-id="physicalSwitches">
			                 <a class="navtext-layers" href="#"><div class="layernotification">1</div>Physical</a>
			            </li>

			            <li class="layersli rightline" data-layerlist-id="naturalSwitches"><a class="navtext-layers" href="#"><div class="layernotification">1</div>Resource Management</a></li>

			            <li class="layersli verticlealign" data-layerlist-id="basemap"><a class="navtext-layers" href="#"><div class="layernotificationConstant">1</div>Basemap</a></li>
		          </ul>
		          <div id="layerswitches">

		            <div id="politicalSwitches">
			          <!-- switches -->
				      <div id="cityLayerdiv" class="onoffswitch">
				      <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox overlay" id="citylayeronoffswitch" checked>
					    <!-- <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked> -->
					    <label class="onoffswitch-label" for="citylayeronoffswitch">
					    <!-- <label class="onoffswitch-label" for="myonoffswitch"> -->
					        <span class="onoffswitch-inner"></span>
					        <!-- <span class="onoffswitch-inner"></span> -->
					        <span class="onoffswitch-switch"></span>
					        <!-- <span class="onoffswitch-switch"></span> -->
					    </label>
					  </div>
					  <div class='layersswitchLabel'>Municipal Boundaries</div>
		              <!-- END CITY SWITCH -->

					  <div id="countyLayerdiv" class="onoffswitch">
				      <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox overlay" id="countylayeronoffswitch" checked>
					    <!-- <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked> -->
					    <label class="onoffswitch-label" for="countylayeronoffswitch">
					    <!-- <label class="onoffswitch-label" for="myonoffswitch"> -->
					        <span class="onoffswitch-inner"></span>
					        <!-- <span class="onoffswitch-inner"></span> -->
					        <span class="onoffswitch-switch"></span>
					        <!-- <span class="onoffswitch-switch"></span> -->
					    </label>
					  </div>
					  <div class='layersswitchLabel'>County Boundaries</div>
		              <!-- END COUNTY SWITCH -->

		              <div id="houseLayerdiv" class="onoffswitch">
				      <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox overlay" id="houselayeronoffswitch" checked>
					    <!-- <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked> -->
					    <label class="onoffswitch-label" for="houselayeronoffswitch">
					    <!-- <label class="onoffswitch-label" for="myonoffswitch"> -->
					        <span class="onoffswitch-inner"></span>
					        <!-- <span class="onoffswitch-inner"></span> -->
					        <span class="onoffswitch-switch"></span>
					        <!-- <span class="onoffswitch-switch"></span> -->
					    </label>
					  </div>
					  <div class='layersswitchLabel'>MN House Districts</div>
		              <!-- END CITY SWITCH -->

					  <div id="senateLayerdiv" class="onoffswitch">
				      <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox overlay" id="senatelayeronoffswitch" checked>
					    <!-- <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked> -->
					    <label class="onoffswitch-label" for="senatelayeronoffswitch">
					    <!-- <label class="onoffswitch-label" for="myonoffswitch"> -->
					        <span class="onoffswitch-inner"></span>
					        <!-- <span class="onoffswitch-inner"></span> -->
					        <span class="onoffswitch-switch"></span>
					        <!-- <span class="onoffswitch-switch"></span> -->
					    </label>
					  </div>
					  <div class='layersswitchLabel'>MN Senate Districts</div>
		              <!-- END COUNTY SWITCH -->

		            </div>  <!-- END POLITICAL GROUP -->


		            <div id="physicalSwitches">
			          <!-- switches -->
				      <div id="snaLayerdiv" class="onoffswitch">
				      <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox overlay" id="snalayeronoffswitch" checked>
					    <!-- <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked> -->
					    <label class="onoffswitch-label" for="snalayeronoffswitch">
					    <!-- <label class="onoffswitch-label" for="myonoffswitch"> -->
					        <span class="onoffswitch-inner"></span>
					        <!-- <span class="onoffswitch-inner"></span> -->
					        <span class="onoffswitch-switch"></span>
					        <!-- <span class="onoffswitch-switch"></span> -->
					    </label>
					  </div>
					  <div class='layersswitchLabel'>Scientific Natural Areas</div>
		              <!-- END CITY SWITCH -->

					  <div id="bwcaLayerdiv" class="onoffswitch">
				      <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox overlay" id="bwcalayeronoffswitch" checked>
					    <!-- <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked> -->
					    <label class="onoffswitch-label" for="bwcalayeronoffswitch">
					    <!-- <label class="onoffswitch-label" for="myonoffswitch"> -->
					        <span class="onoffswitch-inner"></span>
					        <!-- <span class="onoffswitch-inner"></span> -->
					        <span class="onoffswitch-switch"></span>
					        <!-- <span class="onoffswitch-switch"></span> -->
					    </label>
					  </div>
					  <div class='layersswitchLabel'>Boundary Waters Canoe Area</div>
		              <!-- END COUNTY SWITCH -->

		              <div id="sfLayerdiv" class="onoffswitch">
				      <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox overlay" id="sflayeronoffswitch" checked>
					    <!-- <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked> -->
					    <label class="onoffswitch-label" for="sflayeronoffswitch">
					    <!-- <label class="onoffswitch-label" for="myonoffswitch"> -->
					        <span class="onoffswitch-inner"></span>
					        <!-- <span class="onoffswitch-inner"></span> -->
					        <span class="onoffswitch-switch"></span>
					        <!-- <span class="onoffswitch-switch"></span> -->
					    </label>
					  </div>
					  <div class='layersswitchLabel'>State Forest</div>
		              <!-- END CITY SWITCH -->

					  <div id="nfLayerdiv" class="onoffswitch">
				      <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox overlay" id="nflayeronoffswitch" checked>
					    <!-- <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked> -->
					    <label class="onoffswitch-label" for="nflayeronoffswitch">
					    <!-- <label class="onoffswitch-label" for="myonoffswitch"> -->
					        <span class="onoffswitch-inner"></span>
					        <!-- <span class="onoffswitch-inner"></span> -->
					        <span class="onoffswitch-switch"></span>
					        <!-- <span class="onoffswitch-switch"></span> -->
					    </label>
					  </div>
					  <div class='layersswitchLabel'>National Forest</div>
		              <!-- END COUNTY SWITCH -->

		            </div>  <!-- END PHYSICAL GROUP -->


		            <div id="naturalSwitches">
			          <!-- switches -->
				      <div id="wmaLayerdiv" class="onoffswitch">
				      <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox overlay" id="wmalayeronoffswitch" checked>
					    <!-- <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked> -->
					    <label class="onoffswitch-label" for="wmalayeronoffswitch">
					    <!-- <label class="onoffswitch-label" for="myonoffswitch"> -->
					        <span class="onoffswitch-inner"></span>
					        <!-- <span class="onoffswitch-inner"></span> -->
					        <span class="onoffswitch-switch"></span>
					        <!-- <span class="onoffswitch-switch"></span> -->
					    </label>
					  </div>
					  <div class='layersswitchLabel'>Wildlife Management Areas</div>
		              <!-- END CITY SWITCH -->

					  <div id="wmdLayerdiv" class="onoffswitch">
				      <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox overlay" id="wmdlayeronoffswitch" checked>
					    <!-- <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked> -->
					    <label class="onoffswitch-label" for="wmdlayeronoffswitch">
					    <!-- <label class="onoffswitch-label" for="myonoffswitch"> -->
					        <span class="onoffswitch-inner"></span>
					        <!-- <span class="onoffswitch-inner"></span> -->
					        <span class="onoffswitch-switch"></span>
					        <!-- <span class="onoffswitch-switch"></span> -->
					    </label>
					  </div>
					  <div class='layersswitchLabel'>Wetland Management Areas</div>
		              <!-- END COUNTY SWITCH -->

		              <div id="nwrLayerdiv" class="onoffswitch">
				      <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox overlay" id="nwrlayeronoffswitch" checked>
					    <!-- <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked> -->
					    <label class="onoffswitch-label" for="nwrlayeronoffswitch">
					    <!-- <label class="onoffswitch-label" for="myonoffswitch"> -->
					        <span class="onoffswitch-inner"></span>
					        <!-- <span class="onoffswitch-inner"></span> -->
					        <span class="onoffswitch-switch"></span>
					        <!-- <span class="onoffswitch-switch"></span> -->
					    </label>
					  </div>
					  <div class='layersswitchLabel'>National Wildlife Refuge</div>
		              <!-- END CITY SWITCH -->

		            </div>  <!-- END NATURAL GROUP -->



		            <div id="basemap">
			          <!-- switches -->
				      <div id="grayLayerdiv" class="onoffswitch">
				      <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox basemap" id="graylayeronoffswitch" checked>
					    <!-- <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked> -->
					    <label class="onoffswitch-label" for="graylayeronoffswitch">
					    <!-- <label class="onoffswitch-label" for="myonoffswitch"> -->
					        <span class="onoffswitch-inner"></span>
					        <!-- <span class="onoffswitch-inner"></span> -->
					        <span class="onoffswitch-switch"></span>
					        <!-- <span class="onoffswitch-switch"></span> -->
					    </label>
					  </div>
					  <div class='layersswitchLabel'>Light Gray Basemap</div>
		              <!-- END CITY SWITCH -->

					  <div id="streetsLayerdiv" class="onoffswitch">
				      <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox basemap" id="streetslayeronoffswitch" checked>
					    <!-- <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked> -->
					    <label class="onoffswitch-label" for="streetslayeronoffswitch">
					    <!-- <label class="onoffswitch-label" for="myonoffswitch"> -->
					        <span class="onoffswitch-inner"></span>
					        <!-- <span class="onoffswitch-inner"></span> -->
					        <span class="onoffswitch-switch"></span>
					        <!-- <span class="onoffswitch-switch"></span> -->
					    </label>
					  </div>
					  <div class='layersswitchLabel'>Streets Basemap</div>
		              <!-- END COUNTY SWITCH -->

		              <div id="satLayerdiv" class="onoffswitch">
				      <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox basemap" id="satlayeronoffswitch" checked>
					    <!-- <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked> -->
					    <label class="onoffswitch-label" for="satlayeronoffswitch">
					    <!-- <label class="onoffswitch-label" for="myonoffswitch"> -->
					        <span class="onoffswitch-inner"></span>
					        <!-- <span class="onoffswitch-inner"></span> -->
					        <span class="onoffswitch-switch"></span>
					        <!-- <span class="onoffswitch-switch"></span> -->
					    </label>
					  </div>
					  <div class='layersswitchLabel'>Satellite Basemap</div>
		              <!-- END COUNTY SWITCH -->

		          </div>  <!-- END BASEMAP SWITCHES -->

	             </div>
	             <div class="logo">
		          	<a href="http://www.legacy.leg.mn/"><img src="images/logo-new.png" alt="logo"/></a>
		        </div>
	            </div> <!-- end layers tab -->

            <!-- - - - - - - - - - - - - - - - Sidebar/Results Div - - - - - - - - - - - - - - -->
            <div id="results" style="display: none">
            <div class='closetab'><i class="fa fa-caret-square-o-left fa-lg"></i></div>
            	<div class="navtitle">Results</div>

            	<div id="resultsTable">
            		<table class="table">
            		</table>
            	</div>

            	<div class="singleResultTable">
            		<table id="singleResultTable" class="table">
            		<thead id="noshow">
						<tr>
							<th><span class="detailsText">No Project Selected</span></th>
						</tr>
					</thead>

					<tbody id="data">
					</tbody>


            		</table>

            	</div>
            	<div class="logo">
		          	<a href="http://www.legacy.leg.mn/"><img src="images/logo-new.png" alt='logo'/></a>
		        </div>
            </div>

            <!-- - - - - - - - - - - - - - - - Sidebar/LCCMR Div - - - - - - - - - - - - - -->
            <div id="lccmr" style="display: none">
            <div class='closetab'><i class="fa fa-caret-square-o-left fa-lg"></i></div>
            	<div class="navtitle">Documentation</div>
            	
            	<ul class="nav navbar-nav helpul">
			            <li class="active helpli rightline" data-helplist-id="mapNavHelp">
			                <a class="navtext-help" href="#"><div class="layernotification">1</div>Map Navigation</a>
			            </li>

			            <li class="helpli rightline" data-helplist-id="sidebarHelp">
			                 <a class="navtext-help" href="#"><div class="layernotification">1</div>Sidebar Navigation</a>
			            </li>

			            <li class="helpli" data-helplist-id="mapToolsHelp" style="width:34%;"><a class="navtext-help" href="#"><div class="layernotification">1</div>Map Tools</a></li>

		          </ul>

		            <div id="help">
			          <!-- switches -->
				      <div id="mapNavHelp" class="helpMenu">
					      <ul>
					      	<li class="helpListHeader">Basic map navigation</li>
					      	<li>The red circle symbols size are proportional to the number of Legacy and Trust Fund projects found within the symbol boundary.</li>
					      	<li>Select the symbols to drill down to individual projects.</li>
					      	<li>Selecting an individual project will reveal the project attributes in the sidebar navigation "Results" tab.</li>
					      	<li>Select the project link to display the full project report.</li>
					      </ul>
					  </div>
					  <!-- <div class='layersswitchLabel'>Light Gray Basemap</div> -->
		              <!-- END CITY SWITCH -->

					  <div id="sidebarHelp" class="helpMenu">
					      <ul>
					      	<li class="helpListHeader">Search Tab</li>
					      	<li>Search for projects near an address using the "Search by Address" form.</li>
					      	<li>Search for projects by County, House District, or Senate District using the "Search by" select forms. This will zoom the map to the respective selection.</li>
					 
					      </ul>
					      <ul>
					      	<li class="helpListHeader">Layers Tab</li>
					      	<li>Add additional layers to the map from the following categories of map layers tabs: Political, Physical, Resource Management, Basemap.</li>
					      </ul>
					      <ul>
					      	<li class="helpListHeader">Results Tab</li>
					      	<li>Selected project attribute information.</li>
					      </ul>
					  </div>
					  <!-- <div class='layersswitchLabel'>Streets Basemap</div> -->
		              <!-- END COUNTY SWITCH -->

		              <div id="mapToolsHelp" class="helpMenu">
				      <ul>
				      	<li class="helpListHeader">Map Tools <br><span class="detailsText">(upper right-hand corner)</span></li>

				      	<li>Reset map.</li>
				      	<li>Information about the Legacy and Trust Fund Amendments.</li>
				      	<li>Add legend to map.</li>
				      	<li>Share the map on Facebook or Twitter.</li>
				      </ul>
					  </div>
					  <!-- <div class='layersswitchLabel'>Satellite Basemap</div> -->
		              <!-- END COUNTY SWITCH -->

		          </div>  <!-- END BASEMAP SWITCHES -->

                <div class="logo">
		          	<a href="http://www.legacy.leg.mn/"><img src="images/logo-new.png" alt='logo'/></a>
		        </div>
            </div> 
         <!--    <div class="logo">
			  	<a href="http://www.legacy.leg.mn/"><img src="images/logo-new.png" alt='logo'/></a>
		    </div>  -->   
        </div>

        <!-- - - - - - - - - - - - - - - map - - - - - - - - - - - - - - -->
        <div class="col-sm-9  col-md-10 ">

           <div id="map">
           	     <div class="loader">Loading...</div>
           </div>
        </div>
        <div id="map-tools">
			<a href="#" class="first" data-toggle="tooltip" data-placement="bottom" title="Reset Map"><i class="fa fa-refresh fa-lg"></i></a>
			<span data-toggle="modal" data-target="#info" style="cursor:pointer">
				<a href="#" class="middle" data-toggle="tooltip" data-placement="bottom" title="About" id="helpbutton"><i class="fa fa-info-circle fa-lg"></i></a>
			</span>
			<a href="#"  id="legendToggle" data-toggle="tooltip" data-placement="bottom" title="Toggle Map Legend"><i class="fa fa-map-signs fa-lg"></i></a>
			<span data-toggle="modal" data-target="#share" style="cursor:pointer">
			    <a class="last" data-toggle="tooltip" data-placement="bottom" title="Share Map" id="sharebutton"><i class="fa fa-share fa-lg"></i></a>
			</span>
		</div>

	 <div id="legend" >
	  <div class="legendTitle">Legend</div>
	  <img id="propsymbols" src="images/legend/legend3.png" alt='legend'/>
	  <ul class="symbolClass">
		  <li style="padding-right:6px;">2-10</li>
		  <li style="padding-right:12px;">11-75</li>
		  <li style="padding-right:24px;">75-500</li>
		  <li >500+</li>
		</ul>
		<div class="legendlabel">Projects: Grouped by location</div>
		<div class="legendHelper">* Actual count displayed in symbol *</div>
		<!-- <hr> -->
		<ul class="legendicons">
		<!-- <div id="legendicons"> -->
		   <li class="legendiconsLi"><div class="leaflet-marker-icon artsandculture legendhover" style="position:relative"></div> </li>
		   <li class="legendiconsLi"><div class="leaflet-marker-icon cleanwater legendhover" style="position:relative"></div></li>		   
		   <li class="legendiconsLi"><div class="leaflet-marker-icon outdoorheritage legendhover" style="position:relative"></div></li>
		   <li class="legendiconsLi"><div class="leaflet-marker-icon parksandtrails legendhover" style="position:relative"></div></li>
		   <li class="legendiconsLi"><div class="leaflet-marker-icon enrtf legendhover" style="position:relative"></div></li>
		   <!-- </div> -->
		</ul>
		<div class="legendlabel">Legacy and Trust Fund projects</div>
		<div class="legendHelper">* See Search tab checkboxes *</div>
	 </div>

    <!-- Add js if success - use the data attributes to fire modal -->
    <!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button> -->
<!-- help modal -->

<div id="info" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">The Legacy and Trust Fund Amendments</h4>
			</div>
			<div class="aboutLCCMR">
			    <div class="infodivs">
		            <div class="pull-left"><a href="http://www.legacy.leg.mn/" target="_blank"><img src='images/legacy_logo_rgb.jpg' alt='legacy logo'style="height:150px;padding-right: 10px;"/></a></div>
		            <p><strong><a href="http://www.legacy.leg.mn/" target="_blank" style="color: #50667f;">Legacy Amendment</a></strong></p>
		            <p>In 2008, Minnesota's voters passed the Clean Water, Land and Legacy Amendment (Legacy Amendment) to the Minnesota Constitution to: protect drinking water sources; to protect, enhance, and restore wetlands, prairies, forests, and fish, game, and wildlife habitat; to preserve arts and cultural heritage; to support parks and trails; and to protect, enhance, and restore lakes, rivers, streams, and groundwater.</p>

					<p>The Legacy Amendment increases the state sales tax by three-eighths of one percent beginning on July 1, 2009 and continuing until 2034. The additional sales tax revenue is distributed into four funds as follows: 33 percent to the clean water fund; 33 percent to the outdoor heritage fund; 19.75 percent to the arts and cultural heritage fund; and 14.25 percent to the parks and trails fund.</p>
				</div>
				<div class="infodivs">
		            <div class="pull-left"><a href="http://www.lccmr.leg.mn/" target="_blank"><img src='images/enrtf-logo.jpg' alt='legacy logo' style="height:100px;padding-right: 10px;"/></a></div><p><strong><a href="http://www.lccmr.leg.mn/" target="_blank" style="color: #50667f;">Environmental and Natural Resources Trust Fund</a></strong></p>

		            <p>In 1988, Minnesota's voters approved a constitutional amendment establishing the Environment and Natural Resources Trust Fund (Trust Fund). The purpose of the Trust Fund is to provide a long-term, consistent, and stable source of funding for activities that protect and enhance Minnesota's environment and natural resources for the benefit of current citizens and future generations.</p>

					<p>The money in the Trust Fund originates from a combination of contributions and investment income. Forty percent of the net proceeds from the Minnesota State Lottery are deposited to the Trust Fund each year; this contribution is guaranteed by the Minnesota Constitution until December 31, 2024. The Trust Fund may also receive contributions from other sources such as private donations.</p>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- share modal -->
<div class="modal fade" id="share" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
			<div class="modal-dialog share">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel2">Share this map on social media!</h4>
					</div>
				<div class="modal-body">
					<a id="FB" title="Share on Facebook" target="_blank" 
					href="https://www.facebook.com/dialog/share?app_id=944707115597875&redirect_uri=http%3A%2F%2Fwww.gis.leg.mn%2FiMaps%2FLegacy%2Findex.html&display=popup&href=http%3A%2F%2Fwww.gis.leg.mn%2FiMaps%2FLegacy%2F%23">
					
					<div id="facebookshare">										    
                            <i class="fa fa-facebook fa-lg fb"></i>
		                <strong>Share on Facebook</strong>
					</div>
					</a>

				    <a id="TW" target="_blank" title="Share on Twitter" href="http://twitter.com/intent/tweet?url=http%3A%2F%2Fwww.gis.leg.mn%2FiMaps%2FLCCMR%2FlandAcq%2Findex.html&text=Legacy%20project%20mapping%20application&hashtags=LCCMR, Legacy, ENRTF">
					<div id="twittershare">
				            <i class="fa fa-twitter fa-lg tw"></i>
		                <strong>Share on Twitter</strong>
					</div>
					</a>
				</div>
<!-- 				<div class="modal-footer">
				     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				
				</div> -->
				</div>
			</div>
		</div>
      </div>
    </div> <!-- container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src='https://api.mapbox.com/mapbox.js/v2.3.0/mapbox.js'></script>
    <script src="js/plugins/leaflet.markercluster.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/app.js"></script>
    <script src="js/helper.js"></script>
    <script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-40102195-1']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
    
    
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <!-- <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>-->
  </body>
</html>
