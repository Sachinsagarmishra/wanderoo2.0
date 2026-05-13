# North AI: The Wanderoo Advisor Plan

This document serves as the master blueprint for building **North AI**, the premium corporate travel assistant for Wanderoo.

## 1. Design Aesthetic (The "Sage" Inspiration)
*   **Floating Widget**: Positioned at the bottom right with a pulsing animation.
*   **Greeting Bubble**: A temporary message bubble that appears 5 seconds after page load.
*   **Glassmorphism Chatbox**: Using `backdrop-filter: blur(10px)` and semi-transparent white backgrounds.
*   **Quick-Start Grid**: 6 primary categories (Goa, Bali, Team Building, etc.) displayed as cards when the chat is first opened.

## 2. Technical Architecture
### Frontend (The Shell)
*   **HTML**: Floating button + Chat container + Input area.
*   **CSS**: Responsive design, dedicated `ai-chatbot.css` for isolation.
*   **JS**: Handle opening/closing, state management, and API calls.

### The Brain (The Intelligence)
*   **LLM Provider**: Gemini 1.5 Pro (recommended for speed and context window).
*   **RAG System**:
    *   **Context Source**: `about.php`, `destinations.php`, `index.php`.
    *   **Retrieval Logic**: AI must cross-reference the user query against the "Destinations" database before answering.
*   **Persona Prompt**:
    > "You are North AI, the lead travel advisor at Wanderoo. You are professional, knowledgeable about corporate logistics, and enthusiastic about travel. You provide indicative pricing and travel ideas based ONLY on Wanderoo's official offerings. Never mention being an AI; act as a human team member."

## 3. Features & Logic
*   **Indicative Pricing**: Perform real-time math: `(Base Rate) * (No. of Pax) * (No. of Nights)`.
*   **Lead Capture**: When a user asks for a "real proposal," the AI should trigger a contact form or ask for an email.
*   **Session Memory**: Keep track of the current conversation to allow follow-up questions.

## 4. Implementation Checklist
- [ ] Create `assets/css/ai-chatbot.css`
- [ ] Build floating button HTML in `includes/footer.php`
- [ ] Develop JS handler for UI interactions
- [ ] Integrate with Backend API (North AI Engine)
- [ ] Test with specific Wanderoo data (Bali, Goa, Swiss Alps)
