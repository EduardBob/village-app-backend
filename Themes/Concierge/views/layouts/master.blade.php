<!DOCTYPE html>
<!--[if IE 7]>    <html class="no-js ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->
<head lang="{{ LaravelLocalization::setLocale() }}">
    <meta charset="UTF-8">
    @section('meta')
        <meta name="description" content="{{ Setting::get('core::site-description') }}" />
    @show
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>
        @section('title'){{ Setting::get('core::site-name') }}@show
    </title>
    <link rel="apple-touch-icon" sizes="57x57" href="{!! Theme::url('images/favicon/apple-touch-icon-57x57.png') !!}" />
    <link rel="apple-touch-icon" sizes="60x60" href="{!! Theme::url('images/favicon/apple-touch-icon-60x60.png') !!}" />
    <link rel="apple-touch-icon" sizes="72x72" href="{!! Theme::url('images/favicon/apple-touch-icon-72x72.png') !!}" />
    <link rel="apple-touch-icon" sizes="76x76" href="{!! Theme::url('images/favicon/apple-touch-icon-76x76.png') !!}" />
    <link rel="apple-touch-icon" sizes="114x114" href="{!! Theme::url('images/favicon/apple-touch-icon-114x114.png') !!}" />
    <link rel="apple-touch-icon" sizes="120x120" href="{!! Theme::url('images/favicon/apple-touch-icon-120x120.png') !!}" />
    <link rel="apple-touch-icon" sizes="144x144" href="{!! Theme::url('images/favicon/apple-touch-icon-144x144.png') !!}" />
    <link rel="apple-touch-icon" sizes="152x152" href="{!! Theme::url('images/favicon/apple-touch-icon-152x152.png') !!}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{!! Theme::url('images/favicon/apple-touch-icon-180x180.png') !!}" />
    <link rel="icon" type="image/png" sizes="192x192" href="{!! Theme::url('images/favicon/android-icon-192x192.png') !!}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{!! Theme::url('images/favicon/favicon-32x32.png') !!}" />
    <link rel="icon" type="image/png" sizes="96x96" href="{!! Theme::url('images/favicon/favicon-96x96.png') !!}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{!! Theme::url('images/favicon/favicon-16x16.png?v=4') !!}" />
    <link rel="icon" href="{!! Theme::url('images/favicon/favicon.ico?v=4') !!}" />
    <link rel="manifest" href="{!! Theme::url('images/favicon/manifest.json') !!}" />
    <!-- Styles -->
    {!! Theme::style('css/chosen.min.css') !!}
    {!! Theme::style('css/owl.carousel.css') !!}
    {!! Theme::style('css/owl.theme.css') !!}
    {!! Theme::style('css/animate.css') !!}
    {!! Theme::style('css/font-awesome.min.css') !!}
    {!! Theme::style('css/main.css') !!}
    {!! Theme::style('css/common.css') !!}
    <?php $themeUrl =  Theme::url(); ?>
    <?php $facilityTypes = \Modules\Village\Entities\AbstractFacility::getTypes()?>
</head>
<body>
<div class="main-wrapper">
    <header class="header" id="home">
        <div class="mobile-header">
            <a href="#" class="logo"></a>
            <div class="navbar-menu-overlay"></div><a href="#" class="mob-menu-icon"><span></span></a>
            <div class="mob-sidebar">
                <div class="mob-menu-container">
                    <ul class="menu menu-mob">
                        <li><a href="#" data-popup-link="login" class="menu-mob-item">Войти</a>
                        </li>
                        <li><a href="#info" class="menu-mob-item">Преимущества</a>
                        </li>
                        <li><a href="#rates" class="menu-mob-item">Цены</a>
                        </li>
                        <li><a href="#reviews" class="menu-mob-item">Отзывы</a>
                        </li>
                        <li><a href="#contacts" class="menu-mob-item">Контакты</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="header-slider">
            <div class="container">
                <div class="row">
                    <div class="header-top">
                        <div class="desktop-header">
                            <div class="col-xs-3">
                                <a href="#" class="logo"></a>
                            </div>
                            <div class="col-xs-6">
                                <div class="navigation-wrap">
                                    <ul class="navigation">
                                        <li><a href="#info">Преимущества</a>
                                        </li>
                                        <li><a href="#rates">Цены</a>
                                        </li>
                                        <li><a href="#reviews">Отзывы</a>
                                        </li>
                                        <li><a href="#contacts">Контакты</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="login-wrap"><a href="#" data-popup-link="login" class="login">Войти</a>
                                </div>
                                <div class="language-switcher clearfix hide">
                                    <select class="chosen-select-no-single">
                                        <option>РУ</option>
                                        <option>Md</option>
                                        <option>En</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-md-offset-7">
                                <div class="slider-form">
                                    <h4>Получите месяц тестового периода <span>бесплатно</span>!</h4>
                                    <form id="register-facility" method="post" action="">
                                        <div class="form-group">
                                            <input type="text" name="full_name" placeholder="Имя, Фамилия" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" placeholder="Email" required="required" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="name" placeholder="Торговый центр “Ривьера”"  required="required" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <select name="type" class="facility-type"  required="required">
                                                @foreach ($facilityTypes as $type)
                                                   <option value="{!! $type !!}">{!!  trans('village::villages.type.'.$type) !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" required="required" name="phone" data-mask="" placeholder="Ваш телефон" data-inputmask='"mask": "{!! config('village.user.phone.mask') !!}"' class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn-submit">Получить Доступ</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="owl-carousel">
                <div class="item slider-img">
                    <div class="container">
                        <div class="row">
                            <div class="slider-content">
                                <div class="col-md-6 col-sm-12">
                                    <div class="slider-description">
                                        <h3>Мы делаем жизнь проще!</h3>
                                        <p>Забудьте о проблемах и недовольстве клиентов. Моментальный отклик на заявки и оперативный менеджмент объекта в один клик</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item slider-img">
                    <div class="container">
                        <div class="row">
                            <div class="slider-content">
                                <div class="col-md-6 col-sm-12">
                                    <div class="slider-description">
                                        <h3>Мы делаем жизнь проще!</h3>
                                        <p>Забудьте о проблемах и недовольстве клиентов. Моментальный отклик на заявки и оперативный менеджмент объекта в один клик</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item slider-img">
                    <div class="container">
                        <div class="row">
                            <div class="slider-content">
                                <div class="col-md-6 col-sm-12">
                                    <div class="slider-description">
                                        <h3>Мы делаем жизнь проще!</h3>
                                        <p>Забудьте о проблемах и недовольстве клиентов. Моментальный отклик на заявки и оперативный менеджмент объекта в один клик</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <section class="info" id="info">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="headline">
                        <h3>Консьерж для Вашего бизнеса</h3>
                        <p>Посмотрите на то, чем торгуют люди, пройдите по городу и досмотрите, что продается: наряды и предметы для объядения. Они с полчаса как кончили работу, так что в этот день мы могли сидеть только пустые каморы. Несмотря на открытые
                            с двух сторон ворота, в каморе был тяжелый запах теплой крови, пол был весь коричневый, глянцовитый и в углублениях пола стояла сгущающаяся черная кровь.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="vilage-card-wrap">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="vilage-card">
                                    <div class="img-wrapper">
                                        <img src="{!! $themeUrl !!}/images/panel-img-1.png" />
                                    </div><a href="#" class="img-link"><span>подробнее</span></a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="vilage-card">
                                    <div class="img-wrapper">
                                        <img src="{!! $themeUrl !!}/images/panel-img-2.png" />
                                    </div><a href="#" class="img-link"><span>подробнее</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="vilage-card">
                                    <div class="img-wrapper">
                                        <img src="{!! $themeUrl !!}/images/panel-img-3.png" />
                                    </div><a href="#" class="img-link"><span>подробнее</span></a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="vilage-card">
                                    <div class="img-wrapper">
                                        <img src="{!! $themeUrl !!}/images/panel-img-4.png" />
                                    </div><a href="#" class="img-link"><span>подробнее</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="vilage-card-open">
                        <a href="#" class="card-close"></a>
                        <div class="row">
                            <div class="col-md-4 padding-right-none">
                                <div class="left-block js-equal-height"></div>
                            </div>
                            <div class="col-md-8 padding-left-none">
                                <div class="right-block js-equal-height">
                                    <div class="card-open-headline">
                                        <h3>Смарт-Офис - нет ничего проще!</h3>
                                        <p>Предоставление услуг высшего качества, оперативная связь с арендаторами, удобный инструмент для мониторинга общественного мнения, а также удобная доставка новостей и счетов клиентам в удобном формате. Лучшее
                                            all-in-one решение для бизнес-центров вместе с сервисом "Консьерж".</p>
                                    </div>
                                    <div class="card-open-advantages">
                                        <h3>Преимущества</h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="advantages-block"><i class="icon-grafic sprite"></i>
                                                    <h4>Качество</h4>
                                                    <p>А между тем так же, как первое условие доброй жизни есть воздержание, так и первое условие воздержанной жизни.</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="advantages-block"><i class="icon-tree sprite"></i>
                                                    <h4>Контроль персонала</h4>
                                                    <p>А между тем так же, как первое условие доброй жизни есть воздержание, так и первое условие воздержанной жизни.</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="advantages-block"><i class="icon-sheet sprite"></i>
                                                    <h4>Управление услугами</h4>
                                                    <p>А между тем так же, как первое условие доброй жизни есть воздержание, так и первое условие воздержанной жизни.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="earnings">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="headline">
                        <h3>Консьерж увеличит Ваш заработок</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="earnings-slider">
                    <div class="item">
                        <div class="col-md-4">
                            <div class="item-wrap">
                                <div class="icon-wrap"><i class="icon-dashboard sprite"></i>
                                </div>
                                <div class="content-wrap clearfix">
                                    <h4>Удобный интерфейс</h4>
                                    <p>Looking cautiously round, to ascertain that they were not overheard, the two hags cowered nearer to the fire, and chuckled heartily.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="col-md-4">
                            <div class="item-wrap">
                                <div class="icon-wrap"><i class="icon-chat sprite"></i>
                                </div>
                                <div class="content-wrap clearfix">
                                    <h4>Онлайн заявки</h4>
                                    <p>Looking cautiously round, to ascertain that they were not overheard, the two hags cowered nearer to the fire, and chuckled heartily.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="col-md-4">
                            <div class="item-wrap">
                                <div class="icon-wrap"><i class="icon-phone sprite"></i>
                                </div>
                                <div class="content-wrap clearfix">
                                    <h4>Уведомления</h4>
                                    <p>Looking cautiously round, to ascertain that they were not overheard, the two hags cowered nearer to the fire, and chuckled heartily.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="col-md-4">
                            <div class="item-wrap">
                                <div class="icon-wrap"><i class="adjustments sprite"></i>
                                </div>
                                <div class="content-wrap clearfix">
                                    <h4>Гибкая настройка</h4>
                                    <p>Looking cautiously round, to ascertain that they were not overheard, the two hags cowered nearer to the fire, and chuckled heartily.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="col-md-4">
                            <div class="item-wrap">
                                <div class="icon-wrap"><i class="chart sprite"></i>
                                </div>
                                <div class="content-wrap clearfix">
                                    <h4>Заказ товара онлайн</h4>
                                    <p>Looking cautiously round, to ascertain that they were not overheard, the two hags cowered nearer to the fire, and chuckled heartily.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="col-md-4">
                            <div class="item-wrap">
                                <div class="icon-wrap"><i class="icon-statistic sprite"></i>
                                </div>
                                <div class="content-wrap clearfix">
                                    <h4>Подробная статистика</h4>
                                    <p>Looking cautiously round, to ascertain that they were not overheard, the two hags cowered nearer to the fire, and chuckled heartily.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-wrapper"><a href="#" class="btn-white btn-advantages-open">Узнать больше</a>
                    </div>
                    <div class="advantages-open animated fadeInDown">
                        <h3>Ваши клиенты всегда будут довольны</h3>
                        <p>А между тем так же, как первое условие доброй жизни есть воздержание, так и первое условие воздержанной жизни есть пост. Нельзя не радоваться этому так же, как не могли бы не радоваться люди, стремившиеся войти на верх дома
                            и прежде беспорядочно и тщетно лезшие с разных сторон прямо на стены, когда бы они стали сходиться, наконец, к первой ступени лестницы и все бы теснились у нее, зная, что хода на верх не может быть помимо этой первой ступени
                            лестницы.</p>
                        <p>А между тем так же, как первое условие доброй жизни есть воздержание, так и первое условие воздержанной жизни есть пост. Нельзя не радоваться этому так же, как не могли бы не радоваться люди, стремившиеся войти на верх дома
                            и прежде беспорядочно и тщетно лезшие с разных сторон прямо на стены, когда бы они стали сходиться, наконец, к первой ступени лестницы и все бы теснились у нее, зная, что хода на верх не может быть помимо этой первой ступени
                            лестницы.</p>
                        <h3>Другие причины для использования Консьержа</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <ul>
                                    <li>А между тем так же, как первое условие доброй жизни есть воздержание;</li>
                                    <li>Так и первое условие воздержанной жизни есть пост;</li>
                                    <li>Нельзя не радоваться этому так же, как не могли бы не радоваться люди;</li>
                                    <li>Стремившиеся войти на верх дома и прежде беспорядочно;</li>
                                    <li>И тщетно лезшие с разных сторон прямо на стены</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul>
                                    <li>А между тем так же, как первое условие доброй жизни есть воздержание;</li>
                                    <li>Так и первое условие воздержанной жизни есть пост;</li>
                                    <li>Нельзя не радоваться этому так же, как не могли бы не радоваться люди;</li>
                                    <li>Стремившиеся войти на верх дома и прежде беспорядочно;</li>
                                    <li>И тщетно лезшие с разных сторон прямо на стены</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="btn-wrapper"><a href="#" class="btn-white btn-advantages-close">Свернуть</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="profile-slider">
        <div class="container">
            <div class="row">
                <div class="col-md-7 padding-none">
                    <div class="carousel-rotate-wrap">
                        <div class="carousel-rotate">
                            <div class="item">
                                <img src="{!! $themeUrl !!}/images/phone-item2.png" />
                            </div>
                            <div class="item">
                                <img src="{!! $themeUrl !!}/images/phone-item1.png" />
                            </div>
                            <div class="item">
                                <img src="{!! $themeUrl !!}/images/slide-item.png" />
                            </div>
                            <div class="item">
                                <img src="{!! $themeUrl !!}/images/phone-item3.png" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 padding-none profile-wrapper">
                    <div class="profile-info">
                        <div class="item-wrap">
                            <div class="icon-wrap"><i class="chart sprite"></i>
                            </div>
                            <div class="content-wrap clearfix">
                                <h4>Следите за всеми событиями</h4>
                                <p>Whether you want to create a blog, eCommerce store, portfolio, or all of the above, you can express your idea with a website powered by our elegant yet intuitive platform.</p>
                            </div>
                        </div>
                        <div class="item-wrap">
                            <div class="icon-wrap"><i class="chart sprite"></i>
                            </div>
                            <div class="content-wrap clearfix">
                                <h4>Подробный профиль</h4>
                                <p>From goods to services, every business needs a space online to bring in customers.</p>
                            </div>
                        </div>
                        <div class="item-wrap">
                            <div class="icon-wrap"><i class="chart sprite"></i>
                            </div>
                            <div class="content-wrap clearfix">
                                <h4>Делайте пометки</h4>
                                <p>An artist should always have control over their creative process.</p>
                            </div>
                        </div>
                    </div>
                    <div class="profile-info-footer"><a href="#home">ПОПРОБУЙТЕ СЕЙЧАС</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="join-now">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Присоединяйтесь</h2>
                    <p>Уже на данный момент нашими услугами пользуется около 50 000 пользователей. Станьте частью нашего большого сообщества.</p>
                    <div class="btn-wrapper"><a href="#home" class="btn-main">ПОЛУЧИТЬ ДОСТУП</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="rates" id="rates">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="headline">
                        <h3>Тарифы для <span>Бизнес центров</span></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="rates-slider">
                        <div class="item">
                            <div class="rates-card">
                                <div class="rates-card-header">
                                    <p>Базовый</p>
                                </div>
                                <div class="rates-card-body">
                                    <div class="rates-info"><i></i>
                                        <p>200</p>
                                    </div>
                                    <p class="rates-user">Система поддерживающая 200 пользователей</p>
                                    <p class="rates-price"><span>1599</span>/месяц</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="rates-card">
                                <div class="rates-card-header">
                                    <p>Базовый</p>
                                </div>
                                <div class="rates-card-body">
                                    <div class="rates-info"><i></i>
                                        <p>200</p>
                                    </div>
                                    <p class="rates-user">Система поддерживающая 200 пользователей</p>
                                    <p class="rates-price"><span>1599</span>/месяц</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="rates-card">
                                <div class="rates-card-header">
                                    <p>Базовый</p>
                                </div>
                                <div class="rates-card-body">
                                    <div class="rates-info"><i></i>
                                        <p>200</p>
                                    </div>
                                    <p class="rates-user">Система поддерживающая 200 пользователей</p>
                                    <p class="rates-price"><span>1599</span>/месяц</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="rates-card">
                                <div class="rates-card-header">
                                    <p>Базовый</p>
                                </div>
                                <div class="rates-card-body">
                                    <div class="rates-info"><i></i>
                                        <p>200</p>
                                    </div>
                                    <p class="rates-user">Система поддерживающая 200 пользователей</p>
                                    <p class="rates-price"><span>1599</span>/месяц</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rates-sales">
                        <p><span>Специальное условие!</span> Скидки от <span>25%</span> до <span>50%</span> при оплате авансом</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-wrapper"><a href="#" class="btn-main">Попробовать бесплатно</a></div>
                </div>
            </div>
        </div>
    </section>
    <section class="reviews" id="reviews">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="headline"><h3>Что говорят о нас</h3></div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="reviews-card-wrap">
                        <div class="reviews-card active"><p class="reviews-description">Консьерж помог нашему бизнес-центру
                                качественно улучшить уровень предоставляемых услуг!</p><h5 class="reviews-name">Геннадий
                                Волыгин1</h5>
                            <p class="reviews-position">управляющий БЦ “Сити-Люкс”</p>
                            <div class="reviews-img"><img src="{!! $themeUrl !!}/images/reviews-img.png"/></div>
                        </div>
                        <div class="reviews-card"><p class="reviews-description">Консьерж помог нашему бизнес-центру
                                качественно улучшить уровень предоставляемых услуг!</p><h5 class="reviews-name">Вася
                                Пупкин</h5>
                            <p class="reviews-position">управляющий БЦ “Сити-Люкс”</p>
                            <div class="reviews-img"><img src="{!! $themeUrl !!}/images/reviews-img.png"/></div>
                        </div>
                        <div class="reviews-card"><p class="reviews-description">Консьерж помог нашему бизнес-центру
                                качественно улучшить уровень предоставляемых услуг!</p><h5 class="reviews-name">Илья
                                муромец</h5>
                            <p class="reviews-position">управляющий БЦ “Сити-Люкс”</p>
                            <div class="reviews-img"><img src="{!! $themeUrl !!}/images/reviews-img.png"/></div>
                        </div>
                        <div class="reviews-card"><p class="reviews-description">Консьерж помог нашему бизнес-центру
                                качественно улучшить уровень предоставляемых услуг!</p><h5 class="reviews-name">Добрыня
                                Никитич</h5>
                            <p class="reviews-position">управляющий БЦ “Сити-Люкс”</p>
                            <div class="reviews-img"><img src="{!! $themeUrl !!}/images/reviews-img.png"/></div>
                        </div>
                    </div>
                    <div class="col-xs-8 col-xs-offset-2 col-sm-6 col-sm-offset-3">
                        <div class="reviews-slider">
                            <div class="item">
                                <div data-index="0" class="client-img js-toggle-review-card"><img
                                            src="{!! $themeUrl !!}/images/reviews-img.png"/></div>
                            </div>
                            <div class="item">
                                <div data-index="1" class="client-img js-toggle-review-card"><img
                                            src="{!! $themeUrl !!}/images/reviews-img1.png"/></div>
                            </div>
                            <div class="item">
                                <div data-index="2" class="client-img js-toggle-review-card"><img
                                            src="{!! $themeUrl !!}/images/reviews-img.png"/></div>
                            </div>
                            <div class="item">
                                <div data-index="3" class="client-img js-toggle-review-card"><img
                                            src="{!! $themeUrl !!}/images/reviews-img1.png"/></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="clients">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="headline"><h3>Наши клиенты</h3></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <ul class="clients-list">
                        <li><img src="{!! $themeUrl !!}/images/clients1.png"/></li>
                        <li><img src="{!! $themeUrl !!}/images/clients2.png"/></li>
                        <li><img src="{!! $themeUrl !!}/images/clients2.png"/></li>
                        <li><img src="{!! $themeUrl !!}/images/clients2.png"/></li>
                        <li><img src="{!! $themeUrl !!}/images/clients1.png"/></li>
                        <li><img src="{!! $themeUrl !!}/images/clients2.png"/></li>
                        <li><img src="{!! $themeUrl !!}/images/clients1.png"/></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="main-form">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="headline">
                        <h3>Протестируйте Консьерж уже сейчас</h3>
                        <p>Подпишитесь на бесплатный месяц тестового периода</p>
                    </div>
                </div>
                <div class="form">
                    <form id="register-facility-wide" method="post" action="">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" name="full_name" placeholder="Имя, Фамилия" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="email" name="email" placeholder="Email" required="required" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" name="name" placeholder="Торговый центр “Ривьера”" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="type" class="facility-type"  required="required">
                                        @foreach ($facilityTypes as $type)
                                            <option value="{!! $type !!}">{!!  trans('village::villages.type.'.$type) !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" required="required" name="phone" data-mask="" placeholder="Ваш телефон" data-inputmask='"mask": "{!! config('village.user.phone.mask') !!}"' class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="btn-wrapper">
                                        <button class="btn-main" type="submit">Получить Доступ</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="contacts" id="contacts">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="headline"><h3>Контакты</h3></div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="cotacts-wrapper"><h5>ООО "Консьерж"</h5>
                        <p class="adress">188367, г. Москва,<br> ул. Новый Арбат 20, офис 100</p>
                        <a href="#" class="phone">+7 (495) 731-74-37</a>
                        <a href="#" class="email">info@concierge.app</a>
                        <p class="metro">"Арбатская 3, 4", "Смоленская 3, 4"</p>
                        <div class="btn-wrapper">
                            <a href="#" data-popup-link="map" class="btn-white">Открыть карту</a>
                        </div>
                        <ul class="social">
                            <li><a href="#" class="social-fb"></a></li>
                            <li><a href="#" class="social-vk"></a></li>
                            <li><a href="#" class="social-gplus"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!--
CMS front page commented at the moment.
@include('partials.navigation')
<div class="container">
    @yield('content')
</div> -->
@include('partials.footer')
@include('partials.popups')
{!! Theme::script('js/libs/jquery-1.11.2.min.js') !!}
{!! Theme::script('js/libs/chosen.jquery.min.js') !!}
{!! Theme::script('js/libs/owl.carousel.min.js') !!}
{!! Theme::script('js/libs/matchHeight.js') !!}
{!! Theme::script('js/libs/Scroll2id.min.js') !!}
{!! Theme::script('js/libs/jquery-imagefill.js') !!}
{!! Theme::script('js/libs/imagesloaded.min.js') !!}
<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyA8rJqu3EUZaTMaJ_8sP2Cn05-VW6f2Jlo"></script>
{!! Theme::script('js/libs/google-map.js') !!}
{!! Theme::script('js/scripts.min.js') !!}
{!! HTML::script('themes/adminlte/js/vendor/input-mask/jquery.inputmask.js') !!}
{!! HTML::script('themes/adminlte/js/vendor/input-mask/jquery.inputmask.phone.extensions.js') !!}
{!! Theme::script('js/common.js') !!}
@yield('scripts')
<?php if (Setting::has('core::google-analytics')): ?>
{!! Setting::get('core::google-analytics') !!}
<?php endif; ?>
</body>
</html>