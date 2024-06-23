<?php

namespace App\Controllers;

use App\Models\SectorModel;

class Sector extends BaseController
{
    public function index(): string
    {
        $model = new SectorModel();
        $searchTerm = $this->request->getGet('search');

        if ($searchTerm) {
            $data = $model->like('LOWER(name)', strtolower($searchTerm))->findAll();
        } else {
            $data = $model->findAll();
        }

        return view('sector/index', [
            'sectors' => $data,
            'searchTerm' => $searchTerm
        ]);
    }

    public function create()
    {
        return view('sector/create');
    }

    public function add()
    {

        $name = $this->request->getPost('name');

        $model = new SectorModel();
        $data = [
            'name' => $name,
            'createdAt' => date('Y-m-d H:i:s')
        ];

        if ($model->insert($data)) {
            return redirect()->to('/sectors')->with('success', 'Sektor uspješno dodan');
        } else {
            return redirect()->back()->with('errors', $model->errors());
        }
    }

    public function update($id)
    {
        $model = new SectorModel();
        $data = $model->find($id);

        return view('sector/update', ['document' => $data]);
    }

    public function updateReq($id)
    {
        $name = $this->request->getPost('name');


        $model = new SectorModel();
        $data = [
            'name' => $name,
        ];

        if ($model->update($id, $data)) {
            return redirect()->to('/sectors')->with('success', 'Sektor uspješno ažuriran.');
        } else {
            return redirect()->back()->with('errors', $model->errors());
        }
    }

    public function delete($id)
    {
        $model = new SectorModel();
        try {
            $model->delete($id);
        } catch (\Exception $e) {
            return response()->setStatusCode(500)->setJSON(['error' => 'Greška prilikom brisanja dokumenta']);
        }

        return response()->setStatusCode(200)->setJSON(['success' => 'Uspešno obrisan dokument']);
    }
}

