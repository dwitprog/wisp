/**
 * audioController - контроллер аудио-плеера
 * Управляет воспроизведением, переключением треков, синхронизацией с визуализатором и логированием
 *
 * @param {Object} visualizer - экземпляр визуализатора (soundWaveVisualizer)
 * @param {Boolean} debug - включение/выключение логирования
 * @returns {Object} API с методами: play, pause, next, prev, getCurrentIndex
 */
export function audioController(visualizer, debug = false) {
    // Получаем все элементы аудио-треков
    const items = [...document.querySelectorAll("[data-audio-item]")];

    // Из каждого item берём элемент <audio>
    const audios = items.map(i => i.querySelector("audio"));

    // Индекс текущего активного трека
    let currentIndex = items.findIndex(i => i.classList.contains("active"));
    if (currentIndex === -1) currentIndex = 0; // Если нет активного, ставим 0

    // Флаг блокировки при быстром переключении NEXT/PREV
    let isSwitching = false;

    /**
     * Удобная функция логирования действий
     * @param {string} action - описание действия
     * @param {Object} extra - дополнительные данные для лога
     */
    function log(action, extra = {}) {
        if (!debug) return;
        console.group(`🎵 AUDIO | ${action}`);
        console.log("currentIndex:", currentIndex);
        console.log("audio:", audios[currentIndex]);
        Object.entries(extra).forEach(([k, v]) => console.log(k + ":", v));
        console.groupEnd();
    }

    /**
     * setActive - устанавливает активный трек
     * 1. Останавливает предыдущий трек
     * 2. Снимает класс active с предыдущего элемента
     * 3. Обновляет currentIndex
     * 4. Добавляет класс active к новому элементу
     *
     * @param {number} index - индекс трека, который нужно сделать активным
     */
    function setActive(index) {
        if (index === currentIndex) return; // Если уже активный, ничего не делаем

        log("setActive()", { to: index });

        // Останавливаем предыдущий трек
        const prevAudio = audios[currentIndex];
        prevAudio.pause();
        prevAudio.currentTime = 0;

        // Убираем активный класс с предыдущего элемента
        items[currentIndex].classList.remove("active");

        // Обновляем индекс активного трека
        currentIndex = index;

        // Добавляем активный класс к новому элементу
        items[currentIndex].classList.add("active");
    }

    /**
     * play - воспроизводит текущий аудио-трек
     * 1. Защита от повторного вызова play, если трек уже играет
     * 2. Логирование
     * 3. Воспроизведение аудио
     * 4. Старт визуализатора, если он ещё не работает
     */
    function play() {
        const audio = audios[currentIndex];

        if (!audio.paused) {
            log("play() проигнорирован, уже играет");
            return;
        }

        log("play()");
        audio.play().catch(err => console.warn("play() error:", err));

        if (!visualizer.getState || !visualizer.getState().isAnimating) {
            visualizer.start();
        }
    }

    /**
     * pause - ставит текущий трек на паузу
     * 1. Защита от повторного вызова pause
     * 2. Логирование
     * 3. Остановка аудио
     * 4. Остановка визуализатора
     */
    function pause() {
        const audio = audios[currentIndex];

        if (audio.paused) {
            log("pause() проигнорирован, уже на паузе");
            return;
        }

        log("pause()");
        audio.pause();
        visualizer.stop();
    }

    /**
     * next - переключение на следующий трек
     * 1. Блокировка повторного переключения через isSwitching
     * 2. Вычисление nextIndex с цикличностью
     * 3. Логирование
     * 4. Установка активного трека и запуск воспроизведения
     * 5. Сброс флага блокировки через requestAnimationFrame
     */
    function next() {
        if (isSwitching) return;
        isSwitching = true;

        const nextIndex = (currentIndex + 1) % audios.length;
        log("NEXT", { nextIndex });

        setActive(nextIndex);
        play();

        requestAnimationFrame(() => (isSwitching = false));
    }

    /**
     * prev - переключение на предыдущий трек
     * 1. Блокировка повторного переключения через isSwitching
     * 2. Вычисление prevIndex с цикличностью
     * 3. Логирование
     * 4. Установка активного трека и запуск воспроизведения
     * 5. Сброс флага блокировки через requestAnimationFrame
     */
    function prev() {
        if (isSwitching) return;
        isSwitching = true;

        const prevIndex = (currentIndex - 1 + audios.length) % audios.length;
        log("PREV", { prevIndex });

        setActive(prevIndex);
        play();

        requestAnimationFrame(() => (isSwitching = false));
    }

    /**
     * Авто-переключение при завершении трека
     * Если текущий трек заканчивается, вызываем next()
     */
    audios.forEach((audio, index) => {
        audio.onended = () => {
            if (index === currentIndex) {
                log("ended → next()");
                next();
            }
        };
    });

    /**
     * Возвращаем публичное API:
     * play, pause, next, prev — методы управления
     * getCurrentIndex — получение индекса текущего активного трека
     */
    return { play, pause, next, prev, getCurrentIndex: () => currentIndex };
}
