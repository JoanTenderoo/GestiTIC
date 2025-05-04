import React from 'react';
import Header from '../components/Header';
import IncidenciasTable from '../components/IncidenciasTable';
import '../styles/Dashboard.css';

const Dashboard = () => {
    return (
        <div className="dashboard">
            <Header />
            <main className="dashboard-main">
                <IncidenciasTable />
            </main>
        </div>
    );
};

export default Dashboard; 