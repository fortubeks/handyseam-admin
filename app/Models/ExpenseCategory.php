<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;
    public $table = "expense_categories";

    public static function getAll()
    {
        $expense_categories = ExpenseCategory::where('user_id', '=', auth()->user()->user_account_id)->get();
        return $expense_categories;
    }
    public function expenses()
    {
        return $this->hasMany('App\Models\Expense');
    }
}
