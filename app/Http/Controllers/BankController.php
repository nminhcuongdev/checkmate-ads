<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bank\EditRequest;
use App\Http\Requests\Bank\CreateRequest;
use App\Repositories\Bank\BankRepositoryInterface;
use App\Repositories\Customer\CustomerRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class BankController extends Controller
{

    protected $bankRepo;
    protected $accountRepo;

    public function __construct(BankRepositoryInterface $bankRepo, CustomerRepositoryInterface $customerRepo)
    {
        $this->bankRepo = $bankRepo;
        $this->customerRepo = $customerRepo;
    }

    public function index()
    {
        $banks = $this->bankRepo->search(false);
        return view('management.bank.index', ['banks' => $banks]);
    }

    public function create() {
        return view('management.bank.create');
    }

    public function store(CreateRequest $createRequest) {
        try {
            DB::beginTransaction();
            $data = request()->all();
            $this->bankRepo->create($data);
            session()->flash('success', __('messages.accountCreated'));
            DB::commit();
        } catch (\Exception $e) {
            Log::error('Account Create Error ', ['admin_id' => Auth::guard('admin')->id(), 'error' => $e->getMessage()]);
            DB::rollBack();
            session()->flash('error', __('messages.createFail'));
        }

        return redirect()->route('management.bank');
    }

    public function edit($id) {
        try {
            $bank = $this->bankRepo->find($id);
            session()->put('bank_data', $bank);
        } catch (\Exception $e) {
            Log::error('Account Edit Error ', ['admin_id' => Auth::guard('admin')->id(), 'error' => $e->getMessage()]);
            session()->flash('error', __('messages.bankNotFound'));
            return redirect()->route('management.bank');
        }
        return view('management.bank.edit', ['bank' => $bank]);
    }

    public function update(EditRequest $editRequest, $id)
    {
        try {
            DB::beginTransaction();
            $data = request()->all();
            $result = $this->bankRepo->update($id, $data);
            if (!empty($result)) {
                session()->flash('success', __('messages.bankUpdated'));
            }
            DB::commit();
        } catch (Exception $e) {
            Log::error('Update bank Error ', ['admin_id' => Auth::guard('admin')->id(), 'error' => $e->getMessage()]);
            DB::rollBack();
            session()->flash('error', __('messages.updateFail'));
        }
        return redirect()->route('management.bank');
    }

    public function delete($id) {
        try {
            $this->bankRepo->delete($id);
            session()->flash('success', __('messages.bankDeleted'));
        } catch (Exception $e) {
            Log::error('Bank Delete Error ', ['admin' => Auth::guard('admin')->id(), 'error' => $e->getMessage()]);
            session()->flash('error', __('messages.deleteFail'));
        }

        return redirect()->route('management.bank');
    }
}
