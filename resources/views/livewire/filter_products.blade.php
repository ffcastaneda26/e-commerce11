<div class="w-full pr-2 lg:w-1/4 lg:block">
    {{-- Filtros Categorías --}}
    <div class="p-4 mb-5 bg-white border border-gray-200 dark:border-gray-900 dark:bg-gray-900">
        <h2 class="text-2xl font-bold dark:text-gray-400"> {{ __('Categories') }}</h2>
        <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
        <ul>
            @foreach ($categories as $category )
                <li wire:key={{ 'category-'.$category->id}} class="mb-4">
                    <label for="{{ $category->slug }}" class="flex items-center dark:text-gray-400 ">
                        <input type="checkbox" wire:model.live="selected_categories"  id="{{ $category->slug }}" value="{{ $category->id }}" class="w-4 h-4 mr-2">
                        <span class="text-lg">{{ $category->name }}</span>
                    </label>
                    </li>
            @endforeach
        </ul>
    </div>

    {{-- Filtros Marcas --}}
    <div class="p-4 mb-5 bg-white border border-gray-200 dark:bg-gray-900 dark:border-gray-900">
        <h2 class="text-2xl font-bold dark:text-gray-400">{{ __('Brand') }}</h2>
        <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
        <ul>
            @foreach ($brands as $brand )
                <li wire:key={{ 'brand-'.$brand->id}} class="mb-4">
                    <label for="{{ $brand->slug }}" class="flex items-center dark:text-gray-300">
                        <input type="checkbox"  wire:model.live="selected_brands" id="{{ $brand->slug }}" value="{{ $brand->id}}" class="w-4 h-4 mr-2">
                        <span class="text-lg dark:text-gray-400">{{ $brand->name }}</span>
                    </label>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Filtro por Estado del Producto --}}
    <div class="p-4 mb-5 bg-white border border-gray-200 dark:bg-gray-900 dark:border-gray-900">
        <h2 class="text-2xl font-bold dark:text-gray-400">{{ __('Product Status') }}</h2>
        <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
        <ul>
            <li class="mb-4">
            <label for="featured" class="flex items-center dark:text-gray-300">
                <input type="checkbox" id="featured" wire:model.live="featured" value="1" class="w-4 h-4 mr-2">
                <span class="text-lg dark:text-gray-400">{{ __('Featured Products') }}</span>
            </label>
            </li>
            <li class="mb-4">
            <label for="on_sale" class="flex items-center dark:text-gray-300">
                <input type="checkbox" id="on_sale" wire:model.live="on_sale" class="w-4 h-4 mr-2">
                <span class="text-lg dark:text-gray-400">{{__('On Sale')}}</span>
            </label>
            </li>
        </ul>
    </div>

    {{-- Filtro rango de precio --}}

    <div class="p-4 mb-5 bg-white border border-gray-200 dark:bg-gray-900 dark:border-gray-900">
        <h2 class="text-2xl font-bold dark:text-gray-400">{{ __('Max Price') }}</h2>
        <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
        <div>
            <div class="font-semibold text-center">
                ${{ number_format($price_range, 2, '.', ',') }}
            </div>
            <input type="range" class="w-full h-1 mb-4 bg-blue-100 rounded appearance-none cursor-pointer"
                max="{{ $max_price }}"
                value="{{ $max_price }}"
                step="{{ $step_price }}"
                wire:model.live="price_range">
            <div class="flex justify-between ">
            <span class="inline-block text-lg font-bold text-blue-400 ">${{ number_format($min_price, 2, '.', ',') }}</span>
            <span class="inline-block text-lg font-bold text-blue-400 ">${{ number_format($max_price, 2, '.', ',') }}</span>
            </div>
        </div>
    </div>
</div>
