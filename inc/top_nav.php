<?php
// Get the current page filename
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<header class="header-area header-three">
  <div id="header-sticky" class="menu-area">
    <div class="container-fluid pl-85 pr-85">
      <div class="second-menu">
        <div class="row align-items-center">
          <div class="col-xl-2 col-lg-2">
            <div class="logo">
              <a href="index.php"><img src="img/logo/logo.png" alt="logo"></a>
            </div>
          </div>
          <div class="col-xl-8 col-lg-8">

            <div class="main-menu text-center">
              <nav id="mobile-menu">
                <ul>
                  <li class="has-sub <?= ($currentPage == 'index.php') ? 'active' : '' ?>">
                    <a href="index.php">Home</a>
                  </li>
                  <li class="<?= ($currentPage == 'about.php') ? 'active' : '' ?>"><a href="about.php">About</a></li>
                  <li class="has-sub <?= ($currentPage == 'room.php') ? 'active' : '' ?>">
                    <a href="room.php">Our Rooms</a>
                  </li>
                  <li class="has-sub <?= ($currentPage == 'services.php' || $currentPage == 'single-service.php') ? 'active' : '' ?>">
                    <a href="services.php">Facilities</a>
                    <ul>
                      <li class="<?= ($currentPage == 'services.php') ? 'active' : '' ?>"> <a href="services.php">Services</a></li>
                      <li class="<?= ($currentPage == 'single-service.php') ? 'active' : '' ?>"> <a href="single-service.php">Services Details</a></li>
                    </ul>
                  </li>
                  <li class="has-sub <?= in_array($currentPage, ['projects.php', 'faq.php', 'team.php', 'team-single.php', 'pricing.php', 'shop.php', 'shop-details.php']) ? 'active' : '' ?>">
                    <a href="#">Pages</a>
                    <ul>
                      <li class="<?= ($currentPage == 'projects.php') ? 'active' : '' ?>"><a href="projects.php">Gallery</a></li>
                      <li class="<?= ($currentPage == 'faq.php') ? 'active' : '' ?>"><a href="faq.php">Faq</a></li>
                      <li class="<?= ($currentPage == 'team.php') ? 'active' : '' ?>"><a href="team.php">Team</a></li>
                      <li class="<?= ($currentPage == 'team-single.php') ? 'active' : '' ?>"><a href="team-single.php">Team Details</a></li>
                      <li class="<?= ($currentPage == 'pricing.php') ? 'active' : '' ?>"><a href="pricing.php">Pricing</a></li>
                      <li class="<?= ($currentPage == 'shop.php') ? 'active' : '' ?>"><a href="shop.php">Shop</a></li>
                      <li class="<?= ($currentPage == 'shop-details.php') ? 'active' : '' ?>"><a href="shop-details.php">Shop Details</a></li>
                    </ul>
                  </li>
                  <li class="has-sub <?= ($currentPage == 'blog.php' || $currentPage == 'blog-details.php') ? 'active' : '' ?>">
                    <a href="blog.php">Blog</a>
                    <ul>
                      <li class="<?= ($currentPage == 'blog.php') ? 'active' : '' ?>"><a href="blog.php">Blog</a></li>
                      <li class="<?= ($currentPage == 'blog-details.php') ? 'active' : '' ?>"><a href="blog-details.php">Blog Details</a></li>
                    </ul>
                  </li>
                  <li class="<?= ($currentPage == 'contact.php') ? 'active' : '' ?>"><a href="contact.php">Contact</a></li>
                </ul>
              </nav>
            </div>
          </div>
          <div class="col-xl-2 col-lg-2 d-none d-lg-block">
            <a href="contact.php" class="top-btn mt-10 mb-10 <?= ($currentPage == 'contact.php') ? 'active' : '' ?>">Reservation</a>
          </div>

          <div class="col-12">
            <div class="mobile-menu"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>