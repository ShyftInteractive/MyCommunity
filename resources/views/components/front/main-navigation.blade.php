<ul {{$attributes->merge(['class' => 'navigation--main']) }}>
    <li><a href="/">Home</a></li>
    @foreach($pages as $page)
    <li><a href="{{$page->slug}}">{{ ucfirst($page->title)}}</a></li>
    @endforeach
</ul>
