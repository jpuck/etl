<?php

return [
	'Data' =>
	[
		'count' =>
		[
			'max' =>
			[
				'measure' => 1,
			],
		],
		'attributes' =>
		[
			'date' =>
			[
				'unique' => 1,
				'datetime' =>
				[
					'max' =>
					[
						'value' => '2016-08-23',
					],
				],
				'varchar' =>
				[
					'max' =>
					[
						'measure' => 10,
						'value' => '2016-08-23',
					],
				],
			],
		],
		'children' =>
		[
			'distinct' => 1,
			'count' =>
			[
				'max' =>
				[
					'measure' => 3,
				],
			],
		],
		'elements' =>
		[
			'Record' =>
			[
				'count' =>
				[
					'max' =>
					[
						'measure' => 3,
					],
				],
				'attributes' =>
				[
					'id' =>
					[
						'unique' => 1,
						'int' =>
						[
							'max' =>
							[
								'value' => '22',
							],
							'min' =>
							[
								'value' => '20',
							],
						],
						'varchar' =>
						[
							'max' =>
							[
								'measure' => 2,
								'value' => '20',
							],
						],
					],
				],
				'children' =>
				[
					'distinct' => 1,
					'count' =>
					[
						'max' =>
						[
							'measure' => 3,
						],
						'min' =>
						[
							'measure' => 1,
						],
					],
				],
				'elements' =>
				[
					'SAMPLE' =>
					[
						'count' =>
						[
							'max' =>
							[
								'measure' => 3,
							],
							'min' =>
							[
								'measure' => 1,
							],
						],
						'attributes' =>
						[
							'id' =>
							[
								'unique' => 1,
								'int' =>
								[
									'max' =>
									[
										'value' => '6',
									],
									'min' =>
									[
										'value' => '1',
									],
								],
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 1,
										'value' => '1',
									],
								],
							],
							'created' =>
							[
								'unique' => 1,
								'datetime' =>
								[
									'max' =>
									[
										'value' => '2016-09-16 12:00:00',
									],
									'min' =>
									[
										'value' => '2016-09-11',
									],
								],
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 19,
										'value' => '2016-09-16 11:00:00',
									],
									'min' =>
									[
										'measure' => 10,
										'value' => '2016-09-11',
									],
								],
							],
						],
						'children' =>
						[
							'distinct' => 8,
							'count' =>
							[
								'max' =>
								[
									'measure' => 11,
								],
								'min' =>
								[
									'measure' => 8,
								],
							],
						],
						'elements' =>
						[
							'ADMIN_DEP' =>
							[
								'count' =>
								[
									'max' =>
									[
										'measure' => 1,
									],
								],
								'attributes' =>
								[
									'id' =>
									[
										'int' =>
										[
											'max' =>
											[
												'value' => '131951073242',
											],
										],
										'varchar' =>
										[
											'max' =>
											[
												'measure' => 12,
												'value' => '131951073242',
											],
										],
									],
									'primaryKey' =>
									[
										'varchar' =>
										[
											'max' =>
											[
												'measure' => 10,
												'value' => 'Management',
											],
										],
									],
								],
								'children' =>
								[
									'distinct' => 1,
									'count' =>
									[
										'max' =>
										[
											'measure' => 1,
										],
									],
								],
								'elements' =>
								[
									'DEP' =>
									[
										'count' =>
										[
											'max' =>
											[
												'measure' => 1,
											],
										],
										'varchar' =>
										[
											'max' =>
											[
												'measure' => 10,
												'value' => 'Management',
											],
										],
									],
								],
							],
							'SUPP_DEP' =>
							[
								'count' =>
								[
									'max' =>
									[
										'measure' => 1,
									],
								],
								'attributes' =>
								[
									'id' =>
									[
										'int' =>
										[
											'max' =>
											[
												'value' => '131951073241',
											],
										],
										'varchar' =>
										[
											'max' =>
											[
												'measure' => 12,
												'value' => '131951073241',
											],
										],
									],
									'primaryKey' =>
									[
										'varchar' =>
										[
											'max' =>
											[
												'measure' => 19,
												'value' => 'Information Systems',
											],
										],
									],
								],
								'children' =>
								[
									'distinct' => 1,
									'count' =>
									[
										'max' =>
										[
											'measure' => 2,
										],
										'min' =>
										[
											'measure' => 1,
										],
									],
								],
								'elements' =>
								[
									'DEP' =>
									[
										'count' =>
										[
											'max' =>
											[
												'measure' => 2,
											],
											'min' =>
											[
												'measure' => 1,
											],
										],
										'varchar' =>
										[
											'max' =>
											[
												'measure' => 19,
												'value' => 'Information Systems',
											],
											'min' =>
											[
												'measure' => 10,
												'value' => 'Management',
											],
										],
									],
								],
							],
							'CONTRACT_TERM' =>
							[
								'unique' => 1,
								'count' =>
								[
									'max' =>
									[
										'measure' => 1,
									],
								],
								'datetime' =>
								[
									'max' =>
									[
										'value' => '12 month',
									],
									'min' =>
									[
										'value' => '9 month',
									],
								],
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 8,
										'value' => '12 month',
									],
									'min' =>
									[
										'measure' => 7,
										'value' => '9 month',
									],
								],
							],
							'TITLE' =>
							[
								'unique' => 1,
								'count' =>
								[
									'max' =>
									[
										'measure' => 2,
									],
									'min' =>
									[
										'measure' => 1,
									],
								],
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 19,
										'value' => 'Just One More Title',
									],
									'min' =>
									[
										'measure' => 13,
										'value' => 'Another Title',
									],
								],
							],
							'SAMPLE_AUTH' =>
							[
								'count' =>
								[
									'max' =>
									[
										'measure' => 2,
									],
									'min' =>
									[
										'measure' => 1,
									],
								],
								'attributes' =>
								[
									'id' =>
									[
										'unique' => 1,
										'int' =>
										[
											'max' =>
											[
												'value' => '10',
											],
											'min' =>
											[
												'value' => '7',
											],
										],
										'varchar' =>
										[
											'max' =>
											[
												'measure' => 2,
												'value' => '10',
											],
											'min' =>
											[
												'measure' => 1,
												'value' => '7',
											],
										],
									],
								],
								'children' =>
								[
									'distinct' => 7,
									'count' =>
									[
										'max' =>
										[
											'measure' => 7,
										],
									],
								],
								'elements' =>
								[
									'FACULTY_NAME' =>
									[
										'count' =>
										[
											'max' =>
											[
												'measure' => 1,
											],
										],
										'int' =>
										[
											'max' =>
											[
												'value' => '4242',
											],
											'min' =>
											[
												'value' => '4141',
											],
										],
										'varchar' =>
										[
											'max' =>
											[
												'measure' => 4,
												'value' => '4242',
											],
										],
										'attributes' =>
										[
											'fid' =>
											[
												'int' =>
												[
													'max' =>
													[
														'value' => '4242',
													],
													'min' =>
													[
														'value' => '4141',
													],
												],
												'varchar' =>
												[
													'max' =>
													[
														'measure' => 4,
														'value' => '4242',
													],
												],
											],
										],
									],
									'FNAME' =>
									[
										'count' =>
										[
											'max' =>
											[
												'measure' => 1,
											],
										],
										'varchar' =>
										[
											'max' =>
											[
												'measure' => 4,
												'value' => 'John',
											],
										],
									],
									'MNAME' =>
									[
										'count' =>
										[
											'max' =>
											[
												'measure' => 1,
											],
										],
									],
									'LNAME' =>
									[
										'count' =>
										[
											'max' =>
											[
												'measure' => 1,
											],
										],
										'varchar' =>
										[
											'max' =>
											[
												'measure' => 3,
												'value' => 'Doe',
											],
										],
									],
									'ISSTUDENT' =>
									[
										'count' =>
										[
											'max' =>
											[
												'measure' => 1,
											],
										],
									],
									'DISPLAY' =>
									[
										'count' =>
										[
											'max' =>
											[
												'measure' => 1,
											],
										],
										'varchar' =>
										[
											'max' =>
											[
												'measure' => 2,
												'value' => 'No',
											],
											'min' =>
											[
												'measure' => 1,
												'value' => '1',
											],
										],
									],
									'INITIATION' =>
									[
										'unique' => 1,
										'count' =>
										[
											'max' =>
											[
												'measure' => 1,
											],
										],
										'datetime' =>
										[
											'max' =>
											[
												'value' => '2016-08-01T14:00:06',
											],
											'min' =>
											[
												'value' => '2016-08-01T14:00:02',
											],
										],
										'varchar' =>
										[
											'max' =>
											[
												'measure' => 19,
												'value' => '2016-08-01T14:00:04',
											],
										],
									],
								],
							],
							'PRICE' =>
							[
								'unique' => 1,
								'count' =>
								[
									'max' =>
									[
										'measure' => 1,
									],
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
										'measure' => 3,
										'value' => '-210.12',
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
										'measure' => 2,
										'value' => '42.21',
									],
								],
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 7,
										'value' => '-210.12',
									],
									'min' =>
									[
										'measure' => 5,
										'value' => '42.21',
									],
								],
							],
							'SAMPLE_EDITOR' =>
							[
								'count' =>
								[
									'max' =>
									[
										'measure' => 2,
									],
									'min' =>
									[
										'measure' => 1,
									],
								],
								'attributes' =>
								[
									'id' =>
									[
										'unique' => 1,
										'int' =>
										[
											'max' =>
											[
												'value' => '14',
											],
											'min' =>
											[
												'value' => '11',
											],
										],
										'varchar' =>
										[
											'max' =>
											[
												'measure' => 2,
												'value' => '11',
											],
										],
									],
								],
								'children' =>
								[
									'distinct' => 5,
									'count' =>
									[
										'max' =>
										[
											'measure' => 5,
										],
									],
								],
								'elements' =>
								[
									'FACULTY_NAME' =>
									[
										'count' =>
										[
											'max' =>
											[
												'measure' => 1,
											],
										],
									],
									'FNAME' =>
									[
										'count' =>
										[
											'max' =>
											[
												'measure' => 1,
											],
										],
									],
									'MNAME' =>
									[
										'count' =>
										[
											'max' =>
											[
												'measure' => 1,
											],
										],
									],
									'LNAME' =>
									[
										'count' =>
										[
											'max' =>
											[
												'measure' => 1,
											],
										],
									],
									'DISPLAY' =>
									[
										'count' =>
										[
											'max' =>
											[
												'measure' => 1,
											],
										],
									],
								],
							],
							'ABSTRACT' =>
							[
								'count' =>
								[
									'max' =>
									[
										'measure' => 1,
									],
								],
							],
						],
					],
				],
			],
		],
	],
];
