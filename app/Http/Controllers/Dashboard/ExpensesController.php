<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ExpensesController extends Controller
{
    public function create($journeyId) {
     
        return view("dashboard.expenses.add", compact('journeyId'));
    }

    public function store(Request $request, $journeyId) {     
        $validated = $request->validate([
            "description" => ["required", "string"],
            "cost" => ["required", "decimal:0,2", 'gt:0'],
            'event_date' => ["required", "string"],
        ]);
        $event = Event::create([
            'journey_id' => $journeyId,
            'type' => 'expense',
            'event_date' => $validated["event_date"],
        ]);
        $expense = Expense::create([
            "event_id" => $event->id,
            "description" => $validated["description"],
            "cost" => $validated["cost"],
        ]);
    
        return redirect()->route("dashboard.journies.view")->with("success", "Expense created!");
    }

    public function edit($id) {
        $expense = Expense::with('event.journey')->where('id', $id)->first();;
        if ($expense && Gate::allows("update-journey", $expense->event->journey)) {
            return view("dashboard.expenses.edit", compact("expense"));
        }
        return back()->withErrors("Expense not exists!");
    }

    public function update(Request $request, $id) {
        $expense = Expense::with('event.journey')->where('id', $id)->first();;
        if ($expense && Gate::allows("update-journey", $expense->event->journey)) {
            $validated = $request->validate([
                "description" => ["required", "string"],
                'event_date' => ["required", "string"],
            ]);
            $expense->event->event_date = $validated["event_date"];
            $expense->description = $validated["description"];
            $expense->save();
            $expense->event->save();
            return redirect()->route("dashboard.journies.index")->with("success", "Expense updated!");
        }
        return back()->withErrors("Expense not exists!");
    }

    public function destroy($id) {
        $expense = Expense::with('event.journey')->where('id', $id)->first();;
        if ($expense && Gate::allows("update-journey", $expense->event->journey)) {
            $expense->delete();
            $expense->event->delete();
            return back()->with("success", "Expense deleted!");
        }
        return back()->withErrors("Expense not exists!");
    }

}
