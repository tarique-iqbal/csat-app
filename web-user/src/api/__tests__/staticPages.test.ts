import { describe, it, expect, vi, beforeEach } from 'vitest';
import { getStaticPages } from '@/api/staticPages';

vi.mock('@/api/http', () => ({
  default: {
    get: vi.fn(),
  },
}));

import http from '@/api/http';

describe('getStaticPages API Service', () => {
  beforeEach(() => {
    vi.clearAllMocks();
  });

  it('should return static pages when request succeeds', async () => {
    const mockData = [
      { id: 1, title: 'About Us', slug: 'about', url: '/about-us' },
      { id: 2, title: 'FAQ', slug: 'faq', url: '/faq' },
    ];

    (http.get as any).mockResolvedValueOnce({ data: mockData });

    const result = await getStaticPages();

    expect(result).toEqual(mockData);
    expect(http.get).toHaveBeenCalledWith('/api/static-pages');
  });

  it('should throw an error when API call fails', async () => {
    const err = new Error('API failed');

    (http.get as any).mockRejectedValueOnce(err);

    await expect(getStaticPages()).rejects.toThrow('API failed');
    expect(http.get).toHaveBeenCalledWith('/api/static-pages');
  });
});
