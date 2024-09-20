<section class="py-20">
    <div class="max-w-xl mx-auto">
      <div class="text-center ">
        <div class="relative flex flex-col items-center">
          <h1 class="text-5xl font-bold dark:text-gray-200"> {{ __('Browse') }}<span class="text-blue-500"> {{ __('Brands') }}
            </span> </h1>
          <div class="flex w-40 mt-2 mb-6 overflow-hidden rounded">
            <div class="flex-1 h-2 bg-blue-200">
            </div>
            <div class="flex-1 h-2 bg-blue-400">
            </div>
            <div class="flex-1 h-2 bg-blue-600">
            </div>
          </div>
        </div>
        <p class="mb-12 text-base text-center text-gray-500">
            {{ __('See products from the most popular brands') }}
        </p>
      </div>
    </div>
    <div class="justify-center max-w-6xl px-4 py-4 mx-auto lg:py-0">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-4 md:grid-cols-2">
            @foreach($brands as $brand )
                <div class="bg-white rounded-lg shadow-md dark:bg-gray-800" wire:key={{ 'brand-'.$brand->id}}>
                    <a href="/products?selected_brands[0]={{$brand->id}}" class="">
                        <img src="{{ Storage::url($brand->image )}}" alt="{{ $brand->name }}" class="object-cover w-auto h-auto rounded-t-lg">
                    </a>
                    <div class="p-5 text-center">
                        <a href="" class="text-2xl font-bold tracking-tight text-gray-900 dark:text-gray-300">
                        {{ $brand->name }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
  </section>
