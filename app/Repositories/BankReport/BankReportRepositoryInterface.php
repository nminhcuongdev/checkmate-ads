<?php
namespace App\Repositories\BankReport;

use App\Repositories\RepositoryInterface;

interface BankReportRepositoryInterface extends RepositoryInterface
{
    public function search($paginate = true);
}
