<?php
/*
 *	Made by Partydragen
 *  https://github.com/partydragen/Vote-Module
 *  https://partydragen.com/
 *  NamelessMC version 2.0.0
 *
 *  License: MIT
 */

class Vote {
    /*
     *  Check for Module updates
     *  Returns JSON object with information about any updates
     */
    public static function updateCheck() {
        $current_version = Settings::get('nameless_version');
        $uid = Settings::get('unique_id');

		$enabled_modules = Module::getModules();
		foreach ($enabled_modules as $enabled_item) {
			if ($enabled_item->getName() == 'Vote') {
				$module = $enabled_item;
				break;
			}
		}

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, 'https://api.partydragen.com/stats.php?uid=' . $uid . '&version=' . $current_version . '&module=Vote&module_version='.$module->getVersion() . '&domain='. URL::getSelfURL());

        $update_check = curl_exec($ch);
        curl_close($ch);

		$info = json_decode($update_check);
		if (isset($info->message)) {
			die($info->message);
		}

        return $update_check;
    }
}