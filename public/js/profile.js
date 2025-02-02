function toggleEdit(field) {
    const valueSpan = document.getElementById(`user-${field}`);
    const inputField = document.getElementById(`${field}-input`);

    if (valueSpan.style.display === "none") {
        valueSpan.style.display = "inline";
        inputField.style.display = "none";
    } else {
        valueSpan.style.display = "none";
        inputField.style.display = "inline";
        inputField.focus();
    }
}