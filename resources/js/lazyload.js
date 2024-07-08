export function lazyloadImages() {
    let lazyImages = [].slice.call(document.querySelectorAll("img.lazy:not([data-observed])"));
    let imagesToLoad = lazyImages.length;

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
                        var spinner =
                            this.parentElement.parentElement.querySelector(
                                ".spinner"
                            );

                        if (spinner) {
                            spinner.style.display = "none";
                            spinner.classList.remove("animate-spin");
                        }

                        // Reduce the number of images to load
                        imagesToLoad--;

                        // If all images are loaded, remove all spinners
                        if (imagesToLoad === 0) {
                            document
                                .querySelectorAll(".spinner")
                                .forEach((spinner) => {
                                    spinner.style.display = "none";
                                    spinner.classList.remove("animate-spin");
                                });
                        }
                    };
                    lazyImage.removeAttribute("loading");
                    lazyImage.dataset.observed = 'true';
                    lazyImageObserver.unobserve(lazyImage);
                }
            });
        });

        lazyImages.forEach(function (lazyImage) {
            lazyImageObserver.observe(lazyImage);
        });
    } else {
        // Fallback for browsers that don't support IntersectionObserver
        let lazyImageScrollHandler = function() {
            if (imagesToLoad === 0) {
                document.removeEventListener("scroll", lazyImageScrollHandler);
                window.removeEventListener("resize", lazyImageScrollHandler);
                window.removeEventListener("orientationchange", lazyImageScrollHandler);
                return;
            }

            lazyImages.forEach(function(lazyImage) {
                if ((lazyImage.getBoundingClientRect().top <= window.innerHeight && lazyImage.getBoundingClientRect().bottom >= 0) && getComputedStyle(lazyImage).display !== "none") {
                    lazyImage.src = lazyImage.dataset.src;
                    lazyImage.onload = function() {
                        var spinner = this.parentElement.parentElement.querySelector(".spinner");
                        if (spinner) {
                            spinner.style.display = "none";
                            spinner.classList.remove("animate-spin");
                        }
                        imagesToLoad--;
                        if (imagesToLoad === 0) {
                            document.querySelectorAll(".spinner").forEach((spinner) => {
                                spinner.style.display = "none";
                                spinner.classList.remove("animate-spin");
                            });
                        }
                    };
                    lazyImage.removeAttribute("loading");
                    lazyImage.dataset.observed = 'true';
                    lazyImages = lazyImages.filter(function(image) { return image !== lazyImage; });
                }
            });
        };

        document.addEventListener("scroll", lazyImageScrollHandler);
        window.addEventListener("resize", lazyImageScrollHandler);
        window.addEventListener("orientationchange", lazyImageScrollHandler);
        lazyImageScrollHandler();
    }
}

