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
    <?php
    $facilityTypes = \Modules\Village\Entities\AbstractFacility::getTypes();
            var_dump($facilityTypes);
    $packets = new \Modules\Village\Services\Packet();
   $sett =  $packets->getSettings();
      //  var_dump($sett)
    ?>

            <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-TXXJFNR');</script>
    <!-- End Google Tag Manager -->
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TXXJFNR"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

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
                                        <option>Ру</option>
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

                <!--Slide 1 start-->
                <div class="item slider-img" id="slider1">
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
                <!--Slide 1 end-->

                <!--Slide 2 start-->
                <div class="item slider-img" id="slider2">
                    <div class="container">
                        <div class="row">
                            <div class="slider-content">
                                <div class="col-md-6 col-sm-12">
                                    <div class="slider-description">
                                        <h3>Бюрократия в прошлом!</h3>
                                        <p>Все документы, счета, показания и квитанции всегда под рукой с возможностью отправки через E-mail. Вся мощь цифровых решений в одно касание.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Slide 2 end-->

                <!--Slide 3 start-->
                <div class="item slider-img"  id="slider3">
                    <div class="container">
                        <div class="row">
                            <div class="slider-content">
                                <div class="col-md-6 col-sm-12">
                                    <div class="slider-description">
                                        <h3>Продвигайте услуги сегодня!</h3>
                                        <p>Продажа товаров, оказание услуг и оперативная поддержка для жильцов и клиентов. Увеличение доходности и расширение бизнеса благодаря партнёрству уже сейчас.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Slide 3 end-->

                <!--Slide 4 start-->
                <div class="item slider-img" id="slider4">
                    <div class="container">
                        <div class="row">
                            <div class="slider-content">
                                <div class="col-md-6 col-sm-12">
                                    <div class="slider-description">
                                        <h3>Новый уровень поддержки!</h3>
                                        <p>Оказание помощи, ответы на вопросы пользователей, оперативный менеджмент ресурсов, а также новый уровень предоставления услуг с сервисом Консьерж!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Slide 4 end-->

            </div>
        </div>
    </header>
    <section class="info" id="info">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <!--General text start-->
                    <div class="headline">
                        <h3>Консьерж для Вашего бизнеса</h3>
                        <p>Хотите сделать управление своим бизнесом или недвижимостью удобнее? Сервис “Консьерж” станет вашим незаменимым помощником. Всего несколько кликов и полный оперативный контроль ресурсов Бизнес-Центра, Жилого Комплекса, Торгового Центра или Коттеджного Посёлка у Вас в руках. Мониторинг текущей обстановки, общение с клиентами и оперативная поддержка, оказание услуг и продажа товаров в режиме онлайн. “Консьерж” - смарт-решения уже сегодня!</p>
                    </div>
                    <!-- General text end-->
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
                                    </div><a href="#" class="img-link" rel="card1"><span>подробнее</span></a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="vilage-card">
                                    <div class="img-wrapper">
                                        <img src="{!! $themeUrl !!}/images/panel-img-2.png" />
                                    </div><a href="#" class="img-link" rel="card2"><span>подробнее</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="vilage-card">
                                    <div class="img-wrapper">
                                        <img src="{!! $themeUrl !!}/images/panel-img-3.png" />
                                    </div><a href="#" rel="card3" class="img-link"><span>подробнее</span></a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="vilage-card">
                                    <div class="img-wrapper">
                                        <img src="{!! $themeUrl !!}/images/panel-img-4.png" />
                                    </div><a href="#" rel="card4" class="img-link"><span>подробнее</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="card1" class="vilage-card-open">
                        <a href="#" class="card-close"></a>
                        <div class="row">
                            <div class="col-md-4 padding-right-none">
                                <div class="left-block js-equal-height"></div>
                            </div>
                            <div class="col-md-8 padding-left-none">
                                <div class="right-block js-equal-height">
                                    <div class="card-open-headline">
                                        <h3>Смарт-Офис - нет ничего проще!</h3>
                                        <p>Предоставление услуг высшего качества, оперативная связь с арендаторами, удобный инструмент для мониторинга общественного мнения, а также удобная доставка новостей и счетов клиентам в удобном формате. Лучшее all-in-one решение для бизнес-центров вместе с сервисом "Консьерж".</p>
                                    </div>
                                    <div class="card-open-advantages">
                                        <h3>Преимущества</h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="advantages-block"><i class="icon-grafic sprite"></i>
                                                    <h4>Оперативная поддержка</h4>
                                                    <p>Возможность оказания мгновенной поддержки пользователям бизнес-центров от малых офисов до бизнес-парков.</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="advantages-block"><i class="icon-tree sprite"></i>
                                                    <h4>Управление услугами</h4>
                                                    <p>Предоставляйте широкий спектр услуг всех видов через удобный мобильный клиент. Всё гениальное просто!</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="advantages-block"><i class="icon-sheet sprite"></i>
                                                    <h4>Контроль всегда<br>под рукой</h4>
                                                    <p>Быстрая связь с обслуживающим персоналом, сотрудниками и исполнителями. Гибкая система оповещений.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="card2" class="vilage-card-open">
                        <a href="#" class="card-close"></a>
                        <div class="row">
                            <div class="col-md-4 padding-right-none">
                                <div class="left-block js-equal-height"></div>
                            </div>
                            <div class="col-md-8 padding-left-none">
                                <div class="right-block js-equal-height">
                                    <div class="card-open-headline">
                                        <h3>Жилой Комплекс нового поколения!</h3>
                                        <p>Мониторинг ресурсов в режиме онлайн, предоставление услуг, преимущества цифрового документооборота для жильцов и администрации и многое другое вместе с сервисом "Консьерж". Обеспечьте удобство, комфорт, безопасность и функциональность высшего уровня уже сегодня.</p>
                                    </div>
                                    <div class="card-open-advantages">
                                        <h3>Преимущества</h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="advantages-block"><i class="icon-grafic sprite"></i>
                                                    <h4>Оперативная поддержка</h4>
                                                    <p>Возможность оказания мгновенной поддержки пользователям бизнес-центров от малых офисов до бизнес-парков.</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="advantages-block"><i class="icon-tree sprite"></i>
                                                    <h4>Управление услугами</h4>
                                                    <p>Предоставляйте широкий спектр услуг всех видов через удобный мобильный клиент. Всё гениальное просто!</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="advantages-block"><i class="icon-sheet sprite"></i>
                                                    <h4>Контроль под рукой</h4>
                                                    <p>Быстрая связь с обслуживающим персоналом, сотрудниками и исполнителями. Удобная система оповещений и заявок.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="card3" class="vilage-card-open">
                        <a href="#" class="card-close"></a>
                        <div class="row">
                            <div class="col-md-4 padding-right-none">
                                <div class="left-block js-equal-height"></div>
                            </div>
                            <div class="col-md-8 padding-left-none">
                                <div class="right-block js-equal-height">
                                    <div class="card-open-headline">
                                        <h3>Коттеджный Посёлок - новая эра!</h3>
                                        <p>Безоспасность, удобство предоставления услуг, возможность мониторинга в режиме онлайн и многое другое вместе с сервисом "Консьерж". Смарт-услуги и смарт-сервис, новости и опросы для жильцов, возможность организации электронного охранно-контрольного режима. Будущее цифровых решений.
                                        </p>
                                    </div>
                                    <div class="card-open-advantages">
                                        <h3>Преимущества</h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="advantages-block"><i class="icon-grafic sprite"></i>
                                                    <h4>Широкие возможности</h4>
                                                    <p>Поддержка онлайн, магазин товаров и услуг, управление безопасностью и пропускным режимом и многое другое!</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="advantages-block"><i class="icon-tree sprite"></i>
                                                    <h4>Смарт-Дом</h4>
                                                    <p>Обеспечьте удобство жильцов благодаря интеграции с умным домом. Вся информация в одно касание.</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="advantages-block"><i class="icon-sheet sprite"></i>
                                                    <h4>Удобство взаимодействия</h4>
                                                    <p>Онлайн-документы, персональные оповещения, оперативная связь с пользователями и исполнителями.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="card4" class="vilage-card-open">
                        <a href="#" class="card-close"></a>
                        <div class="row">
                            <div class="col-md-4 padding-right-none">
                                <div class="left-block js-equal-height"></div>
                            </div>
                            <div class="col-md-8 padding-left-none">
                                <div class="right-block js-equal-height">
                                    <div class="card-open-headline">
                                        <h3>Торговый Центр нового поколения!</h3>
                                        <p>Смарт-продажи нуждаются в смарт-инструментах. Сервис "Консьерж" - многофункциональная интегрированная платформа, позволяющая эффективно администрировать ресурсы и торговые площади в режиме онлайн. Связь с арендаторами в один клик, предоставление онлайн-услуг, электронные документы и др. </p>
                                    </div>
                                    <div class="card-open-advantages">
                                        <h3>Преимущества</h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="advantages-block"><i class="icon-grafic sprite"></i>
                                                    <h4>Больше арендодателей</h4>
                                                    <p> Услуги высшего уровня и больше клиентов вместе с сервисом "Консьерж". Торговый центр нового поколения!</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="advantages-block"><i class="icon-tree sprite"></i>
                                                    <h4>Эффективные коммуникации</h4>
                                                    <p>Уменьшайте время отклика на заявки и увеличивайте лояльность клиентов благодаря быстрой коммуникации.</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="advantages-block"><i class="icon-sheet sprite"></i>
                                                    <h4>Отсутвтвие волокиты</h4>
                                                    <p>Модуль онлайн-документирования поможет избежать бумажной волокиты и сделать предоставление услуг комфортным.</p>
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
                                    <p>Всё гениальное просто! Удобный и лаконичный интерфейс, максимальная прозрачность функциональности и удобство без границ.</p>
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
                                    <p>Принимайте, реализуйте и завершайте заявки на услуги и товары в один клик. Удобный административный интерфейс к вашим услугам.</p>
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
                                    <h4>Персональные уведомления</h4>
                                    <p>Не упускайте ни единой новости или заявки. Гибкий механизм персонализированных оповещений для клиентов, администраторов и исполнителей.</p>
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
                                    <p>Удобная, функциональная и гибкая в возможностях административная панель - персонализация нового уровня. Будущее уже сейчас.</p>
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
                                    <p>Один клик до заказа товара или услуги. Удобная доставка, оплата онлайн и возможность получать всё с максимальным комфортом.</p>
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
                                    <p>Получайте данные о заказах, предоставляемых услугах, покупках и откликах на заявки жильцов и клиентов в режиме реального времени.</p>
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
                        <h3>Сервис "Консьерж" - будущее сегодня</h3>
                        <p>Электронный сервис "Консьерж" - концептуальное CRM решение для менеджмента и мониторинга ресурсов объектов недвижимости. Целевая аудитория Консьержа - холдинги и управляющие компании, отвечающие за сопровождение и администрирование крупных инфраструктурных объектов. От бизнес-центров до жилых комплексов, от коттеджных посёлков до торговых центров - удобство коммуникации, скорость и простота предоставления услуг и многое другое вместе с сервисом "Консьерж".</p>
                        <p>Благодаря интегрированной платформе администраторы объектов получают широкий спектр возможностей. Общайтесь с жильцами и арендаторами по средствам новостей, продвигайте товары и услуги во встроенном магазине, узнавайте общественное мнение благодаря публичным опросам, а также избавьтесь от бумажной волокиты благодаря встроенному механизму документооборота. Сервис "Консьерж" - опережая время!</p>
                        <h3>Ключевые преимущества сервиса "Консьерж"</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <ul>
                                    <li>Скорость и удобство менеджмента и мониторинга объектов;</li>
                                    <li>Возможность расширения спектра предоставляемых услуг;</li>
                                    <li>Информационный портал: лента новостей, документы, опросы;</li>
                                    <li>Гибкий и функциональный веб-интерфейс администрирования;</li>
                                    <li>Электронный документооборот для пользователей;</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul>
                                    <li>Механизмы быстрого взаимодействия с арендаторами и жильцами;</li>
                                    <li>Интегрированный доступ к системам умного дома из приложения;</li>
                                    <li>Персональные уведомления для пользователей и исполнителей;</li>
                                    <li>Перспективная возможность интеграции с популярными CRM;</li>
                                    <li>Поддержка, обновления и расширение возможностей;</li>
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
                                <h4>Следите за событиями</h4>
                                <p>Оставайтесь в курсе новостей, услуг, объявлений и опросов благодаря сервису "Консьерж". Удобство и гибкий функционал в вашем смарт-устройстве.</p>
                            </div>
                        </div>
                        <div class="item-wrap">
                            <div class="icon-wrap"><i class="chart sprite"></i>
                            </div>
                            <div class="content-wrap clearfix">
                                <h4>Решение "всё в одном"</h4>
                                <p>От товаров и услуг, до экстренной помощи и поддержки администрации в режиме онлайн.</p>
                            </div>
                        </div>
                        <div class="item-wrap">
                            <div class="icon-wrap"><i class="chart sprite"></i>
                            </div>
                            <div class="content-wrap clearfix">
                                <h4>Документы под рукой</h4>
                                <p>Счета, квитанции, справки и любые другие документы в удобном доступе и всегда под рукой.</p>
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
                    <p>Услугами сервиса Консьерж на данный момент нашими услугами пользуется более 1 000 пользователей. Станьте частью нашего большого сообщества.</p>
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
                

                        <div class="item" rel="business">
                            <div class="rates-card">
                                <div class="rates-card-header">
                                    <p>Базовый</p>
                                </div>
                                <div class="rates-card-body">
                                    <div class="rates-info"><i></i>
                                        <p>100</p>
                                    </div>
                                    <p class="rates-user">Система поддерживающая до 100 адресов</p>
                                    <p class="rates-price"><span>9800</span>/месяц</p>
                                </div>
                            </div>

                        </div>
                        <div class="item" rel="business">
                            <div class="rates-card">
                                <div class="rates-card-header">
                                    <p>Продвинутый</p>
                                </div>
                                <div class="rates-card-body">
                                    <div class="rates-info"><i></i>
                                        <p>300</p>
                                    </div>
                                    <p class="rates-user">Система поддерживающая до 300 адресов</p>
                                    <p class="rates-price"><span>18800</span>/месяц</p>
                                </div>
                            </div>
                        </div>
                        <div class="item" rel="business">
                            <div class="rates-card">
                                <div class="rates-card-header">
                                    <p>Профессионал</p>
                                </div>
                                <div class="rates-card-body">
                                    <div class="rates-info"><i></i>
                                        <p>600</p>
                                    </div>
                                    <p class="rates-user">Система поддерживающая до 600 адресов</p>
                                    <p class="rates-price"><span>22800</span>/месяц</p>
                                </div>
                            </div>
                        </div>






                        <div class="item" rel="shopping">
                            <div class="rates-card">
                                <div class="rates-card-header">
                                    <p>Базовый</p>
                                </div>
                                <div class="rates-card-body">
                                    <div class="rates-info"><i></i>
                                        <p>100</p>
                                    </div>
                                    <p class="rates-user">Система поддерживающая до 100 адресов</p>
                                    <p class="rates-price"><span>10400</span>/месяц</p>
                                </div>
                            </div>

                        </div>
                        <div class="item" rel="shopping">
                            <div class="rates-card">
                                <div class="rates-card-header">
                                    <p>Продвинутый</p>
                                </div>
                                <div class="rates-card-body">
                                    <div class="rates-info"><i></i>
                                        <p>200</p>
                                    </div>
                                    <p class="rates-user">Система поддерживающая до 200 адресов</p>
                                    <p class="rates-price"><span>13400</span>/месяц</p>
                                </div>
                            </div>
                        </div>
                        <div class="item" rel="shopping">
                            <div class="rates-card">
                                <div class="rates-card-header">
                                    <p>Профессионал</p>
                                </div>
                                <div class="rates-card-body">
                                    <div class="rates-info"><i></i>
                                        <p>400</p>
                                    </div>
                                    <p class="rates-user">Система поддерживающая до 400 адресов</p>
                                    <p class="rates-price"><span>16400</span>/месяц</p>
                                </div>
                            </div>
                        </div>









                        <div class="item" rel="apartment">
                            <div class="rates-card">
                                <div class="rates-card-header">
                                    <p>Базовый</p>
                                </div>
                                <div class="rates-card-body">
                                    <div class="rates-info"><i></i>
                                        <p>500</p>
                                    </div>
                                    <p class="rates-user">Система поддерживающая до 500 адресов</p>
                                    <p class="rates-price"><span>4800</span>/месяц</p>
                                </div>
                            </div>

                        </div>
                        <div class="item" rel="apartment">
                            <div class="rates-card">
                                <div class="rates-card-header">
                                    <p>Продвинутый</p>
                                </div>
                                <div class="rates-card-body">
                                    <div class="rates-info"><i></i>
                                        <p>1000</p>
                                    </div>
                                    <p class="rates-user">Система поддерживающая до 1000 адресов</p>
                                    <p class="rates-price"><span>6800</span>/месяц</p>
                                </div>
                            </div>
                        </div>
                        <div class="item" rel="apartment">
                            <div class="rates-card">
                                <div class="rates-card-header">
                                    <p>Профессионал</p>
                                </div>
                                <div class="rates-card-body">
                                    <div class="rates-info"><i></i>
                                        <p>3000</p>
                                    </div>
                                    <p class="rates-user">Система поддерживающая до 3000 адресов</p>
                                    <p class="rates-price"><span>12800</span>/месяц</p>
                                </div>
                            </div>
                        </div>










                        <div class="item" rel="cottage">
                            <div class="rates-card">
                                <div class="rates-card-header">
                                    <p>Базовый</p>
                                </div>
                                <div class="rates-card-body">
                                    <div class="rates-info"><i></i>
                                        <p>100</p>
                                    </div>
                                    <p class="rates-user">Система поддерживающая до 100 адресов</p>
                                    <p class="rates-price"><span>4200</span>/месяц</p>
                                </div>
                            </div>

                        </div>
                        <div class="item" rel="cottage">
                            <div class="rates-card">
                                <div class="rates-card-header">
                                    <p>Продвинутый</p>
                                </div>
                                <div class="rates-card-body">
                                    <div class="rates-info"><i></i>
                                        <p>300</p>
                                    </div>
                                    <p class="rates-user">Система поддерживающая до 300 адресов</p>
                                    <p class="rates-price"><span>8200</span>/месяц</p>
                                </div>
                            </div>
                        </div>
                        <div class="item" rel="cottage">
                            <div class="rates-card">
                                <div class="rates-card-header">
                                    <p>Профессионал</p>
                                </div>
                                <div class="rates-card-body">
                                    <div class="rates-info"><i></i>
                                        <p>600</p>
                                    </div>
                                    <p class="rates-user">Система поддерживающая до 600 адресов</p>
                                    <p class="rates-price"><span>10200</span>/месяц</p>
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
                    <div class="btn-wrapper"><a href="#home" class="btn-main">Попробовать бесплатно</a></div>
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
                        <div class="reviews-card active">
                            <p class="reviews-description">Консьерж помог нашему бизнес-центру
                                качественно улучшить уровень предоставляемых услуг!</p><h5 class="reviews-name">Геннадий
                                Волыгин</h5>
                            <p class="reviews-position">управляющий БЦ “Сити-Люкс”</p>
                            <div class="reviews-img"><img src="{!! $themeUrl !!}/images/review-img.png"/></div>
                        </div>
                        <div class="reviews-card"><p class="reviews-description">Консьерж стал универсальным решением для управления услугами, персоналом и процессом аренды площадей.</p><h5 class="reviews-name">Андрей Аксёнов</h5>
                            <p class="reviews-position">директор ТЦ "Галерея"</p>
                            <div class="reviews-img"><img src="{!! $themeUrl !!}/images/review-img-2.png"/></div>
                        </div>
                        <div class="reviews-card"><p class="reviews-description">Консьерж помог избавиться от бумажной волокиты и качественно повысит уровень коммуникаций с жильцами. Отлично!</p><h5 class="reviews-name">Николай Дергачёв</h5>
                            <p class="reviews-position">застроищик ЖК "Перспектива"</p>
                            <div class="reviews-img"><img src="{!! $themeUrl !!}/images/review-img-3.png"/></div>
                        </div>
                        <div class="reviews-card"><p class="reviews-description">Благодаря внедрению Консьержа нам удалось поднять уровень предоставляемых услуг и поднять популярность бизнес-центра.</p><h5 class="reviews-name">Михаил Антонов</h5>
                            <p class="reviews-position">владелец БЦ "NextCore"</p>
                            <div class="reviews-img"><img src="{!! $themeUrl !!}/images/review-img-4.png"/></div>
                        </div>
                    </div>
                    <div class="col-xs-8 col-xs-offset-2 col-sm-6 col-sm-offset-3">
                        <div class="reviews-slider">
                            <div class="item">
                                <div data-index="0" class="client-img js-toggle-review-card"><img
                                            src="{!! $themeUrl !!}/images/review-img.png"/></div>
                            </div>
                            <div class="item">
                                <div data-index="1" class="client-img js-toggle-review-card"><img
                                            src="{!! $themeUrl !!}/images/review-img-2.png"/></div>
                            </div>
                            <div class="item">
                                <div data-index="2" class="client-img js-toggle-review-card"><img
                                            src="{!! $themeUrl !!}/images/review-img-3.png"/></div>
                            </div>
                            <div class="item">
                                <div data-index="3" class="client-img js-toggle-review-card"><img
                                            src="{!! $themeUrl !!}/images/review-img-4.png"/></div>
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="full_name" placeholder="Имя, Фамилия" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="email" name="email" placeholder="Email" required="required" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="name" placeholder="Торговый центр “Ривьера”" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-md-4 col-md-offset-2">
                                <div class="form-group">
                                    <select name="type" class="facility-type"  required="required">
                                        @foreach ($facilityTypes as $type)
                                            <option value="{!! $type !!}">{!!  trans('village::villages.type.'.$type) !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
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
                    <div class="cotacts-wrapper"><h5>ООО "Е-Центр"</h5>
                        <p class="adress">108811, г. Москва,<br>Киевское шоссе, д. 1 БП "Румянцево", корпус "Г"</p>
                        <a href="tel:+74957317437" class="phone">+7 (495) 731-74-37</a>
                        <a href="mailto:concierge@concierge.promo" class="email">concierge@concierge.promo</a>
                        <p class="metro">"Тропарёво"</p>
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