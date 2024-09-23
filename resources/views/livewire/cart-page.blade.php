<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-semibold mb-4">{{ __('Shopping Cart') }}</h1>
        <div class="flex flex-col md:flex-row gap-4">
        <div class="md:w-3/4">
            <div class="bg-white overflow-x-auto rounded-lg shadow-md p-6 mb-4">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th class="text-left font-semibold">{{ __('Product') }}</th>
                            <th class="text-left font-semibold">{{ __('Price') }}</th>
                            <th class="text-left font-semibold">{{ __('Quantity') }}</th>
                            <th class="text-left font-semibold">{{ __('Total') }}</th>
                            <th class="text-left font-semibold">{{ __('Remove') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cart_items as $item )
                            <tr wire:key='{{ $item['product_id'] }}'>
                                <td class="py-4">
                                <div class="flex items-center">
                                    <img class="h-16 w-16 mr-4" src="{{ $item['image'] ? Storage::url($item['image']) : asset('images/any_product.png')}}" alt="{{ $item['name'] }}">
                                    <span class="font-semibold">{{ $item['name'] }}</span>
                                </div>
                                </td>
                                <td class="py-4">${{ number_format($item['unit_amount'], 2, '.', ',') }}</td>
                                <td class="py-4">
                                <div class="flex items-center">
                                    <button wire:click="decreaseQty({{ $item['product_id'] }})"  class="border rounded-md py-2 px-4 mr-2">-</button>
                                    <span class="text-center w-8">{{ $item['quantity'] }}</span>
                                    <button wire:click="increaseQty({{ $item['product_id'] }})" class="border rounded-md py-2 px-4 ml-2">+</button>
                                </div>
                                </td>
                                <td class="py-4"><td class="py-4">${{ number_format($item['total_amount'], 2, '.', ',') }}</td>
                                <td>
                                    <button wire:click="removeItem({{ $item['product_id'] }})" class="bg-slate-300 border-2 border-slate-400 rounded-lg px-3 py-1 hover:bg-red-500 hover:text-white hover:border-red-700">
                                        <span wire:loading.remove wire:target='removeItem({{ $item['product_id'] }})'> {{ __('Remove') }}</span>
                                        <span wire:loading
                                              wire.loading.class="text-xs"
                                              wire:target='removeItem({{ $item['product_id'] }})'>{{ __('Removing...') }}</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-4xl text-red-500 font-semibold"> {{ __('No products in the cart') }}</td>
                            </tr>
                        @endforelse

                    <!-- More product rows -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="md:w-1/4">
            <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">{{ __('Summary') }}</h2>
            <div class="flex justify-between mb-2">
                <span>Subtotal</span>
                <span>${{ number_format($grand_total, 2, '.', ',') }}</span>
            </div>
            <div class="flex justify-between mb-2">
                <span>{{ __('Taxes') }}</span>
                <span>${{ number_format($taxes, 2, '.', ',') }}</span>
            </div>
            <div class="flex justify-between mb-2">
                <span>{{ __('Shipping') }}</span>
                <span>${{ number_format($shipping, 2, '.', ',') }}</span>
            </div>
            <hr class="my-2">
            <div class="flex justify-between mb-2">
                <span class="font-semibold">Total</span>
                <span class="font-bold underline border-b-2">${{ number_format($total_to_pay, 2, '.', ',') }}</span>
            </div>
                @if($cart_items)
                    <a href="{{ route('checkout') }}" class="block text-center bg-blue-500 text-white py-2 px-4 rounded-lg mt-4 w-full">{{ __('Checkout') }}</a>
                @endif
            </div>
        </div>
        </div>
    </div>
  </div>
