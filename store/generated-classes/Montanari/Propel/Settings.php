<?php

namespace Montanari\Propel;

use Montanari\Propel\Base\Settings as BaseSettings;

/**
 * Skeleton subclass for representing a row from the 'user_settings' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Settings extends BaseSettings
{

	public function fill(array $data)
	{
		$this->setPushMessage($data["pushMessage"]);
		$this->setEmailMessage($data["emailMessage"]);
		$this->setEmailCarSummary($data["emailCarSummary"]);
		$this->setEmailEventSummary($data["emailEventSummary"]);
	}
}
