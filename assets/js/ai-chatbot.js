/**
 * North AI Chat Agent JavaScript Controller
 * Handles visual toggling, suggestion cards, RAG chat stream, and inline lead captures.
 */
document.addEventListener("DOMContentLoaded", () => {
    // Select elements
    const floatBtn = document.getElementById("northaiFloatBtn");
    const greetBubble = document.getElementById("northaiGreetBubble");
    const closeBubble = document.getElementById("northaiCloseBubble");
    const chatPanel = document.getElementById("northaiChatPanel");
    const closeChat = document.getElementById("northaiCloseChat");
    const overlayBlur = document.getElementById("northaiOverlayBlur");
    const messageInput = document.getElementById("northaiMessageInput");
    const sendBtn = document.getElementById("northaiSendBtn");
    const messagesBox = document.getElementById("northaiMessagesBox");
    const welcomeBox = document.getElementById("northaiWelcomeBox");

    // Dynamic configuration variables
    const newChatBtn = document.getElementById("northaiNewChatBtn");

    // Dynamic configuration variables
    let isChatInitialized = false;
    let chatHistory = [];
    const sitePath = window.location.pathname.includes('/admin/') ? '../' : '';

    // 1. Show Greeting Bubble after 5 seconds delay
    setTimeout(() => {
        if (!chatPanel.classList.contains("active") && localStorage.getItem("northai_greet_dismissed") !== "true") {
            greetBubble.classList.add("active");
        }
    }, 5000);

    // 2. Dismiss Greeting Bubble
    closeBubble.addEventListener("click", (e) => {
        e.stopPropagation();
        greetBubble.classList.remove("active");
        localStorage.setItem("northai_greet_dismissed", "true");
    });

    // 3. Panel Toggle Actions
    const openAgentPanel = () => {
        greetBubble.classList.remove("active");
        chatPanel.classList.add("active");
        overlayBlur.classList.add("active");
        messageInput.focus();
        
        if (!isChatInitialized) {
            isChatInitialized = true;
            // Additional setup if needed
        }
    };

    const closeAgentPanel = () => {
        chatPanel.classList.remove("active");
        overlayBlur.classList.remove("active");
    };

    floatBtn.addEventListener("click", openAgentPanel);
    closeChat.addEventListener("click", closeAgentPanel);
    overlayBlur.addEventListener("click", closeAgentPanel);

    // Toggle Send Button active state color on input change
    messageInput.addEventListener("input", () => {
        if (messageInput.value.trim().length > 0) {
            sendBtn.classList.add("active");
        } else {
            sendBtn.classList.remove("active");
        }
    });

    // 4. Suggestion Quick-Start Card Actions
    function bindSuggestionCards() {
        document.querySelectorAll(".northai-quick-card").forEach(card => {
            card.addEventListener("click", () => {
                const topic = card.getAttribute("data-topic");
                let predefinedPrompt = "";

                switch (topic) {
                    case 'goa':
                        predefinedPrompt = "Plan an offsite in Goa for 50 people, 3 nights Standard pricing";
                        break;
                    case 'coorg':
                        predefinedPrompt = "Plan a Coorg retreat for 30 pax leadership team";
                        break;
                    case 'phuket':
                        predefinedPrompt = "Plan an international offsite in Phuket for 60 people, 4 nights Premium package";
                        break;
                    case 'bali':
                        predefinedPrompt = "Plan an international offsite in Bali for 40 people, 5 nights";
                        break;
                    case 'munnar':
                        predefinedPrompt = "We want a Munnar wellness retreat for 25 pax, 3 nights";
                        break;
                    case 'teambuilding':
                        predefinedPrompt = "What team building formats do you offer at Wanderoo?";
                        break;
                }

                if (predefinedPrompt !== "") {
                    // Clear welcome layout and submit
                    const currentWelcomeBox = document.getElementById("northaiWelcomeBox");
                    if (currentWelcomeBox) {
                        currentWelcomeBox.style.display = "none";
                    }
                    submitUserMessage(predefinedPrompt);
                }
            });
        });
    }

    bindSuggestionCards();

    // New Chat button click handler to reset history and display welcome grid
    if (newChatBtn) {
        newChatBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            chatHistory = [];
            
            // Re-render only the welcome box
            messagesBox.innerHTML = `
                <div class="northai-welcome-box" id="northaiWelcomeBox" style="display: block;">
                    <div class="northai-welcome-avatar">
                        <img src="${sitePath}assets/img/nothai.png" alt="North AI Avatar">
                    </div>
                    <h2>Hey, I'm North AI</h2>
                    <p>Your personal event planning advisor. How can I help?</p>
                    
                    <div class="northai-quick-grid">
                        <div class="northai-quick-card" data-topic="goa">
                            <h4>🌴 Goa offsite</h4>
                            <p>50 pax · 3 nights · Premium</p>
                        </div>
                        <div class="northai-quick-card" data-topic="coorg">
                            <h4>🏔️ Coorg retreat</h4>
                            <p>30 pax leadership</p>
                        </div>
                        <div class="northai-quick-card" data-topic="phuket">
                            <h4>✈️ Phuket international</h4>
                            <p>60 pax · 4 nights</p>
                        </div>
                        <div class="northai-quick-card" data-topic="bali">
                            <h4>🌴 Bali offsite</h4>
                            <p>40 pax · Premium</p>
                        </div>
                        <div class="northai-quick-card" data-topic="munnar">
                            <h4>🏔️ Munnar wellness</h4>
                            <p>25 pax · 3 nights</p>
                        </div>
                        <div class="northai-quick-card" data-topic="teambuilding">
                            <h4>🎯 Team building</h4>
                            <p>Activities & formats</p>
                        </div>
                    </div>
                </div>
            `;
            
            messagesBox.scrollTop = 0;
            messageInput.value = "";
            sendBtn.classList.remove("active");
            bindSuggestionCards();
        });
    }

    // Keypress submission
    messageInput.addEventListener("keydown", (e) => {
        if (e.key === "Enter" && !e.shiftKey) {
            e.preventDefault();
            triggerManualSubmit();
        }
    });

    sendBtn.addEventListener("click", triggerManualSubmit);

    function triggerManualSubmit() {
        const text = messageInput.value.trim();
        if (text === "") return;
        
        const currentWelcomeBox = document.getElementById("northaiWelcomeBox");
        if (currentWelcomeBox) {
            currentWelcomeBox.style.display = "none";
        }
        messageInput.value = "";
        sendBtn.classList.remove("active");
        submitUserMessage(text);
    }

    // 5. Submit Message to PHP Brain Endpoint
    function submitUserMessage(message) {
        // Render User Bubble
        appendMessageBubble(message, "user");
        
        // Render typing indicator
        const typingId = appendTypingIndicator();
        scrollToBottom();

        // Prepare cURL Payload
        const payload = {
            message: message,
            history: chatHistory
        };

        fetch(sitePath + 'api/northai-chat.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            // Remove typing bubble
            removeTypingIndicator(typingId);

            if (data.reply) {
                appendMessageBubble(data.reply, "agent");
                
                // Append text history
                chatHistory.push({ role: 'user', text: message });
                chatHistory.push({ role: 'model', text: data.reply });
                
                // Check if reply requests a real proposal or details (Lead Capture trigger)
                if (data.reply.toLowerCase().includes("proposal") || 
                    data.reply.toLowerCase().includes("name, work email")) {
                    appendLeadCaptureForm(message);
                }
            } else {
                appendMessageBubble("⚠️ Sorry, I encountered an issue processing your request. Please try again.", "agent");
            }
            scrollToBottom();
        })
        .catch(err => {
            removeTypingIndicator(typingId);
            appendMessageBubble("⚠️ Connection timeout. Please verify your network and Gemini API key config.", "agent");
            scrollToBottom();
        });
    }

    // Render bubble bubbles
    function appendMessageBubble(text, sender) {
        const messageDiv = document.createElement("div");
        messageDiv.classList.add("northai-message", sender);
        
        const avatarDiv = document.createElement("div");
        avatarDiv.classList.add("northai-msg-avatar");
        const logoImg = sitePath + 'assets/img/nothai.png';
        if (sender === 'agent') {
            avatarDiv.innerHTML = `<img src="${logoImg}" alt="North AI">`;
        } else {
            avatarDiv.style.background = "transparent";
            avatarDiv.innerHTML = `<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #F1F5F9; border-radius: 50%; border: 1px solid #E2E8F0;"><i class="fa-solid fa-user" style="color: #64748B; font-size: 14px;"></i></div>`;
        }
        
        const bubbleDiv = document.createElement("div");
        bubbleDiv.classList.add("northai-msg-bubble");
        bubbleDiv.innerHTML = formatMarkdownText(text);

        messageDiv.appendChild(avatarDiv);
        messageDiv.appendChild(bubbleDiv);
        messagesBox.appendChild(messageDiv);
    }

    // Format bold text and lists for beautiful display
    function formatMarkdownText(text) {
        let html = text;
        // Escape HTML entities to prevent scripts injection
        html = html.replace(/</g, "&lt;").replace(/>/g, "&gt;");
        
        // Bold tags **text** -> <strong>text</strong>
        html = html.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        
        // Bullet point lists
        if (html.includes("- ")) {
            const lines = html.split("\n");
            let inList = false;
            for (let i = 0; i < lines.length; i++) {
                if (lines[i].trim().startsWith("- ")) {
                    let content = lines[i].trim().substring(2);
                    if (!inList) {
                        lines[i] = "<ul><li>" + content + "</li>";
                        inList = true;
                    } else {
                        lines[i] = "<li>" + content + "</li>";
                    }
                } else {
                    if (inList) {
                        lines[i] = "</ul>" + lines[i];
                        inList = false;
                    }
                }
            }
            if (inList) {
                lines[lines.length - 1] += "</ul>";
            }
            html = lines.join("\n");
        }

        // Newlines to breaks
        html = html.replace(/\n/g, "<br>");
        return html;
    }

    // Append Typing status
    function appendTypingIndicator() {
        const uniqueId = "typing-" + Date.now();
        const typingDiv = document.createElement("div");
        typingDiv.classList.add("northai-message", "agent");
        typingDiv.id = uniqueId;

        const avatarDiv = document.createElement("div");
        avatarDiv.classList.add("northai-msg-avatar");
        avatarDiv.innerHTML = `<img src="${sitePath + 'assets/img/nothai.png'}" alt="North AI">`;

        const bubbleDiv = document.createElement("div");
        bubbleDiv.classList.add("northai-msg-bubble");
        bubbleDiv.innerHTML = `
            <div class="northai-typing-dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        `;

        typingDiv.appendChild(avatarDiv);
        typingDiv.appendChild(bubbleDiv);
        messagesBox.appendChild(typingDiv);
        return uniqueId;
    }

    function removeTypingIndicator(id) {
        const el = document.getElementById(id);
        if (el) el.remove();
    }

    // 6. Dynamic Inline Lead Capture
    function appendLeadCaptureForm(queryContext) {
        const messageDiv = document.createElement("div");
        messageDiv.classList.add("northai-message", "agent");

        const avatarDiv = document.createElement("div");
        avatarDiv.classList.add("northai-msg-avatar");
        avatarDiv.innerHTML = `<img src="${sitePath + 'assets/img/nothai.png'}" alt="North AI">`;

        const bubbleDiv = document.createElement("div");
        bubbleDiv.classList.add("northai-msg-bubble");
        bubbleDiv.style.width = "100%";

        const formId = "lead-form-" + Date.now();
        bubbleDiv.innerHTML = `
            <div class="northai-lead-form" id="${formId}">
                <h4>📋 Request Corporate Proposal</h4>
                <input type="text" placeholder="Enter Full Name" class="lead-name" required>
                <input type="email" placeholder="Work Email Address" class="lead-email" required>
                <input type="tel" placeholder="WhatsApp / Phone Number" class="lead-phone" required>
                <button type="button" class="submit-lead-btn">Submit Request</button>
            </div>
        `;

        messageDiv.appendChild(avatarDiv);
        messageDiv.appendChild(bubbleDiv);
        messagesBox.appendChild(messageDiv);
        scrollToBottom();

        // Attach Submit Event
        const formEl = document.getElementById(formId);
        const submitBtn = formEl.querySelector(".submit-lead-btn");
        
        submitBtn.addEventListener("click", () => {
            const name = formEl.querySelector(".lead-name").value.trim();
            const email = formEl.querySelector(".lead-email").value.trim();
            const phone = formEl.querySelector(".lead-phone").value.trim();

            if (name === "" || email === "" || phone === "") {
                alert("Please fill in all lead details to generate your curated corporate proposal.");
                return;
            }

            submitBtn.textContent = "Submitting...";
            submitBtn.disabled = true;

            const leadPayload = {
                lead_submission: true,
                name: name,
                email: email,
                phone: phone,
                context: "Query details: " + queryContext
            };

            fetch(sitePath + 'api/northai-chat.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(leadPayload)
            })
            .then(res => res.json())
            .then(resData => {
                if (resData.success) {
                    formEl.innerHTML = `
                        <div style="text-align: center; color: #059669; font-weight: 700; padding: 10px 0;">
                            <i class="fa-solid fa-circle-check" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
                            Proposal Request Registered!
                            <p style="font-size: 11px; font-weight: 500; color: #64748B; margin-top: 6px; line-height: 1.4;">
                                Thank you, ${name}. Our lead MICE coordinator will ping you on WhatsApp at ${phone} within 30 minutes!
                            </p>
                        </div>
                    `;
                } else {
                    submitBtn.textContent = "Submit Request";
                    submitBtn.disabled = false;
                    alert("Submission failed. Please check parameters.");
                }
            })
            .catch(err => {
                submitBtn.textContent = "Submit Request";
                submitBtn.disabled = false;
                alert("Lead capture connection timeout. Please try again.");
            });
        });
    }

    function scrollToBottom() {
        messagesBox.scrollTop = messagesBox.scrollHeight;
    }
});
