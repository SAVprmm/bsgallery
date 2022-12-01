<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\BaseInflector;

use yii\imagine\Image;  
use Imagine\Image\Box;

class GalleryAddForm extends Model
{
    /**
     * @var UploadedFile parameters for file upload
     */
    public $imageFile0;
    public $imageFile1;
    public $imageFile2;
    public $imageFile3;
    public $imageFile4;

    /**
     * @var imageFileXlastModify parameters for file last modify
     */
    public $imageFile0lastModify;
    public $imageFile1lastModify;
    public $imageFile2lastModify;
    public $imageFile3lastModify;
    public $imageFile4lastModify;

    public function rules()
    {
        
        $rules = [];
        $files = [];
        for($f = 0; $f < 5; $f++) {
            $files[] = [['imageFile'.$f], 'file', 'skipOnEmpty' => ($f != 0 ? true : false), 'extensions' => 'png, jpg, gif', 'maxSize' => 2048*2048, 'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif'], 'checkExtensionByMimeType' => true, 'maxFiles' => 1];
            $rules[] = [['imageFile'.$f.'lastModify'], 'string'];
        }
        return array_merge($rules, $files);
    }
    
    /**
     * GalleryAddUpload do upload files
     * save file, tumble and insert into ActiveRecord
     *
     * @return array status of uploading
     */
    public function uploadImage()
    {
        $status = array(
            'error' => false,
            'files' => array()
        );
        if ($this->validate()) { 
            for($f = 0; $f < 5; $f++) {
                $myFile = 'imageFile'.$f;
                $myDate = 'imageFile'.$f.'lastModify';
                if($file = $this->$myFile) {
                    $result = array(
                        'name' => $file->baseName.'.'.$file->extension
                    );
                    $fileName = $this->normalizationFileName($file->baseName);
                    
                    //get unique file name
                    for($attempt = 0; $attempt < 10; $attempt++) {
                        $fileNameTest = $fileName;
                        if($attempt > 0 && $attempt < 8) {
                            $fileNameTest .= '_'.($attempt+1);
                        } else if($attempt == 8) {
                            $fileNameTest .= '_'.time();
                        } else if($attempt == 9) {
                            $fileNameTest .= '_'.md5(microtime());
                        }
                        $fileNameTest .= '.'.$file->extension;
                        $fileDist = Yii::$app->params['galleryFolder'].$fileNameTest;
                        if(!file_exists($fileDist)) {
                            $fileName = $fileNameTest;
                            break;
                        }
                    }
                    /////////////////////

                    if($file->saveAs($fileDist)) {
                        $result['save'] = true;
                        
                        /////////////////////
                        $dateFile = $this->$myDate;
                        try {
                            if(empty($dateFile) || is_null($dateFile)) {
                                $exif = exif_read_data($fileDist, null, true, false);
                                if(isset($exif['EXIF'],$exif['EXIF']['DateTimeOriginal'])) {
                                    $dateFile = $exif['EXIF']['DateTimeOriginal'];
                                } else if (isset($exif['EXIF'],$exif['EXIF']['DateTimeDigitized'])) {
                                    $dateFile = $exif['EXIF']['DateTimeDigitized'];
                                } else if (isset($exif['EXIF'],$exif['IFD0']['DateTime'])) {
                                    $dateFile = $exif['IFD0']['DateTime'];
                                }
                            }
                            
                            if(!empty($dateFile) && !is_null($dateFile)) {
                                $dateFile = new \DateTime($dateFile);
                                $dateFile = $dateFile->format('Y-m-d H:i:s');
                            }
                        } catch (\Exception $e) {
                            //may problem of real create date of image
                            //skiped
                            $dateFile = null;
                        }
                        /////////////////////

                        $arg = new ArGallery();
                        $arg->image = $fileNameTest;
                        $arg->alt = $file->baseName;
                        if(!empty($dateFile) && !is_null($dateFile)) {
                            $arg->file_date = $dateFile;
                        }

                        if($arg->save()) {
                            $result['insert'] = true;
                        } else {
                            $result['insert'] = false;
                            $status['error'] = true;
                        }

                        //thumbnail//
                        Image::thumbnail(Yii::$app->params['galleryFolder'].$fileNameTest, 100, 100)
                            ->resize(new Box(100,100))
                            ->save(Yii::$app->params['galleryFolder'].Yii::$app->params['tumblFolder'].'100x100_'.$fileNameTest, ['quality' => 50]);
                        /////////////
                    } else {
                        $result['save'] = false;
                        $status['error'] = true;
                    }

                    $status['files'][] = $result;
                }
            }
        } else {
            $status['error'] = true;
        }
        return $status;
    }
    
    /**
     * normalizationFileName name of file convert into lower case, transline only and soon
     * @param  mixed $fileName
     *
     * @return string
     */
    private function normalizationFileName($fileName) {
        $fileName = $this->translite($fileName);
        $fileName = trim($fileName);
        $fileName = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $fileName);
        $fileName = str_replace(' ', '_', $fileName);
        $fileName = strtolower($fileName);
        return $fileName;
    }
    
    /**
     * translite self 
     *
     * @param  mixed $string text for transliting 
     * @param  mixed $cyrilic direct of transliting
     * @return void
     */
    private function translite($string, $cyrilic = true) {
        $cyr = [/*'Љ', 'Њ', 'Џ', 'џ', 'ш', 'ђ', 'ч', 'ћ', 'ж', 'љ', 'њ', 'Ш', 'Ђ', 'Ч', 'Ћ', 'Ж','Ц','ц',*/ 'а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п', 'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я', 'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П', 'Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'
        ];
        $lat = [/*'Lj', 'Nj', 'Dž', 'dž', 'š', 'đ', 'č', 'ć', 'ž', 'lj', 'nj', 'Š', 'Đ', 'Č', 'Ć', 'Ž','C','c',*/ 'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p', 'r','s','t','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya', 'A','B','V','G','D','E','Io','Zh','Z','I','Y','K','L','M','N','O','P', 'R','S','T','U','F','H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya'
        ];
        
        if($cyrilic) {
            $string = str_replace($cyr, $lat, $string);
        } else {
            $string = str_replace($lat, $cyr, $string);
        }
        return $string;
    }
}

?>