<?php
namespace App\Repositories\Currency;

use App\Repositories\RepositoryInterface;

interface CurrencyRepositoryInterface extends RepositoryInterface
{
    public function search($paginate = true);
}
