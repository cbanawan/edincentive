<?php
namespace common\components;

use yii\db\Connection;

class CustomDbConnection extends Connection
{
    /**
	 * Close the connection when serializing.
	 * @return array
	 */
	public function __sleep()
	{
		$this->close();
		return array_keys(get_object_vars($this));
	}
}

