import { describe, it, expect, vi, beforeEach } from 'vitest';
import { getCsatByWeek } from '@/api/csatService';

vi.mock('@/api/http', () => ({
  default: {
    get: vi.fn(),
  },
}));

import http from '@/api/http';

describe('getCsatByWeek', () => {
  const mockWeek = '11';
  const mockData = { week: 11, score: 85 };

  beforeEach(() => {
    vi.clearAllMocks();
  });

  it('should return CSAT data when request succeeds', async () => {
    (http.get as vi.Mock).mockResolvedValueOnce({ data: mockData });

    const result = await getCsatByWeek(mockWeek);

    expect(http.get).toHaveBeenCalledWith('/api/csat/11', { signal: undefined });
    expect(result).toEqual(mockData);
  });

  it('should throw formatted error when request fails', async () => {
    const error = new Error('Server Error');
    (http.get as vi.Mock).mockRejectedValueOnce(error);

    await expect(getCsatByWeek(mockWeek)).rejects.toThrow('Failed to fetch CSAT: Server Error');
  });

  it('should throw AbortError when request is canceled', async () => {
    const controller = new AbortController();

    const abortError = {
      name: 'CanceledError',
      code: 'ERR_CANCELED',
      message: 'Request canceled',
      isAxiosError: true,
      config: {}
    };

    (http.get as vi.Mock).mockRejectedValueOnce(abortError);

    await expect(getCsatByWeek(mockWeek, controller.signal))
      .rejects.toThrow(DOMException);
  });
});
