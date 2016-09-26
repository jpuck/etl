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
					'userId' =>
					[
						'unique' => 1,
						'int' =>
						[
							'max' =>
							[
								'value' => '7654321',
							],
							'min' =>
							[
								'value' => '654321',
							],
						],
						'varchar' =>
						[
							'max' =>
							[
								'measure' => 7,
								'value' => '7654321',
							],
							'min' =>
							[
								'measure' => 6,
								'value' => '654321',
							],
						],
					],
					'username' =>
					[
						'unique' => 1,
						'varchar' =>
						[
							'max' =>
							[
								'measure' => 6,
								'value' => 'jeffpu',
							],
							'min' =>
							[
								'measure' => 5,
								'value' => 'jeffp',
							],
						],
					],
					'termId' =>
					[
						'int' =>
						[
							'max' =>
							[
								'value' => '129',
							],
						],
						'varchar' =>
						[
							'max' =>
							[
								'measure' => 3,
								'value' => '129',
							],
						],
					],
					'surveyId' =>
					[
						'unique' => 1,
						'int' =>
						[
							'max' =>
							[
								'value' => '16881965',
							],
							'min' =>
							[
								'value' => '1262550',
							],
						],
						'varchar' =>
						[
							'max' =>
							[
								'measure' => 8,
								'value' => '16881965',
							],
							'min' =>
							[
								'measure' => 7,
								'value' => '1262550',
							],
						],
					],
				],
				'children' =>
				[
					'distinct' => 2,
					'count' =>
					[
						'max' =>
						[
							'measure' => 6,
						],
						'min' =>
						[
							'measure' => 1,
						],
					],
				],
				'elements' =>
				[
					'IndexEntry' =>
					[
						'count' =>
						[
							'max' =>
							[
								'measure' => 4,
							],
						],
						'attributes' =>
						[
							'indexKey' =>
							[
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 13,
										'value' => 'QUALIFICATION',
									],
									'min' =>
									[
										'measure' => 4,
										'value' => 'RANK',
									],
								],
							],
							'entryKey' =>
							[
								'unique' => 1,
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 26,
										'value' => 'Instructional Practitioner',
									],
									'min' =>
									[
										'measure' => 7,
										'value' => 'Finance',
									],
								],
							],
							'text' =>
							[
								'unique' => 1,
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 26,
										'value' => 'Instructional Practitioner',
									],
									'min' =>
									[
										'measure' => 7,
										'value' => 'Finance',
									],
								],
							],
						],
					],
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
					'ADMIN' =>
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
										'value' => '131951073280',
									],
									'min' =>
									[
										'value' => '123352686592',
									],
								],
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 12,
										'value' => '131951073280',
									],
								],
							],
							'lastModified' =>
							[
								'unique' => 1,
								'datetime' =>
								[
									'max' =>
									[
										'value' => '2016-08-15T10:02:33',
									],
									'min' =>
									[
										'value' => '2016-01-15T12:35:18',
									],
								],
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 19,
										'value' => '2016-08-15T10:02:33',
									],
								],
							],
							'startDate' =>
							[
								'unique' => 1,
								'datetime' =>
								[
									'max' =>
									[
										'value' => '2016-09-01',
									],
									'min' =>
									[
										'value' => '2016-01-15',
									],
								],
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 10,
										'value' => '2016-09-01',
									],
								],
							],
							'endDate' =>
							[
								'unique' => 1,
								'datetime' =>
								[
									'max' =>
									[
										'value' => '2016-12-31',
									],
									'min' =>
									[
										'value' => '2016-04-30',
									],
								],
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 10,
										'value' => '2016-12-31',
									],
								],
							],
							'primaryKey' =>
							[
								'unique' => 1,
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 11,
										'value' => 'Summer|2016',
									],
									'min' =>
									[
										'measure' => 9,
										'value' => 'Fall|2016',
									],
								],
							],
						],
						'children' =>
						[
							'distinct' => 33,
							'count' =>
							[
								'max' =>
								[
									'measure' => 33,
								],
							],
						],
						'elements' =>
						[
							'TYT_TERM' =>
							[
								'unique' => 1,
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
										'measure' => 6,
										'value' => 'Summer',
									],
									'min' =>
									[
										'measure' => 4,
										'value' => 'Fall',
									],
								],
							],
							'TEACHING_WORKLOAD_WEIGHT' =>
							[
								'unique' => 1,
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
										'value' => '25',
									],
									'min' =>
									[
										'value' => '10',
									],
								],
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 2,
										'value' => '10',
									],
								],
							],
							'NPRESP' =>
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
										'measure' => 22,
										'value' => 'Undergraduate Teaching',
									],
								],
							],
							'FTE' =>
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
										'value' => '100',
									],
									'min' =>
									[
										'value' => '25',
									],
								],
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 3,
										'value' => '100',
									],
									'min' =>
									[
										'measure' => 2,
										'value' => '25',
									],
								],
							],
							'DEDMISS' =>
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
										'value' => '100',
									],
									'min' =>
									[
										'value' => '25',
									],
								],
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 3,
										'value' => '100',
									],
									'min' =>
									[
										'measure' => 2,
										'value' => '25',
									],
								],
							],
							'SABBATICAL_OTHER' =>
							[
								'unique' => 1,
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
										'measure' => 15,
										'value' => 'Maternity Leave',
									],
								],
							],
							'SABBATICAL' =>
							[
								'unique' => 1,
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
										'measure' => 5,
										'value' => 'Other',
									],
								],
							],
							'AACSBSUFF_JUST' =>
							[
								'unique' => 1,
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
										'measure' => 141,
										'value' => 'Instructor is actively working with and helping doctoral students while also interacting with the business community and department services.',
									],
								],
							],
							'AACSBSUFF' =>
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
										'measure' => 13,
										'value' => 'Participating',
									],
									'min' =>
									[
										'measure' => 10,
										'value' => 'Supporting',
									],
								],
							],
							'AACSBQUAL_JUST' =>
							[
								'unique' => 1,
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
										'measure' => 218,
										'value' => 'Dude Man has considerable expertise in operations, with over 200 years’ experience in operations at Business. His operations work continues in his current role as Operations director at Somewhere Community Centers.  ',
									],
								],
							],
							'AACSBQUAL' =>
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
										'measure' => 24,
										'value' => 'Professionally Qualified',
									],
								],
							],
							'QUALIFICATION_BASIS' =>
							[
								'unique' => 1,
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
										'measure' => 1354,
										'value' => '	Jeff teaches Introduction to Something on the undergraduate level and Multivariate Statistical Analysis on the doctoral level. For years, Jeff taught in all three of our programs, undergraduate, MBA, and PhD. Jeff is known for teaching excellence and has won multiple teaching and research awards, including best all-around faculty for the Super-Duper College. Jeff is currently serving on four doctoral dissertation committees; he is the most active faculty member in our doctoral program. Jeff had forty articles accepted for publication this year and three thousand articles published in the last three years. These articles were published in some of the top journals in Something including the Journal of Something Research. Jeff is the most prolific researcher in the Department and one of the most prolific researchers in the College and University. In addition, he is very active in national and international conferences publishing multiple proceedings articles. In 2014, a number of his articles won best paper awards. Jeff is very active as a reviewer, editorial board member, and conference organizer. For example, he was conference co-chair and co-organizer of the Southeast Something Symposium taking place in the Spring 2014. Jeff serves on the Department’s Graduate Program Committee and the College’s Promotion and Tenure Committee. ',
									],
								],
							],
							'QUALIFICATION' =>
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
										'measure' => 26,
										'value' => 'Instructional Practitioner',
									],
									'min' =>
									[
										'measure' => 18,
										'value' => 'Scholarly Academic',
									],
								],
							],
							'ADMINISTRATIVE_WORKLOAD_WEIGHT' =>
							[
								'unique' => 1,
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
										'value' => '0',
									],
								],
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 1,
										'value' => '0',
									],
								],
							],
							'SERVICE_WORKLOAD_WIEGHT' =>
							[
								'unique' => 1,
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
										'value' => '15',
									],
								],
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 2,
										'value' => '15',
									],
								],
							],
							'RESEARCH_WORKLOAD_WEIGHT' =>
							[
								'unique' => 1,
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
										'value' => '60',
									],
								],
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 2,
										'value' => '60',
									],
								],
							],
							'ABD_END' =>
							[
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
										'value' => '2012-04-30',
									],
								],
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 10,
										'value' => '2012-04-30',
									],
								],
							],
							'TYY_TERM' =>
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
										'value' => '2016',
									],
								],
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 4,
										'value' => '2016',
									],
								],
							],
							'ABD_START' =>
							[
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
										'value' => '2012-01-15',
									],
								],
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 10,
										'value' => '2012-01-15',
									],
								],
							],
							'TYY_ABD' =>
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
										'value' => '2012',
									],
								],
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 4,
										'value' => '2012',
									],
								],
							],
							'TYT_ABD' =>
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
										'measure' => 6,
										'value' => 'Spring',
									],
								],
							],
							'ABD_STATUS' =>
							[
								'unique' => 1,
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
										'measure' => 7,
										'value' => 'Non-ABD',
									],
								],
							],
							'GRADUATE' =>
							[
								'unique' => 1,
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
							'DISCIPLINE' =>
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
										'measure' => 26,
										'value' => 'Finance (includes Banking)',
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
										'value' => '9 month',
									],
								],
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 7,
										'value' => '9 month',
									],
								],
							],
							'ENDPOS' =>
							[
								'unique' => 1,
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
										'measure' => 57,
										'value' => 'Walter B. Cole Chair in Accounting, MAcc Program Director',
									],
								],
							],
							'TENURE' =>
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
										'measure' => 16,
										'value' => 'Non-Tenure Track',
									],
									'min' =>
									[
										'measure' => 7,
										'value' => 'Tenured',
									],
								],
							],
							'ACADEMIC_MODIFIER' =>
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
										'measure' => 8,
										'value' => 'Clinical',
									],
								],
							],
							'RANK' =>
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
										'measure' => 19,
										'value' => 'Assistant Professor',
									],
									'min' =>
									[
										'measure' => 15,
										'value' => 'Ph.D. Candidate',
									],
								],
							],
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
										'unique' => 1,
										'int' =>
										[
											'max' =>
											[
												'value' => '131951073281',
											],
											'min' =>
											[
												'value' => '123352686593',
											],
										],
										'varchar' =>
										[
											'max' =>
											[
												'measure' => 12,
												'value' => '131951073281',
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
											'min' =>
											[
												'measure' => 7,
												'value' => 'Finance',
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
											'min' =>
											[
												'measure' => 7,
												'value' => 'Finance',
											],
										],
									],
								],
							],
							'TERM_END' =>
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
										'value' => '2016-12-31',
									],
									'min' =>
									[
										'value' => '2016-04-30',
									],
								],
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 10,
										'value' => '2016-12-31',
									],
								],
							],
							'TERM_START' =>
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
										'value' => '2016-09-01',
									],
									'min' =>
									[
										'value' => '2016-01-15',
									],
								],
								'varchar' =>
								[
									'max' =>
									[
										'measure' => 10,
										'value' => '2016-09-01',
									],
								],
							],
							'AACSBTCLASS' =>
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
										'measure' => 45,
										'value' => 'Substantial coursework but no doctoral degree',
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
