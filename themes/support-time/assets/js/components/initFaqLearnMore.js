/**
 * По клику на "Learn more" плавно раскрываем блок и показываем faq_item_text_detail снизу (дополнение к тексту).
 */
export function initFaqLearnMore(containerSelector = "body") {
    const container =
        typeof containerSelector === "string" ? document.querySelector(containerSelector) : containerSelector;
    const root = container || document;

    root.querySelectorAll(".faq .item .content, .faq-content .item .content").forEach(content => {
        const detailBlock = content.querySelector(".faq_item_text_detail");
        const btn = content.querySelector(".faq-learn-more");

        if (!detailBlock || !btn) return;
        const detailText = (detailBlock.textContent || "").trim();
        if (!detailText) return;

        detailBlock.setAttribute("aria-hidden", "true");
        detailBlock.classList.add("faq-detail-hidden");

        btn.addEventListener("click", e => {
            e.preventDefault();

            const isExpanded = detailBlock.classList.contains("faq-detail-expanded");
            if (isExpanded) {
                detailBlock.classList.remove("faq-detail-expanded");
                detailBlock.classList.add("faq-detail-hidden");
                detailBlock.setAttribute("aria-hidden", "true");
                btn.textContent = "learn more";
            } else {
                detailBlock.classList.remove("faq-detail-hidden");
                detailBlock.classList.add("faq-detail-expanded");
                detailBlock.setAttribute("aria-hidden", "false");
                btn.textContent = "show less";
            }
        });
    });
}
