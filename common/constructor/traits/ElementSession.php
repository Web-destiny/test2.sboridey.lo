<?php

namespace common\constructor\traits;

use yii\web\UploadedFile;

trait ElementSession
{
    protected ?string $type = null;

    protected ?bool $hasFile = null;

    /**
     * @var null|string|UploadedFile
     */
    protected $file = null;

    protected ?string $fileType = null;

    protected int $elementOrder = 0;

    protected ?string $fileOriginalType = null;

    protected ?string $fileBase64 = null;

    protected function getFileKey() : string
    {
        return 'constructor_file_' . $this->type . $this->elementOrder;
    }

    protected function getFileFromSession(array $default = [])
    {
        return \Yii::$app->session->get($this->getFileKey(), $default);
    }

    protected function updateFileInfoFromSession() : void
    {
        $sessionFile = $this->getFileFromSession();

        $this->hasFile = !empty($sessionFile['file']);
        $this->file = $sessionFile['file'] ?? null;
        $this->fileType = $sessionFile['fileType'] ?? null;
        $this->fileOriginalType = $sessionFile['fileOriginalType'] ?? null;
        $this->fileBase64 = $sessionFile['fileBase64'] ?? null;
    }

    protected function savePostFile(): void
    {
        if (empty($this->hasFile)) {
            $this->deleteFileFromSession(); // for any cases
        }

        $this->file = !empty($this->data['file'][0]) && $this->data['file'][0] instanceof UploadedFile ? $this->data['file'][0] : null;

        if ($this->file) {
            $this->fileType = $this->data['file'][1] ?? null;
            $this->fileOriginalType = $this->file->type;
        }

        try {
            $this->hasFile = true;
            $data = file_get_contents($this->file->tempName);
            $this->fileBase64 = 'data:' . $this->fileOriginalType . ';base64,' . base64_encode($data);

            $this->putFileToSession();
        } catch (\Throwable $throwable) {
            // dd($throwable);
            // can't get image
        }
    }

    protected function deleteFileFromSession()
    {
        \Yii::$app->session->set($this->getFileKey(), []);
    }

    protected function putFileToSession()
    {
        \Yii::$app->session->set($this->getFileKey(), [
            'file' => $this->file,
            'fileType' => $this->fileType,
            'fileOriginalType' => $this->fileOriginalType,
            'fileBase64' => $this->fileBase64,
        ]);
    }

    protected function isElementGeneratedFromSession() : bool
    {
        return !$this->isElementGeneratedFromPost() && !empty($this->getFileFromSession());
    }

    protected function isElementGeneratedFromPost() : bool
    {
        return !empty(\Yii::$app->request->post('type_' . $this->elementOrder));
    }
}