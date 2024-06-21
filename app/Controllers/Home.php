<?php

namespace App\Controllers;

use App\Models\TempDocumentModel;

class Home extends BaseController
{
    public function index(): string
    {
        $model = model('TempDocumentModel');

        $data = $model->findAll();

        return view('home/index', [
            'documents' => $data
        ]);
    }

    public function update($id) {
        $model = model('TempDocumentModel');

        $tempDocument = $model->find($id);

        return view('home/update', [
            'document' => $tempDocument
        ]);
    }

    public function updateReq($id) {
        dd($this->request->getPost());
    }
}
