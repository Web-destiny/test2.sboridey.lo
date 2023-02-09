<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "survey_question".
 *
 * @property int $id
 * @property int $survey_id
 * @property string $url
 * @property int $status
 *
 * @property Survey $survey
 */
class RandUrl extends \yii\db\ActiveRecord
{
    const MAX_URL_COUNT = 2000;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rand_url';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'survey_id'], 'required'],
            [['id', 'status', 'survey_id'], 'integer'],
            [['url'], 'string', 'min' => 3, 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'URL',
            'survey_id' => 'Опрос',
            'status' => 'Статус',
        ];
    }

    public function generateRandomUrl($survey_id, $count)
    {
        $urlsCount = self::find()->where(['survey_id' => $survey_id])->count();

        if (($urlsCount + $count) > self::MAX_URL_COUNT) {
            return false;
        }

        for($i = 0; $i<$count; $i++) {
            $randUrl = clone $this;
            $uniqid = $this->generateRandomString(5);
            $data = self::find()->where(['survey_id' => $survey_id, 'url' => $uniqid])->one();
            if($data) continue;

            $randUrl->survey_id = $survey_id;
            $randUrl->url = $uniqid;
            $randUrl->status = 0;
            $randUrl->save();
        }

        return true;
    }


    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function getShortLink($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($output, 1);

        $str = '';

        if(isset($result['url'])) {
            if(isset($result['url']['shortLink'])) {
                $str = $result['url']['shortLink'];
            }
        }

        return $str;
    }

    public function getSurvey()
    {
        return $this->hasOne(Survey::class, ['id' => 'survey_id']);
    }

}
