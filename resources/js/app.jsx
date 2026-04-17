import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';
import ChatWidget from './components/Chat/ChatWidget';
import ChatAdmin from './components/Chat/ChatAdmin';
import IntentManager from './components/Chat/IntentManager';

const chatWidgetEl = document.getElementById('chat-widget');
if (chatWidgetEl) {
    createRoot(chatWidgetEl).render(<ChatWidget />);
}

const chatAdminEl = document.getElementById('chat-admin');
if (chatAdminEl) {
    createRoot(chatAdminEl).render(<ChatAdmin />);
}

const intentManagerEl = document.getElementById('intent-manager');
if (intentManagerEl) {
    createRoot(intentManagerEl).render(<IntentManager />);
}
