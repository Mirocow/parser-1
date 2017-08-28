<?php
namespace common\models;

use yii\base\Model;
use Yii;
use yii\web\UploadedFile;

class Upload extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    public function rules()
    {
        return [
            [['file'], 'file'
//                'skipOnEmpty' => false, 'extensions' => 'csv'
            ],
        ];
    }
    public function upload()
    {
        if ($this->validate()) {
            $this->file->saveAs('uploads/' . 'price.csv');
            return true;
        } else {
            return false;
        }
    }

}