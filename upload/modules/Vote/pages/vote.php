<?php
/*
 *	Made by Partydragen
 *  https://github.com/partydragen/Vote-Module
 *  https://partydragen.com
 *  NamelessMC version 2.2.0
 *
 *  License: MIT
 */

// Always define page name
define('PAGE', 'vote');
$page_title = $vote_language->get('vote', 'vote');
require_once(ROOT_PATH . '/core/templates/frontend_init.php');

// Get message
$vote_message = Settings::get('vote_message', 'You can manage this vote module in StaffCP -> Vote', 'Vote');

// Is vote message empty?
if (!empty($vote_message)) {
	$message_enabled = true;
}

// Get sites from database
$sites = DB::getInstance()->get("vote_sites", ["id", "<>", 0]);

$sites_array = [];
foreach ($sites->results() as $site) {
    $sites_array[] = [
        'name' => Output::getClean($site->name),
        'url' => Output::getClean($site->site),
    ];
}

// Assign Smarty variables
$template->getEngine()->addVariables([
	'VOTE_TITLE' => $vote_language->get('vote', 'vote'),
	'MESSAGE_ENABLED' => $message_enabled,
	'MESSAGE' => Output::getPurified($vote_message),
	'SITES' => $sites_array,
]);

// Load modules + template
Module::loadPage($user, $pages, $cache, $smarty, [$navigation, $cc_nav, $staffcp_nav], $widgets, $template);

$template->onPageLoad();

$template->getEngine()->addVariable('WIDGETS_LEFT', $widgets->getWidgets('left'));
$template->getEngine()->addVariable('WIDGETS_RIGHT', $widgets->getWidgets('right'));

require(ROOT_PATH . '/core/templates/navbar.php');
require(ROOT_PATH . '/core/templates/footer.php');

// Display template
$template->displayTemplate('vote');