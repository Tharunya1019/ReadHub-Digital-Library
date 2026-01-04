<?php

	include "connection.php";
    include "admin_navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
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
        
        /* Table Info Styling */
        .table-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .table-info img {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            object-fit: cover;
            border: 3px solid #e5e7eb;
            transition: all 0.3s ease;
        }
        
        .rtable tr:hover .table-info img {
            border-color: #667eea;
            transform: scale(1.05);
        }
        
        .table-info div p {
            margin: 2px 0;
            font-weight: 500;
        }
        
        .table-info div p:first-child {
            color: #667eea;
            font-weight: 600;
            font-size: 13px;
        }
        
        .table-info div p:last-child {
            color: #111827;
            font-size: 15px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="search-bar admin-search">
        <form action="" method='post'>
            <input type="search" name='search' placeholder='Search by Student ID' required>
            <button type='submit' name='submit'><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div class="request-table">
        <div class="request-container">
            <h2 class="request-title student-info-title">List of Students</h2>
            <?php

		if(isset($_POST['submit']))
		{
			$q=mysqli_query($db,"SELECT studentid,FullName,Email,PhoneNumber,studentpic FROM  `student` where studentid ='$_POST[search]';");
			if(mysqli_num_rows($q)==0)
			{
				echo "Sorry! No student found. Try searching again";

			}
			else
			{
				echo "<table class='rtable'>";
                echo "<tr>";
                //Table header
                echo "<th>"; echo "Students"; echo "</th>";
                // echo "<th>"; echo "Full Name"; echo "</th>";
                echo "<th>"; echo "Email"; echo "</th>";
                echo "<th>"; echo "Phone Number"; echo "</th>";
                echo "</tr>";

                while($row=mysqli_fetch_assoc($q))
                {
                    echo "<tr>";
                    // echo "<td>"; echo $row['studentid']; echo "</td>";
                    // echo "<td>"; echo $row['FullName']; echo "</td>";
                    echo "<td>
                    <div class='table-info'>
                        <img src='images/".$row['studentpic']."'>
                        <div>
                            <p>Student ID: ";echo $row['studentid'];echo"</p>
                            <p>";echo $row['FullName'];echo"</p><br>";?>
                        </div>
                    </div>
                    </td><?php
                    echo "<td>"; echo $row['Email']; echo "</td>";
                    echo "<td>"; echo $row['PhoneNumber']; echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
		    }
		}
			//if button is not pressed
		else
		{
			$res=mysqli_query($db,"SELECT studentid,FullName,Email,PhoneNumber,studentpic FROM `student`;");
            echo "<table class='rtable'>";
            echo "<tr>";
            //Table header
            echo "<th>"; echo "Students"; echo "</th>";
            // echo "<th>"; echo "Full Name"; echo "</th>";
            echo "<th>"; echo "Email"; echo "</th>";
            echo "<th>"; echo "Phone Number"; echo "</th>";
            echo "</tr>";

            while($row=mysqli_fetch_assoc($res))
            {
                echo "<tr>";
                echo "<td>
                    <div class='table-info'>
                        <img src='images/".$row['studentpic']."'>
                        <div>
                            <p>Student ID: ";echo $row['studentid'];echo"</p>
                            <p>";echo $row['FullName'];echo"</p><br>";?>
                        </div>
                    </div>
                    </td><?php
                echo "<td>"; echo $row['Email']; echo "</td>";
                echo "<td>"; echo $row['PhoneNumber']; echo "</td>";
                echo "</tr>";
            }
            echo "</table>";

            }
        ?> 
        </div>
    </div>
    
</body>
</html>