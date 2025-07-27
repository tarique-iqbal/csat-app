import React from 'react';
import MainLayout from '../layouts/MainLayout';
import Nav from '../components/Nav';

const Home: React.FC = () => {
  return (
    <MainLayout left={<Nav />}>
      <h1>Welcome to the Home Page</h1>
      <p>This is your main content.</p>
    </MainLayout>
  );
};

export default Home;
