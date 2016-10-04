<?php
return [
	'1) missing name' => [
		1, ['value'=>'one']
	],
	'2) missing value' => [
		2, ['name'=>'one']
	],
	'3) missing nested name' => [
		1, ['name'=>'one','value'=>
			[['value'=>2]]
		]
	],
	'4) missing nested value' => [
		2, ['name'=>'one','value'=>
			[['name'=>'two']]
		]
	],
];
