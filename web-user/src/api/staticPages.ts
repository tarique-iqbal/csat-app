import http from '@/api/http';

export interface StaticPage {
  id: number;
  title: string;
  slug: string;
  url: string;
}

export const getStaticPages = async (): Promise<StaticPage[]> => {
  const res = await http.get('/api/static-pages');
  return res.data;
};
