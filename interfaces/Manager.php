<?php

namespace App\Interfaces;

interface Manager
{
    public function getAll();
    public function get(int $id);
    public function add(array $values);
    public function update(array $values, int $id);
    public function remove(int $id);
}