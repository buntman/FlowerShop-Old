<?php

namespace App\Validations;

class InputSanitizer
{
    private $data;

    public function __construct($post)
    {
        $this->data = $post;
    }


    public function sanitize(): array
    {
        foreach ($this->data as $key => $data) {
            $this->data[$key] = htmlspecialchars(stripslashes(trim($data)));
        }
        return $this->data;
    }
}
