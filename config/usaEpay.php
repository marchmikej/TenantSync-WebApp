<?php

return [

	'testSoapUrl' => 'https://sandbox.usaepay.com/soap/gate/0AE595C1/usaepay.wsdl',
	
	'soapUrl' => 'https://www.usaepay.com/soap/gate/0AE595C1/usaepay.wsdl',

	// This is the key and pin for the TenantSync receiving account
	'sourceKey' => '_OAo2776ws1599T3Y5yLvX65d4j5G0y0',
	
	'pin' => '1234',
	//

	'usaEpayPath' => base_path().'/app/Services/usaepay-php/usaepay.php',
];