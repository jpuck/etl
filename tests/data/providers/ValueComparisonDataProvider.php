<?php
// [champion], [contender], [expected]
return [
	[
		['measure'=>0], ['measure'=>1], ['measure'=>1]
	],
	[
		['measure'=>1], ['measure'=>0], ['measure'=>1]
	],
	[
		['measure'=>0], ['measure'=>0], ['measure'=>0]
	],
	[
		['measure'=>1], ['measure'=>1], ['measure'=>1]
	],
	[
		['measure'=>1,'value'=>6],
		['measure'=>1,'value'=>9],
		['measure'=>1,'value'=>6]
	],
	[
		['value'=>0], ['value'=>1], ['value'=>1]
	],
	[
		['value'=>1], ['value'=>0], ['value'=>1]
	],
	[
		['value'=>0], ['value'=>0], ['value'=>0]
	],
	[
		['value'=>1], ['value'=>1], ['value'=>1]
	],
	[
		['measure'=>0], ['measure'=>1], ['measure'=>0], ['min']
	],
	[
		['measure'=>1], ['measure'=>0], ['measure'=>0], ['min']
	],
	[
		['measure'=>0], ['measure'=>0], ['measure'=>0], ['min']
	],
	[
		['measure'=>1], ['measure'=>1], ['measure'=>1], ['min']
	],
	[
		['measure'=>1,'value'=>3],
		['measure'=>1,'value'=>2],
		['measure'=>1,'value'=>3], ['min']
	],
	[
		['value'=>0], ['value'=>1], ['value'=>0], ['min']
	],
	[
		['value'=>1], ['value'=>0], ['value'=>0], ['min']
	],
	[
		['value'=>0], ['value'=>0], ['value'=>0], ['min']
	],
	[
		['value'=>1], ['value'=>1], ['value'=>1], ['min']
	],
];
