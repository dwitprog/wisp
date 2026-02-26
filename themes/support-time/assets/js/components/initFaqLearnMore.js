/**
 * По клику на "Learn more" плавно раскрываем блок и показываем faq_item_text_detail снизу (дополнение к тексту).
 * На странице /qa/ (page-44) текст кнопки: "Learn more about this point" / "Show less", у кнопки скрытия margin-top: 20px.
 */
export function initFaqLearnMore(containerSelector = "body") {
    const container =
        typeof containerSelector === "string" ? document.querySelector(containerSelector) : containerSelector;
    const root = container || document;
    const isPage44 = document.querySelector(".page-44.faq");
    const labelMore = isPage44 ? "Learn more about this point" : "learn more";
    const labelLess = isPage44 ? "Show less" : "show less";

    root.querySelectorAll(".faq .item .content, .faq-content .item .content").forEach(content => {
        const detailBlock = content.querySelector(".faq_item_text_detail");
        const btn = content.querySelector(".faq-learn-more");

        if (!detailBlock || !btn) return;
        const detailText = (detailBlock.textContent || "").trim();
        if (!detailText) return;

        detailBlock.setAttribute("aria-hidden", "true");
        detailBlock.classList.add("faq-detail-hidden");
        if (isPage44 && btn.textContent.trim().toLowerCase().includes("learn more")) {
            btn.textContent = labelMore;
        }

        const collapseDuration = 450;

        btn.addEventListener("click", e => {
            e.preventDefault();

            const isExpanded = detailBlock.classList.contains("faq-detail-expanded");
            if (isExpanded) {
                detailBlock.classList.remove("faq-detail-expanded");
                detailBlock.classList.add("faq-detail-hidden");
                detailBlock.setAttribute("aria-hidden", "true");
                window.setTimeout(() => {
                    btn.textContent = labelMore;
                    btn.classList.remove("is-expanded");
                }, collapseDuration);
            } else {
                detailBlock.classList.remove("faq-detail-hidden");
                detailBlock.classList.add("faq-detail-expanded");
                detailBlock.setAttribute("aria-hidden", "false");
                btn.textContent = labelLess;
                btn.classList.add("is-expanded");
            }
        });
    });
}
