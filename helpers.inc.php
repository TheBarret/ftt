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
 
function wDir2Cardinal($value) {
	if (is_numeric($value)) {
		if ($value > 348.75 or $value < 11.25)     { return "North\r\n"; }					//N 	348.75 - 11.25	
		if ($value >= 326.25 and $value <= 348.75) { return "North - North West\r\n"; }		//NNW	326.25 - 348.75
		if ($value >= 303.75 and $value <= 326.25) { return "North West\r\n"; }				//NW	303.75 - 326.25
		if ($value >= 281.75 and $value <= 303.75) { return "West - North West\r\n"; }		//WNW	281.25 - 303.75
		if ($value >= 258.75 and $value <= 281.25) { return "West\r\n"; }					//W		258.75 - 281.25
		if ($value >= 236.25 and $value <= 258.75) { return "West - South West\r\n"; }		//WSW	236.25 - 258.75
		if ($value >= 213.75 and $value <= 236.25) { return "South West\r\n"; }				//SW	213.75 - 236.25
		if ($value >= 191.25 and $value <= 213.75) { return "South - South West\r\n"; }		//SSW	191.25 - 213.75
		if ($value >= 168.75 and $value <= 191.25) { return "South\r\n"; }					//S		168.75 - 191.25
		if ($value >= 146.25 and $value <= 168.75) { return "South - South East\r\n"; }		//SSE	146.25 - 168.75
		if ($value >= 123.75 and $value <= 146.25) { return "South East\r\n"; }				//SE	123.75 - 146.25
		if ($value >= 101.25 and $value <= 123.75) { return "East - South East\r\n"; }		//ESE	101.25 - 123.75
		if ($value >= 78.75 and $value <= 101.25)  { return "East\r\n"; }					//E		78.75 - 101.25
		if ($value >= 56.25 and $value <= 78.75)   { return "East - North East\r\n"; }		//ENE	56.25 - 78.75
		if ($value >= 33.75 and $value <= 56.25)   { return "North East\r\n"; }				//NE	33.75 - 56.25
		if ($value >= 11.25 and $value <= 33.75)   { return "North - North East\r\n"; }		//NNE	11.25 - 33.75
	}
	return "{$value} Degrees\r\n";
}

function loadJson($input) {
	if (file_exists($input)) {
		print("Reading {$input}...\r\n");
		return json_decode(file_get_contents($input),true);
	}
}

function saveJson($output,$data) {
	print("Saving {$output}...\r\n");
	$fp = fopen($output, 'w');
	fwrite($fp, json_encode($data));
	fclose($fp);
}

function trimSensorData($input)  {
	$unwanted = ["=>","'","(",")",",","array"];
	return trim(str_replace($unwanted,"",var_export($input, true)));
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
                    	"value" => $rssi."dB",
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

function discordCreateStatusPayload($value) {
	return json_encode([
		"username" => "Reporter",
		"tts" => false,
		"embeds" => [
			[
				"title" => "Status Report",
				"type" => "rich",
				"color" => hexdec( "3366ff" ),
				"fields" => [
	                [
                    	"name" => "Frames",
                    	"value" => $value['frames']['count'],
                    	"inline" => true
                	],
                	[
						"name" => "FSK",
    	                "value" => $value['frames']['fsk'],
                    	"inline" => true
                	],
                	[
                    	"name" => "Events",
                    	"value" => $value['frames']['events'],
                    	"inline" => true
                	]
            	]
			]
		]
	], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);	
}
function discordCreateHopPayload($value) {
	if (is_numeric($value)) { 
		$v = $value / 1000000;
		return json_encode([
			"content" => "**Switching frequency to {$v}MHz**",
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