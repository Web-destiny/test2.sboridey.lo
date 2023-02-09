<?php

namespace common\services\exporter;

use common\services\exporter\excel\XLSXWriter;

/**
 * @package common\services\exporter
 *
 * Example Usage
 *
 * $obj
 * ->setOptions(['sheet1_headerStyle' => ..., 'sheet1_rowStyle' => ...])
 * ->setFilename('test')
 * ->setHeader(['sheet1' => ['col1' => 'string', ...]])
 * ->setExportData(['sheet1' => ['col1' => 'value', ...]])
 * ->export()
 */
class FileExportExcel extends FileExportAdapter
{
    protected XLSXWriter $XLSXWriter;

    public function __construct($config = [])
    {
        $this->XLSXWriter = new XLSXWriter();

        parent::__construct($config);
    }

    /**
     * @param bool $exportEmptyOnError
     * @return void
     */
    public function export(bool $exportEmptyOnError = true)
    {
        if (count($this->header) != count($this->exportData) || empty($this->header) || empty($this->exportData)) {
            if ($exportEmptyOnError) {
                $this->addResponseHeader();

                \Yii::$app->session->setFlash('export-excel-error', 'Logic Exception : Wrong data was passed!');

                $this->XLSXWriter->writeSheetHeader('Sheet_1', [], $this->getOption('Sheet_1_headerStyle', [
                    // ...
                ]));

                $this->XLSXWriter->writeToStdOut();

                die(0);
            } else {
                throw new \LogicException('Logic Exception : Wrong data was passed!');
            }
        } else {
            $this->addResponseHeader();
        }

        foreach ($this->header as $sheet => $header) {
            $this->XLSXWriter->writeSheetHeader($sheet, $header, $this->getOption($sheet . '_headerStyle', [
                // ...
            ]));

            if (empty($this->exportData[$sheet])) continue;

            foreach ($this->exportData[$sheet] as $row) {
                $this->XLSXWriter->writeSheetRow($sheet, $row, $this->getOption($sheet . '_rowStyle', [
                    'halign' => 'center',
                    'valign' => 'center'
                ]));
            }
        }

        if (!$this->header['Sheet_1']) {

            $headers = array('name' => 'string');
            $sheet_names = ['Тест'];
            $writer = $this->XLSXWriter;
            foreach ($sheet_names as $sheet_name) {
                $writer->writeSheetHeader($sheet_name, $headers);
                for ($i = 0; $i < 1; $i++) {
                    $writer->writeSheetRow($sheet_name, ['Пройденное количество опросов - 0']);
                }
            }
            $writer->writeToStdOut();
            die();
        }

        try {
            $this->XLSXWriter->writeToStdOut();
        } catch (\Exception $e) {

        }
        die(0);
    }

    private function addResponseHeader()
    {
        header('Content-disposition: attachment; filename="' . $this->XLSXWriter->sanitize_filename($this->filename) . '"');
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
    }
}