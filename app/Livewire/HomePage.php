<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use Livewire\Attributes\Title;
use Livewire\Component;

class HomePage extends Component
{
    public function render()
    {
        $brands = Brand::isActive()->get();
        $categories = Category::isActive()->get();

        return view('livewire.home.home-page',[
            'brands'    => $brands,
            'categories' => $categories
        ])->title(__('Home Page'));
    }
}
