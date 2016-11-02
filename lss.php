<?php

	require('apikey.php');

	// @todo Make summoner name and server dynamic based off form input, hide global api key from version control.
	$summoner_name = 'Juggernawt';
	$server = 'NA';

	$summoner_encoded = rawurlencode($summoner_name);
	$summoner_name = strtolower($summoner_encoded);

/* 
 * Add the necessary Curl code along with the url of the API, execute it, and return the result.
 * Gets Summoner Information and returns the Name, ID, ProfileIconID, and Level.
 */
	function base_summoner_info($summoner_name, $server) {
		
		$curl = curl_init('https://' . $server . '.api.pvp.net/api/lol/' . $server . '/v1.4/summoner/by-name/' . $summoner_name . '?api_key=' . $GLOBALS['API_KEY']);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($curl);
		curl_close($curl);
		$json = json_decode($result);
		return $json;
	}

/*
 * Gets a summary of stats such as total minions killed, turrets taken, W/L ratios 
 * for various game modes.
 */
	function summary_stats($summoner_name, $server, $summoner_id) {
		$curl = curl_init('https://' . $server . '.api.pvp.net/api/lol/' . $server . '/v1.3/stats/by-summoner/' . $summoner_id . 'summary?api_key=' . $GLOBALS['API_KEY']);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($curl);
		curl_close($curl);
		echo $result;
	
}

	$summoner_id = base_summoner_info($summoner_name, $server);
	echo "Summoner Name: " . $response_name = 
	$summoner_id->$summoner_name->name . "<br>";
	
	echo "Summoner ID: " . $response_id = 
	$summoner_id->$summoner_name->id . "<br>";

	echo "Icon: " . $response_icon_id = 
	$summoner_id->$summoner_name->profileIconId . "<br>";

	echo "Level: " . $response_level = 
	$summoner_id->$summoner_name->summonerLevel . "<br>";

?>