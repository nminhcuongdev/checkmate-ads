<?php
namespace App\Repositories\Notification;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Notification::class;
    }

    public function getByCustomer() {
        $result = $this->model->select('id', 'name', 'email', 'balance', 'fee', 'ins_datetime', 'admin_id', 'account_id')->where('admin_id', Auth::guard('admin')->user()->id);
        if (request()->get('searchName')) {
            $result->where('name', 'like', '%' . request()->get('searchName') . '%');
        }

        return $result->get();
    }

    public function search($paginate = true)
    {
        $result = $this->model->select('id', 'title', 'content', 'date', 'type');



        if ($paginate == false){
            return $result->get();
        }

        return $result->paginate(config('const.numPerPage'));
    }
}
