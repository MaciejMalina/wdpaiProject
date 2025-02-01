document.addEventListener("DOMContentLoaded", function () {
    const checkboxes = document.querySelectorAll('.team-member input[type="checkbox"]');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", function () {
            const roleSelect = this.parentElement.querySelector(".role-select");
            roleSelect.disabled = !this.checked;
        });
    });
});
