<?php

namespace App\Http\Controllers;

use App\Charts\MyChart;
use App\Expense;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if ($this->isUserType('admin')) {
            $transactions = $this->getTransactionsByMonth();

            $incomes = collect();
            $grosss = collect();
            $capitals = collect();
            $dates = collect();
            $clerks = collect();
            $rentals = collect();
            $electrics= collect();
            $waters = collect();
            $services = collect();
            $otherss = collect();

            foreach (Expense::orderBy('month','asc')->get() as $expense) {
                $gross = 0.0;
                $income = 0.0;
                $capital = 0.0;
                if (!empty($transactions[date('M Y', strtotime($expense->month))])) {
                    foreach ($transactions[date('M Y', strtotime($expense->month))] as $transaction) {
                        $gross += $transaction->income;
                        $capital += $transaction->capital;
                    }
                    $income = $gross - (
                            $expense->clerk + $expense->rental +
                            $expense->electric + $expense->water +
                            $expense->service + $expense->others
                        );
                }

                $dates->push(date('M Y', strtotime($expense->month)));
                $incomes->push($income);
                $grosss->push($gross);
                $capitals->push($capital);
                $clerks->push($expense->clerk);
                $rentals->push($expense->rental);
                $electrics->push($expense->electric);
                $waters->push($expense->water);
                $services->push($expense->service);
                $otherss->push($expense->others);
            }

            $data = array(
                'dates' => $dates,
                'incomes' => $incomes,
                'grosss' => $grosss,
                'capitals' => $capitals,
                'clerks' => $clerks,
                'rentals' => $rentals,
                'electrics' => $electrics,
                'waters' => $waters,
                'services' => $services,
                'otherss' => $otherss,
            );

            $chart = new MyChart;
            $chart->labels($data['dates']);
            $chart->dataset('Gross', 'line', $data['grosss'])->options(['color' => '#3490dc']);
            $chart->dataset('Capital', 'line', $data['capitals'])->options(['color' => '#dd0']);
            $chart->dataset('Income', 'line', $data['incomes'])->options(['color' => '#38c172']);
            $chart->dataset('Sales Clerk Fee', 'line', $data['clerks'])->options(['color' => '#f00']);
            $chart->dataset('Rental Fee', 'line', $data['rentals'])->options(['color' => '#d00']);
            $chart->dataset('Electric Bill', 'line', $data['electrics'])->options(['color' => '#b00']);
            $chart->dataset('Water Bill', 'line', $data['waters'])->options(['color' => '#900']);
            $chart->dataset('Service Fee', 'line', $data['services'])->options(['color' => '#700']);
            $chart->dataset('Others Fee', 'line', $data['otherss'])->options(['color' => '#500']);

            return view('pages.expenses')
                ->with('expenses', Expense::orderBy('month', 'desc')->get())
                ->with('data', $data)
                ->with('chart', $chart);
        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if ($this->isUserType('admin'))
            return view('pages.expenses.create');

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if ($this->isUserType('admin')) {
            $this->validate($request, [
                'month' => 'required',
                'clerk' => 'required',
                'rental' => 'required',
                'water' => 'required',
                'electric' => 'required',
                'service' => 'required',
                'others' => 'required'
            ]);

            $month = Carbon::createFromFormat('Y-m-d', $request->input('month').'-01');

            foreach (Expense::all() as $expense) {
                $current = Carbon::createFromFormat('Y-m-d H:i:s', $expense->month);
                if ($month->isSameMonth($current) && $month->isSameYear($current))
                    return redirect('/expenses')
                        ->with('error', date('F Y', strtotime($expense->month)). ' was already saved!');
            }

            $expense = new Expense;
            $expense->month = Carbon::createFromFormat('Y-m-d', $request->input('month').'-01');
            $expense->clerk = $request->input('clerk');
            $expense->rental = $request->input('rental');
            $expense->water = $request->input('water');
            $expense->electric = $request->input('electric');
            $expense->service = $request->input('service');
            $expense->others = $request->input('others');
            $expense->save();

            return redirect('/expenses')->with('success', 'Saved new monthly expenses successfully!');
        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        if ($this->isUserType('admin')) {
            $gross = 0.0;
            $income = 0.0;
            $capital = 0.0;
            $transactions = $this->getTransactionsByMonth();
            $expense = Expense::find($id);
            if(!empty($transactions[date('M Y', strtotime($expense->month))])) {
                foreach ($transactions[date('M Y', strtotime($expense->month))] as $transaction) {
                    $gross += $transaction->income;
                    $capital += $transaction->capital;
                }
                $income = $gross - (
                        $expense->clerk + $expense->rental +
                        $expense->electric + $expense->water +
                        $expense->service + $expense->others
                    );
            }

            return view('pages.expenses.show')
                ->with('expense', Expense::find($id))
                ->with('income', $income)
                ->with('gross', $gross)
                ->with('capital', $capital);
        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        if ($this->isUserType('admin'))
            return view('pages.expenses.edit')
                ->with('expense', Expense::find($id))
                ->with('expenses', Expense::all());

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        if ($this->isUserType('admin')) {
            $this->validate($request, [
                'month' => 'required',
                'clerk' => 'required',
                'rental' => 'required',
                'water' => 'required',
                'electric' => 'required',
                'service' => 'required',
                'others' => 'required'
            ]);
            
            $expense = Expense::find($id);
            $expense->month = Carbon::createFromFormat('Y-m-d', $request->input('month').'-01');
            $expense->clerk = $request->input('clerk');
            $expense->rental = $request->input('rental');
            $expense->water = $request->input('water');
            $expense->electric = $request->input('electric');
            $expense->service = $request->input('service');
            $expense->others = $request->input('others');
            $expense->save();

            return redirect('/expenses')->with('success', 'Updated '. date('F Y', strtotime($expense->month)) .' expenses successfully!');
        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        if ($this->isUserType('admin')) {
            $expense = Expense::find($id);
            $expense->delete();
            return redirect('/expenses')->with('success', 'Deleted Monthly Expenses Successfully!');
        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function isUserType($type) { return (User::find(auth()->user()->id)->type == $type) ? true : false; }

    public function getTransactionsByMonth() {
        return Transaction::orderBy('created_at','asc')->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('M Y'); // grouping by format w/ year
            });
    }
}
