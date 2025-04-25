(function ($) {
  ("use strict");

  //===== General Variables =====//
  var pgurl,
    width,
    wow,
    port_caro,
    testi_caro,
    menu_height = $("header").innerHeight(),
    scroll = $(window).scrollTop();

  $(document).ready(function () {
    //===== Menu Active =====//
    pgurl = window.location.href.substr(
      window.location.href.lastIndexOf("/") + 1
    );
    $("nav ul li a").each(function () {
      if ($(this).attr("href") == pgurl || $(this).attr("href") == "")
        $(this)
          .parent("li")
          .addClass("active")
          .parent()
          .parent()
          .addClass("active")
          .parent()
          .parent()
          .addClass("active");
    });

    //===== Side Panel =====//
    $(".sidepanel > span").on("click", function () {
      $(".sidepanel").toggleClass("show");
      $(this).toggleClass("spin");
      return false;
    });

    //===== Skin Mode =====//
    $(".skin-mode a").on("click", function () {
      $(".skin-mode a").removeClass("applied");
      $(this).addClass("applied");
      return false;
    });

    $(".skin-mode > a.dark-mode").on("click", function () {
      $("body").removeClass("light bg-color4 gray-layer");
      $("body").addClass("dark bg-color12 dark-layer2");
      return false;
    });

    $(".skin-mode > a.light-mode").on("click", function () {
      $("body").removeClass("dark bg-color12 dark-layer2");
      $("body").addClass("light bg-color4 gray-layer");
      return false;
    });

    //===== Color Picker =====//
    $(".color-picker a").on("click", function () {
      $(".color-picker a").removeClass("applied");
      $(this).addClass("applied");
      return false;
    });

    $(".color-picker > a.scheme1-color").on("click", function () {
      $("body").removeClass("scheme2 scheme3 scheme4 scheme5");
      $("body").addClass("scheme1");
      return false;
    });

    $(".color-picker > a.scheme2-color").on("click", function () {
      $("body").removeClass("scheme1 scheme3 scheme4 scheme5");
      $("body").addClass("scheme2");
      return false;
    });

    $(".color-picker > a.scheme3-color").on("click", function () {
      $("body").removeClass("scheme2 scheme1 scheme4 scheme5");
      $("body").addClass("scheme3");
      return false;
    });

    $(".color-picker > a.scheme4-color").on("click", function () {
      $("body").removeClass("scheme2 scheme3 scheme1 scheme5");
      $("body").addClass("scheme4");
      return false;
    });

    $(".color-picker > a.scheme5-color").on("click", function () {
      $("body").removeClass("scheme2 scheme3 scheme4 scheme1");
      $("body").addClass("scheme5");
      return false;
    });

    //===== Width =====//
    width = window.innerWidth;
    //===== Wow Animation Setting =====//
    if ($(".wow").length > 0) {
      var wow = new WOW({
        boxClass: "wow", // default
        animateClass: "animated", // default
        offset: 0, // default
        mobile: true, // default
        live: true // default
      });

      wow.init();
    }

    if (width < 1199) {
      // Open menu
      $(".res-menu-btn").on("click", function () {
        $("nav > ul").addClass("slidein");
        $(".res-menu-close").addClass("d-inline-flex");
        return false;
      });

      // Prevent propagation inside menu
      $("nav > ul").on("click", function (e) {
        e.stopPropagation();
      });

      // Close menu when clicking outside
      $("html, body").on("click", function (e) {
        if (!$(e.target).closest("nav > ul").length && !$(e.target).closest(".res-menu-btn").length) {
          $("nav > ul").removeClass("slidein");
          $(".res-menu-close").removeClass("d-inline-flex");
        }
      });

      // Close menu when any item is clicked
      $("nav > ul > li > a").on("click", function () {
        $("nav > ul").removeClass("slidein");
        $(".res-menu-close").removeClass("d-inline-flex");
      });

      // Dropdown toggle
      $("nav li.menu-item-has-children > a > i").on("click", function () {
        $(this).parent().parent().siblings("li").children("ul").slideUp();
        $(this).parent().parent().siblings("li").removeClass("active");
        $(this).parent().parent().children("ul").slideToggle();
        $(this).parent().parent().toggleClass("active");
        return false;
      });
    }

    //   $(document).ready(function() {
    //     // Check on page load
    //     if ($(window).scrollTop() === 0) {
    //         $('#stickyHeader').addClass('at-top');
    //     }

    //     // Handle scroll event
    //     $(window).scroll(function() {
    //         if ($(this).scrollTop() > 50) {
    //             $('#stickyHeader').removeClass('at-top').addClass('scrolled');
    //         } else {
    //             $('#stickyHeader').addClass('at-top').removeClass('scrolled');
    //         }
    //     });
    // });
    // Certificate Section Animation with jQuery
    $(document).ready(function () {
      // Add animation classes to certificates when they come into view
      const $certificateBoxes = $('.certificate-box');

      if ('IntersectionObserver' in window) {
        const certificateObserver = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              $(entry.target).addClass('wow fadeInUp');
              certificateObserver.unobserve(entry.target);

              // Add a slight delay between each certificate animation
              setTimeout(() => {
                $(entry.target).css('visibility', 'visible');
              }, 200 * $certificateBoxes.index($(entry.target)));
            }
          });
        }, {
          threshold: 0.2
        });

        $certificateBoxes.each(function () {
          $(this).css('visibility', 'hidden');
          certificateObserver.observe(this);
        });
      } else {
        // Fallback for browsers that don't support IntersectionObserver
        $certificateBoxes.addClass('wow fadeInUp');
        $certificateBoxes.css('visibility', 'visible');
      }

      // Add hover effect for certificate boxes
      $certificateBoxes.hover(
        function () {
          // Mouse enter
          const $icon = $(this).find('.cert-icon');
          if ($icon.length) {
            $icon.css({
              'transition': 'transform 0.3s ease, color 0.3s ease',
              'transform': 'rotate(15deg) scale(1.2)',
              'color': 'var(--scheme1)',
              'opacity': '1'
            });
          }
        },
        function () {
          // Mouse leave
          const $icon = $(this).find('.cert-icon');
          if ($icon.length) {
            $icon.css({
              'transform': 'rotate(0) scale(1)',
              'opacity': '0.7'
            });
          }
        }
      );

      // Add click event for certificate view buttons to track analytics (if needed)
      $('.certificate-box .btn').on('click', function (e) {
        // Optional: Track certificate view analytics
        const certificateTitle = $(this).closest('.certificate-box').find('h4').text();
        console.log(`Certificate viewed: ${certificateTitle}`);

        // If you have analytics, you could add the tracking code here
        // Example: if (typeof gtag !== 'undefined') { gtag('event', 'view_certificate', { 'certificate_name': certificateTitle }); }
      });

      // Initialize WOW.js if it's included in your project
      if (typeof WOW !== 'undefined') {
        new WOW().init();
      }
    });
    //===== LightBox =====//
    if ($.isFunction($.fn.fancybox)) {
      $('[data-fancybox],[data-fancybox="gallery"]').fancybox({});
    }

    if (width > 1290) {
      //===== Sticky Sidebar =====//
      if ($.isFunction($.fn.theiaStickySidebar)) {
        $(".resume-sidebar, .resume-content").theiaStickySidebar({
          additionalMarginTop: 30
        });
      }
    }

    //===== Swiper Carousel =====//
    if ($(".swiper").length) {
      port_caro = new Swiper(".port-caro", {
        slidesPerView: 3,
        spaceBetween: 20,
        grabCursor: true,
        loop: true,
        speed: 2000,
        autoplay: {
          delay: 6000,
          disableOnInteraction: false
        },
        pagination: {
          el: ".gen-pagi",
          clickable: true
        },
        breakpoints: {
          0: {
            slidesPerView: 1
          },
          577: {
            slidesPerView: 1
          },
          768: {
            slidesPerView: 2
          },
          995: {
            slidesPerView: 2
          },
          1020: {
            slidesPerView: 3
          },
          1210: {
            slidesPerView: 3
          }
        }
      });
      testi_caro = new Swiper(".testi-caro", {
        slidesPerView: 1,
        spaceBetween: 20,
        effect: "fade",
        grabCursor: true,
        loop: true,
        speed: 2000,
        autoplay: {
          delay: 6000,
          disableOnInteraction: false
        },
        navigation: {
          nextEl: ".gen-btn-next",
          prevEl: ".gen-btn-prev"
        },
        pagination: {
          el: ".testi-pagi",
          type: "fraction"
        }
      });
    }
  }); //===== Document Ready Ends =====//

  //===== Window onLoad =====//
  $(window).on("load", function () {
    //===== Header Spacing =====//
    $("main").css("padding-top", menu_height);

    //===== Page Loader =====//
    $(".page-loader").fadeOut("slow");
  }); //===== Window onLoad Ends =====//

  //===== Sticky Header =====//
  $(window).on("scroll", function () {
    "use strict";

    if (scroll >= menu_height) {
      $("body").addClass("sticky");
    } else {
      $("body").removeClass("sticky");
    }
  }); //===== Window onScroll Ends =====//
})(jQuery);
