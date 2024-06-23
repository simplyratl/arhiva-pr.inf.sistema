<?php

namespace App\Controllers;

use App\Models\DocumentTypeModel;

class DocumentType extends BaseController
{
    public function index(): string
    {
        $model = new DocumentTypeModel();
        $searchTerm = $this->request->getGet('search');

        if ($searchTerm) {
            $data = $model->like('LOWER(name)', strtolower($searchTerm))->findAll();
        } else {
            $data = $model->orderBy('createdAt', 'desc')->findAll();
        }

        return view('document-type/index', [
            'documentTypes' => $data,
            'searchTerm' => $searchTerm
        ]);
    }

    public function create()
    {
        return view('document-type/create');
    }

    public function add()
    {

        $name = $this->request->getPost('name');
        $model = new DocumentTypeModel();

        $data = [
            'name' => $name,
            'createdAt' => date('Y-m-d H:i:s')
        ];

        $res = $model->insert($data);

        if ($res !== false) {
            return redirect()->to('/document-types')->with('success', 'Document type added successfully.');
        } else {
            return redirect()->back()->with('errors', $model->errors());
        }
    }

    public function update($id)
    {
        $model = new DocumentTypeModel();
        $data = $model->find($id);

        return view('document-type/update', ['document' => $data]);
    }

    public function updateReq($id)
    {
        $name = $this->request->getPost('name');

        $model = new DocumentTypeModel();
        $data = [
            'name' => $name,
        ];

        if ($model->update($id, $data)) {
            return redirect()->to('/document-types')->with('success', 'Dokument uspješno ažuriran.');
        } else {
            return redirect()->back()->with('errors', $model->errors());
        }
    }

    public function delete($id)
    {
        $model = new DocumentTypeModel();
        try {
            $model->delete($id);
        } catch (\Exception $e) {
            return response()->setStatusCode(500)->setJSON(['error' => 'Greška prilikom brisanja dokumenta']);
        }

        return response()->setStatusCode(200)->setJSON(['success' => 'Uspešno obrisan dokument']);
    }
}

