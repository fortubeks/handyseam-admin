<?php

use Magarrent\LaravelCurrencyFormatter\Facades\Currency;
use App\Models\User;

function formatCurrency($amount)
{
    // $f = (float)$amount;
    // return Currency::currency("NGN")->format($f);
    $formatted = number_format($amount, 2);
    return "₦" . $formatted;
}
if (! function_exists('divnum')) {

    function divnum($numerator, $denominator)
    {
        return $denominator == 0 ? 0 : ($numerator / $denominator);
    }
}
function removeSpaces($inputString)
{
    return str_replace(' ', '', $inputString);
}
function getBanksList()
{
    $banks = [
        'Access Bank Plc',
        'Fidelity Bank Plc',
        'First City Monument Bank Plc',
        'First Bank of Nigeria Limited',
        'Guaranty Trust Bank Plc',
        'Union Bank of Nigeria Plc',
        'United Bank for Africa Plc',
        'Zenith Bank Plc',
        'Citibank Nigeria Limited',
        'Ecobank Nigeria Plc',
        'Heritage Banking Company Limited',
        'Keystone Bank Limited',
        'Polaris Bank Limited. (Formerly Skye Bank Plc)',
        'Stanbic IBTC Bank Plc',
        'Standard Chartered',
        'Sterling Bank Plc',
        'Titan Trust Bank Limited',
        'Unity Bank Plc',
        'Wema Bank Plc',
        'Globus Bank Limited',
        'SunTrust Bank Nigeria Limited',
        'Providus Bank Limited',
        'Jaiz Bank Plc',
        'Taj Bank Limited',
        'Coronation Merchant Bank',
        'FBNQuest Merchant Bank',
        'FSDH Merchant Bank',
        'Rand Merchant Bank',
        'Nova Merchant Bank'
    ];
    return $banks;
}
function getModelList($model)
{
    $model_list = null;
    if ($model == 'expense-categories') {
        $model_list = \App\Models\ExpenseCategory::all();
    }
    if ($model == 'branches') {
        $model_list = \App\Models\Branch::all();
    }
    if ($model == 'suppliers') {
        $model_list = \App\Models\Supplier::all();
    }
    if ($model == 'products') {
        $model_list = \App\Models\Product::all();
    }
    if ($model == 'customers') {
        $model_list = \App\Models\Customer::all();
    }
    return $model_list;
}
