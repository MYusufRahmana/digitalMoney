// app.js

// Fungsi untuk modal transaksi
function showTransactionModal(type = "income") {
    console.log("Show modal called");

    // Reset form
    document.getElementById("transactionForm").reset();

    // Set modal title dan radio button
    if (type === "income") {
        document.getElementById("modalTitle").textContent = "Tambah Pemasukan";
        document.getElementById("typeIncome").checked = true;
    } else {
        document.getElementById("modalTitle").textContent =
            "Tambah Pengeluaran";
        document.getElementById("typeExpense").checked = true;
    }

    // Set default date
    const today = new Date().toISOString().split("T")[0];
    document.getElementById("transaction_date").value = today;

    // Show modal
    const modal = document.getElementById("transactionModal");
    modal.classList.add("active");
    document.body.style.overflow = "hidden"; // Prevent scrolling

    console.log("Modal should be visible");
}

// Close Transaction Modal
function closeTransactionModal() {
    const modal = document.getElementById("transactionModal");
    modal.classList.remove("active");
    document.body.style.overflow = "auto"; // Restore scrolling
}

// Set quick amount
function setAmount(amount) {
    console.log("Set amount:", amount);
    const amountInput = document.getElementById("amount");
    if (amountInput) {
        amountInput.value = amount;
        amountInput.focus();
    }
}

// Initialize when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM loaded");

    // Close modal on ESC key
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            closeTransactionModal();
        }
    });

    // Close modal when clicking on overlay
    const modalOverlay = document.getElementById("transactionModal");
    if (modalOverlay) {
        modalOverlay.addEventListener("click", function (e) {
            if (e.target === this) {
                closeTransactionModal();
            }
        });
    }

    // Set default date
    const dateInput = document.getElementById("transaction_date");
    if (dateInput) {
        const today = new Date().toISOString().split("T")[0];
        dateInput.value = today;
        dateInput.max = today;
    }
});
