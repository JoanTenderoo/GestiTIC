import React from 'react';
import Header from './Header';
import IncidenciasTable from './IncidenciasTable';
import '../styles/Dashboard.css';

const Dashboard = () => {
    return (
        <div className="dashboard">
            <Header />
            <main className="dashboard-main">
                <div className="dashboard-content">
                    <div className="left-panel">
                        <IncidenciasTable />
                    </div>
                    <div className="right-panel">
                        <div className="placeholder-box small" />
                        <div className="placeholder-box medium" />
                        <div className="placeholder-box large" />
                        <div className="placeholder-box small" />
                        <div className="placeholder-box medium" />
                        <div className="placeholder-box small" />
                        <div className="placeholder-box large" />
                    </div>
                </div>
            </main>
        </div>
    );
};

export default Dashboard;
