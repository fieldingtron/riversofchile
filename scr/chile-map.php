<?php
require( '../wp-load.php' );
?>


<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<style type="text/css">
  html { height: 100% }
  body { height: 100%; margin: 0px; padding: 0px }
  #map_canvas { height: 100% }
</style>
<?php

?>
<script type="text/javascript"
    src="http://maps.google.com/maps/api/js?sensor=false">
</script>
<script type="text/javascript">
  function initialize() {
     var myLatlng =  new google.maps.LatLng(-40.358072, -72.376791);
	 
  var myOptions = {
    zoom: 8,
    center: myLatlng,
    mapTypeId: google.maps.MapTypeId.TERRAIN
  }
    
  var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    
<?php
query_posts('cat=157');
if (have_posts()) :
  while (have_posts()) : the_post();
	$postID = $post->ID;
	$postTitle = get_the_title();
	$permalink = get_permalink();
	$excerpt = 
	$Difficulty = get_post_meta($post->ID, "Difficulty", true);
	$Distance = get_post_meta($post->ID, "Distance", true);
	$ElevationDrop = get_post_meta($post->ID, "Elevation Drop", true);
	$gradient = round( $ElevationDrop / $Distance); 
	$feetPerMile = round ( 5.29 *( $ElevationDrop / $Distance));
	$putInLat = get_post_meta($post->ID, "Put In Lat", true);
	$putInLong = get_post_meta($post->ID, "Put In Long", true);
	$takeOutLat = get_post_meta($post->ID, "Take Out Lat", true);
	$takeOutLong = get_post_meta($post->ID, "Take Out Long", true);
 	
	
	?>
	//content
	var contentString<?php echo $postID;?> = '<div id="content">'+
    '<div id="siteNotice">'+
    '</div>'+
    '<h1 id="firstHeading" class="firstHeading"><?php echo $postTitle;?></h1>'+
    '<div id="bodyContent"> <?php echo trim(get_the_excerpt()); ?>'+
    '<p>More Details: <a target="_blank" href="<?php echo $permalink; ?>"><?php echo $permalink; ?>'+
    '</a></p>'+
    '</div>'+
    '</div>';
	
	//infowindow
	var infowindow<?php echo $postID;?> = new google.maps.InfoWindow({   content: contentString<?php echo $postID;?>   });
	
	
	
	<?php
	
	
	echo "var marker$postID = new google.maps.Marker({ position: myLatlng,  map: map, title:'$postTitle' });"; 
	
	?>
	//listener
	google.maps.event.addListener(marker<?php echo $postID;?>, 'click', function() {  infowindow<?php echo $postID;?>.open(map,marker<?php echo $postID;?>); });
	<?php
 	 
  endwhile;  
 endif;
?>
   
  
  }

</script>
</head>
<body onload="initialize()">
  <div id="map_canvas" style="width:100%; height:100%"></div>
</body>
</html>