<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello There World</title>
    <link href="{{ mix('/assets/css/front.css') }}" rel="stylesheet">
</head>

<body>
    <x-front.banner :banner="$banner" />

    <section class="container">
        <header class="header--main grid--center">
            <div class="workspace--logo col-10 sm::col-3">
                <h1>Logo</h1>
            </div>
            <nav class="col-2 sm::col-9">
                <section class="grid--center">
                    <x-front.main-navigation :pages="$pages" class="col-10" />
                    <x-front.secondary-navigation class="col-2" />
                </section>
            </nav>
        </header>
        @foreach($content as $row)
        <div class="grid--page" style="height: {{$row['height']}}">
            @foreach($row['cols'] as $col)
            <div class="col-{{$col['span']}}">
                {!! $col['component'] !!}
            </div>
            @endforeach
        </div>
        @endforeach
    </section>
    <footer class="footer--main">
        <div class="grid">
            <div class="col-12">
                Copyright &copy; 2020
            </div>
        </div>
    </footer>
</body>

</html>
