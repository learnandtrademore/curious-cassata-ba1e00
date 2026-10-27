window.onload = function() {
    var popup = document.createElement("div");
    popup.className = "popup";
    popup.innerHTML = `
        <div class="popup-content">
            <span class="close" onclick="closePopup()">&times;</span>
            <p>List of Students Pre Nursery Admission 2024</p>
            <button onclick="openLink()">OK</button>
        </div>
    `;
    document.body.appendChild(popup);
};

function closePopup() {
    var popup = document.querySelector(".popup");
    popup.style.display = "none";
}

function openLink() {
    window.location.href = "documents/pre_nursery_admission_2024.pdf";
}
