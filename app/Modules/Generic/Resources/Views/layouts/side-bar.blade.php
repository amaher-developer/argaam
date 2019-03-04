{{-- get the identifier of from the route--}}
@php
    $identifier = request()->segment(2);
@endphp

{{--@permission(['super'])--}}
    {{--<li aria-haspopup="true" class="start">--}}
        {{--<a href="{{route('listModules')}}" class="nav-link nav-toggle">--}}
            {{--<i class="icon-folder"></i>--}}
            {{--<span class="title">Modules </span>--}}
            {{--@if($migrate)<span class="title" style="   font-weight: bold;   font-size: 14px;   color: red;">(migrate) </span>@endif--}}
        {{--</a>--}}
    {{--</li>--}}
{{--@endpermission--}}

{{--@permission(['super'])--}}
    {{--<li aria-haspopup="true" class="start">--}}
        {{--<a href="{{url('telescope')}}" class="nav-link nav-toggle" target="_blank">--}}
            {{--<i class="icon-ghost"></i>--}}
            {{--<span class="title">Telescope </span>--}}
        {{--</a>--}}
    {{--</li>--}}
{{--@endpermission--}}


@permission(['super','user-index','admin-index','role-index'])
    <li aria-haspopup="true"
        class="menu-dropdown classic-menu-dropdown {{ in_array($identifier,['role','admin','user'])  ? 'font-green' : '' }}">
        <a href="javascript:;" class="{{ in_array($identifier,['role','admin','user'])  ? 'font-green' : '' }}">
            <i class="icon-users"></i> Access
        </a>
        <ul class="dropdown-menu">
            {{--@permission(['super','role-index'])--}}
                {{--<li aria-haspopup="true" class="{{ in_array($identifier,['role'])  ? 'font-green' : '' }}">--}}
                    {{--<a href="{{route('listRoles')}}" class="nav-link ">--}}
                        {{--<i class="icon-arrow-right "></i>--}}
                        {{--<span class="title">Roles</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--@endpermission--}}


            @permission(['super','admin-index'])
                <li aria-haspopup="true" class="{{ in_array($identifier,['admin'])  ? 'font-green' : '' }}">
                    <a href="{{route('listAdmins')}}" class="nav-link ">
                        <i class="icon-arrow-right "></i>
                        <span class="title">Users</span>
                    </a>
                </li>
            @endpermission


            @permission(['super','user-index'])

                {{--<li aria-haspopup="true" class=" {{ in_array($identifier,['user'])  ? 'font-green' : '' }}">--}}
                    {{--<a href="{{route('listUser')}}?limit=10" class="nav-link ">--}}
                        {{--<i class="icon-user"></i>--}}
                        {{--<span class="title">Customers</span>--}}
                    {{--</a>--}}
                {{--</li>--}}

            @endpermission
        </ul>
    </li>
@endpermission





@permission(['super','user-index','admin-index','role-index'])
    {{--<li aria-haspopup="true"--}}
        {{--class="menu-dropdown classic-menu-dropdown {{ in_array($identifier,['setting','notification','dashboard'])  ? 'font-green' : '' }}">--}}
        {{--<a href="javascript:;"--}}
           {{--class="{{ in_array($identifier,['setting','notification','dashboard'])  ? 'font-green' : '' }}">--}}
            {{--<i class="icon-settings"></i> General Settings--}}
        {{--</a>--}}
        {{--<ul class="dropdown-menu">--}}
            {{--@permission(['super','setting-edit'])--}}

                {{--<li aria-haspopup="true" class="{{ in_array($identifier,['setting'])  ? 'font-green' : '' }}">--}}
                    {{--<a href="{{route('editSetting',1)}}" class="nav-link ">--}}
                        {{--<i class="icon-notebook "></i>--}}
                        {{--<span class="title">Update Content</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li aria-haspopup="true" class="{{ in_array($identifier,['static-variables'])  ? 'font-green' : '' }}">--}}
                    {{--<a href="{{route('staticVariables')}}" class="nav-link ">--}}
                        {{--<i class="icon-notebook "></i>--}}
                        {{--<span class="title">Static Variables</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--@endpermission--}}


            {{--<li aria-haspopup="true" class="{{ in_array($identifier,['notification'])  ? 'font-green' : '' }}">--}}
                {{--<a href="{{route('listNotification')}}" class="nav-link nav-toggle">--}}
                    {{--<i class="icon-volume-2"></i>--}}
                    {{--<span class="title">Push Notification</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--@permission(['super','dashboard'])--}}
                {{--<li class=" {{ in_array($identifier,['dashboard'])  ? 'font-green' : '' }}">--}}
                    {{--<a href="{{route('backupDB')}}" class="nav-link ">--}}
                        {{--<i class="icon-cloud-download"></i>--}}
                        {{--<span class="title">Database backup</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--@endpermission--}}

        {{--</ul>--}}
    {{--</li>--}}
@endpermission


@permission(['super','article-index','category-index','image-index'])
<li aria-haspopup="true"
    class="menu-dropdown classic-menu-dropdown {{ in_array($identifier,['article','category','image'])  ? 'font-green' : '' }}">
    <a href="javascript:;" class="{{ in_array($identifier,['article','category','image'])  ? 'font-green' : '' }}">
        <i class="icon-users"></i> Argaam
    </a>
    <ul class="dropdown-menu">
        @permission(['super','category-index'])
        <li aria-haspopup="true" class="{{ in_array($identifier,['category'])  ? 'font-green' : '' }}">
            <a href="{{route('listCategory')}}" class="nav-link ">
                <i class="icon-arrow-right "></i>
                <span class="title">Category</span>
            </a>
        </li>
        @endpermission


        @permission(['super','article-index'])
        <li aria-haspopup="true" class="{{ in_array($identifier,['article'])  ? 'font-green' : '' }}">
            <a href="{{route('listArticle')}}" class="nav-link ">
                <i class="icon-arrow-right "></i>
                <span class="title">Articles</span>
            </a>
        </li>
        @endpermission

    </ul>
</li>
@endpermission