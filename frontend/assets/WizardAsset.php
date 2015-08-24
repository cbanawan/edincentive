<?php
namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class WizardAsset extends AssetBundle
{
    public $sourcePath = '@frontend/assets';
    public $js = [
        'bootstrap-wizard/jquery.bootstrap.wizard.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
