document.addEventListener("DOMContentLoaded", function () {
    const toc = document.getElementById("rank-math-toc");
    if (!toc) return;
    const title = toc.querySelector("h2");
    const nav = toc.querySelector("nav");

    if (!title || !nav) return;

    title.style.cursor = "pointer";

    title.addEventListener("click", function () {
        nav.classList.toggle("open");
    });
});
