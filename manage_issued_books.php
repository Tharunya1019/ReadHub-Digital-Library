<?php
include "connection.php";
include "admin_navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Issued Books</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
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
    <style>
        .fine-amount { color: red; font-weight: bold; }
        .no-fine { color: green; }
        .overdue { background-color: #ffebee; }
        .table-info img { width: 50px; height: 50px; border-radius: 10px; margin-right: 10px; }
        .table-info { display: flex; align-items: center; }
        .table-info p { margin: 0; }
    </style>
</head>
<body>
    <div class="request-container book-container" style="max-width:1600px;">
        <h2>Information of Issued Books</h2>

        <table class="rtable booktable">
            <tr style="background-color: teal; color: white;">
                <th>Student</th>
                <th>Book</th>
                <th>Issue Date</th>
                <th>Return Date</th>
                <th>Status</th>
                <th>Fine</th>
                <th>Action</th>
            </tr>

            <?php
            $query = "SELECT 
                        s.studentid, s.FullName, s.studentpic,
                        b.bookid, b.bookname, b.bookpic,
                        i.issuedate, i.returndate, i.approve, i.fine
                    FROM issueinfo i
                    JOIN student s ON s.studentid = i.studentid
                    JOIN books b ON b.bookid = i.bookid
                    ORDER BY i.returndate ASC";

            $result = mysqli_query($db, $query);

            if (mysqli_num_rows($result) == 0) {
                echo "<tr><td colspan='7'>No issued books found.</td></tr>";
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    $today = date("Y-m-d");
                    $overdue = ($today > $row['returndate'] && $row['approve'] != 'Returned');
                    $row_class = $overdue ? 'overdue' : '';
            ?>
                <tr class="<?php echo $row_class; ?>">
                    <td>
                        <div class="table-info">
                            <img src="images/<?php echo $row['studentpic']; ?>" alt="Student">
                            <div>
                                <p><strong><?php echo $row['FullName']; ?></strong></p>
                                <p>ID: <?php echo $row['studentid']; ?></p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="table-info">
                            <img src="images/<?php echo $row['bookpic']; ?>" alt="Book">
                            <div>
                                <p><strong><?php echo $row['bookname']; ?></strong></p>
                                <p>ID: <?php echo $row['bookid']; ?></p>
                            </div>
                        </div>
                    </td>
                    <td><?php echo $row['issuedate']; ?></td>
                    <td><?php echo $row['returndate']; ?></td>
                    <td><?php echo $row['approve']; ?></td>
                    <td>
                        <?php 
                        if ($row['fine'] > 0) {
                            echo "<span class='fine-amount'>Rs. " . $row['fine'] . "</span>";
                        } else {
                            echo "<span class='no-fine'>No Fine</span>";
                        }
                        ?>
                    </td>
                    <td>
                        <?php if ($row['approve'] != 'Returned') { ?>
                            <a href="return_book.php?studentid=<?php echo $row['studentid']; ?>&bookid=<?php echo $row['bookid']; ?>" 
                               onclick="return confirm('Confirm to mark as Returned?');">
                                <button class="btn btn-success">Return</button>
                            </a>
                        <?php } else { ?>
                            <span class="badge badge-success">Returned</span>
                        <?php } ?>
                    </td>
                </tr>
            <?php
                }
            }
            ?>
        </table>
    </div>
</body>
</html>
