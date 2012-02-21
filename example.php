<?
include "sonicliving.php"; // include the SonicLiving class file
$sl = new SonicLiving(); // create a new instance of the SonicLiving class.
$sl->setAPI( "" ); // set your API Key.

try
{
	echo "<h2>getArtistID</h2>";
	$artistName = "lady-gaga";
	$getArtistID = $sl->getArtistID( $artistName );
	//echo "<pre>"; print_r( $getArtistID->data[0] ); echo "</pre>";
	foreach ( $getArtistID->data as $artist )
	{
		echo "<b>performer_id</b> " . $artist->performer_id . "<br />";
		echo "<b>name</b> " . $artist->name . "<br />";
	}
	
	echo "<h2>getArtistInfo</h2>";
	$artistID = $getArtistID->data[0]->performer_id;
	$getArtistInfo = $sl->getArtistInfo( $artistID );
	//echo "<pre>"; print_r( $getArtistInfo ); echo "</pre>";
	foreach ( $getArtistInfo->data as $artist )
	{
		echo "<b>performer_id</b> " . $artist->performer_id . "<br />";
		echo "<b>name</b> " . $artist->name . "<br />";
		echo "<b>itms_artist_id</b> " . $artist->itms_artist_id . "<br />";
		echo "<b>amg_artist_id</b> " . $artist->amg_artist_id . "<br />";
		echo "<b>amg_video_artist_id</b> " . $artist->amg_video_artist_id . "<br />";
		echo "<b>wl_title_id</b> " . $artist->wl_title_id . "<br />";
		echo "<b>wl_freebase_id</b> " . $artist->wl_freebase_id . "<br />";
		echo "<b>freebase_id</b> " . $artist->freebase_id . "<br />";
		echo "<b>freebase_name</b> " . $artist->freebase_name . "<br />";
		echo "<b>freebase_guid</b> " . $artist->freebase_guid . "<br />";
		echo "<b>genres</b> " . $artist->genres . "<br />";
		echo "<b>image_id</b> " . $artist->image_id . "<br />";
		echo "<b>image_attrib</b> " . $artist->image_attrib . "<br />";
		echo "<b>article_id</b> " . $artist->article_id . "<br />";
		echo "<b>article_attrib</b> " . $artist->article_attrib . "<br />";
		echo "<b>article_text</b> " . $artist->article_text . "<br />";
		echo "<b>date_created</b> " . $artist->date_created . "<br />";
	}
	
	echo "<h2>getArtistConcerts</h2>";
	$artistID = $getArtistID->data[0]->performer_id;
	$getArtistConcerts = $sl->getArtistConcerts( $artistID );
	//echo "<pre>"; print_r( $getArtistConcerts ); echo "</pre>";
	foreach ( $getArtistConcerts->data as $concert )
	{
		echo "<b>event_id</b> " . $concert->event_id . "<br />";
		echo "<b>name</b> " . $concert->name . "<br />";
		echo "<b>start_datetime</b> " . $concert->start_datetime . "<br />";
		echo "<b>venue_id</b> " . $concert->venue_id . "<br />";
		echo "<b>venue_name</b> " . $concert->venue_name . "<br />";
		echo "<b>venue_city</b> " . $concert->venue_city . "<br />";
		echo "<b>venue_state</b> " . $concert->venue_state . "<br />";
		echo "<b>venue_country</b> " . $concert->venue_country . "<br />";
		echo "<b>event_url</b> " . $concert->event_url . "<br />";
		echo "<b>rsvp</b> " . $concert->rsvp . "<br />";
		echo "<b>facebook_eid</b> " . $concert->facebook_eid . "<br /><br />";
	}
}
catch ( Exception $e )
{
	echo $e->getMessage();
}
?>