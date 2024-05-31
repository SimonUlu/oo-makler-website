export function lazyloadImages() {
    // do lazyloading
    let lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));

    if (
        "IntersectionObserver" in window &&
        "IntersectionObserverEntry" in window &&
        "isIntersecting" in window.IntersectionObserverEntry.prototype
    ) {
        let lazyImageObserver = new IntersectionObserver(function (
            entries,
            observer
        ) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    let lazyImage = entry.target;
                    lazyImage.src = lazyImage.dataset.src;
                    lazyImage.onload = function () {
                        console.log("loaded");
                        var spinner =
                            this.parentElement.parentElement.querySelector(
                                ".spinner"
                            );

                        if (spinner) {
                            spinner.style.display = "none";
                        }
                    };
                    lazyImage.removeAttribute("loading");
                    lazyImageObserver.unobserve(lazyImage);
                }
            });
        });

        lazyImages.forEach(function (lazyImage) {
            lazyImageObserver.observe(lazyImage);
        });
    }
}

export function lazyloadUsers() {
    // site.js
    const options = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    }
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                let userid = entry.target.getAttribute('data-user-id');
                let estateid = entry.target.getAttribute('data-estate-id');
                Livewire.emit('loadUser', userid);
                observer.unobserve(entry.target);
                console.log("User is loaded");
            }
        });
    }, options);

    const targets = document.querySelectorAll('.lazy-user');
    targets.forEach(target => observer.observe(target));

}
