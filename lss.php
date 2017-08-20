<?php

	require('apikey.php');

	$GLOBALS['version'] = 'v3';

	// @todo Make summoner name and server dynamic based off form input.
	$server = 'na1';
	$summoner_name = 'juggernawt';
	$summoner_name = rawurlencode(strtolower($summoner_name));

	function get_base_summoner_info($summoner_name, $server) {
		$curl = curl_init('https://' . $server . '.api.riotgames.com/lol/summoner/' . $GLOBALS['version'] . '/summoners/by-name/' . $summoner_name . '?api_key=' . $GLOBALS['API_KEY']);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($curl);
		curl_close($curl);
		$json = json_decode($result);
		return $json;
	}

	function get_most_played($summoner_id, $server) {
		$curl = curl_init('https://' . $server . '.api.riotgames.com/lol/match/' . $GLOBALS['version'] . '/matchlists/by-account/' . $summoner_id . '/recent?api_key=' . $GLOBALS['API_KEY']);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($curl);
		curl_close($curl);
		$json = json_decode($result, true);

		$most_played_array = array();
		for ($i=0; $i < 19; $i++) {
			array_push($most_played_array, $json['matches'][$i]['lane']);
		}

		$count = array_count_values($most_played_array);
		arsort($count);
		$keys = array_keys($count);
		return $keys[0];
}

	$summoner_info = get_base_summoner_info($summoner_name, $server);
	$most_played = get_most_played($summoner_info->accountId, $server);
	echo "Summoner Name: " . $summoner_info->name . "<br>";
	echo "Summoner Level: " . $summoner_info->summonerLevel . "<br>";
	echo "Summoner ID: " . $summoner_info->accountId . "<br>";
	echo "Summoner Profile Icon ID: " . $summoner_info->profileIconId . "<br>";
	echo "most played role is: " . $most_played;