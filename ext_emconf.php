<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "ratings".
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'Ratings',
	'description' => 'Modern AJAX-based ratings system. Public free support is provided only through typo3.slack.com! Contact by e-mail for commercial support.',
	'category' => 'plugin',
	'version' => '3.0.1',
	'state' => 'beta',
	'uploadfolder' => 0,
	'createDirs' => '',
	'clearcacheonload' => 0,
	'author' => 'Netcreators',
	'author_email' => 'extensions@proudnerds.com',
	'author_company' => 'Proud Nerds',
	'constraints' => 
	array (
		'depends' => 
		array (
			'php' => '5.6.0-7.2.99',
            'typo3' => '7.6.0-8.7.99'
		),
		'conflicts' => 
		array (
		),
		'suggests' => 
		array (
		),
	),
);

