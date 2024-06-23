<?php

namespace App\Controllers;

use App\Models\DocumentModel;
use App\Models\DocumentTypeModel;
use App\Models\SectorModel;
use App\Models\TempDocumentModel;

class TempDocument extends BaseController
{
    public function index(): string
    {
        $model = new TempDocumentModel();

        $searchTerm = $this->request->getGet('search');

        $query = $model
            ->select('tempDocument.*, documentType.name as documentTypeName')
            ->join('documentType', 'documentType.id = tempDocument.documentTypeId')
            ->orderBy("createdAt", "ASC");

        if ($searchTerm) {
            $query->like('LOWER("tempDocument"."name")', strtolower($searchTerm));
        }

        $data = $query->findAll();

        return view('temp-document/index', [
            'tempDocuments' => $data,
            'searchTerm' => $searchTerm,
        ]);
    }


    public function create()
    {
        $model = new DocumentTypeModel();
        $data = $model->findAll();

        return view('temp-document/create', [
            'documentTypes' => $data
        ]);
    }

    public function add()
    {

        $model = new TempDocumentModel();
        $sentData = $this->request->getPost();
        $file = $this->request->getFile('document');

        if (!$file->isValid()) {
            return redirect()->back()->with('errors', ['Dokument je obavezan']);
        }

        $path = $file->store('temp_documents');

        $filePath = "uploads/" . $path;

        $userId = auth()->user()->id;

        $data = [
            'name' => $sentData['name'],
            'createdAt' => date('Y-m-d H:i:s'),
            'boxNumber' => intval($sentData['boxNumber']),
            'registerNumber' => intval($sentData['registerNumber']),
            'documentTypeId' => intval($sentData['documentTypeId']),
            'documentPath' => $filePath,
            'userId' => $userId,
        ];

        if ($model->insert($data)) {
            return redirect()->to('/temp-documents')->with('success', 'Privremeni dokument uspješno dodan.');
        } else {
            return redirect()->back()->with('errors', $model->errors());
        }
    }

    public function update($id)
    {
        $model = new TempDocumentModel();
        $modelDocTypes = new DocumentTypeModel();
        $data = $model
            ->select('tempDocument.*, documentType.name as documentTypeName, user.username as username')
            ->join('documentType', 'documentType.id = tempDocument.documentTypeId')
            ->join('users as user', 'user.id = tempDocument.userId', 'left')
            ->find($id);

        $docTypes = $modelDocTypes->findAll();

        return view('temp-document/update', [
            'document' => $data,
            'documentTypes' => $docTypes,
        ]);
    }

    public function updateReq($id)
    {
        $file = $this->request->getFile('document');

        $model = new TempDocumentModel();
        $data = $this->request->getPost();

        if ($file->isValid()) {
            $path = $file->store('temp_documents');
            $filePath = "uploads/" . $path;
            $data['documentPath'] = $filePath;

            $oldDocument = $model->find($id);
            unlink(WRITEPATH . $oldDocument['documentPath']);

        }

        if ($model->update($id, $data)) {
            return redirect()->to('/temp-documents')->with('success', 'Privremeni dokument uspješno ažuriran.');
        } else {
            return redirect()->back()->with('errors', $model->errors());
        }
    }

    public function createDocument($id)
    {
        $model = new DocumentModel();

        $tempModel = new TempDocumentModel();

        $tempDocument = $tempModel->find($id);
        $userId = auth()->user()->id;

        $data = [
            'name' => $tempDocument['name'],
            'createdAt' => date('Y-m-d H:i:s'),
            'boxNumber' => $tempDocument['boxNumber'],
            'registerNumber' => $tempDocument['registerNumber'],
            'documentTypeId' => $tempDocument['documentTypeId'],
            'documentPath' => $tempDocument['documentPath'],
            'userId' => $userId,
        ];

        if ($model->insert($data)) {
            $tempModel->delete($id);

            return $this->response->setStatusCode(201);
        } else {
            return $this->response->setStatusCode(500);
        }
    }

    public function delete($id)
    {
        $model = new TempDocumentModel();
        try {
            $oldDocument = $model->find($id);
            unlink(WRITEPATH . $oldDocument['documentPath']);

            $model->delete($id);


        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->setStatusCode(500)->setJSON(['error' => 'Greška prilikom brisanja dokumenta,']);
        }

        return response()->setStatusCode(200)->setJSON(['success' => 'Uspešno obrisan dokument']);
    }
}

