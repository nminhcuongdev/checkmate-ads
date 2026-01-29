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
                <a class="navbar-brand logo_h" href="{{ route('frontend.home') }}"><img src="img/logo.png" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <ul class="nav navbar-nav menu_nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="{{ route('frontend.home') }}">Home</a></li>
                        <li class="nav-item active"><a class="nav-link" href="{{ route('frontend.about') }}">About</a></li>
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
<section class="banner_area">
    <div class="banner_inner d-flex align-items-center">
        <div class="overlay bg-parallax" data-stellar-ratio="0.9" data-stellar-vertical-offset="0"
             data-background=""></div>
        <div class="container">
            <div class="banner_content text-center">
                <div class="page_link">
                    <a href="{{ route('frontend.home') }}">Home</a>
                    <a href="about-us.html">About</a>
                </div>
                <h2>About Us</h2>
            </div>
        </div>
    </div>
</section>

<section class="about_area">
    <div class="container">
        <div class="section-top-border">
            <div class="row">
                <div class="col-md-4">
                    <div class="single-defination">
                        <h3 class="mb-20" style="text-align: center">Mission</h3>
                        <p style="text-align: justify">To provide clients with strategic mastery in Facebook ads campaigns. We aim to achieve this
                            by offering abundant accounts, instant support staying proactive and forward-thinking in
                            adapting to market changes, delivering customized solutions tailored to each client's unique
                            needs, and making data-driven decisions at every stage of campaign development.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single-defination">
                        <h3 class="mb-20" style="text-align: center">Vision</h3>
                        <p style="text-align: justify">To be the unrivaled leader in Facebook advertising, exemplifying strategic excellence and
                            precision. We aspire to consistently deliver impactful results by leveraging our deep
                            understanding of digital marketing and the ever-evolving advertising landscape.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single-defination">
                        <h3 class="mb-20" style="text-align: center">Value</h3>
                        <p style="text-align: justify">Checkmate embodies the essence of strategic excellence, precision, and success in the realm
                            of Facebook advertising. With a focus on tailored strategies and data-driven insights, the
                            agency is well-positioned to deliver impactful results in the competitive world of
                            digital.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-top-border">
            <div class="row">
                <div class="col-lg-4 col-sm-6 typo-sec">
                    <h3 class="mb-20 title_color">How to win this chess match?</h3>

                </div>
                <div class="col-lg-4 col-sm-6 mt-sm-30 typo-sec">
                    <h3 class="mb-20 title_color">Chess match win </h3>
                    <div class="">
                        <ul class="unordered-list">
                            <li style="padding-bottom: 42px">An indispensable factor to win a chess match is that you
                                must have all the chess pieces ready in hand
                            </li>
                            <li style="padding-bottom: 72px">The second important factor is that you need to clearly
                                understand how each piece is played, how to coordinate them as well as the position you
                                want to create.
                            </li>
                            <li>Finally, what is important and directly impacts the outcome of the chess match is the
                                wise, accurate, highly effective moves...It's a sustainable position, both defensive and
                                offensive
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 mt-sm-30 typo-sec">
                    <h3 class="mb-20 title_color">Campaign ads win</h3>
                    <div class="">
                        <ul class="unordered-list">
                            <li style="padding-bottom: 10px">Similarly, to have a successful advertising campaign, you
                                need a product/service, target customers, campaign purpose, budget,... and many related
                                factors.
                            </li>
                            <li style="padding-bottom: 10px">For an advertising campaign, the same point is that you
                                also need to determine in detail and deeply the characteristics of your product/service,
                                who your potential customers are, and the strengths and weaknesses of opponents.
                            </li>
                            <li style="padding-bottom: 10px">An effective move in your advertising campaign is to find a
                                consultant in this field who has a lot of experience and is willing to help you - that's
                                us "CHECKMATE". A strong and suitable advertising account will always be an important
                                factor in the effectiveness of the campaign, above all with our enthusiastic technical
                                and support team, we are committed to your cooperation and CHECKMATE not only bringing
                                positivity in one area but in many different areas.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


<section class="clients_logo_area p_120">
    <div class="container">
        <div class="clients_slider owl-carousel">
            <div class="item">
                <img src="img/clients-logo/russia.png" alt="">
            </div>
            <div class="item">
                <img src="img/clients-logo/ukraine.png" alt="">
            </div>
            <div class="item">
                <img src="img/clients-logo/indonesia.png" alt="">
            </div>
            <div class="item">
                <img src="img/clients-logo/usa.png" alt="">
            </div>
            <div class="item">
                <img src="img/clients-logo/india.png" alt="">
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
                    <p>Checkmate Ads Agency provides all types of Facebook advertising account rental service, accepts all niches and has cooperated with many clients from all over the world. We are confident in delivering high-quality rental services with abundant and stable resources, providing additional insights with hands-on experience in ad campaigns, establishing a solid foundation for customers to achieve success in the digital advertising arena</p>
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

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
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
</body>
</html>
