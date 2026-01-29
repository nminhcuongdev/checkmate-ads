<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankReport\EditRequest;
use App\Http\Requests\BankReport\CreateRequest;
use App\Models\Admin;
use App\Repositories\Bank\BankRepositoryInterface;
use App\Repositories\BankReport\BankReportRepositoryInterface;
use App\Repositories\Customer\CustomerRepositoryInterface;
use AshAllenDesign\LaravelExchangeRates\Classes\ExchangeRate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class BankReportController extends Controller
{

    protected $bankRepo;
    protected $bankReportRepo;

    public function __construct(BankRepositoryInterface $bankRepo, BankReportRepositoryInterface $bankReportRepo)
    {
        $this->bankRepo = $bankRepo;
        $this->bankReportRepo = $bankReportRepo;
    }

    public function index()
    {
        $banks = $this->bankRepo->getAllByTech();
        $techs = Admin::where('role', '2')->get();
        $bankReports = $this->bankReportRepo->search(false);
        return view('management.bankreport.index', ['bankReports' => $bankReports, 'banks' => $banks, 'techs' => $techs]);
    }

    public function create($bank_id) {
        try {
            $bank = $this->bankRepo->find($bank_id);
            session()->put('bank_data', $bank);
        } catch (\Exception $e) {
            Log::error('Account Edit Error ', ['admin_id' => Auth::guard('admin')->id(), 'error' => $e->getMessage()]);
            session()->flash('error', __('messages.bankNotFound'));
            return redirect()->route('management.bank');
        }

        return view('management.bankreport.create', ['bank' => $bank]);
    }

    public function store(CreateRequest $createRequest) {
        try {
            DB::beginTransaction();
            $data = request()->all();
            $data['balance'] = (double)$data['receive'] + (double)$data['transfer'] - (double)$data['refund'] - (double)$data['pay'];
            $data['pay_usd'] = app(ExchangeRate::class)->convert((double)$data['pay'], 'VND', 'USD', Carbon::now());
            $this->bankReportRepo->create($data);
            session()->flash('success', __('messages.reportCreated'));
            DB::commit();
        } catch (\Exception $e) {
            Log::error('Report Create Error ', ['admin_id' => Auth::guard('admin')->id(), 'error' => $e->getMessage()]);
            DB::rollBack();
            session()->flash('error', __('messages.createFail'));
        }

        return redirect()->route('management.bankReport');
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
