<div class="content mt-3">
	<div class="animated fadeIn">
		<div class="row">

			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<strong class="card-title">{{ $title }}</strong>
					</div>
					<a class="btn btn-primary" href="{{ route('showAdd') }}">Добавить</a>
					<div class="card-body">
						<table id="bootstrap-data-table" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Название</th>
									<th>Адрес</th>
									<th>Страна</th>
									<!-- <th>Телефон</th>
									<th>E-mail</th>
									<th>Сайт</th> -->
									<th>Тип деятельности</th>
									<th>Продукция</th>
									<!-- <th>Контактное лицо</th> -->
									<th>Изменить</th>
								</tr>
							</thead>
							<tbody>
								
								@if(isset($sellers) && is_object($sellers))
								@foreach($sellers as $k=>$seller)
								
								<tr>
									<td><a title="Подробнее" href="{{ url('/admin/seller/'.$seller->id) }}">{{$seller->name}}</a></td>
									<td>{{$seller->address}}</td>
									<td>{{$seller->country}}</td>
                                    <!-- <td>{{$seller->phone}}</td>
                                    <td>{{$seller->email}}</td>
                                    <td>{{$seller->site}}</td> -->
									<td>{{$seller->activity_type}}</td>
									<td>
										@for($i=0; $i < count($seller->arrayCatNames); $i++)
										<p>{{$seller->arrayCatNames[$i]}}</p>
										@endfor
									</td>
									<!-- <td>{{$seller->contact_person}}</td> -->
									<td>
										<a class="btn btn-primary" href="{{ url('/admin/sellers/'.$seller->id) }}">Изменить</a>
										{!! Form::open(['url'=>route('deleteSeller'),'onsubmit' => 'return ConfirmDelete()', 'class'=>'form-horizontal','method' => 'POST']) !!}
										{!! Form::hidden('action',$seller->id) !!}
										{!! Form::button('Удалить',['class'=>'btn btn-danger','type'=>'submit']) !!}
										{!! Form::close() !!}
									</td>
								</tr>

								@endforeach
								@endif
							</tbody>
						</table>
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