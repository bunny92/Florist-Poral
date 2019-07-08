<nav class="navbar navbar-transparent navbar-absolute">
    <div class="container-fluid">
        <div class="navbar-minimize">
            <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
                <i class="material-icons visible-on-sidebar-regular">more_vert</i>
                <i class="material-icons visible-on-sidebar-mini">view_list</i>
            </button>
        </div>
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"></a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
               
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                        <p>
                            Flowers
                            <b class="caret"></b>
                        </p>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?= base_url() ?>flowers">Add Flowers</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo base_url() ?>login/logout">
                        <i class="material-icons">lock</i>
                        <p class="hidden-lg hidden-md">Sign out</p>
                    </a>
                </li>
                 <li>
                    <a href="#">
                        <i class="material-icons">access_time</i>
                        <span class="text-success" id="time" style="font-size: 1.3em;"></span>
                    </a>

                </li>
                <li class="separator hidden-lg hidden-md"></li>
            </ul>
        </div>
    </div>
</nav>