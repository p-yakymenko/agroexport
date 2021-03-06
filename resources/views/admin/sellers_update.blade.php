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

						{!! Form::open(['url'=>route('sellersUpdate',['object'=>$object, 'id'=>$seller->id]), 'class'=>'form-horizontal','method' => 'POST']) !!}

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
						@if($object != 'fermeri')
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
						@else
						<div class="form-group">
							{!! Form::label('region','Область',['class' => 'col-md-2 control-label'])   !!}
							<div class="col-md-8">
								{!! Form::text('region',$seller->region,['class' => 'form-control'])!!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('district','Район',['class' => 'col-md-2 control-label'])   !!}
							<div class="col-md-8">
								{!! Form::text('district',$seller->district,['class' => 'form-control'])!!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('edrpou','ЄДРПОУ',['class' => 'col-md-2 control-label'])   !!}
							<div class="col-md-8">
								{!! Form::text('edrpou',$seller->edrpou,['class' => 'form-control'])!!}
							</div>
						</div>
						<div class="form-group">
							<p>Продукция:</p>
							<div class="col-md-8">
								@if(!empty(json_decode($seller->products)))								
								
								@for ($i=0; $i < count($farm_product); $i++)
								@if(array_search($farm_product[$i], json_decode($seller->products)) !== false)
                                        <p>{!! Form::checkbox('farm_product[]', $farm_product[$i], true) !!}{{$farm_product[$i]}}</p>
                                @else
                                		<p>{!! Form::checkbox('farm_product[]', $farm_product[$i]) !!}{{$farm_product[$i]}}</p>
                                @endif		                                		         
                                @endfor	

                                @else
								@for ($i=0; $i < count($farm_product); $i++)
										<p>{!! Form::checkbox('farm_product[]', $farm_product[$i]) !!}{{$farm_product[$i]}}</p>
								@endfor
								@endif						
							</div>
						</div>
						@endif

						{!! Form::button('Сохранить',['class'=>'btn btn-primary','type'=>'submit']) !!}
						{!! Form::close() !!}
						@endif

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