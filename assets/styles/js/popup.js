document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".open-popup").forEach(function(link) {
        link.addEventListener("click", function(event) {
            event.preventDefault(); 
            event.stopPropagation();     
            let popupId = this.getAttribute("href").substring(1);
            let popup = document.getElementById(popupId);
            if (popup) {
            popup.style.display = "flex";
            document.body.style.overflow = 'hidden';
            }
        });
    });

    function closePopup(popup) {
        popup.style.display = "none"; 
        document.body.style.overflow = 'auto'; 
    }

    document.querySelectorAll(".popup .close").forEach(function(closeBtn) {
        closeBtn.addEventListener("click", function(event) {
            event.stopPropagation();
            let popup = this.closest(".popup");
            closePopup(popup);
        });
    });

    window.addEventListener("click", function(event) {
        document.querySelectorAll(".popup").forEach(function(popup) {
            if (event.target === popup) {
                closePopup(popup);
            }
        });
    });
});
