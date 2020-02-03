<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Contract;
use App\Models\RentalPayment;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class RentalPaymentsController extends Controller
{
    public function index()
    {
        $month = Request::get('month', date('m'));
        $year = Request::get('year', date('Y'));

        $date = Carbon::create($year, $month, 1);
        
        $generateRegistersByMonthCaseNotExits = (function() use ($month, $year, $date) {
            $contracts = Contract::
                where('date_begin', '<=', $date->toDateString())
                ->where('date_end', '>=', $date->addMonths(1)->toDateString())
                ->whereDoesntHave('rentalPayments', function($query) use ($month, $year) {
                    return $query->where('month_ref', $month)->where('year_ref', $year);
                })
                ->paginate();
                
            $contracts->each(function($contract) use ($month, $year) {
                $contract->rentalPayments()->create([
                    'month_ref' => $month,
                    'year_ref' => $year 
                    ]);
            });
        })();
                
        $payments = RentalPayment::with('contract.tenant', 'contract.property')
            ->where('month_ref', $month)
            ->where('year_ref', $year)
            ->paginate()
            ->transform(function($payment) {
                return [
                    'id' => $payment->id,
                    'paid' => $payment->paid,
                    'due_date' => $payment->contract->date_begin->format('d'),
                    'payable' => $payment->paid ? 'Pago' : (date('d') > $payment->contract->date_begin->format('d') ? 'Atrasado' : 'A vencer'),
                    'tenant' => $payment->contract->tenant->first_name,
                    'property' => $payment->contract->property->address,
                ];
            });
        
        return Inertia::render('RentalPayments/Index', [
            'filters' => Request::all('search', 'month', 'year'),
            'payments' => $payments
        ]);
    }

    public function update($payment)
    {
        $payment->update(Request::all());
        
        return Redirect::back()->with('status', 'Registro atualizado com sucesso');
    }
}
