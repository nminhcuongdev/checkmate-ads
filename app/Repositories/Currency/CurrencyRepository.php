<?php
namespace App\Repositories\Currency;

use App\Models\Account;
use App\Models\Currency;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class CurrencyRepository extends BaseRepository implements CurrencyRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Currency::class;
    }

    public function search($paginate = true)
    {
        $result = $this->model->select('id', 'code', 'rate');

        if (request()->get('searchCode')) {
            $result->where('code', 'like', '%' . request()->get('searchCode') . '%');
        }

        if ($paginate == false){
            return $result->get();
        }
        return $result->paginate(config('const.numPerPage'));
    }
}
