<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Models\Address;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use phpDocumentor\Reflection\PseudoTypes\False_;

class AddressRelationManager extends RelationManager
{
    protected static string $relationship = 'address';
    // protected static bool $canCreateAnother = false;
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name')->translateLabel()->required(),
                TextInput::make('last_name')->translateLabel()->required(),
                TextInput::make('phone')->translateLabel()->required()->tel()->maxLength(15),

                TextInput::make('city')->translateLabel()->required(),
                TextInput::make('state')->translateLabel()->required(),
                TextInput::make('country')->translateLabel()->required(),
                TextInput::make('zip_code')
                    ->translateLabel()
                    ->required()
                    ->minLength(5)
                    ->maxLength(5)
                    ->numeric(),
                Textarea::make('street_address')->translateLabel()->required()->columnSpanFull(),
            ]);
    }

    // protected function canCreate(): bool { return true; }

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('Addresses'))
            ->recordTitleAttribute(__('Address'))
            ->columns([
                Tables\Columns\TextColumn::make('fullname')->translateLabel(),
                Tables\Columns\TextColumn::make('phone')->translateLabel(),
                Tables\Columns\TextColumn::make('street_address')->translateLabel(),
                Tables\Columns\TextColumn::make('city')->translateLabel(),
                Tables\Columns\TextColumn::make('state')->translateLabel(),
                Tables\Columns\TextColumn::make('country')->translateLabel(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->hidden(fn (RelationManager $livewire) => $livewire->getRelationship()->exists()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

}
