<?php

namespace App\Models;

use CodeIgniter\Model;

class SectorModel extends Model
{
    protected $table = 'sector';
    protected $allowedFields = ['name', 'createdAt'];
    protected $validationRules = [
        'name' => 'required|max_length[255]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Ime je obavezno',
            'max_length' => 'Dužina imena ne smije biti veća od 255 karaktera',
        ],
    ];
}