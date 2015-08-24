<?php
namespace common\components;
/**
 * Author: Pavel Kostenko <poul.kg@gmail.com>
 * Date: 06.10.13
 * Time: 23:49
 */
use Yii;

class CGAssetManager extends \yii\web\AssetManager
{
    /**
     * @var array published assets
     */
    private $_published=array();
	
	public function init()
	{
		$origPath = $this->basePath;
		//exit('Orig Path '.$origPath.' Base Path '.$this->basePath.' '.(strpos($this->basePath, 'gs://')));
		if(0 !== strpos($this->basePath, 'gs://'))
			return parent::init();
		elseif(is_dir($origPath) && is_writable($origPath))
		{
			$this->basePath = $origPath;
		}            
        else
            throw new \yii\base\Exception(Yii::t('app','CAssetManager.basePath "{path}" is invalid. Please make sure the directory exists and is writable by the Web server process.',
                array('{path}'=>$origPath)));
		
		//exit($this->baseUrl);
	}

    public function getAssetPath($bundle, $asset)
	{
		exit();
		return parent::getAssetPath($bundle, $asset);
	}
	
	public function getPublishedPath($path)
	{
		exit();
		parent::getPublishedPath($path);
	}
	
	public function getPublishedUrl($path)
	{
		exit();
		\yii\helpers\VarDumper::dump($path);
		return parent::getPublishedUrl($path);
	}

    /**
     * Publishes a file or a directory.
     * This method will copy the specified asset to a web accessible directory
     * and return the URL for accessing the published asset.
     * <ul>
     * <li>If the asset is a file, its file modification time will be checked
     * to avoid unnecessary file copying;</li>
     * <li>If the asset is a directory, all files and subdirectories under it will
     * be published recursively. Note, in case $forceCopy is false the method only checks the
     * existence of the target directory to avoid repetitive copying.</li>
     * </ul>
     *
     * Note: On rare scenario, a race condition can develop that will lead to a
     * one-time-manifestation of a non-critical problem in the creation of the directory
     * that holds the published assets. This problem can be avoided altogether by 'requesting'
     * in advance all the resources that are supposed to trigger a 'publish()' call, and doing
     * that in the application deployment phase, before system goes live. See more in the following
     * discussion: http://code.google.com/p/yii/issues/detail?id=2579
     *
     * @param string $path the asset (file or directory) to be published
     * @param boolean $hashByName whether the published directory should be named as the hashed basename.
     * If false, the name will be the hash taken from dirname of the path being published and path mtime.
     * Defaults to false. Set true if the path being published is shared among
     * different extensions.
     * @param integer $level level of recursive copying when the asset is a directory.
     * Level -1 means publishing all subdirectories and files;
     * Level 0 means publishing only the files DIRECTLY under the directory;
     * level N means copying those directories that are within N levels.
     * @param boolean $forceCopy whether we should copy the asset file or directory even if it is already
     * published before. In case of publishing a directory old files will not be removed.
     * This parameter is set true mainly during development stage when the original
     * assets are being constantly changed. The consequence is that the performance is degraded,
     * which is not a concern during development, however. Default value of this parameter is null meaning
     * that it's value is controlled by {@link $forceCopy} class property. This parameter has been available
     * since version 1.1.2. Default value has been changed since 1.1.11.
     * Note that this parameter cannot be true when {@link $linkAssets} property has true value too. Otherwise
     * an exception would be thrown. Using this parameter with {@link $linkAssets} property at the same time
     * is illogical because both of them are solving similar tasks but in a different ways. Please refer
     * to the {@link $linkAssets} documentation for more details.
     * @return string an absolute URL to the published asset
     * @throws CException if the asset to be published does not exist.
     */
    public function publish($path,  $options = ['forceCopy' => null])
    {
        $path = Yii::getAlias($path);
		if(!(isset($options['forceCopy'])) || $options['forceCopy'] === null)
            $forceCopy=$this->forceCopy;
		
        if($forceCopy && $this->linkAssets)
            throw new \yii\base\Exception(Yii::t('app','The "forceCopy" and "linkAssets" cannot be both true.'));
        
		if(isset($this->_published[$path]))
            return $this->_published[$path];
        
		elseif(($src = realpath($path))!==false)
        {
            $dir = $this->hash($src);
            $dstDir = $this->basePath.DIRECTORY_SEPARATOR.$dir;

            if(is_file($src))
            {
                $fileName=basename($src);
                $dstFile=$dstDir.DIRECTORY_SEPARATOR.$fileName;

                if(!is_dir($dstDir))
                {
                    mkdir($dstDir,$this->dirMode,true);
                    @chmod($dstDir,$this->dirMode);
                }

                if($this->linkAssets && !is_file($dstFile)) symlink($src,$dstFile);
                elseif(@filemtime($dstFile)<@filemtime($src))
                {
                    copy($src,$dstFile);
//                    @chmod($dstFile,$this->fileMode);
                }

                return $this->_published[$path] = [$dstFile, $this->baseUrl."/$dir/$fileName"];
            }
            elseif(is_dir($src))
            {
                if($this->linkAssets && !is_dir($dstDir))
                {
//                    exit('link');
                    symlink($src,$dstDir);
                }
                elseif(!is_dir($dstDir) || $forceCopy)
                {
//                    exit('copyDir');
                    CGFileHelper::copyDirectory($src,$dstDir,array(
                        'dirMode'=>$this->dirMode,
                        'fileMode'=>$this->fileMode,
                    ));
                }

                return $this->_published[$path] = [$dstDir, $this->baseUrl.'/'.$dir];
            }
        }
        throw new \yii\base\Exception(Yii::t('app',"The asset '$path' to be published does not exist.",
            array('{asset}'=>$path)));
		
		
    }
} 