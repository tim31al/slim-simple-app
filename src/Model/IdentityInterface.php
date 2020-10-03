<?php


namespace App\Model;


interface IdentityInterface
{
    public function login() : bool;
    public static function isLogged() : bool;
    public static function logout();
    public function isCreator() : bool;
    public function isAdmin() : bool;
}