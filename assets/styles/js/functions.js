// @codekit-prepend "/vendor/hammer-2.0.8.js";

$(document).ready(function () {
  var canScroll = true,
      scrollController = null;

  document.addEventListener("wheel", function (e) {
    if (!$('.outer-nav').hasClass('is-vis')) {
      e.preventDefault();

      var delta = e.deltaY || e.wheelDelta || -e.detail * 20;

      if (delta > 50 && canScroll) {
        triggerScroll(1);
      } else if (delta < -50 && canScroll) {
        triggerScroll(-1);
      }
    }
  }, { passive: false });

  function triggerScroll(direction) {
    canScroll = false;
    clearTimeout(scrollController);
    scrollController = setTimeout(() => canScroll = true, 800);
    updateHelper(direction);
  }

  $('.side-nav li, .outer-nav li').click(function () {
    if (!$(this).hasClass('is-active')) {
      var curActive = $(this).parent().find('.is-active'),
          curPos = $(this).parent().children().index(curActive),
          nextPos = $(this).parent().children().index($(this)),
          lastItem = $(this).parent().children().length - 1;

      updateNavs(nextPos);
      updateContent(curPos, nextPos, lastItem);
    }
  });

  $('.cta').click(function () {
    var curActive = $('.side-nav').find('.is-active'),
        curPos = $('.side-nav').children().index(curActive),
        lastItem = $('.side-nav').children().length - 1,
        nextPos = lastItem;

    updateNavs(lastItem);
    updateContent(curPos, nextPos, lastItem);
  });

  var targetElement = document.getElementById('viewport'),
      mc = new Hammer(targetElement);
  mc.get('swipe').set({ direction: Hammer.DIRECTION_VERTICAL });
  mc.on('swipeup swipedown', function (e) {
    updateHelper(e.type === "swipeup" ? 1 : -1);
  });

  $(document).keyup(function (e) {
    if (!$('.outer-nav').hasClass('is-vis')) {
      updateHelper(e.keyCode === 40 ? 1 : (e.keyCode === 38 ? -1 : 0));
    }
  });

  function updateHelper(param) {
    var curActive = $('.side-nav').find('.is-active'),
        curPos = $('.side-nav').children().index(curActive),
        lastItem = $('.side-nav').children().length - 1,
        nextPos = curPos;

    if (param > 0 && curPos !== lastItem) nextPos = curPos + 1;
    else if (param < 0 && curPos !== 0) nextPos = curPos - 1;
    else if (param > 0) nextPos = 0;
    else if (param < 0) nextPos = lastItem;

    updateNavs(nextPos);
    updateContent(curPos, nextPos, lastItem);
  }

  function updateNavs(nextPos) {
    $('.side-nav, .outer-nav').children().removeClass('is-active')
      .eq(nextPos).addClass('is-active');
  }

  function updateContent(curPos, nextPos, lastItem) {
    $('.main-content').children().removeClass('section--is-active')
      .eq(nextPos).addClass('section--is-active');
    $('.main-content .section').children().removeClass('section--next section--prev');

    if ((curPos === lastItem && nextPos === 0) || (curPos === 0 && nextPos === lastItem)) {
      $('.main-content .section').children().removeClass('section--next section--prev');
    } else if (curPos < nextPos) {
      $('.main-content').children().eq(curPos).children().addClass('section--next');
    } else {
      $('.main-content').children().eq(curPos).children().addClass('section--prev');
    }

    $('.header--cta').toggleClass('is-active', nextPos !== 0 && nextPos !== lastItem);

    if(nextPos === 3) {
      startProgressAnimationCustom();        
    } 
  }

  function outerNav() {
    $('.header--nav-toggle').click(function () {
      $('.perspective').addClass('perspective--modalview');
      setTimeout(() => $('.perspective').addClass('effect-rotate-left--animate'), 25);
      $('.outer-nav, .outer-nav li, .outer-nav--return').addClass('is-vis');
    });

    $('.outer-nav--return, .outer-nav li').click(function () {
      $('.perspective').removeClass('effect-rotate-left--animate');
      setTimeout(() => $('.perspective').removeClass('perspective--modalview'), 400);
      $('.outer-nav, .outer-nav li, .outer-nav--return').removeClass('is-vis');
    });
  }

  function workSlider() {
    $('.slider--prev, .slider--next').click(function () {
      var $this = $(this),
      $slider = $('.slider'),
      $items = $slider.children();
    
      if ($this.hasClass('slider--next')) {
        $items.first().appendTo($slider);
      } else {
        $items.last().prependTo($slider);
      }
    
      updateSliderClasses();
    });
  }
  
  function updateSliderClasses() {
      var $items = $('.slider').children();
      
      $items.removeClass('slider--item-left slider--item-center slider--item-right');
  
      $items.eq(2).addClass('slider--item-left');
      $items.eq(1).addClass('slider--item-center');
      $items.eq(0).addClass('slider--item-right');
  }
  
  $(document).ready(function () {
      updateSliderClasses();
      workSlider();
  });

  function transitionLabels() {
    $('.work-request--information input').focusout(function () {
      $(this).toggleClass('has-value', $(this).val() !== "");
      window.scrollTo(0, 0);
    });
  }

  outerNav();
  workSlider();
  transitionLabels();
});

function startProgressAnimationCustom() {
  const progressBars = document.querySelectorAll(".progress");
  const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        let bar = entry.target;
        if (!bar.dataset.animated) {
          let targetWidth = parseInt(bar.getAttribute("data-value"));
          bar.style.width = "0%";
          bar.textContent = "0%";

          setTimeout(() => {
            bar.style.transition = "width 2s ease-in-out";
            bar.style.width = targetWidth + "%";
          }, 100);

          let count = 0;
          let interval = setInterval(() => {
            if (count >= targetWidth) {
              clearInterval(interval);
            } else {
              count++;
              bar.textContent = count + "%";
            }
          }, 20);

          bar.dataset.animated = "true";
        }
        observer.unobserve(bar);
      }
    });
  }, { threshold: 0.5 });

  progressBars.forEach(bar => observer.observe(bar));
}

document.querySelectorAll('.side-nav li, .outer-nav li').forEach(item => {
  item.addEventListener("click", () => {
    startProgressAnimationCustom();
  });
});
