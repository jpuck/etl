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
	'5) non-array attributes' => [
		3, ['name'=>'one','value'=>1,'attributes'=>'something']
	],
	'6) numerically indexed attributes' => [
		4, ['name'=>'one','value'=>1,'attributes'=>['something']]
	],
	'7) name is array' => [
		5, ['name'=>['one'],'value'=>1]
	],
	'8) name is null' => [
		6, ['name'=>null,'value'=>1]
	],
	'9) name is nothing' => [
		6, ['name'=>'','value'=>1]
	],
	'10) name is false' => [
		6, ['name'=>false,'value'=>1]
	],
	'11) name is numeric' => [
		7, ['name'=>42,'value'=>1]
	],
	'12) name is true' => [
		8, ['name'=>true,'value'=>1]
	],
];
