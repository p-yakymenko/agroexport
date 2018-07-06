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
						<p> Название файла - это название продукта для экспорта. Колонки в таблице должны быть заполнены в строгой последовательности: название предприятия | адрес | страна | телефон | e-mail | сайт | вид деятельности | контактное лицо. Сами названия колонок не имеют значения, главное - их содержание. Колонка "|название предприятия |" - обязательная к заполнению.</p>
					</div>
					</div>					
					<div class="card-body">
						{!! Form::open(['url'=>route('uploadFile'), 'class'=>'form-horizontal','method' => 'POST','enctype' => 'multipart/form-data']) !!}
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