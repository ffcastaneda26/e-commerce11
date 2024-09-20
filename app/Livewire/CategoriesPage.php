<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategoriesPage extends Component
{

    public function render()
    {   $categories = Category::isActive()->get();
        return view('livewire.categories-page',[
            'categories' => $categories
        ])->title(__('Categories'));
    }
}
