@extends('layouts.admin')
@section('content')
<div class="content mt-3">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<strong class="card-title">{{ $title }}</strong>
					</div>
					<div class="card-body">

						@if(isset($seller))						
						<strong class="card-title">Название:</strong>
						<p>{{ $seller->name }}</p>
						<strong class="card-title">Адрес:</strong>
						<p>{{ $seller->address }}</p>
						<strong class="card-title">Страна:</strong>
						<p>{{ $seller->country }}</p>
						<strong class="card-title">Телефон:</strong>
						<p>{{ $seller->phone }}</p>
						<strong class="card-title">E-mail:</strong>
						<p>{{ $seller->email }}</p>
						<strong class="card-title">Сайт:</strong>
						<p>{{ $seller->site }}</p>
						<strong class="card-title">Тип деятельности:</strong>
						<p>{{ $seller->activity_type }}</p>
						<strong class="card-title">Контактное лицо:</strong>
						<p>{{ $seller->contact_person }}</p>
						<strong class="card-title">Продукция:</strong>
						@foreach ($products as $product)
						@if(array_search($product->name, $seller->arrayCatNames) !== false)
						<p>{{ $product->name }}</p>
						@endif
						@endforeach
						@endif					
					
					</div>
				</div>
			</div>
		</div>
	</div><!-- .animated -->
</div><!-- .content -->
@endsection