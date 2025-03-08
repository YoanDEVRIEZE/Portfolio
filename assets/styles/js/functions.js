$(document).ready(function () {
  var canScroll = true,
      scrollController = null;

  var sectionToActivate = document.getElementById('section-data').getAttribute('data-section');

  if (sectionToActivate !== null) {
    sectionToActivate = parseInt(sectionToActivate);

    if (sectionToActivate === 4) {
      var curActive = $('.side-nav').find('.is-active'),
        curPos = $('.side-nav').children().index(curActive),
        lastItem = $('.side-nav').children().length - 1,
        nextPos = lastItem;

    updateNavs(lastItem);
    updateContent(curPos, nextPos, lastItem);
    } else {
      updateNavs(sectionToActivate);
    }
  }

  document.addEventListener("wheel", function (e) {
    if (!$('.outer-nav').hasClass('is-vis') && !$('.popup').is(':visible')) {
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
    if (!$('.outer-nav').hasClass('is-vis') && !$('.popup').is(':visible')) {
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

    setTimeout(() => {
      updateNavs(nextPos);
      updateContent(curPos, nextPos, lastItem);
      isAnimating = false;
    }, 100);
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

    if (nextPos === 3) {
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

  outerNav();
});
