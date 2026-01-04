<?php

	include "connection.php";
    include "student_navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <style>
        /* Modern Table Styling */
        .rtable {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
        }
        
        .rtable tr {
            transition: all 0.3s ease;
        }
        
        .rtable th {
            text-align: left;
            color: white;
            padding: 16px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-weight: 600;
            font-size: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .rtable td {
            padding: 16px 20px;
            border-bottom: 1px solid #e5e7eb;
            color: #374151;
            font-size: 14px;
        }
        
        .rtable tr:hover {
            background-color: #f3f4f6;
            transform: scale(1.01);
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.1);
        }
        
        .rtable tr:last-child td {
            border-bottom: none;
        }
        
        /* Action Buttons */
        .actionbtn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s ease;
            margin-right: 8px;
        }
        
        .actionbtn:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        
        .delbtn {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s ease;
        }
        
        .delbtn:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }
        
        .authortable th:last-child {
            padding-left: 20px;
        }
    </style>
</head>
<body>
    <div class="request-table">
        <div class="request-container">
            <h2 class="request-title">List of Requested Books</h2>
            <?php
	    if(isset($_SESSION['login_student_username']))
		{

			$q1=mysqli_query($db,"SELECT studentid from student where studentid='$_SESSION[studentid]';");
		    $row=mysqli_fetch_assoc($q1);

			$q=mysqli_query($db,"SELECT books.bookpic,books.bookid,books.bookname,books.ISBN,books.price,books.quantity,authors.authorname,category.categoryname from  `issueinfo` join `books` on issueinfo.bookid=books.bookid join `student`on student.studentid=issueinfo.studentid join authors on authors.authorid=books.authorid join category on category.categoryid=books.categoryid where student.studentid ='$_SESSION[studentid]' and issueinfo.approve=''; ");
			if(mysqli_num_rows($q)==0)
			{
				echo "There's no pending request";
			}
			else
			{
				echo "<table class='rtable'>";
                echo "<tr style='background-color: teal;'>";
                //Table header
                // echo "<th>"; echo "Book ID"; echo "</th>";
                echo "<th>"; echo "Books"; echo "</th>";
                echo "<th>"; echo "Author Name"; echo "</th>";
                echo "<th>"; echo "Category Name"; echo "</th>";
                echo "<th>"; echo "ISBN"; echo "</th>";
                // echo "<th>"; echo "Issue Date"; echo "</th>";
                // echo "<th>"; echo "Return Date"; echo "</th>";
                // echo "<th>"; echo "Approve Status"; echo "</th>";
                echo "</tr>";

                while($row=mysqli_fetch_assoc($q))
                {
                    echo "<tr>";
                    // echo "<td>"; echo $row['bookid']; echo "</td>";
                    echo "<td>
                    <div class='table-info'>
                        <img src='images/".$row['bookpic']."'>
                        <div>
                            <p>";echo $row['bookname'];echo"</p>
                            <small>Price: ";echo $row['price'];echo" Tk.</small><br>";?>
                            <a href="?req=<?php echo $row['bookid'];?>"><button type='submit' name='remove'>Remove</button></a>
                        </div>
                    </div>
                    </td><?php
                    echo "<td>"; echo $row['authorname']; echo "</td>";
                    echo "<td>"; echo $row['categoryname']; echo "</td>";
                    echo "<td>"; echo $row['ISBN']; echo "</td>";
                    // echo "<td>"; echo $row['issuedate']; echo "</td>";
                    // echo "<td>"; echo $row['returndate']; echo "</td>";
                    // echo "<td>"; echo $row['approve']; echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                }
            }

            ?>
        </div>
    </div>
    <!-- <div class="footer">
        <div class="footer-row">
            <div class="footer-left">
                <h1>Opening Hours</h1>
                <p><i class="far fa-clock"></i>Monday to Friday - 9am to 9pm</p>
                <p><i class="far fa-clock"></i>Saturday to Sunday - 8am to 11pm</p>
            </div>
            <div class="footer-right">
                <h1>Get In Touch</h1>
                <p>#30 abc Colony, xyz City IN<i class="fas fa-map-marker-alt"></i></p>
                <p>example@website.com<i class="fas fa-paper-plane"></i></p>
                <p>+8801515637957<i class="fas fa-phone-alt"></i></p>
            </div>
        </div>
        <div class="social-links">
            <i class="fab fa-facebook-f"></i>
            <i class="fab fa-twitter"></i>
            <i class="fab fa-instagram-square"></i>
            <i class="fab fa-youtube"></i>
            <p>&copy; 2021 Copyright by Nazre Imam Tahmid</p>
        </div>
    </div> -->
    <?php
    if(isset($_GET['req']))
	{
		$id=$_GET['req'];
		mysqli_query($db,"DELETE FROM issueinfo where bookid=$id AND studentid = '$_SESSION[studentid]' AND approve=' ';");
        $res=mysqli_query($db,"SELECT quantity from books where bookid=$id;");
		while($row=mysqli_fetch_assoc($res))
		{
			if($row['quantity']==0)
			{
				mysqli_query($db,"UPDATE books SET quantity=quantity+1, status='Available' where bookid=$id;");
			}
			else
			{
				mysqli_query($db,"UPDATE books SET quantity=quantity+1 where bookid=$id;");
			}
			
		}
		?>	
		<script type="text/javascript">
			alert("Request Deleted successfully.");
			
		</script>
		<script type="text/javascript">
			window.location="request_book.php";
	    </script>
		<?php
	}
	?>
</body>
</html>