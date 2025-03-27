<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Config\database;

class PendingController extends Controller
{
    public function __construct(database $db)
    {
        parent::__construct($db);
    }

    public function getPendingPage()
    {
        $this->render("pending-request");
    }
}
