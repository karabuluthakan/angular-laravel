<ul class="m-menu__nav ">
    @foreach($links as $link)
        @if(!isset($link->parent)/* && Thor::_isMenuItemCan($link)*/)
            @if($link->type == \App\MenuLink::TYPE_SEPARATOR)
                <li class="m-menu__section m-menu__section--first">
                    <h4 class="m-menu__section-text">{{ $link->label }}</h4>
                    <i class="m-menu__section-icon flaticon-more-v2"></i>
                </li>
            @elseif ($link->type == \App\MenuLink::TYPE_LINK)
                <li class="m-menu__item{{ $link->has_child ? ' m-menu__item--submenu' : '' }}{{ $link->is_active ? ' m-menu__item--active' : '' }}{{ $link->is_child_active ? ' m-menu__item--open m-menu__item--expanded' : '' }}" aria-haspopup="true"{!! $link->has_child ? ' m-menu-submenu-toggle="hover"' : '' !!}>
                    <a href="{{ preg_match('/[^a-zA-Z_]/', $link->route) ? $link->route : route($link->route) }}" class="m-menu__link{{ $link->has_child ? ' m-menu__toggle' : '' }}">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon {{ $link->icon }}"></i>
                        <span class="m-menu__link-text">{{ $link->label }}</span>
                        @if($link->has_child)
                            <i class="m-menu__ver-arrow la la-angle-right"></i>
                        @endif
                    </a>
                    @if($link->has_child)
                        <div class="m-menu__submenu ">
                            <span class="m-menu__arrow"></span>
                            <ul class="m-menu__subnav">
                                @foreach($links as $link1)
                                    @if($link1->parent == $link->id /* && Thor::_isMenuItemCan($link)*/)
                                        <li class="m-menu__item{{ $link1->is_active ? ' m-menu__item--active' : '' }}" aria-haspopup="true">
                                            <a href="{{ route($link1->route) }}" class="m-menu__link ">
                                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                                <span class="m-menu__link-text">{{ $link1->label }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </li>
            @endif
        @endif
    @endforeach
</ul>
