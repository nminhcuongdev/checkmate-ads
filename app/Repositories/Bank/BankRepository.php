<?php
namespace App\Repositories\Bank;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class BankRepository extends BaseRepository implements BankRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Bank::class;
    }

    public function getAllByTech() {
        $result = $this->model->select('id', 'name', 'owner', 'bank_account', 'admin_id')->where('admin_id', Auth::guard('admin')->id());

        return $result->get();
    }

    public function search($paginate = true)
    {
        $result = $this->model->select('id', 'name', 'owner', 'bank_account', 'admin_id')->where('admin_id', Auth::guard('admin')->id());
        if ($paginate == false){
            return $result->get();
        }
        return $result->paginate(config('const.numPerPage'));
    }
}
