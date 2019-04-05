$(function() {

	 $("#jsGrid").jsGrid({
         height: "70%",
         width: "100%",
         filtering: true,
         inserting: true,
         editing: true,
         sorting: true,
         paging: true,
         autoload: true,
         pageSize: 10,
         pageButtonCount: 5,
         deleteConfirm: "Do you really want to delete this location?",
         controller: {
             loadData: function(filter) {
                 return $.ajax({
                     type: "GET",
                     url: "locations/",
                     data: filter
                 });
             },
             insertItem: function(item) {
                 return $.ajax({
                     type: "POST",
                     url: "locations/",
                     data: item
                 });
             },
             updateItem: function(item) {
                 return $.ajax({
                     type: "PUT",
                     url: "locations/",
                     data: item
                 });
             },
             deleteItem: function(item) {
                 return $.ajax({
                     type: "DELETE",
                     url: "locations/",
                     data: item
                 });
             }
         },
         fields: [
             { name: "name", title: "Naam", type: "text", width: 150 },
             { name: "apbnumber", title: "ApbNummer", type: "text", width: 50 },
             { name: "address", title: "Adres", type: "text", width: 150, filtering: false },
             { name: "zipcode", title: "Postcode", type: "text", width: 20 },
             { name: "city", title: "Stad", type: "text", width: 50, filtering: false },
             { name: "country", title: "Land", type: "text", width: 20 },
             { name: "state", type: "text", title: "Status" },
             { type: "control" }
         ]
     });
     
     //{ name: "country", title: "Land", type: "select", width: 100, items: countries, valueField: "id", textField: "name" },



});