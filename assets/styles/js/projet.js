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
    var count = $items.length;
    $items.removeClass('slider--item-left slider--item-center slider--item-right slider--item-hidden');

    if (count === 1) {
        $items.eq(0).addClass('slider--item-center');
    } else if (count === 2) {
        $items.eq(1).addClass('slider--item-right');
        $items.eq(0).addClass('slider--item-center');
    } else {
        var currentCenterIndex = $('.slider .slider--item-center').index();
        var nextCenterIndex = (currentCenterIndex + 1) % count;   
        var leftIndex = (nextCenterIndex - 1 + count) % count; 
        var rightIndex = (nextCenterIndex + 1) % count;
        $items.eq(leftIndex).addClass('slider--item-left');
        $items.eq(nextCenterIndex).addClass('slider--item-center');
        $items.eq(rightIndex).addClass('slider--item-right');

        for (var i = 0; i < count; i++) {
            if (i !== leftIndex && i !== nextCenterIndex && i !== rightIndex) {
                $items.eq(i).addClass('slider--item-hidden');
            }
        }
    }
}

$('.slider--prev').click(function () {
    var $slider = $('.slider');
    var $items = $slider.children();
    $items.first().appendTo($slider); 
    updateSliderClasses();
});

$('.slider--next').click(function () {
    var $slider = $('.slider');
    var $items = $slider.children();
    $items.last().prependTo($slider);
    updateSliderClasses(); 
});

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

workSlider();
transitionLabels();
