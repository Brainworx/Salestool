var geocoder;
var map;
var markers=[];
$(function() {
	initializeMap();
	$("#jsGrid").jsGrid({
         height: "30%",
         width: "100%",
         filtering: true,
         inserting: true,
         editing: true,
         sorting: true,
         paging: true,
         autoload: true,
         pageSize: 10,
         pageButtonCount: 5,
         deleteConfirm: "Ben je zeker dat je de locatie wenst te verwijderen?",
         controller: {
             loadData: function(filter) {
                 return $.ajax({
                     type: "GET",
                     url: "locations/",
                     data: filter,
                     success: function(data, textStatus, request){data.forEach(showOnMap);}
                 });
             },
             insertItem: function(item) {
                 return $.ajax({
                     type: "POST",
                     url: "locations/",
                     data: item,
                     success: function(data, textStatus, request){showOnMap(data);}
                 });
             },
             updateItem: function(item) {
                 return $.ajax({
                     type: "PUT",
                     url: "locations/",
                     data: item,
                     success: function(data, textStatus, request){showOnMap(data);}
                 });
             },
             deleteItem: function(item) {
                 return $.ajax({
                     type: "DELETE",
                     url: "locations/",
                     data: item,
                     success: function(data, textStatus, request){removeFromMap(item);}
                 });
             }
         },
         fields: [
             { name: "name", title: "Naam", type: "text", width: 150 },
             { name: "apbnumber", title: "ApbNummer", type: "text", width: 50 },
             { name: "address", title: "Adres", type: "text", width: 150, filtering: false },
             { name: "zipcode", title: "Postcode", type: "text", width: 30 },
             { name: "city", title: "Stad", type: "text", width: 50, filtering: false },
             { name: "country", title: "Land", type: "text", width: 20 },
             { name: "state", type: "text", title: "Status" },
             { type: "control" }
         ]
     });
     
     //{ name: "country", title: "Land", type: "select", width: 100, items: countries, valueField: "id", textField: "name" },
});

function initializeMap() {
  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(50.8796, 4.7009);//Leuven
  var mapOptions = {
    zoom: 8,
    center: latlng
  }
  map = new google.maps.Map($('#map')[0], mapOptions);
  $("#locate").click(codeAddress);
}

function codeAddress() {
  var address = $('#address').val();
  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == 'OK') {
      map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
      });
    } else {
      alert('Fout bij zoeken adres: ' + status);
    }
  });
}

function showOnMap(item) {
  if(typeof item.lattitude !== 'undefined' && typeof item.longitude !== 'undefined'){
	  if(typeof markers[item.id] !== 'undefined'){
		  //remove marker
		  markers[item.id].setMap(null);
	  }
	  var latlng = new google.maps.LatLng(parseFloat(item.lattitude),parseFloat(item.longitude));
	  map.setCenter(latlng);
	  var pinColor1 = "f3da0b"; //geel
	  var pinColor2 = "35682d"; //green
	  var pinColor3 = "cb3234"; //red
	  var pinColor = pinColor1;
	  if(item.state==-1)
		  pinColor = pinColor3;
	  if(item.state==1)
		  pinColor = pinColor2;
	  var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
	            new google.maps.Size(21, 34),
	            new google.maps.Point(0,0),
	            new google.maps.Point(10, 34));

	  var marker = new google.maps.Marker({
	      map: map,
	      position: latlng,
	      icon: pinImage
	  });
	  google.maps.event.addListener(marker, 'click', function() {
	//      infoWindow.setContent(html);
	//      infoWindow.open(map, marker);
		  alert('click marker');
	    });
	  markers[item.id]=marker;
  }
}
function removeFromMap(item) {
	 if(typeof item.lattitude !== 'undefined' && typeof item.longitude !== 'undefined'){		  
		 if(typeof markers[item.id] !== 'undefined'){
			 //remove marker
			 markers[item.id].setMap(null);
		 }
	 }
}

