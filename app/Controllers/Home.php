<?php

namespace App\Controllers;

use App\Models\TempDocumentModel;

class Home extends BaseController
{
    public function index(): string
    {
//        $model = model('TempDocumentModel');
//
//        $data = $model->findAll();

        $data = [
            ['name' => 'Test123'],
            ['name' => 'Test456'],
        ];

        return view('home/index', [
            'documents' => $data
        ]);
    }
}
