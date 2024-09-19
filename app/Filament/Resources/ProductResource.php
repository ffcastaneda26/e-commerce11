<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $activeNavigationIcon = 'heroicon-s-shield-check';
    protected static ?int $navigationSort = 3;
    public static function getNavigationLabel(): string
    {
        return __('Products');
    }
    public static function getPluralLabel(): ?string
    {
        return __('Products');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function getModelLabel(): string
    {
        return __('Product');
    }

    public static function getNavigationGroup(): string
    {
        return __('Catalogs');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                        Section::make(__('Product Info'))->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->translateLabel()
                                    ->maxLength(100)
                                    ->unique(Product::class, 'name', ignoreRecord: true)
                                    ->unique(ignoreRecord: true)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn($operation, Set $set, ?string $state) => $set('slug', $operation === 'create' ? Str::slug($state) : null)),
                                TextInput::make('slug')
                                    ->translateLabel()
                                    ->maxLength(255)
                                    ->disabled()
                                    ->dehydrated()
                                    ->unique(Product::class, 'slug', ignoreRecord: true)
                                    ->readonly(true),
                                MarkdownEditor::make('description')
                                    ->translateLabel()
                                    ->columnSpanFull()
                                    ->fileAttachmentsDirectory('products')

                            ])->columns(2),
                        Section::make(__('Images'))->schema([
                            FileUpload::make('images')
                                ->multiple()
                                ->directory('products')
                                ->maxFiles(5)
                                ->reorderable()
                        ])
                    ])->columnSpan(2),
                Group::make()->schema([
                    Section::make(__('Price'))->schema([
                        TextInput::make('price')
                            ->numeric()
                            ->required()
                            ->translateLabel()
                            ->prefix('USD')
                    ]),
                    Section::make(heading: __('Assosiations'))->schema([
                        Select::make('category_id')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->translateLabel()
                            ->relationship('category','name'),
                        Select::make('brand_id')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->translateLabel()
                            ->relationship('brand','name')
                    ]),

                    Section::make(__('Status'))->schema([
                        Toggle::make('in_stock')
                            ->translateLabel()
                            ->inline()
                            ->default(true),
                        Toggle::make('is_active')
                            ->translateLabel()
                            ->inline()
                            ->default(state: true),
                        Toggle::make('is_featured')
                            ->translateLabel()
                            ->inline()
                            ->default(false),
                        Toggle::make('on_sale')
                            ->translateLabel()
                            ->inline()
                            ->default(false),

                    ])
                ])->columnSpan(1)
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable()->translateLabel(),
                TextColumn::make('category.name')->searchable()->sortable()->translateLabel(),
                TextColumn::make('brand.name')->searchable()->sortable()->translateLabel(),
                TextColumn::make('price')->searchable()->sortable()->translateLabel()->money('USD'),
                TextColumn::make('price')->searchable()->sortable()->translateLabel()
                    ->alignment(Alignment::End)
                    ->numeric(decimalPlaces: 2, decimalSeparator: '.' , thousandsSeparator: ','),
                ToggleColumn::make('in_stock')->translateLabel()->alignCenter()->toggleable(isToggledHiddenByDefault: false),
                ToggleColumn::make('is_featured')->translateLabel()->toggleable(isToggledHiddenByDefault: false),
                ToggleColumn::make('on_sale')->translateLabel()->toggleable(isToggledHiddenByDefault: false),
                ToggleColumn::make('is_active')->translateLabel()->toggleable(isToggledHiddenByDefault: false),

                // IconColumn::make('in_stock')->translateLabel()->boolean()->alignCenter(),
                // IconColumn::make('is_featured')->translateLabel()->boolean()->alignCenter()->toggleable(isToggledHiddenByDefault: false),
                // IconColumn::make('on_sale')->translateLabel()->boolean()->alignCenter()->toggleable(isToggledHiddenByDefault: false),
                // IconColumn::make('is_active')->translateLabel()->boolean()->alignCenter(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d-M-Y')
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d-M-Y')
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->relationship('category','name')
                    ->searchable()
                    ->translateLabel()
                    ->preload(),
                SelectFilter::make('brand')
                    ->relationship('brand','name')
                    ->searchable()
                    ->translateLabel()
                    ->preload(),

                TernaryFilter::make('is_active')
                    ->translateLabel()
                    ->placeholder(__('Active'))
                    ->trueLabel(__('Yes'))
                    ->falseLabel(__('No')),
                TernaryFilter::make('on_sale')
                    ->translateLabel()
                    ->placeholder(__('On Sale'))
                    ->trueLabel(__('Yes'))
                    ->falseLabel(__('No')),
                TernaryFilter::make('is_featured')
                    ->translateLabel()
                    ->placeholder(__('Is featured'))
                    ->trueLabel(__('Yes'))
                    ->falseLabel(__('No'))
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug', 'brand.name', 'category.name'];
    }

    
}
