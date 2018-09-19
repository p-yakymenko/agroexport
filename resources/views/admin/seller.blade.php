@extends('layouts.admin')
@section('content')
<div class="breadcrumbs">
	<div class="col-sm-4">
		<div class="page-header float-left">
			<div class="page-title">
				<h1>Панель управления</h1>
			</div>
		</div>
	</div>
	<div class="col-sm-8">
		<div class="page-header float-right">
			<div class="page-title">
				<ol class="breadcrumb text-right">
					<li><a href="{{route('adminIndex')}}">Панель управления</a></li>
					<li class="active">{{ $title }}</li>
				</ol>                        
			</div>
		</div>
	</div>
</div>
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
						@if($object != 'fermeri')
						<strong class="card-title">Продукция:</strong>
						@foreach ($products as $product)
						@if(array_search($product->name, $seller->arrayCatNames) !== false)
						<p>{{ $product->name }}</p>
                        @endif
						@endforeach
						@else
						<strong class="card-title">Область:</strong>
						<p>{{ $seller->region }}</p>
						<strong class="card-title">Район:</strong>
						<p>{{ $seller->district }}</p>
						<strong class="card-title">Продукция:</strong>
						@for ($i=0; $i < count(json_decode($seller->products)); $i++)
						<p>{{json_decode($seller->products)[$i]}}</p>               
                        @endfor
                        @endif
						@endif						
						
											
					
					</div>
				</div>
			</div>
		</div>
	</div><!-- .animated -->
</div><!-- .content -->
@endsection