<?php
return [
	'1) more than one root node' => [
		1, ['first'=>'one','second'=>'two']
	],
	'2) integer node name' => [
		2, [1=>'one']
	],
	'3) numeric node name' => [
		2, ['1'=>'one']
	],
	'4) empty node name' => [
		2, ['first']
	],
	'5) string (non-array) node value' => [
		3, ['first' => 'one']
	],
	'6) int (non-array) node value' => [
		3, ['first' => 1]
	],
	'7) object (non-array) node value' => [
		3, ['first' => new stdClass]
	],
	'8) empty array' => [
		4, ['first' => []]
	],
	'9) missing node count' => [
		4, ['first' => ['one']]
	],
	'10) count max measure = 0' => [
		4, [
			'first' =>
			[
				'count' =>
				[
					'max' =>
					[
						'measure' => 0
					]
				]
			]
		]
	],
	'11) recursive count max measure = 0' => [
		4, [
			'first' =>
			[
				'count' =>
				[
					'max' =>
					[
						'measure' => 1
					]
				],
				'elements' =>
				[
					'second' =>
					[
						'count' =>
						[
							'max' =>
							[
								'measure' => 0
							]
						],
					],
				],
			]
		]
	],
	'12) recursive integer node name' => [
		2, [
			'first' =>
			[
				'count' =>
				[
					'max' =>
					[
						'measure' => 1
					]
				],
				'elements' =>
				[
					'second' =>
					[
						'count' =>
						[
							'max' =>
							[
								'measure' => 1
							]
						],
					],
					1 =>
					[
						'count' =>
						[
							'max' =>
							[
								'measure' => 1
							]
						],
					],
				],
			]
		]
	],
	'13) attribute integer node name' => [
		2, [
			'first' =>
			[
				'count' =>
				[
					'max' =>
					[
						'measure' => 1
					]
				],
				'attributes' =>
				[
					'second' =>
					[
					],
					1 =>
					[
					],
				],
			]
		]
	],
	'14) attribute varchar no max' => [
		5, [
			'first' =>
			[
				'count' =>
				[
					'max' =>
					[
						'measure' => 1
					]
				],
				'attributes' =>
				[
					'second' =>
					[
						'varchar' =>
						[
							'min' =>
							[
								'measure' => 10,
								'value' => '2016-09-11'
							]
						]
					],
				],
			]
		]
	],
	'15) attribute varchar no max measure' => [
		5, [
			'first' =>
			[
				'count' =>
				[
					'max' =>
					[
						'measure' => 1
					]
				],
				'attributes' =>
				[
					'second' =>
					[
						'varchar' =>
						[
							'max' =>
							[
								'value' => '2016-09-16 11:00:00'
							],
							'min' =>
							[
								'measure' => 10,
								'value' => '2016-09-11'
							]
						]
					],
				],
			]
		]
	],
	'16) attribute varchar no max value' => [
		5, [
			'first' =>
			[
				'count' =>
				[
					'max' =>
					[
						'measure' => 1
					]
				],
				'attributes' =>
				[
					'second' =>
					[
						'varchar' =>
						[
							'max' =>
							[
								'measure' => 19,
							],
							'min' =>
							[
								'measure' => 10,
								'value' => '2016-09-11'
							]
						]
					],
				],
			]
		]
	],
	'17) attribute datetime no max value' => [
		6, [
			'first' =>
			[
				'count' =>
				[
					'max' =>
					[
						'measure' => 1
					]
				],
				'attributes' =>
				[
					'second' =>
					[
						'datetime' =>
						[
							'max' =>
							[
								'measure' => 19,
							],
							'min' =>
							[
								'measure' => 10,
								'value' => '2016-09-11'
							]
						]
					],
				],
			]
		]
	],
	'18) element datetime no max value' => [
		6, [
			'first' =>
			[
				'count' =>
				[
					'max' =>
					[
						'measure' => 1
					]
				],
				'datetime' =>
				[
					'max' =>
					[
						'measure' => 19,
					],
					'min' =>
					[
						'measure' => 10,
						'value' => '2016-09-11'
					]
				]
			]
		]
	],
	'19) element decimal no max value' => [
		6, [
			'first' =>
			[
				'count' =>
				[
					'max' =>
					[
						'measure' => 1
					]
				],
				'decimal' =>
				[
					'max' =>
					[
						'measure' => 19,
					],
					'min' =>
					[
						'measure' => 10,
						'value' => '2016-09-11'
					]
				]
			]
		]
	],
	'20) element decimal no scale or precision' => [
		7, [
			'first' =>
			[
				'count' =>
				[
					'max' =>
					[
						'measure' => 1
					]
				],
				'decimal' =>
				[
					'max' =>
					[
						'value' => '42.21',
					],
					'min' =>
					[
						'value' => '-210.12',
					],
				],
			]
		]
	],
	'21) element decimal no scale' => [
		7, [
			'first' =>
			[
				'count' =>
				[
					'max' =>
					[
						'measure' => 1
					]
				],
				'decimal' =>
				[
					'max' =>
					[
						'value' => '42.21',
					],
					'min' =>
					[
						'value' => '-210.12',
					],
				],
				'precision' =>
				[
					'max' =>
					[
						'value' => '2.300',
						'measure' => 3,
					],
					'min' =>
					[
						'value' => '42.21',
						'measure' => 2,
					],
				],
			]
		]
	],
	'22) element decimal no precision' => [
		7, [
			'first' =>
			[
				'count' =>
				[
					'max' =>
					[
						'measure' => 1
					]
				],
				'decimal' =>
				[
					'max' =>
					[
						'value' => '42.21',
					],
					'min' =>
					[
						'value' => '-210.12',
					],
				],
				'scale' =>
				[
					'max' =>
					[
						'value' => '-210.12',
						'measure' => 5,
					],
					'min' =>
					[
						'value' => '42.21',
						'measure' => 4,
					],
				],
			]
		]
	],
	'23) element decimal no precision max value' => [
		7, [
			'first' =>
			[
				'count' =>
				[
					'max' =>
					[
						'measure' => 1
					]
				],
				'decimal' =>
				[
					'max' =>
					[
						'value' => '42.21',
					],
					'min' =>
					[
						'value' => '-210.12',
					],
				],
				'scale' =>
				[
					'max' =>
					[
						'value' => '-210.12',
						'measure' => 5,
					],
					'min' =>
					[
						'value' => '42.21',
						'measure' => 4,
					],
				],
				'precision' =>
				[
					'max' =>
					[
						'measure' => 3,
					],
					'min' =>
					[
						'value' => '42.21',
						'measure' => 2,
					],
				],
			]
		]
	],
	'24) element decimal no precision max measure' => [
		7, [
			'first' =>
			[
				'count' =>
				[
					'max' =>
					[
						'measure' => 1
					]
				],
				'decimal' =>
				[
					'max' =>
					[
						'value' => '42.21',
					],
					'min' =>
					[
						'value' => '-210.12',
					],
				],
				'scale' =>
				[
					'max' =>
					[
						'value' => '-210.12',
						'measure' => 5,
					],
					'min' =>
					[
						'value' => '42.21',
						'measure' => 4,
					],
				],
				'precision' =>
				[
					'max' =>
					[
						'value' => '2.300',
					],
					'min' =>
					[
						'value' => '42.21',
						'measure' => 2,
					],
				],
			]
		]
	],
	'25) element decimal no scale max value' => [
		7, [
			'first' =>
			[
				'count' =>
				[
					'max' =>
					[
						'measure' => 1
					]
				],
				'decimal' =>
				[
					'max' =>
					[
						'value' => '42.21',
					],
					'min' =>
					[
						'value' => '-210.12',
					],
				],
				'scale' =>
				[
					'max' =>
					[
						'measure' => 5,
					],
					'min' =>
					[
						'value' => '42.21',
						'measure' => 4,
					],
				],
				'precision' =>
				[
					'max' =>
					[
						'value' => '2.300',
						'measure' => 3,
					],
					'min' =>
					[
						'value' => '42.21',
						'measure' => 2,
					],
				],
			]
		]
	],
	'26) element decimal no scale max measure' => [
		7, [
			'first' =>
			[
				'count' =>
				[
					'max' =>
					[
						'measure' => 1
					]
				],
				'decimal' =>
				[
					'max' =>
					[
						'value' => '42.21',
					],
					'min' =>
					[
						'value' => '-210.12',
					],
				],
				'scale' =>
				[
					'max' =>
					[
						'value' => '-210.12',
					],
					'min' =>
					[
						'value' => '42.21',
						'measure' => 4,
					],
				],
				'precision' =>
				[
					'max' =>
					[
						'value' => '2.300',
						'measure' => 3,
					],
					'min' =>
					[
						'value' => '42.21',
						'measure' => 2,
					],
				],
			]
		]
	],
	'27) children has no distinct count' => [
		8, [
			'first' =>
			[
				'count' =>
				[
					'max' =>
					[
						'measure' => 1
					]
				],
				'children' =>
				[
					'count' =>
					[
						'max' =>
						[
							'measure' => 3,
						]
					],
				],
			]
		]
	],
	'28) children has negative distinct count' => [
		8, [
			'first' =>
			[
				'count' =>
				[
					'max' =>
					[
						'measure' => 1
					]
				],
				'children' =>
				[
					'distinct' => -1,
					'count' =>
					[
						'max' =>
						[
							'measure' => 3,
						]
					],
				],
			]
		]
	],
	'29) children has non-numeric distinct count' => [
		8, [
			'first' =>
			[
				'count' =>
				[
					'max' =>
					[
						'measure' => 1
					]
				],
				'children' =>
				[
					'distinct' => 'one',
					'count' =>
					[
						'max' =>
						[
							'measure' => 3,
						]
					],
				],
			]
		]
	],
	'30) children has array distinct count' => [
		8, [
			'first' =>
			[
				'count' =>
				[
					'max' =>
					[
						'measure' => 1
					]
				],
				'children' =>
				[
					'distinct' => [1],
					'count' =>
					[
						'max' =>
						[
							'measure' => 3,
						]
					],
				],
			]
		]
	],
	'31) children has zero count' => [
		4, [
			'first' =>
			[
				'count' =>
				[
					'max' =>
					[
						'measure' => 1
					]
				],
				'children' =>
				[
					'distinct' => 1,
					'count' =>
					[
						'max' =>
						[
							'measure' => 0,
						]
					],
				],
			]
		]
	],
	'32) conflicting datatypes int and decimal' => [
		9, [
			'first' =>
			[
				'count' =>
				[
					'max' =>
					[
						'measure' => 1
					]
				],
				'children' =>
				[
					'distinct' => 1,
					'count' =>
					[
						'max' =>
						[
							'measure' => 1,
						]
					],
				],
				'elements' =>
				[
					"item_id" =>
					[
						"count" =>
						[
							"max"=>
							[
								"measure"=> 1
							],
							"min" =>
							[
								"measure"=> 1
							]
						],
						"int" =>
						[
							"max" =>
							[
								"value" => 1022568213
							],
							"min" =>
							[
								"value"=> 1000331053
							]
						],
						'decimal' =>
						[
							'max' =>
							[
								'value' => '1022568213',
							],
							'min' =>
							[
								'value' => '-210.12',
							],
						],
						'scale' =>
						[
							'max' =>
							[
								'measure' => 10,
								'value' => '1022568213',
							],
							'min' =>
							[
								'measure' => 1,
								'value' => '2.300',
							],
						],
						'precision' =>
						[
							'max' =>
							[
								'measure' => 3,
								'value' => '2.300',
							],
							'min' =>
							[
								'measure' => 0,
								'value' => '1022568213',
							],
						],
						'varchar' =>
						[
							'max' =>
							[
								'measure' => 10,
								'value' => '1022568213',
							],
							'min' =>
							[
								'measure' => 5,
								'value' => '42.21',
							],
						],
					],
				],
			]
		]
	],
];
