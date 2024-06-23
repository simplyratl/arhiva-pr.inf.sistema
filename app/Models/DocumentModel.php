<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentModel extends Model
{
    protected $table = 'document';
    protected $allowedFields = ['name', 'createdAt', 'updatedAt', 'boxNumber', 'registerNumber', 'documentTypeId', 'documentPath', 'sectorId', 'shelf', 'shelfRow', 'shelfColumn', 'privacy', 'userId'];
    protected $validationRules = [
        'name' => 'required|max_length[255]',
        'boxNumber' => 'required|integer',
        'registerNumber' => 'required|integer',
        'documentTypeId' => 'required|integer',
        'documentPath' => 'required',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Ime je obavezno',
            'max_length' => 'Dužina imena ne smije biti veća od 255 karaktera',
        ],
        'boxNumber' => [
            'required' => 'Broj kutije je obavezan',
            'integer' => 'Broj kutije mora biti cijeli broj',
        ],
        'registerNumber' => [
            'required' => 'Registarski broj je obavezan',
            'integer' => 'Registarski broj mora biti cijeli broj',
        ],
        'documentTypeId' => [
            'required' => 'Tip dokumenta je obavezan',
            'integer' => 'Tip dokumenta mora biti cijeli broj',
        ],
        'documentPath' => [
            'required' => 'Dokument je obavezan'
        ]
    ];

}