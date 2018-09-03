<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="{{ asset('assets/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/cs-skin-elastic.css') }}">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
    <link rel="stylesheet" href="{{ asset('assets/scss/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/vector-map/jqvmap.min.css') }}">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

</head>
<body>
    @can('update-post')

    <!-- Left Panel -->

    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="/">Агроэкспорт</a>
                <a class="navbar-brand hidden" href="/">АЭ</a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="{{route('adminIndex')}}"> <i class="menu-icon fa fa-dashboard"></i>Панель управления </a>
                    </li>                 
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-user-circle"></i> Экспортёры </a>
                        <ul class="sub-menu children dropdown-menu">

                            @if(isset($products) && is_object($products))
                            @foreach($products as $product)
                            <li><a href="{{ url('/admin/sellers/'.Transliterate::make( 'Экспортёры', ['type' => 'url', 'lowercase' => true]).'/'.Transliterate::make($product->name, ['type' => 'url', 'lowercase' => true])) }}">{{$product->name}}</a></li>                                                 
                            @endforeach
                            @endif
                            <li>
                                <a href="{{ url('/admin/import-excel/'.Transliterate::make( 'Экспортёры', ['type' => 'url', 'lowercase' => true])) }}"> Импорт из Excel </a>
                            </li> 
                        </ul>
                    </li>
                    
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-user-circle"></i> Импортёры </a>
                        <ul class="sub-menu children dropdown-menu">

                            @if(isset($products) && is_object($products))
                            @foreach($products as $product)
                            <li><a href="{{ url('/admin/sellers/'.Transliterate::make( 'Импортёры', ['type' => 'url', 'lowercase' => true]).'/'.Transliterate::make($product->name, ['type' => 'url', 'lowercase' => true])) }}">{{$product->name}}</a></li>                                                 
                            @endforeach
                            @endif
                            <li>
                                <a href="{{ url('/admin/import-excel/'.Transliterate::make( 'Импортёры', ['type' => 'url', 'lowercase' => true])) }}"> Импорт из Excel </a>
                            </li> 
                        </ul>
                    </li>
                    
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-user-circle"></i> Фермеры </a>
                        <ul class="sub-menu children dropdown-menu">

                            @if(isset($products) && is_object($products))
                            @foreach($products as $product)
                            <li><a href="{{ url('/admin/sellers/'.Transliterate::make( 'Фермеры', ['type' => 'url', 'lowercase' => true]).'/'.Transliterate::make($product->name, ['type' => 'url', 'lowercase' => true])) }}">{{$product->name}}</a></li>                                                 
                            @endforeach
                            @endif
                            <li>
                                <a href="{{ url('/admin/import-excel/'.Transliterate::make( 'Фермеры', ['type' => 'url', 'lowercase' => true])) }}"> Импорт из Excel </a>
                            </li> 
                        </ul>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-user-circle"></i> Производители </a>
                        <ul class="sub-menu children dropdown-menu">

                            @if(isset($products) && is_object($products))
                            @foreach($products as $product)
                            <li><a href="{{ url('/admin/sellers/'.Transliterate::make( 'Производители', ['type' => 'url', 'lowercase' => true]).'/'.Transliterate::make($product->name, ['type' => 'url', 'lowercase' => true])) }}">{{$product->name}}</a></li>                                                 
                            @endforeach
                            @endif
                            <li>
                                <a href="{{ url('/admin/import-excel/'.Transliterate::make( 'Производители', ['type' => 'url', 'lowercase' => true])) }}"> Импорт из Excel </a>
                            </li> 
                        </ul>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-user-circle"></i> Элеваторы </a>
                        <ul class="sub-menu children dropdown-menu">

                            @if(isset($products) && is_object($products))
                            @foreach($products as $product)
                            <li><a href="{{ url('/admin/sellers/'.Transliterate::make( 'Элеваторы', ['type' => 'url', 'lowercase' => true]).'/'.Transliterate::make($product->name, ['type' => 'url', 'lowercase' => true])) }}">{{$product->name}}</a></li>                                                 
                            @endforeach
                            @endif
                            <li>
                                <a href="{{ url('/admin/import-excel/'.Transliterate::make( 'Элеваторы', ['type' => 'url', 'lowercase' => true])) }}"> Импорт из Excel </a>
                            </li> 
                        </ul>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-user-circle"></i> Перевозчики </a>
                        <ul class="sub-menu children dropdown-menu">

                            @if(isset($products) && is_object($products))
                            @foreach($products as $product)
                            <li><a href="{{ url('/admin/sellers/'.Transliterate::make( 'Перевозчики', ['type' => 'url', 'lowercase' => true]).'/'.Transliterate::make($product->name, ['type' => 'url', 'lowercase' => true])) }}">{{$product->name}}</a></li>                                                 
                            @endforeach
                            @endif
                            <li>
                                <a href="{{ url('/admin/import-excel/'.Transliterate::make( 'Перевозчики', ['type' => 'url', 'lowercase' => true])) }}"> Импорт из Excel </a>
                            </li> 
                        </ul>
                    </li>

                    <li>
                        <a href="{{route('adminCategories')}}"><i class="menu-icon fa fa-cubes"></i> Продукты </a>
                    </li>                                     
                    <li>
                        <a href="{{route('adminUsers')}}"><i class="menu-icon fa fa-address-card "></i> Пользователи </a>
                    </li>                   
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-10">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                </div>

                <div class="col-sm-2">
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Войти') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Зарегистрироваться') }}</a>
                        </li>
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Выйти') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endguest
                </ul>
            </div>

        </div>

    </header><!-- /header -->
    <!-- Header-->

    @yield('content')


</div><!-- /#right-panel -->

<!-- Right Panel -->

<script src="{{ asset('assets/js/vendor/jquery-2.1.4.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>


<script src="{{ asset('assets/js/lib/data-table/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/data-table/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/data-table/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/data-table/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/data-table/jszip.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/data-table/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/data-table/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/js/lib/data-table/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/data-table/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/data-table/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/data-table/datatables-init.js') }}"></script>


<script type="text/javascript">
    $(document).ready(function() {
      $('#bootstrap-data-table-export').DataTable();

      $('#bootstrap-data-table_wrapper > div:nth-child(3)').hide();
      $('#bootstrap-data-table_wrapper > div:nth-child(1) > div:nth-child(1)').hide();
      
      if ($('.dataTables_empty').text() == 'No data available in table') {
        $('.dataTables_empty').text('Нет данных');
    }

} );
</script>


@else
<h1>Вы не можете просматривать эту страницу!</h1>
@endcan
</body>
</html>

