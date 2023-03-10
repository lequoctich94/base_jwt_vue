<?php
namespace App\Repositories\Staff;

use App\Repositories\RepositoryInterface;

interface StaffRepositoryInterface extends RepositoryInterface
{
    public function findByEmail($email);
}
