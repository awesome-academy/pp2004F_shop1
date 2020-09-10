<?php

namespace App\Repositories\Contact;

use App\Repositories\RepositoryInterface;

interface ContactRepositoryInterface extends RepositoryInterface {
    public function all();
}
