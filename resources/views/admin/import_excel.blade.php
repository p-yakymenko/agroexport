@extends('layouts.admin')
@section('content')
<div class="content mt-3">
	<div class="animated fadeIn">
		<div class="row">

			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<strong class="card-title">{{ $title }}</strong>
						<div>
						<strong class="card-title">Правила загрузки файлов:</strong>
						<p> Название файла - это название продукта для экспорта. Колонки в таблице должны быть заполнены в строгой последовательности: название предприятия | адрес | страна | телефон | e-mail | сайт | вид деятельности | контактное лицо. Сами названия колонок не имеют значения, главное - их содержание. Колонки "название предприятия | адрес | страна | телефон | e-mail" - обязательные к заполнению.</p>
					</div>
					</div>					
					<div class="card-body">
						{!! Form::open(['url'=>route('uploadFile'), 'class'=>'form-horizontal','method' => 'POST','enctype' => 'multipart/form-data']) !!}
						{!! Form::file('import_file') !!}
						{!! Form::button('Загрузить',['class'=>'btn btn-primary','type'=>'submit']) !!}
						{!! Form::close() !!}
					</div>
				</div>
			</div>

		</div>
	</div><!-- .animated -->
</div><!-- .content -->
@endsection