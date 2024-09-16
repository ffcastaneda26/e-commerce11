<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Brand;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BrandResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BrandResource\RelationManagers;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-wallet';
    protected static ?string $activeNavigationIcon = 'heroicon-s-shield-check';
    protected static ?int $navigationSort = 2;


    public static function getNavigationLabel(): string
    {
        return __('Brands');
    }


    public static function getModelLabel(): string
    {
        return __('Brand');
    }


    public static function getPluralLabel(): ?string
    {
        return __('Brands');
    }
    public static function getNavigationGroup(): string
    {
        return __('Catalogs');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() == 0 ? 'danger' : 'success';
    }
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make([
                Grid::make()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->translateLabel()
                            ->maxLength(100)
                            ->unique(Brand::class, 'name', ignoreRecord: true)
                            ->unique(ignoreRecord: true)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($operation, Set $set, ?string $state) => $set('slug', $operation === 'create' ? Str::slug($state) : null)),
                        TextInput::make('slug')
                            ->translateLabel()
                            ->maxLength(255)
                            ->disabled()
                            ->dehydrated()
                            ->unique(Brand::class, 'slug', ignoreRecord: true)
                            ->readonly(true),
                    ]),
                Grid::make()
                    ->schema([
                        FileUpload::make('image')
                            ->translateLabel()
                            ->directory('categories')
                            ->preserveFilenames()
                            ->image(),
                        Toggle::make('is_active')->required(),
                    ])

            ]),


        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('image'),

                IconColumn::make('is_active')
                    ->translateLabel()
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->translateLabel(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->translateLabel()

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}
