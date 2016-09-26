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
										],
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
								],
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 19,
										'value' => 'Just One More Title',
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
								],
								'scale' =>
								[
									'max' =>
									[
										'measure' => 3,
										'value' => '-210.12',
									],
								],
								'precision' =>
								[
									'max' =>
									[
										'measure' => 3,
										'value' => '2.300',
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
