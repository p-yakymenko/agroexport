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

						{!! Form::open(['url'=>route('sellersUpdate',['id'=>$seller->id]), 'class'=>'form-horizontal','method' => 'POST']) !!}

						<div class="form-group">
							{!! Form::label('name','Название',['class' => 'col-md-2 control-label'])   !!}
							<div class="col-md-8">
								{!! Form::text('name',$seller->name,['class' => 'form-control'])!!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('address','Адрес',['class' => 'col-md-2 control-label'])   !!}
							<div class="col-md-8">
								{!! Form::text('address',$seller->address,['class' => 'form-control'])!!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('country','Страна',['class' => 'col-md-2 control-label'])   !!}
							<div class="col-md-8">
								{!! Form::text('country',$seller->country,['class' => 'form-control'])!!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('phone','Телефон',['class' => 'col-md-2 control-label'])   !!}
							<div class="col-md-8">
								{!! Form::text('phone',$seller->phone,['class' => 'form-control'])!!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('email','E-mail',['class' => 'col-md-2 control-label'])   !!}
							<div class="col-md-8">
								{!! Form::text('email',$seller->email,['class' => 'form-control'])!!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('site','Сайт',['class' => 'col-md-2 control-label'])   !!}
							<div class="col-md-8">
								{!! Form::text('site',$seller->site,['class' => 'form-control'])!!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('activity_type','Тип деятельности',['class' => 'col-md-2 control-label'])   !!}
							<div class="col-md-8">
								{!! Form::text('activity_type',$seller->activity_type,['class' => 'form-control'])!!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('contact_person','Контактное лицо',['class' => 'col-md-2 control-label'])   !!}
							<div class="col-md-8">
								{!! Form::text('contact_person',$seller->contact_person,['class' => 'form-control'])!!}
							</div>
						</div>
						<div class="form-group">
							<p>Продукция:</p>
							<div class="col-md-8">
								@foreach ($products as $product)
								@if(array_search($product->name, $seller->arrayCatNames) !== false)
								<p>{!! Form::checkbox('arrayCatNames[]', $product->name, true) !!}{{$product->name}}</p>
								@else
								<p>{!! Form::checkbox('arrayCatNames[]', $product->name) !!}{{$product->name}}</p>
								@endif	
								@endforeach							
							</div>
						</div>

						{!! Form::button('Сохранить',['class'=>'btn btn-primary','type'=>'submit']) !!}
						{!! Form::close() !!}
						@endif
					</div>
				</div>
			</div>


		</div>
	</div><!-- .animated -->
</div><!-- .content -->
@endsection