<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\RelationManagers\OrdersRelationManager;
use Filament\Forms;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;
use Filament\Actions\ActionGroup;
use Filament\Pages\Page;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 1;
    public static function getGloballySearchableAttributes(): array
    {
            return ['name', 'email'];
    }
    // protected static ?string $cluster = Security::class;
    public static function getNavigationLabel(): string
    {
        return __('Users');
    }


    public static function getModelLabel(): string
    {
        return __('User');
    }


    public static function getPluralLabel(): ?string
    {
        return __('Users');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function getNavigationGroup(): string
    {
        return __('Security');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                        ->required()
                        ->translateLabel(),
                Forms\Components\TextInput::make('email')->email()
                        ->required()
                        ->email()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->translateLabel(),
                Forms\Components\DateTimePicker::make('email_verified_at')
                    // ->default(now())
                    ->translateLabel(),
                Forms\Components\TextInput::make('password')
                            ->password()
                            ->revealable()
                            // ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->translateLabel()->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->translateLabel()->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email_verified_at')->dateTime()->translateLabel()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->translateLabel()->sortable(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->translateLabel()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
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
            OrdersRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
