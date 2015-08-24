<?php
use yii\db\Migration;
use yii\db\Expression;

class m140419_025914_initialize_user_type extends Migration
{
	public function up()
	{
        $sql = " SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
        SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
        SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';";
        $this->execute($sql);
        // Initialize User Type records
		$userTypes = [
			[
				'userTypeId' => 1, 
				'userTypeName' => 'admin',
			],
            [
				'userTypeId' => 2, 
				'userTypeName' => 'webUser',
			],
		];
		
		foreach($userTypes as $userType)
		{
			$userType['dateCreated'] = new Expression('NOW()');
			$userType['dateLastModified'] = new Expression('NOW()');
            try{
                $this->insert('UserType', $userType);
            }
            catch(yii\db\Exception $e)
            {
                //do nothing
                Yii::$app->session->setFlash('danger', $e->getMessage());
            }
		}
        
        // Initialize User Status Records
		$userTypes = [
			[
				'userId' => 1, 
				'userTypeName' => 'admin',
			],
            [
				'userTypeId' => 2, 
				'userTypeName' => 'webUser',
			],
		];
		
		foreach($userTypes as $userType)
		{
			$userType['dateCreated'] = new Expression('NOW()');
			$userType['dateLastModified'] = new Expression('NOW()');
            try{
                $this->insert('UserType', $userType);
            }
            catch(yii\db\Exception $e)
            {
                //do nothing
                Yii::$app->session->setFlash('danger', $e->getMessage());
            }
		}
        
        // Initialize Admin User
        $adminUser = [
            'userName' => 'admin',
            'userEmail' => Yii::$app->params['adminEmail'],
            'userPassword' => Yii::$app->security->generatePasswordHash('admin'),
            'userStatusId' => 1,
            'userTypeId' => 1
        ];
        
        try{
            $this->insert('User', $adminUser);
        }
        catch(yii\db\Exception $e)
        {
            //do nothing
            Yii::$app->session->setFlash('danger', $e->getMessage());
        }
        $sql = "SET SQL_MODE=@OLD_SQL_MODE;
        SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
        SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;";
        $this->execute($sql);
	}

	public function down()
	{
		//echo "m140419_025914_initialize_member_status does not support migration down.\n";
		//return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}