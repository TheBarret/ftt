<?php
/**
 * Application	: FTT (rtl_433 wrapper & reporter)
 * Version		: 1.1 (dev)
 * Author(s)	: Barret
 * License		: MIT License
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), 
 * to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, 
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
 
include_once('config.inc.php');
include_once('helpers.inc.php');
define("DEBUG",false);

function discordInitialize($file,$config) {
	if (file_exists($file)) {
		// Fetch last line in report.json
		// Note:
		// Needs be done differently in the future
		// because reports can come in multiple entries
		$line 			= `tail -n 1 $file`;
		
		// Decode json data into array
		$report 		= json_decode($line,true);
		
		// Get last entry to avoid duplicates
		if (isset($config['io']['last'])) {
			if (file_exists($config['io']['last'])) {
				$current = file_get_contents($config['io']['last']);
			} else { $current = "0"; }
		} else { $current = "0"; }
		
		// If we have a report header and last report is not equal to last time
		if (isset($report['model'])) {
			print("DEVICE: ".$report['model']."\r\n");
			if ($report['model'] == $current) {
				print("Nothing to report, exiting...\r\n");
				exit(0);
			} else {
				print("Creating payload...\r\n");
			}

			// Initialize variables
			$sensors	= array();
			$freq		= "0Hz";
			$proto		= "Undefined";
			$type		= "Undefined";
			$time		= date('d-m-Y H:i:s');
			$title		= $report['model'];
			$mod		= $report['mod'];
			$rssi		= $report['rssi'];
			$snr		= $report['snr'];
			$noise		= $report['noise'];

			// Collect basic information
			if (isset($report['type']))			{ $type	= $report['type']; }
			if (isset($report['freq'])) 		{ $freq = $report['freq']."Mhz"; }
			if (isset($report['freq1'])) 		{ $freq = $report['freq1']."Mhz ~ ".$report['freq2']."Mhz"; }
			
			// Check and match up protocol name with protocol number
			if (isset($config['protocols'][$report['protocol']])) { $proto = $config['protocols'][$report['protocol']]; }

			// Collect sensor data if matching fields are set
			if (isset($report['status']))		{ $sensors['status']		= $report['status']; }
			if (isset($report['flags']))		{ $sensors['flags']			= $report['flags']; }
			if (isset($report['state']))		{ $sensors['state']			= $report['state']; }
			if (isset($report['code']))			{ $sensors['code']			= $report['code']; }
			if (isset($report['test']))			{ $sensors['test']			= $report['test']; }
			if (isset($report['slave']))		{ $sensors['slave']			= $report['slave']; }
			if (isset($report['master']))		{ $sensors['master']		= $report['master']; }
			if (isset($report['command']))		{ $sensors['command']		= $report['command']; }
			if (isset($report['repeat']))		{ $sensors['repeat']		= $report['repeat']; }
			if (isset($report['transmit']))		{ $sensors['transmit']		= $report['transmit']; }
			if (isset($report['button']))		{ $sensors['button']		= $report['button']; }
			if (isset($report['battery_ok']))	{ $sensors['battery_ok']	= $report['battery_ok']; }
			if (isset($report['maybe_battery'])){ $sensors['maybe_battery']	= $report['maybe_battery']; }
			if (isset($report['wind_avg_km_h'])){ $sensors['wind_avg_km_h']	= $report['wind_avg_km_h']; }
			if (isset($report['wind_dir_deg'])) { $sensors['wind_dir_deg']	= $report['wind_dir_deg']; }
			if (isset($report['pressure_PSI'])) { $sensors['pressure_PSI']	= $report['pressure_PSI']; }
			if (isset($report['temperature_C'])){ $sensors['temperature_C']	= $report['temperature_C']; }
			if (isset($report['rain_mm'])) 		{ $sensors['rain_mm']		= $report['rain_mm']; }
			if (isset($report['humidity'])) 	{ $sensors['humidity']		= $report['humidity']; }
			if (isset($report['moisture'])) 	{ $sensors['moisture']		= $report['moisture']; }

			// Correct units to readable data
			$sdata = "";
			if (isset($sensors['battery_ok']))	{
				if ($sensors['battery_ok'] == 1) { $sdata .= "Battery: OK\r\n"; } else { $sdata .= "Battery: BAD\r\n"; }
			}
			
			if (isset($sensors['status'])) 			{ $sdata .= "Status: ".$sensors['status']."\r\n";}
			if (isset($sensors['flags'])) 			{ $sdata .= "Flags: ".$sensors['flags']."\r\n";}
			if (isset($sensors['state'])) 			{ $sdata .= "State: ".$sensors['state']."\r\n";}
			if (isset($sensors['code'])) 			{ $sdata .= "Code: ".$sensors['code']."\r\n";}
			if (isset($sensors['test'])) 			{ $sdata .= "Test: ".$sensors['test']."\r\n";}
			if (isset($sensors['slave'])) 			{ $sdata .= "Slave: ".$sensors['slave']."\r\n";}
			if (isset($sensors['master'])) 			{ $sdata .= "Master: ".$sensors['master']."\r\n";}
			if (isset($sensors['command'])) 		{ $sdata .= "Command: ".$sensors['command']."\r\n";}
			if (isset($sensors['repeat'])) 			{ $sdata .= "Repeat: ".$sensors['repeat']."\r\n";}
			if (isset($sensors['transmit'])) 		{ $sdata .= "Transmit: ".$sensors['transmit']."\r\n";}
			if (isset($sensors['button'])) 			{ $sdata .= "Button: ".$sensors['button']."\r\n";}
			
			if (isset($sensors['wind_avg_km_h']))	{ $sdata .= "Wind avg: ".str_replace("wind_avg_km_h =","Wind (avg): ",$sensors['wind_avg_km_h'])."km\h\r\n"; }
			if (isset($sensors['pressure_PSI'])) 	{ $sdata .= "Pressure: ".str_replace("pressure_PSI =","Pressure : ",$sensors['pressure_PSI'])."Psi\r\n"; }
			if (isset($sensors['temperature_C']))	{ $sdata .= "Temperature: ".str_replace("temperature_C =","Temperature : ",$sensors['temperature_C'])."°C\r\n"; }
			if (isset($sensors['rain_mm']))	  		{ $sdata .= "Rain: ".str_replace("rain_mm =","Rain : ",$sensors['rain_mm'])."mm\r\n"; }
			if (isset($sensors['wind_dir_deg'])) 	{ $sdata .= "Wind direction: ".wDir2Cardinal(str_replace("wind_dir_deg = ","",$sensors['wind_dir_deg'])); }

			// Clean up sensor data before correcting units
			$sdata = trimSensorData($sdata);
			
			//Embed as code for readability
			if (strlen($sdata) > 0) { $sdata = "```".$sdata."```"; } 
			if (strlen($proto) > 0) { $proto = "```".$proto."```"; }

			if (DEBUG) {
				print("Model: ".$title."\r\n");
				print("Protocol: ".$proto."\r\n");
				print("Type: ".$type."\r\n");
				print("Modulation: ".$mod."\r\n");
				print("Frequency: ".$freq."\r\n");
				print("Time: ".$time."\r\n");
				print("RSSI: ".$rssi."\r\n");
				print("SNR: ".$snr."\r\n");
				print("Noise: ".$noise."\r\n");
				print("Data: ".$sdata."\r\n");
			}


			// Hand off sensor data to Discord
			if (DEBUG) {
				$payload = discordCreateTestPayload();
			} else {
				$payload = discordCreatePayload($title,$proto,$type,$mod,$freq,$time,$rssi,$snr,$noise,$sdata);
			}
			
			// Save last discovery name, avoid repeating finds
			file_put_contents($config['io']['last'], $report['model']);
			return $payload;

		// Notify if 433 utlitiy makes a hop to new frequency
		} elseif (isset($report['center_frequency'])) {
			$payload = discordCreateHopPayload($report['center_frequency']);
			return $payload;
		} else {
			$payload = discordCreateNoPayload();
			return $payload;
		}
	} else {
		throw new ErrorException("File not found: ${file}");
	}
}

function discordCreatePayload($title,$proto,$type,$mod,$freq,$time,$rssi,$snr,$noise,$sensors) {
	return json_encode([
		"username" => "Reporter",
		"tts" => false,
		"embeds" => [
			[
				"title" => $title,
				"type" => "rich",
				"color" => hexdec( "3366ff" ),
				"fields" => [
	                [
                    	"name" => "Type",
                    	"value" => $type,
                    	"inline" => true
                	],
                	[
						"name" => "Modulation",
    	                "value" => $mod,
                    	"inline" => true
                	],
                	[
                    	"name" => "Frequency",
                    	"value" => $freq,
                    	"inline" => true
                	],
                	[
						"name" => "Signal to noise",
    	                "value" => $snr."dB",
						"inline" => true
            	    	],
                	[
                    	"name" => "Signal strength",
                    	"value" => $rssi."dB (".rssiTest($rssi).")",
                    	"inline" => true
                	],
                	[
                    	"name" => "Noise",
                    	"value" => $noise."dB",
                    	"inline" => true
                	],
                	[
						"name" => "Protocol",
						"value" => $proto,
						"inline" => false
					],
                	[
                    	"name" => "Data",
                    	"value" => $sensors,
                    	"inline" => false
                	]
            	]
        ]
	]
	], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

function discordCreateTestPayload() {
	return json_encode([
		"username" => "Reporter",
		"tts" => false,
		"embeds" => [
			[
				"title" => "1",
				"type" => "rich",
				"color" => hexdec( "3366ff" ),
				"fields" => [
	                [
                    	"name" => "Type",
                    	"value" => 2,
                    	"inline" => true
                	],
                	[
						"name" => "Modulation",
    	                "value" => 3,
                    	"inline" => true
                	],
                	[
                    	"name" => "Frequency",
                    	"value" => 4,
                    	"inline" => true
                	],
                	[
						"name" => "Signal to noise",
    	                "value" => 5,
						"inline" => true
            	    	],
                	[
                    	"name" => "Signal strength",
                    	"value" => 6,
                    	"inline" => true
                	],
                	[
                    	"name" => "Noise",
                    	"value" => 7,
                    	"inline" => true
                	],
                	[
						"name" => "Protocol",
						"value" => 8,
						"inline" => false
					],
                	[
                    	"name" => "Data",
                    	"value" => 9,
                    	"inline" => false
                	]
            	]
        ]
	]
	], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

function discordCreateNoPayload() {
	return json_encode([
			"content" => "**discordInitialize(): No payload created**",
			"username" => "Reporter",
			"tts" => false,
		], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

function discordCreateHopPayload($value) {
	if (is_numeric($value)) { 
		return json_encode([
			"content" => "**Switching frequency to {$value}Hz**",
			"username" => "Reporter",
			"tts" => false,
		], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	} else {
		return json_encode([
			"content" => "**Switching frequency to {$value}Hz**",
			"username" => "Reporter",
			"tts" => false,
		], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	}
}

// hand off data to discord API server
function discordSend($payload,$config) {
	$ch = curl_init($config['discord']['webhook']);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$response = curl_exec( $ch );
	curl_close( $ch );
	return $response;
}
?>
