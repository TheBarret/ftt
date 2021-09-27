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

$config 	= array();
$config 	= [
    'discord'	=> [
		'webhook'	=> 'https://discord.com/api/webhooks/892032010774773790/MfwXtIRwdWHUXazXZDgEeTbRgkKPngQhDqkiLlcIyn4o3eNJpN0AmqkV7t8yObxSJJc5',
	],
	'io'		=> [
		'appdir' 	=> '',
		'reports' 	=> '',
	],
	'protocols' => [],
];

// Directory and output settings
$config['io']['appdir'] 		= getcwd();
$config['io']['reports'] 		= getcwd()."/reports.json";
$config['io']['last'] 			= getcwd()."/last.tmp";

// Protocols
$config['protocols'][1] 	= "Silvercrest Remote Control";
$config['protocols'][2] 	= "Rubicson Temperature Sensor";
$config['protocols'][3] 	= "Prologue, FreeTec NC-7104, NC-7159-675 temperature sensor";
$config['protocols'][4] 	= "Waveman Switch Transmitter";
$config['protocols'][5] 	= "Undefined Protocol";
$config['protocols'][6] 	= "ELV EM 1000";
$config['protocols'][7] 	= "ELV WS 2000";
$config['protocols'][8] 	= "LaCrosse TX Temperature / Humidity Sensor";
$config['protocols'][9] 	= "Undefined Protocol";
$config['protocols'][10] 	= "Acurite 896 Rain Gauge";
$config['protocols'][11] 	= "Acurite 609TXC Temperature and Humidity Sensor";
$config['protocols'][12] 	= "Oregon Scientific Weather Sensor";
$config['protocols'][13] 	= "Mebus 433";
$config['protocols'][14] 	= "Intertechno 433";
$config['protocols'][15] 	= "KlikAanKlikUit Wireless Switch";
$config['protocols'][16] 	= "AlectoV1 Weather Sensor (Alecto WS3500 WS4500 Ventus W155/W044 Oregon)";
$config['protocols'][17] 	= "Cardin S466-TX2";
$config['protocols'][18] 	= "Fine Offset Electronics, WH2, WH5, Telldus Temperature/Humidity/Rain Sensor";
$config['protocols'][19] 	= "Nexus, FreeTec NC-7345, NX-3980, Solight TE82S, TFA 30.3209 temperature/humidity sensor";
$config['protocols'][20] 	= "Ambient Weather, TFA 30.3208.02 temperature sensor";
$config['protocols'][21] 	= "Calibeur RF-104 Sensor";
$config['protocols'][22] 	= "X10 RF";
$config['protocols'][23] 	= "DSC Security Contact";
$config['protocols'][24] 	= "Brennenstuhl RCS 2044";
$config['protocols'][25] 	= "Globaltronics GT-WT-02 Sensor";
$config['protocols'][26] 	= "Danfoss CFR Thermostat";
$config['protocols'][27] 	= "Undefined Protocol";
$config['protocols'][28] 	= "Undefined Protocol";
$config['protocols'][29] 	= "Chuango Security Technology";
$config['protocols'][30] 	= "Generic Remote SC226x EV1527";
$config['protocols'][31] 	= "TFA-Twin-Plus-30.3049, Conrad KW9010, Ea2 BL999";
$config['protocols'][32] 	= "Fine Offset Electronics WH1080/WH3080 Weather Station";
$config['protocols'][33] 	= "WT450, WT260H, WT405H";
$config['protocols'][34] 	= "LaCrosse WS-2310 / WS-3600 Weather Station";
$config['protocols'][35] 	= "Esperanza EWS";
$config['protocols'][36] 	= "Efergy e2 classic";
$config['protocols'][37] 	= "Inovalley kw9015b, TFA Dostmann 30.3161 (Rain and temperature sensor)";
$config['protocols'][38] 	= "Generic temperature sensor 1";
$config['protocols'][39] 	= "WG-PB12V1 Temperature Sensor";
$config['protocols'][40] 	= "Acurite 592TXR Temp/Humidity, 5n1 Weather Station, 6045 Lightning, 3N1, Atlas";
$config['protocols'][41] 	= "Acurite 986 Refrigerator / Freezer Thermometer";
$config['protocols'][42] 	= "HIDEKI TS04 Temperature, Humidity, Wind and Rain Sensor";
$config['protocols'][43] 	= "Watchman Sonic / Apollo Ultrasonic / Beckett Rocket oil tank monitor";
$config['protocols'][44] 	= "CurrentCost Current Sensor";
$config['protocols'][45] 	= "emonTx OpenEnergyMonitor";
$config['protocols'][46] 	= "HT680 Remote control";
$config['protocols'][47] 	= "Conrad S3318P, FreeTec NC-5849-913 temperature humidity sensor";
$config['protocols'][48] 	= "Akhan 100F14 remote keyless entry";
$config['protocols'][49] 	= "Quhwa";
$config['protocols'][50] 	= "OSv1 Temperature Sensor";
$config['protocols'][51] 	= "Proove / Nexa / KlikAanKlikUit Wireless Switch";
$config['protocols'][52] 	= "Bresser Thermo-/Hygro-Sensor 3CH";
$config['protocols'][53] 	= "Springfield Temperature and Soil Moisture";
$config['protocols'][54] 	= "Oregon Scientific SL109H Remote Thermal Hygro Sensor";
$config['protocols'][55] 	= "Acurite 606TX Temperature Sensor";
$config['protocols'][56] 	= "TFA pool temperature sensor";
$config['protocols'][57] 	= "Kedsum Temperature & Humidity Sensor, Pearl NC-7415";
$config['protocols'][58] 	= "Blyss DC5-UK-WH";
$config['protocols'][59] 	= "Steelmate TPMS";
$config['protocols'][60] 	= "Schrader TPMS";
$config['protocols'][61] 	= "LightwaveRF";
$config['protocols'][62] 	= "Elro DB286A Doorbell";
$config['protocols'][63] 	= "Efergy Optical";
$config['protocols'][64] 	= "Honda Car Key";
$config['protocols'][67] 	= "Radiohead ASK";
$config['protocols'][68] 	= "Kerui PIR / Contact Sensor";
$config['protocols'][69] 	= "Fine Offset WH1050 Weather Station";
$config['protocols'][70] 	= "Honeywell Door/Window Sensor, 2Gig DW10/DW11, RE208 repeater";
$config['protocols'][71] 	= "Maverick ET-732/733 BBQ Sensor";
$config['protocols'][72] 	= "RF-tech";
$config['protocols'][73] 	= "LaCrosse TX141-Bv2, TX141TH-Bv2, TX141-Bv3, TX141W, TX145wsdth sensor";
$config['protocols'][74] 	= "Acurite 00275rm,00276rm Temp/Humidity with optional probe";
$config['protocols'][75] 	= "LaCrosse TX35DTH-IT, TFA Dostmann 30.3155 Temperature/Humidity sensor";
$config['protocols'][76] 	= "LaCrosse TX29IT, TFA Dostmann 30.3159.IT Temperature sensor";
$config['protocols'][77] 	= "Vaillant calorMatic VRT340f Central Heating Control";
$config['protocols'][78] 	= "Fine Offset Electronics, WH25, WH32B, WH24, WH65B, HP1000 Temperature/Humidity/Pressure Sensor";
$config['protocols'][79] 	= "Fine Offset Electronics, WH0530 Temperature/Rain Sensor";
$config['protocols'][80] 	= "IBIS beacon";
$config['protocols'][81] 	= "Oil Ultrasonic STANDARD FSK";
$config['protocols'][82] 	= "Citroen TPMS";
$config['protocols'][83] 	= "Oil Ultrasonic STANDARD ASK";
$config['protocols'][84] 	= "Thermopro TP11 Thermometer";
$config['protocols'][85] 	= "Solight TE44/TE66, EMOS E0107T, NX-6876-917";
$config['protocols'][86] 	= "Wireless Smoke and Heat Detector GS 558";
$config['protocols'][87] 	= "Generic wireless motion sensor";
$config['protocols'][88] 	= "Toyota TPMS";
$config['protocols'][89] 	= "Ford TPMS";
$config['protocols'][90] 	= "Renault TPMS";
$config['protocols'][91] 	= "inFactory, nor-tec, FreeTec NC-3982-913 temperature humidity sensor";
$config['protocols'][92] 	= "FT-004-B Temperature Sensor";
$config['protocols'][93] 	= "Ford Car Key";
$config['protocols'][94] 	= "Philips outdoor temperature sensor (type AJ3650)";
$config['protocols'][95] 	= "Schrader TPMS EG53MA4, PA66GF35";
$config['protocols'][96] 	= "Nexa";
$config['protocols'][97] 	= "Thermopro TP08/TP12/TP20 thermometer";
$config['protocols'][98] 	= "GE Color Effects";
$config['protocols'][99] 	= "X10 Security";
$config['protocols'][100] = "Interlogix GE UTC Security Devices";
$config['protocols'][101] = "Dish remote 6.3";
$config['protocols'][102] = "SimpliSafe Home Security System (May require disabling automatic gain for KeyPad decodes)";
$config['protocols'][103] = "Sensible Living Mini-Plant Moisture Sensor";
$config['protocols'][104] = "Wireless M-Bus, Mode C&T, 100kbps (-f 868950000 -s 1200000)";
$config['protocols'][105] = "Wireless M-Bus, Mode S, 32.768kbps (-f 868300000 -s 1000000)";
$config['protocols'][106] = "Wireless M-Bus, Mode R, 4.8kbps (-f 868330000)";
$config['protocols'][107] = "Wireless M-Bus, Mode F, 2.4kbps";
$config['protocols'][108] = "Hyundai WS SENZOR Remote Temperature Sensor";
$config['protocols'][109] = "WT0124 Pool Thermometer";
$config['protocols'][110] = "PMV-107J (Toyota) TPMS";
$config['protocols'][111] = "Emos TTX201 Temperature Sensor";
$config['protocols'][112] = "Ambient Weather TX-8300 Temperature/Humidity Sensor";
$config['protocols'][113] = "Ambient Weather WH31E Thermo-Hygrometer Sensor, EcoWitt WH40 rain gauge";
$config['protocols'][114] = "Maverick et73";
$config['protocols'][115] = "Honeywell ActivLink, Wireless Doorbell";
$config['protocols'][116] = "Honeywell ActivLink, Wireless Doorbell (FSK)";
$config['protocols'][117] = "ESA1000 / ESA2000 Energy Monitor";
$config['protocols'][118] = "Biltema rain gauge";
$config['protocols'][119] = "Bresser Weather Center 5-in-1";
$config['protocols'][120] = "Digitech XC-0324 temperature sensor";
$config['protocols'][121] = "Opus/Imagintronix XT300 Soil Moisture";
$config['protocols'][122] = "FS20";
$config['protocols'][123] = "Jansite TPMS Model TY02S";
$config['protocols'][124] = "LaCrosse/ELV/Conrad WS7000/WS2500 weather sensors";
$config['protocols'][125] = "TS-FT002 Wireless Ultrasonic Tank Liquid Level Meter With Temperature Sensor";
$config['protocols'][126] = "Companion WTR001 Temperature Sensor";
$config['protocols'][127] = "Ecowitt Wireless Outdoor Thermometer WH53/WH0280/WH0281A";
$config['protocols'][128] = "DirecTV RC66RX Remote Control";
$config['protocols'][129] = "Eurochron temperature and humidity sensor";
$config['protocols'][130] = "IKEA Sparsnas Energy Meter Monitor";
$config['protocols'][131] = "Microchip HCS200 KeeLoq Hopping Encoder based remotes";
$config['protocols'][132] = "TFA Dostmann 30.3196 T/H outdoor sensor";
$config['protocols'][133] = "Rubicson 48659 Thermometer";
$config['protocols'][134] = "Holman Industries iWeather WS5029 weather station (newer PCM)";
$config['protocols'][135] = "Philips outdoor temperature sensor (type AJ7010)";
$config['protocols'][136] = "ESIC EMT7110 power meter";
$config['protocols'][137] = "Globaltronics QUIGG GT-TMBBQ-05";
$config['protocols'][138] = "Globaltronics GT-WT-03 Sensor";
$config['protocols'][139] = "Norgo NGE101";
$config['protocols'][140] = "Elantra2012 TPMS";
$config['protocols'][141] = "Auriol HG02832, HG05124A-DCF, Rubicson 48957 temperature/humidity sensor";
$config['protocols'][142] = "Fine Offset Electronics/ECOWITT WH51 Soil Moisture Sensor";
$config['protocols'][143] = "Holman Industries iWeather WS5029 weather station (older PWM)";
$config['protocols'][144] = "TBH weather sensor";
$config['protocols'][145] = "WS2032 weather station";
$config['protocols'][146] = "Auriol AFW2A1 temperature/humidity sensor";
$config['protocols'][147] = "TFA Drop Rain Gauge 30.3233.01";
$config['protocols'][148] = "DSC Security Contact (WS4945)";
$config['protocols'][149] = "ERT Standard Consumption Message (SCM)";
$config['protocols'][150] = "Klimalogg";
$config['protocols'][151] = "Visonic powercode";
$config['protocols'][152] = "Eurochron EFTH-800 temperature and humidity sensor";
$config['protocols'][153] = "Cotech 36-7959 wireless weather station with USB";
$config['protocols'][154] = "Standard Consumption Message Plus (SCMplus)";
$config['protocols'][155] = "Fine Offset Electronics WH1080/WH3080 Weather Station (FSK)";
$config['protocols'][156] = "Abarth 124 Spider TPMS";
$config['protocols'][157] = "Missil ML0757 weather station";
$config['protocols'][158] = "Sharp SPC775 weather station";
$config['protocols'][159] = "Insteon";
$config['protocols'][160] = "ERT Interval Data Message (IDM)";
$config['protocols'][161] = "ERT Interval Data Message (IDM) for Net Meters";
$config['protocols'][162] = "ThermoPro-TX2 temperature sensor";
$config['protocols'][163] = "Acurite 590TX Temperature with optional Humidity";
$config['protocols'][164] = "Security+ 2.0 (Keyfob)";
$config['protocols'][165] = "TFA Dostmann 30.3221.02 T/H Outdoor Sensor";
$config['protocols'][166] = "LaCrosse Technology View LTV-WSDTH01 Breeze Pro Wind Sensor";
$config['protocols'][167] = "Somfy RTS";
$config['protocols'][168] = "Schrader TPMS SMD3MA4 (Subaru)";
$config['protocols'][169] = "Nice Flor-s remote control for gates";
$config['protocols'][170] = "LaCrosse Technology View LTV-WR1 Multi Sensor";
$config['protocols'][171] = "LaCrosse Technology View LTV-TH Thermo/Hygro Sensor";
$config['protocols'][172] = "Bresser Weather Center 6-in-1, 7-in-1 indoor, new 5-in-1, 3-in-1 wind gauge, Froggit WH6000, Ventus C8488A";
$config['protocols'][173] = "Bresser Weather Center 7-in-1";
$config['protocols'][174] = "EcoDHOME Smart Socket and MCEE Solar monitor";
$config['protocols'][175] = "LaCrosse Technology View LTV-R1 Rainfall Gauge";
$config['protocols'][176] = "BlueLine Power Monitor";
$config['protocols'][177] = "Burnhard BBQ thermometer";
$config['protocols'][178] = "Security+ (Keyfob)";
$config['protocols'][179] = "Cavius smoke, heat and water detector";
$config['protocols'][180] = "Jansite TPMS Model Solar";
$config['protocols'][181] = "Amazon Basics Meat Thermometer";
$config['protocols'][182] = "TFA Marbella Pool Thermometer";
$config['protocols'][183] = "Auriol AHFL temperature/humidity sensor";
$config['protocols'][184] = "Auriol AFT 77 B2 temperature sensor";
$config['protocols'][185] = "Honeywell CM921 Wireless Programmable Room Thermostat";
$config['protocols'][186] = "Hyundai TPMS (VDO)";
$config['protocols'][187] = "RojaFlex shutter and remote devices";
$config['protocols'][188] = "Marlec Solar iBoost+ sensors";
$config['protocols'][189] = "Somfy io-homecontrol";
$config['protocols'][190] = "Ambient Weather (Fine Offset) WH31L Lightning-Strike sensor";
$config['protocols'][191] = "Markisol, E-Motion, BOFU, Rollerhouse, BF-30x, BF-415 curtain remote";
$config['protocols'][192] = "Govee Water Leak Dectector H5054, Door Contact Sensor B5023";

?>