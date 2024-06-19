export function lazyloadImages() {
    let lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));
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
                            spinner.classList.remove("animate-spin"); // Entferne die animate-spin Klasse
                        }

                        // Reduziere die Anzahl der zu ladenden Bilder
                        imagesToLoad--;

                        // Wenn alle Bilder geladen sind, entferne alle Spinner
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
        rootMargin: "0px",
        threshold: 0.1,
    };
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                let userid = entry.target.getAttribute("data-user-id");
                let estateid = entry.target.getAttribute("data-estate-id");
                Livewire.emit("loadUser", userid);
                observer.unobserve(entry.target);
                console.log("User is loaded");
            }
        });
    }, options);

    const targets = document.querySelectorAll(".lazy-user");
    targets.forEach((target) => observer.observe(target));
}
