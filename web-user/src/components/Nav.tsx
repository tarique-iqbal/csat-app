import React from 'react';
import { getCurrentWeek } from '@/utils/dateUtils';

const Nav: React.FC = () => {
  const week = getCurrentWeek();

  return (
    <nav>
      <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/about">About</a></li>
        <li><a href={`/csat/${week}`}>This Week</a></li>
      </ul>
    </nav>
  );
};

export default Nav;
