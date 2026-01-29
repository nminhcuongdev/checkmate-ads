<?php

namespace App\Http\Controllers;

use App\Http\Requests\Currency\EditRequest;
use App\Repositories\Currency\CurrencyRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class CurrencyController extends Controller
{

    protected $currencyRepo;

    public function __construct(CurrencyRepositoryInterface $currencyRepo)
    {
        $this->currencyRepo = $currencyRepo;

    }

    public function index()
    {
        $currencies = $this->currencyRepo->search(false);

        return view('management.currency.index', ['currencies' => $currencies]);
    }

    public function edit($id) {
        try {
            $currency = $this->currencyRepo->find($id);
            session()->put('currency_data', $currency);
        } catch (\Exception $e) {
            Log::error('Customer Edit Error ', ['admin_id' => Auth::guard('admin')->id(), 'error' => $e->getMessage()]);
            session()->flash('error', __('messages.customerNotFound'));
            return redirect()->route('management.customer');
        }
        return view('management.currency.edit', ['currency' => $currency]);
    }

    public function update(EditRequest $editRequest, $id)
    {
        try {
            DB::beginTransaction();
            $data = request()->all();
            $result = $this->currencyRepo->update($id, $data);
            if (!empty($result)) {
                session()->flash('success', "Currency Updated");
            }
            DB::commit();
        } catch (Exception $e) {
            Log::error('Update customer Error ', ['admin_id' => Auth::guard('admin')->id(), 'error' => $e->getMessage()]);
            DB::rollBack();
            session()->flash('error', __('messages.updateFail'));
        }
        return redirect()->route('management.currency');
    }
}
