import React, { useState, useEffect } from 'react';
import axios from 'axios';
import '../styles/IncidenciasTable.css';

const IncidenciasTable = () => {
    const [incidencias, setIncidencias] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState('');

    useEffect(() => {
        const fetchIncidencias = async () => {
            try {
                const response = await axios.get('http://localhost:8000/api/incidencias');
                setIncidencias(response.data);
                setLoading(false);
            } catch (err) {
                setError('Error al cargar las incidencias');
                setLoading(false);
            }
        };

        fetchIncidencias();
    }, []);

    if (loading) return <div className="incidencias-loading">Cargando...</div>;
    if (error) return <div className="incidencias-error">{error}</div>;

    return (
        <div className="incidencias-container">
            <h2 className="incidencias-title">Incidencias Registradas</h2>
            <div className="incidencias-table-wrapper">
                <table className="incidencias-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Equipo</th>
                            <th>Ubicación</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        {incidencias.map((incidencia) => (
                            <tr key={incidencia.id}>
                                <td>{incidencia.id}</td>
                                <td>{incidencia.equipo}</td>
                                <td>{incidencia.ubicacion}</td>
                                <td>{incidencia.descripcion}</td>
                                <td>
                                    <span className={`estado-badge ${incidencia.estado.toLowerCase()}`}>
                                        {incidencia.estado}
                                    </span>
                                </td>
                                <td>{new Date(incidencia.created_at).toLocaleDateString()}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </div>
    );
};

export default IncidenciasTable;
