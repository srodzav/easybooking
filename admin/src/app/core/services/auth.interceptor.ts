import { HttpInterceptorFn } from '@angular/common/http';
import { inject } from '@angular/core';
import { Router } from '@angular/router';
import { catchError, throwError } from 'rxjs';
import { AuthService } from './auth.service';

export const authInterceptor: HttpInterceptorFn = (req, next) => {
  const authService = inject(AuthService);
  const router = inject(Router);
  
  // Obtener token
  const token = authService.getToken();
  
  // Clonar request y agregar token si existe
  let authReq = req;
  if (token) {
    authReq = req.clone({
      setHeaders: {
        Authorization: `Bearer ${token}`
      }
    });
  }

  // Manejar errores de autenticación
  return next(authReq).pipe(
    catchError((error) => {
      if (error.status === 401) {
        // Token expirado o inválido
        console.log('invalid token, redirect to login');
        // Limpiar directamente sin hacer logout al servidor
        authService.clearAuthData();
        router.navigate(['/login']);
      }
      return throwError(() => error);
    })
  );
};