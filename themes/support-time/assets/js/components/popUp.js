class PopUp {
    constructor(btnGetPopup) {
        this.btnGetPopup = btnGetPopup;
        const isString = typeof btnGetPopup === "string";
        if (this.btnGetPopup) {
            // Окно
            let popup = document.getElementById(
                isString ? this.btnGetPopup : this.btnGetPopup?.getAttribute("data-pop"),
            );

            if (popup) {
                // Записываем в localStorage открытие каждого окна.
                this.openPopUpsCounter("open-popups");
                // Убираем скрол у body
                document.querySelector("html").style.cssText = "overflow: hidden;margin-right: 15px;";
                // Кастомный заголовок
                let popupTitle = isString ? 0 : this.btnGetPopup?.getAttribute("data-title");
                // Кастомный заголовок для формы, для отправки на back
                let popupFormTitle = isString ? 0 : this.btnGetPopup?.getAttribute("data-form-title");
                // Кастомный комментарий для формы, для отправки на back
                let popupFormComment = isString ? 0 : this.btnGetPopup?.getAttribute("data-form-comment");
                // Передаём тариф для формы, для отправки на back
                let popupFormTariff = isString ? 0 : this.btnGetPopup?.getAttribute("data-form-tariff");
                // Передаём цену для формы, для отправки на back
                let popupFormPrice = isString ? 0 : this.btnGetPopup?.getAttribute("data-form-price");
                // Кастомный продукт
                let popupProduct = isString ? 0 : this.btnGetPopup?.getAttribute("data-product");
                // У последующего открытого окна z-index будет > предыдущего
                popup.style.zIndex = this.popUpCounter <= 0 ? 999 : this.popUpCounter;
                // Блок .pop с контентом
                const popupContent = popup.querySelector(".pop");
                // Создаем и добавляем контейнер окна, для дальнейшей реализации прокрутки длинных окон
                let popupContainer;
                if (!popup.querySelector(".popup-container")) {
                    popupContainer = document.createElement("div");
                    popupContainer.setAttribute("class", "popup-container");
                    popupContent.parentNode.insertBefore(popupContainer, popupContent);
                    popupContainer.appendChild(popupContent);
                } else {
                    popupContainer = popup.querySelector(".popup-container");
                }
                // Блок .pop.img c картинкой
                const popupContentImg = popup.querySelector(".pop.img");
                if (popupContentImg) {
                    // Атрибут с ссылкой на картинку полного размера
                    const popupFullImg = this.btnGetPopup?.getAttribute("data-full-img");
                }
                // Блок .pop.video c iframe в котором будет видео
                const popupContentVideo = popup.querySelector(".pop.video");
                if (popupContentVideo) {
                    // Атрибут с ссылкой на видео
                    const popupFullVideo = this.btnGetPopup?.getAttribute("data-full-video");
                }
                // Устанавливаем максимальную ширину окна
                let popupMaxWidth = popup.getAttribute("data-max-width");
                popupMaxWidth = popupMaxWidth ? popupMaxWidth : "";
                popupContent.style.maxWidth = `${popupMaxWidth}px`;
                // Устанавливаем минимальную высоту окна
                let popupMinHeight = popup.getAttribute("data-min-height");
                popupMinHeight =
                    popupMinHeight && !popup.classList.contains("full") ? `${popupMinHeight}px` : "max-content";
                popupContent.style.minHeight = popupMinHeight;
                // Создаем кнопку закрытия окна и вставляем в popupContent
                this.closeBtnCreate(popup, popupContent);
                // Проверка на существование окон с картинками или видео
                if (popupContentImg) {
                    // Если пусто и картинки нет
                    let imgToPop = popupContentImg.querySelector("img");
                    if (!imgToPop) {
                        // Создаем и вставляем в popupContentImg картинку
                        const createImg = document.createElement("img");
                        createImg.style.width = "100%";
                        popupContentImg.prepend(createImg);
                        imgToPop = createImg;
                    }
                    imgToPop.src = popupFullImg;
                } else if (popupContentVideo) {
                    // Если пусто и видео нет
                    let videoToPop = popupContentVideo.querySelector("iframe");
                    let widthVideo = this.btnGetPopup?.getAttribute("data-width-video")
                        ? this.btnGetPopup?.getAttribute("data-width-video")
                        : 560;
                    if (widthVideo >= window.innerWidth) {
                        widthVideo = window.innerWidth - 100 + "px";
                    }
                    let heightVideo = this.btnGetPopup?.getAttribute("data-height-video")
                        ? this.btnGetPopup?.getAttribute("data-height-video")
                        : 315;
                    if (heightVideo >= window.innerHeight) {
                        heightVideo = window.innerHeight - 100 + "px";
                    }
                    popupContent.style.maxWidth = widthVideo + "px";
                    if (!videoToPop) {
                        // Создаем и вставляем в popupContentVideo видео
                        const createVideo = document.createElement("iframe");
                        createVideo.style.width = widthVideo;
                        createVideo.style.height = heightVideo;
                        createVideo.setAttribute("allow", "autoplay;");
                        //createVideo.setAttribute('frameborder', '0');
                        popupContentVideo.prepend(createVideo);
                        videoToPop = createVideo;
                    }
                    videoToPop.src = popupFullVideo + "?autoplay=1";
                }
                //Создаем лоадер если у нас идет вызов картинок или видео
                let imgLoader = document.querySelector("img.loader-popup");

                if (popupContentImg || popupContentVideo) {
                    if (!imgLoader) {
                        const createImgLoader = document.createElement("img");
                        createImgLoader.src = "/wp-content/themes/govorov.top/assets/img/widgets/popup/loader.gif";
                        createImgLoader.className = "loader-popup";
                        document.querySelector("body").prepend(createImgLoader);
                        imgLoader = createImgLoader;
                    }
                }

                // Показываем окно
                if (popupContentImg) {
                    popupContentImg.querySelector("img").onload = ev => {
                        if (ev.path[0].src) {
                            this.fadeOut(imgLoader);
                            popup.classList.add("active");
                            // Центруем окно
                            this.alignmentPopUps(popupContent, popupContainer);
                        }
                    };
                } else if (popupContentVideo) {
                    popupContentVideo.querySelector("iframe").onload = ev => {
                        if (ev.path[0].src) {
                            this.fadeOut(imgLoader);
                            popup.classList.add("active");
                            // Центруем окно
                            this.alignmentPopUps(popupContent, popupContainer);
                        }
                    };
                } else {
                    popup.classList.remove("d-none");
                    popup.classList.add("active");
                    // Центруем окно
                    this.alignmentPopUps(popupContent, popupContainer);
                }

                // По клику чистим src и закрываем окно
                this.closeBtn.onclick = () => {
                    if (popupContentImg) {
                        popupContentImg.querySelector("img").removeAttribute("src");
                    } else if (popupContentVideo) {
                        popupContentVideo.querySelector("iframe").removeAttribute("src");
                    }
                    //this.fadeOut(popup);
                    popup.classList.remove("active");
                    popup.classList.add("d-none");
                    // Возвращаем скрол у body
                    document.querySelector("html").style.cssText = "overflow: auto;margin: auto;";
                };
                //Обновляем заголовок если имеется
                if (popupTitle) {
                    let title = popup.querySelector(".title");
                    if (title) {
                        popup.querySelector(".title").innerHTML = this.replaceSubstringsOnHTMLTags(popupTitle);
                    } else {
                        let defaultTitle = popup.querySelector(".title").getAttribute("data-default-title");
                        if (defaultTitle) popup.querySelector(".title").innerText = defaultTitle;
                    }
                }
                //Обновляем значение title в скрытых полях форм, если имеется
                if (popupFormTitle) {
                    popup.querySelector('input[name="title"]').value = popupFormTitle;
                }
                //Обновляем значение comment в скрытых полях форм, если имеется
                if (popupFormComment) {
                    popup.querySelector('input[name="comment"]').value = popupFormComment;
                }
                //Обновляем значение тарифа в скрытых полях форм, если имеется
                if (popupFormTariff) {
                    if (popupFormTariff === "false") {
                        popup.querySelector('input[name="tariff"]').value = "";
                    } else {
                        popup.querySelector('input[name="tariff"]').value = popupFormTariff;
                    }
                }
                //Обновляем значение цены в скрытых полях форм, если имеется
                if (popupFormPrice) {
                    if (popupFormPrice === "false") {
                        popup.querySelector('input[name="price"]').value = "";
                    } else {
                        popup.querySelector('input[name="price"]').value = popupFormPrice;
                    }
                }
                //Обновляем продукт если имеется
                if (popupProduct) {
                    let product = popup.querySelector('input[name="product"]');
                    if (product) {
                        product.value = popupProduct;
                    }
                }
            } else {
                alert("Окно вызываемое по данной «кнопке» не найдено!");
            }
        }
    }

    /**
     * Записываем в localStorage открытие каждого окна.
     * Для того чтобы последующие открытые окна внутри окон были выше уже открытых.
     * @param name
     */
    openPopUpsCounter(name) {
        this.popUpCounter = Number(localStorage.getItem(name));
        if (!this.popUpCounter) localStorage.setItem(name, 100);
        else localStorage.setItem(name, ++this.popUpCounter);
    }

    /**
     * Создаем кнопку закрытия окна и вставляем в popupContainer
     * @param popup - Где ищем
     * @param popupContent - куда вставляем
     */
    closeBtnCreate(popup, popupContent) {
        this.closeBtn = popup.querySelector(".close");
        if (!this.closeBtn) {
            const createCloseBtn = document.createElement("span");
            createCloseBtn.className = "close";
            popupContent.prepend(createCloseBtn);
            this.closeBtn = createCloseBtn;
        }
    }

    /**
     * Функция для установки popUp по центру экрана
     * @param popupContent
     * @param popupContainer
     */
    alignmentPopUps(popupContent, popupContainer) {
        // Получаем высоту popupContent, для включения прокрутки, если оно слишком длинное и для от центровки
        const popupContentHeight = popupContent.clientHeight;
        // Устанавливаем минимальную высоту окна, зависит от размера popupContent
        popupContainer.style.minHeight = popupContentHeight + 100 + "px";
        // Считаем размер окна для от центровки
        const userWindow = window.outerWidth;
        const screenUserHeight = Number(window.innerHeight);
        const marginTop = (screenUserHeight - popupContentHeight) / 2;
        if (marginTop > 0 && popupContentHeight !== 0) {
            popupContent.style.marginTop = userWindow <= 991 ? marginTop + "px" : marginTop + "px";
        } else {
            popupContent.style.margin = userWindow <= 991 ? 50 + "px auto" : "50px auto";
        }
    }

    /**
     * Функция анимации появления окна
     * @param el
     * @param displayClass
     */
    fadeIn(el, displayClass) {
        el.style.opacity = "0";
        el.style.display = displayClass || "block";
        (function fade() {
            let val = Number(el.style.opacity);
            if (!((val += 0.1) > 1)) {
                el.style.opacity = `${val}`;
                requestAnimationFrame(fade);
            }
        })();
    }

    /**
     * Функция анимации скрытия окна
     * @param el
     */
    fadeOut(el) {
        el.style.opacity = "1";
        (function fade() {
            if ((el.style.opacity -= ".1") < 0) {
                el.style.display = "none";
            } else {
                requestAnimationFrame(fade);
            }
        })();
    }

    /**
     * Заменяем все вхождения [!___!] в строке на HTML теги
     * Примеры:
     * "какой-то текст и [!b!]ЖИРНЫЙ[!/b!]";
     * "какой-то текст и [!br!]с новой строки";
     * "какой-то текст и [!i!]наклонный[!/i!] текст";
     */
    replaceSubstringsOnHTMLTags(str) {
        return str.replace(/\[\!(.*?)\!\]/g, (match, p1) => {
            // Проверка на наличие закрывающего тега
            if (p1.startsWith("/")) {
                return `</${p1.slice(1)}>`;
            } else {
                return `<${p1}>`;
            }
        });
    }
}

export default PopUp;
