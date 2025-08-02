import { getCurrentWeek } from '../dateUtils';

describe('getCurrentWeek', () => {
  it('should return a number between 1 and 53', () => {
    const week = getCurrentWeek();
    expect(typeof week).toBe('number');
    expect(week).toBeGreaterThanOrEqual(1);
    expect(week).toBeLessThanOrEqual(53);
  });

  it('should return correct ISO week number for a mocked date', () => {
    const RealDate = Date;

    global.Date = class extends RealDate {
      constructor() {
        super();
        return new RealDate('2025-01-04T00:00:00.000Z');
      }
    } as unknown as DateConstructor;

    const week = getCurrentWeek();
    expect(week).toBe(1);

    global.Date = RealDate;
  });
});
