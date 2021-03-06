<?php
	$imei = $_GET['imei'];
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	 <script src='https://www.gstatic.com/firebasejs/4.3.0/firebase.js'></script>

    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
   
<style>
    


#map {
        height: 650px;
        width: 100%;
       }
    </style>
</head>
<body>
<div id="map"></div>
<pre id="Root" hidden>

	
</pre>
<ul id="list" hidden>
	
</ul>
<script type="text/javascript">
	var imei = <?=json_encode($imei)?>;
	
	const  config = {
		apiKey: "AAAAk56FbHw:APA91bF9e2Pf6I-sKGApMf3LTGPgLcxVja1y03cnLt5LCE279lWMaP1CiF-A85IlqzeBTuSvlH-w-SlapxWAjczKXsju25zMMmOuhF-O4rLLmMPEeAFoeZYT3cmWC7UI8hdEE0JbNc1A",
		authDomain: "hha9FJjaLPTETtZ58FiVPahTiw82",
		databaseURL: "https://employee-track-009.firebaseio.com/",
		storageBucket: "gs://employee-track-009.appspot.com"
	};
	
	firebase.initializeApp(config);

	const preObject = document.getElementById('Root');
	const ulList = document.getElementById('list');

	//create reference
	const dbRefObject = firebase.database().ref().child('Root');
	const dbRefList = dbRefObject.child(imei);
	var map;
	var count = 0;
	var marker;
	function initMap(lat,long) {
		console.log(lat);
		console.log(long);
		console.log(count);
		var uluru = {lat: parseFloat(lat), lng: parseFloat(long)};
		var mark = {lat: parseFloat(lat), lng: parseFloat(long)};
        if(count==0){
        	map = new google.maps.Map(document.getElementById('map'), {
          zoom: 15,
          center: uluru
        });
        	marker = new google.maps.Marker({
          position: mark,
          map: map
        });
        count++;
        return true;
        }
        marker.setMap(null);
        marker = new google.maps.Marker({
          position: mark,
          map: map
        });
        marker.setMap(map);
      }

	//sync object
	dbRefObject.on('value', snap => {
		preObject.innerText = JSON.stringify(snap.val(), null, 3);
		value = JSON.stringify(snap.val(), null, 3);
		console.log(value);
		values = JSON.parse(value);
		Latitude = values[imei]['Latitude'];
		Longitude = values[imei]['Longitude'];
		initMap(Latitude,Longitude)
	});


	dbRefList.on('child_added', snap => {
		const li = document.createElement('li');
		li.innerText = snap.val();
		latlng = snap.val();
		ulList.appendChild(li);
	});

	dbRefList.on('child_changed', snap => {
		const liChanged = document.createElement(snap.key);
		liChanged.innerText = snap.val();
		
	});

	dbRefList.on('child_removed', snap => {
		const liChanged = document.createElement(snap.key);
		liToRemove.remove();
		
	});

</script>

 
 <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3XrGEiVo5eFmm1L-Tt2yYiV6gdljXtkM&callback"> </script>
</body>
</html>
