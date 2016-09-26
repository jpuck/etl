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
								],
							],
						],
					],
				],
			],
		],
	],
];
