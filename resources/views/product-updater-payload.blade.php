<?xml version="1.0" encoding="UTF-8" ?>
<Request>
	@foreach ($products as $product)
	<Product>
		<SellerSku>{{ $product->sku }}</SellerSku>
		<Price>{{ $product->price }}</Price>
		<Quantity>{{ $product->stock }}</Quantity>
		@if ($product->sale_price < $product->price)
		<SalePrice>{{ $product->sale_price }}</SalePrice>
		<SaleStartDate>{{ now()->toIso8601String() }}</SaleStartDate>
		<SaleEndDate>{{ now()->addDays($product->sale_duration)->toIso8601String() }}</SaleEndDate>
		@else
		<SalePrice></SalePrice>
		<SaleStartDate></SaleStartDate>
		<SaleEndDate></SaleEndDate>
		@endif 
	</Product>
	@endforeach
</Request>