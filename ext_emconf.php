<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "ratings".
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'Ratings',
	'description' => 'Modern AJAX-based ratings system. Public free support is provided only through typo3.slack.com! Contact by e-mail for commercial support.',
	'category' => 'plugin',
	'version' => '3.0.0',
	'state' => 'beta',
	'uploadfolder' => 0,
	'createDirs' => '',
	'clearcacheonload' => 0,
	'author' => 'Netcreators BV',
	'author_email' => 'extensions@netcreators.com',
	'author_company' => 'Netcreators BV',
	'constraints' => 
	array (
		'depends' => 
		array (
			'php' => '5.5.0-7.99.99',
            'typo3' => '6.2.0-9.3.99'
		),
		'conflicts' => 
		array (
		),
		'suggests' => 
		array (
		),
	),
);

