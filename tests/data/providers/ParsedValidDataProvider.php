<?php
return [
	'1) simple' => [
		['name'=>'one','value'=>1]
	],
	'2) nested' => [
		['name'=>'one','value'=>
			[['name'=>'two','value'=>2]]
		]
	],
	'3) attributes' => [
		['name'=>'one','value'=>1,'attributes'=>
			['something'=>'anything']
		]
	],
];
