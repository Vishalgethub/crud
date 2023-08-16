<?php
include 'config.php';
if (isset($_POST['submit'])) {

    $name1 = $_POST['name'];
    $email1 = $_POST['email'];
    $phone1 = $_POST['phone'];
    $gender1 = $_POST['gender'];
    if (isset($_POST['hobbies']) && is_array($_POST['hobbies'])) {
        $hobbies1 = implode(', ', $_POST['hobbies']);
    } else {
        $hobbies1 = "";
    }


    $filename1 = $_FILES['up']['name'];
    $inputValue = $_POST["name"];
    if (empty($inputValue)) {
        $error = "This field is required.";
    } else {
        $source = $_FILES['up']['tmp_name'];
        $destination = "images/" . $filename1;
        $pass = move_uploaded_file($source, $destination);
        $queryfindemail = "SELECT email FROM users WHERE email = '{$email1}'";
        $resultfindemail = mysqli_query($conn, $queryfindemail);

        if (mysqli_num_rows($resultfindemail) !== 0) {
            $alert = "Email already exists!";
            echo "<script type='text/javascript'>
                alert('$alert');
                window.location.href = 'http://localhost/crud/add.php';
            </script>";
            exit;
        } else {

            // Perform the database insertion
            $query1 = "INSERT INTO users (name, email, phone, gender, hobbies, photo) VALUES ('{$name1}', '{$email1}', '{$phone1}', '{$gender1}', '{$hobbies1}', '{$destination}')";
            $result1 = mysqli_query($conn, $query1);

            if ($result1 && $pass) {
                header('Location: http://localhost/crud/add.php');
                exit;
            }
        }
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <title>ADD USER</title>
</head>

<body>


    <form action="add.php" method="post" id="myForm" enctype="multipart/form-data">

        <section class="vh-100" style="background-color: #2779e2;>
                <div class=" container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-9">

                    <h1 class="text-white mb-4">ADD USER</h1>

                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body">

                            <div class="row align-items-center pt-3 pb-3">
                                <div class="col-md-3 ps-5">
                                    <h6 class="mb-0">Full name</h6>
                                </div>
                                <div class="col-md-9 pe-5">
                                    <input type="text" name="name" id="nameInput" class="form-control form-control-lg"
                                        placeholder="Enter your name" />
                                    <span class="nameErr text-danger" style="display: none;">Name is required</span>
                                </div>
                            </div>

                            <hr class="mx-n3">

                            <div class="row align-items-center py-3">
                                <div class="col-md-3 ps-5">

                                    <h6 class="mb-0">Email</h6>

                                </div>
                                <div class="col-md-9 pe-5">

                                    <input type="email" name="email" id="emailInput"
                                        class="form-control form-control-lg" placeholder="example@example.com" />
                                    <span class="emailErr text-danger" style="display: none;">Email is
                                        required</span>


                                </div>
                            </div>

                            <hr class="mx-n3">

                            <div class="row align-items-center py-3">
                                <div class="col-md-3 ps-5">

                                    <h6 class="mb-0">Phone</h6>

                                </div>
                                <div class="col-md-9 pe-5">

                                    <input type="number" name="phone" id="phoneInput"
                                        class="form-control form-control-lg" placeholder="Enter valid phone no" />
                                    <span class="phoneErr text-danger" style="display: none;">Phone is
                                        required</span>
                                    <span class="phoneVerifyErr text-danger" style="display: none;">Enter valid
                                        number</span>


                                </div>
                            </div>

                            <hr class="mx-n3">

                            <div class="row align-items-center py-3">
                                <div class="col-md-3 ps-5">

                                    <h6 class="mb-0">Gender</h6>

                                </div>
                                <div class="col-md-9 pe-5 d-flex">

                                    <h6 class="mb-0 px-4">Male</h6>
                                    <input type="radio" name="gender" value="male" />

                                    <h6 class="mb-0 px-4">Female</h6>
                                    <input type="radio" name="gender" value="female" />

                                </div>
                                <span class="genderErr text-danger" style="display: none; margin-left: 350px">Gender is
                                    required</span>

                            </div>

                            <hr class="mx-n3">

                            <div class="row align-items-center py-3">
                                <div class="col-md-3 ps-5">

                                    <h6 class="mb-0">Hobbies</h6>

                                </div>
                                <div class="col-md-9 pe-5 d-flex">

                                    <h6 class="mb-0 px-4">Cricket</h6>
                                    <input type="checkbox" name="hobbies[]" value="Cricket" />

                                    <h6 class="mb-0 px-4">Football</h6>
                                    <input type="checkbox" name="hobbies[]" value="Football" />

                                </div>
                                <span class="hobbiesErr text-danger" style="display: none; margin-left: 350px">Hobbies
                                    is required</span>

                            </div>

                            <hr class="mx-n3">

                            <div class="row align-items-center py-3">
                                <div class="col-md-3 ps-5">

                                    <h6 class="mb-0">Upload CV</h6>

                                </div>
                                <div class="col-md-9 pe-5">

                                    <input type="file" name="up" accept="image/png, image/gif, image/jpeg" />
                                    <div class="small text-muted mt-2">Upload your photo PNG's, JPEG's and GIF's
                                        Max size 5 Mb.</div>

                                </div>
                                <span class="imageErr text-danger" style="display: none; margin-left: 350px">Image is
                                    required</span>

                            </div>

                            <hr class="mx-n3">

                            <div class="px-5 py-4">
                                <button type="button" id="submit" class="btn btn-primary btn-lg">Submit new
                                    user</button>

                            </div>

                        </div>
                    </div>

                </div>
            </div>
            </div>
        </section>

    </form>
    <?php


    $query = "SELECT * FROM users";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {

        ?>


        <section class="h-100vh w-100" style="background-color: #2779e2; padding: 20px;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Photo</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Hobbies</th>
                        <th scope="col">Settings</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $serialNumber = 1;


                    while ($row = mysqli_fetch_assoc($result)) {

                        ?>

                        <?php
                        ?>
                        <tr>
                            <td>
                                <p class="mb-1">
                                    <?php echo $serialNumber ?>
                                </p>
                            </td>
                            <td>
                                <img src="<?php echo $row['photo']; ?>" alt="Generic placeholder image" class="img-fluid"
                                    style="width: 20px; border-radius: 50px;">
                            </td>
                            <td>
                                <p class="mb-1">
                                    <?php echo $row['name'] ?>
                                </p>
                            </td>
                            <td>
                                <p class="mb-1">
                                    <?php echo $row['email'] ?>
                                </p>
                            </td>
                            <td>
                                <p class="mb-1">
                                    <?php echo $row['phone'] ?>
                                </p>
                            </td>
                            <td>
                                <p class="mb-1">
                                    <?php echo $row['gender'] ?>
                                </p>
                            </td>
                            <td>
                                <p class="mb-1">
                                    <?php echo $row['hobbies'] ?>
                                </p>
                            </td>
                            <td>
                                <div class="d-flex pt-1">
                                    <a class="btn btn-outline-primary me-1 flex-grow-1 edit-button"
                                        href="http://localhost/crud/edit.php?id=<?php echo $row['id']; ?>">Edit details</a>
                                    <a class="btn btn-outline-primary me-1 flex-grow-1 delete-button"
                                        data-id="<?php echo $row['id']; ?>">Delete
                                        user</a>
                                </div>

                            </td>

                        </tr>
                        <?php

                        $serialNumber += 1;

                    } ?>

                </tbody>
            </table>
        </section>


    
        <script>

            const submitButton = document.getElementById("submit");

            submitButton.addEventListener("click", function (event) {

                const nameInput = document.getElementById("nameInput");
                const emailInput = document.getElementById("emailInput");
                const phoneInput = document.getElementById("phoneInput");
                const genderRadios = document.querySelectorAll("input[name='gender']");
                const hobbiesCheckbox = document.querySelectorAll("input[name='hobbies[]']");
                const fileInput = document.querySelector("input[name='up']");

                const nameSpan = document.querySelector(".nameErr");
                const emailSpan = document.querySelector(".emailErr");
                const phoneSpan = document.querySelector(".phoneErr");
                const phoneVerifySpan = document.querySelector(".phoneVerifyErr");
                const genderSpan = document.querySelector(".genderErr");
                const hobbiesSpan = document.querySelector(".hobbiesErr");
                const fileSpan = document.querySelector(".imageErr");

                // Reset error messages
                nameSpan.style.display = "none";
                emailSpan.style.display = "none";
                phoneSpan.style.display = "none";
                phoneVerifySpan.style.display = "none";
                genderSpan.style.display = "none";
                hobbiesSpan.style.display = "none";
                fileSpan.style.display = "none";

                let isValid = true;

                // Validate inputs
                if (nameInput.value.trim() === "") {
                    nameSpan.style.display = "inline";
                    isValid = false;
                    event.preventDefault(); // Prevent form submission
                }

                if (emailInput.value.trim() === "") {
                    emailSpan.style.display = "inline";
                    isValid = false;
                    event.preventDefault();
                }


                if (phoneInput.value.trim() === "") {
                    phoneSpan.style.display = "inline";
                    isValid = false;
                    event.preventDefault();
                }

                if (phoneInput.value.trim().length !== 10) {
                    phoneVerifySpan.style.display = "inline";
                    isValid = false;
                    event.preventDefault();
                }

                if (document.querySelector("input[name='gender']:checked") === null) {
                    genderSpan.style.display = "inline";
                    isValid = false;
                    event.preventDefault();
                }

                if (document.querySelector("input[name='hobbies[]']:checked") === null) {
                    hobbiesSpan.style.display = "inline";
                    isValid = false;
                    event.preventDefault();
                }
                if (fileInput.files.length === 0) {
                    fileSpan.style.display = "inline";
                    isValid = false;
                    event.preventDefault();
                }

                if (isValid) {
                    this.action = "app.php";
                }
            }

        </script>
    </body>

    </html>
<?php } ?>