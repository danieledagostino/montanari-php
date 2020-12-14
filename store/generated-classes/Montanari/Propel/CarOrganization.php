<?php

namespace Montanari\Propel;

use Montanari\Propel\Base\CarOrganization as BaseCarOrganization;

/**
 * Skeleton subclass for representing a row from the 'car_organization' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class CarOrganization extends BaseCarOrganization
{

	private $seats_available;
	
	private $seats_taken;
	
	/**
	 * Get the [seats_available] value.
	 *
	 * @return int
	 */
	public function getSeatsAvailable()
	{
		return $this->seats_available;
	}
	
	/**
	 * Get the [seats_taken] value.
	 *
	 * @return int
	 */
	public function getSeatsTaken()
	{
		return $this->seats_taken;
	}
	
	/**
	 * Set the [seats_available] value.
	 *
	 * @return int
	 */
	public function setSeatsAvailable($seats_available)
	{
		$this->seats_available = $seats_available;
	}
	
	/**
	 * Set the [seats_taken] value.
	 *
	 * @return int
	 */
	public function setSeatsTaken($seats_taken)
	{
		$this->seats_taken = $seats_taken;
	}
}
