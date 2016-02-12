<div id="header" class="header-container" data-ng-class=" {'header-fixed': admin.fixedHeader} " data-ng-controller="HeaderCtrl">
<header class="top-header clearfix">

<!-- Logo -->
<div class="logo" style="padding: 5px 15px 5px 15px;">
    <a href="#/">
        <img src="/assets/images/logo2-small.png" class="img-responsive ">
    </a>
</div>

<!-- needs to be put after logo to make it working-->
<div class="menu-button" toggle-off-canvas>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
</div>

<div class="top-nav">

<ul class="nav-left list-unstyled">
    <li>
        <a href="#/" data-toggle-nav-collapsed-min
           class="toggle-min"
           id="step4"
            ><i class="fa fa-bars"></i></a>
    </li>
    <!--
    <li class="dropdown hidden-xs">
        <a href="javascript:;" class="dropdown-toggle" id="step1" data-toggle="dropdown"><i class="fa fa-cogs"></i></a>
        <div class="dropdown-menu with-arrow panel panel-default admin-options" ui-not-close-on-click>
            <div class="panel-heading"> Admin Options </div>
            <ul class="list-group">
                <li class="list-group-item">
                    <p>Layouts Style</p>
                    <label class="ui-radio"><input name="layout" type="radio" value="boxed" ng-model="admin.layout"><span>Boxed</span></label>
                    <label class="ui-radio"><input name="layout" type="radio" value="wide" ng-model="admin.layout"><span>Wide</span></label>
                </li>
                <li class="list-group-item">
                    <p>Menu Style</p>
                    <label class="ui-radio"><input name="menu" type="radio" value="vertical" ng-model="admin.menu"><span>Vertical</span></label>
                    <label class="ui-radio"><input name="menu" type="radio" value="horizontal" ng-model="admin.menu"><span>Horizontal</span></label>
                </li>
                <li class="list-group-item">
                    <p>Additional</p>
                    <label class="ui-checkbox"><input name="checkbox1" type="checkbox" value="option1" ng-model="admin.fixedHeader"><span>Fixed Top Header</span></label>
                    <br>
                    <label class="ui-checkbox"><input name="checkbox1" type="checkbox" value="option1" ng-model="admin.fixedSidebar"><span>Fixed Sidebar Menu</span></label>
                </li>
            </ul>
        </div>
    </li>
    -->
</ul>

<ul class="nav-right pull-right list-unstyled">
    <!--

    <li class="dropdown">
    <a href="javascript:;" class="dropdown-toggle bg-info" data-toggle="dropdown">
        <i class="fa fa-comment-o"></i>
        <span class="badge badge-info">2</span>
    </a>
    <div class="dropdown-menu pull-right with-arrow panel panel-default">
        <div class="panel-heading">
            You have 2 messages.
        </div>
        <ul class="list-group">
            <li class="list-group-item">
                <a href="javascript:;" class="media">
                    <span class="media-left media-icon">
                        <span class="round-icon sm bg-info"><i class="fa fa-comment-o"></i></span>
                    </span>
                    <div class="media-body">
                        <span class="block">Jane sent you a message</span>
                        <span class="text-muted">3 hours ago</span>
                    </div>
                </a>
            </li>
            <li class="list-group-item">
                <a href="javascript:;" class="media">
                    <span class="media-left media-icon">
                        <span class="round-icon sm bg-danger"><i class="fa fa-comment-o"></i></span>
                    </span>
                    <div class="media-body">
                        <span class="block">Lynda sent you a mail</span>
                        <span class="text-muted">9 hours ago</span>
                    </div>
                </a>
            </li>
        </ul>
        <div class="panel-footer">
            <a href="javascript:;">Show all messages.</a>
        </div>
    </div>
    </li>
    -->
    <li class="dropdown">
        <a href="javascript:;" class="dropdown-toggle bg-success" data-toggle="dropdown">
            <i class="fa fa-envelope-o"></i>
            <span class="badge badge-info">3</span>
        </a>
        <div class="dropdown-menu pull-right with-arrow panel panel-default">
            <div class="panel-heading">
                You have 3 mails.
            </div>
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="javascript:;" class="media">
                                <span class="media-left media-icon">
                                    <span class="round-icon sm bg-warning"><i class="fa fa-envelope-o"></i></span>
                                </span>
                        <div class="media-body">
                            <span class="block">Lisa sent you a mail</span>
                            <span class="text-muted block">2min ago</span>
                        </div>
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="javascript:;" class="media">
                                <span class="media-left media-icon">
                                    <span class="round-icon sm bg-info"><i class="fa fa-envelope-o"></i></span>
                                </span>
                        <div class="media-body">
                            <span class="block">Jane sent you a mail</span>
                            <span class="text-muted">3 hours ago</span>
                        </div>
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="javascript:;" class="media">
                                <span class="media-left media-icon">
                                    <span class="round-icon sm bg-success"><i class="fa fa-envelope-o"></i></span>
                                </span>
                        <div class="media-body">
                            <span class="block">Lynda sent you a mail</span>
                            <span class="text-muted">9 hours ago</span>
                        </div>
                    </a>
                </li>
            </ul>
            <div class="panel-footer">
                <a href="javascript:;">Show all mails.</a>
            </div>
        </div>
    </li>
    <li class="dropdown">
        <a href="javascript:;" class="dropdown-toggle bg-warning" data-toggle="dropdown">
            <i class="fa fa-bell-o nav-icon"></i>
            <span class="badge badge-info">3</span>
        </a>
        <div class="dropdown-menu pull-right with-arrow panel panel-default">
            <div class="panel-heading">
                You have 3 notifications.
            </div>
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="javascript:;" class="media">
                                <span class="media-left media-icon">
                                    <span class="round-icon sm bg-success"><i class="fa fa-bell-o"></i></span>
                                </span>
                        <div class="media-body">
                            <span class="block">New tasks needs to be done</span>
                            <span class="text-muted block">2min ago</span>
                        </div>
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="javascript:;" class="media">
                                <span class="media-left media-icon">
                                    <span class="round-icon sm bg-info"><i class="fa fa-bell-o"></i></span>
                                </span>
                        <div class="media-body">
                            <span class="block">Change your password</span>
                            <span class="text-muted">3 hours ago</span>
                        </div>
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="javascript:;" class="media">
                                <span class="media-left media-icon">
                                    <span class="round-icon sm bg-danger"><i class="fa fa-bell-o"></i></span>
                                </span>
                        <div class="media-body">
                            <span class="block">New feature added</span>
                            <span class="text-muted">9 hours ago</span>
                        </div>
                    </a>
                </li>
            </ul>
            <div class="panel-footer">
                <a href="javascript:;">Show all notifications.</a>
            </div>
        </div>
    </li>
    <li class="dropdown">
        <a href="javascript:;" class="dropdown-toggle bg-primary" data-toggle="dropdown">
            <i class="fa fa-user nav-icon"></i>
            <span class="badge badge-info"></span>
        </a>
        <div class="dropdown-menu pull-right with-arrow panel panel-default">
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="{{ URL::to('profile') }}" class="media">
                        <div class="media-body">
                            <span class="block">My Profile</span>
                        </div>
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="{{ URL::to('auth/logout') }}" class="media">
                        <div class="media-body">
                            <span class="block">Log out</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </li>
</ul>


</div>

</header>

</div>
