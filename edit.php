<?php
include 'config.php';




if (isset($_POST['submit'])) {

  $id1 = $_POST['id'];
  $name1 = $_POST['name'];
  $email1 = $_POST['email'];
  $phone1 = $_POST['phone'];
  $gender1 = $_POST['gender'];
  $hobbies1 = implode(', ', $_POST['hobbies']); // Combine selected hobbies into a comma-separated string
  $filename1 = $_FILES['up']['name'];

  $source = $_FILES['up']['tmp_name'];
  $destination = "images/{$filename1}";

  $pass = move_uploaded_file($source, $destination);

  // Perform the database update
  $query1 = "UPDATE users SET name = '{$name1}', email = '{$email1}', phone = '{$phone1}', gender = '{$gender1}', hobbies = '{$hobbies1}', photo = '{$destination}' WHERE id = '{$id1}'";

  $result1 = mysqli_query($conn, $query1);

  if ($result1 && $pass) {
    header('Location: http://localhost/crud/add.php');
    exit;
  } else {
    // Update failed
    echo "Error updating user: " . mysqli_error($conn);
  }
}





?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <title>EDIT USER</title>
</head>

<body>


  <form action="edit.php" method="post" enctype="multipart/form-data" id="myForm">

    <section class="vh-100" style="background-color: #2779e2;>
  <div class=" container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-9">

          <h1 class="text-white mb-4">EDIT USER</h1>
          <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">

          <div class="card" style="border-radius: 15px;">
            <div class="card-body">

              <div class="row align-items-center pt-3 pb-3">
                <div class="col-md-3 ps-5">

                  <?php


                  include 'config.php'; // Include the database configuration
                  
                  $query = "SELECT * FROM users where id = '{$_GET['id']}' ";
                  $result = mysqli_query($conn, $query);

                  if (mysqli_num_rows($result) > 0) {

                    ?>


                    <section class="h-100vh w-100" style="background-color: #2779e2;">
                      <?php

                      while ($row = mysqli_fetch_assoc($result)) {

                        ?>
                        <h6 class="mb-0 bg-light">Full name</h6>

                    </div>
                    <div class="col-md-9 pe-5">

                      <input type="text" id="nameInput" name="name" class="form-control form-control-lg"
                        value="<?php echo $row['name']; ?>" />
                      <span class="nameErr text-danger" style="display: none;">Name is required</span>

                    </div>
                  </div>

                  <hr class="mx-n3">

                  <div class="row align-items-center py-3">
                    <div class="col-md-3 ps-5">

                      <h6 class="mb-0">Email address</h6>

                    </div>
                    <div class="col-md-9 pe-5">

                      <input type="email" id="emailInput" name="email" class="form-control form-control-lg"
                        value="<?php echo $row['email']; ?>" placeholder="example@example.com" />
                      <span class="emailErr text-danger" style="display: none;">Email is required</span>


                    </div>
                  </div>

                  <hr class="mx-n3">

                  <div class="row align-items-center py-3">
                    <div class="col-md-3 ps-5">

                      <h6 class="mb-0">Phone</h6>

                    </div>
                    <div class="col-md-9 pe-5">

                      <input type="number" id="phoneInput" name="phone" class="form-control form-control-lg"
                        value="<?php echo $row['phone']; ?>" placeholder="Enter valid phone no" />
                      <span class="phoneErr text-danger" style="display: none;">Phone is required</span>
                      <span class="phoneVerifyErr text-danger" style="display: none;">Enter valid number</span>

                    </div>
                  </div>

                  <hr class="mx-n3">

                  <div class="row align-items-center py-3">
                    <div class="col-md-3 ps-5">

                      <h6 class="mb-0">Gender</h6>

                    </div>
                    <div class="col-md-9 pe-5 d-flex">
                      <?php
                      $checkedMale = "";
                      $checkedFemale = "";

                      if ($row['gender'] == 'male') {
                        $checkedMale = "checked";
                      } else if ($row['gender'] == 'female') {
                        $checkedFemale = "checked";
                      }
                      ?>

                      <h6 class="mb-0 px-4">Male</h6>
                      <input type="radio" name="gender" value="male" <?php echo $checkedMale; ?> />

                      <h6 class="mb-0 px-4">Female</h6>
                      <input type="radio" name="gender" value="female" <?php echo $checkedFemale; ?> />
                    </div>
                    <span class="genderErr text-danger" style="display: none;">Gender is required</span>


                  </div>

                  <hr class="mx-n3">

                  <div class="row align-items-center py-3">
                    <div class="col-md-3 ps-5">
                      <h6 class="mb-0">Hobbies</h6>
                    </div>
                    <div class="col-md-9 pe-5 d-flex">
                      <?php
                      $userHobbies = explode(', ', $row['hobbies']); // Split stored hobbies into an array
                  
                      $hobbies = array('Cricket', 'Football'); // List of available hobbies
                  
                      foreach ($hobbies as $hobby) {
                        $checked = in_array($hobby, $userHobbies) ? 'checked' : ''; // Check if the hobby is in user's hobbies
                        echo '<h6 class="mb-0 px-4">' . $hobby . '</h6>';
                        echo '<input type="checkbox" name="hobbies[]" value="' . $hobby . '" ' . $checked . ' />';
                      }
                      ?>
                    </div>
                    <span class="hobbiesErr text-danger" style="display: none;">Hobbies is required</span>

                  </div>


                  <hr class="mx-n3">

                  <div class="row align-items-center py-3">
                    <div class="col-md-3 ps-5">

                      <h6 class="mb-0">Upload CV</h6>

                    </div>
                    <div class="col-md-9 pe-5">

                      <input type="file" name="up" value="a:/passwords.txt">
                      <div class="small text-muted mt-2">Upload your CV/Resume or any other relevant file.
                        Max file
                        size 50 MB</div>
                      <span class="imageErr text-danger" style="display: none;">Image is required</span>


                    </div>
                  </div>

                  <hr class="mx-n3">

                  <div class="px-5 py-4">
                    <button type="submit" name="submit" class="btn btn-primary btn-lg">Submit</button>
                  </div>
                <?php } ?>
              <?php } ?>

            </div>
          </div>

        </div>
      </div>
      </div>
    </section>

  </form>
  <?php

  
  $query = "SELECT * FROM users where id = '{$_GET['id']}' ";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {

    ?>


    <section class="h-100vh w-100" style="background-color: #2779e2;">
      <?php

      while ($row = mysqli_fetch_assoc($result)) {

        ?>
        <div class="container py-5 h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-md-9 col-lg-7 col-xl-5">
              <div class="card" style="border-radius: 15px;">
                <div class="card-body p-4">
                  <div class="d-flex text-black">
                    <div class="flex-shrink-0">

                      <img src="<?php echo $row['photo']; ?>" alt="Generic placeholder image" class="img-fluid"
                        style="width: 180px; border-radius: 10px;">
                    </div>

                    <div class="flex-grow-1 ms-3">
                      <div class="name d-flex">
                        <h5 style="display: none">ID: &nbsp&nbsp </h5>
                        <p style="display: none" class="mb-1">
                          <?php echo $row['id'] ?>
                        </p>
                        <h5>Your details</h5>
                      </div>
                      <div class="name d-flex">
                        <h5>Name: &nbsp&nbsp </h5>
                        <p class="mb-1">
                          <?php echo $row['name'] ?>
                        </p>
                      </div>
                      <div class="name d-flex">
                        <h5>Email: &nbsp&nbsp </h5>
                        <p class="mb-2 pb-1" style="color: #2b2a2a;">
                          <?php echo $row['email'] ?>
                        </p>
                      </div>
                      <div class="name d-flex">
                        <h5>Phone: &nbsp&nbsp </h5>
                        <p class="mb-2 pb-1" style="color: #2b2a2a;">
                          <?php echo $row['phone'] ?>
                        </p>
                      </div>
                      <div class="name d-flex">
                        <h5>Gender: &nbsp&nbsp </h5>
                        <p class="mb-2 pb-1" style="color: #2b2a2a;">
                          <?php echo $row['gender'] ?>
                        </p>
                      </div>
                      <div class="name d-flex">
                        <h5>Hobbies: &nbsp&nbsp </h5>
                        <p class="mb-2 pb-1" style="color: #2b2a2a;">
                          <?php echo $row['hobbies'] ?>
                        </p>
                      </div>

                      <div class="d-flex pt-1">
                        <a href="http://localhost/crud/edit.php?id=<?php echo $row['id']; ?>"
                          class="btn btn-outline-primary me-1 flex-grow-1">Edit details</a>
                        <a href="http://localhost/crud/delete.php?id=<?php echo $row['id']; ?>"
                          class="delete-button btn btn-outline-primary me-1 flex-grow-1">Delete user</a>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>


      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
      <script>
        $(document).ready(function () {
          $(".delete-button").click(function () {
            var id = $(this).data("id");
            if (confirm('Are you sure you want to delete this user?')) {
              window.location.href = "http://localhost/crud/delete.php?id=" + id;
            } else {
              // Do nothing or add a different redirection
            }

          });
        });


        const form = document.getElementById("myForm");

        form.addEventListener("submit", function (event) {
          event.preventDefault();
          const nameInput = document.getElementById("nameInput");
          const emailInput = document.getElementById("emailInput");
          const phoneInput = document.getElementById("phoneInput");
          const genderRadios = document.querySelectorAll("input[name='gender']");
          const hobbiesCheckbox = document.querySelectorAll("input[name='hobbies[] ']");
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

          // Validate inputs
          if (nameInput.value.trim() === "") {
            nameSpan.style.display = "inline";
             // Prevent form submission
          }

          if (emailInput.value.trim() === "") {
            emailSpan.style.display = "inline";
          }

          if (phoneInput.value.trim() === "") {
            phoneSpan.style.display = "inline";
          }

          if (phoneInput.value.trim().length !== 10) {
            phoneVerifySpan.style.display = "inline";
          }

          if (document.querySelector("input[name='gender']:checked") === null) {
            genderSpan.style.display = "inline";
          }

          if (document.querySelector("input[name='hobbies[]']:checked") === null) {
            hobbiesSpan.style.display = "inline";
          }
          if (fileInput.files.length === 0) {
            fileSpan.style.display = "inline";
          }
        });
      </script>

  </body>

  </html>
<?php } ?>