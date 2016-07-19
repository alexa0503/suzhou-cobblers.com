<?php

return [

	// The default gateway to use
	'default' => 'alipay',

	// Add in each gateway here
	'gateways' => [
		'paypal' => [
			'driver'  => 'PayPal_Express',
			'options' => [
				'solutionType'   => ['Sole', 'Mark'],
				'landingPage'    => ['Billing', 'Login'],
				//'headerImageUrl' => '',
				'testMode' => true,
				'username' => 'wanga503_api1.outlook.com',
				'password' => '4EJD4PL8MY7728PY',
				'signature' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AVIQGUkRv-6UA72GyUIXh0zspm0J'
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
