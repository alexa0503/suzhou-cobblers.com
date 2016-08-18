<?php

return [

	// The default gateway to use
	'default' => 'paypal',

	// Add in each gateway here
	'gateways' => [
		'paypal' => [
			'driver'  => 'PayPal_Express',
			'options' => [
				'solutionType'   => ['Sole', 'Mark'],
				'landingPage'    => ['Billing', 'Login'],
				//'headerImageUrl' => '',
				'testMode' => false,//true
				'username' => 'suzhou_cobblers_api1.yahoo.com',//wanga503-test_api1.outlook.com
				'password' => 'UPY3XZKWPWK8FDUL',//892NFR9D7BUZBZZV
				'signature' => 'AFi0V0uf6HmilKqFDdA50XrW8niNA12vfBY40H34smomGRrA2U.HZYH-'//AFcWxV21C7fd0v3bYYYRCpSSRl31AJ23cSbcrjCHuDRf6U8dtqC29mRH
			]
		],
		'alipay' => [
            'driver' => 'Alipay_Express',
            'options' => [
                'partner' => '2088102849184119',
                'key' => 'm3qu2mlackd1yhi8jijygvjkb23zmzbh',
                'sellerEmail' =>'suzhou_cobblers@yahoo.com',
                'returnUrl' => 'http://www.suzhou-cobblers.com/return',
                'notifyUrl' => 'http://www.suzhou-cobblers.com/notify'
            ]
        ]
	]

];
