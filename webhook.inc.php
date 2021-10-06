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
		
		// Load seen database
		if (file_exists($config['io']['seen'])) {
			$seen = loadJson($config['io']['seen']);
		} else {
			$seen = ['devices'];
		}
		
		// Fetch last line in report.json
		$line 			= `tail -n 1 $file`;
		
		// Decode json data into array
		$report 		= json_decode($line,true);
		
		if (isset($report['model'])) {
			
			// Exit if we already seen this device
			if (isset($seen['devices'][$report['id']])) { exit(0); }

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

			// Collect selected fields for later display
			if (isset($report['id']))			{ $sensors['id']			= $report['id']; }
			if (isset($report['status']))		{ $sensors['status']		= $report['status']; }
			if (isset($report['channel']))		{ $sensors['channel']		= $report['channel']; }
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
			if (isset($sensors['id'])) 				{ $sdata .= "ID: ".$sensors['id']."\r\n";}
			if (isset($sensors['channel'])) 		{ $sdata .= "channel: ".$sensors['channel']."\r\n";}
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
			if (isset($sensors['humidity'])) 		{ $sdata .= "humidity: ".$sensors['humidity']."\r\n";}
			if (isset($sensors['moisture'])) 		{ $sdata .= "moisture: ".$sensors['moisture']."\r\n";}
			if (isset($sensors['wind_avg_km_h']))	{ $sdata .= "Wind avg: ".str_replace("wind_avg_km_h =","Wind (avg): ",$sensors['wind_avg_km_h'])."kmh\r\n"; }
			if (isset($sensors['pressure_PSI'])) 	{ $sdata .= "Pressure: ".str_replace("pressure_PSI =","Pressure : ",$sensors['pressure_PSI'])."Psi\r\n"; }
			if (isset($sensors['temperature_C']))	{ $sdata .= "Temperature: ".str_replace("temperature_C =","Temperature : ",$sensors['temperature_C'])."°C\r\n"; }
			if (isset($sensors['rain_mm']))	  		{ $sdata .= "Rain: ".str_replace("rain_mm =","Rain : ",$sensors['rain_mm'])."mm\r\n"; }
			if (isset($sensors['wind_dir_deg'])) 	{ $sdata .= "Wind direction: ".wDir2Cardinal(str_replace("wind_dir_deg = ","",$sensors['wind_dir_deg'])); }
			
			// Save device info and re-cache array
			$seen['devices'][$sensors['id']] = [$time,$title,$freq,$proto,$rssi];
			saveJson($config['io']['seen'],$seen);
			
			// Get possible distance
			//10 ^ ((Measured Power – RSSI)/(10 * N))
			$dist = 10
			
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
			return $payload;
		} elseif (isset($report['center_frequency'])) {
			// Notify if 433 utlitiy makes a hop to new frequency
			return discordCreateHopPayload($report['center_frequency']);
		} elseif (isset($report['frames'])) {
			// Notify for a status frame
			return discordCreateStatusPayload($report);
		} else {
			// Notify if 433 utlitiy makes a hop to new frequency
			exit(0);
		}
	} else {
		throw new ErrorException("File not found: ${file}");
	}
}
?>
