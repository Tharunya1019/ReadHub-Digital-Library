<?php

    include "connection.php";
    include "index_navbar.php";
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReadHub | Digital Library</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="banner">
        <div class="banner-content">
            <h1>Welcome to ReadHub | Digital Library</h1>
        </div>
    </div>
    <div class="trending-books all-books">
        <div class="small-container">
            <h2 class="co-title">Trending Books</h2>
            <div class="row">
            <?php
                $res=mysqli_query($db,"SELECT books.bookid,books.bookpic,books.bookname,category.categoryname,authors.authorname,books.ISBN,books.price,quantity,status from  `books` join `category` on category.categoryid=books.categoryid join `authors` on authors.authorid=books.authorid join trendingbook on trendingbook.bookid=books.bookid;");
                while($row=mysqli_fetch_assoc($res)){
                    ?>
                    <div class="card">
                        <?php echo "<img src='images/".$row['bookpic']."'>"; ?>
                        <div class="card-body">
                            <h4 style="font-size: 18px;"><?php echo $row['bookname']; ?></h4>
                            <p style="font-size: 18px">Price: <?php echo $row['price']; ?> Tk.</p>
                            <div class="overlay"></div>
                            <div class="sub-card">
                                <p><b>Book Name: &nbsp;</b><?php echo $row['bookname']; ?></p>  
                                <p><b>Category Name: &nbsp;</b><?php echo $row['categoryname']; ?></p>
                                <p><b>Author Name: &nbsp;</b><?php echo $row['authorname']; ?></p>
                                <p><b>ISBN: &nbsp;</b><?php echo $row['ISBN']; ?></p>
                                <p><b>Quantity: &nbsp;</b><?php echo $row['quantity']; ?></p>
                                <p><b>Price:</b> <?php echo $row['price']; ?> Tk.</p> 
                                <p><b>Status: &nbsp;</b><span><?php echo $row['status']; ?></span></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            ?>
            </div>
        </div>
    </div>

   
    <div class="footer">
        <div class="footer-row">
            <div class="footer-left">
                <h1>Opening Hours</h1>
                <p><i class="far fa-clock"></i>Monday to Friday - 9am to 9pm</p>
                <p><i class="far fa-clock"></i>Saturday to Sunday - 8am to 11pm</p>
            </div>

            <div class="footer-middle">
             
                <!-- New Kandy Map -->
                <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63397.41239302644!2d80.58856843070886!3d7.294543592720654!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae3663dd8987095%3A0xd78d9a607934a9b4!2sKandy!5e0!3m2!1sen!2slk!4v1628164820407!5m2!1sen!2slk" width="600" height="200" style="border:0;" allowfullscreen="" loading="lazy" aria-hidden="false"></iframe>
            </div>

            <div class="footer-right">
                <h1>Get In Touch</h1>
                <p>ReadHub | Digital Library<i class="fas fa-map-marker-alt"></i></p>
                <p>ReadHub@.com<i class="fas fa-paper-plane"></i></p>
                <p>081 2345566<i class="fas fa-phone-alt"></i></p>
            </div>
        </div>
        <div class="social-links">
            <i class="fab fa-facebook-f"></i>
            <i class="fab fa-twitter"></i>
            <i class="fab fa-instagram-square"></i>
            <i class="fab fa-youtube"></i>
            <p>&copy; 2025 Copyright by Tharunya</p>
        </div>
    </div>

    <script>
        function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
</body>
</html>
