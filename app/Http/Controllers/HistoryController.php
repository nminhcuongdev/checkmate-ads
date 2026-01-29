<?php

namespace App\Http\Controllers;

use App\Http\Requests\History\EditRequest;
use App\Http\Requests\History\CreateRequest;
use App\Models\History;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Repositories\History\HistoryRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class HistoryController extends Controller
{
    protected $historyRepo;
    protected $customerRepo;

    public function __construct(HistoryRepositoryInterface $historyRepo, CustomerRepositoryInterface $customerRepo)
    {
        $this->historyRepo = $historyRepo;
        $this->customerRepo = $customerRepo;
    }

    public function index()
    {
        $histories = $this->historyRepo->search(false);
        return view('management.history.index', ['histories' => $histories]);
    }

    public function create() {
        $customers = $this->customerRepo->getAll();
        return view('management.history.create', ['customers' => $customers]);
    }

    public function store(CreateRequest $createRequest) {
        try {
            DB::beginTransaction();
            $data = request()->all();
            $customer = $this->customerRepo->find($data['customer_id']);
            $fee = $data['amount'] / 100 * $customer->fee;
            $data['fee'] = $fee;
            $data['last_balance'] = $customer->balance;
            $data['amount'] -= $fee;
            $history = $this->historyRepo->create($data);
            if ($history) {
                $this->customerRepo->update($customer->id, ['balance' => $customer->balance + $data['amount'], 'amount_fee' => $customer->amount_fee + $fee]);
                session()->flash('success', __('messages.historyCreated'));
                DB::commit();
            } else {
                session()->flash('error', __('messages.createFail'));
            }
        } catch (\Exception $e) {
            Log::error('History Create Error ', ['admin_id' => Auth::guard('admin')->id(), 'error' => $e->getMessage()]);
            DB::rollBack();
            session()->flash('error', __('messages.createFail'));
        }

        return redirect()->route('management.history');
    }

    public function edit($id) {
        try {
            $history = $this->historyRepo->find($id);
            $customers = $this->customerRepo->getAll();
            session()->put('history_data', $history);
        } catch (\Exception $e) {
            Log::error('Customer Edit Error ', ['admin_id' => Auth::guard('admin')->id(), 'error' => $e->getMessage()]);
            session()->flash('error', __('messages.customerNotFound'));
            return redirect()->route('management.customer');
        }
        return view('management.history.edit', ['history' => $history, 'customers' => $customers]);
    }

    public function update(EditRequest $editRequest, $id)
    {
        try {
            DB::beginTransaction();
            $data = request()->all();
            if (!empty($data['addAmount']))  {
                $data['amount'] += $data['addAmount'];
            }
            $result = $this->historyRepo->update($id, $data);
            $customer = $this->customerRepo->find($data['customer_id']);
            $this->customerRepo->update($customer->id, ['balance' => $customer->balance+$data['addAmount']]);
            if (!empty($result)) {
                session()->flash('success', __('messages.historyUpdated'));
            }
            DB::commit();
        } catch (Exception $e) {
            Log::error('History account Error ', ['admin_id' => Auth::guard('admin')->id(), 'error' => $e->getMessage()]);
            DB::rollBack();
            session()->flash('error', __('messages.updateFail'));
        }
        return redirect()->route('management.history');
    }

    public function delete($id) {
        try {
            $history = $this->historyRepo->find($id);
            History::destroy($id);
            $customer = $this->customerRepo->find($history['customer_id']);
            $customer->update(['balance' => $customer->balance - $history->amount, 'amount_fee' => $customer->amount_fee - $history->fee]);
            session()->flash('success', __('messages.historyDeleted'));
        } catch (Exception $e) {
            Log::error('History Delete Error ', ['admin' => Auth::guard('admin')->id(), 'error' => $e->getMessage()]);
            session()->flash('error', __('messages.deleteFail'));
        }

        return redirect()->route('management.history');
    }
}
