<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Illuminate\Support\Number;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class OrderStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('News'),Order::query()->where('status','new')->count()),
            Stat::make(__('Processing'),Order::query()->where('status','processing')->count()),
            Stat::make(__('Shipened'),Order::query()->where('status','shippend')->count()),
            //Stat::make(__('Delivered'),Order::query()->where('status','delivered')->count()),
           // Stat::make(__('Cancelled'),Order::query()->where('status','cancelled')->count()),
            // Stat::make(__('Average Price'), Number::currency(Order::query()->avg('grand_total'),'USD')),
            Stat::make(__('Average Price'), number_format(Order::query()->avg('grand_total'),2)),
        ];
    }


}
