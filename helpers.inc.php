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

function rssiTest($value) {
	if (is_numeric($value)) { 
		$v = round((0.474 * $value) - 112);
		if ($v >= -40)  { return "Excellent"; }
		if ($v >= -50)  { return "Very good"; }
		if ($v >= -60)  { return "Ok"; }
		if ($v >= -70)  { return "Low"; }
		if ($v >= -80)  { return "Very low"; }
		if ($v >= -90)  { return "Bad"; }
		if ($v <= -100) { return "Very bad"; }
		return "{$v}dBm";
	}
}

function trimSensorData($input)  {
	$unwanted = ["=>","'","(",")",",","array"];
	return trim(str_replace($unwanted,"",var_export($input, true)));
}

?>