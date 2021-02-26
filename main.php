<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit();
}
$config = include("db/config.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <link href="public/css/style.css" rel="stylesheet" />
    <link href="public/css/jsgrid.min.css" rel="stylesheet" />
    <link href="public/css/jsgrid-theme.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="public/css/jquery-ui.css" />
    <title>Zorgpunt Salestool</title>
</head>
<body>
<header>
    <h1>Zorgpunt locaties</h1>
</header>

<div id="jsGrid"></div>

<div id="floating-panel">
    <input id="searchaddress" placeholder="Adres" type="text">
	<select id="searchzoom"><option value=8>10</option><option value=10>20</option><option value=12 selected>30</option><option value=15>40</option></select>
    <input id="locate" type="button" value="Zoek" >
</div>
  
<div id="map"></div> 
<div id="detailsDialog">
	<form class="form-inline"><fieldset>
		<input type="text" class="hidden" id="id" name="id">
		<label for="name">Naam</label>
		<input type="text" class="text ui-widget-content ui-corner-all input-l" id="name" name="name" placeholder="Naam" required>
		<label for="apb">Apb nummer</label>
		<input type="text" class="text ui-widget-content ui-corner-all input-s" id="apbnumber" name="apbnumber" placeholder="Apb nummer" required>
		<br><label for="address">Adres</label>
		<input type="text" class="text ui-widget-content ui-corner-all input-l" id="address" name="address" placeholder="Straat en nr" required>
		<label for="zipcode">Postcode</label>
		<input type="text" class="text ui-widget-content ui-corner-all input-xs" id="zipcode" name="zipcode" placeholder="Postcode" required>
		<label for="city">Stad</label>
		<input type="text" class="text ui-widget-content ui-corner-all input-s" id="city" name="city" placeholder="Stad" required>
		<br><label for="phone" >Telefoon</label>
		<input type="text" class="text ui-widget-content ui-corner-all input-s" id="phone" name="phone" placeholder="Telefoon">
		<label for="email" >Email</label>
		<input type="text" class="text ui-widget-content ui-corner-all input-1" id="email" name="email" placeholder="Email">
		<br><label for="website" >Website</label>
		<input type="text" class="text ui-widget-content ui-corner-all input-1" id="website" name="website" placeholder="Website">
		<br><label for="state" >Status</label>
		<select name="state" id="state">
	      <option value=1>Zorgpunt</option>	      
	      <option value=2 selected="selected">Kan nog</option>
	      <option value=3>Kan niet</option>
	    </select>
		
	</fieldset></form>
	<label>Overzicht van uitsluitingen:</label><br>
	<div id="exlusivetygrid"></div>
</div>

<script src="public/js/jquery-1.11.3.min.js"></script>
<script src="public/js/jquery-ui.min.js"></script>
<script src="public/js/jquery.validate.min.js"></script>
<script src="public/js/jsgrid.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $config["apikey"];?>"></script>
<script src="public/js/script.js"></script>
</body>
</html>
