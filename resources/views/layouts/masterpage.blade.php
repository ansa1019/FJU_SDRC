<!DOCTYPE html>
<html lang="en" style="height: 100%">

<head>
    <link rel="icon" href="{{ asset('static/img/logo.ico') }}" type="image/x-icon" />
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta property="og:title" content="{{ $article_title ?? '預設標題' }}">
    <meta property="og:description" content="{{ $plain ?? '文章描述未提供' }}">
    <meta property="og:image" content="{{ $cover_image ?? asset('static/img/default_cover_image.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <!--ICON-->
    <link rel="stylesheet" href="{{ asset('static/bootstrap_icons-1.4.1/font/bootstrap-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('static/fontawesome-free-5.15.3-web/css/all.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css') }}" />

    <!--Bootstrap-->
    <link rel="stylesheet" href="{{ asset('static/bootstrap-5.1.3-dist/css/bootstrap.min.css') }}" />
    <!--BootstrapTable-->
    <link rel="stylesheet" href="{{ asset('static/bootstrap-table-master/dist/bootstrap-table.min.css') }}" />
    <!-- MultiSelect -->
    <link rel="stylesheet" href="{{ asset('static/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}"
        type="text/css" />
    <!-- Datetime picker -->
    <link rel="stylesheet"
        href="{{ asset('static/bootstrap-datepicker-master/dist/css/bootstrap-datepicker.min.css') }}" />
    <!-- Image cropper -->
    <link href="https://unpkg.com/cropperjs/dist/cropper.min.css" rel="stylesheet" />

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="{{ asset('static/sweetalert2-11.7.1/dist/sweetalert2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('static/quill-1.3.6/quill.snow.css') }}" />
    <link rel="stylesheet" href="{{ asset('static/quill-1.3.6/quill.core.css') }}" />

    <!-- import self-css -->
    <link rel="stylesheet" href="{{ asset('static/css/article.css') }}" />
    <link rel="stylesheet" href="{{ asset('static/css/master_page.css') }}" />
    <link rel="stylesheet" href="{{ asset('static/css/index.css') }}" />
    <link rel="stylesheet" href="{{ asset('static/css/forum_list.css') }}" />
    <link rel="stylesheet" href="{{ asset('static/css/user.css') }}" />
    <link rel="stylesheet" href="{{ asset('static/css/point.css') }}" />
    <link rel="stylesheet" href="{{ asset('static/css/saved.css') }}" />
    <link rel="stylesheet" href="{{ asset('static/css/chat_room.css') }}" />
    <link rel="stylesheet" href="{{ asset('static/css/share_modal.css') }}" />
    <link rel="stylesheet" href="{{ asset('static/css/point.css') }}" />
    <!-- JS -->
    <script src="{{ asset('static/bootstrap-4.6.0-dist/jquery-3.6.0.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"
        integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/cropperjs/dist/cropper.min.js"></script>
    <!-- jsCalendar -->
    <link rel="stylesheet" type="text/css" href="static/jsCalendar-master/source/jsCalendar.css" />
    <!-- chat room -->
    <script src="https://cdn.socket.io/4.7.5/socket.io.min.js"
        integrity="sha384-2huaZvOR9iDzHqslqwpR87isEmrfxqyWOF7hr7BY6KG0+hVKLoEXMPUJw3ynWuhO" crossorigin="anonymous">
    </script>


    <title>@yield('title', '莎莉聊療吧 - 優德莎莉')</title>
    <style>
        #calendar {
            font-size: var(--fs-18);
        }
    </style>
</head>

<body>
    @isset($jwt_token)
        <p style="display: none" id="jwt_token">{{ $jwt_token }}</p>
    @endisset
    <div type="hidden" id="app" data-api-ip="{{ env('API_IP') }}"></div>

    @include('layouts.navigation')
    @yield('content')
    @include('layouts.footer')
    @include('layouts.chat_room')

</body>

<script src="{{ asset('static/bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('static/bootstrap-table-master/dist/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('static/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}"></script>
<script src="{{ asset('static/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('static/bootstrap-datepicker-master/dist/locales/bootstrap-datepicker.zh-TW.min.js') }}">
</script>
<script src="{{ asset('static/sweetalert2-11.7.1/dist/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('static/jsCalendar-master/source/jsCalendar.js') }}"></script>
<script src="{{ asset('static/jsCalendar-master/source/jsCalendar.lang.zh.js') }}"></script>
<script src="{{ asset('static/evo-event-calendar/js/evo-calendar.js') }}"></script>
<script src="{{ asset('static/dayjs-1.11.8/package/dayjs.min.js') }}"></script>
<script src="{{ asset('static/dayjs-1.11.8/package/locale/zh-tw.js') }}"></script>
<script src="{{ asset('static/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('static/quill-1.3.6/quill.js') }}"></script>
@if (!empty($nickname))
    <script src="{{ asset('static/js/chat.js') }}"></script>
@endif
<script src="{{ asset('static/js/master_page.js') }}"></script>
<script src="{{ asset('static/js/index.js') }}"></script>
<script src="{{ asset('static/js/forum_list.js') }}"></script>
<script src="{{ asset('static/js/user.js') }}"></script>
<script src="{{ asset('static/js/points.js') }}"></script>
<script src="{{ asset('static/js/article.js') }}"></script>
<script src="{{ asset('static/js/calendar.js') }}"></script>
<script src="{{ asset('static/js/save.js') }}"></script>
<script src="{{ asset('static/js/blacklist.js') }}"></script>
