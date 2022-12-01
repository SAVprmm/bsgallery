<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "bs_gallery".
 *
 * @property int $id
 * @property string $image
 * @property string|null $alt
 * @property string $file_date
 * @property string $create_at
 */
class ArGallery extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bs_gallery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image'], 'required'],
            [['id'], 'integer'],
            [['file_date', 'create_at'], 'safe'],
            [['image', 'alt'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
            'alt' => 'Alt',
            'file_date' => 'File Date',
            'create_at' => 'Create At',
        ];
    }
    
    /**
     * getId
     *
     * @return void
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * getImage
     *
     * @return void
     */
    public function getImage() {
        return $this->image;
    }
    
    /**
     * getAlt
     *
     * @return void
     */
    public function getAlt() {
        return $this->alt;
    }
    
    /**
     * getFileDate
     *
     * @return void
     */
    public function getFileDate() {
        return $this->file_date;
    }

    /**
     * getCreateAt
     *
     * @return void
     */
    public function getCreateAt() {
        return $this->create_at;
    }
}
