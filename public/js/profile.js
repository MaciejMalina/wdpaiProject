document.addEventListener("DOMContentLoaded", function () {
    const fields = ["name", "email", "phone", "address", "password", "position", "department", "role"];

    fields.forEach(field => {
        const valueSpan = document.getElementById(`user-${field}`);
        const editButton = document.createElement("button");
        editButton.textContent = "Edit";
        editButton.classList.add("edit-button");
        editButton.style.display = "none";
        editButton.onclick = function () {
            toggleEdit(field);
        };

        valueSpan.insertAdjacentElement("afterend", editButton);

        valueSpan.addEventListener("click", function () {
            editButton.style.display = "inline-block";
        });
    });
});

function toggleEdit(field) {
    const valueSpan = document.getElementById(`user-${field}`);
    const inputField = document.getElementById(`${field}-input`);
    
    valueSpan.style.display = "none";
    inputField.style.display = "inline";
    inputField.focus();
}
