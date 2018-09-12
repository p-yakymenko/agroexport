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
						<div>
						<strong class="card-title">Правила загрузки файлов:</strong>
						<p> Колонки в таблице должны быть заполнены в строгой последовательности: название предприятия | адрес | страна | телефон | e-mail | сайт | вид деятельности | контактное лицо. Сами названия колонок не имеют значения, главное - их содержание. Колонка "|название предприятия |" - обязательная к заполнению. Минимальное кол-во колонок - 8.</p>
					</div>
					</div>					
					<div class="card-body">
						{!! Form::open(['url'=>route('uploadExcel',['object'=>$object]), 'class'=>'form-horizontal','method' => 'POST','enctype' => 'multipart/form-data']) !!}
						<div class="form-group">
							<div class="col-md-4">
								{!! Form::text('product_name',old('product_name'),['class' => 'form-control', 'placeholder'=>'Название продукта', 'required'])!!}
							</div>
						</div>						
						{!! Form::file('import_file') !!}
						{!! Form::button('Загрузить',['class'=>'btn btn-primary','type'=>'submit']) !!}
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