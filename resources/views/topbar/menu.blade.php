@foreach ($menu as $value)

    @if($value->user_group_id == $data->user_group_id)

    <li class="nav-item has-treeview">

        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
                {{$value->title}}
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>

        <ul class="nav nav-treeview">

            @foreach($submenu as $submenus)

                @if($value->menu_item_id == $submenus->menu_item_id)

                    @php
                        // Check if submenu2 exists
                        $child2 = collect($submenu2)->where('sub_menu_2', $submenus->sub_menu_id);
                    @endphp

                    {{-- IF submenu2 EXISTS --}}
                    @if($child2->count() > 0)

                        <li class="nav-item has-treeview">

                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    {{$submenus->sub_menu_name}}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">

                                @foreach($child2 as $submenus2)
                                    <li class="nav-item">
                                        <a href="{{ url($submenus2->route) }}" class="nav-link {{ request()->is(ltrim($submenus2->route, '/')) ? 'active' : '' }}">
                                            <i class="far fa-dot-circle nav-icon"></i>
                                            {{$submenus2->sub_menu_name}}
                                        </a>
                                    </li>
                                @endforeach

                            </ul>

                        </li>

                    {{-- IF submenu2 NOT EXISTS --}}
                    @else

                        <li class="nav-item">
                            <a href="{{ url($submenus->route) }}" class="nav-link {{ request()->is(ltrim($submenus->route, '/')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                {{$submenus->sub_menu_name}}
                            </a>
                        </li>

                    @endif

                @endif

            @endforeach

        </ul>

    </li>

    @endif

@endforeach
