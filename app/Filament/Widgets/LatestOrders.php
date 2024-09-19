<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\SelectColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;
    public function table(Table $table): Table
    {
        return $table
            ->query(OrderResource::getEloquentQuery())
                ->defaultPaginationPageOption(5)
                ->defaultSort('created_at','desc')
            ->columns([
                TextColumn::make('user.name')->label(__('Customer'))->searchable()->sortable(),
                TextColumn::make('created_at')->dateTime('d-M-Y')->translateLabel(),
                TextColumn::make('payment_method')->searchable()->sortable()->translateLabel()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('payment_status')->searchable()->sortable()->translateLabel()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('currency')->searchable()->sortable()->translateLabel()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make(name: 'shipping_method')->searchable()->sortable()->translateLabel()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('grand_total')
                    		->translateLabel()
                    		->alignment(Alignment::End)
                    		->numeric(decimalPlaces: 2, decimalSeparator: '.' , thousandsSeparator: ','),
                SelectColumn::make('status')->searchable()->sortable()->translateLabel()
                    ->options([
                        'new' => __('New'),
                        'processing' => __('Processing'),
                        'shipped' => __('Shipped'),
                        'delivered' => __('Delivered'),
                        'cancelled' => __('Cancelled'),
                    ])
            ])->actions([
                Action::make(__('view'))
                ->url(fn(Order $record):string => OrderResource::getUrl('view',['record' => $record]))
                ->color('info')
                ->icon('heroicon-o-eye'),
            ])->heading(__('Latest Orders'));
    }
}
