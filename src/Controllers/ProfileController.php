<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Config\database;
use App\Config\JwtConfig;
use App\Models\UserService;
use App\Validations\FormValidator;
use App\Validations\InputSanitizer;

class ProfileController extends Controller
{
    private $user_service;

    public function __construct(database $db)
    {
        parent::__construct($db);
        $this->initializeUserService();
    }

    public function initializeUserService()
    {
        $this->user_service = new UserService($this->db->getConnection());
    }

    public function getUserDetails()
    {
        header("Content-Type: application/json");
        $user_id = JwtConfig::getInstance()->getUserId();
        $user_details = $this->user_service->getUserDetails($user_id);
        echo json_encode($user_details);
    }

    public function editProfile()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $user_details = json_decode($json, true);
        $input = new InputSanitizer($user_details);
        $clean_form = $input->sanitize();
        $validated_fields = new FormValidator($user_details);
        if (!$validated_fields->validateUserProfile()) {
            echo json_encode(["success" => false, "message" => $validated_fields->getErrors()]);
        } else {
            $user_id = JwtConfig::getInstance()->getUserId();
            $this->user_service->editProfile($clean_form, $user_id);
            echo json_encode(["success" => true, "message" => "Updated Successfully!"]);
        }
    }

    public function isUserDetailsUpdated()
    {
        header("Content-Type: application/json");
        $user_id = JwtConfig::getInstance()->getUserId();
        if (!$this->user_service->isUserDetailsUpdated($user_id)) {
            echo json_encode(["success" => false, "message" => "Please update your details first before proceeding."]);
        } else {
            echo json_encode(["success" => true]);
        }
    }
}
