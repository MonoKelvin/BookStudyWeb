<?php
if (!session_id()) {
    session_start();
}

global $admin_name;
global $admin_avatar;
if (isset($_SESSION['name']) && isset($_SESSION['avatar'])) {
    $admin_name = $_SESSION['name'];
    $admin_avatar = $_SESSION['avatar'];
}

?>

<nav class="side-navbar">
    <div class="sidebar-header d-flex align-items-center">
        <img src=<?php echo "'$admin_avatar'"; ?> alt="..." class="side-navbar-avatar">
        <div class="title">
            <h1 class="h4">管理员</h1>
            <p><?php echo $admin_name; ?></p>
        </div>
    </div>
    <span class="heading">导航</span>
    <ul class="list-unstyled">
        <?php
        outputCurrentActivePage('index.php', '<i class="fa fa-database"></i>数据统计</a>');
        outputCurrentActivePage('book_manager.php', '<i class="fa fa-book"></i>图书管理</a>');
        outputCurrentActivePage('user_manager.php', '<i class="fa fa-user"></i>用户管理</a>');

        function outputCurrentActivePage($page_name, $contents)
        {
            if ($_SERVER['SCRIPT_NAME'] == "/$page_name") {
                echo '<li class="active">';
            } else {
                echo '<li>';
            }
            echo "<a class='p-4' href=$page_name>" . $contents . "</li>";
        }
        ?>
        <li><a class="p-4" href="login_page.php"> <i class="fa fa-sign-in"></i>登陆页面</a></li>
    </ul>
</nav>
