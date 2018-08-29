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
					@if(Session::has('message'))
					<h3>{{Session::get('message')}}</h3>
					@endif
					<a class="btn btn-primary" href="{{ route('showAdd',['object'=>$object]) }}">Добавить</a>
					<div class="card-body">
						<table id="bootstrap-data-table" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Название, Адрес, Страна</th>
									<th>Телефон</th>
									<th>E-mail</th>
									<th>Сайт</th>
									<th>Продукция</th>
									<th>Изменить</th>
								</tr>
							</thead>
							<tbody>
								
								@if(isset($sellers))
								@foreach($sellers as $k=>$seller)

								<tr>
									<td><a title="Подробнее" href="{{ url('/admin/seller/'.$object.'/'.$seller->id) }}" style="color: blue;">{{$seller->name}}</a>
										<p>{{$seller->address}}</p>
										<p>{{$seller->country}}</p>
									</td>
									<td>{{$seller->phone}}</td>
									<td>{{$seller->email}}</td>
									<td>{{$seller->site}}</td> 
									<td>
										@for($i=0; $i < count($seller->arrayCatNames); $i++)
										<p>{{$seller->arrayCatNames[$i]}}</p>
										@endfor
									</td>
									<td>
										<a class="btn btn-primary" href="{{ url('/admin/seller-update/'.$object.'/'.$seller->id) }}">Изменить</a>
										{!! Form::open(['url'=>route('deleteSeller',['object'=>$object]),'onsubmit' => 'return ConfirmDelete()', 'class'=>'form-horizontal','method' => 'POST']) !!}
										{!! Form::hidden('action',$seller->id) !!}
										{!! Form::button('Удалить',['class'=>'btn btn-danger','type'=>'submit']) !!}
										{!! Form::close() !!}
									</td>
								</tr>

								@endforeach
								@endif
							</tbody>
						</table>
						{{ $sellers->links() }}
					</div>
				</div>
			</div>


		</div>
	</div><!-- .animated -->
</div><!-- .content -->

<script>

	function ConfirmDelete()
	{
		var x = confirm("Вы уверены, что хотите удалить?");
		if (x)
			return true;
		else
			return false;
	}

</script>