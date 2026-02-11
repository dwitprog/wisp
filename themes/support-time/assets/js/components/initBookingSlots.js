/**
 * Слоты записи по дням (1=сегодня, 2=завтра, 3=послезавтра) и 10 слотов в день.
 * Данные из rgData: booking_dates[3], booking_slot_labels[10], booking_booked["1"|"2"|"3"] = [bool x10].
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

    const dateSelect = container.querySelector(".select-booking-date.custom-select");
    const slotSelect = container.querySelector(".select-booking-slot.custom-select");
    const slotList = container.querySelector(".select-booking-slot [data-booking-slot-list]");
    if (!dateSelect || !slotList || !slotSelect) return;

    const slotTop = slotSelect.querySelector(".custom-select_top");
    const slotTitle = slotSelect.querySelector(".custom-select_title");

    function getSelectedDate() {
        const cb = dateSelect.querySelector('input[name="booking_date[]"]:checked');
        return cb ? cb.value : null;
    }

    function renderSlotList(dateStr) {
        const booked = getBookedStateForDate(dateStr);
        const labels = getSlotLabels();
        const free = [];
        if (booked && booked.length >= 10) {
            for (let i = 0; i < 10; i++) {
                if (!booked[i]) free.push({ label: labels[i], index: i });
            }
        } else {
            labels.forEach((label, i) => free.push({ label: label, index: i }));
        }

        slotList.innerHTML = "";
        if (free.length === 0) {
            slotList.innerHTML = `
                <div class="custom-select_item">
                    <input type="checkbox" class="onlyOne" name="booking_slot[]" value="" id="booking_slot_none" disabled>
                    <label for="booking_slot_none"><span></span>No free slots</label>
                </div>`;
            if (slotTitle) slotTitle.textContent = "Time slot";
            return;
        }

        free.forEach((item, i) => {
            const id = "booking_slot_popup_" + i;
            const el = document.createElement("div");
            el.className = "custom-select_item";
            el.innerHTML = `
                <input type="checkbox" class="onlyOne" name="booking_slot[]" value="${item.label}" data-slot-index="${item.index}" id="${id}">
                <label for="${id}"><span></span>${item.label}</label>`;
            slotList.appendChild(el);
        });

        slotTop.classList.remove("active");
        slotList.classList.remove("active");
        slotSelect.querySelectorAll('input[name="booking_slot[]"]').forEach(el => {
            el.checked = false;
        });
        if (slotTitle) slotTitle.textContent = "Time slot";

        const checkboxes = slotList.querySelectorAll('input[name="booking_slot[]"]');
        checkboxes.forEach(cb => {
            cb.addEventListener("change", function () {
                if (this.checked) {
                    checkboxes.forEach(other => {
                        if (other !== this) other.checked = false;
                    });
                }
                slotTop.classList.toggle(
                    "valide",
                    slotList.querySelector('input[name="booking_slot[]"]:checked') &&
                        !slotTop.classList.contains("active"),
                );
            });
        });
    }

    function updateSlotSelect() {
        const dateStr = getSelectedDate();
        if (!dateStr) {
            slotList.innerHTML = `
                <div class="custom-select_item">
                    <input type="checkbox" class="onlyOne" name="booking_slot[]" value="" id="booking_slot_placeholder" disabled>
                    <label for="booking_slot_placeholder"><span></span>Choose date first</label>
                </div>`;
            if (slotTitle) slotTitle.textContent = "Time slot";
            return;
        }
        renderSlotList(dateStr);
    }

    dateSelect.querySelectorAll('input[name="booking_date[]"]').forEach(cb => {
        cb.addEventListener("change", () => updateSlotSelect());
    });

    updateSlotSelect();
}
