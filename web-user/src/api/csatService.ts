import http from '@/api/http';

export interface CsatEntry {
  week: number;
  score: number;
}

export const getCsatByWeek = (
  week: string,
  signal?: AbortSignal
): Promise<CsatEntry> =>
  http
    .get(`/api/csat/${Number(week)}`, { signal })
    .then((res) => res.data)
    .catch((error) => {
      if (error.name === 'CanceledError' || error.code === 'ERR_CANCELED') {
        throw new DOMException('Request aborted', 'AbortError');
      }
      throw new Error(`Failed to fetch CSAT: ${error.message}`);
    });
