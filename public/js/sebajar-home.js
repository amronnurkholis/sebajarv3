document.addEventListener("DOMContentLoaded", () => {
    const header = document.querySelector("#siteHeader");
    const menuButton = document.querySelector("[data-menu-toggle]");
    const mobileMenu = document.querySelector("[data-mobile-menu]");
    const navLinks = document.querySelectorAll(".nav-link");
    const sections = document.querySelectorAll("main section[id]");
    const revealItems = document.querySelectorAll(".reveal");

    // Header shadow when scrolling.
    const updateHeader = () => {
        if (window.scrollY > 10) {
            header?.classList.add("is-scrolled");
        } else {
            header?.classList.remove("is-scrolled");
        }
    };

    updateHeader();
    window.addEventListener("scroll", updateHeader, { passive: true });

    // Mobile navigation.
    menuButton?.addEventListener("click", () => {
        const isOpen = mobileMenu?.classList.toggle("is-open") ?? false;

        menuButton.setAttribute("aria-expanded", String(isOpen));

        const icon = menuButton.querySelector(".material-symbols-outlined");
        if (icon) {
            icon.textContent = isOpen ? "close" : "menu";
        }
    });

    navLinks.forEach((link) => {
        link.addEventListener("click", () => {
            mobileMenu?.classList.remove("is-open");
            menuButton?.setAttribute("aria-expanded", "false");

            const icon = menuButton?.querySelector(".material-symbols-outlined");
            if (icon) icon.textContent = "menu";
        });
    });

    // Active navigation based on the current section.
    const sectionObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;

                const id = entry.target.getAttribute("id");

                navLinks.forEach((link) => {
                    link.classList.toggle(
                        "is-active",
                        link.getAttribute("href") === `#${id}`
                    );
                });
            });
        },
        {
            rootMargin: "-35% 0px -55% 0px",
            threshold: 0
        }
    );

    sections.forEach((section) => sectionObserver.observe(section));

    // Reveal-on-scroll.
    if ("IntersectionObserver" in window) {
        const revealObserver = new IntersectionObserver(
            (entries, observer) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;

                    entry.target.classList.add("is-visible");
                    observer.unobserve(entry.target);
                });
            },
            {
                threshold: 0.12
            }
        );

        revealItems.forEach((item) => revealObserver.observe(item));
    } else {
        revealItems.forEach((item) => item.classList.add("is-visible"));
    }

    // Featured costume carousel: keeps images large without shrinking all items.
    const productCarousel = document.querySelector("[data-product-carousel]");
    const previousProductButton = document.querySelector("[data-product-carousel-prev]");
    const nextProductButton = document.querySelector("[data-product-carousel-next]");

    if (productCarousel && previousProductButton && nextProductButton) {
        const getScrollAmount = () => {
            const card = productCarousel.querySelector(".costume-card");
            const gap = Number.parseFloat(getComputedStyle(productCarousel).gap) || 0;
            return (card?.getBoundingClientRect().width || productCarousel.clientWidth) + gap;
        };

        previousProductButton.addEventListener("click", () => {
            productCarousel.scrollBy({ left: -getScrollAmount(), behavior: "smooth" });
        });

        nextProductButton.addEventListener("click", () => {
            productCarousel.scrollBy({ left: getScrollAmount(), behavior: "smooth" });
        });
    }
});
