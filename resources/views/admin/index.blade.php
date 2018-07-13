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
                    @if(Session::has('message'))
                    <h3>{{Session::get('message')}}</h3>
                    @endif                                      
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

                               @if(isset($exporters) && is_object($exporters))
                               @foreach($exporters as $k=>$seller)

                               <tr>
                                <td>                                   
                                    <a title="Подробнее" href="{{ url('/admin/seller/'.$objects[0].'/'.$seller->id) }}" style="color: blue;">{{$seller->name}}</a>
                                    <p>{{$seller->address}}</p>
                                    <p>{{$seller->country}}</p>
                                    <h6>Экспортёр</h6>
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
                                    <a class="btn btn-primary" href="{{ url('/admin/seller-update/'.$objects[0].'/'.$seller->id) }}">Изменить</a>
                                    {!! Form::open(['url'=>route('deleteSeller',['object'=>$objects[0]]),'onsubmit' => 'return ConfirmDelete()', 'class'=>'form-horizontal','method' => 'POST']) !!}
                                    {!! Form::hidden('action',$seller->id) !!}
                                    {!! Form::button('Удалить',['class'=>'btn btn-danger','type'=>'submit']) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>

                            @endforeach
                            @endif

                            @if(isset($importers) && is_object($importers))
                               @foreach($importers as $k=>$seller)

                               <tr>
                                <td>                                    
                                    <a title="Подробнее" href="{{ url('/admin/seller/'.$objects[1].'/'.$seller->id) }}" style="color: blue;">{{$seller->name}}</a>
                                    <p>{{$seller->address}}</p>
                                    <p>{{$seller->country}}</p>
                                    <h6>Импортёр</h6>
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
                                    <a class="btn btn-primary" href="{{ url('/admin/seller-update/'.$objects[1].'/'.$seller->id) }}">Изменить</a>
                                    {!! Form::open(['url'=>route('deleteSeller',['object'=>$objects[1]]),'onsubmit' => 'return ConfirmDelete()', 'class'=>'form-horizontal','method' => 'POST']) !!}
                                    {!! Form::hidden('action',$seller->id) !!}
                                    {!! Form::button('Удалить',['class'=>'btn btn-danger','type'=>'submit']) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>

                            @endforeach
                            @endif

                            @if(isset($farms) && is_object($farms))
                               @foreach($farms as $k=>$seller)

                               <tr>
                                <td>                                   
                                    <a title="Подробнее" href="{{ url('/admin/seller/'.$objects[2].'/'.$seller->id) }}" style="color: blue;">{{$seller->name}}</a>
                                    <p>{{$seller->address}}</p>
                                    <p>{{$seller->country}}</p>
                                    <h6>Фермер</h6>
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
                                    <a class="btn btn-primary" href="{{ url('/admin/seller-update/'.$objects[2].'/'.$seller->id) }}">Изменить</a>
                                    {!! Form::open(['url'=>route('deleteSeller',['object'=>$objects[2]]),'onsubmit' => 'return ConfirmDelete()', 'class'=>'form-horizontal','method' => 'POST']) !!}
                                    {!! Form::hidden('action',$seller->id) !!}
                                    {!! Form::button('Удалить',['class'=>'btn btn-danger','type'=>'submit']) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>

                            @endforeach
                            @endif

                            @if(isset($manufacturers) && is_object($manufacturers))
                               @foreach($manufacturers as $k=>$seller)

                               <tr>
                                <td>                                   
                                    <a title="Подробнее" href="{{ url('/admin/seller/'.$objects[3].'/'.$seller->id) }}" style="color: blue;">{{$seller->name}}</a>
                                    <p>{{$seller->address}}</p>
                                    <p>{{$seller->country}}</p>
                                    <h6>Производитель</h6>
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
                                    <a class="btn btn-primary" href="{{ url('/admin/seller-update/'.$objects[3].'/'.$seller->id) }}">Изменить</a>
                                    {!! Form::open(['url'=>route('deleteSeller',['object'=>$objects[3]]),'onsubmit' => 'return ConfirmDelete()', 'class'=>'form-horizontal','method' => 'POST']) !!}
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

@endsection