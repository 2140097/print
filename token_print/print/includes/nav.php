<header>
    <nav id='top_nav'>
        <ul>
            <?php
                if(isset($_SESSION['auth'])){
                    $auth_type = $_SESSION['auth'];
                    if($auth_type == 'admin'){
                        echo "<li style='float: left; color: white'>Logged in as Admin</li>";
                        echo "<li><a href='../pages/change_pw.php'>Settings</a></li>";
                    }else if($auth_type == 'printing staff'){
                        echo "<li style='float: left; color: white'>Logged in as Staff</li>";
                        echo "<li><a href='../pages/change_pw.php'>Settings</a></li>";
                    }else if($auth_type == 'client'){
                        echo "<li style='float: left; color: white'>Logged in as Client</li>";
                        echo "<li><a href='../pages/change_pw.php'>Settings</a></li>";
                    }
                }
            ?>
            <?php
                if(isset($_SESSION['uid'])){
                    echo "<li><a href='../process/logout.php'>Logout</a></li>";
                }
            ?>
        </ul>
    </nav>
    <nav id='side_nav'>
        <?php
            if(isset($_SESSION['auth'])){
                $auth_type = $_SESSION['auth'];
                if($auth_type == 'admin'){
                    echo "<ul>
                    <li><a href='../pages/listrequest.php'>Requests</a></li>
                    <li><a href='../pages/userlist.php'>User List</a></li>
                    <li><a href='../pages/reports.php'>Reports</a></li>
                    </ul>";
                }else if($auth_type == 'printing staff'){
                    //do nothing
                }else if($auth_type == 'client'){
                    echo "<ul>
                    <li><a href='../pages/client_request_list.php'>Requests</a></li>
                    <li><a href='../process/chkb.php'>Check balance</a></li>
                    <li><a href='../pages/request.php'>Request print</a></li>
                    </ul>";
                }
            }
        ?>
    </nav>
</header>