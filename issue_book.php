<?php
include "connection.php";
include "admin_navbar.php";
$res1 = mysqli_query($db, "SELECT * FROM authors");
$res2 = mysqli_query($db, "SELECT * FROM category");
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Book</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
<body>
    <div class="edit-profile-container">
        <?php
        $studentid = $_GET['ed'];
        $bookid = $_GET['ed1'];

        $q = "SELECT student.studentid, FullName, studentpic, issueinfo.bookid, books.bookname, ISBN, price, bookpic, issuedate, returndate, approve, authors.authorname, category.categoryname 
              FROM issueinfo 
              INNER JOIN student ON issueinfo.studentid = student.studentid 
              INNER JOIN books ON issueinfo.bookid = books.bookid 
              INNER JOIN authors ON authors.authorid = books.authorid 
              INNER JOIN category ON category.categoryid = books.categoryid 
              WHERE student.studentid = $studentid 
                AND approve='' 
<?php
                AND issueinfo.bookid = $bookid";
        $res = mysqli_query($db, $q) or die(mysqli_error($db));

        $row = mysqli_fetch_assoc($res);

        $studentid = $row['studentid'];
        $studentpic = $row['studentpic'];
        $FullName = $row['FullName'];
        $bookid = $row['bookid'];
        $bookpic = $row['bookpic'];
        $bookname = $row['bookname'];
        $authorname = $row['authorname'];
        $categoryname = $row['categoryname'];
        $ISBN = $row['ISBN'];
        $price = $row['price'];
        ?>
        <div class="form form-book">
            <div class="form-container edit-form-container issue-book-container edit-book-container">
                <div class="form-btn">
                    <span style="width: 100%;">Issue Book</span>
                    <hr id="indicator" class="add-author">
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="label">
                        <?php echo "<img width='50px' height='50px' src='images/".$studentpic."'>"?>
                    </div>
                    <div class="label">
                        <label>Student ID :</label>
                        <b><?php echo $studentid; ?></b>
                    </div> 
                    <div class="label">
                        <label>Full Name :</label>
                        <b><?php echo $FullName; ?></b>
                    </div> 
                    <div class="label">
                        <?php echo "<img width='50px' height='50px' src='images/".$bookpic."'>"?>
                    </div>
                    <div class="label">
                        <label>Book ID :</label>
                        <b><?php echo $bookid; ?></b>
                    </div> 
                    <div class="label">
                        <label>Book Name :</label>
                        <b><?php echo $bookname; ?></b>
                    </div>
                    <div class="label">
                        <label>Author Name :</label>
                        <b><?php echo $authorname; ?></b>
                    </div>
                    <div class="label">
                        <label>Category Name :</label>
                        <b><?php echo $categoryname; ?></b>
                    </div>
                    <div class="label">
                        <label>ISBN :</label>
                        <b><?php echo $ISBN; ?></b>
                    </div>
                    <div class="label">
                        <label>Price :</label>
                        <b><?php echo $price; ?></b>
                    </div>
                    <input type="text" name="approve" placeholder="Approve">
                    <div class="label">
                        <label>Issue Date :</label>
                    </div>
                    <input type="date" name="issuedate">
                    <div class="label">
                        <label>Return Date :</label>
                    </div>
                    <input type="date" name="returndate">
                    <button type="submit" class="btn" name="submit" style="margin-top: 20px;">Issue</button> 
                </form>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        $approve = $_POST['approve'];
        $issuedate = $_POST['issuedate'];
        $returndate = $_POST['returndate'];

        // Call stored procedure instead of manual query
        $proc = "CALL IssueBookProc('$studentid', '$bookid', '$issuedate', '$returndate', '$approve')";
        if (mysqli_query($db, $proc)) {
            echo "<script>alert('Book issued successfully.');window.location='request_info.php';</script>";
        } else {
            echo "<script>alert('Error issuing book.');</script>";
        }
    }
    ?>
</body>
</html>
