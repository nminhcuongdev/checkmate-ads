<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="{{ asset('images/logo.svg') }}" type="image/png">
    <title>Checkmate Advertising Agency</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/linericon/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/owl-carousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/lightbox/simpleLightbox.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/nice-select/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/animate-css/animate.css') }}">
    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>

<style>
    #myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myImg:hover {opacity: 0.7;}

    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
    }

    /* Modal Content (Image) */
    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    /* Caption of Modal Image (Image Text) - Same Width as the Image */
    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    /* Add Animation - Zoom in the Modal */
    .modal-content, #caption {
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @keyframes zoom {
        from {transform:scale(0)}
        to {transform:scale(1)}
    }

    /* The Close Button */
    .close {
        position: absolute;
        top: 100px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px){
        .modal-content {
            width: 100%;
        }
    }
</style>
<!--================Header Menu Area =================-->
<header class="header_area">
    <div class="top_menu row m0">
        <div class="container">
            <div class="float-left">
                <ul class="list header_social">
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                    <li><a href="#"><i class="fa fa-behance"></i></a></li>
                </ul>
            </div>
            <div class="float-right">
                <select class="lan_pack">
                    <option value="1">English</option>
                    <option value="1">Bangla</option>
                    <option value="1">Indian</option>
                    <option value="1">Aus</option>
                </select>
                <a class="dn_btn" href="#">Change Language</a>
            </div>
        </div>
    </div>
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <a class="navbar-brand logo_h" href="{{ route('frontend.home') }}"><img src="{{ asset('img/logo.png') }}" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <ul class="nav navbar-nav menu_nav ml-auto">
                        <li class="nav-item active"><a class="nav-link" href="{{ route('frontend.home') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('frontend.about') }}">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('frontend.service') }}">Services</a>
                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Blog</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="nav-link" href="blog.html">Blog</a></li>
                                <li class="nav-item"><a class="nav-link" href="single-blog.html">Blog Details</a></li>
                            </ul>
                        </li>

                        {{--                        <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>--}}
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="nav-item"><a style="font-size: 25px;" href="{{ route('customer.login') }}" class="search"><i class="lnr lnr-enter"></i></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>


</header>
<section class="home_banner_area">
    <div class="banner_inner d-flex align-items-center">
        <div class="overlay" data-stellar-ratio="0.9" data-stellar-vertical-offset="0" data-background=""></div>
        <div class="container">
            <div class="banner_content text-center mt-25 pt-5">
                <img src="{{ asset('img/banner/text.png') }}" alt="">
                <p class="mt-25">We specialize in providing multidisciplinary Facebook advertising account leasing services. We have partnered with over 500 clients, offering a variety of services and holistic solutions that deliver the best customer experience.</p>
                <h4 class="mt-2" style="color: #F8D241;">Do you want to win this chess match?</h4>
                <a class="black_btn mr-4" href="{{ route('frontend.about') }}">No</a>
                <a class="black_btn" href="{{ route('frontend.about') }}">Yes</a>
            </div>
        </div>
    </div>
</section>
<section class="services_area p_120">
    <div class="container">
        <div class="main_title">
            <a href="{{ route('frontend.service') }}"><h2>OUR OFFERED SERVICE</h2></a>
        </div>
        <div class="row services_inner">
            <div class="col-lg-4">
                <div class="services_item">
                    <img src="{{ asset('img/icon/service-icon-1.png') }}" alt="">
                    <a href="#"><h4>HIGH-QUANTITY ACCOUNT</h4></a>
                    <p>We offer a large number of strong, unlimited accounts with spending history and unlimited daily spending, easily enhancing business efficiency. Specifically, with our huge number of accounts, we can immediately replace them if they become restricted.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="services_item">
                    <img src="{{ asset('img/icon/service-icon-2.png') }}" alt="">
                    <a href="#"><h4>CAMPAIGN OPTIMIZATION</h4></a>
                    <p>We support you to manage many ads campaigns and help you to save time providing and managing resources for employees by immediate support from our team according to 1-1-1 principle ( 1 team = 1 technician + 1 supporter). All your problems will be handled in the best way possible.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="services_item">
                    <img src="{{ asset('img/icon/service-icon-3.png') }}" alt="">
                    <a href="#"><h4>COMPLETELY RISK-FREE</h4></a>
                    <p>We understand that our clients can manage their ads campaigns themselves. However, the special aspect of our service is our commitment to minimizing risks for customers through transparency in refund policies, top-ups, spending, and resource handling, all without any additional fees.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Services Area =================-->
<section class="video-area video-one">
    <div class="section-title-five">
        <div class="main_title">
            <a href="{{ route('frontend.service') }}"><h2>SERVICE CHARGE DETAIL</h2></a>
            <!--					<a class="black_btn mr-4" href="#">Discover Now</a>-->
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="{{ asset('img/bangia-3.jpg') }}" alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="{{ asset('img/bangia-1.jpg') }}" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="{{ asset('img/bangia-2.jpg') }}" alt="Third slide">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="testimonials_area p_120">
    <div class="container">
        <div class="section-title-five">
            <div class="main_title">
                <h2>OUR FEEDBACKS</h2>
                <!--					<a class="black_btn mr-4" href="#">Discover Now</a>-->
            </div>
        </div>
        <div class="testi_slider owl-carousel">
            <div class="item" onclick="showModal('img/testimonials/1.png');">
                <div class="testi_item">
                    <div class="media">
                        <div class="d-flex">
                            <img src="img/testimonials/avatar.png" alt="">
                        </div>
                        <div class="media-body">
                            <p>These are the accounts and campaigns of one of our customers. Impressive numbers include 358, 432, 125, 119 active ads, etc. They demonstrate Checkmate's quality and responsiveness to a very abundant number of accounts.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item" onclick="showModal('img/testimonials/2.png');">
                <div class="testi_item">
                    <div class="media">
                        <div class="d-flex">
                            <img src="img/testimonials/avatar.png" alt="">
                        </div>
                        <div class="media-body">
                            <p>These data are certainly the ideal numbers for all customers when running ads. That's a big reach, mostly over 1000 and the highest being 363,978; low cost with the highest index being 4.71$ and the lowest being only 0.92$,...This is also the reason why our customers have spent up to more than 15.000$ for 26 campaigns.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item" onclick="showModal('img/testimonials/3.png');">
                <div class="testi_item">
                    <div class="media">
                        <div class="d-flex">
                            <img src="img/testimonials/avatar.png" alt="">
                        </div>
                        <div class="media-body">
                            <p>Providing a smart personal website is Checkmate's pride in creating customer experience satisfaction. Customers' compliments are the driving force for us to develop more convenient services in the future.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item" onclick="showModal('img/testimonials/4.png');">
                <div class="testi_item">
                    <div class="media">
                        <div class="d-flex">
                            <img src="img/testimonials/avatar.png" alt="">
                        </div>
                        <div class="media-body">
                            <p>No advertisement is more prestigious than customer referrals. That is also the reason why Checkmate always tries to bring the best service experience to its customers. Customer referrals also partly demonstrate our success in building customer trust.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- The Close Button -->
            <span class="close">&times;</span>

            <!-- Modal Content (The Image) -->
            <img class="modal-content" id="img01">

            <!-- Modal Caption (Image Text) -->
            <div id="caption"></div>
        </div>
    </div>
</section>

<!--================Builder Image Area =================-->
<seciton class="builder_area">
    <div class="main_title">
        <h2>OUR LATEST BLOGS</h2>
    </div>
    <div class="row m0 builder_inner">
        <div class="builder_item">
            <img src="img/builder/Blog1.jpg" alt="">
            <div class="hover">
                <h4>RENT FACEBOOK ACCOUNT: OPPORTUNITY KEY TO INCREASE SALES</h4>
                <p>Unlock the full potential of your online advertising with secure and reliable service to rent Facebook account. Tailored for marketers and businesses, our hassle-free solution ensures high-quality accounts for your ads campaigns. Get started today and amplify your digital presence.</p>
            </div>
        </div>
        <div class="builder_item">
            <img src="img/builder/Blog2.jpg" alt="">
            <div class="hover">
                <h4>FACEBOOK AD ACCOUNT DISABLED: HOW TO FIX IT QUICKLY?</h4>
                <p>Facebook organic reach is crucial for both businesses and individuals. Boosting it with these five strategies, overcoming algorithm challenges without depending solely on ads..</p>
            </div>
        </div>
        <div class="builder_item">
            <img src="img/builder/Blog3.jpg" alt="">
            <div class="hover">
                <h4>5 WAYS TO GROW FACEBOOK ORGANIC REACH</h4>
                <p>Facebook ad account disabled can bring a lot of troubles to your business. This article will show you how to fix it effectively.</p>
            </div>
        </div>
    </div>
</seciton>

<section class="feature_area p_120">
    <div class="container">
        <div class="main_title">
            <h2>FEATURES THAT MAKE US UNIQUE</h2>
        </div>
        <div class="row feature_inner">
            <div class="col-lg-4 col-md-6">
                <div class="feature_item">
                    <h4><i class="lnr lnr-user"></i>Professional Auto Report</h4>
                    <p>Customers can easily and promptly review all financial information, such as deposits, daily expenditures, balance, etc., on the website through their individual accounts accessible on all devices (laptops, phones). Regular monitoring is facilitated, ensuring that all service-related information is readily available at this one-stop location.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature_item">
                    <h4><i class="lnr lnr-diamond"></i>No Test Fee</h4>
                    <p>The fee for the first month will be adjusted according to the customer's average daily expenditure. For instance, if your actual average daily expenditure in the first month is $5000, the fee for the first and second month will be 6%, and any difference will be transferred to your balance for the next month.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature_item">
                    <h4><i class="lnr lnr-phone"></i>Problem Solving Partner</h4>
                    <p>In addition to providing advertising resources and quality services, we are committed to partnering with our clients to address and resolve all issues, including both internal matters and those involving external influences.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature_item">
                    <h4><i class="lnr lnr-rocket"></i>Instant Support </h4>
                    <p>All unforeseen issues related to accounts will be addressed as swiftly as possible to ensure minimal disruption to the customer's campaigns. If account was banned normally it will be replaced in just 1 to few hours
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="feature_item">
                    <h4><i class="lnr lnr-license"></i>Calculate The Real Fee
                    </h4>
                    <p>The fee will be charged only when your campaigns begin to incur expenses. We will not deduct any fees if you have not made any expenditures.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="feature_item">
                    <h4><i class="lnr lnr-bubble"></i>Clear policy</h4>
                    <p>All policies are transparent and public, with no deceit involved. We are always prioritizing integrity above all else.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer-area p_120">
    <div class="container">
        <div class="row">
            <div class="col-lg-6  col-md-6 col-sm-6">
                <div class="single-footer-widget ab_wd">
                    <h6 class="footer_title">About Us</h6>
                    <p>Checkmate Ads Agency provides all types of Facebook advertising account rental service, accepts all niches and has cooperated with many clients from all over the world. We are confident in delivering high-quality rental services with abundant and stable resources, providing additional insights with hands-on experience in ad campaigns, establishing a solid foundation for customers to achieve success in the digital advertising arena.</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="single-footer-widget contact_wd">
                    <h6 class="footer_title">Contact Us</h6>
                    <p><a href="https://t.me/Dan_Checkmate" target="_blank">Telegram:</a>https://t.me/Dan_Checkmate</p>
                    <p><a href="#">Skype:</a>live:.cid.9357fe726ae027a4 </p>
                </div>
            </div>

        </div>
        <div class="row footer-bottom d-flex justify-content-between align-items-center">
            <p class="col-lg-8 col-md-8 footer-text m-0"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="" target="_blank">Checkmate Team</a>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
            <div class="col-lg-4 col-md-4 footer-social">
                <a href="https://www.facebook.com/Trendynewzz"><i class="fa fa-facebook"></i></a>
                <a href="https://t.me/checkmateadsagency"><i class="fa fa-telegram"></i></a>
            </div>
        </div>
    </div>
</footer>
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/stellar.js"></script>
<script src="vendors/lightbox/simpleLightbox.min.js"></script>
<script src="vendors/nice-select/js/jquery.nice-select.min.js"></script>
<script src="vendors/isotope/imagesloaded.pkgd.min.js"></script>
<script src="vendors/isotope/isotope-min.js"></script>
<script src="vendors/owl-carousel/owl.carousel.min.js"></script>
<script src="js/jquery.ajaxchimp.min.js"></script>
<script src="vendors/counter-up/jquery.waypoints.min.js"></script>
<script src="vendors/counter-up/jquery.counterup.js"></script>
<script src="js/mail-script.js"></script>
<script src="js/theme.js"></script>
<script>
    var modal = document.getElementById("myModal");

    // // Get the image and insert it inside the modal - use its "alt" text as a caption
    // var img = document.getElementById("testi_item1");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");

    function showModal(img) {
        modal.style.display = "block";
        modalImg.src = img;
    }

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }
</script>
</body>
</html>
