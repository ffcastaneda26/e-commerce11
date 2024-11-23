<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\RelationManagers\AddressRelationManager;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Number;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $activeNavigationIcon = 'heroicon-s-shield-check';

    protected static ?int $navigationSort = 5;
    public static function getNavigationLabel(): string
    {
        return __('Orders');
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::count() < 10 ? 'danger' : 'success';
    }
    public static function getPluralLabel(): ?string
    {
        return __('Orders');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function getModelLabel(): string
    {
        return __('Order');
    }

    public static function getNavigationGroup(): string
    {
        return __('Sales');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make(__('Order Information'))->schema([
                        Section::make()->schema([
                            Select::make('user_id')
                                ->label(__('Customer'))
                                ->relationship('user', 'name')
                                ->preload()
                                ->required()
                                ->searchable(),
                        ]),


                        Section::make()->schema([
                            Select::make('payment_method')
                                ->translateLabel()
                                ->options([
                                    'stripe' => 'Stripe',
                                    'cod' => __('Cash on Delivery')
                                ])
                                ->required(),

                            Select::make('payment_status')
                                ->translateLabel()
                                ->options([
                                    'pending' => __('Pending'),
                                    'paid' => __('Paid'),
                                    'failed' => __('Failed')
                                ])
                                ->required(),
                            Select::make('currency')
                                ->translateLabel()
                                ->options([
                                    'usd' => __('US Dollar'),
                                    "mxp" => __('Mexican peso'),
                                    "eur" => __('Euro'),
                                    "gbp" => __('Pound sterling')
                                ])
                                ->required()
                                ->default('usd')
                        ])->columns(3),

                        Section::make()->schema(
                            [
                                ToggleButtons::make('status')
                                    ->default('new')
                                    ->inline()
                                    ->translateLabel()
                                    ->options([
                                        'new' => __('New'),
                                        'processing' => __('Processing'),
                                        'shipped' => __('Shipped'),
                                        'delivered' => __('Delivered'),
                                        'cancelled' => __('Cancelled'),
                                    ])
                                    ->colors([
                                        'new' => 'info',
                                        'processing' => 'success',
                                        'shipped' => 'warning',
                                        'delivered' => 'success',
                                        'cancelled' => 'danger',
                                    ])
                                    ->icons([
                                        'new' => 'heroicon-m-sparkles',
                                        'processing' => 'heroicon-m-arrow-path',
                                        'shipped' => 'heroicon-m-truck',
                                        'delivered' => 'heroicon-m-check-badge',
                                        'cancelled' => 'heroicon-m-x-circle',
                                    ]),

                                Select::make('shipping_method')
                                    ->required()
                                    ->translateLabel()
                                    ->options([
                                        'fedex' => 'Fedex',
                                        'ups' => 'UPS',
                                        'dhl' => 'DHL',
                                        'usps' => 'USPS'
                                    ]),
                                    Textarea::make('notes')->translateLabel()->columnSpanFull(),

                            ],
                        )->columns(2),

                        Section::make('Order Items')->schema([
                            Repeater::make('items')
                                ->relationship()->schema([
                                    Select::make('product_id')
                                        ->translateLabel()
                                        ->relationship('product','name')
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->distinct()
                                        ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                        ->reactive()
                                        ->afterStateUpdated(fn($state,Set $set)=> $set('unit_amount',Product::find($state)->price ?? 0))
                                        ->afterStateUpdated(fn($state,Set $set)=> $set('total_amount',Product::find($state)->price ?? 0))
                                        ->columnSpan(4),
                                    TextInput::make('quantity')
                                        ->required()
                                        ->numeric()
                                        ->minValue(1)
                                        ->default(1)
                                        ->translateLabel()
                                        ->reactive()
                                        ->afterStateUpdated( fn($state,Set $set,Get $get) => $set('total_amount',round($state * $get('unit_amount'),2)))
                                        ->columnSpan(2),
                                    TextInput::make('unit_amount')
                                        ->required()
                                        ->disabled()
                                        ->translateLabel()
                                        ->dehydrated()
                                        ->columnSpan(3),
                                    TextInput::make('total_amount')
                                        ->required()
                                        ->disabled()
                                        ->dehydrated()
                                        ->translateLabel()
                                        ->columnSpan(3),
                                ])->columns(12),
                                Placeholder::make('grand_total_placeholder')
                                    ->label(__('Grand Total'))
                                    ->content(function(Get $get,Set $set){
                                        $total = 0;
                                        if(!$repeaters = $get('items')){
                                            return $total;
                                        }
                                        foreach($repeaters as $repeater){
                                            $total += $repeater['total_amount'];
                                        }
                                        $set('grand_total',$total);
                                        // return Number::currency($total,$get('currency'));
                                        return number_format($total,2);

                                    }),
                                Hidden::make('grand_total')
                                    ->default(0)
                                    ->dehydrated(),
                        ]),

                    ])
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])

            ]);
    }

    public static function getRelations(): array
    {
        return [
            AddressRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
