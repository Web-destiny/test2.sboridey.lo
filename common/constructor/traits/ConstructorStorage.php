<?php


namespace common\constructor\traits;

use common\constructor\BaseElement;
use common\models\SurveyElement;
use common\models\SurveyRazdel;
use Yii;
use yii\db\Query;

trait ConstructorStorage
{
    protected static bool $sessionStorageMode = false;

    protected static int $id;
    public static $surveyId;

    public static function setSurveyId($id)
    {
        self::$id = $id;
    }

    public static function getElementsData(bool $grouped = false) : array
    {
        if (self::$sessionStorageMode) {
            return Yii::$app->session->get('constructorElements' . self::$id, []);
        }

        $elements = SurveyElement::find()->alias('s')->innerJoinWith(['surveyRazdel'])->where(['s.survey_id' => self::$id])->asArray()->all();

        $groupedElements = [];

        foreach ($elements as &$e) {
            $e['elements'] = json_decode($e['json_data'], true);
            $e['fileObject'] = json_decode($e['file'], true);
            unset($e['json_data']);

            if ($grouped) {
                $groupedElements[$e['surveyRazdel']['razdel_id']]['id'] = $e['surveyRazdel']['razdel']['id'];
                $groupedElements[$e['surveyRazdel']['razdel_id']]['number'] = $e['surveyRazdel']['razdel']['number'];
                $groupedElements[$e['surveyRazdel']['razdel_id']]['title'] = $e['surveyRazdel']['razdel']['title'];
                $groupedElements[$e['surveyRazdel']['razdel_id']]['elements'][] = $e;
            }
        }

//        echo '<pre>';
//        print_r($groupedElements);
//        die;
        
        return $grouped ? $groupedElements : $elements;
    }

    public static function setElementsData(array $data) : void
    {
        if (self::$sessionStorageMode) {
            Yii::$app->session->set('constructorElements' . self::$id, $data);
            return;
        }

        $savedElements = [];

        foreach ($data as $d) {
            $model = SurveyElement::find()
                ->alias('el')
                ->select('el.*')
                ->innerJoinWith(['surveyRazdel.razdel' => function (Query $query) use ($d) {
                    $query->where(['number' => $d['surveyRazdelData']['number']]);
                }])
                ->where([
                    'el.survey_id' => self::$id,
                    'el.element_order' => $d['element_order']
                ])
                ->one() ?: new SurveyElement();

            $model->survey_id = self::$id;
            $model->type = $d['type'];
            $model->element_order = $d['element_order'];
            $model->question = $d['question'];
            $model->unique_key = $d['unique_key'];
            $model->json_data = json_encode($d['elements']);

            if ($model->id) {
                if (!empty($d['fileObject'])) {
                    $model->file = json_encode($d['fileObject']);
                } else {
                    $model->file = null;
                }
            } elseif (!empty($d['fileObject'])) {
                $model->file = json_encode($d['fileObject']);
            }

            if ($model->validate() && $model->save()) {
                if (!empty($d['surveyRazdelData']['razdel_id'])) {
                    $d['surveyRazdelData']['survey_element_id'] = $model->id;

                    $surveyRazdel = SurveyRazdel::findOne([
                        'razdel_id' => $d['surveyRazdelData']['razdel_id'],
                        'survey_element_id' => $model->id
                    ]) ?: new SurveyRazdel();

                    $surveyRazdel->setAttributes($d['surveyRazdelData']);

                    $surveyRazdel->save();
                }

                $savedElements[] = $model->id;
            }
        }

        $deletables = SurveyElement::find()
            ->where(['survey_id' => self::$id])
            ->andWhere(['NOT IN', 'id', $savedElements])
            ->all();

        foreach ($deletables as $deletable) {
            self::deleteElementImage($deletable);

            $deletable->delete();
        }
    }

    public static function deleteElementsData() : void
    {
        if (self::$sessionStorageMode) {
            self::setElementsData([]);
            return;
        }

        $deletables = SurveyElement::findAll(['survey_id' => self::$id]);

        foreach ($deletables as $deletable) {
            self::deleteElementImage($deletable);
            $deletable->delete();
        }
    }

    // TODO call this function at the constructor delete time.
    public static function deleteElementImage(SurveyElement $element)
    {
        if (!empty($element->file) && is_string($element->file)) {
            $file = json_decode($element->file, true)['file'] ?? null;
        }

        if (empty($file)) {
            return; // do nothing
        }

        $file = Yii::getAlias(BaseElement::PUBLIC_STORAGE) . '/' . $file;

        if (is_file($file)) {
            unlink($file);
        }

        $element->file = null;
    }

}