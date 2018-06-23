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
					<a class="btn btn-primary" href="{{ route('productShow') }}">Добавить</a>
					<div class="card-body">
						<table id="bootstrap-data-table" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Название</th>
									<th>Описание</th>
									<th>Изменить</th>
								</tr>
							</thead>
							<tbody>
								
								@if(isset($products) && is_object($products))
								@foreach($products as $k=>$product)
								
								<tr>
									<td>{{$product->name}}</td>
									<td>{{$product->description}}</td>
									<td>
										<a class="btn btn-primary" href="{{ url('/admin/product-categories/'.$product->id) }}">Изменить</a>
										{!! Form::open(['url'=>route('deleteProduct'),'onsubmit' => 'return ConfirmDelete()', 'class'=>'form-horizontal','method' => 'POST']) !!}
										{!! Form::hidden('action',$product->id) !!}
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
@endsection