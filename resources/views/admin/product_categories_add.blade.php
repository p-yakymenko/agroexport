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

						{!! Form::open(['url'=>route('productAdd'), 'class'=>'form-horizontal','method' => 'POST']) !!}

						<div class="form-group">
							{!! Form::label('name','Название',['class' => 'col-md-2 control-label'])   !!}
							<div class="col-md-8">
								{!! Form::text('name',old('name'),['class' => 'form-control'])!!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('category_id','Категория',['class' => 'col-md-2 control-label'])  !!}
							<div class="col-md-8">
								{!! Form::select('category_id', $categories, '', ['class' => 'form-control']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('description','Описание',['class' => 'col-md-2 control-label'])   !!}
							<div class="col-md-8">
								{!! Form::text('description',old('description'),['class' => 'form-control'])!!}
							</div>
						</div>

						{!! Form::button('Сохранить',['class'=>'btn btn-primary','type'=>'submit']) !!}
						{!! Form::close() !!}

					</div>
				</div>
			</div>


		</div>
	</div><!-- .animated -->
</div><!-- .content -->
@endsection