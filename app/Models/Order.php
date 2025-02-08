<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Order extends Model
{
    use HasFactory;

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer')->withTrashed();
    }
    public function invoice()
    {
        return $this->hasOne('App\Models\Invoice');
    }

    public function order_items()
    {
        return $this->hasMany('App\Models\OrderItem');
    }
    public function outfits()
    {
        return $this->hasMany('App\Models\OutfitsOrders');
    }
    public function ListofOrderStyleImagesWithFileUrl()
    {
        $list = array();
        $style_images = explode(',', $this->order_style_images);
        if (count($style_images) >= 1) {
            foreach ($style_images as $style_image) {
                $titles = explode('=', $style_image);
                if (count($titles) > 1) {
                    array_push($list, array($titles[0], $titles[1]));
                }
            }
        }

        return $list;
    }
    public static function getAll()
    {
        //get a list of all items in inventory
        $orders = Order::where('user_id', '=', auth()->user()->user_account_id)->latest()->paginate(20);
        return $orders;
    }
    public function getOrdersDueThisWeek()
    {
        $orders = Order::orderBy('expected_delivery_date', 'asc')
            ->where('status', '!=', 'Completed')
            ->where('order_type', 'tailoring')
            ->where('user_id', '=', auth()->user()->user_account_id)->paginate(20);
        return $orders;
    }
    public function getRecentOrders()
    {
        $orders = Order::orderBy('created_at', 'asc')->with('customer')
            ->where('user_id', '=', auth()->user()->user_account_id)->paginate(20);
        return $orders;
    }
    public function getTotalAmountPlusVAT()
    {
        return ($this->total_amount + $this->vat);
    }

    public function cost()
    {
        //subtract amount for tailor and sum of item used from total amount and return amounr
        $order_item_used_amount = 0;

        foreach ($this->outfits as $key => $outfit) {
            $outfit_item_used_amount = $outfit->items_used()->sum('amount');
            $order_item_used_amount += $outfit_item_used_amount;
        }

        $cost = $this->outfits()->sum('tailor_cost') + $this->outfits()->sum('material_cost') + $order_item_used_amount;

        return $cost;
    }

    public function getListOfOutfits()
    {
        return $this->outfits()->get(['name', 'job_status'])->map(function ($outfit) {
            return [
                'name' => $outfit->name,
                'status' => $outfit->job_status,
            ];
        })->toArray();
    }
}
