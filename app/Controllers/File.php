<?php

namespace App\Controllers;

use App\Models\DocumentModel;
use App\Models\TempDocumentModel;

class File extends BaseController
{
    public function getTempDocumentImage($id)
    {
        $model = new TempDocumentModel();
        $document = $model->find($id);

        if (!$document) {
            return redirect()->back()->with('errors', ['Dokument nije pronađen']);
        }

        $docPath = $document['documentPath'];
        $path = WRITEPATH . $docPath;

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $type = $finfo->file($path);

        header('Content-Type: ' . $type);
        header('Content-Length: ' . filesize($path));

        readfile($path);
        exit;
    }

    public function getDocumentImage($id)
    {
        $model = new DocumentModel();
        $document = $model->find($id);

        if (!$document) {
            return redirect()->back()->with('errors', ['Dokument nije pronađen']);
        }

        $docPath = $document['documentPath'];
        $path = WRITEPATH . $docPath;

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $type = $finfo->file($path);

        header('Content-Type: ' . $type);
        header('Content-Length: ' . filesize($path));

        readfile($path);
        exit;
    }

}
