<?php

namespace common\models;

use common\models\forms\SurveyForm;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "survey".
 *
 * @property int $id
 * @property int|null $type
 * @property string| $rand_string
 * @property string|null $admin_id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $banner
 * @property string|null $background
 * @property int|null $is_survey_file
 * @property int|null $is_contact_form
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $published
 * @property int $count_started
 * @property int $count_finished
 * @property int $has_numbering
 * @property string $extra
 * @property string $extra1
 * @property yii\web\UploadedFile $imageFile
 */
class Survey extends \yii\db\ActiveRecord
{
    public const MAX_PARTICIPANT_COUNT = 1000000;

    public const ALIAS_EXTRA = 'cement';

    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'survey';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'admin_id'], 'required'],
            [['type', 'is_survey_file', 'is_contact_form', 'status', 'admin_id', 'published', 'created_at', 'updated_at', 'count_started', 'count_finished', 'has_numbering'], 'integer'],
            [['description', 'extra', 'extra1'], 'string'],
            [['name', 'banner', 'background', 'rand_string'], 'string', 'max' => 500],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
            ['rand_string', 'unique'],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'name' => 'Name',
            'description' => 'Description',
            'banner' => 'Banner',
            'background' => 'Background',
            'is_survey_file' => 'Is Survey File',
            'is_contact_form' => 'Is Contact Form',
            'status' => 'Статус',
            'admin_id' => 'Админ ID',
            'published' => 'Опубликовано',
            'count_started' => 'Перешли по ссылке',
            'count_finished' => 'Прошли опрос',
            'has_numbering' => 'Включить нумерацию вопросов',
            'extra' => 'Дополнтельный критерий',
            'extra1' => 'Дополнтельный критерий 1',
        ];
    }

    public function beforeSave($insert)
    {
        $result = parent::beforeSave($insert);

        $this->uploadBanner();

        return $result;
    }

    public function isCementExtra() : bool
    {
        return !empty($this->extra) && $this->extra === self::ALIAS_EXTRA;
    }

    public function uploadBanner(): self
    {
        if ($this->imageFile = UploadedFile::getInstance($this, 'imageFile')) {
            $extensionFile = $this->imageFile->extension;
            $fileName = Yii::$app->security->generateRandomString(11);
            $this->banner = "{$fileName}.{$extensionFile}";
            $this->imageFile->saveAs(Yii::getAlias('@frontend/web') . "/img/survey/{$this->banner}");
        }

        return $this;
    }


    public function archiveSurvey($id, $published_status)
    {
        $survey = self::find()->where(['id' => $id])->one();
        $survey->published = $published_status;
        if($survey->validate()) {
            $survey->save();
        }
    }

    public function saveAnswers($post, $unique)
    {
        $types = ArrayHelper::toArray(ArrayHelper::getValue($post, 'types'));

        $form = new SurveyForm();

        return $form->saveSurvey($unique, $post, $types);
    }

    public function getRandUrl()
    {
        return $this->hasMany(RandUrl::className(), ['survey_id' => 'id']);
    }

}
