<?php

declare(strict_types=1);
require_once '../db.inc.php'; // Database connection
require_once 'sendMoney_model.inc.php'; // Contains search_users function

function display_money_transfer_form(): void
{
    ?>
    <form method="POST" action="sendMoney_contr.inc.php">
        
        <label for="username">Recipient Username:</label>
        <input type="text" name="username" id="username" autocomplete="off" required>
        <div id="suggestions" class="suggestions-box"></div>

        <label for="amount">Amount:</label>
        <input type="number" step="0.01" name="amount" id="amount" required>
        
        <label for="comment">Comment (Optional):</label>
        <textarea name="comment" id="comment"></textarea>
        
        <button type="submit" name="transfer">Send Money</button>
        
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const usernameInput = document.getElementById("username");
            const suggestionsBox = document.getElementById("suggestions");

            function fetchUsers(query) {
                if (query.length < 2) {
                    suggestionsBox.innerHTML = ""; // Clear suggestions if input < 2 characters
                    return;
                }

                fetch("searchUsers.php?query=" + encodeURIComponent(query))
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) {
                            suggestionsBox.innerHTML = ""; // No results, clear suggestions
                            return;
                        }

                        let suggestions = data.map(user => `<div class="suggestion-item">${user}</div>`).join("");
                        suggestionsBox.innerHTML = suggestions;
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
                    suggestionsBox.innerHTML = ""; // Clear suggestions after selection
                }
            });

            // Hide suggestions when clicking outside
            document.addEventListener("click", function (event) {
                if (!suggestionsBox.contains(event.target) && event.target !== usernameInput) {
                    suggestionsBox.innerHTML = "";
                }
            });
        });
    </script>

    <!-- <style>
        .suggestions-box {
            position: absolute;
            background: white;
            border: 1px solid #ccc;
            max-height: 150px;
            overflow-y: auto;
            width: 200px;
        }

        .suggestion-item {
            padding: 8px;
            cursor: pointer;
        }

        .suggestion-item:hover {
            background: #f0f0f0;
        }
    </style> -->

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
