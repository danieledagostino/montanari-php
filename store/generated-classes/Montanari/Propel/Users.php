<?php

namespace Montanari\Propel;

use Montanari\Propel\Base\Users as BaseUsers;

/**
 * Skeleton subclass for representing a row from the 'users' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Users extends BaseUsers
{

	public function fill(array $data)
	{
		$this->setUsername($data["username"]);
		$this->setNome($data["nome"]);
		$this->setCognome($data["cognome"]);
		$this->setPassword(md5($data["password"]));
		//$this->abitazione = $data["abitazione"];
		//$this->autonomia = $data["autonomia"];
		$this->setEmail($data["email"]);
	}
	
	public function fullName(){
	    return $this->getNome()." ".$this->getCognome();
	}
}
