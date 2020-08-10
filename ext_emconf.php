<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "ratings".
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
	'title' => 'Ratings',
	'description' => 'Modern AJAX-based ratings system. Public free support is provided only through typo3.slack.com! Contact by e-mail for commercial support.',
	'category' => 'plugin',
	'version' => '3.2.0',
	'state' => 'beta',
	'uploadfolder' => 0,
	'createDirs' => '',
	'clearcacheonload' => 0,
	'author' => 'Netcreators',
	'author_email' => 'extensions@proudnerds.com',
	'author_company' => 'Proud Nerds',
	'constraints' => 
	[
		'depends' => 
		[
			'php' => '5.6.0-7.3.99',
            'typo3' => '7.6.0-9.5.99'
		],
		'conflicts' => 
		[
		],
		'suggests' => 
		[
            'typo3db_legacy' => '1.0.0-1.1.99',
		],
	],
];

