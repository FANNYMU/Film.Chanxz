<style>
        .sidenav {
        height: 100%;
        width: 250px;
        position: fixed;
        z-index: 1;
        top: 0;
        left: -250px;
        background-color: #111;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
    }

    .sidenav a {
        padding: 10px 15px;
        text-decoration: none;
        font-size: 18px;
        color: #818181;
        display: block;
        transition: 0.3s;
    }

    .sidenav a:hover {
        color: #f1f1f1;
    }

    .sidenav .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
    }

    #main {
        transition: margin-left .5s;
        padding: 16px;
    }

    .content {
        margin-left: 250px;
        padding: 20px;
    }
</style>

<!-- Sidebar -->
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="../Streaming/index.php">Home</a>
    <a href="../Streaming/upload.php">Upload</a>
    <a href="../Streaming/login.php">Login</a>
    <a href="../Streaming/register.php">Register</a>
</div>

<!-- Konten utama -->
<script>
    // Fungsi untuk membuka sidebar
    function openNav() {
        document.getElementById("mySidenav").style.left = "0";
        document.getElementById("main").style.marginLeft = "250px";
    }

    // Fungsi untuk menutup sidebar
    function closeNav() {
        document.getElementById("mySidenav").style.left = "-250px";
        document.getElementById("main").style.marginLeft= "0";
    }
</script>
