import { render, screen, waitFor } from '@testing-library/react';
import { MemoryRouter, Route, Routes } from 'react-router-dom';
import { describe, it, vi, beforeEach, expect } from 'vitest';
import CsatDetails from '@/pages/CsatDetails';
import { getCsatByWeek } from '@/api/csatService';

vi.mock('@/api/csatService', () => ({
  getCsatByWeek: vi.fn(),
}));

const mockedGetCsatByWeek = getCsatByWeek as vi.Mock;

const renderWithRoute = (path: string) =>
  render(
    <MemoryRouter initialEntries={[path]}>
      <Routes>
        <Route path="/csat/:week" element={<CsatDetails />} />
      </Routes>
    </MemoryRouter>
  );

describe('CsatDetails', () => {
  beforeEach(() => {
    vi.clearAllMocks();
  });

  it('shows loading and then data on success', async () => {
    mockedGetCsatByWeek.mockResolvedValueOnce({ week: 11, score: 85 });

    renderWithRoute('/csat/11');

    expect(screen.getByText('Loading CSAT entry...')).toBeInTheDocument();

    await waitFor(() => {
      expect(screen.getByText('CSAT week #11')).toBeInTheDocument();
      expect(screen.getByText(/85%/)).toBeInTheDocument();
    });
  });

  it('shows error on API failure', async () => {
    mockedGetCsatByWeek.mockRejectedValueOnce(new Error('API failed'));

    renderWithRoute('/csat/11');

    await waitFor(() => {
      expect(screen.getByText('API failed')).toBeInTheDocument();
    });
  });

  it('shows "Missing CSAT week" when no week param', () => {
    render(
      <MemoryRouter initialEntries={['/csat/']}>
        <Routes>
          <Route path="/csat/" element={<CsatDetails />} />
        </Routes>
      </MemoryRouter>
    );

    expect(screen.getByText('Missing CSAT week.')).toBeInTheDocument();
  });

  it('ignores AbortError without setting error state', async () => {
    const abortError = new DOMException('Request aborted', 'AbortError');
    mockedGetCsatByWeek.mockRejectedValueOnce(abortError);

    renderWithRoute('/csat/11');

    await waitFor(() => {
      expect(screen.queryByText('Request aborted')).not.toBeInTheDocument();
    });
  });
});
