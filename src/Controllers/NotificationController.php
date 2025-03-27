<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Config\database;

class NotificationController extends Controller
{
    public function __construct(database $db)
    {
        parent::__construct($db);
    }

    public function getNotification()
    {
        $this->render("designer-notification");
    }
}
