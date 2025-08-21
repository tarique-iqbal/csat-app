import React from 'react';
import { render, screen } from '@testing-library/react';
import Nav from '@/components/Nav';
import { vi } from 'vitest';

const mockGetCurrentWeek = vi.fn();

vi.mock('@/utils/dateUtils', () => ({
  getCurrentWeek: () => mockGetCurrentWeek(),
}));

describe('Nav component', () => {
  beforeEach(() => {
    vi.clearAllMocks();
  });

  it('renders navigation links with correct URLs (week 42)', () => {
    mockGetCurrentWeek.mockReturnValue(42);
    render(<Nav />);

    expect(screen.getByRole('link', { name: /home/i })).toHaveAttribute('href', '/');
    expect(screen.getByRole('link', { name: /about/i })).toHaveAttribute('href', '/about');
    expect(screen.getByRole('link', { name: /contact us/i })).toHaveAttribute('href', '/contact-us');
    expect(screen.getByRole('link', { name: /this week/i })).toHaveAttribute('href', '/csat/42');
  });

  it('updates the week link when getCurrentWeek changes', () => {
    mockGetCurrentWeek.mockReturnValue(15);
    render(<Nav />);

    expect(screen.getByRole('link', { name: /this week/i })).toHaveAttribute('href', '/csat/15');
  });
});
