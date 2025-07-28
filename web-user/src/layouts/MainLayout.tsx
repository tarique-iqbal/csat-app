import React from 'react';
import './MainLayout.css';

interface MainLayoutProps {
  left?: React.ReactNode;
  children: React.ReactNode;
}

const MainLayout: React.FC<MainLayoutProps> = ({ left, children }) => {
  return (
    <div className="layout-container">
      <header className="layout-header">My App Header</header>
      <div className="layout-body">
        <aside className="layout-left">{left}</aside>
        <main className="layout-main">{children}</main>
      </div>
    </div>
  );
};

export default MainLayout;
