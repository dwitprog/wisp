/**
 * Объединённый селект Date & Time: при открытии — выбор даты, после выбора даты — слоты.
 * При повторном открытии снова даты (с отмеченным выбранным). Данные из rgData и data-date-options.
 */
function getBookedStateForDate(dateStr) {
    if (typeof rgData === "undefined" || !Array.isArray(rgData.booking_dates)) return null;
    const idx = rgData.booking_dates.indexOf(dateStr);
    if (idx === -1) return null;
    const dayKey = String(idx + 1);
    return rgData.booking_booked && rgData.booking_booked[dayKey] ? rgData.booking_booked[dayKey] : null;
}

function getSlotLabels() {
    return typeof rgData !== "undefined" &&
        Array.isArray(rgData.booking_slot_labels) &&
        rgData.booking_slot_labels.length >= 10
        ? rgData.booking_slot_labels
        : [
              "10:00-10:45",
              "11:00-11:45",
              "12:00-12:45",
              "14:00-14:45",
              "15:00-15:45",
              "16:00-16:45",
              "17:00-17:45",
              "18:00-18:45",
              "19:00-19:45",
              "20:00-20:45",
          ];
}

export function initBookingSlots(containerSelector = "#popupForm .have-a-questions") {
    const container = document.querySelector(containerSelector);
    if (!container) return;

    const block = container.querySelector(".select-booking-datetime.custom-select");
    const listEl = block?.querySelector("[data-booking-datetime-list]");
    const topEl = block?.querySelector(".custom-select_top");
    const titleEl = block?.querySelector(".custom-select_title");
    const dateHidden = block?.querySelector(".booking-date-hidden");
    const slotHidden = block?.querySelector(".booking-slot-hidden");
    if (!block || !listEl || !topEl || !titleEl || !dateHidden || !slotHidden) return;

    let dateOptions = [];
    try {
        const raw = block.getAttribute("data-date-options");
        if (raw) dateOptions = JSON.parse(raw);
    } catch (e) {
        dateOptions = [];
    }
    if (!Array.isArray(dateOptions)) dateOptions = [];

    let selectedDate = (dateHidden.value || "").trim();
    let selectedSlot = (slotHidden.value || "").trim();
    let step = "date";

    function updateTitle() {
        if (selectedDate && selectedSlot) titleEl.textContent = selectedDate + ", " + selectedSlot;
        else if (selectedDate) titleEl.textContent = getDateLabel(selectedDate) + " — choose time";
        else titleEl.textContent = "Date & Time";
    }

    function getDateLabel(value) {
        const o = dateOptions.find(d => d.value === value);
        return o ? o.label : value;
    }

    function renderDates() {
        step = "date";
        listEl.innerHTML = "";
        dateOptions.forEach((opt, i) => {
            const id = "booking_datetime_date_" + i;
            const checked = selectedDate === opt.value ? " checked" : "";
            const item = document.createElement("div");
            item.className = "custom-select_item";
            item.innerHTML = `
                <input type="radio" name="booking_datetime_date" value="${opt.value}" id="${id}"${checked}>
                <label for="${id}"><span></span>${opt.label}</label>`;
            listEl.appendChild(item);
        });
        listEl.querySelectorAll('input[name="booking_datetime_date"]').forEach(radio => {
            radio.addEventListener("change", onDatePick);
        });
    }

    function onDatePick() {
        const radio = listEl.querySelector('input[name="booking_datetime_date"]:checked');
        if (!radio) return;
        selectedDate = radio.value;
        dateHidden.value = selectedDate;
        dateHidden.dispatchEvent(new Event("change", { bubbles: true }));
        renderSlots();
    }

    function renderSlots() {
        step = "slot";
        const booked = getBookedStateForDate(selectedDate);
        const labels = getSlotLabels();
        const free = [];
        if (booked && booked.length >= 10) {
            for (let i = 0; i < 10; i++) {
                if (!booked[i]) free.push({ label: labels[i], index: i });
            }
        } else {
            labels.forEach((label, i) => free.push({ label: label, index: i }));
        }

        listEl.innerHTML = "";
        if (free.length === 0) {
            listEl.innerHTML = `
                <div class="custom-select_item">
                    <input type="radio" name="booking_datetime_slot" value="" id="booking_slot_none" disabled>
                    <label for="booking_slot_none"><span></span>No free slots</label>
                </div>`;
            updateTitle();
            return;
        }

        free.forEach((item, i) => {
            const id = "booking_datetime_slot_" + i;
            const checked = selectedSlot === item.label ? " checked" : "";
            const el = document.createElement("div");
            el.className = "custom-select_item";
            el.innerHTML = `
                <input type="radio" name="booking_datetime_slot" value="${item.label}" id="${id}" data-slot-index="${item.index}"${checked}>
                <label for="${id}"><span></span>${item.label}</label>`;
            listEl.appendChild(el);
        });
        listEl.querySelectorAll('input[name="booking_datetime_slot"]').forEach(radio => {
            radio.addEventListener("change", onSlotPick);
        });
        updateTitle();
    }

    function onSlotPick() {
        const radio = listEl.querySelector('input[name="booking_datetime_slot"]:checked');
        if (!radio) return;
        selectedSlot = radio.value;
        slotHidden.value = selectedSlot;
        slotHidden.dispatchEvent(new Event("change", { bubbles: true }));
        updateTitle();
        topEl.classList.add("valide");
        topEl.classList.remove("active");
        listEl.classList.remove("active");
    }

    topEl.addEventListener("click", () => {
        const isOpen = topEl.classList.contains("active");
        if (isOpen) {
            topEl.classList.remove("active");
            listEl.classList.remove("active");
            return;
        }
        topEl.classList.add("active");
        listEl.classList.add("active");
        if (step === "date" || !selectedDate) renderDates();
        else renderSlots();
    });

    document.addEventListener("click", e => {
        if (!block.contains(e.target)) {
            topEl.classList.remove("active");
            listEl.classList.remove("active");
        }
    });

    updateTitle();
}
