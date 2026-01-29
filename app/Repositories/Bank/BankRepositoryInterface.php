<?php
namespace App\Repositories\Bank;

use App\Repositories\RepositoryInterface;

interface BankRepositoryInterface extends RepositoryInterface
{
    public function search($paginate = true);
}
