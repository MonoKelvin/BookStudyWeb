<?php
// session_start();

global $admin_name;
global $admin_avatar;
if (isset($_SESSION['name']) && isset($_SESSION['avatar'])) {
    $admin_name = $_SESSION['name'];
    $admin_avatar = $_SESSION['avatar'];
}

?>

<!-- Side Navbar -->
<nav class="side-navbar">
    <!-- Sidebar Header-->
    <div class="sidebar-header d-flex align-items-center">
        <div class="avatar"><img src=<?php echo "'$admin_avatar'"; ?> alt="..." class="img-fluid rounded-circle"></div>
        <div class="title">
            <h1 class="h4">管理员</h1>
            <p><?php echo $admin_name; ?></p>
        </div>
    </div>
    <!-- Sidebar Navidation Menus-->
    <span class="heading">导航</span>
    <ul class="list-unstyled">
        <?php
        outputCurrentActivePage('index.php', '<i class="icon-home"></i>主页</a>');
        outputCurrentActivePage('book_manager.php', '<i class="icon-grid"></i>图书管理</a>');
        outputCurrentActivePage('user_manager.php', '<i class="fa fa-bar-chart"></i>用户管理</a>');

        function outputCurrentActivePage($page_name, $contents)
        {
            global $cur_page;
            if ($cur_page == "/$page_name") {
                echo '<li class="active">';
            } else {
                echo '<li>';
            }
            echo "<a href=$page_name>" . $contents . "</li>";
        }
        ?>
        <li><a href="login_page.php"> <i class="icon-interface-windows"></i>登陆页面</a></li>
    </ul>
</nav>
