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

						@if(isset($product))						

						{!! Form::open(['url'=>route('productUpdate',['id'=>$product->id]), 'class'=>'form-horizontal','method' => 'POST']) !!}

						<div class="form-group">
							{!! Form::label('name','Название',['class' => 'col-md-2 control-label'])   !!}
							<div class="col-md-8">
								{!! Form::text('name',$product->name,['class' => 'form-control'])!!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('description','Описание',['class' => 'col-md-2 control-label'])   !!}
							<div class="col-md-8">
								{!! Form::text('description',$product->description,['class' => 'form-control'])!!}
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