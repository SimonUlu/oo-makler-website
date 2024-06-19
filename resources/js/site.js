import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";
import morph from "@alpinejs/morph";
import persist from "@alpinejs/persist";
import focus from "@alpinejs/focus";
import Intersect from "@alpinejs/intersect";
import "focus-visible";
import axios from "axios";
import "flowbite";
import Choices from "choices.js";
import 'tailwindcss/tailwind.css'
import 'tailwindcss-animated';
import { lazyloadImages, lazyloadUsers } from "./lazyload.js";
import { addFadeInAnimation } from "./animation.js";


// import * as Sentry from "@sentry/browser";
// Sentry.init({
//     dsn: import.meta.env.VITE_SENTRY_DSN_PUBLIC,
// });

// Call Alpine.
window.Alpine = Alpine;
Alpine.plugin([collapse, focus, morph, persist, Intersect]);
Alpine.start();

window.axios = axios;
window.Choices = Choices;
// add lazyloadImages to the window object so it can be called from the DOM.
window.lazyloadImages = lazyloadImages;

document.addEventListener('click', function(event) {
    if (event.target.matches('.pagination button')) {
        scrollToTop();
    }
    if (event.target.matches('.pagination-button')) {
        scrollToTop();
    }
});

// add lazyloadImages to the window object so it can be called from the DOM.
document.addEventListener("DOMContentLoaded", function () {
    // initial load
    lazyloadImages();
    lazyloadUsers();
    addFadeInAnimation();
});
// Listen to dataUpdated event emitted from livewire and rerun lazyloadImages
document.addEventListener("dataUpdated", function () {
    lazyloadImages();
    lazyloadUsers();
});


// Global get CSRF token function (used by forms).
window.getToken = async () => {
    return await fetch("/!/statamic-peak-tools/dynamic-token/refresh")
        .then((res) => res.json())
        .then((data) => {
            return data.csrf_token;
        })
        .catch((error) => {
            this.error = "Something went wrong. Please try again later.";
        });
};
// initialize Sentry

// manipulate some text nodes
window.addEventListener("DOMContentLoaded", (event) => {
    // Walk the DOM to find text nodes
    function walk(node) {
        let child, next;

        switch (node.nodeType) {
            case 1: // Element
            case 9: // Document
            case 11: // Document fragment
                child = node.firstChild;
                while (child) {
                    next = child.nextSibling;
                    walk(child);
                    child = next;
                }
                break;

            case 3: // Text node
                handleTextNode(node);
                break;
        }
    }

    // Handle the text node
    function handleTextNode(node) {
        let text = node.nodeValue;
        const searchValue = "_Kontaktieren Sie uns_";

        if (text.includes(searchValue)) {
            const newText = text.replace(
                searchValue,
                `<a href='/kontakt' class='font-medium text-primary-600 dark:text-primary-500 hover:underline'>Kontaktieren Sie uns</a>`
            );
            const parentNode = node.parentNode;
            const newElement = document.createElement("span");
            newElement.innerHTML = newText;
            parentNode.replaceChild(newElement, node);
        }
    }

    walk(document.body);
});

function scrollToTop() {
    console.log("Hallo");
    window.scrollTo({
        top: 0,
        behavior: 'smooth' // Mit "smooth" wird ein animiertes Scrollen aktiviert
    });
     // Den Fokus vom Button entfernen
     this.blur();
}
