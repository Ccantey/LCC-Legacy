## Minnesota Legislative Coordinating Commission
### Legislative-Citizen Commission on Minnesota Resources (LCCMR) mapping application User Interface

The **Land Acquisitions Map** application is a completely open-source full-stack, responsive (RWD) application, built with PostGIS, Leaflet, and a little TLC.

See it in the wild at [http://gis.leg.mn/iMaps/LCCMR/landAcq](http://www.gis.leg.mn/iMaps/LCCMR/landAcq/)

### What's included?
- Code
- Data (GeoJSON)
  - Various MN overlay layers
  - mapserver.map WMS configuration file

### What does it do?
- Fun geodev tools
  - Leaflet marker-cluster graduated symbols that are out of this world
  - Geocodes addresses (Google JavaScript API authentication token required)
  - Zoom to location on cellphones (application optimized using RWD)
- Consumes [MapServer WMS](http://mapserver.org/index.html)
  - Free and open source map service publishing
  - Much faster rendering than vectors
- Basic UI/UX
  - Point and click on the map, or use the search bar to retrieve land acquisition data
  - Graduated symbology
  - Add  overlay layers to geo-exploring

The code relies on a connection to an instance of [PostGreSQL/PostGIS](http://www.postgresql.org/), a free and open-source spatial database. But for testing, connections can be made to the GeoJSON included in the data folder (see [Who Represents Me?](https://github.com/Ccantey/LCC-DistrictFinder/tree/master/data) for all data).

