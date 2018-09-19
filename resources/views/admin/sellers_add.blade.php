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

						{!! Form::open(['url'=>route('sellersAdd',['object'=>$object]), 'class'=>'form-horizontal','method' => 'POST']) !!}

						<div class="form-group">
							{!! Form::label('name','Название',['class' => 'col-md-2 control-label'])   !!}
							<div class="col-md-8">
								{!! Form::text('name',old('name'),['class' => 'form-control'])!!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('address','Адрес',['class' => 'col-md-2 control-label'])   !!}
							<div class="col-md-8">
								{!! Form::text('address',old('address'),['class' => 'form-control'])!!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('country','Страна',['class' => 'col-md-2 control-label'])   !!}
							<div class="col-md-8">
								{!! Form::text('country',old('country'),['class' => 'form-control'])!!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('phone','Телефон',['class' => 'col-md-2 control-label'])   !!}
							<div class="col-md-8">
								{!! Form::text('phone',old('phone'),['class' => 'form-control'])!!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('email','E-mail',['class' => 'col-md-2 control-label'])   !!}
							<div class="col-md-8">
								{!! Form::text('email',old('email'),['class' => 'form-control'])!!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('site','Сайт',['class' => 'col-md-2 control-label'])   !!}
							<div class="col-md-8">
								{!! Form::text('site',old('site'),['class' => 'form-control'])!!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('activity_type','Тип деятельности',['class' => 'col-md-2 control-label'])   !!}
							<div class="col-md-8">
								{!! Form::text('activity_type',old('activity_type'),['class' => 'form-control'])!!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('contact_person','Контактное лицо',['class' => 'col-md-2 control-label'])   !!}
							<div class="col-md-8">
								{!! Form::text('contact_person',old('contact_person'),['class' => 'form-control'])!!}
							</div>
						</div>
						@if($object != 'fermeri')
						<div class="form-group">
							<p>Продукция:</p>
							<div class="col-md-8">
								@foreach ($products as $product)								
								<p>{!! Form::checkbox('arrayCatNames[]', $product->name) !!}{{$product->name}}</p>	
								@endforeach							
							</div>
						</div>
						@else
						<div class="form-group">
							{!! Form::label('region','Область',['class' => 'col-md-2 control-label'])   !!}
							<div class="col-md-8">
								{!! Form::text('region',old('region'),['class' => 'form-control'])!!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('district','Район',['class' => 'col-md-2 control-label'])   !!}
							<div class="col-md-8">
								{!! Form::text('district',old('district'),['class' => 'form-control'])!!}
							</div>
						</div>
						<div class="form-group">
							<p>Продукция:</p>
							<div class="col-md-8">
								@for ($i=0; $i < count($farm_product); $i++)
                                        <p>{!! Form::checkbox('farm_product[]', $farm_product[$i]) !!}{{$farm_product[$i]}}</p> 
                                @endfor							
							</div>
						</div>
						@endif

						{!! Form::button('Сохранить',['class'=>'btn btn-primary','type'=>'submit']) !!}
						{!! Form::close() !!}

						@if(isset($message))
						<h3>{{$message}}</h3>
						@endif
					</div>
				</div>
			</div>


		</div>
	</div><!-- .animated -->
</div><!-- .content -->
@endsection