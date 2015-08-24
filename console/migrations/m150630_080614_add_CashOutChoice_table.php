<?php

use yii\db\Schema;
use yii\db\Migration;

class m150630_080614_add_CashOutChoice_table extends Migration
{
    public function up()
    {
		$sql = "CREATE TABLE IF NOT EXISTS `CashOutChoice` (
			`cashOutChoiceId` INT NOT NULL AUTO_INCREMENT,
			`dateCreated` DATETIME NULL,
			`dateLastModified` DATETIME NULL,
			`cashOutType` INT NULL,
			`schoolDonationPercentage` INT NULL,
			`schoolDonationType` INT NULL,
			`schoolId` INT NULL,
			`schoolName` VARCHAR(256) NULL,
			`memberId` INT NULL,
			PRIMARY KEY (`cashOutChoiceId`),
			INDEX `memberId` (`memberId` ASC))
		  ENGINE = InnoDB";
		$this->execute($sql);
    }

    public function down()
    {
        //echo "m150630_080614_add_CashOutChoice_table cannot be reverted.\n";

        //return false;
    }
}
