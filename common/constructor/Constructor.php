<?php

namespace common\constructor;


use common\constructor\traits\ConstructorData;
use common\constructor\traits\ConstructorStorage;
use common\models\Razdel;
use Yii;
use yii\base\BaseObject;

class Constructor extends BaseObject
{
    use ConstructorData, ConstructorStorage;

    const SINGLE = 'single';
    const FREE_ANSWER = 'free-answer';
    const SCALE = 'scale';
    const DROPDOWN = 'dropdown';
    const MATRIX = 'matrix';
    const RANGING = 'ranging';
    const NAME = 'name';
    const DATE = 'date';
    const EMAIL = 'email';
    const PHONE = 'phone';
    const FILE = 'file';
    const NPS = 'nps';

    const SIMPLE_ELEMENTS = [self::NAME, self::EMAIL, self::PHONE, self::FILE];

    protected static int $id;

    /**
     * @return int
     */
    public static function getId(): int
    {
        return self::$id;
    }

    public static function initialize(int $id) : self
    {
        self::$id = $id;

        $constructor = new static;

        if (empty(Yii::$app->request->post())) {
            return $constructor;
        }

        $elementsGroup = $constructor->getDetails(Yii::$app->request->post());

        $savedRazdels = $elementsToBeProcessed = [];

        foreach ($elementsGroup as $razdelNumber => $elements) {
            $surveyRazdelData = [];

            $razdel = Razdel::findOne([
                'survey_id' => self::$id,
                'number' => $razdelNumber,
            ]) ?: new Razdel();

            if (isset($elements['title'])) {
                $surveyRazdelData = [
                    'survey_id' => self::$id,
                    'number' => $razdelNumber,
                    'title' => $elements['title'],
                ];

                $razdel->setAttributes($surveyRazdelData);

                if ($razdel->save()) {
                    $surveyRazdelData['razdel_id'] = $razdel->id;
                    $savedRazdels[] = $razdel->id;
                }

                unset($elements['title']);
            }

            foreach ($elements as $element) {
                $groupData = $surveyRazdelData ? [
                    'id' => $surveyRazdelData['razdel_id'],
                    'number' => $razdelNumber,
                    'title' => $surveyRazdelData['title'],
                ] : [];

                $object = self::makeElement($element, $groupData);

                $data = $object->getOptions();

                $element['surveyRazdelData'] = $surveyRazdelData;

                if (!empty($data['file'])) {
                    $element['fileObject'] = [
                        'file' => $data['file'],
                        'fileType' => $data['fileType'],
                        'fileOriginalType' => $data['fileOriginalType'],
                    ];
                }

                $elementsToBeProcessed[] = $element;
            }
        }

        if (!empty($savedRazdels)) {
            Razdel::deleteAll([
                'AND',
                ['survey_id' => self::$id],
                ['NOT IN', 'id', $savedRazdels]
            ]);
        }

        if (!empty($elementsToBeProcessed)) {
            self::setElementsData($elementsToBeProcessed);
        }

        return $constructor;
    }

    public static function makeElement(array $data = [], array $groupData = []) : BaseElement
    {
        switch ($type = $data['type'] ?? self::SINGLE) {
            case self::SINGLE:
                return new SingleElement($data, $groupData);
            case self::FREE_ANSWER:
                return new FreeAnswerElement($data, $groupData);
            case self::SCALE:
                return new ScaleElement($data, $groupData);
            case self::NPS:
                return new NpsElement($data, $groupData);
            case self::DROPDOWN:
                return new DropdownElement($data, $groupData);
            case self::MATRIX:
                return new MatrixElement($data, $groupData);
            case self::RANGING:
                return new RangingElement($data, $groupData);
            case self::NAME:
                return new NameElement($data, $groupData);
            case self::DATE:
                return new DateElement($data, $groupData);
            case self::EMAIL:
                return new EmailElement($data, $groupData);
            case self::PHONE:
                return new PhoneElement($data, $groupData);
            case self::FILE:
                return new FileElement($data, $groupData);
            default:
                throw new \LogicException("The element: `{$type}` isn't implemented!");
        }
    }

    public static function generateConstructor() : string
    {
        $groups = self::getElementsData(true);

        $constructor = '';

        $numberOfGroup = 0;
        foreach ($groups as $group) {
            $groupData = [
                'id' => $group['id'],
                'number' => $group['number'],
                'title' => $group['title'],
            ];

            $groupHtml = '';

            foreach ($group['elements'] as $element) {
                $groupHtml .= self::makeElement($element, $groupData)->getElementHTML();
            }

            $groupHtml = Yii::$app->view->render('@common/constructor/view/__group_section', [
                'html' => $groupHtml,
                'data' => $groupData,
                'numberOfGroup' => $numberOfGroup,
            ]);

            $constructor .= $groupHtml;
            $numberOfGroup++;
        }

        return $constructor;
    }

    public static function generateQuestionnaire() : string
    {
        $groups = self::getElementsData(true);

        $constructor = '';

        foreach ($groups as $group) {
            $groupData = [
                'id' => $group['id'],
                'number' => $group['number'],
                'title' => $group['title'],
            ];

            $groupHtml = '';

            foreach ($group['elements'] as $element) {
                if (!isset($element['type'])) continue;
                $groupHtml .= Yii::$app->view->render('/site/partials/' . $element['type'], [
                    'element' => $element,
                ]);
            }

            $groupHtml = Yii::$app->view->render('@common/constructor/view/__group_section_questionnaire', [
                'html' => $groupHtml,
                'data' => $groupData,
            ]);

            $constructor .= $groupHtml;
        }

        return $constructor;
    }

}