import http from '@/api/http';

export interface ContactFormValues {
  name: string;
  email: string;
  message: string;
}

export const sendContactMessage = async (
  data: ContactFormValues,
  signal?: AbortSignal
): Promise<{ success: boolean; message: string }> => {
  try {
    const response = await http.post('/api/contact', data, { signal });
    return response.data;
  } catch (error: any) {
    if (error.name === 'CanceledError' || error.code === 'ERR_CANCELED') {
      throw new DOMException('Request aborted', 'AbortError');
    }
    throw new Error(
      error.response?.data?.message || `Failed to send message: ${error.message}`
    );
  }
};
