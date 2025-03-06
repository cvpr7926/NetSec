<?php

declare(strict_types=1);
require_once '../db.inc.php'; // Database connection
require_once 'sendMoney_model.inc.php'; // Contains search_users function

function display_money_transfer_form(): void
{
    ?>

    <form method="POST" action="sendMoney_contr.inc.php">
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

            // Ensure suggestions box is hidden on page load
            suggestionsBox.style.display = "none";

            function fetchUsers(query) {
                if (query.length < 2) {
                    suggestionsBox.style.display = "none"; // Hide box if input is empty or too short
                    return;
                }

                fetch("searchUsers.php?query=" + encodeURIComponent(query))
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) {
                            suggestionsBox.style.display = "none"; // Hide if no results
                            return;
                        }

                        let suggestions = data.map(user => `<div class="suggestion-item">${user}</div>`).join("");
                        suggestionsBox.innerHTML = suggestions;
                        suggestionsBox.style.display = "block"; // Show only if results exist
                    });
            }

            // Fetch matching users when typing
            usernameInput.addEventListener("input", function () {
                fetchUsers(this.value);
            });

            // Handle click on a suggestion
            suggestionsBox.addEventListener("click", function (event) {
                if (event.target.classList.contains("suggestion-item")) {
                    usernameInput.value = event.target.textContent;
                    suggestionsBox.style.display = "none"; // Hide after selection
                }
            });

            // Hide suggestions when clicking outside
            document.addEventListener("click", function (event) {
                if (!suggestionsBox.contains(event.target) && event.target !== usernameInput) {
                    suggestionsBox.style.display = "none";
                }
            });
        });
    </script>

    <?php
    if (isset($_SESSION["errors_transfer"])) {
        echo '<p class="error-message">' . htmlspecialchars($_SESSION["errors_transfer"]) . '</p>';
        unset($_SESSION["errors_transfer"]);
    }
    if (isset($_SESSION["transfer_success"])) {
        echo '<p class="success-message">' . htmlspecialchars($_SESSION["transfer_success"]) . '</p>';
        unset($_SESSION["transfer_success"]);
    }
}
?>
