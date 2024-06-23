<?php

namespace App\Controllers;

use App\Models\DocumentModel;
use App\Models\DocumentTypeModel;
use App\Models\SectorModel;
use App\Models\TempDocumentModel;
use App\Models\UserModel;

class Document extends BaseController
{
    public function index(): string
    {
        $model = new DocumentModel();
        $modelSector = new SectorModel();
        $modelDocTypes = new DocumentTypeModel();
        $modelUser = new UserModel();

        $searchTerm = $this->request->getGet('search');
        $searchSector = $this->request->getGet('sectorId');
        $searchDocType = $this->request->getGet('documentTypeId');
        $searchShelf = $this->request->getGet('shelf');
        $searchShelfRow = $this->request->getGet('shelfRow');
        $searchShelfColumn = $this->request->getGet('shelfColumn');
        $searchCreatedAt = $this->request->getGet('createdAt');
        $searchUser = $this->request->getGet('userId');

        $query = $model
            ->select('document.*, documentType.name as documentTypeName, sector.name as sectorName, user.username as username')
            ->join('documentType', 'documentType.id = document.documentTypeId')
            ->join('sector', 'sector.id = document.sectorId', 'left')
            ->join('users as user', 'user.id = document.userId', 'left')
            ->orderBy("createdAt", "ASC");

        if ($searchSector != 0 && $searchSector) {
            $query->where('sectorId', $searchSector);
        }

        if ($searchDocType != 0 && $searchDocType) {
            $query->where('documentTypeId', $searchDocType);
        }

        if ($searchTerm) {
            $query->like('LOWER("document"."name")', strtolower($searchTerm));
        }

        if ($searchShelf) {
            $query->where('shelf', $searchShelf);
        }

        if ($searchShelfRow) {
            $query->where('shelfRow', $searchShelfRow);
        }

        if ($searchShelfColumn) {
            $query->where('shelfColumn', $searchShelfColumn);
        }

        if ($searchCreatedAt) {
            $startDate = $searchCreatedAt . ' 00:00:00';
            $endDate = $searchCreatedAt . ' 23:59:59';
            $query->where('"document"."createdAt" >=', $startDate);
            $query->where('"document"."createdAt" <=', $endDate);
        }

        if ($searchUser) {
            // find all users where they have same userId
            // and when the user only has user role in table auth_groups_users

            $query->where('userId', $searchUser);
        }

        $data = $query->findAll();
        $sectors = $modelSector->findAll();
        $documentTypes = $modelDocTypes->findAll();
        $users = $modelUser->findAll();

        return view('documents/index', [
            'documents' => $data,
            'searchTerm' => $searchTerm,
            'sectors' => $sectors,
            'documentTypes' => $documentTypes,
            'searchSector' => $searchSector,
            'searchDocType' => $searchDocType,
            'searchShelf' => $searchShelf,
            'searchShelfRow' => $searchShelfRow,
            'searchShelfColumn' => $searchShelfColumn,
            'searchCreatedAt' => $searchCreatedAt,
            'searchUser' => $searchUser,
            'users' => $users
        ]);
    }

    public function update($id)
    {
        $model = new DocumentModel();
        $modelDocTypes = new DocumentTypeModel();
        $modelSector = new SectorModel();
        $data = $model
            ->select('document.*, documentType.name as documentTypeName, sector.name as sectorName, user.username as username')
            ->join('documentType', 'documentType.id = document.documentTypeId')
            ->join('sector', 'sector.id = document.sectorId', 'left')
            ->join('users as user', 'user.id = document.userId', 'left')
            ->find($id);

        $docTypes = $modelDocTypes->findAll();
        $sectors = $modelSector->findAll();
        $privacy = [
            ['name' => 'Javno', 'value' => 'PUBLIC'],
            ['name' => 'Privatno', 'value' => 'PRIVATE'],
            ['name' => 'Interno', 'value' => 'INTERNAL'],
            ['name' => 'Povjerljivo', 'value' => 'CONFIDENTIAL'],
        ];

        // $hasPermission = $data['privacy'] === 'CONFIDENTIAL' && (in_array('director', auth()->user()->getGroups(), true) || in_array('admin', auth()->user()->getGroups(), true));
        $hasPermissionToView = false;
        $hasPermissionToEdit = false;
        $userGroups = auth()->user()->getGroups();

        if ($data['privacy'] === 'CONFIDENTIAL') {
            if (in_array('director', $userGroups, true) || in_array('admin', $userGroups, true)) {
                $hasPermissionToView = true;
            }
        } else {
            $hasPermissionToView = true;
        }

        // Check da li je arhivar ulogovan ili admin. Niko drugi nema pristup mijenjanja metadata dokumenta
        if ((in_array('user', $userGroups, true) && count($userGroups) === 1) || in_array('admin', $userGroups, true)) {
            $hasPermissionToEdit = true;
        }


        return view('documents/update', [
            'document' => $data,
            'documentTypes' => $docTypes,
            'sectors' => $sectors,
            'privacy' => $privacy,
            'hasPermissionToEdit' => $hasPermissionToEdit,
            'hasPermissionToView' => $hasPermissionToView
        ]);
    }

    public function updateReq($id)
    {

        $model = new DocumentModel();
        $data = $this->request->getPost();

        $dataToSend = [
            'name' => $data['name'],
            'documentTypeId' => intval($data['documentTypeId']),
            'boxNumber' => intval($data['boxNumber']),
            'registerNumber' => intval($data['registerNumber']),
        ];

        if (isset($data['shelfRow'])) {
            $dataToSend['shelfRow'] = intval($data['shelfRow']);
        }

        if (isset($data['shelfColumn'])) {
            $dataToSend['shelfColumn'] = intval($data['shelfColumn']);
        }

        if (isset($data['shelf'])) {
            $dataToSend['shelf'] = $data['shelf'];
        }

        if (isset($data['sectorId'])) {
            $dataToSend['sectorId'] = intval($data['sectorId']);
        }

        if (isset($data['privacy'])) {
            $dataToSend['privacy'] = $data['privacy'];
        }

        if ($model->update($id, $data)) {
            return redirect()->to('/')->with('success', 'Privremeni dokument uspješno ažuriran.');
        } else {
            return redirect()->back()->with('errors', $model->errors());
        }
    }

    public function delete($id)
    {
        $model = new DocumentModel();
        try {
            $oldDocument = $model->find($id);
            $filePath = WRITEPATH . $oldDocument['documentPath'];
            if (is_writable($filePath)) {
                unlink($filePath);
            }

            $model->delete($id);

        } catch (\Exception $e) {
            return response()->setStatusCode(500)->setJSON(['error' => 'Greška prilikom brisanja dokumenta', 'trace' => $e->getMessage()]);
        }

        return response()->setStatusCode(200)->setJSON(['success' => 'Uspešno obrisan dokument']);
    }
}

