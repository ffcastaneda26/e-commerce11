<?php

namespace App\Filament\Resources\BrandResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use App\Filament\Resources\BrandResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBrand extends CreateRecord
{
    protected static string $resource = BrandResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['name'] = ucfirst($data['name']);
        return $data;
    }
}
