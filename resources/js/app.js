import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';
import BookingForm from './components/BookingForm';

// Helper to mount React components
if (document.getElementById('booking-root')) {
    const root = createRoot(document.getElementById('booking-root'));
    root.render(<BookingForm />);
}
