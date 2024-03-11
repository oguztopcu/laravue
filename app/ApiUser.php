<?php

namespace App;

class ApiUser
{
    public $user;

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    public function user()
    {
        return $this->user;
    }
}