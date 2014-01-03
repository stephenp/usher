<?
header('Content-Type: application/json');

// Get load
$load = sys_getloadavg();
$load = number_format((float)$load[0], 2, '.', '') .', '. number_format((float)$load[1], 2, '.', '') .', '. number_format((float)$load[2], 2, '.', '');

// Store load
$arr['load'] = $load;

// Get uptime
$uptime = shell_exec("cut -d. -f1 /proc/uptime");
$days = floor($uptime/60/60/24);
$hours = $uptime/60/60%24;
$mins = sprintf("%02s", $uptime/60%60);

// Store uptime
$arr['uptime'] = "$days days, $hours:$mins";

// Get raidSize
$command = shell_exec('df -h'); 
preg_match("/md0 ([^\/]+)/", $command, $result);
preg_match_all("([0-9A-Z%.]+)", $result[1], $result);

// Store raidSize
$arr['raidSize'] = $result[0][0] . 'B total';

// Store used space
$arr['usedSpace'] = $result[0][1] . 'B used';

// Store free space
$arr['freeSpace'] = $result[0][2] . "B free";

// Store percent used
$arr['percentUsed'] = $result[0][3];

// Raid rebuild status
$command = shell_exec('cat /proc/mdstat');
preg_match("/finish=([^min]+)/", $command, $result);

// Only run raid calculation if raid is being rebuilt
if(isset($result[1])) {
	// Calculate to human readable
	$minutes = $result[1];
	
	// Assuming that your minutes value is $minutes
	$d = floor ($minutes / 1440);
	$h = floor (($minutes - $d * 1440) / 60);
	$m = $minutes - ($d * 1440) - ($h * 60);
	
	// Convert minute to whole number
	$m = round($m, 0);
	
	// Store time for raidRebuild
	$arr['raidRebuild'] = "{$d}day {$h}hr {$m}min";
}

// Get current network usage
$sendspeed1 = shell_exec('cat /sys/class/net/eth0/statistics/tx_bytes'); 
$receivespeed1 = shell_exec('cat /sys/class/net/eth0/statistics/rx_bytes'); 

// Wait 2 seconds
sleep(2);

// Remeasure
$sendspeed2 = shell_exec('cat /sys/class/net/eth0/statistics/tx_bytes'); 
$receivespeed2 = shell_exec('cat /sys/class/net/eth0/statistics/rx_bytes'); 

// Calculate
$sendspeed = ($sendspeed2 - $sendspeed1) / 1024 / 128 / 2;
$sendspeed = number_format((float)$sendspeed, 2, '.', '') . "Mb/sec";

$receivespeed = ($receivespeed2 - $receivespeed1) / 1024 / 128 / 2;
$receivespeed = number_format((float)$receivespeed, 2, '.', '') . "Mb/sec";

// Store send and receive speeds
$arr['sendSpeed'] = $sendspeed;
$arr['receiveSpeed'] = $receivespeed;

// Make it rain - Weather time!  Get the flat file and unserialize.  If it fails, the next if statement returns false and will create the file automatically (need to make sure you have permission though)
$cachedWeather = unserialize(file_get_contents("weather.txt"));

// If the data is older than 10 minutes, refresh:
if(time() >= $cachedWeather['timestamp'] + 600) {

	// Get temperature in F
	$json_string = file_get_contents("http://api.wunderground.com/api/0a4bf68d2d38fcab/geolookup/conditions/q/CA/Sacramento.json");
	$parsed_json = json_decode($json_string);
	
	$temp_f = $parsed_json->{'current_observation'}->{'temp_f'};
	

	// Get probability of precipitation  
	$json_string = file_get_contents("http://api.wunderground.com/api/0a4bf68d2d38fcab/forecast/q/CA/Sacramento.json");
	$parsed_json = json_decode($json_string);
	
	$pop = $parsed_json->{'forecast'}->{'simpleforecast'}->{'forecastday'}[0]->{'pop'};


	// Get Sunset time
	$json_string = file_get_contents("http://api.wunderground.com/api/0a4bf68d2d38fcab/astronomy/q/CA/Sacramento.json");
	$parsed_json = json_decode($json_string);

	$sunset_h = $parsed_json->{'moon_phase'}->{'sunset'}->{'hour'};
	$sunset_m = $parsed_json->{'moon_phase'}->{'sunset'}->{'minute'};
	$sunset = "{$sunset_h}:{$sunset_m}";
	$sunset = date("g:i a", strtotime($sunset));

	// Store a cached value!
	$weatherArr = array('timestamp' => time(), 'temp_f' => $temp_f, 'pop' => $pop, 'sunset' => $sunset);
	file_put_contents('weather.txt', serialize($weatherArr));

	$arr['temp_f'] = $temp_f;
	$arr['pop'] = $pop;
	$arr['sunset'] = $sunset;
	
	
} else {

	$arr['temp_f'] = $cachedWeather['temp_f'];
	$arr['pop'] = $cachedWeather['pop'];
	$arr['sunset'] = $cachedWeather['sunset'];

}

echo json_encode($arr);

?>