<?php
    include("dbh.php");
    
    if(!isset($_SESSION['email'])){
        header('location: login.php');
    }
?>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>iResponse - Dashboard</title>
    
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <!-- icon-->
    <link rel="icon" href="./assets/img/favicon.png" sizes="16x16">

    <!-- LeafLet -->
    <script src="./js/leaflet/leaflet.js"></script>
    <script src="./js/leaflet/mapbox-gl.js"></script>
    <script src="./js/leaflet/leaflet-mapbox-gl.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.3/leaflet.css" />
    <link rel="stylesheet" href="./css/mapbox-gl.css" />

    <!--Vue Support-->
    <script src="./js/vue/vue.min.js"></script>

    <!-- Axios -->
    <script src="./js/vue/axios.min.js"></script>

    <style>
        .sb-sidenav-menu {
            background-color: #468b48;
        }

        .sb-sidenav-dark .sb-sidenav-menu .nav-link {
            color: rgba(255, 255, 255);
        }

        .sb-sidenav-dark .sb-sidenav-menu .nav-link .sb-nav-link-icon {
            color: rgba(255, 255, 255);
        }

        .sb-sidenav-dark .sb-sidenav-menu .sb-sidenav-menu-heading {
            color: rgba(255, 255, 255);
        }

        .sb-sidenav-dark .sb-sidenav-footer {
            background-color: #468b48;
        }
    </style>
</head>