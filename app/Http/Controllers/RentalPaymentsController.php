<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Finance;
use App\Models\Contract;
use Carbon\CarbonImmutable;
use App\Models\RentalPayment;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class RentalPaymentsController extends Controller
{
    public function index()
    {
        $month = Request::get('month', date('m'));
        $year = Request::get('year', date('Y'));

        $date = CarbonImmutable::create($year, $month, 1, 0, 0, 0, 'America/Sao_Paulo');
        
        $payments = Contract::
            where(function($query) use ($date) {
                $query->where('date_begin', '<=', $date->toDateString())
                ->where('date_end', '>=', $date->addMonths(1)->toDateString())
                ->orWhere(function($query) use ($date) {
                    $query->whereMonth('date_begin', $date->format('m'))
                    ->whereYear('date_begin', $date->format('Y'));
                });
            })
            ->with(['rentalPayment' => function($query) use ($month, $year) {
                return $query->where('month_ref', $month)->where('year_ref', $year);
            }])
            ->paginate()
            ->transform(function($payment) {
                return [
                    'id' => $payment->id,
                    'rental_payment' => $payment->rentalPayment->toArray(),
                    'paid' => $payment->rentalPayment !== null ? true : false,
                    'due_date' => $payment->date_begin->format('d'),
                    'payable' => $payment->rentalPayment !== null ? 'Pago' : (date('d') > $payment->date_begin->format('d') ? 'Atrasado' : 'A vencer'),
                    'tenant' => $payment->tenant->first_name,
                    'property' => $payment->property->address,
                ];
            });

        return Inertia::render('RentalPayments/Index', [
            'filters' => Request::all('search', 'month', 'year'),
            'payments' => $payments
        ]);
    }

    public function create($month, $year, Contract $contract) 
    {
        return Inertia::render('RentalPayments/Create', [
            'month' => $month,
            'year' => $year,
            'contract' => $contract
        ]);
    }

    public function store(Contract $contract)
    {
        $rentalPayment = $contract->rentalPayment()->create([
            'type' => Finance::RENTAL_PAYMENTS,
            'month_ref' => Request::input('month_ref'),
            'year_ref' => Request::input('year_ref'),
            'credit' => $contract->price
        ]);

        $rentalPayment = $contract->rentalPayment()->create([
            'type' => Finance::COMMISSION,
            'month_ref' => Request::input('month_ref'),
            'year_ref' => Request::input('year_ref'),
            'debt' => $contract->price * 0.10
        ]);
        
        return Redirect::route('rental_payments')->with('success', 'Pagamento lançado.');
    }

    public function update($payment)
    {
        $payment->update(Request::all());
        
        return Redirect::back()->with('status', 'Registro atualizado com sucesso');
    }
}
