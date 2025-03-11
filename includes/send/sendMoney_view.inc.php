<?php

declare(strict_types=1);
require_once '../config_session.inc.php' ; // Session configuration
require_once '../db.inc.php'; // Database connection
require_once 'sendMoney_model.inc.php'; // Contains search_users function

function display_money_transfer_form(): void
{
    ?>

    <form method="POST" action="sendMoney_contr.inc.php">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

        <div class="form-container">
            <div class="form-group">
                <label for="username">Recipient Username:</label>
                <div class="username-container">
                    <input type="text" name="username" id="username" autocomplete="off" required>
                    <div id="suggestions" class="suggestions-box"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" step="0.01" name="amount" id="amount" required>
            </div>

            <div class="form-group">
                <label for="comment">Comment (Optional):</label>
                <textarea name="comment" id="comment"></textarea>
            </div>
        </div>

        <button type="submit" name="transfer">Send Money</button>
    </form>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const usernameInput = document.getElementById("username");
        const suggestionsBox = document.getElementById("suggestions");

        suggestionsBox.style.display = "none";

        async function fetchUsers(query) {
            
            if (query.length < 2) {
                suggestionsBox.style.display = "none";
                return;
            }

            try {
                const response = await fetch("searchUsers.php?query=" + encodeURIComponent(query));

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const data = await response.json();

                if (!Array.isArray(data) || data.length === 0) {
                    suggestionsBox.style.display = "none";
                    return;
                }

                suggestionsBox.innerHTML = data.map(user => 
                    `<div class="suggestion-item" tabindex="0">${user}</div>`
                ).join("");
                suggestionsBox.style.display = "block";
            } catch (error) {
                console.error("Error fetching users:", error);
                suggestionsBox.style.display = "none"; // Hide suggestions on error
            }
        }


        usernameInput.addEventListener("input", () => fetchUsers(usernameInput.value));

        suggestionsBox.addEventListener("click", event => {
            if (event.target.classList.contains("suggestion-item")) {
                usernameInput.value = event.target.textContent;
                suggestionsBox.style.display = "none";
            }
        });

        document.addEventListener("click", event => {
            if (!suggestionsBox.contains(event.target) && event.target !== usernameInput) {
                suggestionsBox.style.display = "none";
            }
        });

        // Allow keyboard navigation for better UX
        suggestionsBox.addEventListener("keydown", event => {
            if (event.key === "Enter") {
                usernameInput.value = event.target.textContent;
                suggestionsBox.style.display = "none";
                usernameInput.focus();
            }
        });
    });
    </script>

    <?php
    if (!empty($_SESSION["errors_transfer"])) {
        echo '<p class="error-message">' . nl2br(htmlspecialchars($_SESSION["errors_transfer"], ENT_QUOTES, 'UTF-8')) . '</p>';
        unset($_SESSION["errors_transfer"]); // Clear the error after displaying
    }

    if (!empty($_SESSION["transfer_success"])) {
        echo '<p class="success-message">' . nl2br(htmlspecialchars($_SESSION["transfer_success"], ENT_QUOTES, 'UTF-8')) . '</p>';
        unset($_SESSION["transfer_success"]); // Clear success message after displaying
    }

}

?>


