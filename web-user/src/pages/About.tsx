import React from 'react';
import MainLayout from '../layouts/MainLayout';
import Nav from '../components/Nav';

const About: React.FC = () => {
  return (
    <MainLayout left={<Nav />}>
      <h1>About Page</h1>
      <p>This is the about page content.</p>
    </MainLayout>
  );
};

export default About;
