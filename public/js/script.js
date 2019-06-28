var geocoder;
var map;
var markers=[];
var searchmarker;
var statuslist = [
                 { name: "", id: 0 },
                 { name: "Zorgpunt", id: 1 },
                 { name: "Kan nog", id: 2 },
                 { name: "Kan niet", id: 3 }
             ];
$(function() {
	initializeMap();
	  $.ajax({
          type: "GET",
          url: "locations/",
          data:{ name: "", apbnumber: "", zipcode: "", country: "", state: "" }
	      }).done(function(locations) {
	      	locations.unshift({ id: "0", name: "" });
	
	      	$("#exlusivetygrid").jsGrid({
	          height: "100%",
	          width: "100%",
	          //filtering: true,
	          inserting: true,
	          editing: true,
	          sorting: true,
	          paging: true,
	          autoload: false,
	          pageSize: 10,
	          pageButtonCount: 5,
	          deleteConfirm: function(item) {
	              return "Blokkering zal verwijderd worden. Ben je zeker?";
	          },
	          controller: {
	              loadData: function(filter) {
	                  return $.ajax({
	                      type: "GET",
	                      url: "exclusiveties/",
	                      data: filter
//	                      data: {location_id:""+item.id,blocked_location_id:""+item.id,rule_active:""},
	//                      success: function(data, textStatus, request){
	//                      	$("#detailsDialog").dialog("option", "title", dialogType + " apotheek");
	//               	        $("#detailsDialog").dialog( "option", "buttons", 
	//               	        		  [
	//               	        		    {
	//               	        		      text: "Bewaar",
	//               	        		      click: function() {
	//               	        		    	  $("#detailsDialog").validate();
	//               	        		    	  saveItem(item, dialogType === "Nieuwe");
	//               	        		      }
	//               	        		    },
	//               	        		    {
	//               	        		    	text: "Annuleer",
	//               		        		    click: function() {
	//               		        		    	$( this ).dialog( "close" );
	//               		        		  }
	//               	        		    }
	//               	        		  ]
	//               	        		);
	//               	        
	//               	        $("#detailsDialog").dialog("open");
	//                      }
	                  });
	              },
	              insertItem: function(item) {
	                  return $.ajax({
	                      type: "POST",
	                      url: "exclusiveties/",
	                      data: item,
	                      success: function(data, textStatus, request){}
	                  });
	              },
	              updateItem: function(item) {
	                  return $.ajax({
	                      type: "PUT",
	                      url: "exclusiveties/",
	                      data: item,
	                      success: function(data, textStatus, request){}
	                  });
	              },
	              deleteItem: function(item) {
	                  return $.ajax({
	                      type: "DELETE",
	                      url: "exclusiveties/",
	                      data: item,
	                      success: function(data, textStatus, request){}
	                  });
	              }
	          },
	          fields: [
	              { name: "location_id",title:"Zorgpunt", type: "select", items: locations, valueField: "id", textField: "name" },
	              { name: "blocked_location_id",title:"Apotheek", type: "select", items: locations, valueField: "id", textField: "name" },
	              { name: "rule_active", type: "checkbox", title: "Ingeschakeld", sorting: false },
	              { type: "control" }
	          ]
	      });
	  });
	$("#jsGrid").jsGrid({
         height: "40%",
         width: "100%",
         filtering: true,
         //inserting: true,
         editing: true,
         sorting: true,
         paging: true,
         autoload: true,
         pageSize: 10,
         pageButtonCount: 5,
         rowClick: function(args) {
             showDetailsDialog("Bewerk", args.item);
         },
         deleteConfirm: function(item) {
             return "Apotheek \"" + item.Name + "\" zal verwijderd worden. Ben je zeker?";
         },
         controller: {
             loadData: function(filter) {
                 return $.ajax({
                     type: "GET",
                     url: "locations/",
                     data: filter,
                     success: function(data, textStatus, request){
						 //hide previous markers on map
						for (var i = 0; i < markers.length; i++) {
							  if(typeof markers[i] !== 'undefined')
									markers[i].setMap(null);
						}
						  
						data.forEach(showOnMap);
					 }
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
             { name: "state", type: "select", title: "Status", items:statuslist, valueField: "id", textField: "name"  },
             {
                 type: "control",
                 modeSwitchButton: false,
                 editButton: false,
                 headerTemplate: function() {
                     return $("<button>").attr("type", "button").text("Nieuwe")
                             .on("click", function () {
                                 showDetailsDialog("Nieuwe", {});
                             });
                 }
             }
         ]
     });
	$("#detailsDialog").dialog({
        autoOpen: false,
        modal: true,
        width: 800,
        overlay: {
            opacity: 0.7,
            background: "black"
          },
        close: function() {            
            $("#detailsDialog").find(".error").removeClass("error");
        }
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
function showDetailsDialog(dialogType, item) {

    $('#detailsDialog').find('input').val(function (index, value) {
        return item[this.id];
    });
    $('#detailsDialog').find('select').val(function (index, value) {
        return item[this.id];
    });
    $("#detailsDialog").dialog("option", "title", dialogType + " apotheek");
     $("#detailsDialog").dialog("option", "buttons", 
     		  [
     		    {
     		      text: "Bewaar",
     		      click: function() {
     		    	  $("#detailsDialog").validate();
     		    	  saveItem(item, dialogType === "Nieuwe");
     		      }
     		    },
     		    {
     		    	text: "Annuleer",
	        		    click: function() {
	        		    	$( this ).dialog( "close" );
	        		  }
     		    }
     		  ]
     		);
    if(dialogType != "Nieuwe"){
    	$("#exlusivetygrid").jsGrid("loadData",{location_id:""+item.id,blocked_location_id:""+item.id,rule_active:""}).done(function(){         	        
 	        $("#detailsDialog").dialog("open");
    	});
    }else{
    	$("#detailsDialog").dialog("open");
    }
   
   
};

function saveItem(item, isNew) {
    $.extend(item, {
        name: $("#name").val(),
        apbnumber: $("#apbnumber").val(),
        address: $("#address").val(),
        zipcode: $("#zipcode").val(),
        city: $("#city").val(),
        phone: $("#phone").val(),
        email: $("#email").val(),
        website: $("#website").val(),
        state: parseInt($("#state").val())
    });
    
    if(isNew){
    	$.ajax({
            type: "POST",
            url: "locations/",
            data: item,
            success: function(data, textStatus, request){
            	showOnMap(data);
            	$("#jsGrid").jsGrid(isNew ? "insertItem" : "updateItem", item);                   	 
    	        $("#detailsDialog").dialog("close");
    	    }
        });
    }else{
    	$.ajax({
            type: "PUT",
            url: "locations/",
            data: item,
            success: function(data, textStatus, request){
            	showOnMap(data);
            	$("#jsGrid").jsGrid(isNew ? "insertItem" : "updateItem", item);                   	 
    	        $("#detailsDialog").dialog("close");
    	    }
        });
    }

    
};

function codeAddress() {
  var address = $('#searchaddress').val();
  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == 'OK') {
	 if(typeof searchmarker !== 'undefined'){
		 searchmarker.setMap(null);
	 }
      map.setCenter(results[0].geometry.location);
      searchmarker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
      });
	  map.setZoom(parseInt($('#searchzoom').val()));
	  map.panTo(searchmarker.position);
    } else {
      alert('Fout bij zoeken adres: ' + status);
    }
  });
}


function showOnMap(item) {
  if(typeof item.lattitude !== 'undefined' && typeof item.longitude !== 'undefined' && item.lattitude && item.longitude){
	  if(typeof markers[item.id] !== 'undefined'){
		  //show existing marker
		  if(item.lattitude == markers[item.id].getPosition().lat() && item.longitude == markers[item.id].getPosition().lng()){
			   markers[item.id].setMap(map);
			  return;
		  }
		  //remove marker
		  markers[item.id].setMap(null);
	  }
	  var latlng = new google.maps.LatLng(parseFloat(item.lattitude),parseFloat(item.longitude));
	  map.setCenter(latlng);
	  var pinColor1 = "f3da0b"; //geel state 1 (Zorgpunt)
	  var pinColor2 = "35682d"; //green state 2
	  var pinColor3 = "cb3234"; //red state 3
	  var pinColor = pinColor1;
	  if(item.state==3)
		  pinColor = pinColor3;
	  if(item.state==2)
		  pinColor = pinColor2;
	  var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
	            new google.maps.Size(21, 34),
	            new google.maps.Point(0,0),
	            new google.maps.Point(10, 34));

	  var marker = new google.maps.Marker({
	      map: map,
	      position: latlng,
	      icon: pinImage,
	      title:item.name
	  });
	  google.maps.event.addListener(marker, 'click', function() {
		  showDetailsDialog("Bewerk",item);
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

