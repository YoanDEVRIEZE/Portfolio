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
