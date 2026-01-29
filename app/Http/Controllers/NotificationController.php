<?php

namespace App\Http\Controllers;

use App\Http\Requests\Notification\EditRequest;
use App\Http\Requests\Notification\CreateRequest;
use App\Models\CustomerNotification;
use App\Models\Notification;
use App\Models\PostHasCategories;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Models\Customer;
use Cassandra\Custom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class NotificationController extends Controller
{
    protected $notiRepo;
    protected $customerRepo;

    public function __construct(NotificationRepositoryInterface $notiRepo, CustomerRepositoryInterface $customerRepo)
    {
        $this->notiRepo = $notiRepo;
        $this->customerRepo = $customerRepo;
    }

    public function index()
    {
        $notifications = $this->notiRepo->search(false);
        $customers = Customer::orderBy('name', 'asc')->get();
        return view('management.notification.index', ['notifications' => $notifications, 'customers' => $customers]);
    }

    public function customerNotification()
    {
        $notificationIds = CustomerNotification::where('customer_id', Auth::guard('customer')->id())->pluck('notification_id');
        $notifications = Notification::whereIn('id', $notificationIds)->get();
        return view('management.notification.index', ['notifications' => $notifications]);
    }

    public function create() {
        $customers = $this->customerRepo->getAll();
        return view('management.notification.create', ['customers' => $customers]);
    }

    public function store(CreateRequest $createRequest) {
        try {
            $data = request()->all();
            $data['type'] = 1;
            $this->notiRepo->create($data);
            session()->flash('success', __('messages.notificationCreated'));
        } catch (\Exception $e) {
            Log::error('Notification Create Error ', ['admin_id' => Auth::guard('admin')->id(), 'error' => $e->getMessage()]);
            session()->flash('error', __('messages.createFail'));
        }

        return redirect()->route('management.notification');
    }

    public function edit($id) {
        try {
            $notification = $this->notiRepo->find($id);
            session()->put('notification_data', $notification);
        } catch (\Exception $e) {
            Log::error('Customer Edit Error ', ['admin_id' => Auth::guard('admin')->id(), 'error' => $e->getMessage()]);
            session()->flash('error', __('messages.customerNotFound'));
            return redirect()->route('management.customer');
        }
        return view('management.notification.edit', ['notification' => $notification]);
    }

    public function show($id) {
        try {
            $notification = $this->notiRepo->find($id);
            CustomerNotification::where('notification_id', $id)->update(['read_flag' => '1']);
            session()->put('notification_data', $notification);
        } catch (\Exception $e) {
            Log::error('Customer Edit Error ', ['admin_id' => Auth::guard('admin')->id(), 'error' => $e->getMessage()]);
            session()->flash('error', __('messages.customerNotFound'));
            return redirect()->route('management.customer');
        }
        return view('management.notification.show', ['notification' => $notification]);
    }


    public function chooseCustomer($id) {
        try {
            $notification = $this->notiRepo->find($id);
            $customers = $this->customerRepo->search(false);
            session()->put('notification_data', $notification);
        } catch (\Exception $e) {
            Log::error('Customer Edit Error ', ['admin_id' => Auth::guard('admin')->id(), 'error' => $e->getMessage()]);
            session()->flash('error', __('messages.customerNotFound'));
            return redirect()->route('management.customer');
        }
        return view('management.notification.chooseCustomer', ['notification' => $notification, 'customers' => $customers]);
    }

    public function send($id)
    {
        try {
            DB::beginTransaction();
            $data = request()->all();
            foreach ($data['customer'] as $customer) {
                $notification = CustomerNotification::where(['customer_id' => $customer['id'], 'notification_id' => $id])->get();
                if ($notification->count() == 0) {
                    $customerNotification = new CustomerNotification();
                    $customerNotification->customer_id = $customer['id'];
                    $customerNotification->notification_id = $id;
                    $customerNotification->save();
                }
            }
            DB::commit();
            session()->flash('success', "Choose Customer Succesfull!");
        } catch (Exception $e) {
            Log::error('Update notificaiton Error ', ['admin_id' => Auth::guard('admin')->id(), 'error' => $e->getMessage()]);
            DB::rollBack();
            session()->flash('error', __('messages.updateFail'));
        }
        return redirect()->route('management.notification');
    }


    public function update(EditRequest $editRequest, $id)
    {
        try {
            DB::beginTransaction();
            $data = request()->all();
            $result = $this->notiRepo->update($id, $data);
            if (!empty($result)) {
                session()->flash('success', __('messages.notificationUpdated'));
            }
            DB::commit();
        } catch (Exception $e) {
            Log::error('Update notificaiton Error ', ['admin_id' => Auth::guard('admin')->id(), 'error' => $e->getMessage()]);
            DB::rollBack();
            session()->flash('error', __('messages.updateFail'));
        }
        return redirect()->route('management.notification');
    }

    public function delete($id) {
        try {
            $history = $this->historyRepo->find($id);
            $this->historyRepo->delete($id);
            $customer = $this->customerRepo->find($history['customer_id']);
            $customer->update(['balance' => $customer->balance - $history->amount]);
            session()->flash('success', __('messages.historyDeleted'));
        } catch (Exception $e) {
            Log::error('History Delete Error ', ['admin' => Auth::guard('admin')->id(), 'error' => $e->getMessage()]);
            session()->flash('error', __('messages.deleteFail'));
        }

        return redirect()->route('management.history');
    }
}
