import React from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import ContactUs from '@/pages/ContactUs';
import { vi } from 'vitest';

vi.mock('@/api/contactUs', () => ({
  sendContactMessage: vi.fn(),
}));

import { sendContactMessage } from '@/api/contactUs';

describe('ContactUs Page', () => {
  beforeEach(() => {
    vi.clearAllMocks();
  });

  it('renders form fields correctly', () => {
    render(<ContactUs />);

    expect(screen.getByLabelText(/name/i)).toBeInTheDocument();
    expect(screen.getByLabelText(/email/i)).toBeInTheDocument();
    expect(screen.getByLabelText(/message/i)).toBeInTheDocument();
    expect(screen.getByRole('button', { name: /send/i })).toBeInTheDocument();
  });

  it('shows validation errors when submitting empty form', async () => {
    render(<ContactUs />);

    fireEvent.click(screen.getByRole('button', { name: /send/i }));

    expect(await screen.findByText(/name is required/i)).toBeInTheDocument();
    expect(await screen.findByText(/invalid email format/i)).toBeInTheDocument();
    expect(await screen.findByText(/message is required/i)).toBeInTheDocument();
  });

  it('submits successfully and shows thank-you message', async () => {
    (sendContactMessage as jest.Mock).mockResolvedValueOnce({ success: true });

    render(<ContactUs />);

    fireEvent.change(screen.getByLabelText(/name/i), {
      target: { value: 'John Doe' },
    });
    fireEvent.change(screen.getByLabelText(/email/i), {
      target: { value: 'john@example.com' },
    });
    fireEvent.change(screen.getByLabelText(/message/i), {
      target: { value: 'Hello!' },
    });

    fireEvent.click(screen.getByRole('button', { name: /send/i }));

    await waitFor(() => {
      expect(
        screen.getByText(/your message has been sent successfully/i)
      ).toBeInTheDocument();
    });

    expect(screen.queryByRole('form')).not.toBeInTheDocument();
  });

  it('shows server error when API fails', async () => {
    (sendContactMessage as jest.Mock).mockRejectedValueOnce(
      new Error('Server error')
    );

    render(<ContactUs />);

    fireEvent.change(screen.getByLabelText(/name/i), {
      target: { value: 'Jane Doe' },
    });
    fireEvent.change(screen.getByLabelText(/email/i), {
      target: { value: 'jane@example.com' },
    });
    fireEvent.change(screen.getByLabelText(/message/i), {
      target: { value: 'Help me!' },
    });

    fireEvent.click(screen.getByRole('button', { name: /send/i }));

    expect(await screen.findByText(/server error/i)).toBeInTheDocument();
  });
});
