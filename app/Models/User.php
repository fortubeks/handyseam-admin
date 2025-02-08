<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function invoices()
    {
        return $this->hasMany('App\Models\Invoice');
    }

    public function expenses()
    {
        return $this->hasMany('App\Models\Expense');
    }

    public function purchases()
    {
        return $this->hasMany('App\Models\Purchase');
    }

    public function expense_categories()
    {
        return $this->hasMany('App\Models\ExpenseCategory');
    }

    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }

    public function item_categories()
    {
        return $this->hasMany('App\Models\ItemCategory');
    }

    public function customers()
    {
        return $this->hasMany('App\Models\Customer');
    }

    public function app_settings()
    {
        return $this->hasOne('App\Models\Setting');
    }

    public function subscriptions()
    {
        return $this->hasMany('App\Models\Subscription');
    }

    public function user_account()
    {
        return $this->belongsTo('App\Models\User', 'user_account_id');
    }

    public function isPremiumUser()
    {
        $isExpired = true;
        $user = auth()->user()->user_account;
        $last_subscription = $user->subscriptions->last();
        if ($last_subscription && $last_subscription->package->name == "Silver") {
            $isExpired = Carbon::createFromTimestamp(strtotime($last_subscription->expires_at))->isPast();
        }

        if (!$isExpired) {
            return true;
        }
        return false;
    }

    public function active_tailors()
    {
        $active_tailors = Staff::where('user_account_id', '=', auth()->user()->user_account_id)
            ->where('is_active', '=', 1)->where('role', '=', 'tailor')->get();
        return $active_tailors;
    }

    public function getOrdersDueThisWeek()
    {
        $orders = Order::orderBy('expected_delivery_date', 'asc')
            ->where('status', '!=', 'Completed')
            ->where('user_id', '=', $this->id)->paginate(20);
        return $orders;
    }
    public function getRecentOrders()
    {
        $orders = Order::orderBy('created_at', 'desc')->where('user_id', '=', $this->id)->paginate(20);
        return $orders;
    }
    public function getWeeklyInfo()
    {
        $weekly_info = [];
        $start_date = Carbon::today()->subDay(7);
        $end_date = Carbon::today()->subDay(0);
        $prev_week_start = Carbon::today()->subDay(14);
        $prev_week_end = Carbon::today()->subDay(7);
        $newOrdersThisWeek = Order::where('user_id', $this->id)->whereBetween('created_at', [$start_date, $end_date])->get()->count();
        $newOrdersLastWeek = Order::where('user_id', $this->id)->whereBetween('created_at', [$prev_week_start, $prev_week_end])->get()->count();
        $newOrdersChange = divnum(($newOrdersThisWeek - $newOrdersLastWeek), $newOrdersThisWeek) * 100;
        $newCustomersThisWeek = Customer::where('user_id', $this->id)->whereBetween('created_at', [$start_date, $end_date])->get()->count();
        $newCustomersLastWeek = Customer::where('user_id', $this->id)->whereBetween('created_at', [$prev_week_start, $prev_week_end])->get()->count();
        $newCustomersChange  = divnum(($newCustomersThisWeek - $newCustomersLastWeek), $newCustomersThisWeek) * 100;
        $weekly_info['startDate'] = $start_date->format('Y-m-d');
        $weekly_info['endDate'] = $end_date->format('Y-m-d');
        $weekly_info['newOrdersThisWeek'] = $newOrdersThisWeek;
        $weekly_info['newOrdersLastWeek'] = $newOrdersLastWeek;
        $weekly_info['newOrdersChange'] = $newOrdersChange;
        $weekly_info['newCustomersThisWeek'] = $newCustomersThisWeek;
        $weekly_info['newCustomersLastWeek'] = $newCustomersLastWeek;
        $weekly_info['newCustomersChange'] = $newCustomersChange;
        $weekly_info['orders'] = $this->getOrdersDueThisWeek();
        return $weekly_info;
    }

    public function whatsappNumber()
    {
        //if number has space remove it
        $whatsapp_number = removeSpaces($this->phone);
        //if number has 0 as first character remove it
        $whatsapp_number = ltrim($whatsapp_number, '0');
        //if number has + remove it
        if (substr($whatsapp_number, 0, 1) === '+') {
            return ltrim($whatsapp_number, '+');
        }
        return '+234' . $whatsapp_number;
    }
}
