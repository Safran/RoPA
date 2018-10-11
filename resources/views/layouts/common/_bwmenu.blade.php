<ul {!!  (!empty($options['class']) ? ' class="'.$options['class'].'" ':'')  !!}>
    @foreach($items as $item)
        <li>
            <a class="{{ $item->class }}" href="{{ $item->link }}">{{ $item->title }}</a>
        </li>
    @endforeach
</ul>
