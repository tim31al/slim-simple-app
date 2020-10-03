<?php


namespace App\Model;


interface ModelInterface
{
    public function create() : int;

    public function read(int $id = null);

    public function update() :bool;

    public function delete() : bool;

    public function validate($isNew = true) : bool;

}