@foreach ($menu as $item=>$value)

@foreach($data as $ddata)

@if($value->user_group_id==$ddata->user_group_id)
<li class="nav-item d-sm-inline-block has-treeview menu-close" style="font-size:14px; color:white;" id="menu">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt fa-lg"></i>
        <p>{{$value->title}} <i class="right fas fa-angle-left"></i></p>
    </a>

    <ul class="nav nav-treeview">
        @foreach($submenu as $submenus)
        @if($value->menu_item_id==$submenus->menu_item_id)
        <li class="nav-item has-treeview menu-close ">
            <a href="{{$submenus->route}}" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                {{$submenus->sub_menu_name}}<i class="right fas fa-angle-left"></i>
            </a>



            <ul class="nav nav-treeview">
                <div class="test1">

                    @foreach($submenu2 as $submenus2)
                    @if($submenus->sub_menu_id==$submenus2->sub_menu_2)
                    <li class="nav-item has-treeview menu-close " style="margin-left: 10px;"id="menu2">

                        <a href="{{$submenus2->route}}" class="nav-link active">
                            <i class="far fa-circle nav-icon"></i>
                            {{$submenus2->sub_menu_name}}<i class="right fas fa-angle-left"></i>
                        </a>



                    </li>
                    @endif

                    @endforeach
                </div>
            </ul>


        </li>
        @endif

        @endforeach
    </ul>
</li>
@endif

@endforeach

@endforeach