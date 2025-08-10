import React from 'react';
import { render, screen } from '@testing-library/react';
import { MemoryRouter } from 'react-router-dom';
import AppRoutes from '../AppRoutes';
import { vi } from 'vitest';

vi.mock('@/pages/Home', () => ({
  default: () => <div>Home Page</div>,
}));

vi.mock('@/pages/About', () => ({
  default: () => <div>About Page</div>,
}));

vi.mock('@/pages/CsatDetails', () => ({
  default: () => <div>CSAT Details Page</div>,
}));

describe('AppRoutes', () => {
  it('renders Home page for root path', () => {
    render(
      <MemoryRouter initialEntries={['/']}>
        <AppRoutes />
      </MemoryRouter>
    );
    expect(screen.getByText('Home Page')).toBeInTheDocument();
  });

  it('renders About page for /about', () => {
    render(
      <MemoryRouter initialEntries={['/about']}>
        <AppRoutes />
      </MemoryRouter>
    );
    expect(screen.getByText('About Page')).toBeInTheDocument();
  });

  it('renders CSAT Details page for /csat/:week', () => {
    render(
      <MemoryRouter initialEntries={['/csat/11']}>
        <AppRoutes />
      </MemoryRouter>
    );
    expect(screen.getByText('CSAT Details Page')).toBeInTheDocument();
  });
});
