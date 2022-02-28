<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCG | My Certificate Generator</title>

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;900&family=Ubuntu:wght@300;400;700&display=swap" rel="stylesheet">
    
    <!-- Font awesome -->
    <script defer src="https://use.fontawesome.com/releases/v6.0.0/js/all.js"></script>
   
    <!-- Bootstrap/ CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

    <!-- JS & Jquery for Collapsable button action (or hamburger)  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>    
</head>
<body>
    <?php
        if (isset($_POST['name'],$_POST['course'])) {
            // create session
            session_start();
            // get the current date/time;
            include("includes/time.fn");
            // sets variables in the session
            $_SESSION['time'] = $now;


            // ######################   USING GD libs of php for img Ops    ########################

            // header('content-type:image/png');
            $font1 = dirname(__FILE__) . "\\PERTIBD.TTF";                           //  get the fonts
            $font2 = dirname(__FILE__) . "\\PERTILI.TTF";
            $font3 = dirname(__FILE__) . "\\CONSTANI.TTF";
            $font4 = dirname(__FILE__) . "\\CONSTANB.TTF";
            $font5 = dirname(__FILE__) . "\\BRUSHSCI.TTF";
            $font6 = dirname(__FILE__) . "\\AGENCYR.TTF";
            $image = imagecreatefrompng("images/cert.png");                        //  creating img ptr

            // organisation title
            $title = "FRT Institute";
            $title_color = imagecolorallocate($image, 5, 7, 80);                        //  takes 2 para imgPtr & RGB color format  
            imagettftext($image, 40, 0, 1200, 185, $title_color, $font1, $title);       //  put txt in img, takes para as (imgPtr, fontsize, textRotationAngle, XY-axis coord

            //  organisation address
            $address = "404, Virtual World";
            $address_color = imagecolorallocate($image, 5, 7, 80);
            imagettftext($image, 25, 0, 1200, 220, $address_color, $font2, $address);

            //  candidates name
            $name = $_POST['name'];
            $name_color = imagecolorallocate($image, 10, 50, 100);
            //$name_font_size = 60;
            $len = 40 * strlen($name) / 2;
            imagettftext($image, 60, 0, (1000 - $len), 710, $name_color, $font3, $name);

            //  course taken
            // $course = "Microsoft Azure Fundamentals";
            $course = $_POST['course'];
            $len_course = 40 * strlen($course) / 2;
            $course_color = imagecolorallocate($image, 10, 50, 100);
            imagettftext($image, 60, 0, (1000 - $len_course), 950, $course_color, $font4, $course);

            //  date
            $date = $now;
            $date_col = imagecolorallocate($image, 255, 255, 255);
            imagettftext($image, 20, 0, 1620, 1380, $date_col, $font6, $date);

            // verification
            $num_color = imagecolorallocate($image, 105, 105, 105);
            $file = time();                                                       //  creeate timestamp for every certifacte that gets generated
            //$num = "Verified Certificate No : " . $file;
            $url= "Verify at https://mcg1.azurewebsites.net/verify/".$file;
            echo "<a href='.$url.'></a>";
            imagettftext($image, 20, 0, 100, 1380, $num_color, $font6, $url);

            //  generate certificate
            $filepath = "verify/" . $file . ".png";                             // Save to verify dir with unique id i.e. unix timestamp
            imagepng($image, $filepath);


            imagedestroy($image);                                                //  Destructor 
            $_SESSION['filepath'] = $filepath;

            header("Location:preview.php");                                       // Redirect
        }
    ?>

    <!-- Top navigation -->
    <section class="color_sec" id=hdr>
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-dark">        <!-- bg-primary   -->
                <a class="navbar-brand" href="https://mcg1.azurewebsites.net"><i class="fa-solid fa-house-chimney"></i></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#hdr">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#footer">Azure</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#footer">Github</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Title -->
            <div class="header"><p>
                <img class="flt" src="https://futurereadytalent.in/images/logo/01.png" alt="FRT logo-img">
                <h1 class="title">FRT INTERNSHIP</h1>
                <p class="address">404, Virtual World</p></P>
            </div>

        </div> 
    </section>

    <!-- Form section -->
    <section class="white_sec">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 bound">        
                    <h4> Fill in the details to generate the certificate of Course Completion</h4>

                    <form method="POST" action="">
                        <table class="table">
                            <tr>
                                <td>
                                    <label for="name"> Name :
                                        <input type="text" name="name" class="ip_width">
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="course">Course: 
                                        <input type="text" name="course" class="ip_width">
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="btnz">
                                        <button type="reset" class="btn btn-md btn-dark"  value="Reset">Reset</button>
                                        <button type="submit" class="btn btn-md btn-outline-success">Submit</button>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

                <!-- Quick guide section -->
                <div class="col-lg-4 bound"> 
                   <h5>Qucik Guide</h5>
                   <ul>
                       <li>Input Name of the Student/Participant</li>
                       <li>Input Name of the Course & Submit</li>
                       <li>View certificate & print with shortcut Ctrl+P</li>
                       <li>Unique & verifiable ID for every generated certificate </li>
                       <br>
                       <li>The Azure link redirects to the hosted web app</li>
                       <li>The Github link redirects to the github repository</li>
                   </ul>
                </div>

                <!-- image section -->
                <div class="col-lg-4 bound"> 
                    <img class="resize" src="images/tst.jpg" alt="FRT img" > 
                </div>
            </div>

        </div>
    </section>
    
    <!-- Footer section -->
    <footer id="footer">
        <h4 class="pro sub_hd">Project aligned to industry EdTech</h4>
        <a href="#hdr"><i class="social-icon fa-solid fa-house-chimney"></i></a>  <!-- social-icon is customm css-->
        <a href="https://mcg1.azurewebsites.net"><i class="social-icon fa-solid fa-cloud-arrow-up"></i></a>
        <a href="https://github.com/AOriole/mcg"> <i class="social-icon fa-brands fa-github"></i></a>
        <p class="rights">© Copyright Touseef Khan | MCG Project for FRT | Internship 2022</p>
    </footer>
</body>
</html>