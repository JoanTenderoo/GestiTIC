import React, { useState } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import {
  TextField,
  Button,
  Typography,
  Alert,
  InputAdornment,
  IconButton,
  FormControl,
  InputLabel,
  Select,
  MenuItem
} from '@mui/material';
import {
  Visibility,
  VisibilityOff,
  Person,
  Email,
  Lock
} from '@mui/icons-material';
import authService from '../services/authService';
import logo from '../assets/logo.webp';
import '../styles/RegisterPage.css';

const RegisterPage = () => {
  const navigate = useNavigate();
  const [formData, setFormData] = useState({
    nombre: '',
    apellidos: '',
    email: '',
    password: '',
    password_confirmation: '',
    rol: 'usuario'
  });
  const [showPassword, setShowPassword] = useState(false);
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');
    setLoading(true);

    if (formData.password !== formData.password_confirmation) {
      setError('Las contraseñas no coinciden');
      setLoading(false);
      return;
    }

    try {
      await authService.register(formData);
      navigate('/login');
    } catch (err) {
      setError(err.message || 'Error al registrar usuario');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="register-wrapper">
      <div className="register-left-panel">
        <img src={logo} alt="Logo" className="register-logo-image" />
      </div>

      <div className="register-right-panel">
        <div className="register-form-container">
          <Typography variant="h4" className="register-title">
            Crear Cuenta
          </Typography>

          {error && (
            <Alert severity="error" className="register-error">
              {error}
            </Alert>
          )}

          <form onSubmit={handleSubmit} className="register-form">
            <TextField
              label="Nombre"
              name="nombre"
              value={formData.nombre}
              onChange={handleChange}
              required
              className="register-input"
              fullWidth
              InputProps={{
                startAdornment: (
                  <InputAdornment position="start">
                    <Person className="input-icon" />
                  </InputAdornment>
                ),
              }}
            />

            <TextField
              label="Apellidos"
              name="apellidos"
              value={formData.apellidos}
              onChange={handleChange}
              required
              className="register-input"
              fullWidth
              InputProps={{
                startAdornment: (
                  <InputAdornment position="start">
                    <Person className="input-icon" />
                  </InputAdornment>
                ),
              }}
            />

            <TextField
              label="Email"
              name="email"
              type="email"
              value={formData.email}
              onChange={handleChange}
              required
              className="register-input"
              fullWidth
              InputProps={{
                startAdornment: (
                  <InputAdornment position="start">
                    <Email className="input-icon" />
                  </InputAdornment>
                ),
              }}
            />

            <TextField
              label="Contraseña"
              name="password"
              type={showPassword ? 'text' : 'password'}
              value={formData.password}
              onChange={handleChange}
              required
              className="register-input"
              fullWidth
              InputProps={{
                startAdornment: (
                  <InputAdornment position="start">
                    <Lock className="input-icon" />
                  </InputAdornment>
                ),
                endAdornment: (
                  <InputAdornment position="end">
                    <IconButton
                      onClick={() => setShowPassword(!showPassword)}
                      className="password-toggle"
                    >
                      {showPassword ? <VisibilityOff /> : <Visibility />}
                    </IconButton>
                  </InputAdornment>
                ),
              }}
            />

            <TextField
              label="Confirmar Contraseña"
              name="password_confirmation"
              type={showPassword ? 'text' : 'password'}
              value={formData.password_confirmation}
              onChange={handleChange}
              required
              className="register-input"
              fullWidth
              InputProps={{
                startAdornment: (
                  <InputAdornment position="start">
                    <Lock className="input-icon" />
                  </InputAdornment>
                ),
              }}
            />

            <FormControl fullWidth className="register-select">
              <InputLabel id="rol-label">Rol</InputLabel>
              <Select
                labelId="rol-label"
                name="rol"
                value={formData.rol}
                label="Rol"
                onChange={handleChange}
              >
                <MenuItem value="usuario">Usuario</MenuItem>
                <MenuItem value="tecnico">Técnico</MenuItem>
                <MenuItem value="admin">Administrador</MenuItem>
              </Select>
            </FormControl>

            <Button
              type="submit"
              fullWidth
              variant="contained"
              className="register-button"
              disabled={loading}
            >
              {loading ? 'Registrando...' : 'REGISTRARSE'}
            </Button>

            <div className="register-login-link">
              <Typography variant="body2">
                ¿Ya tienes una cuenta?{' '}
                <Link to="/login" className="login-link">
                  Iniciar sesión
                </Link>
              </Typography>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
};

export default RegisterPage;

