<aside id="nav-container" class="nav-container" data-ng-class=" {'nav-fixed': admin.fixedSidebar, 'nav-horizontal': admin.menu === 'horizontal', 'nav-vertical': admin.menu === 'vertical'}">
    <div class="nav-wrapper">
        <ul id="nav"
            class="nav"
            data-ng-controller="NavCtrl"
            data-slim-scroll
            data-collapse-nav
            data-highlight-active>

            <li><a href="{{URL::to('/')}}"> <i class="fa fa-dashboard"></i><span data-i18n="Dashboard"></span> </a></li>
            <li><a href="{{URL::to('affiliates')}}"> <i class="fa fa-users"></i><span data-i18n="Affiliates"></span> </a></li>
            <li><a href="{{URL::to('affiliates/add')}}"> <i class="fa fa-user"></i><span data-i18n="Add Affiliate"></span> </a></li>
            <li><a href="{{URL::to('products')}}"> <i class="glyphicon glyphicon-briefcase"></i><span data-i18n="Products"></span> </a></li>
            <li><a href="{{URL::to('profile')}}"> <i class="fa fa-gear"></i><span data-i18n="My Account"></span> </a></li>
            @if(Auth::user()->hasRole('admin'))
            <li><a href="{{URL::to('admin/users')}}"> <i class="fa fa-users"></i><span data-i18n="Users"></span> </a></li>
            <!--<li><a href="{{URL::to('admin/user_roles')}}"> <i class="fa fa-users"></i><span data-i18n="User Roles"></span> </a></li>-->
            @endif
            <li><a href="{{URL::to('auth/logout')}}"> <i class="fa fa-sign-out"></i><span data-i18n="Log out"></span> </a></li>
        </ul>
    </div>
</aside>