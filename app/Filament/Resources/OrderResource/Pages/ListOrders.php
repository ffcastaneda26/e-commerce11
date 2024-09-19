<?php

namespace App\Filament\Resources\OrderResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\OrderResource\Widgets\OrderStats;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            OrderStats::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            'all'       => Tab::make(__('All')),
            'news'      => Tab::make(__('News'))->query(fn($query) => $query->where('status','new')),
            'processing'=> Tab::make(__('Processing'))->query(fn($query) => $query->where('status','processing')),
            'shipped'   => Tab::make(__('Shipened'))->query(fn($query) => $query->where('status','shipped')),
            'delivered' => Tab::make(__('Delivered'))->query(fn($query) => $query->where('status','delivered')),
            'cancelled' => Tab::make(__('Cancelled'))->query(fn($query) => $query->where('status','cancelled')),
        ];
    }
}
