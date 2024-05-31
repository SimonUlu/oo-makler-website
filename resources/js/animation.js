export function addFadeInAnimation() {
    const elements = document.querySelectorAll(".fade-in-animation");
    let options = {
        root: null,
        rootMargin: '0px',
        threshold: 0.5
    }

    let callback = (entries, observer) => {
        entries.forEach(entry => {

            if (entry.isIntersecting) {

                entry.target.classList.remove("invisible");
                entry.target.classList.add("animate-fade-right", "animate-ease-out", "animate-once", "animate-duration-[2000ms]");
                observer.unobserve(entry.target);
            }
        });
    };

    let observer = new IntersectionObserver(callback, options);

    elements.forEach(element => {
      observer.observe(element);
    });
}

