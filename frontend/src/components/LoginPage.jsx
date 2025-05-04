import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import '../styles/LoginPage.css';
import {
  Container,
  Paper,
  TextField,
  Button,
  Typography,
  Box,
  Alert,
  InputAdornment,
  IconButton,
  Divider,
  Link,
  CircularProgress
} from '@mui/material';
import {
  Email as EmailIcon,
  Lock as LockIcon,
  Visibility,
  VisibilityOff,
  Instagram,
  Twitter
} from '@mui/icons-material';
import authService from '../services/authService';
import logoImage from '../assets/logo.webp';

const LoginPage = () => {
  const navigate = useNavigate();
  const [formData, setFormData] = useState({
    email: '',
    password: '',
    showPassword: false
  });
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value
    });
  };

  const handleToggle = (name) => () => {
    setFormData({
      ...formData,
      [name]: !formData[name]
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');
    setLoading(true);

    try {
      await authService.login(formData.email, formData.password);
      navigate('/dashboard');
    } catch (err) {
      setError(err.message || 'Error al iniciar sesión. Verifica tus credenciales.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="login-wrapper">
      <div className="login-side-panel">
        <img src={logoImage} alt="Company Logo" className="login-side-image" />
      </div>
      
      <Container component="main" className="login-container">
        <div elevation={6} className="login-paper">
          <Typography component="h1" variant="h5" className="login-title">
            Iniciar Sesión
          </Typography>
          
          {error && (
            <Alert severity="error" className="error-alert">
              {error}
            </Alert>
          )}
          
          <Box component="form" onSubmit={handleSubmit} className="login-form">
            <TextField
              margin="normal"
              required
              fullWidth
              id="email"
              label="Correo electrónico"
              name="email"
              autoComplete="email"
              autoFocus
              value={formData.email}
              onChange={handleChange}
              InputProps={{
                startAdornment: (
                  <InputAdornment position="start">
                    <EmailIcon className="input-icon" />
                  </InputAdornment>
                ),
              }}
              className="login-input"
            />
            
            <TextField
              margin="normal"
              required
              fullWidth
              name="password"
              label="Contraseña"
              type={formData.showPassword ? 'text' : 'password'}
              id="password"
              autoComplete="current-password"
              value={formData.password}
              onChange={handleChange}
              InputProps={{
                startAdornment: (
                  <InputAdornment position="start">
                    <LockIcon className="input-icon" />
                  </InputAdornment>
                ),
                endAdornment: (
                  <InputAdornment position="end">
                    <IconButton
                      aria-label="toggle password visibility"
                      onClick={handleToggle('showPassword')}
                      edge="end"
                      className="password-toggle"
                    >
                      {formData.showPassword ? <VisibilityOff /> : <Visibility />}
                    </IconButton>
                  </InputAdornment>
                ),
              }}
              className="login-input"
            />
            
            <Box className="login-options">              
              <Link href="#" className="forgot-password">
                ¿Olvidaste tu contraseña?
              </Link>
            </Box>
            
            <Button
              type="submit"
              fullWidth
              variant="contained"
              disabled={loading}
              className="login-button"
            >
              {loading ? (
                <CircularProgress size={24} className="login-spinner" />
              ) : (
                'Iniciar Sesión'
              )}
            </Button>
            
            <Divider className="login-divider">O</Divider>
            
            <Box className="social-login">
              <IconButton className="social-button instagram-button">
                <Instagram className="instagram-icon" />
              </IconButton>
              <IconButton className="social-button twitter-button">
                <Twitter className="twitter-icon" />
              </IconButton>
            </Box>
            
            <Typography className="register-link">
              ¿No tienes una cuenta?{' '}
              <Link href="/register" className="register-text">
                Regístrate
              </Link>
            </Typography>
          </Box>
        </div>
      </Container>
    </div>
  );
};

export default LoginPage;