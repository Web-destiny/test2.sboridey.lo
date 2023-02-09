<?php


namespace common\constructor\traits;


use common\constructor\Constructor;
use yii\web\UploadedFile;

trait ConstructorData
{
    public array $simpleElements = Constructor::SIMPLE_ELEMENTS;

    public function getDetails(?array $data) : array
    {
        $keys = array_keys($data);
        $pattern = "/\bchapter\-name\-\d+/iuUs";
        $razdelsArray = preg_grep($pattern, $keys);

        $razdelsArray = $razdelsArray ?: ['chapter-name-0'];

        $elements = [];

        foreach ($razdelsArray as $razdel) {
            $numRazdel = intval(str_replace('chapter-name-', '', $razdel));

            $titleRazdel = $data['chapter-name-' . $numRazdel] ?? '';

            $elements[$numRazdel]['title'] = $titleRazdel;

            $pattern = "/\btype_{$numRazdel}(_|-)\d+/iuUs";
            $elementKeys = preg_grep($pattern, $keys);

            try {
                $this->appendElementsToGroup($elements, $data, $elementKeys, $numRazdel, '_');
            } catch (\Throwable $throwable) {
                $this->appendElementsToGroup($elements, $data, $elementKeys, $numRazdel, '-');
            }
        }

        return $elements;
    }

    public function appendElementsToGroup(&$elements, array $data, array $elementKeys, int $numRazdel, string $separator = '_')
    {
        foreach ($elementKeys as $d) {
            $num = intval(str_replace("type_{$numRazdel}{$separator}", '', $d));

            $namePrefix = $numRazdel . $separator . $num;

            $elements[$numRazdel][$num]['type'] = (string)$data["type_$namePrefix"];
            $elements[$numRazdel][$num]['hasFile'] = (bool)($data["hasFile_$namePrefix"] ?? false);
            if (!empty($data["fileObject_$namePrefix"]) && is_string($data["fileObject_$namePrefix"])) {
                $data["fileObject_$namePrefix"] = json_decode($data["fileObject_$namePrefix"], true);
                $elements[$numRazdel][$num]['fileObject'] = [
                    'file' => $data["fileObject_$namePrefix"]['file'] ?? null,
                    'fileType' => $data["fileObject_$namePrefix"]['fileType'] ?? null,
                    'fileOriginalType' => $data["fileObject_$namePrefix"]['fileOriginalType'] ?? null,
                ];
            }

            $elements[$numRazdel][$num]['element_order'] = $num;
            $elements[$numRazdel][$num]['file'] = $this->getFileInfoByNumber($namePrefix);
            $elements[$numRazdel][$num]['question'] = $data["question_$namePrefix"] ?? '';
            $elements[$numRazdel][$num]['unique_key'] = $data["id_$namePrefix"] ?? '';
            $elements[$numRazdel][$num]['elements'] = $this->getAllElements($namePrefix, $elements[$numRazdel][$num]['type'], $data);
        }
    }

    public function getAllElements(string $namePrefix, string $type, ?array $data = []) : array
    {
        $elements = [];

        switch ($type) {
            case Constructor::SINGLE:
                $elements = $this->getElementsOfSingleQuestion($namePrefix, $data);
                break;
            case Constructor::FREE_ANSWER:
                $elements = $this->getElementsOfFreeAnswerQuestion($namePrefix, $data);
                break;
            case Constructor::SCALE:
                $elements = $this->getElementsOfScale($namePrefix, $data);
                break;
            case Constructor::NPS:
                $elements = $this->getElementsOfNps($namePrefix, $data);
                break;
            case Constructor::DROPDOWN:
                $elements = $this->getElementsOfDropdown($namePrefix, $data);
                break;
            case Constructor::MATRIX:
                $elements = $this->getElementsOfMatrix($namePrefix, $data);
                break;
            case Constructor::RANGING:
                $elements = $this->getElementsOfRanging($namePrefix, $data);
                break;
            case Constructor::DATE:
                $elements = $this->getElementsOfDate($namePrefix, $data);
                break;
            default:
                if (in_array($type, $this->simpleElements)) {
                    $elements = $this->getSimpleElements($namePrefix, $data);
                }
                break;
        }

        return is_array($elements) ? $elements : [];
    }

    public function getFileInfoByNumber(string $namePrefix) : ?array
    {
        $data = null;

        if ($fileImage = UploadedFile::getInstanceByName("uploadimage_$namePrefix")) {
            $data = [$fileImage, 'image'];
        } elseif ($fileVideo = UploadedFile::getInstanceByName("uploadvideo_$namePrefix")) {
            $data = [$fileVideo, 'video'];
        } elseif ($fileAudio = UploadedFile::getInstanceByName("uploadaudio_$namePrefix")) {
            $data = [$fileAudio, 'audio'];
        }

        return $data;
    }

    public function getElementsOfSingleQuestion(string $namePrefix, array $data) : array
    {
        $arr = [];
//dd($namePrefix);
        $keys = array_keys($data);
        $pattern = "/inputpoint_$namePrefix(_|-)\d+/iuUs";
        $elements = preg_grep($pattern, $keys);
        $n = 1;

        foreach ($elements as $element) {
            $elementName = 'inputpoint_' . preg_replace("/inputpoint_(\d+)_(\d+)(_|-)(\d+)/i", '${4}', $element);
            $arr[$elementName] = $data[$element] ?? '';
            $arr["addOther"] = $data["addOther_$namePrefix"] ?? '';
            $arr["addNeither"] = $data["addNeither_$namePrefix"] ?? '';
            $arr["addComment"] = $data["addComment_$namePrefix"] ?? '';
            $arr["multiple"] = $data["multiple_$namePrefix"] ?? '';
            $arr["required"] = $data["required_$namePrefix"] ?? '';

            $n++;
        }

        $pattern = "/related_{$namePrefix}_(\d+)/iuUs";
        $elements = preg_grep($pattern, $keys);

        foreach ($elements as $key => $element) {
            $arr[$element] = $data[$element] ?? '';
        }

        $arr["isSkipAll"] = $data["isSkipAll_$namePrefix"] ?? '';
        $arr["skipItem"] = $data["skipItem_$namePrefix"] ?? '';

        return $arr;
    }

    public function getElementsOfFreeAnswerQuestion(string $namePrefix, array $data) : array
    {
        $arr = [];
        $arr["amount"] = intval($data["amount_$namePrefix"] ?? 0);
        $arr["required"] = $data["required_$namePrefix"] ?? '';

        return $arr;
    }

    public function getElementsOfScale(string $namePrefix, array $data) : array
    {
        $arr = [];
        $keys = array_keys($data);
        $pattern = "/inputpoint_$namePrefix(_|-)\d+/iuUs";
        $elements = preg_grep($pattern, $keys);

        $n = 1;
        foreach ($elements as $element) {
            $elementName = 'inputpoint_' . preg_replace("/inputpoint_(\d+)_(\d+)(_|-)(\d+)/i", '${4}', $element);
            $arr[$elementName] = $data[$element] ?? '';
            $n++;
        }

        $arr['scaleAmount'] = $data["scaleAmount_$namePrefix"] ?? '';
        $arr['rateLabels'] = $data["rateLabels_$namePrefix"] ?? '';
        $arr["required"] = $data["required_$namePrefix"] ?? '';
        $arr["scale"] = $data["scale_$namePrefix"] ?? '';
        $arr["scaleType"] = $data["scaleType_$namePrefix"] ?? '';

        return $arr;
    }

    public function getElementsOfNps(string $namePrefix, array $data) : array
    {
        $arr = [];
        $keys = array_keys($data);
        $pattern = "/inputpoint_$namePrefix(_|-)\d+/iuUs";
        $elements = preg_grep($pattern, $keys);

        $n = 1;
        foreach ($elements as $key => $element) {
            $elementName = 'inputpoint_' . preg_replace("/inputpoint_(\d+)_(\d+)(_|-)(\d+)/i", '${4}', $element);
            $arr[$elementName] = $data[$element] ?? '';
            $n++;
        }

        $pattern = "/npsAction_$namePrefix/iuUs";
        $elements = preg_grep($pattern, $keys);
        $n = 1;

        $elementName = 'npsAction_' . $namePrefix;

        foreach ($elements as $element) {
            if($data[$element]) {
                $arr[$elementName][$n]['npsTypeValue'] = $data[$element] ?? '';
                $arr[$elementName][$n]['npsDiapasoneStart'] =  $data["npsDiapasoneStart_{$namePrefix}_{$n}"] ?? '';
                $arr[$elementName][$n]['npsDiapasoneEnd'] =  $data["npsDiapasoneEnd_{$namePrefix}_{$n}"] ?? '';
            }
            $n++;
        }

        $arr['npsAmount'] = $data["npsAmount_$namePrefix"] ?? '';
        $arr['rateLabels'] = $data["rateLabels_$namePrefix"] ?? '';
        $arr["required"] = $data["required_$namePrefix"] ?? '';
        $arr["nps"] = $data["nps_$namePrefix"] ?? '';
        $arr["npsType"] = $data["npsType_$namePrefix"] ?? '';
        $arr["addNpsOption"] = $data["addNpsOption_$namePrefix"] ?? '';

        return $arr;
    }

    public function getElementsOfDropdown(string $namePrefix, array $data) : array
    {
        $arr = [];
        $keys = array_keys($data);
        $pattern = "/inputpoint_$namePrefix(_|-)\d+/iuUs";
        $elements = preg_grep($pattern, $keys);
        $n = 1;

        foreach ($elements as $element) {
            $elementName = 'inputpoint_' . preg_replace("/inputpoint_(\d+)_(\d+)(_|-)(\d+)/i", '${4}', $element);
            $arr[$elementName] = $data[$element] ?? '';            
            $n++;
        }

        $arr["addOther"] = $data["addOther_$namePrefix"] ?? '';
        $arr["addNeither"] = $data["addNeither_$namePrefix"] ?? '';
        $arr["addComment"] = $data["addComment_$namePrefix"] ?? '';
        $arr["multiple"] = $data["multiple_$namePrefix"] ?? '';
        $arr["required"] = $data["required_$namePrefix"] ?? '';

        return $arr;
    }

    public function getElementsOfMatrix(string $namePrefix, array $data) : array
    {
        $arr = [];
        $keys = array_keys($data);
        $pattern = "/inputRow_$namePrefix/iuUs";
        $elements = preg_grep($pattern, $keys);
        $n = 1;
        foreach ($elements as $element) {
            $arr[$element] = $data[$element] ?? null;
            $n++;
        }

        $pattern = "/inputCol_$namePrefix/iuUs";
        $elements = preg_grep($pattern, $keys);
        $n = 1;
        foreach ($elements as $element) {
            $arr[$element] = $data[$element] ?? null;
            $n++;
        }

        $arr["multiple"] = $data["multiple_$namePrefix"] ?? '';
        $arr["addComment"] = $data["addComment_$namePrefix"] ?? '';
        $arr["required"] = $data["required_$namePrefix"] ?? '';

        return $arr;
    }

    public function getElementsOfRanging(string $namePrefix, array $data) : array
    {
       
       +
       $arr = [];
        $keys = array_keys($data);
        $pattern = "/inputpoint_$namePrefix(_|-)\d+/iuUs";
        $elements = preg_grep($pattern, $keys);
        $n = 1;
        foreach ($elements as $element) {
            $elementName = 'inputpoint_' . preg_replace("/inputpoint_(\d+)_(\d+)(_|-)(\d+)/i", '${4}', $element);
            $arr[$elementName] = $data[$element] ?? '';
            $arr["required"] = $data["required_$namePrefix"] ?? '';
            $n++;
        }

        return $arr;
    }

    public function getElementsOfDate(string $namePrefix, array $data) : array
    {
        $arr = [];
        $arr["amount"] = intval($data["amount_$namePrefix"] ?? 0);
        $arr["required"] = $data["required_$namePrefix"] ?? '';

        return $arr;
    }

    public function getSimpleElements(string $namePrefix, array $data) : array
    {
        $arr = [];
        $arr["required"] = $data["required_$namePrefix"] ?? '';

        return $arr;
    }
}