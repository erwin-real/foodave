<?php

namespace App\Http\Controllers;

use App\Expense;
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
        if ($this->isUserType('admin'))
            return view('pages.expenses');

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

            $expense = new Expense;
            $expense->month = Carbon::createFromFormat('Y-m-d', $request->input('month').'-01');
            $expense->clerk = $request->input('clerk');
            $expense->rental = $request->input('rental');
            $expense->water = $request->input('water');
            $expense->electric = $request->input('electric');
            $expense->service = $request->input('service');
            $expense->others = $request->input('others');
            $expense->save();

            return redirect('/')->with('success', 'Saved new monthly expenses successfully!');
        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense) {
        if ($this->isUserType('admin')) {

        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense) {
        if ($this->isUserType('admin')) {
            return view('pages.expenses.edit');
        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense) {
        if ($this->isUserType('admin')) {

        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense) {
        if ($this->isUserType('admin')) {

        }

        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function isUserType($type) { return (User::find(auth()->user()->id)->type == $type) ? true : false; }
}
