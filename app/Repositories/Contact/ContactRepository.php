<?php

namespace App\Repositories\Contact;

use App\Repositories\BaseRepository;
use App\Repositories\Contact\ContactRepositoryInterface;
use App\Models\Contact;

class ContactRepository extends BaseRepository implements ContactRepositoryInterface
{
    protected $model;
    public function getModel()
    {
        return Contact::class;
    }

    public function all()
    {
        return Contact::all();
    }
}
