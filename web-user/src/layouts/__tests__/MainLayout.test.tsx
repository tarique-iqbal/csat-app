import React from 'react';
import { render, screen } from '@testing-library/react';
import MainLayout from '@/layouts/MainLayout';
import { describe, it, expect } from 'vitest';

describe('MainLayout', () => {
  it('renders children inside the main area', () => {
    render(
      <MainLayout>
        <p>Test Content</p>
      </MainLayout>
    );

    expect(screen.getByText('Test Content')).toBeInTheDocument();
  });

  it('renders left sidebar content when provided', () => {
    render(
      <MainLayout left={<p>Sidebar</p>}>
        <p>Main Area</p>
      </MainLayout>
    );

    expect(screen.getByText('Sidebar')).toBeInTheDocument();
    expect(screen.getByText('Main Area')).toBeInTheDocument();
  });

  it('renders header, body, aside, and main structure', () => {
    const { container } = render(
      <MainLayout left={<p>Left</p>}>
        <p>Child</p>
      </MainLayout>
    );

    expect(container.querySelector('.layout-container')).toBeTruthy();
    expect(container.querySelector('.layout-header')).toBeTruthy();
    expect(container.querySelector('.layout-body')).toBeTruthy();
    expect(container.querySelector('.layout-left')).toBeTruthy();
    expect(container.querySelector('.layout-main')).toBeTruthy();
  });
});
