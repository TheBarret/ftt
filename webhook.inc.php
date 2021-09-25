<?php

include_once('config.inc.php');

function discordInitialize($file,$config) {
	if (file_exists($file)) {
		$line 			= `tail -n 1 $file`;
		$report 		= json_decode($line,true);
		$current 		= file_get_contents($config['io']['last']);
		if (isset($report['model']) && $current !== $report['model']) {
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
			
			if (isset($report['type'])) { $type	= $report['type']; }
			if (isset($report['freq'])) { $freq = $report['freq']."Hz"; }
			if (isset($report['freq1'])) { $freq = $report['freq1']."Hz ~ ".$report['freq2']."Hz"; }
			if (isset($config['protocols'][$report['protocol']])) { $proto = $config['protocols'][$report['protocol']]; }
			
			// Sensor data 
			if (isset($report['status'])) { $sensors['status'] = $report['status']; }
			if (isset($report['flags'])) { $sensors['flags'] = $report['flags']; }
			if (isset($report['state'])) { $sensors['state'] = $report['state']; }
			if (isset($report['code'])) { $sensors['code'] = $report['code']; }
			if (isset($report['test'])) { $sensors['test'] = $report['test']; }
			if (isset($report['slave'])) { $sensors['slave'] = $report['slave']; }
			if (isset($report['master'])) { $sensors['master'] = $report['master']; }
			if (isset($report['command'])) { $sensors['command'] = $report['command']; }
			if (isset($report['repeat'])) { $sensors['repeat'] = $report['repeat']; }
			if (isset($report['transmit'])) { $sensors['transmit'] = $report['transmit']; }
			if (isset($report['button'])) { $sensors['button'] = $report['button']; }
			if (isset($report['battery_ok'])) { $sensors['battery_ok'] = $report['battery_ok']; }
			if (isset($report['maybe_battery'])) { $sensors['maybe_battery'] = $report['maybe_battery']; }
			if (isset($report['wind_avg_km_h'])) { $sensors['wind_avg_km_h'] = $report['wind_avg_km_h']; }
			if (isset($report['wind_dir_deg'])) { $sensors['wind_dir_deg'] = $report['wind_dir_deg']; }
			if (isset($report['pressure_PSI'])) { $sensors['pressure_PSI'] = $report['pressure_PSI']; }
			if (isset($report['temperature_C'])) { $sensors['temperature_C'] = $report['temperature_C']; }
			if (isset($report['rain_mm'])) { $sensors['rain_mm'] = $report['rain_mm']; }
			if (isset($report['humidity'])) { $sensors['humidity'] = $report['humidity']; }
			if (isset($report['moisture'])) { $sensors['moisture'] = $report['moisture']; }
			
			// Reformat sensor data for display
			$sdata	= var_export($sensors, true);
			$sdata	= str_replace("\n","",$sdata);
			$sdata	= str_replace(",","",$sdata);
			$sdata	= str_replace("(","",$sdata);
			$sdata	= str_replace(")","",$sdata);
			$sdata	= str_replace("'","",$sdata);
			$sdata	= str_replace("=>","=",$sdata);
			$sdata	= trim(str_replace("array","",$sdata));
			if (strlen($sdata) > 0) { $sdata = "```".$sdata."```"; }
			
			$payload = discordCreatePayload(
						$title,
						$proto,
						$type,
						$mod,
						$freq,
						$time,
						$rssi,
						$snr,
						$noise,
						$sdata);
			file_put_contents($config['io']['last'], $report['model']);
			return $payload;
		}
	} else {
		print("File not found, exiting...");
	}
}

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
function discordCreatePayload($title,$proto,$type,$mod,$freq,$time,$rssi,$snr,$noise,$sensors) {
	return json_encode([
		"content" => "",
		"username" => "Reporter",
		"tts" => false,
		"embeds" => [
			[
				"title" => $title." [".$time."]",
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
    	                "value" => $rssi."dB",
        	            "inline" => true
            	    ],
                	[
                    	"name" => "Signal strength",
                    	"value" => $snr."dB",
                    	"inline" => true
                	],
                	[
                    	"name" => "Noise",
                    	"value" => $noise."dB",
                    	"inline" => true
                	],
                	[
						"name" => "Protocol",
						"value" => "```".$proto."```",
						"inline" => false
					],
                	[
                    	"name" => "Sensor data",
                    	"value" => $sensors,
                    	"inline" => false
                	]
            	]
        	]
		]
	], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}
?>